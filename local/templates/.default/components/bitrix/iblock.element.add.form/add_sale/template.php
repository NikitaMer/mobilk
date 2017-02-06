<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(false);
if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;?>
<?if (strlen($arResult["MESSAGE"]) > 0):?>
	<?ShowNote($arResult["MESSAGE"])?>
<?endif?>
<h2 class="send_saler_report_header"><?= GetMessage("SEND_SALE_REPORT") ?></h2>
<? if (!$arResult['USER_HAVE_ACTIVE_REQUESTS']) { ?>
<form name="iblock_add" action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data">
	<?=bitrix_sessid_post()?>
		<? if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])) { ?>
		<div class="webFormItems">
			<? foreach ($arResult["PROPERTY_LIST"] as $propertyID) { ?>
				<? if ($propertyID == SALER_REPORT_PRODUCT_ID_PROPERTY_ID) { continue; } ?>
				<div class="webFormItem" style="<?= $propertyID == "NAME" ? "display: none" : "" ?>">
					<div class="webFormItemCaption">
						<div class="webFormItemLabel">
						<? if (intval($propertyID) > 0) { ?>
							<?= $arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"] ?>
						<? } else { ?>
							<?= !empty($arParams["CUSTOM_TITLE_" . $propertyID]) ? $arParams["CUSTOM_TITLE_" . $propertyID] : GetMessage("IBLOCK_FIELD_" . $propertyID) ?>
						<? } ?>
						</div>
					</div>
					<div class="webFormItemField">
						<?
						if (intval($propertyID) > 0)
						{
							if (
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
							elseif (
								(
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
									||
									$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
								)
								&&
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
							)
								$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
						}
						elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
							$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

						if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
						{
							$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
							$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
						}
						else
						{
							$inputNum = 1;
						}

						if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
							$INPUT_TYPE = "USER_TYPE";
						else
							$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];

						switch ($INPUT_TYPE) {
							case "S":
							case "USER_TYPE":
							case "N":
								for ($i = 0; $i<$inputNum; $i++)
								{
									if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
									{
										$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
									}
									elseif ($i == 0)
									{
										$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

									}
									else
									{
										$value = "";
									}
								?>
								<?
								// для поля название всегда подставляем ФИО пользователя
								if ($propertyID == "NAME") {
									$value = $arResult['USER_FULL_NAME'];
								}
								?>
								<?
								if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["USER_TYPE"] == "Date") { ?>
									<div class="sale_date_calendar">
									<? $APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'FORM_NAME' => 'iblock_add',
											'INPUT_NAME' => "PROPERTY[".$propertyID."][".$i."]",
											'INPUT_VALUE' => $value,
										),
										null,
										array('HIDE_ICONS' => 'Y')
									); ?>
									</div>
									<input type="text" readonly data-field-type="calendar" class="inputtext" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" />
								<? } else { ?>
									<input type="text" class="inputtext" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" size="25" value="<?=$value?>" /><?
									}
								}
							break;
						} ?>
					</div>
				</div>
				<? // выведем поле для добавления товара сразу после скрытого поля имени, т.к. компонент это поле вообще не выводит ?>
				<? if ($propertyID == "NAME") { ?>
				<div class="webFormItems">
					<div class="webFormItemCaption">
						<div class="webFormItemLabel">
							<?= GetMessage("ADD_ITEM") ?>
						</div>
					</div>
					<div class="webFormItemField">
						<?$APPLICATION->IncludeComponent("bitrix:search.title", "products_search", Array(
							"COMPONENT_TEMPLATE" => ".default",
								"NUM_CATEGORIES" => "1",	// Количество категорий поиска
								"TOP_COUNT" => "15",	// Количество результатов в каждой категории
								"ORDER" => "date",	// Сортировка результатов
								"USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
								"CHECK_DATES" => "N",	// Искать только в активных по дате документах
								"SHOW_OTHERS" => "N",	// Показывать категорию "прочее"
								"PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
								"SHOW_INPUT" => "Y",	// Показывать форму ввода поискового запроса
								"INPUT_ID" => "title-search-input",	// ID строки ввода поискового запроса
								"CONTAINER_ID" => "title-search",	// ID контейнера, по ширине которого будут выводиться результаты
								"CATEGORY_0_TITLE" => "",	// Название категории
								"CATEGORY_0" => array(	// Ограничение области поиска
									0 => "iblock_catalog",
								),
								"CATEGORY_0_iblock_catalog" => array(	// Искать в информационных блоках типа "iblock_catalog"
									0 => "14",
									1 => "20",
								)
							),
							false
						);?>
					</div>
				</div>
				<input type="hidden" name="PROPERTY[<?= SALER_REPORT_PRODUCT_ID_PROPERTY_ID ?>][0]" size="25" value="" />
				<? } ?>
			<? } ?>
		</div>
		<? } ?>
		<div class="webFormTools">
			<div class="tb">
				<div class="tc">
					<input type="submit" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" />
					<? if (strlen($arParams["LIST_URL"]) > 0) { ?>
						<input type="submit" name="iblock_apply" value="<?=GetMessage("IBLOCK_FORM_APPLY")?>" />
						<input
							type="button"
							name="iblock_cancel"
							value="<? echo GetMessage('IBLOCK_FORM_CANCEL'); ?>"
							onclick="location.href='<? echo CUtil::JSEscape($arParams["LIST_URL"])?>';"
						>
					<? } ?>
				</div>
			</div>
		</div>
</form>
<? } else { ?>
	<?= GetMessage('USER_HAVE_ACTIVE_REQUESTS') ?>
<? } ?>