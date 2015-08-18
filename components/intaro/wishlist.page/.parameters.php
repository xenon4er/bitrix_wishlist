<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	 $arComponentParameters = array(
		"GROUPS" => array(),
		"PARAMETERS" => array(
			"TEMPLATE_FOR_DATE" => array(
				"PARENT" => "BASE",
				"NAME" => "Date",
				"TYPE" => "STRING",
				"MULTIPLE" => "N",
				"DEFAULT" => "Y-m-d",
				"REFRESH" => "Y",
			),
			"TEMPLATE_FOR_COUNT_PAGE" => array(
				"PARENT" => "BASE",
				"NAME" => "COUNT_PAGE",
				"TYPE" => "INTEGER",
				"MULTIPLE" => "N",
				"DEFAULT" => 5,
				"REFRESH" => "Y",
			),
			
		),
	);
?>