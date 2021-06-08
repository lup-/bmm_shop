<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 * @var array $templateData
 */

if(is_object($this->__parent))
    if($this->__parent->arResult){
        $this->__parent->arResult["VOTE_SESSION"] = $arResult["AJAX"]["SESSION_KEY"];
    }




