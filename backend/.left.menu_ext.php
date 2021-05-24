<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$menuIndex = 0;
$aMenuLinksNew = array();

foreach ($aMenuLinks as $menuItem){
    $sect['SECTIONS'] = [];
    $sect["ELEMENT_LINKS"] = [];
    $aMenuLinksNew[$menuIndex++] = $menuItem;

    $itemParams = $menuItem[3];
  
    if($itemParams) {

        if(!CModule::IncludeModule("iblock"))
        {
            continue;
        }
        $arFilter = [
            "IBLOCK_ID" => $itemParams["FROM_IBLOCK"],
            "GLOBAL_ACTIVE"=>"Y",
            "IBLOCK_ACTIVE"=>"Y",
            "<="."DEPTH_LEVEL" => $itemParams["DEPTH"]
        ];
       
        $arOrder = [
            "left_margin"=>"asc"
        ];

        $arSelect = [
            "ID",
            "DEPTH_LEVEL",
            "NAME",
            "SECTION_PAGE_URL"
        ];

        $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
       
        while($arSection = $rsSections->GetNext())
        {
         
            $sect["SECTIONS"][] = [
                "ID" => $arSection["ID"],
                "CODE" => $arSection["CODE"],
                "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
                "~NAME" => $arSection["~NAME"],
                "~SECTION_PAGE_URL" => $arSection["~SECTION_PAGE_URL"]
            ];
            $sect["ELEMENT_LINKS"][$arSection["ID"]] = [];
        }

        $previousDepthLevel = 1;
        $isNeedChangeDepth = $itemParams["CHANGE_DEPTH"];

        foreach($sect["SECTIONS"] as $arSection)
        {
            if($arSection["CODE"] === 'books_1'){
                continue;
            }

            if($arSection["CODE"] === 'books_9'){
                $isNeedChangeDepth = true;
            }

            if($isNeedChangeDepth){
                $arSection["DEPTH_LEVEL"] += 1;
            }

            $itemIndex = $menuIndex;

            if ($menuIndex > 0)
                $aMenuLinksNew[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;

            $previousDepthLevel = $arSection["DEPTH_LEVEL"];

            $arResult["ELEMENT_LINKS"][$arSection["ID"]][] = urldecode($arSection["~SECTION_PAGE_URL"]);

            $aMenuLinksNew[$menuIndex++] = [
                htmlspecialcharsbx($arSection["~NAME"]),
                $arSection["~SECTION_PAGE_URL"],
                $arResult["ELEMENT_LINKS"][$arSection["ID"]],
                [
                    "FROM_IBLOCK" => true,
                    "IS_PARENT" => false,
                    "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"]
                ],
            ];
        }
    }
};

$aMenuLinks = $aMenuLinksNew;

?>
