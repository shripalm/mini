<pre>
<?php
    require 'mini.php';
    $fields = array(
        '*'
    );
    $must = array(
        ' sm_id',
        'id'
    );
    print_r(MINI::getSValue("person_det_id,id","login",limit: '0,2'));
    $mValue = MINI::getMValue($fields,"login",remove: 'password, id at last',limit: '*',must: $must);
    print_r($mValue);
?>