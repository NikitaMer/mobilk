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
								// ��� ���� �������� ������ ����������� ��� ������������
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
				<? // ������� ���� ��� ���������� ������ ����� ����� �������� ���� �����, �.�. ��������� ��� ���� ������ �� ������� ?>
				<? if ($propertyID == "NAME") { ?>
				<div class="webFormItems">
					<div class="webFormItemCaption">
						<div class="webFormItemLabel">
							<?= GetMessage("ADD_ITEM") ?>
						</div>
					</div>
					<div class="webFormItemField">
						<?$APPLICATION->IncludeComponent("bitrix:news.list", "product_choise", Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
								"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
								"AJAX_MODE" => "N",	// �������� ����� AJAX
								"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
								"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
								"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
								"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
								"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
								"CACHE_GROUPS" => "Y",	// ��������� ����� �������
								"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
								"CACHE_TYPE" => "A",	// ��� �����������
								"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
								"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
								"DISPLAY_BOTTOM_PAGER" => "N",	// �������� ��� �������
								"DISPLAY_DATE" => "N",	// �������� ���� ��������
								"DISPLAY_NAME" => "Y",	// �������� �������� ��������
								"DISPLAY_PICTURE" => "N",	// �������� ����������� ��� ������
								"DISPLAY_PREVIEW_TEXT" => "N",	// �������� ����� ������
								"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
								"FIELD_CODE" => array(	// ����
									0 => "ID",
									1 => "NAME",
									2 => "",
								),
								"FILTER_NAME" => "",	// ������
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
								"IBLOCK_ID" => "20",	// ��� ��������������� �����
								"IBLOCK_TYPE" => "catalog",	// ��� ��������������� ����� (������������ ������ ��� ��������)
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
								"INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
								"MESSAGE_404" => "",	// ��������� ��� ������ (�� ��������� �� ����������)
								"NEWS_COUNT" => "",	// ���������� �������� �� ��������
								"PAGER_BASE_LINK_ENABLE" => "N",	// �������� ��������� ������
								"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
								"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
								"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
								"PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
								"PAGER_TITLE" => "�������",	// �������� ���������
								"PARENT_SECTION" => "",	// ID �������
								"PARENT_SECTION_CODE" => "",	// ��� �������
								"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
								"PROPERTY_CODE" => array(	// ��������
									0 => "",
									1 => "",
								),
								"SET_BROWSER_TITLE" => "N",	// ������������� ��������� ���� ��������
								"SET_LAST_MODIFIED" => "N",	// ������������� � ���������� ������ ����� ����������� ��������
								"SET_META_DESCRIPTION" => "N",	// ������������� �������� ��������
								"SET_META_KEYWORDS" => "N",	// ������������� �������� ����� ��������
								"SET_STATUS_404" => "N",	// ������������� ������ 404
								"SET_TITLE" => "N",	// ������������� ��������� ��������
								"SHOW_404" => "N",	// ����� ����������� ��������
								"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
								"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
								"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
								"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
								"COMPONENT_TEMPLATE" => ".default"
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