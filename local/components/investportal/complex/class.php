<?php
declare(strict_types=1);

use Bitrix\Iblock\Component\Tools;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Page\Asset;
use Tyumip\Main\Helper\Helper;

class Complex extends \CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        return parent::onPrepareComponentParams($params);
    }

    public function getItemsOfPage(string $sPageType): void
    {
        if ($sPageType == 'detail') {
            $aItem = ElementTable::getList(
                [
                    'select' => [
                        '*', 'IBLOCK_CODE' => 'IBLOCK.CODE'
                    ],
                    'filter' => [
                        '=IBLOCK.IBLOCK_TYPE_ID' => $this->arParams['IBLOCK_TYPE'],
                        '=CODE' => $this->arParams['ELEMENT_CODE']
                    ]
                ]
            )->fetch();
            if (!$aItem) {
                Tools::process404(
                    '',
                    true,
                    true,
                    true,
                    '/404.php'
                );
            }

            $aItem += Helper::getIBlockProperties($aItem['ID']);
            $this->arResult['ITEM'] = $aItem;
        }
    }

    protected function getAction(): array
    {
        return \Bitrix\Main\Context::getCurrent()->getRequest()->getValues();
    }

    protected function getTemplatePath(): string
    {
        if ($this->arParams['PAGE_TYPE'] == 'detail') {
            $sTemplate = 'template';

            if (isset($this->arResult['ITEM']['detailtemplate'])) {
                $sTemplate = $this->arResult['ITEM']['detailtemplate']['PROPERTY_VALUE'];
            }
            if (isset($this->arParams['DETAIL_TEMPLATE'])) {
                $sTemplate = $this->arParams['DETAIL_TEMPLATE'];
            }

            return $this->arParams['PAGE_TYPE'] . '/' . $sTemplate;
        }

        return $this->arParams['PAGE_TYPE'] . '/' . $this->arParams['CODE'];
    }

    protected function ajaxInit()
    {
        ?>
            <script>
                if ('<?=$this->arParams['USE_FILTER']?>' === 'Y') {
                    var PAGE = 1;
                    function getDataByFilters(filters = {}) {
                        BX.ajax.runComponentAction('investportal:main.block', 'getByFilter', {
                            mode: 'class',
                            data: {
                                aRequest: {
                                    IBLOCK: '<?=$this->arParams['IBLOCK_LIST']?>',
                                    TYPE: '<?=$this->arParams['IBLOCK_TYPE']?>',
                                    TEMPLATE: '<?=$this->arParams['TEMPLATE']?>',
                                    LIMIT: '<?=$this->arParams['NEWS_COUNT']?>',
                                    PAGE: PAGE,
                                    FILTERS: filters
                                }
                            }
                        }).then(answer);
                    }
                }

                function answer(response) {
                    document.getElementById('list').innerHTML = response.data.response.data;
                }
            </script>
        <?php
    }

    public function executeComponent()
    {
        if (!isset($this->arParams['PAGE_TYPE'])) {
            throw new Exception('Заполните тип страницы');
        }

        $this->getItemsOfPage($this->arParams['PAGE_TYPE']);
        $this->arParams['FILTERS'] = $this->getAction();
        $sTemplateUrl = $this->getTemplatePath();
        $this->ajaxInit();
        $this->includeComponentTemplate($sTemplateUrl);
    }
}
