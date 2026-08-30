<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="person-cards">
    <?foreach ($arResult as $item):
      $img = CFile::GetPath($item["PREVIEW_PICTURE"]);
    ?>
    <div class="person-cards__item">
        <div class="person-cards__image" style="background-image: url('<?=$img?>');"></div>
        <div class="headline headline_size-h5"><?=$item["NAME"]?></div>
        <div class="description description_padding-top-xs description_c-black-60 description_size-p2">
            <p><?=$item["PROPERTY_IT_CONT_DOL_VALUE"]?></p>
            <div class="person-cards__contacts">
                <div class="person-cards__contacts-text">
                    <? if ($item["PROPERTY_IT_CONT_EM_VALUE"]): ?>
                    <div><a href="mailto:<?=$item["PROPERTY_IT_CONT_EM_VALUE"]?>"><?=$item["PROPERTY_IT_CONT_EM_VALUE"]?></a></div>
                    <? endif; ?>

                    <? if ($item["PROPERTY_IT_CONT_PH_VALUE"]): ?>
                    <div><?=$item["PROPERTY_IT_CONT_PH_VALUE"]?></div>
                    <? endif; ?>
                </div>

                <a class="button button_theme-white button_size-s"
                    data-person-vcard-button
                    data-person-vcard-name="<?=$item["NAME"]?>"
                    data-person-vcard-position="<?=$item["PROPERTY_IT_CONT_DOL_VALUE"]?>"
                    data-person-vcard-email="<?=$item["PROPERTY_IT_CONT_EM_VALUE"]?>"
                    data-person-vcard-phone="<?=$item["PROPERTY_IT_CONT_PH_VALUE"]?>"
                >
                    <div class="button__icon">
                        <svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C12 6.20914 10.2091 8 8 8C5.79086 8 4 6.20914 4 4C4 1.79086 5.79086 0 8 0C10.2091 0 12 1.79086 12 4ZM10.5 4C10.5 5.38071 9.3807 6.5 8 6.5C6.61929 6.5 5.5 5.38071 5.5 4C5.5 2.61929 6.61929 1.5 8 1.5C9.3807 1.5 10.5 2.61929 10.5 4Z" fill="#252830"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16 14.1666C16 13.7333 15.8642 13.3074 15.5815 12.979C13.7477 10.8488 11.0313 9.5 8 9.5C4.96866 9.5 2.25235 10.8488 0.41847 12.979C0.13576 13.3074 0 13.7333 0 14.1666V16C0 17.1046 0.89543 18 2 18H14C15.1046 18 16 17.1046 16 16V14.1666ZM14 16.5C14.2761 16.5 14.5 16.2761 14.5 16V14.1666C14.5 14.0384 14.4601 13.9754 14.4448 13.9576C12.8837 12.1443 10.5763 11 8 11C5.4237 11 3.11632 12.1443 1.55524 13.9576C1.53991 13.9754 1.5 14.0384 1.5 14.1666V16C1.5 16.2761 1.72386 16.5 2 16.5H14Z" fill="#252830"/>
                            <path d="M18 10C17.5858 10 17.25 9.6642 17.25 9.25V6.75H14.75C14.3358 6.75 14 6.41422 14 6C14 5.58579 14.3358 5.25 14.75 5.25H17.25V2.75C17.25 2.33579 17.5858 2 18 2C18.4142 2 18.75 2.33579 18.75 2.75V5.25H21.25C21.6642 5.25 22 5.58579 22 6C22 6.41422 21.6642 6.75 21.25 6.75H18.75V9.25C18.75 9.6642 18.4142 10 18 10Z" fill="#252830"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?endforeach;?>
</div>
