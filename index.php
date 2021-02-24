<pre>
<?php
    require_once('mini.php');
    $fields = array(
        'l_name',
        'f_namea'
    );
    $val = MINI::getMValue($fields,"personal_details","id = '".(MINI::getSValue("person_det_id","login","email = 'svrcti19@gmail.com'"))."'");
    print_r($val);
?>  