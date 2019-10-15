<?php
    require_once('app/models/Student.php');


    $student = new Student('Ashwani','imakumar98@gmail.com',23);

    $student->save();



?>