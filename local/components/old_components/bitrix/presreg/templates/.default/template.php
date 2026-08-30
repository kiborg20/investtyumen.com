<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
    <section class="informres bgblue">
        <div class="container">
            <div class="titlebold fontwhite"><?=$arParams['HEROTITLE'];?></div>
            <div class="infresource">
            <?foreach ($arResult as $item): ?>
            <?
            $file = CFile::GetPath($item["PROPERTY_IT_ATTACH_VALUE"]);
              $img = CFile::GetPath($item["PREVIEW_PICTURE"]);
            ?>
            
            <a href="<?=$file?>" class="linkpic" target="blanc_"><img src="<?=$img?>" alt=""><?=$item["NAME"]?></a>
            <?endforeach;?>
            </div>
            <div class="invpriv">
                <p>Нам важна оперативная обратная связь от бизнеса в части доступности и удобства получения мер 
                    государственной поддержки, работы с инвесторами и общественными объединениями. 
                    <br><br>На сайте Фонда «Инвестиционное агентство Тюменской области» размещена анкета обратной связи, 
                    где пользователь может задать вопрос или предложить свои варианты решения. 
                    Ежемесячно формируется Инвестиционный дайджест бизнес событий региона, по прилагаемым ссылкам 
                    можно посмотреть запись прошедших мероприятий или пройти регистрацию на планируемые.</p>
                <p>Мы открыты к активного диалогу и внедрению лучших практик в работе с предпринимательским 
                    сообществом и инвесторами.</p>
            </div>
        </div>
    </section>
    