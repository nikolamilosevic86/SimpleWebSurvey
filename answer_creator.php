<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
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
echo "Connected successfully";

$num_answers = $_SESSION['num_answers'];
$str_name = 'answer_text';

for($i=0;$i<$num_answers;$i++){
    
    $answer_text =  htmlentities($_POST[$str_name . $i]);


    $question_id = $_SESSION['question_id'];
    $survey_id = $_SESSION['survey_id'];

    $answer_text = $conn->real_escape_string($answer_text);

    $sql = "INSERT INTO PotentialAnswers (id_question, text, type)
    VALUES (".$question_id.",'".$answer_text."',0);";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
header( 'Location: QuestionMaker.html');