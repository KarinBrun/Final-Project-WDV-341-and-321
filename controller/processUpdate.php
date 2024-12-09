<?php

session_start();    //gives us access to a session, or starts a new one if needed
if($_SESSION['validSession'] !== "yes"){
    //you are NOT a valid user and CANNOT access this page
    header('Location: ../view/index.php');
}

$recipeName = $_POST['recipeName'];
$recipeDescription = $_POST['recipeDescription'];
$recipeDifficulty = $_POST['difficultyRadio'];
$recipeTime = $_POST['recipeTime'];
$numOfPeople = $_POST['numOfPeople'];
$ingredients = $_POST['ingredients'];
$instructions = json_encode($_POST['instructions']);

$recipeID = $_GET["recipeID"];

$today = date_format(date_create(), "Y-m-d");   //creating a formatted date "YYYY-MM-DD"

$recipeDateUpdated = "";

try{
    require 'dbConnect.php';

    $sql = "UPDATE recipe SET recipeName = :recipeName, recipeDescription = :recipeDescription, recipeDifficulty = :recipeDifficulty, recipeTime = :recipeTime, numOfPeople = :numOfPeople, instructions = :instructions, recipeUpdateDate = :recipeUpdateDate WHERE recipeID = :recipeID";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":recipeName", $recipeName);
    $stmt->bindParam(":recipeDescription", $recipeDescription);
    $stmt->bindParam(":recipeDifficulty", $recipeDifficulty);
    $stmt->bindParam(":recipeTime", $recipeTime);
    $stmt->bindParam(":numOfPeople", $numOfPeople);
    $stmt->bindParam(":instructions", $instructions);
    $stmt->bindParam(":recipeUpdateDate", $today);
    $stmt->bindParam(":recipeID", $recipeID);

    $stmt->execute();

    if(count($ingredients)>0){
        $ingredientInsertSQL = "INSERT INTO ingredients(recipeID, ingredientName, ingredientQTY) VALUES (:recipeID, :ingredientName, :ingredientQTY)";
        $ingredientUpdateSQL = "UPDATE ingredients SET ingredientName = :ingredientName, ingredientQTY = :ingredientQTY WHERE ingredientID = :ingredientID";
        for($x=0;$x<count($ingredients);$x++){
            $ingredientName = $ingredients[$x]["ingredientName"];
            $ingredientQTY = $ingredients[$x]["ingredientQty"];
            $ingredientID = $ingredients[$x]["ingredientID"];
            if($ingredientID == 0){
                $ingredientStmt = $conn->prepare($ingredientInsertSQL);
    
                $ingredientStmt->bindParam(":recipeID", $recipeID);
                $ingredientStmt->bindParam(":ingredientName", $ingredientName);
                $ingredientStmt->bindParam(":ingredientQTY", $ingredientQTY);
    
                $ingredientStmt->execute();
            }
            else{
                $ingredientStmt = $conn->prepare($ingredientUpdateSQL);

                $ingredientStmt->bindParam(":ingredientName", $ingredientName);
                $ingredientStmt->bindParam(":ingredientQTY", $ingredientQTY);
                $ingredientStmt->bindParam(":ingredientID", $ingredientID);

                $ingredientStmt->execute();
            }
        }
    }

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    header('Location: ../view/error.php');
}

header('Location: ../view/adminView.php');

?>