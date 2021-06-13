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
    print_r(MINI::getSValue("id","login",limit: '*'));
    
    // $mValue = MINI::getMValue($fields,"login",remove: 'password, id at last',limit: '*',must: $must);
    // $mValue = MINI::getMValue($fields,"login",whereCond: '1 GROUP BY role order BY role desc', limit: '*', remove: 'password, id at any', must: 'id, hidden');
    $mValue = MINI::getMValue($fields,"login as l JOIN personal_details as p",whereCond: 'l.person_det_id=p.id', limit: '*', remove: 'password, id at any', must: 'id, hidden');
    print_r($mValue);

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
    print_r(MINI::insert("query", $keyValueSet));
    
    
    $keyValueSet = array(
        "name"=>"Testidsytfu",
        "discription"=>"Testing insertion method test",
        "email"=>"test@test.69hub",
        "datetime"=>"2021-04-12 16:58:33",
        "submit"=>"Click"
    );
    $except = array("submit");
    $insertedId = MINI::insertForm("query", $keyValueSet, "submit");
    
    print_r($insertedId);

    $keyValueSet = array(
        "name"=>"Shripal",
        "email"=>"Shripal.nextstep@gmail.com",
        "submit"=>"Click"
    );
    $whereCond = "id=$insertedId";
    print_r(MINI::update("query", $keyValueSet, whereCond: $whereCond, except: "submit"));

    print_r(MINI::delete("query", "name='Test'"));
    
    print_r($selector = MINI::query("select *from query where $whereCond"));
    print_r(mysqli_fetch_all($selector, MYSQLI_ASSOC));
    
    
    print_r(MINI::describe("query"));
?>