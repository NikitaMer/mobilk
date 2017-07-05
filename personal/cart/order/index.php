<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформить заказ");?>
<h1>Оформление заказа</h1>
<? $basket_type = getBasketType(); ?>
<? if ($basket_type == "empty" || $basket_type == "product") { ?>
	<?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "order", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"PAY_FROM_ACCOUNT" => "Y",	// Разрешить оплату с внутреннего счета
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
		"COUNT_DELIVERY_TAX" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
		"SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
		"DELIVERY_NO_AJAX" => "Y",	// Рассчитывать сразу доставки с внешним доступом к сервисам
		"DELIVERY_NO_SESSION" => "N",	// Проверять сессию при оформлении заказа
		"TEMPLATE_LOCATION" => ".default",	// Визуальный вид контрола выбора метоположений
		"DELIVERY_TO_PAYSYSTEM" => "d2p",	// Последовательность оформления
		"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
		"PROP_1" => "",
		"PROP_2" => "",
		"ALLOW_NEW_PROFILE" => "Y",	// Разрешить множество профилей покупателей
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",	// Показывать изображения складов в окне выбора пункта выдачи
		"PATH_TO_BASKET" => "/personal/cart/",	// Путь к странице корзины
		"PATH_TO_PERSONAL" => "/personal/",	// Путь к странице персонального раздела
		"PATH_TO_PAYMENT" => "/personal/cart/payment/",	// Страница подключения платежной системы
		"PATH_TO_AUTH" => "/auth/",	// Путь к странице авторизации
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"DISABLE_BASKET_REDIRECT" => "N",	// Оставаться на странице оформления заказа, если список товаров пуст
		"PRODUCT_COLUMNS" => "",
		"SHOW_NOT_CALCULATED_DELIVERIES" => "L",	// Отображение доставок с ошибками расчета
		"COMPATIBLE_MODE" => "Y",	// Режим совместимости для предыдущего шаблона
		"USE_PRELOAD" => "Y",	// Автозаполнение оплаты и доставки по предыдущему заказу
		"ALLOW_USER_PROFILES" => "N",	// Разрешить использование профилей покупателей
		"TEMPLATE_THEME" => "site",	// Цветовая тема
		"SHOW_ORDER_BUTTON" => "final_step",	// Отображать кнопку оформления заказа (для неавторизованных пользователей)
		"SHOW_TOTAL_ORDER_BUTTON" => "N",	// Отображать дополнительную кнопку оформления заказа
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",	// Отображать названия в списке платежных систем
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",	// Отображать название в блоке информации по платежной системе
		"SHOW_DELIVERY_LIST_NAMES" => "Y",	// Отображать названия в списке доставок
		"SHOW_DELIVERY_INFO_NAME" => "Y",	// Отображать название в блоке информации по доставке
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",	// Показывать название родительской доставки
		"SKIP_USELESS_BLOCK" => "Y",	// Пропускать шаги, в которых один элемент для выбора
		"BASKET_POSITION" => "after",	// Расположение списка товаров
		"SHOW_BASKET_HEADERS" => "N",	// Показывать заголовки колонок списка товаров
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",	// Дополнительные услуги, которые будут показаны в пройденном (свернутом) блоке
		"SHOW_COUPONS_BASKET" => "Y",	// Показывать поле ввода купонов в блоке списка товаров
		"SHOW_COUPONS_DELIVERY" => "Y",	// Показывать поле ввода купонов в блоке доставки
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",	// Показывать поле ввода купонов в блоке оплаты
		"SHOW_NEAREST_PICKUP" => "N",	// Показывать ближайшие пункты самовывоза
		"DELIVERIES_PER_PAGE" => "8",	// Количество доставок на странице
		"PAY_SYSTEMS_PER_PAGE" => "8",	// Количество платежных систем на странице
		"PICKUPS_PER_PAGE" => "5",	// Количество пунктов самовывоза на странице
		"SHOW_MAP_IN_PROPS" => "N",	// Показывать карту в блоке свойств заказа
		"PROPS_FADE_LIST_1" => "",	// Свойства заказа, которые будут показаны в пройденном (свернутом) блоке (Физическое лицо)[s1]
		"PROPS_FADE_LIST_2" => "",	// Свойства заказа, которые будут показаны в пройденном (свернутом) блоке (Юридическое лицо)[s1]
		"PRODUCT_COLUMNS_VISIBLE" => array(	// Выбранные колонки таблицы списка товаров
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
		),
		"ADDITIONAL_PICT_PROP_14" => "-",	// Дополнительная картинка [Товары Мобил К]
		"ADDITIONAL_PICT_PROP_15" => "-",	// Дополнительная картинка [Торговые предложения DELUXE]
		"ADDITIONAL_PICT_PROP_20" => "-",	// Дополнительная картинка [Торговые предложения]
		"ADDITIONAL_PICT_PROP_24" => "-",	// Дополнительная картинка [Бонусный каталог]
		"BASKET_IMAGES_SCALING" => "standard",	// Режим отображения изображений товаров
		"SERVICES_IMAGES_SCALING" => "standard",	// Режим отображения вспомагательных изображений
		"PRODUCT_COLUMNS_HIDDEN" => "",	// Свойства товаров отображаемые в свернутом виде в списке товаров
		"USE_YM_GOALS" => "N",	// Использовать цели счетчика Яндекс.Метрики
		"USE_CUSTOM_MAIN_MESSAGES" => "N",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",	// Заменить стандартные фразы на свои
		"USE_CUSTOM_ERROR_MESSAGES" => "N",	// Заменить стандартные фразы на свои
	),
	false
);?>
<? } else if ($basket_type == "bonus") { ?>
	<?$APPLICATION->IncludeComponent(
		"webgk:points.order",
		"",
		Array(),
		false
	);?>
<? } else { ?>
	<p>В корзине товары разного типа, оформить заказ невозможно. <a href="/personal/cart/">Перейти в корзину</a></p>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>