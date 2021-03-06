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

namespace TheliaClientApi\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class TheliaClientApiHook extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $module_id = self::getModule()->getModuleId();

        $event->add($this->render("module_configuration.html", ['module_id' => $module_id]));
    }
}
