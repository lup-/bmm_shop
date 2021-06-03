<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @global array $arParams */
/** @global array $arResult */
CJSCore::Init(array("image"));

$iblockId = (isset($_REQUEST['IBLOCK_ID']) && is_string($_REQUEST['IBLOCK_ID']) ? (int)$_REQUEST['IBLOCK_ID'] : 0);
$elementId = (isset($_REQUEST['ELEMENT_ID']) && is_string($_REQUEST['ELEMENT_ID']) ? (int)$_REQUEST['ELEMENT_ID'] : 0);
$vote_session = (isset($_REQUEST['VOTE_SESSION']) && is_string($_REQUEST['VOTE_SESSION']) ? $_REQUEST['VOTE_SESSION'] : '');
$voted = (isset($_REQUEST['VOTED']) && is_string($_REQUEST['VOTED']) ? $_REQUEST['VOTED'] : '');
$imageProduct = '';
$author = '';
if($elementId){
    $elements = CIBlockElement::GetByID($elementId);
    if($product = $elements->GetNext()){
         $imageProduct = CFile::GetPath($product["PREVIEW_PICTURE"]);
         $res = CIBlockElement::GetProperty($iblockId, $elementId, "sort", "asc", array("CODE" => "AUTHOR"));
            if ($ob = $res->GetNext())
            {
                $author = $ob['VALUE'];
            }
    }
}
function GetUserField ($entity_id, $value_id, $property_id)
{
   $arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields ($entity_id, $value_id);
   return $arUF[$property_id]["VALUE"];
}
/*echo '<pre>';
print_r($voted);
echo '</pre>';*/

//echo "Рейтинг комментария: ".GetUserField ("BLOG_COMMENT", 55, "UF_STAR_COUNT");


$reviewPath = $templateFolder.'/ajax.php';
global $classDisabled;
?>
<script>
BX.ready( function(){
	if(BX.viewImageBind)
	{
		BX.viewImageBind(
			'blg-comment-<?=$arParams["ID"]?>',
			false,
			{tag:'IMG', attr: 'data-bx-image'}
		);
	}

	BX.message({'BPC_ERROR_NO_TEXT':'<?=GetMessage("BPC_ERROR_NO_TEXT")?>'});
});
</script>
<div id="blg-comment-<?=$arParams["ID"]?>">
    <?if(isset($arResult['Comments']) && count($arResult['Comments']) === 1):?>
        <input type="text" id="review_comment_id" value="<?=key($arResult['Comments'])?>">
    <?endif;?>
    <ul id="list-unstyled" class="list-unstyled">
         <?if($USER->IsAuthorized()):?>
            <li id="media_product_review_0">
                <div id="err_comment_0"></div>
                <div id="new_comment_cont_0"></div>
            </li>
        <?endif;?>
        <?if($arResult["is_ajax_post"] != "Y")
        {
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/script.php");
            include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/scripts_for_editor.php");
        }

        if($arResult["MESSAGE"] <> '')
        {
            ?>
            <div class="blog-textinfo blog-note-box">
                <div class="blog-textinfo-text">
                    <?=$arResult["MESSAGE"]?>
                </div>
            </div>
            <?
        }
        if($arResult["ERROR_MESSAGE"] <> '')
        {
            ?>
            <div class="blog-errors blog-note-box blog-note-error">
                <div class="blog-error-text" id="blg-com-err">
                    <?=$arResult["ERROR_MESSAGE"]?>
                </div>
            </div>
            <?
        }
        if($arResult["FATAL_MESSAGE"] <> '')
        {
            ?>
            <div class="blog-errors blog-note-box blog-note-error">
                <div class="blog-error-text">
                    <?=$arResult["FATAL_MESSAGE"]?>
                </div>
            </div>
            <?
        }
        else
        {
            if($arResult["imageUploadFrame"] == "Y")
            {
                ?>
                <script>
                    <?if(!empty($arResult["Image"])):?>
                        top.bxBlogImageId = top.arImagesId.push('<?=$arResult["Image"]["ID"]?>');
                        top.arImages.push('<?=CUtil::JSEscape($arResult["Image"]["SRC"])?>');
                        top.bxBlogImageIdWidth = '<?=CUtil::JSEscape($arResult["Image"]["WIDTH"])?>';
                    <?elseif($arResult["ERROR_MESSAGE"] <> ''):?>
                        top.bxBlogImageError = '<?=CUtil::JSEscape($arResult["ERROR_MESSAGE"])?>';
                    <?endif;?>
                </script>
                <?
                die();
            }
            else
            {
                $prevTab = 0;
                function ShowComment($index, $comment, $tabCount=0, $tabSize=2.5, $canModerate=false, $User=Array(), $use_captcha=false, $bCanUserComment=false, $errorComment=false, $arParams = array())
                {

                    if($comment['AUTHOR_ID'] === $User["ID"]) {

                        //$GLOBALS['classDisabled'] = 'd-none';
                    }


                    $iblockId = (isset($_REQUEST['IBLOCK_ID']) && is_string($_REQUEST['IBLOCK_ID']) ? (int)$_REQUEST['IBLOCK_ID'] : 0);
                    $elementId = (isset($_REQUEST['ELEMENT_ID']) && is_string($_REQUEST['ELEMENT_ID']) ? (int)$_REQUEST['ELEMENT_ID'] : 0);

                    $comment["urlToAuthor"] = "";
                    $comment["urlToBlog"] = "";

                    if($comment["SHOW_AS_HIDDEN"] == "Y" || $comment["PUBLISH_STATUS"] == BLOG_PUBLISH_STATUS_PUBLISH || $comment["SHOW_SCREENNED"] == "Y" || $comment["ID"] == "preview")
                    {
                            $avatarFile = $comment['BlogUser']['AVATAR_file']['SRC'];
                            $date = new DateTime($comment["DateFormated"]);
                        ?>
                        <li id="media_product_review_<?=$comment["ID"]?>" class="media product__review <?=$index > 9 ? "d-none" : ""?>" data-item="<?=$index?>">
                            <img class="mr-3" src="<?=$avatarFile?>">
                            <div class="media-body">
                                <h5 class="mt-0 mb-1">
                                    <span class="product__review_name"><?=$comment["AuthorName"]?></span>
                                    <span class="product__review_info">
                                        <span class="product__review_date"><?echo $date->format('m.d.Y')?></span>
                                        <span class="product__info_rating">
                                            <? $vote = GetUserField ("BLOG_COMMENT", $comment['ID'], "UF_STAR_COUNT");
                                                  if($vote){
                                                      for($i = 0; $i < 5; $i++){ ?>
                                                          <span class="product__info_rating_star <?= ($vote >= $i) ? "" : "product__info_rating_star-empty"?>"></span>
                                                      <?}
                                                  }
                                            ?>
                                      </span>
                                    </span>
                                </h5>
                                <p><?=$comment["TextFormated"]?></p>
                                <div id="err_comment_<?=$comment['ID']?>"></div>
                                <div id="new_comment_cont_<?=$comment['ID']?>"></div>
                            </div>
                        </li>

                        <?
                    }
                }

                function RecursiveComments($sArray, $key, $level=0, $first=false, $canModerate=false, $User, $use_captcha, $bCanUserComment, $errorComment, $arSumComments, $arParams)
                {
                    /*echo '<pre>';
                    print_r($User);
                     echo '</pre>';*/
                    if(!empty($sArray[$key]))
                    {
                        $commentArray = array_reverse($sArray[$key]);
                        foreach($commentArray as $index => $comment)
                        {

                            if(!empty($arSumComments[$comment["ID"]]))
                            {
                                $comment["CAN_EDIT"] = $arSumComments[$comment["ID"]]["CAN_EDIT"];
                                $comment["SHOW_AS_HIDDEN"] = $arSumComments[$comment["ID"]]["SHOW_AS_HIDDEN"];
                                $comment["SHOW_SCREENNED"] = $arSumComments[$comment["ID"]]["SHOW_SCREENNED"];
                                $comment["NEW"] = $arSumComments[$comment["ID"]]["NEW"];
                            }
                            ShowComment($index,$comment, $level, 2.5, $canModerate, $User, $use_captcha, $bCanUserComment, $errorComment, $arParams);
                            if($first)
                                $level=0;
                        }
                    }
                }
                ?>
                <?
                if($arResult["is_ajax_post"] != "Y")
                {
                    if($arResult["CanUserComment"])
                    {
                        $postTitle = "";
                        if($arParams["NOT_USE_COMMENT_TITLE"] != "Y")
                            $postTitle = "RE: ".CUtil::JSEscape($arResult["Post"]["TITLE"]);
                        ?>
                        <?
                        if($arResult["COMMENT_ERROR"] <> '' && mb_strlen($_POST["parentId"]) < 2
                            && intval($_POST["parentId"])==0 && intval($_POST["edit_id"]) <= 0)
                        {
                            ?>
                            <div class="blog-errors blog-note-box blog-note-error">
                                <div class="blog-error-text"><?=$arResult["COMMENT_ERROR"]?></div>
                            </div>
                            <?
                        }
                    }

                }

                $arParams["RATING"] = $arResult["RATING"];
                $arParams["component"] = $component;
                $arParams["arImages"] = $arResult["arImages"];
                if($arResult["is_ajax_post"] == "Y")
                    $arParams["is_ajax_post"] = "Y";
                RecursiveComments($arResult["CommentsResult"], $arResult["firstLevel"], 0, true, $arResult["canModerate"], $arResult["User"], $arResult["use_captcha"], $arResult["CanUserComment"], $arResult["COMMENT_ERROR"], $arResult["Comments"], $arParams);

            }
        }
        ?>
    </ul>
</div>
<?if($arResult["is_ajax_post"] != "Y"):?>
        <?
            $commentCount = count($arResult["Comments"]);
            $commentAttempts = count(array_slice($arResult["Comments"], 0, 10));
            $commentMoreShow = $commentCount > 10;
            $moreShowCount = (($commentCount / 10 + 1) == $commentAttempts && $commentCount % 10 > 0) ? ($commentCount % 10) : 10;

        ?>
        <div class="product__info_section_actions">
            <?if($commentMoreShow):?>
                <a href="javascript:void(0)" id="actions-more" class="product__info_section_actions-more" onclick="showMore()">Показать еще (<?=$moreShowCount?>)</a>
            <?endif;?>
            <div class="flex-fill"></div>
            <? if($USER->IsAuthorized()):?>
                <a class="product__info_section_actions-new <?=$classDisabled?>"   href="javascript:void(0)" onclick="addNewReview('0', <?=$arParams["ID"]?>)">
                    <?=GetMessage("B_B_MS_ADD_COMMENT")?>
                </a>
            <?endif;?>
        </div>
        <? if($USER->IsAuthorized()):?>
            <div class="modal modal-shop modal-shop__review fade" id="review-<?=$arParams["ID"]?>">
            <div class="modal-backdrop show"></div>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" onclick="closeNewReview(<?=$arParams["ID"]?>)"></button>
                    </div>
                        <div class="modal-body">
                            <h5 class="modal-title">Новый отзыв</h5>
                            <div class="modal-body__product row no-gutters">
                                <div class="col-4">
                                    <div class="modal-body__product_image">
                                        <img src="<?=$imageProduct?>">
                                    </div>

                                </div>
                                <div class="col-8">
                                    <div class="modal-body__product_name"><?=$product['NAME']?></div>
                                    <div class="modal-body__product_author"><?=$author?></div>
                                </div>
                            </div>
                            <form method="POST" name="form_review" id="review-form-<?=$arParams["ID"]?>" action="<?=$reviewPath; ?>">
                                <input type="hidden" name="act" id="act" value="add">
                                <input type="hidden" name="post" value="Y">
                                <input type="hidden" name="IBLOCK_ID" value="<?=$iblockId; ?>">
                                <input type="hidden" id="ELEMENT_ID", name="ELEMENT_ID" value="<?=$elementId; ?>">
                                 <input type="hidden" id="VOTE_SESSION", name="VOTE_SESSION" value="<?=$vote_session; ?>">
                                <?echo makeInputsFromParams($arParams["PARENT_PARAMS"]);
                                echo bitrix_sessid_post();?>
                                <div class="form-group">
                                    <label>Оцените</label>
                                    <span class="product__info_rating">
                                        <?for($i = 0; $i<5; $i++):?>
                                            <span id="rating_star_<?=$i?>" class="product__info_rating_star product__info_rating_star-empty"
                                            onclick="checkRatingStar(<?=$i?>)"
                                            ></span>
                                        <?endfor;?>
                                    </span>
                                    <input id="product_rating" name="rating_star" type="text" value="">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="REVIEW_TEXT" id="commentText" rows="3" placeholder="Ваш отзыв"></textarea>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" name="sub-post" id="post-button" class="btn btn-success" onclick="submitReviewNew(<?=$arParams["ID"]?>)" ><?=GetMessage("B_B_MS_SEND")?></button>
                        </div>
                </div>
            </div>
        </div>
        <?endif;?>
    <?endif;?>
<?


if($arResult["is_ajax_post"] == "Y")
	die();

function makeInputsFromParams($arParams, $name="PARAMS")
{
	$result = "";

	if(is_array($arParams))
	{
		foreach ($arParams as $key => $value)
		{
			if(mb_substr($key, 0, 1) != "~")
			{
				$inputName = $name.'['.$key.']';

				if(is_array($value))
					$result .= makeInputsFromParams($value, $inputName);
				else
					$result .= '<input type="hidden" name="'.$inputName.'" value="'.$value.'">'.PHP_EOL;
			}
		}
	}

	return $result;
}
?>