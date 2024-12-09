<?php

session_start();    //gives us access to a session, or starts a new one if needed
if($_SESSION['validSession'] !== "yes"){
    //you are NOT a valid user and CANNOT access this page
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Meals, Recipes, Fusion, Recipe, Breakfast, Lunch, Dinner, Brunch, Supper">
    <meta name="description" content="Meal Fusion - Recipe Site">
    <title>Meal Fusion - Recipe Site</title>
    <link rel="icon" type="image/x-icon" href="../images/icons/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="styles/style.css">
    <script src="scripts/script.js"></script>
    <script src="scripts/cookieFunctions.js"></script>

<body>

    <?php include 'navbar.php';?>

    <div class="container-fluid">
        <br>
        <div class="textCenter">
            <h2>Admin Home</h2>
            <br>
            <h5 id="welcomeMessage"></h5>
        </div>
        <br>
        <br>

        <div class="row">
            <div class="col text-center">
                <a href="adminAdd.php"><button class="btn btn-secondary">Add to Database</button></a>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col text-center">
                <a href="adminView.php"><button class="btn btn-secondary">View Database</button></a>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
    </div>

</body>
    <?php include 'footer.php';?>
</html>