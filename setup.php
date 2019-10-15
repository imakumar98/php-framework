<?php

    //This is the main file to generate table and classes

    
    //Import initial file
    require_once('app/init.php');


    //1. Generate tables

        if(file_exists('models.json')){
            $json = file_get_contents('models.json');
            $json = json_decode($json, true);
            $is_tables_generated = Generate::tables($json);
            if($is_tables_generated){
                echo "Yay, Tables generated successfully!!";
                return;
            }else{
                die("Table not generated");
            }
        }else{
            die("Error: 'models.json' file not found");
        }


//2. Generate classes for API CRUD Operation
//
    
 



?>
