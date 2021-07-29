<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?php $APPLICATION->SetDirProperty('theme','red_image');?>
<?php $APPLICATION->IncludeComponent(
    "bmm:publisher",
    ".default",
    [
        "IBLOCK_ID"  => $_ENV['PUBLISHER_BLOCK_ID'],
        "BOOK_BLOCK_ID" => $_ENV["BOOK_BLOCK_ID"],
        "SHOW_BOOKS" => "Y",
        "SET_META_TAGS" => "Y",
        "TITLE_TEMPLATE" => "Книги издательства «#NAME#»: купить с доставкой по Москве, Санкт-Петербургу и России",
        "DESCRIPTION_TEMPLATE" => "Все книги издательства #NAME# в наличии с доставкой по Москве, Санкт-Петербургу и в регионы России 🚚. В торговом доме БММ новинки #YEAR# года, цены от #MIN_PRICE# руб., в каталоге #COUNT# книг!",
        "PRICE_ID" => "1",
    ]
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
