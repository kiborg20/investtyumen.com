<?php

declare(strict_types=1);

class SearchBlock extends CBitrixComponent
{

    public function executeComponent()
    {
        $aRequest = \Bitrix\Main\Context::getCurrent()->getRequest()->getValues();
        $this->arResult['REQUEST']['QUERY'] = $aRequest['q'];

        if (isset($aRequest['q'])) {
            $oSearchService = \Tyumip\Main\Service\SearchService::getInstance();
            $this->arResult['ITEMS'] = $oSearchService->get(mb_strtolower($aRequest['q']));
        }

        $this->includeComponentTemplate();
    }
}