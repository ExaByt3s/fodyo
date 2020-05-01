</div><?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
                        ?>

        <footer class="bx-footer">
            <div style="height: 300px;width: 100%;background: #c5c4c4;"></div>
        </footer>
        <div class="col-xs-12 hidden-lg hidden-md hidden-sm">
            <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
                    "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                    "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                    "SHOW_PERSONAL_LINK" => "N",
                    "SHOW_NUM_PRODUCTS" => "Y",
                    "SHOW_TOTAL_PRICE" => "Y",
                    "SHOW_PRODUCTS" => "N",
                    "POSITION_FIXED" =>"Y",
                    "POSITION_HORIZONTAL" => "center",
                    "POSITION_VERTICAL" => "bottom",
                    "SHOW_AUTHOR" => "Y",
                    "PATH_TO_REGISTER" => SITE_DIR."login/",
                    "PATH_TO_PROFILE" => SITE_DIR."personal/"
                ),
                false,
                array()
            );?>
        </div>
     <!-- //bx-wrapper -->


<script>
    BX.ready(function(){
        var upButton = document.querySelector('[data-role="eshopUpButton"]');
        BX.bind(upButton, "click", function(){
            var windowScroll = BX.GetWindowScrollPos();
            (new BX.easing({
                duration : 500,
                start : { scroll : windowScroll.scrollTop },
                finish : { scroll : 0 },
                transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
                step : function(state){
                    window.scrollTo(0, state.scroll);
                },
                complete: function() {
                }
            })).animate();
        })
    });
    
</script>
</body>
</html>