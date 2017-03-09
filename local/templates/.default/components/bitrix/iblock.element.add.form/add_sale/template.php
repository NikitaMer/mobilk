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
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"product_choise",
							Array(
								"COMPONENT_TEMPLATE" => ".default",
								"IBLOCK_TYPE" => "catalog",	// Тип информационного блока (используется только для проверки)
								"IBLOCK_ID" => "20",	// Код информационного блока
								"NEWS_COUNT" => "80",	// Количество новостей на странице
								"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
								"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
								"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
								"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
								"FILTER_NAME" => "",	// Фильтр
								"FIELD_CODE" => array(	// Поля
									0 => "CODE",
									1 => "NAME",
									2 => "DETAIL_PICTURE",
									3 => "",
								),
								"PROPERTY_CODE" => array(	// Свойства
									0 => "",
									1 => "ARTICLE",
									2 => "GOLDEN_LVL_POINTS",
									3 => "SILVER_LVL_POINTS",
									4 => "ACTION_PRODUCT",
									5 => "ADDITIONAL_POINTS"
								),
								"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
								"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
								"AJAX_MODE" => "N",	// Включить режим AJAX
								"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
								"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
								"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
								"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
								"CACHE_TYPE" => "A",	// Тип кеширования
								"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
								"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
								"CACHE_GROUPS" => "Y",	// Учитывать права доступа
								"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
								"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
								"SET_TITLE" => "N",	// Устанавливать заголовок страницы
								"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
								"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
								"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
								"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
								"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
								"PARENT_SECTION" => "",	// ID раздела
								"PARENT_SECTION_CODE" => "",	// Код раздела
								"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
								"DISPLAY_DATE" => "N",	// Выводить дату элемента
								"DISPLAY_NAME" => "Y",	// Выводить название элемента
								"DISPLAY_PICTURE" => "N",	// Выводить изображение для анонса
								"DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
								"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
								"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
								"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
								"PAGER_TITLE" => "Новости",	// Название категорий
								"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
								"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
								"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
								"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
								"SET_STATUS_404" => "N",	// Устанавливать статус 404
								"SHOW_404" => "N",	// Показ специальной страницы
								"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
							),
							false
						);?>
					</div>
				</div>
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