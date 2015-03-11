<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$id = htmlentities($_GET['id']);
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
//echo "Connected successfully";
$id = $conn->real_escape_string($id);
$sql = "SELECT name,text,random,max_ans,num_of_questions_for_user FROM Survay where id_survay=".$id;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<h1>".$row["name"]."</h1><br/>";
        echo $row["text"]."<br/>";
        $_SESSION["random"] = $row["random"];
        $_SESSION["max_ans"] = $row["max_ans"];
        $_SESSION["num_of_questions_for_user"] = $row["num_of_questions_for_user"];
    }
} else {
    echo "0 results";
}


$sql = "SELECT id_question,question_text,question_img,url,url_text,num_answers FROM Questions where id_survay=".$id." AND num_answers<".$_SESSION["max_ans"]." ORDER BY RAND() LIMIT ".$_SESSION["num_of_questions_for_user"];
$result = $conn->query($sql);
?>
<form action="submit_answers.php" method="POST">
<?php
if ($result->num_rows > 0) {
    $i = 1;
    // output data of each row
    $_SESSION["Questions"] = array();
    while($row = $result->fetch_assoc()) {
        echo $i.".".$row["question_text"]."<br/>";
        echo "<img src=".$row["question_img"]."/><br/>";
        echo $row["url_text"].":<a href=".$row["url"].">".$row["url"]."</a><br/>";
        $id_question = $row["id_question"];
        $num_answers = $row["num_answers"];
        $new_sql = "SELECT id_answer,text,num_answers,type from PotentialAnswers where id_question=".$id_question;
        $result2 = $conn->query($new_sql);
        if ($result2->num_rows > 0) {
        $i ++;
        array_push($_SESSION["Questions"], $id_question);
    // output data of each row
        while($row2 = $result2->fetch_assoc()) {

            $type = $row2["type"];
            $text = $row2["text"];
            $ans_id = $row2["id_answer"];
            $num_answers = $row2["num_answers"];
            $_SESSION["Answer"][$ans_id] = $num_answers;
            
            if(type==0)
            {
                echo "<input type='radio' name='".$id_question."' value='".$ans_id."'/>$text<br/>";
            }
        }
        }
    }
} else {
    echo "0 results";
}
?>
    <input type="submit" value="Submit"/>
</form>
    <?php
$conn->close();

