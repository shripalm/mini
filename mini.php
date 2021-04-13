<?php 

    
    /**
        * @category    Optimize
        * @author      jollyDev           <jolly.devel.x@gmail.com>
        * @author      Shripal Mehta      <shripal.nextstep@gmail.com>
    */

    // error_reporting(0);
    // configuration starts
    // initialize return variable
    $returnData = null;
    
    
    // Database configuration
    $connection = new mysqli('localhost', 'root', '', 'shaadimuhurat_user');
    
    
    // echoing error on connection error
    if($connection->connect_errno){
        echo "Failed to connect to MySQL: ".$connection->connect_error;
        exit;
    }
    // configuration Complete
    
    
    class MINI{
        public function __construct(){ 
            // Constructor
        }

        
        function runTimeError($mName){
            $GLOBALS['returnData'] = "Run Time Error Occured on initializing function: $mName";
        }

        // For getting single value from database
        // field is for single field
        // from is for table name
        // whereCond is for where Condition
        // limit is for limit i.e. (0,5) is similar to (limit 0,5), * is similar to all, default is 1
        public static function getSValue($field, $from, $whereCond = 1, $limit = 1){
            try{
                (new self)->runTimeError("getSValue");
                if($field == '*'){
                    throw new Exception("You can use getMValue() instead of getSValue() for (*)");
                }
                $one = 0;
                switch ($limit) {
                    case 1:
                        $one = 1;
                        $limit = null;
                        break;
                    case '*':
                        $limit = null;
                        break;
                    default:
                        $limit = "limit $limit";
                        break;
                }
                $qry = "select $field from $from where $whereCond $limit";
                $selector = $GLOBALS['connection']->query($qry);
                if(!$selector){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                if(count($selector) == 0){
                    throw new Exception("No data found");
                }
                $GLOBALS['returnData'] = null;
                if($one == 1){
                    $GLOBALS['returnData'] = $selector[0][$field];
                }
                else{
                    $GLOBALS['returnData'] = $selector;
                }
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            }            
        }


        // For getting multiple value from database
        // field is array for fields | single value for *
        // from is for table name
        // whereCond is for where Condition
        // limit is for limit i.e. (0,5) is similar to (limit 0,5), * is similar to all, default is 1
        // remove is for removing some parameters while fetching all date
        // substr at last will checks that substr at condition occurs or not
        // substr at first will checks that substr at condition occurs or not
        // substr at (any word except last,first) will checks that substr at condition occurs or not
        // must in those condition while substr at (key-word) is set and you have to fetch something important field from that condition
        public static function getMValue($field, $from, $whereCond = 1, $limit = 1, $remove = [], $must = []){
            try{
                (new self)->runTimeError("getMValue");
                if(is_array($field)){
                    $field = implode(', ', $field);
                }
                $one = 0;
                switch ($limit) {
                    case 1:
                        $one = 1;
                        $limit = null;
                        break;
                    case '*':
                        $limit = null;
                        break;
                    default:
                        $limit = "limit $limit";
                        break;
                }
                $qry = "select $field from $from where $whereCond $limit";
                $selector = $GLOBALS['connection']->query($qry);
                if(!$selector){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                if(count($selector) == 0){
                    throw new Exception("No data found");
                }
                $GLOBALS['returnData'] = null;
                if($one == 1){
                    $GLOBALS['returnData'][0] = $selector[0];
                }
                else{
                    $GLOBALS['returnData'] = $selector;
                }
                if(! is_array($remove)){
                    $remove = explode(',', $remove);
                    if(! is_array($must)){
                        $must = explode(',',$must);
                    }
                }
                $remove = array_map('trim',array_filter($remove));
                $must = array_map('trim',array_filter($must));
                foreach($remove as $keyRemove => $valueRemove){
                    if(str_contains($valueRemove, ' at ')){
                        $valueAsCommand = explode(' at ',$valueRemove);
                        switch ($valueAsCommand[1]) {
                            case 'last':
                                $operationMethod = 'str_ends_with';
                                break;
                            case 'first':
                                $operationMethod = 'str_starts_with';
                                break;
                            default:
                                $operationMethod = 'str_contains';
                                break;
                        }
                        foreach ($GLOBALS['returnData'] as $keyReturn => $valueReturn) {
                            foreach ($valueReturn as $keyCommand => $valueCommand) {
                                if($operationMethod($keyCommand,$valueAsCommand[0])){
                                    if(! in_array($keyCommand, $must)){
                                        unset($GLOBALS['returnData'][$keyReturn][$keyCommand]);
                                    }
                                }
                            }
                        }
                    }
                    else{
                        foreach ($GLOBALS['returnData'] as $keyReturn => $valueReturn) {
                            unset($GLOBALS['returnData'][$keyReturn][$valueRemove]);
                        }
                    }
                }
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }


        // $keyValueSet indicates set of keys and values...
        /*
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
        */
        public static function insert($table, $keyValueSet){
            try{
                (new self)->runTimeError("insert");
                $keySet = $valueSet = array();
                if( (!isset($keyValueSet['field'])) || (!isset($keyValueSet['value'])) || (!is_array($keyValueSet['field'])) || (!is_array($keyValueSet['value'])) ) throw new Exception("Check Your keyValueSet array..!");
                foreach ($keyValueSet['field'] as $key => $value) {
                    $keySet[] = "`".$value."`";
                }
                foreach ($keyValueSet['value'] as $key => $value) {
                    $tempValueSet = array();
                    if(!is_array($value)) throw new Exception("Check Your keyValueSet array..!");
                    foreach ($value as $keyValue => $valueValue) {
                        $tempValueSet[] = "'".$valueValue."'";
                    }
                    $valueSet[] = "(".implode(',',$tempValueSet).")";
                }
                $keySet = implode(', ',$keySet);
                $valueSet = implode(', ',$valueSet);
                $qry = "insert into $table($keySet) values $valueSet";
                $insertion = $GLOBALS['connection']->query($qry);
                if(!$insertion){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $GLOBALS['returnData'] = $GLOBALS['connection']->insert_id;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }




        // $keyValueSet indicates set of keys and values of a directly form or formate as defined
        /*
            $keyValueSet = array(
                "name"=>"Test",
                "discription"=>"Testing insertion method",
                "email"=>"test@test.69hub",
                "datetime"=>"2021-04-12 16:58:33",
                "submit"=>"Click"
            );
        */
        // $except indicates array or coma (,) saperated string of fields which are not being consider while insertion
        public static function insertForm($table, $keyValueSet, $except = []){
            try{
                (new self)->runTimeError("insertForm");
                if(!is_array($except)) {
                    $except = explode(",",$except);
                }
                foreach ($except as $key => $value) {
                    $except[$key] = trim($value);
                }
                $keySet = $valueSet = array();
                foreach ($keyValueSet as $key => $value) {
                    if(in_array($key, $except)) continue;
                    $keySet[] = "`".$key."`";
                    $valueSet[] = "'".$value."'";
                }
                $keySet = implode(', ',$keySet);
                $valueSet = implode(', ',$valueSet);
                $qry = "insert into $table($keySet) values ($valueSet)";
                $insertion = $GLOBALS['connection']->query($qry);
                if(!$insertion){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $GLOBALS['returnData'] = $GLOBALS['connection']->insert_id;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }





        // $keyValueSet indicates set of keys and values of a directly form or formate as defined
        /*
            $keyValueSet = array(
                "name"=>"Test",
                "discription"=>"Testing insertion method",
                "email"=>"test@test.69hub",
                "datetime"=>"2021-04-12 16:58:33",
                "submit"=>"Click"
            );
        */
        // $except indicates array or coma (,) saperated string of fields which are not being consider while insertion
        // $whereCond indicates condition after where keyword
        public static function update($table, $keyValueSet, $whereCond, $except = []){
            try{
                (new self)->runTimeError("update");
                if(!is_array($except)) {
                    $except = explode(",",$except);
                }
                foreach ($except as $key => $value) {
                    $except[$key] = trim($value);
                }
                $keyValueUpdate = array();
                foreach ($keyValueSet as $key => $value) {
                    if(in_array($key, $except)) continue;
                    $keyValueUpdate[] = "`".$key."`"." = "."'".$value."'";
                }
                $keyValueUpdate = implode(', ',$keyValueUpdate);
                $qry = "update $table set $keyValueUpdate where $whereCond";
                $updation = $GLOBALS['connection']->query($qry);
                if(!$updation){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $GLOBALS['returnData'] = $updation;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }




        // $whereCond indicates condition after where keyword
        public static function delete($table, $whereCond){
            try{
                (new self)->runTimeError("delete");
                $qry = "delete from $table where $whereCond";
                $deletion = $GLOBALS['connection']->query($qry);
                if(!$deletion){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $GLOBALS['returnData'] = $deletion;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }



        
        // $whereCond indicates condition after where keyword
        public static function query($query){
            try{
                (new self)->runTimeError("query");
                $qry = $query;
                $outputQuery = $GLOBALS['connection']->query($qry);
                if(!$outputQuery){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $GLOBALS['returnData'] = $outputQuery;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            } 
        }



        public static function describe($table){
            try{
                (new self)->runTimeError("describe");
                $qry = "desc $table";
                $selector = $GLOBALS['connection']->query($qry);
                if(!$selector){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['connection']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                if(count($selector) == 0){
                    throw new Exception("No data found");
                }
                $GLOBALS['returnData'] = $selector;
            }
            catch(Exception $e){
                $GLOBALS['returnData'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['returnData'];
            }
        }



    }



    error_reporting(1);
?>