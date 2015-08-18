
<script>
	function deleteFromWishlist(wishlist_id)
	{ 
		$.ajax({
			url: '/wishlist/wishlist_manipulations.php',
			data: {
				action:'delete_id',
				wishlist_id: wishlist_id
			},
			method: 'POST',
			success: function(data){location.reload();}
		}	);
	}
</script>
<?php
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$APPLICATION->AddHeadScript("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js");

	function renderElementsPage($a, $i){
		
		if(0 == count($a)){
			echo('Записей нет');
		}
		else{
			$i;
			foreach($a as $product)
			{ ?>
				<div id='product_<?=$product['ID']?>'>
					<?=$i?>
					<img style="width:100px;" src="<?=$product['DETAIL_PICTURE']?>"/>
					<?=$product['NAME']?>
					<a href="<?=$product['DETAIL_PAGE_URL']?>">more..</a>
					<a href='javascript:void(0)' onclick=deleteFromWishlist("<?=$product['ID']?>")> DELETE</a></br>
				</div>
			<? $i++;
			}
		}
		
	}
	
	$countOnPage = 5;
	$elements = $arResult['PRODUCTS'];
	$page = !empty($_GET['PAGEN_1']) ? intval($_GET['PAGEN_1']) : 1;
	$elementsPage = array_slice($elements, ($page-1) * $countOnPage, $countOnPage);
	echo renderElementsPage($elementsPage, ($page-1)*$countOnPage+1);
	$navResult = new CDBResult();
	$navResult->NavPageCount = ceil(count($elements) / $countOnPage);
	$navResult->NavPageNomer = $page;
	$navResult->NavNum = 1;
	$navResult->NavPageSize = $countOnPage;
	$navResult->NavRecordCount = count($elements);

	$APPLICATION->IncludeComponent('bitrix:system.pagenavigation', '', array(
		'NAV_RESULT' => $navResult,
	));
	
	
?>

