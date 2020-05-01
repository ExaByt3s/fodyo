<?
global $APPLICATION;
$APPLICATION->SetAdditionalCSS("/bitrix/components/bitrix/system.pagenavigation/templates/round/style.min.css");
//$APPLICATION->SetAdditionalCSS("/bitrix/templates/demo/additional.css");
?>
<div class="bx-pagination">
    <div class="bx-pagination-container">
        <ul>
            <?if ($this->NavPageNomer > 1):?>
                <?if($arResult["bSavePage"]):?>
                    <li class="bx-pag-prev"><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer-1)?><?=$strNavQueryString?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <li class=""><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer-1)?><?=$strNavQueryString?>PAGEN_<?=$this->NavNum?>=1"><span>1</span></a></li>
                <?else:?>
                    <?if ($this->NavPageNomer > 2):?>
                        <li class="bx-pag-prev"><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer-1)?><?=$strNavQueryString?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <?else:?>
                        <li class="bx-pag-prev"><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer-1)?><?=$strNavQueryString?>"><span><?echo GetMessage("round_nav_back")?></span></a></li>
                    <?endif?>
                    <li class=""><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=1<?=$strNavQueryString?>"><span>1</span></a></li>
                    <?
                    if($this->NavPageNomer > 3){
                        ?><span class="dots">...</span><?
                    }
                    ?> 
                <?endif?>
            <?else:?>
                    <li class="bx-pag-prev"><span><?echo GetMessage("round_nav_back")?></span></li>
                    <li class="bx-active"><span>1</span></li>
            <?endif?>

            <?
            $nStartPage++;
            while($nStartPage <= $nEndPage-1):
            ?>
                <?if ($nStartPage == $this->NavPageNomer):?>
                    <li class="bx-active"><span><?=$nStartPage?></span></li>
                <?else:?>
                    <li class=""><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=$nStartPage?><?=$strNavQueryString?>"><span><?=$nStartPage?></span></a></li>
                <?endif?>
                <?$nStartPage++?>
            <?endwhile?>

            <?if($this->NavPageNomer < $this->NavPageCount):?>
                <?if($this->NavPageCount > 1):?>
                    <?if($this->NavPageCount - $this->NavPageNomer > 2):?>
                        <span class="dots">...</span>
                    <?endif?>
                    <li class=""><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=$this->NavPageCount?><?=$strNavQueryString?>"><span><?=$this->NavPageCount?></span></a></li>
                <?endif?>
                    <li class="bx-pag-next"><a href="<?=$sUrlPath?>?PAGEN_<?=$this->NavNum?>=<?=($this->NavPageNomer+1)?><?=$strNavQueryString?>"><span><?echo GetMessage("round_nav_forward")?></span></a></li>
            <?else:?>
                <?if($this->NavPageCount > 1):?>
                    <li class="bx-active"><span><?=$this->NavPageCount?></span></li>
                <?endif?>
                    <li class="bx-pag-next"><span><?echo GetMessage("round_nav_forward")?></span></li>
            <?endif?>
        </ul>
        <div style="clear:both"></div>
    </div>
</div>