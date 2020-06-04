
        </div>
    </div>
    <?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $exploUri = explode('?', $_SERVER['REQUEST_URI']);
    $exploDir = explode('/', $exploUri[0]);
    /*if($exploDir[count($exploDir) - 1] != '' && ERROR_404 != 'Y'){
        header("HTTP/1.1 301 Moved Permanently"); 
        header("Location: ".$exploUri[0].'/'); 
        exit();
    }*/
    
    ?>


    <div class="background-opacity"></div>

    <div class="form-application popup-form">
        <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="form">
            <div class="title"><?=GetMessage('TITLE_APPLICATION')?></div>
            <div class="inputs">
                <input type="text" name="name" placeholder="<?=GetMessage('NAME_PLACEHOLDER')?>*">
                <input type="text" name="phone" placeholder="<?=GetMessage('PHONE_PLACEHOLDER')?>*">
                <div class="checkboxAgrementBlockInPopup">
                    <input type="checkbox" id="idCheckboxInPopup" onchange="funcOnchangeCheckboxInPopup()">
                    <div class="agreement">
                        <?=GetMessage('SENDING_TEXT')?>
                        <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                    </div>
                </div>
                <div class="checkboxPolicyBlockInPopup">
                    <input type="checkbox" id="idCheckboxPolicyInPopup" onchange="funcOnchangeCheckboxInPopup()">
                    <div class="agreement">
                        <?=GetMessage('SENDING_TEXT2')?>
                        <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT2')?></a>
                    </div>
                </div>
                <!--<div class="agreement"><?=GetMessage('SENDING_TEXT')?>
                    <a href="/agreement/" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                </div>

            -->
                <div class="flex-row">
                    <a href="javascript:void(0)" id="hrefButtonPopupForm" class="form-submit" data-form="callback"><?=GetMessage('SEND_APPLICATION')?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="request-quote popup-form">
        <div class="close"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="form">
            <div class="title"><?=GetMessage('TITLE_QUOTE')?></div>
            <div class="inputs">
                <input type="text" name="name" placeholder="<?=GetMessage('NAME_PLACEHOLDER')?>*">
                <input type="text" name="phone" placeholder="<?=GetMessage('PHONE_PLACEHOLDER')?>*">
                <input type="hidden" name="bank">
                <div class="agreement"><?=GetMessage('SENDING_TEXT')?>
                    <a href="/agreement/" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                </div>
                <div class="flex-row">
                    <a href="javascript:void(0)" class="quote-submit" data-form="callback"><?=GetMessage('SEND_APPLICATION')?></a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bx-footer-black">
        <div class="max-width">
            <div class="flex-row">
                <div class="company">
                    <span class="footer-title"><?=GetMessage('COMPANY_TITLE')?></span>
                    <?$APPLICATION->IncludeComponent(
    "bitrix:menu", 
    "template1", 
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "bottom",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MENU_CACHE_TIME" => "3600000",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "bottom",
        "USE_EXT" => "N",
        "COMPONENT_TEMPLATE" => "template1"
    ),
    false
);?>
                </div>
                <div class="help">
                    <span class="footer-title"><?=GetMessage('HELP_TITLE')?></span>
                    <?$APPLICATION->IncludeComponent(
    "bitrix:menu", 
    "template1", 
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "bottom2",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MENU_CACHE_TIME" => "36000000",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "bottom2",
        "USE_EXT" => "N",
        "COMPONENT_TEMPLATE" => "template1"
    ),
    false
);?>
                </div>
                <?
                if(LANGUAGE_ID == 'en'){
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list", 
                        "footer-tree-usa", 
                        array(
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COUNT_ELEMENTS" => "Y",
                            "FILTER_NAME" => "sectionsFilter",
                            "IBLOCK_ID" => "4",
                            "IBLOCK_TYPE" => "catalog",
                            "SECTION_CODE" => "",
                            "SECTION_FIELDS" => array(
                                0 => "",
                                1 => "",
                            ),
                            "SECTION_ID" => "37",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(
                                0 => "UF_TOP_DEVELOPER",
                                1 => "UF_IS_PAGE",
                                2 => "",
                            ),
                            "SHOW_PARENT_NAME" => "Y",
                            "TOP_DEPTH" => "1",
                            "VIEW_MODE" => "LINE",
                            "COMPONENT_TEMPLATE" => "footer-tree-usa"
                        ),
                        false
                    );
                }
                $APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list", 
    "footer-tree-countries", 
    array(
        "ADD_SECTIONS_CHAIN" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "COUNT_ELEMENTS" => "Y",
        "FILTER_NAME" => "sectionsFilter",
        "IBLOCK_ID" => "4",
        "IBLOCK_TYPE" => "catalog",
        "SECTION_CODE" => "",
        "SECTION_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SECTION_ID" => "745",
        "SECTION_URL" => "",
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "UF_TOP_DEVELOPER",
            2 => "UF_SHOW_MAIN_LIST",
            3 => "UF_IS_PAGE",
            4 => "UF_NAME_RU",
            5 => "UF_RELATED_CATEGS",
            6 => "UF_RELATED_ARTICLES",
            7 => "UF_TEXT_PREVIEW_EN",
            8 => "UF_TEXT_PREVIEW_RU",
            9 => "UF_DESCRIPTION_RU",
            10 => "UF_LANGUAGES_SHOWN",
            11 => "UF_FLAG",
            12 => "UF_HREF_ISO",
            13 => "",
        ),
        "SHOW_PARENT_NAME" => "Y",
        "TOP_DEPTH" => "1",
        "VIEW_MODE" => "LINE",
        "COMPONENT_TEMPLATE" => "footer-tree-countries"
    ),
    false
);           
                ?>
                <div class="payments">
                    <span class="footer-title"><?=GetMessage('PAYMENT_METHODS')?></span>
                    <div class="payment-block">
                        <div class="flex-payments">
                            <div class="row">
                                <img data-src="<?=SITE_TEMPLATE_PATH?>/images/visa-new.jpg" class="lozad" style="margin-right: 20px;margin-bottom: 20px;width:69px;border-radius: 5px;">
                                <img data-src="<?=SITE_TEMPLATE_PATH?>/images/master-new.jpg" class="lozad" style="margin-bottom: 20px;width:69px;border-radius: 5px;">
                            </div>
                            <div class="row">
                                <img data-src="<?=SITE_TEMPLATE_PATH?>/images/electron-new.jpg" class="lozad" style="width:69px;margin-right: 20px;border-radius: 5px;">
                                <img data-src="<?=SITE_TEMPLATE_PATH?>/images/paypal-new.jpg" class="lozad" style="width:69px;border-radius: 5px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="callback">
                    <span class="footer-title"><?=GetMessage('CALL_BACK')?></span>
                    <div class="form">
                        <input type="text" name="phone" placeholder="<?=GetMessage('PHONE')?>*">
                        <button disabled="disabled" class="confirm-callback"><?=GetMessage('CALL_ME')?></button>
                        <div class="checkboxAgrementBlockInFooter">
                            <input type="checkbox" id="idCheckboxInFooter" onchange="funcOnchangeCheckboxInFooter()">
                            <div class="white">
                                <?=GetMessage('SENDING_TEXT')?>
                                <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT')?></a>
                            </div>
                        </div>
                        <div class="checkboxPolicyBlockInFooter">
                            <input type="checkbox" id="idCheckboxPolicyInFooter" onchange="funcOnchangeCheckboxInFooter()">
                            <div class="white">
                                <?=GetMessage('SENDING_TEXT2')?>
                                <a href="<?=GetMessage('HREF_POLICY')?>" class="agreement-link" target="_blank"><?=GetMessage('AGREEMENT_TEXT2')?></a>
                            </div>
                        </div>
                    </div>
                    <div class="social-icons">
                        <a target="_blank" href="https://web.facebook.com/FodyoWorld"><img width="30px;" src="<?=SITE_TEMPLATE_PATH?>/images/facebook.jpg" style="border-radius: 10px;"></a>
                        <a target="_blank" href="https://www.instagram.com/fodyoworld/"><img width="30px;" src="<?=SITE_TEMPLATE_PATH?>/images/instagram-icon.jpg" style="border-radius: 10px;"></a>
                    </div>
                    <div class="age-terms"><b>13+</b></div>
                </div>
            </div>
            <div class="copyright-text">
                Copyright © <?=date('Y')?> fodyo.com. All rights reserved.
            </div>
        </div>
    </footer>
     <!-- //bx-wrapper -->  

    <script defer src="/bitrix/templates/23/js/mmenu/mmenu.js"></script>

<script defer>
BX.ready(function () {
    var g = document.querySelector('[data-role="eshopUpButton"]');
    BX.bind(g, "click", function () {
        var e = BX.GetWindowScrollPos();
        new BX.easing({
            duration: 500,
            start: { scroll: e.scrollTop },
            finish: { scroll: 0 },
            transition: BX.easing.makeEaseOut(BX.easing.transitions.quart),
            step: function (e) {
                window.scrollTo(0, e.scroll);
            },
            complete: function () {},
        }).animate();
    });
});
function getMaxWidth(g) {
    var e = 0;
    g.each(function () {
        $(this).width() > e && (e = $(this).width());
    });
    return e;
}
$(document).ready(function () {
    function g() {
        var a = ++p;
        l.on("keyup", function (a) {
            a.preventDefault();
            return !1;
        });
        var b = $(".input-search input").val(),
            c = {},
            f = 0;
        $(".checkbox-new input").each(function () {
            f += 1;
            this.checked && (c[this.getAttribute("name")] || (c[this.getAttribute("name")] = {}), (c[this.getAttribute("name")][f] = $(this).next().html()));
        });
        var d = $('.filter input[name="PRICE_FROM"]').val() + "-_-" + $('.filter input[name="PRICE_TO"]').val(),
            h = $('.filter input[name="SQUARE_AREA_FROM"]').val() + "-_-" + $('.filter input[name="SQUARE_AREA_TO"]').val();
        json = JSON.stringify(c);
        $.ajax({
            type: "POST",
            dataType: "html",
            url:
                "<?=SITE_TEMPLATE_PATH?>/ajax/new_filter_ajax.php?search_query=" +
                b +
                "&PRICE_ARR=" +
                d +
                "&SQUARE_ARR=" +
                h +
                "&SECTION_ID=" +
                n +
                "&action=getItems&json=" +
                json +
                "&LANGUAGE_ID=<?=LANGUAGE_ID?>&CURDIR=" +
                encodeURIComponent("<?=$APPLICATION->GetCurDir()?>"),
            success: function (b) {
                if (a === p) {
                    0 == $(".search-result").length && $(".input-search").append('<div class="search-result"></div>');
                    $("div.search-result").html(b);
                    $("div.search-result").addClass("opened");
                    b = "/ru//search/?q=" + $(".input-search input").val() + "&PRICE_ARR=" + d + "&json=" + json + "&SQUARE_ARR=" + h;
                    var c = $('input[name="whatToUseInSearch"]').val();
                    "this_one_category" == c || "this_one_product" == c || "get_an_parent_to_decide" == c
                        ? (b = $('input[name="whatToUseInSearch"]').attr("data-new-href") + "&json=" + json + "&PRICE_ARR=" + d + "&SQUARE_ARR=" + h)
                        : "first_from_list" == c && (b = $(".search-result .search-results .result-item").first().find("a").attr("href") + "&json=" + json + "&PRICE_ARR=" + d + "&SQUARE_ARR=" + h);
                    $(".results").attr("href", b);
                    $(".results_num").html($('input[name="whatToUseInSearch"]').attr("data-products-count"));
                    l.on("keyup", function (a) {
                        if (13 == ("number" === typeof a.which ? a.which : a.keyCode)) {
                            a = "/ru//search/?q=" + $(".input-search input").val() + "&sectionId=" + n + "&json=" + json + "&PRICE_ARR=" + d + "&SQUARE_ARR=" + h;
                            var b = $('input[name="whatToUseInSearch"]').val();
                            "this_one_category" == b || "this_one_product" == b || "get_an_parent_to_decide" == b
                                ? (a = $('input[name="whatToUseInSearch"]').attr("data-new-href") + "&json=" + json + "&PRICE_ARR=" + d + "&SQUARE_ARR=" + h)
                                : "first_from_list" == b && (a = $(".search-result .search-results .result-item").first().find("a").attr("href") + "&json=" + json + "&PRICE_ARR=" + d + "&SQUARE_ARR=" + h);
                            console.log(a);
                            window.location.href = a;
                        }
                        clearTimeout(k);
                        k = setTimeout(g, 250);
                    });
                }
            },
        });
    }
    function e(a) {
        $(".flex-filter .filter-item .opened").each(function () {
            $(this).html() != a.html() && ($(this).removeClass("opened"), $(this).addClass("closed"), $(this).parents(".activ-filter").removeClass("activ-filter"));
        });
    }
    function m() {
        $(".sku-filter .checkbox").attr("disabled", !0);
        var a = $(".input input").val();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?=SITE_TEMPLATE_PATH?>/ajax/ajax.php?flats-filter=" + flatFilter + "&SECTION_ID=" + n + "&delivered-filter=" + deliveredFilter + "&search=" + a,
            success: function (a) {
                $(".catalog-section").html(a);
                $(".flats-checkboxes .checkbox").attr("disabled", !1);
                $(".bx-pagination ").css("display", "none");
                lozad().observe();
            },
        });
    }
    $(".mobile-button-hide-filter").click(function () {
        $(".flex-filter").removeClass("opened");
    });
    $(".mobile-button-show-filter").click(function () {
        $(".flex-filter").addClass("opened");
    });
    var q = $("a.newFancy");
    $("a.tryFancy").on("click", function (a) {
        a.preventDefault();
        a = +$(this).parents(".picture-slider").slick("getSlick").slideCount;
        var b = +$(this).parents(".item-slide").data("slick-index");
        console.log(b);
        switch (!0) {
            case 0 > b:
                a += b;
                break;
            case b >= a:
                a = b % a;
                break;
            default:
                a = b;
        }
        $.fancybox.open(q, {}, a);
        return !1;
    });
    var k,
        l = $('.filter input[type="text"]'),
        p = 0,
        n = $(".flex-filter").attr("data-section-id");
    l.on("keyup", function (a) {
        clearTimeout(k);
        k = setTimeout(g, 250);
    });
    l.on("keydown", function () {
        clearTimeout(k);
    });
    $(".checkbox-new input").change(function () {
        clearTimeout(k);
        k = setTimeout(g, 250);
    });
    $(".flex-filter .opener").click(function () {
        var a = $(this).parent().find(".selector");
        if (0 < a.length) {
            if (a.hasClass("opened")) a.addClass("closed"), a.removeClass("opened"), $(this).parent().removeClass("activ-filter");
            else {
                a.addClass("opened");
                $(this).parent().addClass("activ-filter");
                a.removeClass("closed");
                a.width(1e3);
                checkboxes = a.find(".checkbox-new");
                var b = getMaxWidth(checkboxes);
                a.width(b);
            }
            e(a);
        }
        a = $(this).parent().find(".numerics");
        0 < a.length &&
            (a.hasClass("opened") ? (a.addClass("closed"), a.removeClass("opened"), $(this).parent().removeClass("activ-filter")) : (a.addClass("opened"), $(this).parent().addClass("activ-filter"), a.removeClass("closed")), e(a));
    });
    $(".background-opacity").click(function () {
        $(".popup-form").css("display", "none");
        $(".background-opacity").css("display", "none");
    });
    $(".close .fa").click(function () {
        $(".popup-form").css("display", "none");
        $(".background-opacity").css("display", "none");
    });
    $(".top-menu-btn").click(function () {
        var a = $(".form-application").width();
        a = document.body.clientWidth / 2 - (a + 40) / 2 + "px";
        $(".form-application").css("left", a);
        $(".form-application").css("display", "block");
        $(".background-opacity").css("display", "block");
    });
    $("div.flex-banks div.item-bank").click(function () {
        var a = $(".form-application").width();
        a = document.body.clientWidth / 2 - (a + 40) / 2 + "px";
        $(".form-application").css("left", a);
        $(".form-application").css("display", "block");
        $(".background-opacity").css("display", "block");
    });
    $(".button-column.form-bank").click(function () {
        //$(".request-quote.popup-form").css("display", "block");
        //$(".background-opacity").css("display", "block");
        var a = $(".form-application").width();
        a = document.body.clientWidth / 2 - (a + 40) / 2 + "px";
        $(".form-application").css("left", a);
        $(".form-application").css("display", "block");
        $(".background-opacity").css("display", "block");
        $(".request-quote.popup-form").find('input[name="bank"]').val($(this).attr("data-bank"));
        console.log($(this).attr("data-bank"));
    });
    $(".flex-filter .flats-checkboxes .checkbox").click(function () {
        $(this).hasClass("active-filter") ? $(this).removeClass("active-filter") : $(this).addClass("active-filter");
        m();
    });
    $(".flex-filter .delivered-checkboxes .checkbox").click(function () {
        $(this).hasClass("active-filter") ? $(this).removeClass("active-filter") : $(this).addClass("active-filter");
        m();
    });
    $(".input input").blur(function () {
        m();
    });
    $(".sku-filter .checkbox").click(function () {
        if ($(this).hasClass("active-filter")) {
            $(this).removeClass("active-filter");
            var a = "all-flats";
            0 < $(".sku-filter .checkbox.study.active-filter").length && (a += ";study");
            0 < $(".sku-filter .checkbox.1-room.active-filter").length && (a += ";1-room");
            0 < $(".sku-filter .checkbox.2-room.active-filter").length && (a += ";2-room");
            0 < $(".sku-filter .checkbox.3-room.active-filter").length && (a += ";3-room");
            0 < $(".sku-filter .checkbox.4-room.active-filter").length && (a += ";4-room");
            $(".sku-filter .checkbox").attr("disabled", !0);
            $.ajax({
                type: "POST",
                url: window.location.pathname + "?sku-preview=Y&item=" + a,
                success: function (a) {
                    $(".table.sku-items").html($($.parseHTML(a)).find(".table.sku-items").html());
                    $(".sku-filter .checkbox").attr("disabled", !1);
                    $(".bx-pagination ").css("display", "none");
                    $(".table.sku-items .bx-pagination").css("display", "block");
                },
            });
        } else
            $(this).addClass("active-filter"),
                (a = "all-flats"),
                0 < $(".sku-filter .checkbox.study.active-filter").length && (a += ";study"),
                0 < $(".sku-filter .checkbox.1-room.active-filter").length && (a += ";1-room"),
                0 < $(".sku-filter .checkbox.2-room.active-filter").length && (a += ";2-room"),
                0 < $(".sku-filter .checkbox.3-room.active-filter").length && (a += ";3-room"),
                0 < $(".sku-filter .checkbox.4-room.active-filter").length && (a += ";4-room"),
                $(".sku-filter .checkbox").attr("disabled", !0),
                $.ajax({
                    type: "POST",
                    url: window.location.pathname + "?sku-preview=Y&item=" + a,
                    success: function (a) {
                        $(".table.sku-items").html($($.parseHTML(a)).find(".table.sku-items").html());
                        $(".sku-filter .checkbox").attr("disabled", !1);
                        $(".table .open-item").click(function () {
                            "none" == $(this).next(".open-block").css("display") ? $(this).next(".open-block").css("display", "flex") : $(this).next(".open-block").css("display", "none");
                        });
                    },
                });
    });
    $(".quote-submit").click(function () {
        var a = $(this).parent().parent(),
            b = a.find('input[name="name"]').val(),
            c = a.find('input[name="phone"]').val(),
            f = a.find('input[name="bank"]').val();
        "" == c
            ? (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').focus())
            : (a.find('input[name="phone"]').css("border-color", "gray"),
              $.ajax({
                  type: "POST",
                  dataType: "html",
                  url: "<?=SITE_TEMPLATE_PATH?>/ajax/ajax_quote_send.php?name=" + b + "&phone=" + c + "&bankname=" + f,
                  success: function (b) {
                      "Success" != b
                          ? (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').val(""), a.find('input[name="phone"]').focus(), a.find('input[name="phone"]').attr("placeholder", b))
                          : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                  },
              }));
    });
    $(".price-filter-main .inputstyles").click(function () {
        $(".price-filter-main .inputs-price").hasClass("opened") ? $(".price-filter-main .inputs-price").removeClass("opened") : $(".price-filter-main .inputs-price").addClass("opened");
    });
    $('.price-filter-main .inputs-price input[name="price-from"]').on("input", function () {
        var a = "<?=GetMessage('PRICE_FROM')?> " + $('.price-filter-main .inputs-price input[name="price-from"]').val();
        void 0 != $('.price-filter-main .inputs-price input[name="price-to"]').val() &&
            "" != $('.price-filter-main .inputs-price input[name="price-to"]').val() &&
            (a += " - <?=GetMessage('PRICE_TO')?> " + $('.price-filter-main .inputs-price input[name="price-to"]').val());
        $(".price-filter-main .inputstyles").html(a);
    });
    $('.price-filter-main .inputs-price input[name="price-to"]').on("input", function () {
        var a = "";
        void 0 != $('.price-filter-main .inputs-price input[name="price-from"]').val() &&
            "" != $('.price-filter-main .inputs-price input[name="price-from"]').val() &&
            (a += "<?=GetMessage('PRICE_FROM')?> " + $('.price-filter-main .inputs-price input[name="price-from"]').val() + " - ");
        a += "<?=GetMessage('PRICE_TO')?> " + $('.price-filter-main .inputs-price input[name="price-to"]').val();
        $(".price-filter-main .inputstyles").html(a);
    });
    $(".form-submit:not(#contact-form-submit)").click(function () {
        console.log("not contact-form-submit");
        var a = $(this).parent().parent(),
            b = a.find('input[name="name"]').val(),
            c = a.find('input[name="phone"]').val();
        "" == c
            ? (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').focus())
            : (a.find('input[name="phone"]').css("border-color", "gray"),
              $.ajax({
                  type: "POST",
                  dataType: "html",
                  url: "https://fodyo.com/ajax_user_country.php",
                  success: function (f) {
                      "RU" == f
                          ? $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: "https://fodyo.ru/ajax_form_send.php?name=" + b + "&phone=" + c + "&CURDIR=<?=$APPLICATION->GetCurDir()?>",
                                success: function (b) {
                                    "Success" != b
                                        ? (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').val(""), a.find('input[name="phone"]').focus(), a.find('input[name="phone"]').attr("placeholder", b))
                                        : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                                },
                            })
                          : $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: "<?=SITE_TEMPLATE_PATH?>/ajax/ajax_form_send.php?name=" + b + "&phone=" + c + "&CURDIR=<?=$APPLICATION->GetCurDir()?>",
                                success: function (b) {
                                    "Success" != b
                                        ? (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').val(""), a.find('input[name="phone"]').focus(), a.find('input[name="phone"]').attr("placeholder", b))
                                        : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                                },
                            });
                  },
              }));
    });
    $(".captchaImg").click(function () {
        $(this).attr("src", "<?=SITE_TEMPLATE_PATH?>/ajax/captcha.php");
    });
    $("#contact-form-submit").click(function () {
        console.log("contact-form-submit");
        var a = $(this).parent().parent(),
            b = a.find('input[name="name"]').val(),
            c = a.find('input[name="phone"]').val(),
            f = a.find("textarea").val(),
            d = a.find('input[name="captcha"]').val();
        "" == c && (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').focus());
        "" == d && (a.find('input[name="captcha"]').css("border-color", "red"), a.find('input[name="captcha"]').focus());
        "" != c &&
            "" != d &&
            (a.find('input[name="phone"]').css("border-color", "gray"),
            a.find('input[name="captcha"]').css("border-color", "gray"),
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?=SITE_TEMPLATE_PATH?>/ajax/ajax_contact_send.php?name=" + b + "&phone=" + c + "&text=" + f + "&captcha=" + d,
                success: function (b) {
                    "Success" != b
                        ? "captchaError" == b
                            ? (a.find('input[name="captcha"]').css("border-color", "red"),
                              a.find('input[name="captcha"]').val(""),
                              a.find('input[name="captcha"]').focus(),
                              a.find('input[name="captcha"]').attr("placeholder", '<?=GetMessage("WRONG_CAPTCHA")?>'))
                            : (a.find('input[name="phone"]').css("border-color", "red"), a.find('input[name="phone"]').val(""), a.find('input[name="phone"]').focus(), a.find('input[name="phone"]').attr("placeholder", b))
                        : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                },
            }));
    });
    $(".form-close").click(function () {
        $(".confirm-window").fadeOut();
    });
    $(".confirm-callback").click(function () {
        console.log("confirm-callback");
        var a = $(this).parent(),
            b = a.find('input[name="phone"]').val();
        "" == b
            ? (a.find('input[name="phone"]').css("box-shadow", "0 0px 10px rgba(224, 24, 24, 0.25), 0 10px 10px rgba(230, 40, 40, 0.22)"), a.find('input[name="phone"]').focus())
            : (a.find('input[name="phone"]').css("box-shadow", "none"),
              $.ajax({
                  type: "POST",
                  dataType: "html",
                  url: "https://fodyo.com/ajax_user_country.php",
                  success: function (c) {
                      "RU" == c
                          ? $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: "https://fodyo.ru/ajax_form_send.php?phone=" + b + "&CURDIR=<?=$APPLICATION->GetCurDir()?>",
                                success: function (b) {
                                    "Success" != b
                                        ? (a.find('input[name="phone"]').css("box-shadow", "0 0px 10px rgba(224, 24, 24, 0.25), 0 10px 10px rgba(230, 40, 40, 0.22)"),
                                          a.find('input[name="phone"]').val(""),
                                          a.find('input[name="phone"]').focus(),
                                          a.find('input[name="phone"]').attr("placeholder", b))
                                        : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                                },
                            })
                          : $.ajax({
                                type: "POST",
                                dataType: "html",
                                url: "<?=SITE_TEMPLATE_PATH?>/ajax/ajax_form_send.php?phone=" + b + "&CURDIR=<?=$APPLICATION->GetCurDir()?>",
                                success: function (b) {
                                    "Success" != b
                                        ? (a.find('input[name="phone"]').css("box-shadow", "0 0px 10px rgba(224, 24, 24, 0.25), 0 10px 10px rgba(230, 40, 40, 0.22)"),
                                          a.find('input[name="phone"]').val(""),
                                          a.find('input[name="phone"]').focus(),
                                          a.find('input[name="phone"]').attr("placeholder", b))
                                        : ($(".popup-form").css("display", "none"), $(".background-opacity").css("display", "none"), $(".confirm-callback-result").css("display", "flex").hide().fadeIn());
                                },
                            });
                  },
              }));
    });
    $('select[name="city-region"]').change(function () {});
    $(".table .open-item").click(function () {
        "none" == $(this).next(".open-block").css("display") ? $(this).next(".open-block").css("display", "flex") : $(this).next(".open-block").css("display", "none");
    });
    $(".confirm-search").click(function () {
        if ($('select[name="city-region"] option:selected').attr("data-href")) {
            var a = $('select[name="city-region"] option:selected').attr("data-href");
            res = a;
            $('select[name="type"] option:selected').attr("data-type") && (res = a.replace("developments", $('select[name="type"] option:selected').attr("data-type")));
            window.location.replace(res);
        } else $('select[name="type"] option:selected').attr("data-type") && ((a = "/" + $('select[name="type"] option:selected').attr("data-type")), window.location.replace(a));
    });
    $(".reviews .control-left").click(function () {
        0 < $(".slides-reviews .active-slide").prev().length
            ? ($(".slides-reviews .active-slide").prev().css({ display: "block" }),
              $(".slides-reviews .active-slide").prev().animate({ opacity: "1" }, 600),
              $(".slides-reviews .active-slide").css({ display: "none", opacity: "0" }),
              $(".slides-reviews .active-slide").prev().addClass("active-slide-change"))
            : ($(".slides-reviews .slide-item-reviews").last().css({ display: "block" }),
              $(".slides-reviews .slide-item-reviews").last().animate({ opacity: "1" }, 600),
              $(".slides-reviews .active-slide").css({ display: "none", opacity: "0" }),
              $(".slides-reviews .slide-item-reviews").last().addClass("active-slide-change"));
        $(".slides-reviews .active-slide").removeClass("active-slide");
        $(".slides-reviews .active-slide-change").addClass("active-slide");
        $(".slides-reviews .active-slide-change").removeClass("active-slide-change");
    });
    $(".reviews .control-right").click(function () {
        0 < $(".slides-reviews .active-slide").next().length
            ? ($(".slides-reviews .active-slide").next().css({ display: "block" }),
              $(".slides-reviews .active-slide").next().animate({ opacity: "1" }, 600),
              $(".slides-reviews .active-slide").css({ display: "none", opacity: "0" }),
              $(".slides-reviews .active-slide").next().addClass("active-slide-change"))
            : ($(".slides-reviews .slide-item-reviews").first().css({ display: "block" }),
              $(".slides-reviews .slide-item-reviews").first().animate({ opacity: "1" }, 600),
              $(".slides-reviews .active-slide").css({ display: "none", opacity: "0" }),
              $(".slides-reviews .slide-item-reviews").first().addClass("active-slide-change"));
        $(".slides-reviews .active-slide").removeClass("active-slide");
        $(".slides-reviews .active-slide-change").addClass("active-slide");
        $(".slides-reviews .active-slide-change").removeClass("active-slide-change");
    });
    $(".picture-slider").slick({
        infinite: !1,
        slidesToShow: 3,
        slidesToScroll: 1,
        centerPadding: "60px",
        variableWidth: !0,
        prevArrow: '<button type="button" class="slick-prev"><img src="/bitrix/templates/23/images/arrow.png"></button>',
        nextArrow: '<button type="button" class="slick-next"><img src="/bitrix/templates/23/images/arrow.png"></button>',
        responsive: [{ breakpoint: 650, settings: { centerMode: !0 } }],
    });
    1170 > $(document).width() &&
        ($(".items-news.flex-row").slick({
            infinite: !0,
            slidesToShow: 1,
            slidesToScroll: 1,
            centerPadding: "60px",
            prevArrow: '<div class="control-left"><i class="fa fa-angle-left"></i></div>',
            nextArrow: '<div class="control-right"><i class="fa fa-angle-right"></i></div>',
            responsive: [{ breakpoint: 650, settings: { slidesToShow: 1 } }],
        }),
        $(".carousel-mobile .flex-row").slick({
            infinite: !0,
            slidesToShow: 1,
            slidesToScroll: 1,
            centerPadding: "60px",
            prevArrow: '<div class="control-left"><i class="fa fa-angle-left"></i></div>',
            nextArrow: '<div class="control-right"><i class="fa fa-angle-right"></i></div>',
            responsive: [{ breakpoint: 650, settings: { slidesToShow: 1 } }],
        }));
    window.onresize = function (a) {
        1170 > $(document).width()
            ? ($(".items-news.flex-row").slick({
                  infinite: !0,
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  centerPadding: "60px",
                  prevArrow: '<div class="control-left"><i class="fa fa-angle-left"></i></div>',
                  nextArrow: '<div class="control-right"><i class="fa fa-angle-right"></i></div>',
                  responsive: [{ breakpoint: 650, settings: { slidesToShow: 1 } }],
              }),
              $(".carousel-mobile .flex-row").slick({
                  infinite: !0,
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  centerPadding: "60px",
                  prevArrow: '<div class="control-left"><i class="fa fa-angle-left"></i></div>',
                  nextArrow: '<div class="control-right"><i class="fa fa-angle-right"></i></div>',
                  responsive: [{ breakpoint: 650, settings: { slidesToShow: 1 } }],
              }))
            : $(".items-news.flex-row").hasClass("slick-initialized") && ($(".items-news.flex-row").slick("unslick"), $(".items-preview-product.flex-row").slick("unslick"));
    };
    new Mmenu(document.querySelector("#mobile-menu"));
});
</script>

<script  data-skip-moving="true" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
    <script>
        const observer = lozad(); // lazy loads elements with default selector as '.lozad'
        observer.observe();
    </script>
    <!-- Yandex.Metrika counter --> 
    <script data-skip-moving="true">
        $(document).ready(function(){
                setTimeout(() => {
                    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(56851084, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true });
        }, 1000)
        });
    </script>
    <script data-skip-moving="true" defer async>  </script> <noscript><div><img src="https://mc.yandex.ru/watch/56851084" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script data-skip-moving="true" defer async src="https://www.googletagmanager.com/gtag/js?id=UA-155094331-1"></script>
    <script data-skip-moving="true" defer>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-155094331-1');
    </script>
</div>

<div class="confirm-callback-result rgb-back confirm-window">
    <div class="text-form">
        <div class="form-close"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="text-for-form"><?=GetMessage('CONFIRM_CALLBACK_TEXT')?></div>
    </div>
</div>

</body>
</html>