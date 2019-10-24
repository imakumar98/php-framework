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


        //Static function to generate classes
        public static function classes($json){
            $models = $json['models'];
            $number_of_classes_to_create = count($models);
            $number_of_classes_created = 0;

            //Loop for models
            foreach($models as $model){
                $name = array_keys($model)[0];
                $keys = array_keys($model[$name]);

                $properites_array = array();
                

                
                foreach($keys as $key){
                    array_push($properites_array, $key);
                }

                if(self::generateClass($name, $keys)){
                    $number_of_classes_created = $number_of_classes_created + 1;
                }
            }

            if($number_of_classes_to_create==$number_of_classes_created){
                return true;
                
            }else{
                return false;
            }

        }

        //Function to generate class
        public function generateClass($name, $properties){
            $classCamelCase = ucfirst($name);
            $classProperties = self::get_class_properties_string($properties);
            $functionParameters = self::get_function_parameters_string($properties);
            $constructor = self::get_constructor_string($properties);
            $insertParameters = self::get_insert_parameters_string($properties);
            $insertValues = self::get_insert_values_string($properties);
            $classTemplate = "<?php
    require_once('/opt/lampp/htdocs/framework/app/lib/Database.php');\n
    class $classCamelCase{\n
        public $classProperties\n

        public function __construct($functionParameters){\n
            $constructor\n
        }\n

        public function save(){
            \$sql = \"INSERT INTO $name ($insertParameters) VALUES ($insertValues)\"; 
            if(Database::insert(\$sql)){
                \$response = array();
                \$response['insert_id'] = 3232;
                \$response['message'] = 'Student created';
                \$response['status'] = 200;
                echo json_encode(\$response);
            }else{
                \$response = array();
                \$response['message'] = 'Student creation failed';
                \$response['status'] = 400;
                echo json_encode(\$response);
            }

        }

    }\n

?>";
            
            //Copy file
            if(is_dir('/opt/lampp/htdocs/framework/app/models')){
                $file_name = '/opt/lampp/htdocs/framework/app/models/'.$name.'.php';
                $myfile = fopen($file_name, "w") or die("Unable to open file!");
                fwrite($myfile, $classTemplate);
                
                fclose($myfile);
                echo "File written";
            }else{
                if(mkdir('/opt/lampp/htdocs/framework/app/models')){
                    $file_name = '/opt/lampp/htdocs/framework/app/models/'.$name.'.php';
                    $myfile = fopen($file_name, "w") or die("Unable to open file!");
                    fwrite($myfile, $classTemplate);
                    
                    fclose($myfile);
        
                    echo "File written";
                }else{
                    die("Directy creation failed");
                }
            }



            //End of copy file
        }


        public function get_insert_values_string($properties){
            $insertValues = '';
            $length = count($properties);
            for($i=0; $i<$length;$i++){
                if($properties[$i]!='id'){
                    if($i==count($properties)-1){
                        $insertValues.='\'$this->'.$properties[$i].'\'';
                        break;
                    }
                    $insertValues.='\'$this->'.$properties[$i].'\',';
                }
                
        
            }
            return $insertValues;
        }

        //Function to return insert parameters string
        public function get_insert_parameters_string($properties){
            $insert_parameters = '';
            $length = count($properties);
            for($i=0; $i<$length;$i++){
                if($properties[$i]!='id'){
                    if($i==count($properties)-1){
                        $insert_parameters.=$properties[$i];
                        break;
                    }
                    $insert_parameters.=$properties[$i].',';
                }
            }
            return $insert_parameters;
        }

        //Function to return constructor string
        public function get_constructor_string($properties){
            $constructor = '';
            $length = count($properties);
            for($i=0; $i<$length;$i++){
                if($properties[$i]!='id'){
                    $constructor.='$this->'.$properties[$i].'=$'.$properties[$i].';';
                }
            }
            return $constructor;
        }

        //Function to return function parameters string
        public function get_function_parameters_string($properties){
            $functionParameters = '';
            $length = count($properties);
            for($i=0; $i<$length;$i++){
                if($properties[$i]!='id'){
                    if($i==count($properties)-1){
                        $functionParameters.='$'.$properties[$i];
                        break;
                    }
                    $functionParameters.='$'.$properties[$i].',';
                }
            }
            return $functionParameters;
        }

        //Function to return class properies
        public function get_class_properties_string($properties){
            $classProperties = '';
            $length = count($properties);

            for($i=0; $i<$length;$i++){
                if($i==count($properties)-1){
                    $classProperties.='$'.$properties[$i].';';
                    break;
                }
                $classProperties.='$'.$properties[$i].',';
            }
            return $classProperties;
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