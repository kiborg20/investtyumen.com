<?php

namespace Sprint\Migration;


use CModule;

class Version20230713134430 extends Version
{
    protected $description = "Установка модуля tyumip.main";

    protected $moduleVersion = "4.3.1";

    public function up()
    {

        if($module = CModule::CreateModuleObject('tyumip.main'))
        {
            $module->DoInstall();
        }
    }

    public function down()
    {
        if($module = CModule::CreateModuleObject('tyumip.main'))
        {
            $module->DoUninstall();
        }
    }
}
