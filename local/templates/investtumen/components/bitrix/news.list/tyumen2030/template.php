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
<div class="container-detail-float-wrap">
    <?
//    mpr($arResult , false);
    ?>
    <div class="textsubtitle">
        <?
        $name = explode(' ' , $arResult['SECTION']['PATH'][0]['NAME']);
        $name[0] = '<span>'.$name[0].'</span>';
        $name = implode($name, ' ');
        echo $name;
        ?>
    </div>
    <div class="container-detail-float-wrap-in">
        <div class="container-detail-float-preview">
            <img src="<?=CFile::GetPath($arResult['SECTION']['PATH'][0]['PICTURE'])?>" alt="">
        </div>
        <?php
        foreach ($arResult['ITEMS'] as $arValue):
            ?>
            <div class="container-detail-float-item">
                <div class="container-detail-float-item-title">
                    <?=$arValue['NAME']?>
                </div>
                <div class="container-detail-float-item-content">
                    <?=$arValue['DETAIL_TEXT']?>
                </div>
                <div class="container-detail-float-item-prop-link">
                    <? if ($arValue['DISPLAY_PROPERTIES']['LINK']['VALUE']):
                        ?>
                        <ul>
                            <?
                            foreach ($arValue['DISPLAY_PROPERTIES']['LINK']['VALUE'] as $intKey => $arValueLink):
                                ?>
                                <li>
                                    <a target="_blank" href="<?=$arValueLink?>"><?=$arValue['DISPLAY_PROPERTIES']['LINK']['DESCRIPTION'][$intKey]?></a>
                                </li>
                            <?
                            endforeach;
                            ?>
                        </ul>
                    <?
                    endif;?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>


</div>
