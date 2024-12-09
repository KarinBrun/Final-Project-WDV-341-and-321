<?php

session_start();
if($_SESSION['validSession'] !== "yes"){
    header('Location: ../view/index.php');
}

$recipeID = $_GET["recipeID"];

try{
    require 'dbConnect.php';

    $sql = "DELETE FROM recipe WHERE recipeID = :recipeID";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":recipeID", $recipeID);

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    header('Location: ../view/error.php');
}

header('Location: ../view/adminView.php');

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