<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
global $USER;
$aMenuNativeExt = array();

// если пользователь продавец, то для него отображаются дополнительные пункты меню
if (isUserSaler()) {
	$aMenuLinks = Array(
		Array(
			"Для продавцов", 
			"/personal/for_salers/", 
			Array(), 
			Array(), 
			"" 
		),
		Array(
			"Мои продажи",
			SITE_DIR."personal/for_salers/my_sales/",
			Array(),
			Array(),
			""
		),
		Array(
			"Прайс-лист баллов",
			SITE_DIR."personal/for_salers/points_price_list/",
			Array(),
			Array(),
			""
		),
		Array(
			"Задать вопрос",
			SITE_DIR."personal/for_salers/ask_question/",
			Array(),
			Array(),
			""
		),
		Array(
			"Бонусный каталог",
			SITE_DIR."personal/for_salers/bonus_catalog/",
			Array(),
			Array(),
			""
		),
		Array(
			"Бонусная статистика",
			SITE_DIR."personal/for_salers/bonus_statistic/",
			Array(),
			Array(),
			""
		),
		Array(
			"Персональные данные", 
			"/personal/", 
			Array(), 
			Array(), 
			"" 
		)
	);
}
?>