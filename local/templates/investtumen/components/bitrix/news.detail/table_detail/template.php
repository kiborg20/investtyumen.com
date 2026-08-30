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
<div class="table-detail">
	<table class="detail_table">
        <?foreach($arResult["PROPERTIES"] as $prop):

            if(NULL!=$prop && $prop["HINT"]!="HIDE"){
                if($prop["PROPERTY_TYPE"]!="F"):?>
                <tr>
                    <td>
                        <?=$prop["NAME"]?>
                    </td>
                    <td>
                        <?if(is_array($prop["VALUE"])){
                            foreach($prop["VALUE"] as $key){
                                echo $key.", ";
                            }
                        }else{
                            echo $prop["VALUE"];
                        }




                        ?>
                    </td>
                </tr>
                <?else:?>
                <tr>
                    <td>
                        <?=$prop["NAME"]?>
                    </td>
                    <td>
                        <?if(count($prop["VALUE"])>0){
                            if(is_array($prop["VALUE"])){
                                foreach($prop["VALUE"] as $key=>$fileID){
                                    $file = cFile::GetById($fileID)->fetch();
                                    echo '<a target="_blank" href="'.cFile::GetPath($fileID).'">'.$file["ORIGINAL_NAME"].'</a>';
                                    if($key!=count($prop["VALUE"])-1){
                                        echo ", ";
                                    }
                                }
                            }else{
                                $file = cFile::GetById($prop["VALUE"])->fetch();
                                echo '<a target="_blank" href="'.cFile::GetPath($prop["VALUE"]).'">'.$file["ORIGINAL_NAME"].'</a>';
                            }

                        }?>
                    </td>
                </tr>
                <?endif;?>
           <? }?>

        <?endforeach;?>
    </table>
</div>
