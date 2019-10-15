<?php

    //This is database file for all basic database operations


    //Import database configuration file
    require_once('/opt/lampp/htdocs/framework/config.php');


    
    class Database{
        
        //Static function to get connection string
        public static function get_connection(){
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if(!$connection){
                die("Database connection failed!!".mysqli_error($connection));
            }else{
                return $connection;
            }
        }

        
        //Static function to run any query
        public static function query($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            if($result){
                return true;
            }else{
                die("Error: ".mysqli_error($connection));
            }
            
        }


        //Static function to run insert query, and will return inserted id 
        public static function insert($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            $insert_id = mysqli_insert_id($connection);
            if(!$result){
                die("Error: ".mysqli_error($connection));
            }else{
                return $insert_id;
            }
        }


        //Static function to run select query and will return results
        public static function select($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);
            if(!$result){
                die("Error: ".mysqli_error($connection));
            }else{
                return $result;
            }
        }


        //Static function to return escaped string
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
                die("Error: ".mysqli_error($connection));
            }else{
                return true;
            }
        }

         //Static function to run delete query
         public static function delete($sql){
            $connection = self::get_connection();
            $result = mysqli_query($connection, $sql);

            if(!$result){
                die("Error: ".mysqli_error($connection));
            }else{
                return true;
            }
        }




        
    }





?>