<?php
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

		//var_dump($arResult['PRODUCTS']);
		?>
			<style>
				.popProducts{
					position: relative;
					width: 100%;
				}
				.popProduct{
					width: 30%;
					float: left;
				}
			</style>
			
		<div class='popProducts'>
		<h2>Wishlist Popular</h2>
		<?
		foreach($arResult['PRODUCTS'] as $product)
		{ ?>
			<div class='popProduct' id='product_<?=$product['ID']?>'>
				<img style="width:60px; float: left;" src="<?=$product['DETAIL_PICTURE']?>"/>
				<?=$product['NAME']?>
				<a href="<?=$product['DETAIL_PAGE_URL']?>">more..</a>
			</div>
		<? 
		}
		
		?>
		</div>
		<?
	
?>

