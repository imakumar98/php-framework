<?php
        require_once('../db.php');

        class Student{


            public $id,$name,$email,$marks;


            public function __construct($name,$email,$marks){


                $this->name=$name;$this->email=$email;$this->marks=$marks;


            }



            public function save(){
                $sql = "INSERT INTO Student (name,email,marks) VALUES ('$name','$email','$marks')"; 
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