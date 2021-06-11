<?
$aMenuLinks = Array(
    Array(
        "Каталог",
        "/books/",
        Array(),
        Array("FROM_IBLOCK" => $_ENV['BOOK_BLOCK_ID'], "DEPTH" => 2, "CHANGE_DEPTH" => false, "IS_PARENT"=>"1", "DEPTH_LEVEL"=>1, "FILTER"=>false),
        ""
    ),
    Array(
        "Не книги",
        "/non-books/",
        Array(),
        Array("FROM_IBLOCK" => $_ENV['NON_BOOK_BLOCK_ID'], "DEPTH" => 1, "CHANGE_DEPTH" => true, "IS_PARENT"=>"1", "DEPTH_LEVEL"=>1, "FILTER"=>true),
        ""
    ),
    Array(
        "Питание",
        "/foods/",
        Array(),
        Array("FROM_IBLOCK" => $_ENV['FOOD_BLOCK_ID'], "DEPTH" => 1, "CHANGE_DEPTH" => true, "IS_PARENT"=>"1", "DEPTH_LEVEL"=>1, "FILTER"=>true),
        ""
    ),
);
?>
