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
        public static function getSValue($field, $from, $whereCond){
            try{
                $selector = $GLOBALS['conn']->query("select $field from $from where $whereCond");
                if(!$selector){
                    throw new Exception($GLOBALS['conn']->error);
                }
                $selector = mysqli_fetch_all($selector, MYSQLI_ASSOC);
                $GLOBALS['ret'] = $selector[0][$field];
            }
            catch(Exception $e){
                $GLOBALS['ret'] = "MySQL Error: ".$e->getMessage();
            }
            finally{
                return $GLOBALS['ret'];
            }            
        }


        // For getting multiple value from database
        // field is array for fields
        // from is for table name
        // whereCond is for where Condition
        public static function getMValue($field, $from, $whereCond){

        }
    }
?>