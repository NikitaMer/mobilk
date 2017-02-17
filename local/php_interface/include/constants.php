<?
// инфоблок с заявками
define("SALERS_REQUESTS_IBLOCK_ID", 21);
// инфоблок с отчетами о продажах
define("SALERS_REPORTS_IBLOCK_ID", 22);
// инфоблок с настройками уровней пользователя
define("SALERS_LVLS_IBLOCK_ID", 23);
// каталог
define("CATALOG_IBLOCK_ID", 14);
// каталог с ТП
define("SKU_CATALOG_IBLOCK_ID", 20);
// бонусный каталог
define("BONUS_CATALOG_IBLOCK_ID", 24);
// бонусные заказы
define("BONUS_ORDERS_IBLOCK_ID", 25);

// сущность "Серебряные партнеры" для инфоблока уровни продавцов
define("SILVER_LVL_ID", 185);
// сущность "Золотые партнеры" для инфоблока уровни продавцов
define("GOLDEN_LVL_ID", 186);

define("SALERS_GROUP_ID", 9);
define("SILVER_SALER_GROUP_ID", 10);
define("GOLDEN_SALER_GROUP_ID", 11);
// тип почтового события и ID шаблона для письма о новой заявке
define("NEW_SALER_REQUEST_EVENT_TYPE", "NEW_SALER_REQUEST");
define("NEW_SALER_REQUEST_TEMPLATE_ID", 84);
// тип почтового события и ID шаблона для письма о новом отчете
define("NEW_SALER_REPORT_EVENT_TYPE", "NEW_SALER_REPORT");
define("NEW_SALER_REPORT_TEMPLATE_ID", 85);
// ID свойства "товар" для заявок о продажах
define('SALER_REPORT_PRODUCT_ID_PROPERTY_ID', 127);
// ID свойства "статус" для заявок о продажах
define('SALER_REPORT_STATUS_PROPERTY_ID', 130);
// ID значения "На рассмотрении" для свойства "Статус"
define('SALER_REPORT_STATUS_UNDER_CONSIDERATION_ID', 77);
// ID значения "Принято" для свойства "Статус"
define('SALER_REPORT_STATUS_ACCEPTED_ID', 75);
// размер маленьких картинок у акционных товаров
define('ACTION_PRODUCT_LOGO_WIDTH', 100);
define('ACTION_PRODUCT_LOGO_HEIGHT', 100);
?>