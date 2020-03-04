<?php
function currencyComma($str){
    return implode(",",preg_split("/\B(?=(\d{3})+(?!\d))/",$str));
}