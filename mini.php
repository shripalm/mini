<?php 

    
    /**
        * @category    Optimize
        * @author      jollyDev           <jolly.devel.x@gmail.com>
        * @author      Shripal Mehta      <shripal.nextstep@gmail.com>
    */


    // configuration starts
    error_reporting(0);


    // initialize return variable
    $ret = null;
    
    
    // Database configuration
    $conn = new mysqli('localhost', 'root', '', 'shaadimuhurat_user');
    
    
    // echoing error on connection error
    if($conn->connect_errno){        
        echo "Failed to connect to MySQL: ".$conn->connect_error;
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
        public static function getSValue($field, $from, $whereCond, $limit = 1){
            try{
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
                $selector = $GLOBALS['conn']->query($qry);
                if(!$selector){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['conn']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                if(count($selector) == 0){
                    throw new Exception("No data found");
                }
                if($one == 1){
                    $GLOBALS['ret'] = $selector[0][$field];
                }
                else{
                    $GLOBALS['ret'] = $selector;
                }
            }
            catch(Exception $e){
                $GLOBALS['ret'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['ret'];
            }            
        }


        // For getting multiple value from database
        // field is array for fields | single value for *
        // from is for table name
        // whereCond is for where Condition
        // limit is for limit i.e. (0,5) is similar to (limit 0,5), * is similar to all, default is 1
        public static function getMValue($field, $from, $whereCond, $limit = 1){
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
                $selector = $GLOBALS['conn']->query($qry);
                if(!$selector){
                    throw new Exception("Query:- $qry <br/>MySQL Error:- ".$GLOBALS['conn']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                if(count($selector) == 0){
                    throw new Exception("No data found");
                }
                if($one == 1){
                    $GLOBALS['ret'] = $selector[0];
                }
                else{
                    $GLOBALS['ret'] = $selector;
                }
            }
            catch(Exception $e){
                $GLOBALS['ret'] = $e->getMessage();
            }
            finally{
                return $GLOBALS['ret'];
            } 
        }
    }
?>