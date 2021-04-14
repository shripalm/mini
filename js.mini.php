<?php
    // print_r($_POST);
    // exit;
    require 'mini.php';

    function getFromPost($key, $returnValue, $required = false){
        if(!$returnValue){
            if ($required) {
                echo "$key is required";
                exit;
            }
        }
        return $returnValue;
    }

    $method = $_POST['method'];
    switch ($method) {
        case 'getSValue':
            
            $field = getFromPost('field', $_POST['param']['field'] ?? NULL, true);
            $from = getFromPost('from', $_POST['param']['from'] ?? NULL, true);
            $whereCond = getFromPost('whereCond', $_POST['param']['whereCond'] ?? 1, false);
            $limit = getFromPost('limit', $_POST['param']['limit'] ?? 1, false);
            
            $response = MINI::$method(field: $field, from: $from, whereCond: $whereCond, limit: $limit);
            
            break;
        
        case 'getMValue':

            $field = getFromPost('field', $_POST['param']['field'] ?? NULL, true);
            $from = getFromPost('from', $_POST['param']['from'] ?? NULL, true);
            $whereCond = getFromPost('whereCond', $_POST['param']['whereCond'] ?? 1, false);
            $limit = getFromPost('limit', $_POST['param']['limit'] ?? 1, false);
            $remove = getFromPost('remove', $_POST['param']['remove'] ?? [], false);
            $must = getFromPost('must', $_POST['param']['must'] ?? [], false);
            
            $response = MINI::$method(field: $field, from: $from, whereCond: $whereCond, limit: $limit, remove: $remove, must: $must);
            
            break;
            
        case 'insert':

            $table = getFromPost('table', $_POST['param']['table'] ?? NULL, true);
            $keyValueSet = getFromPost('keyValueSet', $_POST['param']['keyValueSet'] ?? [], true);
            
            $response = MINI::$method(table: $table, keyValueSet: $keyValueSet);
            
            break;
      
        case 'insertForm':

            $table = getFromPost('table', $_POST['param']['table'] ?? NULL, true);
            $keyValueSet = getFromPost('keyValueSet', $_POST['param']['keyValueSet'] ?? [], true);
            $except = getFromPost('except', $_POST['param']['except'] ?? [], false);
            
            $response = MINI::$method(table: $table, keyValueSet: $keyValueSet, except: $except);
            
            break;
        
        case 'update':

            $table = getFromPost('table', $_POST['param']['table'] ?? NULL, true);
            $keyValueSet = getFromPost('keyValueSet', $_POST['param']['keyValueSet'] ?? [], true);
            $whereCond = getFromPost('whereCond', $_POST['param']['whereCond'] ?? NULL, true);
            $except = getFromPost('except', $_POST['param']['except'] ?? [], false);
            
            $response = MINI::$method(table: $table, keyValueSet: $keyValueSet, whereCond: $whereCond, except: $except);
            
            break;
        
        case 'delete':

            $table = getFromPost('table', $_POST['param']['table'] ?? NULL, true);
            $whereCond = getFromPost('whereCond', $_POST['param']['whereCond'] ?? NULL, true);
            
            $response = MINI::$method(table: $table, whereCond: $whereCond);
            
            break;

        case 'query':

            $query = getFromPost('query', $_POST['param']['query'] ?? NULL, true);
            
            $response = MINI::$method(query: $query);
            
            break;
    
        case 'describe':

            $table = getFromPost('table', $_POST['param']['table'] ?? NULL, true);
            
            $response = MINI::$method(table: $table);
            
            break;
    
        default:
            $response = null;
            break;
    }
    print_r($response);
?>