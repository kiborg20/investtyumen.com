<?php

namespace Tyumip\Main\Helper;

use Bitrix\Iblock\Component\Tools;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use CFile;
use Tyumip\Main\Model\IconDirectoryTable;

class Helper
{
    /**
     * Метод получает иконку в формате svg, по xmlId
     * @param string $xmlId
     *
     * @return string|null
     *
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getIconsParams(string $xmlId): ?string
    {
        $prop = IconDirectoryTable::getList([
            'select' => ['*'],
            'filter' => ['=external' => $xmlId]
        ])->fetch();

        if (!$prop) {
            return null;
        }

        if ($prop['icon_file']) {
            $prop['icon_svg'] = file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($prop['icon_file']));
        }

        if (!is_string($prop['icon_svg'])) {
            return null;
        }

        return $prop['icon_svg'];
    }

    /**
     * Метод получает все значения (Enum) свойства. Тип: Список
     * @param $sIBlock
     * @param $sCode
     *
     * @return array|null
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getListOfValuesFilter($sIBlock, $sCode): ?array
    {
        $aProperty = PropertyTable::getList(
            [
                'select' => ['ID'],
                'filter' => ['IBLOCK.CODE' => $sIBlock, 'CODE' => $sCode]
            ]
        )->fetch();
        if (!$aProperty) {
            return null;
        }

        $aEnumsFilter = PropertyEnumerationTable::getList(
            [
                'filter' => ['PROPERTY_ID' => $aProperty['ID']]
            ]
        )->fetchAll();

        return array_column($aEnumsFilter, 'ID', 'VALUE');
    }

    /**
     * Получает секцию по коду и id инфоблока
     * Важно:: получает первую найденную секцию по коду. Могут быть коллизии
     * @param string $sSectionCode
     * @param int $iBlockId
     * @return array|bool
     *
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getSection(string $sSectionCode, int $iBlockId): ?array
    {
        $oEntity = Section::compileEntityByIblock($iBlockId);
        $oResult = $oEntity::getList(
            [
                'select' => [
                    'UF_HEADER_NAME',
                    '*'
                ],
                'filter' => [
                    '=CODE'=> $sSectionCode,
                    '=IBLOCK_ID' => $iBlockId
                ]
            ]
        )->fetch();

        if (!$oResult) {
            return null;
        }

        return $oResult;
    }

    protected static function getSectionById(string $sSectionId): array
    {
        return SectionTable::getList(
            [
                'filter' => ['=ID' => $sSectionId]
            ]
        )->fetch();
    }

    /**
     * Метод возвращает массив элементов в секции по id | d7
     * @param int $iSectionId
     *
     * @return array|bool
     *
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getElementsInSection(string $sSectionId, int $iBlockId = 0): array
    {
        return ElementTable::getList(
            [
                'select' => [
                    '*'
                ],
                'filter' => [
                    '=IBLOCK_SECTION_ID' => $sSectionId
                ],
                'order' => [
                    'SORT' => 'ASC'
                ]
            ]
        )->fetchAll();
    }

    /**
     * Метод получает массив секций из подразделов основной секции странцы
     *
     * @return array
     */
    public static function getSections(array $aSection, bool $bIncludeCurrentSection = true): array
    {
        $aSections = SectionTable::getList(
            [
                'filter' => [
                    '>=LEFT_MARGIN' => $aSection['LEFT_MARGIN'],
                    '<=RIGHT_MARGIN' => $aSection['RIGHT_MARGIN'],
                    '=IBLOCK_ID' => $aSection['IBLOCK_ID'],
                ] + ($bIncludeCurrentSection ? [] : ['!=CODE' => $aSection['CODE']]),
                'order' => [
                    'DEPTH_LEVEL' => 'ASC'
                ]
            ]
        )->fetchAll();

        return $aSections;
    }

    /**
     * Метод возвращает элемент по id
     *
     * @return array|null
     */
    public static function getElementById(string $sId): ?array
    {
        return ElementTable::getList(
            [
                'filter' => ['ID' => $sId]
            ]
        )->fetch();
    }

    public static function getElementsByIBlockCode(string $sIblockCode): ?array
    {
        return ElementTable::getList(
            [
                'filter' => ['=IBLOCK.CODE' => $sIblockCode]
            ]
        )->fetchAll();
    }

    /**
     * Метод получает массив свойств, по id иб/элемента
     * @param string $iElementId
     *
     * @return array
     *
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function getIBlockProperties(string $iElementId): array
    {
        $aResult = [];
        $oPropertyResult = PropertyTable::getList(
            [
                'select' => [
                    'PROPERTY_NAME' => 'CODE',
                    'PROPERTY_TYPE',
                    'PROPERTY_ENUM_VALUE' => 'PROPERTY_ELEMENT.ENUM.VALUE',
                    'PROPERTY_VALUE' => 'PROPERTY_ELEMENT.VALUE',
                    'PROPERTY_DESCRIPTION' => 'PROPERTY_ELEMENT.DESCRIPTION',
                    'MULTIPLE',
                    'USER_TYPE'
                ],
                'filter' => ['PROPERTY_ELEMENT.IBLOCK_ELEMENT_ID' => (int)$iElementId],
                'runtime' => [
                    'PROPERTY_ELEMENT' =>
                        [
                            'data_type' => '\Bitrix\Iblock\ElementPropertyTable',
                            'reference' => ['this.ID' => 'ref.IBLOCK_PROPERTY_ID']
                        ]
                ]
            ]
        );

        while ($aProperty = $oPropertyResult->fetch())
        {
            if ($aProperty['USER_TYPE'] == 'directory') {
                $aProperty['PROPERTY_VALUE'] = Helper::getIconsParams($aProperty['PROPERTY_VALUE']);
            } else if ($aProperty['PROPERTY_TYPE'] == PropertyTable::TYPE_ELEMENT) {
                $aProperty['PROPERTY_VALUE'] = self::getElementById($aProperty['PROPERTY_VALUE']);
            }

            if ($aProperty['MULTIPLE'] == 'Y') {
                $aResult[$aProperty['PROPERTY_NAME']][] = $aProperty;
                continue;
            }

            $aResult[$aProperty['PROPERTY_NAME']] = $aProperty;
        }

        return $aResult;

    }

    public static function getIblockId($iBlockCode): int
    {
        return (int) IblockTable::getRow([
            'filter' => [
                '=CODE' => $iBlockCode
            ],
            'select' => ['ID'],
        ])['ID'];
    }

    public static function show404($page = '/404.php')
    {
        Tools::process404(
            '',
            true,
            true,
            true,
            $page
        );
    }
}