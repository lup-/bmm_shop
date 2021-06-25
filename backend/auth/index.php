<?
$showFooter = false;
if ($_REQUEST['ajax_mode'] == 'Y') {
   require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php";
   if ($USER->GetID()) {
      $APPLICATION->IncludeComponent("bitrix:system.auth.form", "", Array());
      echo '<br>Вы авторизовались, обновление страницы...';
      echo '<script>setTimeout(function(){ location.reload(); }, 3000);</script>';
   } else {
      $APPLICATION->AuthForm('', false, false);
   }
   die;
} elseif (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
   require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
   $APPLICATION->SetTitle("Авторизация");
   $showFooter = true;
}

CJSCore::Init(["popup", "jquery"]);
?>

<?if ($USER->IsAuthorized()):?>
    <li class="nav-item">
        <a class="nav-link" href="<?=$APPLICATION->GetCurPage()?>" rel="nofollow">Личный кабинет</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?=$APPLICATION->GetCurPage()?>?logout=yes" rel="nofollow">Выход</a>
    </li>
<?else:?>
    <?$jsAuthVariable = \Bitrix\Main\Security\Random::getString(20)?>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="<?=$jsAuthVariable?>.showPopup('/auth/')" rel="nofollow">Вход</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="<?=$jsAuthVariable?>.showPopup('/auth/?register=yes')" rel="nofollow">Регистрация</a>
    </li>
   <script>
        let <?=$jsAuthVariable?> = {
            id: "modal_auth",
            popup: null,
            convertLinks: function() {
                let links = $("#" + this.id + " a");
                links.each(function (i) {
                    $(this).attr('onclick', "<?=$jsAuthVariable?>.set('" + $(this).attr('href') + "')");
                });
                links.attr('href', '#');

                let form = $("#" + this.id + " form");
                form.attr('onsubmit', "<?=$jsAuthVariable?>.submit('" + form.attr('action') + "');return false;");
            },
            showPopup: function(url) {
                let app = this;
                this.popup = BX.PopupWindowManager.create(this.id, '', {
                    className: 'modal-shop modal-shop__login',
                    closeIcon: true,
                    autoHide: false,
                    draggable: {
                        restrict: true
                    },
                    closeByEsc: true,
                    content: this.getForm(url),
                    overlay: {
                        backgroundColor: 'black',
                        opacity: '20'
                    },
                    events: {
                        onPopupClose: function(PopupWindow) {
                            PopupWindow.destroy(); //удаление из DOM-дерева после закрытия
                        },
                        onAfterPopupShow: function (PopupWindow) {
                            app.convertLinks();
                        }
                    }
                });

                this.popup.show();
            },
            getForm: function(url) {
                let content = null;
                url += (url.includes("?") ? '&' : '?') + 'ajax_mode=Y';
                BX.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'html',
                    async: false,
                    preparePost: false,
                    start: true,
                    processData: false,
                    skipAuthCheck: true,
                    onsuccess: function(data) {
                        let html = BX.processHTML(data);
                        content = html.HTML;
                    },
                    onfailure: function(html, e) {
                        console.error('getForm onfailure html', html, e, this);
                    }
                });

                return content;
            },
            set: function(url) {
                let form = this.getForm(url);
                this.popup.setContent(form);
                this.popup.adjustPosition();
                this.convertLinks();
            },
            submit: function(url) {
                let app = this;
                let form = document.querySelector("#" + this.id + " form");
                let data = BX.ajax.prepareForm(form).data;
                data.ajax_mode = 'Y';

                BX.ajax({
                    url: url,
                    data: data,
                    method: 'POST',
                    preparePost: true,
                    dataType: 'html',
                    async: false,
                    start: true,
                    processData: true,
                    skipAuthCheck: true,
                    onsuccess: function(data) {
                        let html = BX.processHTML(data);
                        app.popup.setContent(html.HTML);
                        app.convertLinks();
                    },
                    onfailure: function(html, e) {
                        console.error('getForm onfailure html', html, e, this);
                    }
                });
            }
        };
   </script>
<?endif?>
<?if ($showFooter) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
