<?php

    $class = ucfirst('student');

    $properties = array('id','name', 'email','marks');

    //Class properties
    $classProperties = '';
    $length = count($properties);

    for($i=0; $i<$length;$i++){
        if($i==count($properties)-1){
            $classProperties.='$'.$properties[$i].';';
            break;
        }
        $classProperties.='$'.$properties[$i].',';
    }


    //Function parameters
    $functionParameters = '';
  

    for($i=0; $i<$length;$i++){
        if($properties[$i]!='id'){
            if($i==count($properties)-1){
                $functionParameters.='$'.$properties[$i];
                break;
            }
            $functionParameters.='$'.$properties[$i].',';
        }
        
    }


    //Constructor implementation
    $constructor = '';
    
   

    for($i=0; $i<$length;$i++){
        if($properties[$i]!='id'){
            $constructor.='$this->'.$properties[$i].'=$'.$properties[$i].';';
        }
        

    }


    //Insert parameters
    $insert_parameters = '';
    for($i=0; $i<$length;$i++){
        if($properties[$i]!='id'){
            if($i==count($properties)-1){
                $insert_parameters.=$properties[$i];
                break;
            }
            $insert_parameters.=$properties[$i].',';
        }
        

    }


    //VALUES TO INSERT
    $insert = '';
    for($i=0; $i<$length;$i++){
        if($properties[$i]!='id'){
            if($i==count($properties)-1){
                $insert.='\'$'.$properties[$i].'\'';
                break;
            }
            $insert.='\'$'.$properties[$i].'\',';
        }
        

    }



    $classTemplate = "<?php
        require_once('../db.php');\n
        class $class{\n

            public $classProperties\n

            public function __construct($functionParameters){\n

                $constructor\n

            }\n


            public function save(){
                \$sql = \"INSERT INTO $class ($insert_parameters) VALUES ($insert)\"; 
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


    if(is_dir('app/models')){
        $file_name = 'app/models/'.$class.'.php';
        $myfile = fopen($file_name, "w") or die("Unable to open file!");
        fwrite($myfile, $classTemplate);
        
        fclose($myfile);
        echo "File written";
    }else{
        if(mkdir('app/models')){
            $file_name = 'app/models/'.$class.'.php';
            $myfile = fopen($file_name, "w") or die("Unable to open file!");
            fwrite($myfile, $classTemplate);
            
            fclose($myfile);

            echo "FIle written";
        }else{
            die("Directy creation failed");
        }
    }


    






?>