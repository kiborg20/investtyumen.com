<?php

namespace Sprint\Migration;


use CModule;

class creativeModule20230717084356 extends Version
{
    protected $description = "Установка модуля \"creative.foundation\"";

    protected $moduleVersion = "4.3.1";

    public function up()
    {
        if ($module = CModule::CreateModuleObject('creative.foundation')) {
            $module->DoInstall();
        }
    }

    public function down()
    {
        if ($module = CModule::CreateModuleObject('creative.foundation')) {
            $module->DoUninstall();
        }
    }
}
