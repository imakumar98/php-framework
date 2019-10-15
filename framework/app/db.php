<?php
    //IMPORT CONFIGURATION FILE
    require_once('./config.php');


    class Database{
        
        //STATIC FUNCTION TO GET CONNECTION
        public static function get_connection(){
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if(!$connection){
                die("Database connection failed!!".mysqli_error($connection));
            }else{
                return $connection;
            }
        }


        //Static function to run query
        public static function query($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            if($result){
                return true;
            }else{
                die(mysqli_error($connection));
            }
            
        }


        //STATIC FUNCTION TO RUN INSERT QUERY
        public static function insert($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            $insert_id = mysqli_insert_id($connection);

            if(!$result){
                return false;
            }else{
                return $insert_id;
            }
        }


        //STATIC FUNCTION TO RUN SELECT QUERY
        public static function select($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            if(!$result){
                die(mysqli_error($connection));
            }else{
                return $result;
            }
        }


        //STATIC FUNCTION TO RETURN ESCAPED STRING
        public static function escaped_string($string){
            if(!empty($string)){
                $connection = self::get_connection();
                return mysqli_real_escape_string($connection, trim($string));
            }else{
                return 'Invalid Argument';
            }
        }

        //STATIC FUNCTION TO UPDATE QUERY
        public static function update($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);

            if(!$result){
                return self::get_query_error_message($sql);
            }else{
                return true;
            }
        }

         //Static function to run delete query
         public static function delete($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);

            if(!$result){
                return self::get_query_error_message($sql);
            }else{
                return true;
            }
        }


        //FUNCTION TO GET ERROR MESSAGE IF QUERY FAILED
        public static function get_query_error_message($sql){
            $connection = self::get_connection();
            return "Your Query : ". $sql. " failed due to ".mysqli_error($connection);
            
        }



        
    }





?>