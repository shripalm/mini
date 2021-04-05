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


        // For getting single value from database
        // field is for single field
        // from is for table name
        // whereCond is for where Condition
        // limit is for limit i.e. (0,5) is similar to (limit 0,5), * is similar to all, default is 1
        public static function getSValue($field, $from, $whereCond = 1, $limit = 1){
            try{
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
    }




    error_reporting(1);
?>