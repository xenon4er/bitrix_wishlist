<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	
	$arResult['DATE'] = date($arParams["TEMPLATE_FOR_DATE"]);
	$arResult['USER'] = $USER->GetID();
	
	
	$arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRODUCT");
	$arFilter = Array("IBLOCK_CODE"=>"wishlist", "PROPERTY_USER"=>(int)$USER->GetID());
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
	
	
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$product = CIBlockElement::GetByID((int)$arFields['PROPERTY_PRODUCT_VALUE']);
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
	
$this->IncludeComponentTemplate();
?>