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

namespace TheliaClientApi\Controller\Admin;

use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Tools\URL;
use TheliaClientApi\Form\TheliaClientApiConfigForm;
use TheliaClientApi\Model\ApiConfig;
use TheliaClientApi\Model\ApiConfigQuery;
use TheliaClientApi\Model\Map\ApiConfigTableMap;

class ConfigController extends BaseAdminController
{

    public function getConfigAction()
    {
        return $this->render("module-configure", ['module_code' => 'TheliaClientApi']);
    }

    public function updateConfigAction()
    {
        $con = Propel::getWriteConnection(ApiConfigTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $request = $this->getRequest();

            $myForm = new TheliaClientApiConfigForm($request);

            $form = $this->validateForm($myForm);
            $myData = $form->getData();

            if (isset($myData['id']) && $myData['id'] > 0) {
                $myObject = ApiConfigQuery::create()->findPk($myData['id']);
                $myObject->setApiToken($myData['api_token'])
                    ->setApiKey($myData['api_key'])
                    ->setApiUrl($myData['api_url'])
                    ->save($con);
            } else {
                $myObject = new ApiConfig();
                $myObject->setApiToken($myData['api_token'])
                    ->setApiKey($myData['api_key'])
                    ->setApiUrl($myData['api_url'])
                    ->save($con);
            }
            $con->commit();
            return RedirectResponse::create(URL::getInstance()->absoluteUrl('/admin/module/TheliaClientApi'));
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
    }
}
