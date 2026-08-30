<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\IO\Directory;

Loc::loadMessages(__FILE__);

class tyumip_main extends CModule
{
    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'tyumip.main';
        $this->MODULE_NAME = Loc::getMessage('TYUMIP_MAIN_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('TYUMIP_MAIN_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('TYUMIP_MAIN_MODULE_PARTNER_NAME');
    }

    /**
     * @inheritdoc
     */
    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installFiles();
        $this->installDb();
    }

    /**
     * @inheritdoc
     */
    public function doUninstall()
    {
        $this->unInstallFiles();
        $this->unInstallDb();
        ModuleManager::unregisterModule($this->MODULE_ID);
    }

    /**
     * Устанавливает данные модуля в базу данных сайта.
     *
     * Устанавливает агента, который будет обрабатывать загрузку.
     */
    public function installDb()
    {
        $eventManager = EventManager::getInstance();
        foreach ($this->getEventsList() as $event) {
            $eventManager->registerEventHandlerCompatible(
                $event['FROM_MODULE_ID'],
                $event['EVENT_TYPE'],
                $this->MODULE_ID,
                $event['TO_CLASS'],
                $event['TO_METHOD'],
                $event['SORT']
            );
        }
    }

    /**
     * Удаляет данные модуля из базы данных сайта.
     *
     * Удаляет агента, который будет обрабатывать загрузку.
     */
    public function unInstallDb()
    {
        $eventManager = EventManager::getInstance();
        foreach ($this->getEventsList() as $event) {
            $eventManager->unRegisterEventHandler(
                $event['FROM_MODULE_ID'],
                $event['EVENT_TYPE'],
                $this->MODULE_ID,
                $event['TO_CLASS'],
                $event['TO_METHOD']
            );
        }

        CAgent::RemoveModuleAgents($this->MODULE_ID);

        Option::delete($this->MODULE_ID);
    }

    /**
     * Возвращает список событий, которые должны быть установлены для данного модуля.
     *
     * @return array
     */
    protected function getEventsList()
    {
        return [];
    }

    public function installFiles()
    {
        $loadModules = $this->getInstallatorPath() . '/tyumip.main.php';
        $to = Application::getDocumentRoot() . '/local/php_interface/include/includeModules/' . 'tyumip.main.php';
        if (!copy( $loadModules, $to)) {
            return false;
        }

        return true;
    }

    /**
     * Удаляет файлы модуля из битрикса.
     *
     * @retrun bool
     */
    public function unInstallFiles()
    {
        $loadModuleFile = Application::getDocumentRoot() . '/local/php_interface/include/includeModules/' . 'tyumip.main.php';
        if (!\Bitrix\Main\IO\File::deleteFile($loadModuleFile)) {
            return false;
        }

        return true;
    }


    /**
     * Возвращает путь к папке с модулем
     *
     * @return string
     */
    protected function getInstallatorPath()
    {
        return __DIR__;
    }
}
