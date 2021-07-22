<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("О нас");
?>
<section class="content-wrap">
    <div class="content-wrap__sidebar">
        <?$APPLICATION->IncludeComponent(    "bitrix:menu",    "info_menu",    [        "ALLOW_MULTI_SELECT" => "N",        "CHILD_MENU_TYPE" => "left",        "DELAY" => "N",        "MAX_LEVEL" => "1",        "MENU_CACHE_GET_VARS" => [""],        "MENU_CACHE_TIME" => "3600",        "MENU_CACHE_TYPE" => "N",        "MENU_CACHE_USE_GROUPS" => "Y",        "ROOT_MENU_TYPE" => "info",        "USE_EXT" => "N"    ]);?>
    </div>
    <div class="content-wrap__content">
        <h1 class="content__head">О нас</h1>
        <div class="row mb-5">
            <div class="col-12">
                В нашем магазине представлены книги более 400 издательств, среди которых «РИПОЛ классик», «Пальмира», Т8
                    Rugram, «Омега-Л», «Лениздат», «Черная речка», Издательство Пушкинского фонда и другие.
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12 col-md-6" style="font-size: 22px">
                В ассортименте вы найдете художественную и научно-популярную литературу, книги по искусству, философии,
                истории, психологии и бизнесу, биографии и книги для детей, учебники и товары для творчества, канцелярские
                принадлежности и другую продукцию.
            </div>
            <div class="col-12 col-md-6">
                Мы предлагаем книжные новинки ведущих российских издательств по доступной цене, регулярно проводим различные
                акции, участие в которых гарантирует выгодные покупки, а также помогаем определиться с выбором. На нашем
                    сайте публикуются тематические подборки, рейтинги, книжные обзоры и отзывы покупателей.
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                У нас вы можете выбрать и заказать товары в любое время суток и оформить доставку удобным способом.
                <br>
                Выбирайте лучшее!
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="list-group list-group-horizontal list-group-images">
                    <li class="list-group-item">
                        <a href="/publisher/T8%20RUGRAM/">
                            <img src="https://bmm.ru/upload/iblock/6a7/6a7b8f0b2cf66f28331beaf212c93ae1.png">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/publisher/De'Libri/">
                            <img src="https://bmm.ru/upload/iblock/e91/e91df79003a57768be8a679446eb59ca.png">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/publisher/Novoe%20nebo/">
                            <img src="https://bmm.ru/upload/iblock/27c/27c99c335dddb6fdf9ca76e784a43606.jpg">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/publisher/Omega-L/">
                            <img src="https://bmm.ru/upload/iblock/fbb/fbb6d7676e38062f92412af0245fbf2a.jpg">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/publisher/Izdatel'stvo%20Pushkinskogo%20fonda/">
                            <img src="https://bmm.ru/upload/iblock/9aa/9aa315e3fb9deea9bacf62f36d2e6e82.jpg">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/publisher/RIPOL%20klassik/">
                            <img src="https://bmm.ru/upload/iblock/e19/e191c1aca248bf83c69f1f53ae1cfabf.png">
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://bmm.ru/publisher/AJAR/">
                            <img src="https://bmm.ru/upload/iblock/d37/d3768f1082e3f69105f959c74ea8db94.png">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");