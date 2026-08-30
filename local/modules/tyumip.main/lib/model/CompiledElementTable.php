<?php

namespace Tyumip\Main\Model;

use Bitrix\Iblock\Iblock;

class CompiledElementTable
{
    private static $_instance = null;

    private function __construct()
    {
    }

    protected function __clone()
    {
        return false;
    }

    static public function getInstance(int $iBlockId): ?object
    {
        if (is_null(self::$_instance[$iBlockId])) {
            $oEntity = Iblock::wakeUp($iBlockId)->getEntityDataClass();
            if ($oEntity == null) {
                return self::$_instance[$iBlockId] = null;
            }
            self::$_instance[$iBlockId] = new $oEntity();
        }
        return self::$_instance[$iBlockId];
    }
}