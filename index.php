<?php
    require_once('mini.php');
    echo $val = MINI::getSValue("gender","personal_details","id = '".(MINI::getSValue("person_det_id","login","email = 'svrcti19@gmail.com'"))."'");
?>