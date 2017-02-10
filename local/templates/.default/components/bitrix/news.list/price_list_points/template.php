<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div id="points_price_list">
<? foreach($arResult['PRODUCTS'] as $product) { ?>
	<div class="itemRow item">
		<div class="column">
			<p class="picture"><img src="<?= $product['picture'] ?>" alt="<?= $product['title'] ?>"></p>
		</div>
		<div class="column">
			<p class="name"><?= $product['title'] ?></p>
		</div>
		<div class="column">
			<div class="optional">
				<div class="row">
					<p class="label"><?= $product['silver_points']['title'] ?>: <?= $product['silver_points']['value'] ?></p>
					<p class="label"><?= $product['golden_points']['title'] ?>: <?= $product['golden_points']['value'] ?></p>
				</div>
			</div>
		</div>
	</div>
<? } ?>
</div>