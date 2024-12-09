<?php

$recipeName = $_POST['recipeName'];
$recipeDescription = $_POST['recipeDescription'];
$recipeDifficulty = $_POST['difficultyRadio'];
$recipeTime = $_POST['recipeTime'];
$numOfPeople = $_POST['numOfPeople'];
$ingredients = $_POST['ingredients'];
$instructions = json_encode($_POST['instructions']);

$today = date_format(date_create(), "Y-m-d");   //creating a formatted date "YYYY-MM-DD"

$recipeInsertDate = "";       //needs a format like YYYY-MM-DD current date
$recipeUpdateDate = "";

//honeypot
$recipeMeal = $_POST['recipeMeal'];
if($recipeMeal === ""){
    //honeypot is empty
}
else{
    die("Die Bot Die");
}

try{
    require 'dbConnect.php';    //access to the database

    $hostImageFolder = "../images/recipeImages/";
    $hostImagePath = $hostImageFolder . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $hostImagePath);

    $sql = "INSERT INTO recipe (recipeName, recipeDescription, recipeImage, recipeDifficulty, recipeTime, numOfPeople, instructions, recipeInsertDate, recipeUpdateDate) VALUES (:recipeName, :recipeDescription, :recipeImage, :recipeDifficulty, :recipeTime, :numOfPeople, :instructions, :recipeInsertDate, :recipeUpdateDate)";     //named parameter

    $stmt = $conn->prepare($sql);   //prepared statement PDO - returns statement object

    //bind parameters
    $stmt->bindParam(":recipeName", $recipeName);
    $stmt->bindParam(":recipeDescription", $recipeDescription);
    $stmt->bindParam(":recipeImage", $hostImagePath);
    $stmt->bindParam(":recipeDifficulty", $recipeDifficulty);
    $stmt->bindParam(":recipeTime", $recipeTime);
    $stmt->bindParam(":numOfPeople", $numOfPeople);
    $stmt->bindParam(":instructions", $instructions);
    $stmt->bindParam(":recipeInsertDate", $today);
    $stmt->bindParam(":recipeUpdateDate", $today);


    $stmt->execute();   //execute the PDO prepared statment, save results in $stmt object

    if(count($ingredients)>0){
        $ingredientSQL = "INSERT INTO ingredients(recipeID, ingredientName, ingredientQTY) VALUES (:recipeID, :ingredientName, :ingredientQTY)";
        $last_id = $conn->lastInsertId();
        for($x=0;$x<count($ingredients);$x++){
            $ingredientName = $ingredients[$x]["ingredientName"];
            $ingredientQTY = $ingredients[$x]["ingredientQty"];
            $ingredientStmt = $conn->prepare($ingredientSQL);

            $ingredientStmt->bindParam(":recipeID", $last_id);
            $ingredientStmt->bindParam(":ingredientName", $ingredientName);
            $ingredientStmt->bindParam(":ingredientQTY", $ingredientQTY);

            $ingredientStmt->execute();
        }
    }

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);    //return values as an ASSOC array

    session_start();
    if($_SESSION['validSession'] !== "yes"){
        header('Location: ../view/index.php');
    }
    else{
        header('Location: ../view/adminSuccess.php');
    }
}
catch(PDOException $e){
    header('Location: ../view/error.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Fusion - Recipe Site</title>
    <link rel="icon" type="image/x-icon" href="../images/icons/icon.ico">
</head>
<body>
    
</body>
</html>