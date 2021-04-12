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

    $keyValueSet = array(
        "field"=>array("name","discription","email","datetime"),
        "value"=>array(
            array(
                "Test",
                "Testing insertion method",
                "test@test.69hub",
                "2021-04-12 16:58:33"
            ),
            array(
                "Test2",
                "Testing insertion method2",
                "test2@test.69hub",
                "2021-04-12 16:58:34"
            )
        )
    );
    var_dump(MINI::insert("query", $keyValueSet));
    
    
    $keyValueSet = array(
        "name"=>"Testidsytfu",
        "discription"=>"Testing insertion method",
        "email"=>"test@test.69hub",
        "datetime"=>"2021-04-12 16:58:33",
        "submit"=>"Click"
    );
    $except = array("submit");
    var_dump(MINI::insertForm("query", $keyValueSet, "submit"));
?>