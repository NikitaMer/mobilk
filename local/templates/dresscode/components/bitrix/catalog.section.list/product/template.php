<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

	$this->setFrameMode(true);

	$i = 0;

	foreach($arResult["SECTIONS"] as $arElement){
        
		if($arElement["DEPTH_LEVEL"] == 2 && in_array($arElement["ID"], $arParams["FILTER"])){
			$result[$i]["ELEMENTS"][] = array(
				"NAME" => $arElement["NAME"],
				"SECTION_PAGE_URL" => $arElement["SECTION_PAGE_URL"],
				"PICTURE" => CFile::ResizeImageGet($arElement["PICTURE"], array("width" => 25, "height" => 20), BX_RESIZE_IMAGE_PROPORTIONAL, false)
			);
		}
	}
    
	?>

	<div id="catalogSection">
		<?if(count($result) > 0):?>
			<div class="sectionItems">
				<?foreach($result as $nextElement):?>
					<div class="item border_none">
						<div class="itemContainer">
							<div class="column">
								<a href="<?=$nextElement["SECTION_PAGE_URL"]?>" class="bigTitle"><?=$nextElement["NAME"]?></a>
								<?if(!empty($nextElement["UF_DESC"])):?>
									<div class="description"><?=$nextElement["UF_DESC"]?></div>
								<?endif;?>
								<?if(count($nextElement["ELEMENTS"])):?>
									<div class="sectionList">
										<?foreach($nextElement["ELEMENTS"] as $next2Elements):?>
											<div class="section"><a href="<?=$next2Elements["SECTION_PAGE_URL"]?>"><?if(!empty($next2Elements["PICTURE"]["src"])):?><img src="<?=$next2Elements["PICTURE"]["src"]?>" alt="<?=$next2Elements["NAME"]?>"><?endif;?><?=$next2Elements["NAME"]?></a></div>
										<?endforeach;?>	
									</div>
								<?endif;?>	
							</div>
						</div>
					</div>
				<?endforeach;?>
			</div>
		<?endif;?>	
	</div>