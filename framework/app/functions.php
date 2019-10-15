<?php 

    //Function to create table
    function query($sql){
        echo $sql;
    }

    //Function to return column type
    function get_column_type($defined_type){


        // echo "Value is  : ".$defined_type;
        

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

?>