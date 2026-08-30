<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

?>

<div class="profile-list-information">
    <h1>Важная информация</h1>
    <?
        foreach ($arResult['SECTION_TREED'] as $arParentSection) { //depth 1
            ?>
            <h2><?=$arParentSection['NAME']?></h2>
            <?
            if (!empty($arParentSection['SUB_SECTION'])) {
                ?>
                <?
                foreach ($arParentSection['SUB_SECTION'] as $arSubsection) { // depth 2
                    ?>
                    <div class="tabpadfaq">
                        <div class="faqitem">
                            <div class="faqitemtitle">
                                <?=$arSubsection['NAME']?>
                            </div>
                            <div class="faqitemcontent">
                                <?
                                if (count($arSubsection['SUB_SECTION']) > 0) {
                                    foreach ($arSubsection['SUB_SECTION'] as $arSubSectionEnd) { // depth 3
                                        ?>
                                        <h3><?=$arSubSectionEnd['NAME']?></h3>
                                        <?
                                        foreach ($arSubSectionEnd['ITEMS'] as $arItem) {
                                            ?>
                                            <span><?=$arItem['NAME']?></span>
                                            <h4><?=$arItem['PROPERTY_NAME_VALUE']?></h4>
                                            <p><?=$arItem['DETAIL_TEXT']?></p>
                                            <?
                                        }
                                        ?>

                                        <?
                                    }
                                    ?>

                                    <?
                                }
                                if (!empty($arSubsection['ITEMS'])) { //выводим элементы
                                    foreach ($arSubsection['ITEMS'] as $arItem) {
                                        ?>
                                        <span><?=$arItem['NAME']?></span>
                                        <h4><?=$arItem['PROPERTY_NAME_VALUE']?></h4>
                                        <p><?=$arItem['DETAIL_TEXT']?></p>
                                        <?
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?
                }
            }
        }
    ?>
</div>