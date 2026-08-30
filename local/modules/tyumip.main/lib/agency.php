<?php

namespace Tyumip\Main;

use CEventLog;
use Exception;

/**
 * Класс, который содержит в себе функции агентов модуля.
 */
class Agency
{
    /**
     * Загрузчик агентов модуля. Ищет соответствующего агента и запускает его.
     *
     * @param string $name
     *
     * @return string|null
     */
    public static function runner($name)
    {
        $return = "\Tyumip\Main\Agency::runner('{$name}');";

        try {
            if (method_exists(self::class, $name)) {
                self::$name();
            } else {
                throw new Exception("Wrong agent name: {$name}");
            }
        } catch (\Throwable $e) {
            CEventLog::Add([
                'SEVERITY' => 'ERROR',
                'AUDIT_TYPE_ID' => 'tyumip_main_agent_error',
                'MODULE_ID' => 'tyumip.main',
                'ITEM_ID' => "\\Tyumip\\Main\\Agency::{$name}()",
                'DESCRIPTION' => $e->getMessage(),
            ]);
        }

        return $return;
    }

}
