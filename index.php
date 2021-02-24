<pre>
<?php
    require_once('mini.php');
    $fields = array(
        '*'
    );
    $sValue = MINI::getSValue("person_det_id","login","email = 'svrcti19@gmail.com'");
    $mValue = MINI::getMValue($fields,"personal_details","1","*");
    print_r($mValue);
?>