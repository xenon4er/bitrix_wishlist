<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
		
		function getElemId($product_id){
			global $USER;
			if(CModule::IncludeModule("iblock")){
				$arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRODUCT");
				$arFilter = Array("IBLOCK_CODE"=>"wishlist", "PROPERTY_USER"=>$USER->GetID(),"PROPERTY_PRODUCT"=>(int)$product_id);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
				
				if($ob = $res->GetNextElement())
				{
					$arFields = $ob->GetFields();
					$elem_id = $arFields["ID"];
				}
			}
			return $elem_id;
		}
		
		function addWishlistProduct($user, $product_id, $product_name)
		{
			if(!getElemId($product_id)){
				
				if(CModule::IncludeModule("iblock")){
					$el = new CIBlockElement;
					$PROP = array();
					$PROP["USER"] = $user;
					$PROP["PRODUCT"] = $product_id;  

					$arLoadProductArray = Array(
					  "IBLOCK_ID"=>4,
					  "PROPERTY_VALUES"=> $PROP,
					  "NAME" => iconv("UTF-8","Windows-1251",$product_name),
					);

					if($PRODUCT_ID = $el->Add($arLoadProductArray))
					  echo 'all good!';
					else
					{
					  echo "Error: ".$el->LAST_ERROR;
					}
				}
			}
		}
		
		function deleteWishlistProduct($product_id)
		{
			global $DB;
			$elem_id = getElemId($product_id);

			if($elem_id){
				$DB->StartTransaction();
				if(!CIBlockElement::Delete($elem_id))
				{
					$strWarning .= 'Error!';
					$DB->Rollback();
				}
				else
				{
					$DB->Commit();
				}
			}
		}
		
		function deleteWishlistID($wishlist_id){

			global $USER;
			global $DB;
			if(CModule::IncludeModule("iblock")){
				$product = CIBlockElement::GetByID($wishlist_id);
				if($ar_res = $product->GetNext()){
					 
					if($ar_res['CREATED_BY'] == $USER->GetID()){
						$DB->StartTransaction();
						if(!CIBlockElement::Delete($wishlist_id))
						{
							$strWarning .= 'Error!';
							$DB->Rollback();
						}
						else
						{
							$DB->Commit();
						}
					}
					else{
						echo "Permission denied!";
					}
				}

			}
		}

	switch ( $_POST['action'] )
	{
		case 'add':
			addWishlistProduct($_POST['user'],$_POST['product_id'],$_POST['product_name']);
			break;
		case 'delete':
			deleteWishlistProduct($_POST['product_id']);
			break;
		case 'delete_id':
			deleteWishlistID($_POST['wishlist_id']);
			break;
	}
?>