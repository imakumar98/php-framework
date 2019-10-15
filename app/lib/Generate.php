<?php

    //This file contains basic functions related to generate


    //Import Database File
    require_once('Database.php');

    
    class Generate{

        public static function tables($json){

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
                    $type = self::get_column_type($model[$name][$key]['TYPE']);
                    $query.=$key.' '.$type.','; 
                }
                $query.= "created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id));";
                echo "Generating table $name...";
                if(Database::query($query)){
                    echo "Generated table $name";
                }else{
                    echo "Table $name creation failed";
                }
                $number_of_tables_created = $number_of_tables_created + 1;
            }

            if($number_of_tables_to_create==$number_of_tables_created){
                return true;
                
            }else{
                return false;
            }

        }


        //Function to return column type
        public function get_column_type($defined_type){
            if($defined_type=="INTEGER"){
                return 'INT';
            }else if($defined_type=="STRING"){
                return 'VARCHAR(255)';
            }else if($defined_type=="TIMESTAMP"){
                return 'TIMESTAMP';
            }else{
                die('Invalid Defined type');
        
            }
        }
    }




?>