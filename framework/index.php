<?php

    require_once('app/functions.php');

    require_once('app/db.php');

    if(file_exists('models.json')){
        $json = file_get_contents('models.json');
        $json = json_decode($json, true);
        $models = $json['models'];



        $number_of_tables_to_create = count($models);

        $number_of_tables_created = 0;


        //Loop for models
        foreach($models as $model){
            $name = array_keys($model)[0];
            
          

            $keys = array_keys($model[$name]);

            $query = "CREATE TABLE IF NOT EXISTS $name (";

            $query.= "id int NOT NULL AUTO_INCREMENT,";


         

            //Loop for columns
            foreach($keys as $key){
               
                $metas = array_keys($model[$name][$key]);
                $type = get_column_type($model[$name][$key]['TYPE']);
                
               

                $query.=$key.' '.$type.','; 




               
            }
            $query.= "created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";

            

            echo "Table $name is creating...<br>";
            
            if(Database::query($query)){
                echo "Table $name created";
            }else{
                echo "Table $name creation failed";
            }

            $number_of_tables_created = $number_of_tables_created + 1;


            

         


            echo "<br/>";
        }


        if($number_of_tables_to_create==$number_of_tables_created){
            echo "Table created successfully!!";
            //Generate classes
        }else{
            echo "Something went wrong";
        }
       
    }else{
        die("models.json file not found!!");
    }
   


?>