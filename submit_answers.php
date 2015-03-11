<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$questions = $_SESSION["Questions"];
$host =  getenv('OPENSHIFT_MYSQL_DB_HOST');
$port = getenv('OPENSHIFT_MYSQL_DB_PORT');
$username = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$password = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
$socker =  getenv('OPENSHIFT_MYSQL_DB_SOCKET');
$db_name = "survey";
$conn = new mysqli($servername, $username, $password,$db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
for($i= 0; $i<sizeof($questions);$i++){
    $id =  $questions[$i];
    $sql = "SELECT id_question,question_text,question_img,url,url_text,num_answers FROM Questions where id_question=".$id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id_question = $row["id_question"];
            $num_answers = $row["num_answers"];
            $new_num_answers = $num_answers+1;
            $sql = "UPDATE Questions SET num_answers =".$new_num_answers." WHERE id_question=".$id;//"SELECT id_answer,text,num_answers,type from PotentialAnswers where id_question=".$id_question;
            $result2 = $conn->query($sql);
            $answer_id = $conn->real_escape_string($_POST[$id_question]);
            $sql = "SELECT num_answers from PotentialAnswers where id_answer=".$answer_id;
            $result3 = $conn->query($sql);
            if ($result3->num_rows > 0) {
                while($row2 = $result3->fetch_assoc()) {
                    $num_ans = $row["num_answers"];
                    $num_ans = $num_ans+1;
                    $sql = "UPDATE PotentialAnswers SET num_answers =".$num_ans." WHERE id_answer=".$answer_id;//"SELECT id_answer,text,num_answers,type from PotentialAnswers where id_question=".$id_question;
                    $result4 = $conn->query($sql);
                }
            }
        }
    }
}

    echo "<br/>Thank you for your answers!";
