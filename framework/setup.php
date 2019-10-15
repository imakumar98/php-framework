<?php 

    //1. UPDATE DATABASE STRUCTURE
        //1.1 READ config.php AND CHECK FOR DATABASE CONNECTION
        require_once('config.php');

        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        if(!$connection){
            die("Error: Invalid Database Parameters");
        }


        //1.1 READ models.json AND CREATE TABLES USING STRUCTURE


    //2. GENERATE CLASS

    //3. PRINT SUCCESS MESSAGE 




?>