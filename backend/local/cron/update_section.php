<?php
require_once '../../vendor/autoload.php';
require '../helper/logger.php';

use \JsonMachine\JsonMachine;

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);
define('BX_WITH_ON_AFTER_EPILOG', true);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);

CAgent::CheckAgents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true);
CEvent::CheckEvents();

CModule::IncludeModule("iblock");
CModule::IncludeModule('catalog');

$importFile = $DOCUMENT_ROOT.'/local/json/data.json';

if(!file_exists($importFile)){
    die("Файла на выгрузку товаров не существует, file = $importFile");
}
logger("Начали загрузку товаров");

function getSection($blockId, $sectionId, $sectionName) {
    $topicId = CIBlockSection::GetList([], [
        "IBLOCK_ID" => $blockId,
        'SECTION_ID' => $sectionId,
        'NAME' => $sectionName
    ])->GetNext()['ID'];

    return $topicId;
}

$offers = JsonMachine::fromFile($importFile, '/offers');
$el = new CIBlockElement;

foreach ($offers as $currentItem) {
    $idtow = $currentItem['idtow'];
    $element = CIBlockElement::GetList([], [
        'CODE' => $idtow
    ]);
    $subSectionId = false;

    if($resElement = $element->Fetch()) {
        $section = CIBlockSection::GetList([], [
            'EXTERNAL_ID' => $currentItem['type_id']
        ])->GetNext();
        $sectionId = $section['ID'];
        $blockId =  $section['IBLOCK_ID'];
        $blockCode = $section['IBLOCK_CODE'];

        $subSectionId = false;
        if($currentItem['features']['section']){
            $subSectionId = getSection($blockId, $sectionId, $currentItem['features']['section']);
        }

        if($currentItem['features']['topic']) {
            $subSectionId = getSection($blockId, $subSectionId, $currentItem['features']['topic']);
        }

        if($currentItem['features']['subtopic']) {
            $subSectionId = getSection($blockId, $subSectionId, $currentItem['features']['subtopic']);
        }
        $elementId = $resElement['ID'];
        $resultElement = $el->Update($elementId, [
            "IBLOCK_SECTION_ID" => $subSectionId ? $subSectionId : $sectionId,
        ]);
    }
}


require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/tools/backup.php");
unlink($importFile);

CMain::FinalActions();
?>
