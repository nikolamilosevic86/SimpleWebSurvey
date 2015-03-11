<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$question_text =  htmlentities($_POST['question_text']);
$question_image =  htmlentities($_POST['question_image']);
$help_url_text =  htmlentities($_POST['help_url_text']);
$help_url =  htmlentities($_POST['help_url']);
$num_answers =  htmlentities($_POST['num_answers']);
$_SESSION['num_answers'] = $num_answers;

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
$question_text = $conn->real_escape_string($question_text);
$question_image = $conn->real_escape_string($question_image);
$help_url_text = $conn->real_escape_string($help_url_text);
$help_url = $conn->real_escape_string($help_url);
$num_answers = $conn->real_escape_string($num_answers);
$id_survey = $_SESSION['survey_id'];

if (!filter_var($help_url, FILTER_VALIDATE_URL) === false) {
} else {
    die("$url is not a valid URL");   
}

$sql = "INSERT INTO Questions (question_text, question_img, url,url_text,id_survay)
VALUES ('".$question_text."','".$question_image."','".$help_url."','".$help_url_text."',".$id_survey.");";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$id = $conn->insert_id;
echo "ID::::".$id;
$_SESSION['question_id'] = $id;
$conn->close();
?>
<html>
    <head>
        <title>Answers maker</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Add a potential answer</h1>
        <form action="answer_creator.php" method="POST">
                <table border="0">
                    <?php 
                    for($i=0;$i<$num_answers;$i++){
                        ?>
                        <tr><td>Text:</td> <td><input name="answer_text<?php echo $i?>" id="que_text" placeholder="Enter Question Text"/></td></tr>
                    <?php } ?>
                        <tr><td></td> <td> <input name="done_question" id="submit" value="Next Question" type="submit"/></td></tr>
                        
                </table>
            </form>
    </body>
</html>

