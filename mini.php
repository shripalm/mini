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
                if($field = '*'){
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
        public static function getMValue($field, $from, $whereCond = 1, $limit = 1, $remove = []){
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
                if($one == 1){
                    $GLOBALS['returnData'] = $selector[0];
                }
                else{
                    $GLOBALS['returnData'] = $selector;
                }
                if(! is_array($remove)){
                    $remove = explode(',', $remove);
                }
                foreach($remove as $keyRemove => $valueRemove){
                    if($one == 1){
                        unset($GLOBALS['returnData'][trim($valueRemove)]);
                    }
                    else{
                        foreach ($GLOBALS['returnData'] as $keyReturn => $valueReturn) {
                            unset($GLOBALS['returnData'][$keyReturn][trim($valueRemove)]);
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