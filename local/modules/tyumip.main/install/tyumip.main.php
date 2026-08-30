<?php

use Bitrix\Main\Loader;

if (!Loader::includeModule('tyumip.main')) {
    throw new LogicException('Main module not found');
}