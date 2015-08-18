<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?><?$APPLICATION->IncludeComponent(
	"intaro:wishlist.page",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"TEMPLATE_FOR_DATE" => "Y-m-d"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>