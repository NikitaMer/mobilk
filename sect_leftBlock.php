<div id="left">
	<a href="<?=SITE_DIR?>catalog/" class="heading orange<?$APPLICATION->ShowViewContent("menuRollClass");?>" id="catalogMenuHeading"><?=GetMessage("DRESS_CATALOG")?><ins></ins></a>
	<div class="collapsed">
		<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"leftMenu", 
	array(
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "leftMenu",
		"HIDE_MEASURES" => "N",
		"PRODUCT_PRICE_CODE" => array(
		)
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
		<?$APPLICATION->IncludeComponent("bitrix:menu", "leftSubMenu", array(
	"ROOT_MENU_TYPE" => "left2",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left2",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "leftSubMenu"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "Y"
	)
);?>
	</div>
	<?$APPLICATION->ShowViewContent("smartFilter");?>
	<div class="<?$APPLICATION->ShowViewContent("hiddenZoneClass");?>">
		<div id="specialBlockMoveContainer"></div>
		<div class="sideBlock banner">
            <?$APPLICATION->IncludeFile(SITE_DIR."sect_left_banner1.php", Array(), Array("MODE" => "text", "NAME" => GetMessage("SECT_LEFT_BANNER_1"), "TEMPLATE" => "sect_left_banner1.php"));?>
        </div>
		<div id="subscribe" class="sideBlock">
		    <div class="sideBlockContent">
			    <?$APPLICATION->IncludeFile(SITE_DIR."sect_subscribe.php", Array(), Array("MODE" => "text", "NAME" => GetMessage("SECT_SUBSCRIBE"), "TEMPLATE" => "sect_subscribe.php"));?>
				<?$APPLICATION->IncludeComponent("bitrix:subscribe.form", ".default", Array(
					"USE_PERSONALIZATION" => "Y",
						"PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php",
						"SHOW_HIDDEN" => "Y",
						"AJAX_MODE" => "Y",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "3600",
					),
					false
				);?>
			</div>
		</div>
		
		
		

		<div class="sideBlock banner">
			<?$APPLICATION->IncludeFile(SITE_DIR."sect_left_banner2.php", Array(), Array("MODE" => "text", "NAME" => GetMessage("SECT_LEFT_BANNER_2"), "TEMPLATE" => "sect_left_banner2.php"));?>
		</div>
	</div>
</div>