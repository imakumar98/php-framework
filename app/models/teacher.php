<?php
    require_once('/opt/lampp/htdocs/framework/app/lib/Database.php');

    class Teacher{

        public $name,$email;


        public function __construct($name,$email){

            $this->name=$name;$this->email=$email;

        }


        public function save(){
            $sql = "INSERT INTO teacher (name,email) VALUES ('$this->name','$this->email')"; 
            if(Database::insert($sql)){
                $response = array();
                $response['insert_id'] = 3232;
                $response['message'] = 'Student created';
                $response['status'] = 200;
                echo json_encode($response);
            }else{
                $response = array();
                $response['message'] = 'Student creation failed';
                $response['status'] = 400;
                echo json_encode($response);
            }

        }

    }


?>