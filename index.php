<pre>
<?php
    require 'mini.php';
    $fields = array(
        '*'
    );
    $remove = array(
        'password',
        'id'
    );
    $sValue = MINI::getSValue("person_det_id","login",limit: '0,2');
    $mValue = MINI::getMValue($fields,"login",limit: "*",remove: 'password, id, id at last');
    print_r($mValue);
?>