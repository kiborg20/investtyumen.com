<?php

use Bitrix\Main\Application;

$app = Application::getInstance();
if (empty($app->iblocklocator)) {
    $app->iblocklocator = new \Creative\Foundation\Iblocklocator();
    $app->iblocklocator->setCache(new \Creative\Foundation\Cache());
}
