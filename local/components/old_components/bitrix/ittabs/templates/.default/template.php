<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
    
    <section>
        <div class="container">
            <div class="content_tabs">
                <div class="sidebar">
                    <ul class="content_tabs_ul">
                        <?$i=0;
                        foreach ($arResult as $item):?>
                        <li class="content_tabs_ul_li <?if ($i==0){?>content_tabs_ul_li_active<?}?>"><a class="selecttab"  data-target="content_tab<?=$item["ID"]?>"><?=$item["NAME"]?></a></li>
                        
                        <?$i++;endforeach;?>
                    </ul>
                </div>
                <?
                $i=0;
                foreach ($arResult as $item): ?>
                <div class="content_tab content_tab<?=$item["ID"]?> <?if ($i==0){?>content_tab_active<?}?>">
                    <div class="textsubtitle"><?=htmlspecialchars_decode($item['UF_TITLE'])?></div>
                    <div class="content_tab_content">
                        <?if ($item["PICTURE"] != ''){?><?$file = CFile::ResizeImageGet($item["PICTURE"], array('width' => 780,'height' => 333), BX_RESIZE_IMAGE_EXACT, true);?>
                        <img src="<?=$file["src"]?>"><?}?>
                        <?=$item["DESCRIPTION"]?>
                    </div>
                </div>
                <?$i++;endforeach;?>
                
                <div class="stopsidebar"></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    