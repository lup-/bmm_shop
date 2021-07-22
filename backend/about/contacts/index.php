<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задайте вопрос");
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
	<div class="row">
		<div class="col-12 col-md-6">
			<div class="contacts-block">
				<h3 class="mb-4">Интернет-магазин</h3>
 <small>Служба клиентской поддержки</small>
				<p class="mb-4">
					 +7 495 259-62-06, доб. 194
				</p>
 <small>Email</small>
				<p>
 <a href="mailto:info@bmm.ru">info@bmm.ru</a>
				</p>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="contacts-block">
				<h3 class="mb-0">Склад</h3>
 <small class="mb-4">г. Москва, Шоссе Энтузиастов, д. 56, стр. 6</small> <small>Телефон</small>
				<p class="mb-4">
					 +7 495 228-64-58, доб. 100
				</p>
 <small>Время работы</small>
				<p>
					 Пн-Пт, c 10:00 до 18:00
				</p>
			</div>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-12">
			<div class="contacts-block">
				<h3 class="mb-4">По вопросам сотрудничества</h3>
				<div class="row no-gutters">
					<div class="col-12 col-md-4">
 <small>Оптовым покупателям</small>
						<p>
 <a target="_blank" href="mailto:korshunov@ripol.ru">korshunov@ripol.ru</a><br>
						</p>
						<p>
						</p>
						<div>
							<div>
								Телефон&nbsp; +7(495)259-62-06
							</div>
						</div>
						<p>
						</p>
					</div>
					<div class="col-12 col-md-4">
 <small>Издательствам</small>
						<p>
 <a href="mailto:info@bmm.ru">info@bmm.ru</a>
						</p>
					</div>
					<div class="col-12 col-md-4">
 <small>Реклама</small>
						<p>
 <a href="mailto:info@bmm.ru">info@bmm.ru</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 </section> <section class="content-wrap">
<div class="mb-2 embed-responsive embed-responsive-16by9">
	 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.31028141404!2d37.7247964158746!3d55.75311199943562!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54aaa41cd23c3%3A0xa10b1aa777efe25b!2z0YguINCt0L3RgtGD0LfQuNCw0YHRgtC-0LIsINC0LjU2INGB0YLRgC42LCDQnNC-0YHQutCy0LAsIDExMTAyNA!5e0!3m2!1sru!2sru!4v1625139074176!5m2!1sru!2sru" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
 </section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");