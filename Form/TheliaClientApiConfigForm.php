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

namespace TheliaClientApi\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use TheliaClientApi\Model\ApiConfigQuery;
use TheliaClientApi\Model\Map\ApiConfigTableMap;
use TheliaClientApi\TheliaClientApi;

class TheliaClientApiConfigForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add("api_token", "text", array(
                "constraints" => array(
                    new NotBlank()
                ),
                "label" => Translator::getInstance()->trans('api_token', [], TheliaClientApi::BO_DOMAIN_NAME),
                "label_attr" => array(
                    "for" => "api_token"
                ),
                'attr' => [
                    'placeholder' => Translator::getInstance()->trans('api_token', [], TheliaClientApi::BO_DOMAIN_NAME),
                ]
            ))
            ->add("api_key", "text", array(
                "constraints" => array(
                    new NotBlank()
                ),
                "label" => Translator::getInstance()->trans('api_key', [], TheliaClientApi::BO_DOMAIN_NAME),
                "label_attr" => array(
                    "for" => "api_key"
                ),
                'attr' => [
                    'placeholder' => Translator::getInstance()->trans('api_key', [], TheliaClientApi::BO_DOMAIN_NAME),
                ]
            ))
            ->add("api_url", "text", array(
                "constraints" => array(
                    new NotBlank()
                ),
                "label" => Translator::getInstance()->trans('api_url', [], TheliaClientApi::BO_DOMAIN_NAME),
                "label_attr" => array(
                    "for" => "api_url"
                ),
                'attr' => [
                    'placeholder' => Translator::getInstance()->trans('api_url', [], TheliaClientApi::BO_DOMAIN_NAME),
                ]
            ));

        $myObject = ApiConfigQuery::create()->findOne();
        if ($myObject) {
            $arrayData = $myObject->toArray(ApiConfigTableMap::TYPE_FIELDNAME);

            $this->formBuilder
                ->add("id", "hidden", array(
                    "constraints" => array(
                        new NotBlank()
                    )
                ))
                ->setData($arrayData);
        }

    }

    public function getName()
    {
        return "thelia_api_config";
    }
}