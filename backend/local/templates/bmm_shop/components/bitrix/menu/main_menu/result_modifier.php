<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))
	return;

$arSectionsInfo = array();
if (IsModuleInstalled("iblock"))
{
	$arFilter = array(
		"TYPE" => "catalog",
		"SITE_ID" => SITE_ID,
		"ACTIVE" => "Y"
	);

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/menu"))
	{
		$arSectionsInfo = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		if (CModule::IncludeModule("iblock"))
		{
			$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
			$dbIBlock = new CIBlockResult($dbIBlock);
			$curIblockID = 0;
			if ($arIBlock = $dbIBlock->GetNext())
			{
				$dbSections = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $arIBlock["ID"]), false, array("ID", "SECTION_PAGE_URL", "PICTURE", "DESCRIPTION"));
				while($arSections = $dbSections->GetNext())
				{
					$pictureSrc = CFile::GetFileArray($arSections["PICTURE"]);

					if ($pictureSrc)
						$arResizePicture = CFile::ResizeImageGet(
							$arSections["PICTURE"],
							array("width" => 240, 'height'=>700),
							BX_RESIZE_IMAGE_PROPORTIONAL,
							true
						);

					$arSectionsInfo[crc32($arSections["SECTION_PAGE_URL"])]["PICTURE"] = $pictureSrc ? $arResizePicture["src"] : false;
					$arSectionsInfo[crc32($arSections["SECTION_PAGE_URL"])]["DESCRIPTION"] = $arSections["DESCRIPTION"];
				}
				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/iblock/menu");
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arIBlock["ID"]);
					$CACHE_MANAGER->EndTagCache();
				}
			}
		}
		$obCache->EndDataCache($arSectionsInfo);
	}
}

$arMenuItemsIDs = array();
$arAllItems = array();
$arImgDesc = array();
function print_d($ar) {
	echo '<pre>';
    print_r($ar);
    echo '</pre>';
    echo '<sc ript>console.log('.json_encode($ar).');</sc ript>';
}
foreach($arResult as $key=>$arItem)
{
	if($arItem["DEPTH_LEVEL"] > $arParams["MAX_LEVEL"])
	{
		unset($arResult[$key]);
		continue;
	}
	
	$arItem["PARAMS"]["item_id"] = crc32($arItem["LINK"]);
	if ($arItem["DEPTH_LEVEL"] == "1")
	{
		
		$arMenuItemsIDs[$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_1 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "2")
	{
		$arMenuItemsIDs[$curItemLevel_1][$arItem["PARAMS"]["item_id"]] = array();
		if ($arItem["IS_PARENT"])
		{
			$curItemLevel_2 = $arItem["PARAMS"]["item_id"];
		}
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
	elseif($arItem["DEPTH_LEVEL"] == "3")
	{
        $arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$arItem["PARAMS"]["item_id"]] = array();
        if ($arItem["IS_PARENT"])
        {
            $curItemLevel_3 = $arItem["PARAMS"]["item_id"];
        }
		$arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
	}
    elseif($arItem["DEPTH_LEVEL"] == "4")
    {
        $arMenuItemsIDs[$curItemLevel_1][$curItemLevel_2][$curItemLevel_3][] = $arItem["PARAMS"]["item_id"];
        $arAllItems[$arItem["PARAMS"]["item_id"]] = $arItem;
    }

}

$newStructure = [];
$menuStructure = [];
$id_1 = 0;
foreach($arMenuItemsIDs as $itemID => $arColumns){
	/*$newStructure[$id_1] = [
		"TITLE" => $arAllItems[$itemID]["TEXT"],
		"HREF" => is_array($arColumns) && count($arColumns) > 0 ? "#" : $arAllItems[$itemID]['LINK']
	];*/
	$menuLevel_1 = [];
	if (is_array($arColumns) && count($arColumns) > 0){

		/*$newStructure[$id_1]["CHILDREN"] = [];
		$id_2 = 0;*/
		foreach($arColumns as $item2 => $level3){
			/*$newStructure[$id_1]["CHILDREN"][$id_2] = [
				"TITLE" => $arAllItems[$item2]["TEXT"],
				"HREF" => is_array($level3) && count($level3) > 0 ? "#" : $arAllItems[$item2]['LINK']
			];*/
			$menuLevel_2 = [];
			if (is_array($level3) && count($level3) > 0){
				/*$newStructure[$id_1]["CHILDREN"][$id_2]["CHILDREN"] = [];
				$id_3 = 0;*/
				foreach($level3 as $item3 => $level4){
					/*$newStructure[$id_1]["CHILDREN"][$id_2]["CHILDREN"][$id_3] = [
						"TITLE" => $arAllItems[$item3]["TEXT"],
						"HREF" => is_array($level4) && count($level4) > 0 ? "#" : $arAllItems[$item3]['LINK']
					];*/
					$menuLevel_3 = [];
					if (is_array($level4) && count($level4) > 0){
						//$newStructure[$id_1]["CHILDREN"][$id_2]["CHILDREN"][$id_3]["CHILDREN"] = [];
						foreach($level4 as $item4){
							/*$newStructure[$id_1]["CHILDREN"][$id_2]["CHILDREN"][$id_3]["CHILDREN"][] = [
								"TITLE" => $arAllItems[$item4]["TEXT"],
								"HREF" => $arAllItems[$item4]["LINK"]
							];*/
							$menuLevel_3[] = [
								"TITLE" => $arAllItems[$item4]["TEXT"],
								"HREF" => $arAllItems[$item4]["LINK"]
							];
						}
					}
					//$id_3++;
					$menuLevel_2[] = [
						"TITLE" => $arAllItems[$item3]["TEXT"],
						"HREF" => $arAllItems[$item3]['LINK'],
						"CHILDREN" => $menuLevel_3
					];
				}
			}
			//$id_2++;
			$menuLevel_1[] = [
				"TITLE" => $arAllItems[$item2]["TEXT"],
				"HREF" => $arAllItems[$item2]['LINK'],
				"CHILDREN" => $menuLevel_2
			];
		}
	}
	$menuStructure[] = [
		"TITLE" => $arAllItems[$itemID]["TEXT"],
		"HREF" => $arAllItems[$itemID]['LINK'],
		"CHILDREN" => $menuLevel_1
	];
	//$id_1++;
}
//print_d($menuStructure);
$arResult = array();
$arResult["ALL_ITEMS"] = $arAllItems;
$arResult["ITEMS_IMG_DESC"] = $arImgDesc;
$arResult["MENU_STRUCTURE"] = $menuStructure;

