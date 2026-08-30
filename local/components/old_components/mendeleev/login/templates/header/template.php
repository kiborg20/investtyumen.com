<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<a href="/personal/" class="header-auth-profile">

    <?
    if ($arResult['PHOTO']) {
        ?>
        <img class="header-auth-profile-img" src="<?=$arResult['PHOTO']?>">
        <?
    } else {
        $firstLetter = mb_substr(strval($USER->GetFirstName()) , 0 , 1);
            ?>
                <span class="header-auth-profile-img"><?=$firstLetter?></span>
            <?
    }
    ?>
    <div class="header-auth-profile-user"><?=$arResult['NAME']?></div>
</a>
