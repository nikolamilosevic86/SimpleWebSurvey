<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$survey_name =  htmlentities($_POST['survey_name']);
$survey_description =  htmlentities($_POST['survey_desc']);
$num_question_per_usr =  htmlentities($_POST['num_questions']);
$is_randomg =  htmlentities($_POST['random_question']);
$random = 0;
if($is_randomg==="on")
{
    $random = 1;
}
$max_num_answers =  htmlentities($_POST['sur_max_answers']);
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
$survey_name = $conn->real_escape_string($survey_name);
$survey_description = $conn->real_escape_string($survey_description);
$random = $conn->real_escape_string($random);
$max_ans = $conn->real_escape_string($max_num_answers);
$num_question_per_usr = $conn->real_escape_string($num_question_per_usr);

$sql = "INSERT INTO Survay (name, text, random,max_ans,num_of_questions_for_user)
VALUES ('".$survey_name."','".$survey_description."',".$random.",".$max_ans.",".$num_question_per_usr.");";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$id = $conn->insert_id;
echo "ID::::".$id;
$_SESSION['survey_id'] = $id;
$conn->close();

header( 'Location: QuestionMaker.html');