<?php

namespace TheliaClientApi\Model\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use TheliaClientApi\Model\ApiConfig as ChildApiConfig;
use TheliaClientApi\Model\ApiConfigQuery as ChildApiConfigQuery;
use TheliaClientApi\Model\Map\ApiConfigTableMap;

/**
 * Base class that represents a query for the 'api_config' table.
 *
 * 
 *
 * @method     ChildApiConfigQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildApiConfigQuery orderByApiToken($order = Criteria::ASC) Order by the api_token column
 * @method     ChildApiConfigQuery orderByApiKey($order = Criteria::ASC) Order by the api_key column
 * @method     ChildApiConfigQuery orderByApiUrl($order = Criteria::ASC) Order by the api_url column
 *
 * @method     ChildApiConfigQuery groupById() Group by the id column
 * @method     ChildApiConfigQuery groupByApiToken() Group by the api_token column
 * @method     ChildApiConfigQuery groupByApiKey() Group by the api_key column
 * @method     ChildApiConfigQuery groupByApiUrl() Group by the api_url column
 *
 * @method     ChildApiConfigQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildApiConfigQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildApiConfigQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildApiConfig findOne(ConnectionInterface $con = null) Return the first ChildApiConfig matching the query
 * @method     ChildApiConfig findOneOrCreate(ConnectionInterface $con = null) Return the first ChildApiConfig matching the query, or a new ChildApiConfig object populated from the query conditions when no match is found
 *
 * @method     ChildApiConfig findOneById(int $id) Return the first ChildApiConfig filtered by the id column
 * @method     ChildApiConfig findOneByApiToken(string $api_token) Return the first ChildApiConfig filtered by the api_token column
 * @method     ChildApiConfig findOneByApiKey(string $api_key) Return the first ChildApiConfig filtered by the api_key column
 * @method     ChildApiConfig findOneByApiUrl(string $api_url) Return the first ChildApiConfig filtered by the api_url column
 *
 * @method     array findById(int $id) Return ChildApiConfig objects filtered by the id column
 * @method     array findByApiToken(string $api_token) Return ChildApiConfig objects filtered by the api_token column
 * @method     array findByApiKey(string $api_key) Return ChildApiConfig objects filtered by the api_key column
 * @method     array findByApiUrl(string $api_url) Return ChildApiConfig objects filtered by the api_url column
 *
 */
abstract class ApiConfigQuery extends ModelCriteria
{
    
    /**
     * Initializes internal state of \TheliaClientApi\Model\Base\ApiConfigQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\TheliaClientApi\\Model\\ApiConfig', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildApiConfigQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildApiConfigQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \TheliaClientApi\Model\ApiConfigQuery) {
            return $criteria;
        }
        $query = new \TheliaClientApi\Model\ApiConfigQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildApiConfig|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ApiConfigTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ApiConfigTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildApiConfig A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, API_TOKEN, API_KEY, API_URL FROM api_config WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildApiConfig();
            $obj->hydrate($row);
            ApiConfigTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildApiConfig|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ApiConfigTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ApiConfigTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ApiConfigTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ApiConfigTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApiConfigTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the api_token column
     *
     * Example usage:
     * <code>
     * $query->filterByApiToken('fooValue');   // WHERE api_token = 'fooValue'
     * $query->filterByApiToken('%fooValue%'); // WHERE api_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterByApiToken($apiToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiToken)) {
                $apiToken = str_replace('*', '%', $apiToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ApiConfigTableMap::API_TOKEN, $apiToken, $comparison);
    }

    /**
     * Filter the query on the api_key column
     *
     * Example usage:
     * <code>
     * $query->filterByApiKey('fooValue');   // WHERE api_key = 'fooValue'
     * $query->filterByApiKey('%fooValue%'); // WHERE api_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterByApiKey($apiKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiKey)) {
                $apiKey = str_replace('*', '%', $apiKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ApiConfigTableMap::API_KEY, $apiKey, $comparison);
    }

    /**
     * Filter the query on the api_url column
     *
     * Example usage:
     * <code>
     * $query->filterByApiUrl('fooValue');   // WHERE api_url = 'fooValue'
     * $query->filterByApiUrl('%fooValue%'); // WHERE api_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apiUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function filterByApiUrl($apiUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apiUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $apiUrl)) {
                $apiUrl = str_replace('*', '%', $apiUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ApiConfigTableMap::API_URL, $apiUrl, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildApiConfig $apiConfig Object to remove from the list of results
     *
     * @return ChildApiConfigQuery The current query, for fluid interface
     */
    public function prune($apiConfig = null)
    {
        if ($apiConfig) {
            $this->addUsingAlias(ApiConfigTableMap::ID, $apiConfig->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the api_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApiConfigTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ApiConfigTableMap::clearInstancePool();
            ApiConfigTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildApiConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildApiConfig object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApiConfigTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ApiConfigTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            

        ApiConfigTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ApiConfigTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ApiConfigQuery
