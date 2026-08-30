<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->addExternalJS("/local/components/investportal/prtab/prtab.js");
$i=1;
$b=0;
?>

<div class="tabprojectslider">
    <?foreach ($arResult as $item): 
    if($b==4){ $b = 0; }
    if($b==0){?><div class="tpsw"><?}
    ?>
    <pre></pre>
    <?
        $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 500,'height' => 500), BX_RESIZE_IMAGE_EXACT, true);        
        $pres = CFile::GetPath($item["PROPERTY_IT_IP_FILE_VALUE"]);
    ?>
    <div class="cardwrap">
        <?
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('Подтвердите удаление')));
        ?>
        <div class="card_rtl" id="<?=$this->GetEditAreaId($item['ID']);?>">
            <div class="dadflex <?if($item["PROPERTY_IT_IP_FILE_VALUE"]){?>dadflexwpres<?};?>" style="margin-bottom: 0; position:relative;">
                <div class="s40">
                    <div class="imgcard" style="background: url('<?=$file['src'];?>') no-repeat;"></div>
                    <?if(!$item["PROPERTY_IT_IP_FILE_VALUE"]){?><a href="#" class=" prtabact" data-target="prtabmodal<?=$item["ID"]?>">Подробнее</a><?}?>
                </div>
                <div class="tpscont">
                    <p class="tpstitle accent ttu mt0"><b><?=$item["NAME"]?></b></p>
                    <?if($item["PROPERTY_IT_IP_TARGET_VALUE"]){?><p class="tpstext"><b>Цель проекта: </b> <?=$item["PROPERTY_IT_IP_TARGET_VALUE"]?></p><?};?>
                    <?if($item["PROPERTY_IT_IP_VOL_VALUE"]){?><p><b>Объем инвестиций: </b> <?=$item["PROPERTY_IT_IP_VOL_VALUE"]?></p><?};?>
                    <?if($item["PROPERTY_IT_IP_EQ_VALUE"]){?><p><b>Результат: </b> <?=$item["PROPERTY_IT_IP_EQ_VALUE"]?></p><?};?>
                    <?if($item["PROPERTY_IT_IP_LOC_VALUE"]){?><p><b>Местоположение: </b> <?=$item["PROPERTY_IT_IP_LOC_VALUE"]?></p><?};?>
                    <?if($item["PROPERTY_IT_IP_FILE_VALUE"]){?><a href="<?=$pres?>" target="blanc_" class="btn btnwhite">СКАЧАТЬ ПРЕЗЕНТАЦИЮ</a><?}?> 
                </div>
            </div>
        </div>
    </div>
    <?$i++;$b++;
    if($b == 4){?></div>
    
    <?};endforeach;
    if($b != 4){?></div><?}?>
</div>
<?foreach ($arResult as $item): 
    $file2 = CFile::ResizeImageGet($item["DETAIL_PICTURE"], array('width' => 1100,'height' => 619), BX_RESIZE_IMAGE_EXACT, true);?>
<div class="fixed-overlay fixed-overlay__modal prtabmodal prtabmodal<?=$item["ID"]?>">
    <div class="modal">
        <div class="modal_container" >
            <div class="modalclose"></div>
            <div class="investbody">
                <img src="<?=$file2['src'];?>" width="100%" alt="<?=$item["NAME"]?>">
            </div>
            
        </div>
    </div>
</div>
<?endforeach;?>
    <style>
        .tabprojectslider{position:relative;}
        .tabprojectslider .slider_arrow{bottom:-90px;right:0; z-index:40;}
        .tabprojectslider .slider_arrow_left{right:58px;}
        .prtabmodal.active{display: block;}
        .prtabmodal .modal_container{margin:auto; width:90%; max-width: 1100px;}
        .prtabmodal img{border-radius:30px;}
        .prtabmodal .modal_container{padding: 20px 20px 10px;}
    </style>
    <script>
        $(".prtabact").on('click', function(e) {
        e.preventDefault();
        var t ='.' + $(this).data('target');
        console.log(t);
        $(t).addClass('active');
        });
    </script>


 
    

    
    