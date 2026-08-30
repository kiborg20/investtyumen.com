<section>
<div class="container">
	<h3 class="t1920">СМИ О НАС</h3>
	<div class="mediaslider">
		<div class="mediaslider_slide">
        <?foreach ($arResult as $item): ?>
            <?
                $file = CFile::ResizeImageGet($item["PREVIEW_PICTURE"], array('width' => 400,'height' => 400), BX_RESIZE_IMAGE_EXACT, true);
            ?>
            
			<div class="smicard dadflex">
                
				<div class="smiimg" style="background: url('<?=$file['src']?>');">
				</div>
				<div class="smicont">
					<div class="smidate">
                        <?=FormatDateFromDB($item["DATE_ACTIVE_FROM"], 'DD.MM.YYYY')?>
					</div>
					<div class="smititle">
						 <?=$item['NAME']?>
					</div>
					<div class="smitext">
                        <p><?=$item['PREVIEW_TEXT']?></p>
                    
					</div>
					<div class="smisource">
                        <b>Источник: <?=$item['PROPERTY_IT_SMIONAS_SOURCE_VALUE']?></b> <a class="reedmorelink" target="blanc_" href="<?=$item['PROPERTY_IT_SMIONAS_SOURCE_LINK_VALUE']?>">перейти к источнику</a>
					</div>
				</div>
			</div>
        <?endforeach;?>
		</div>
	</div>
</div>
</section>