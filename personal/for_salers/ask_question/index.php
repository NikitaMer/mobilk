<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задать вопрос");
?>
<style>
.questions_list input[name="BuyButton"], .questions_list input[type="submit"] {
	align-items: flex-start;
    text-align: center;
    cursor: default;
    color: buttontext;
    background-color: buttonface !important;
    box-sizing: border-box;
    padding: 2px 6px 3px;
    border-width: 2px;
    border-style: outset;
    border-color: buttonface;
    border-image: initial;
}
</style>
<h1>Задать вопрос</h1>
<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"personal",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ROOT_MENU_TYPE" => "salers",	// Тип меню для первого уровня
		"MENU_CACHE_TYPE" => "A",	// Тип кеширования
		"MENU_CACHE_TIME" => "3600000",	// Время кеширования (сек.)
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MAX_LEVEL" => "1",	// Уровень вложенности меню
		"CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?>

<? if (isUserSaler()) { ?>
	<div class="questions_list">
	<?$APPLICATION->IncludeComponent(
		"bitrix:support.ticket",
		"salers_support",
		Array(
			"MESSAGES_PER_PAGE" => "20",	// Количество сообщений на одной странице
			"MESSAGE_MAX_LENGTH" => "70",	// Максимальная длина неразрывной строки
			"MESSAGE_SORT_ORDER" => "asc",	// Направление для сортировки сообщений в обращении
			"SEF_MODE" => "N",	// Включить поддержку ЧПУ
			"SET_PAGE_TITLE" => "Y",	// Устанавливать заголовок страницы
			"SET_SHOW_USER_FIELD" => "",	// Показывать пользовательские поля
			"SHOW_COUPON_FIELD" => "N",	// Показывать поле ввода купона
			"TICKETS_PER_PAGE" => "50",	// Количество обращений на одной странице
			"VARIABLE_ALIASES" => array(
				"ID" => "ID",
			)
		),
		false
	);?>
	</div>
<? } ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>