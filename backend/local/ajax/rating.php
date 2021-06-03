<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER_FIELD_MANAGER;
if(!$USER->IsAuthorized()) {
    return ;
}

$commentId = isset($_REQUEST['COMMENT_ID']) ? (int)$_REQUEST['COMMENT_ID'] : 0;
$voteValue = isset($_REQUEST['VOTE_VALUE']) ? (int)$_REQUEST['VOTE_VALUE'] : 0;

if($commentId && $voteValue){
    $GLOBALS["USER_FIELD_MANAGER"]->Update("BLOG_COMMENT", $commentId, Array ("UF_STAR_COUNT" => $voteValue));
}


$result = [
    'success' => 'ok'
];
echo json_encode($result);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>


