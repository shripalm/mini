<pre>
<?php
    require 'mini.php';
    $fields = array(
        'l.id',
        'role',
        'gender',
    );
    $must = array(
        ' sm_id',
        'id'
    );
    var_dump(MINI::getSValue("id","login",limit: '*'));
    // $mValue = MINI::getMValue($fields,"login",remove: 'password, id at last',limit: '*',must: $must);
    // $mValue = MINI::getMValue($fields,"login",whereCond: '1 GROUP BY role order BY role desc', limit: '*', remove: 'password, id at any', must: 'id, hidden');
    $mValue = MINI::getMValue($fields,"login as l JOIN personal_details as p",whereCond: 'l.person_det_id=p.id', limit: '*', remove: 'password, id at any', must: 'id, hidden');
    var_dump($mValue);
?>