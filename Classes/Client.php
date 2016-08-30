<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaClientApi\Classes;

use Symfony\Component\HttpFoundation\Response;
use TheliaClientApi\Model\ApiConfigQuery;

class Client
{
    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $baseApiRoute;

    public function __construct()
    {
    }

    /**
     * @param string $apiToken
     * @param string $apiKey
     * @param string $baseUrl
     * @param string $baseApiRoute
     * @return mixed
     */
    public function init($apiToken = '', $apiKey = '', $baseUrl = '', $baseApiRoute = '/api/')
    {
        if ($apiToken === '' || $apiKey === '' || $baseUrl === '') {
            $config = ApiConfigQuery::create()->findOne();
            if ($config) {
                $this->apiToken = $config->getApiToken();
                $this->apiKey = $config->getApiKey();
                $this->baseUrl = $config->getApiUrl();
                $this->baseApiRoute = $baseApiRoute;
                return true;
            } else {
                return false;
            }
        } else {
            $this->apiToken = $apiToken;
            $this->apiKey = $apiKey;
            $this->baseUrl = $baseUrl;
            $this->baseApiRoute = $baseApiRoute;
            return true;
        }
    }

    /**
     * @param $name
     * @param array $loopArgs
     * @return mixed|string|Response
     */
    public function doList($name, array $loopArgs = array())
    {
        return $this->call(
            "GET",
            $this->baseApiRoute . $name,
            $loopArgs
        );
    }

    /**
     * @param $name
     * @param $id
     * @param array $loopArgs
     * @return mixed|string|Response
     */
    public function doGet($name, $id, array $loopArgs = array())
    {
        return $this->call(
            "GET",
            $this->baseApiRoute . $name . '/' . $id,
            $loopArgs
        );
    }

    /**
     * @param $name
     * @param $body
     * @param array $loopArgs
     * @return mixed|string|Response
     */
    public function doPost($name, $body, array $loopArgs = array())
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }

        return $this->call(
            "POST",
            $this->baseApiRoute . $name,
            $loopArgs,
            $body,
            "application/json"
        );
    }

    /**
     * @param $name
     * @param $body
     * @param null $id
     * @param array $loopArgs
     * @return mixed|string|Response
     */
    public function doPut($name, $body, $id = null, array $loopArgs = array())
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }

        if (null !== $id && '' !== $id) {
            $id = '/' . $id;
        }

        return $this->call(
            "PUT",
            $this->baseApiRoute . $name . $id,
            $loopArgs,
            $body,
            "application/json"
        );
    }

    /**
     * @param $name
     * @param $id
     * @param array $loopArgs
     * @return mixed|string|Response
     */
    public function doDelete($name, $id, array $loopArgs = array())
    {
        return $this->call(
            "DELETE",
            $this->baseApiRoute . $name . '/' . $id,
            $loopArgs
        );
    }

    /**
     * @param $method
     * @param $pathInfo
     * @param array $queryParameters
     * @param string $body
     * @param string $contentType
     * @return Response|mixed|string
     */
    public function call(
        $method,
        $pathInfo,
        array $queryParameters = array(),
        $body = '',
        $contentType = 'application/x-www-form-urlencoded'
    ) {
        $headers["Authorization"] = "TOKEN " . $this->apiToken;

        $secureKey = pack('H*', $this->apiKey);
        $queryParameters["sign"] = hash_hmac('sha1', $body, $secureKey);

        $data = http_build_query($queryParameters);

        $fullUrl = $this->baseUrl . $pathInfo . '?' . $data;

        $curlHeaders = [
            "Content-type: " . $contentType,
            "Authorization: " . $headers["Authorization"],
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $fullUrl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);

        $res = curl_exec($curl);

        $info = curl_getinfo($curl);
        $http_code = $info['http_code'];

        if (curl_errno($curl)) {
            $res = curl_error($curl);
        } else {
            switch ($info['content_type']) {
                case "application/json":
                    $res = json_decode($res, true);
                    break;
            }
        }

        curl_close($curl);
        return [$http_code, $res];
    }

    public function parseHeaders($headers)
    {
        $head = array();
        foreach ($headers as $k => $v) {
            $t = explode(':', $v, 2);
            if (isset($t[1])) {
                $head[trim($t[0])] = trim($t[1]);
            } else {
                $head[] = $v;
                if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $v, $out)) {
                    $head['reponse_code'] = intval($out[1]);
                }
            }
        }
        return $head;
    }
}
