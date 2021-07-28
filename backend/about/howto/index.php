<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Как сделать заказ");
?><section class="content-wrap">
<div class="content-wrap__sidebar">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"info_menu",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "info",
		"USE_EXT" => "N"
	)
);?>
</div>
<div class="content-wrap__content">
	<h1>Как сделать заказ</h1>
 <span style="color: #231f20;">Вы можете заказать книги и не только в нашем&nbsp; интернет-магазине.<br>
 </span><br>
 <span style="color: #231f20;">Для оформления заказа:</span>
	<ol>
		<div>
			<li><span style="color: #231f20;">Добавьте понравившиеся товары в «Корзину»&nbsp;</span></li>
			<li><span style="color: #231f20;">Войдите под своим логином или зарегистрируйтесь и перейдите в «Корзину»</span></li>
			<li><span style="color: #231f20;">Нажмите на кнопку «Оформить заказ»</span></li>
			<li><span style="color: #231f20;">Введите населенный пункт&nbsp;&nbsp;</span></li>
			<li><span style="color: #231f20;">Выберите способ доставки</span></li>
			<li><span style="color: #231f20;">Внесите ваши данные</span></li>
			<li><span style="color: #231f20;">Оплатите удобным для вас способом</span></li>
			<li>Ожидайте письма с подтверждением заказа&nbsp;</li>
		</div>
	</ol>
	 Возникли дополнительные вопросы?<br>
	<p>
 <span style="color: #231f20;">Напишите нам на почту </span><span style="color: #337ab7;"><a href="mailto:zakaz@bmm.ru">zakaz@bmm.ru</a></span>
	</p>
	<p>
 <span style="color: #231f20;">Позвоните нам по телефону +7 495 259-62-06 доб. 194</span>
	</p>
	<p>
 <span style="color: #231f20;">Более подробную информацию по оплате и доставке товаров вы можете узнать в соответствующих разделах:</span>
	</p>
	<p>
	</p>
	<p>
 <a href="https://bmm.ru/about/payment/"><span style="color: #1155cc; font-weight: 700;">ОПЛАТА</span></a>
	</p>
	<p>
 <a href="https://bmm.ru/about/delivery/"><span style="color: #1155cc; font-weight: 700;">ДОСТАВКА</span></a>
	</p>
 <br>
</div>
 </section> <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>