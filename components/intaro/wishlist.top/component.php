<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	


//Создаем объект кеша
$obCache = new CPHPCache;
//Определяем время на которое кешируем данные в сек.
$life_time = 3600000;
//Определяем ID кеша, ID это уникальное значение по которому отличаются кеши, может быть так же массивом
$cache_id = "wishlisttop";
//Пытаемся создать новый кеш, если получается то вычисляем данные и сохраняем их
//если не получается, то считаем что кеш уже есть и считываем данные из него
// /cache_dir - это путь к папке с нашим кешем относительно /bitrix/cache
if($obCache->StartDataCache($life_time, $cache_id, "/wishlisttop")) {

	$arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRODUCT");
	$arFilter = Array("IBLOCK_CODE"=>"wishlist");
	$arGroupBy = Array("PROPERTY_PRODUCT");
	$res = CIBlockElement::GetList(Array(), $arFilter, $arGroupBy, Array("nPageSize"=>50), $arSelect);
	
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$allProducts[] = $arFields;
	}
	
	function compare($a, $b){
		if($a["CNT"] == $b["CNT"]) return 0;
		return ($a["CNT"] > $b["CNT"]) ? -1 : 1;
	}
	
	usort($allProducts, "compare");
	
	$popProducts = array_slice($allProducts, 0, 3);
	
	
	foreach($popProducts as $pProduct){
		$product = CIBlockElement::GetByID((int)$pProduct['PROPERTY_PRODUCT_VALUE']);
		if($ar_res = $product->GetNext()){
			$arResult['PRODUCTS'][] = array(
				"NAME"=>$ar_res['NAME'],
				"DETAIL_PICTURE"=>CFile::GetFileArray($ar_res['DETAIL_PICTURE'])['SRC'],//$ar_res['DETAIL_PICTURE'],
				"DETAIL_PAGE_URL"=>$ar_res['DETAIL_PAGE_URL'],
				"ID"=>$arFields["ID"]
				);
		}	
	}
	
	$arResult['COUNT'] = count($res);

//Кешируем переменную (можно несколько)
$obCache->EndDataCache(array(
"arResult" => $arResult
));
} else {
// Если у нас был кеш до достаем закешированные переменные
extract($obCache->GetVars());
}


	/*
	$arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRODUCT");
	$arFilter = Array("IBLOCK_CODE"=>"wishlist");
	$arGroupBy = Array("PROPERTY_PRODUCT");
	$res = CIBlockElement::GetList(Array(), $arFilter, $arGroupBy, Array("nPageSize"=>50), $arSelect);
	
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$allProducts[] = $arFields;
	}
	
	function compare($a, $b){
		if($a["CNT"] == $b["CNT"]) return 0;
		return ($a["CNT"] > $b["CNT"]) ? -1 : 1;
	}
	
	usort($allProducts, "compare");
	
	$popProducts = array_slice($allProducts, 0, 3);
	
	
	foreach($popProducts as $pProduct){
		$product = CIBlockElement::GetByID((int)$pProduct['PROPERTY_PRODUCT_VALUE']);
		if($ar_res = $product->GetNext()){
			$arResult['PRODUCTS'][] = array(
				"NAME"=>$ar_res['NAME'],
				"DETAIL_PICTURE"=>CFile::GetFileArray($ar_res['DETAIL_PICTURE'])['SRC'],//$ar_res['DETAIL_PICTURE'],
				"DETAIL_PAGE_URL"=>$ar_res['DETAIL_PAGE_URL'],
				"ID"=>$arFields["ID"]
				);
		}	
	}
	
	$arResult['COUNT'] = count($res);
		*/
$this->IncludeComponentTemplate();
?>