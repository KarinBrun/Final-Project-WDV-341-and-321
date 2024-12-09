<?php

session_start();    //gives us access to a session, or starts a new one if needed
if($_SESSION['validSession'] !== "yes"){
    //you are NOT a valid user and CANNOT access this page
    header('Location: index.php');
}

try{
    require '../controller/dbConnect.php';    //access to the database

    $sql = "SELECT recipeID, recipeName, recipeDescription FROM recipe";

    //prepared statement PDO
    $stmt = $conn->prepare($sql);   //prepared statement PDO - returns statement object

    //bind parameters - n/a

    $stmt->execute();   //execute the PDO prepared statment, save results in $stmt object

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);    //return values as an ASSOC array
}
catch(PDOException $e){
    header('Location: error.php');
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
<script>
    function confirmDelete(inRecipeID){
        //alert("inside confirmDelete() need to know the events_id" + inEventsID);
        //display a modal asking Delete this Record Y or N
        let confirmCode = confirm("To 'DELETE' this recipe, click 'OK'. If you delete this recipe you cannot recover it.")
        //if the response is Y send the eventsID to the deleteEvents.php page to be deleted
        //if N nothing
        if(confirmCode){
            //True - delete record
            //alert("Delete record");
            //?
            window.location.href="../controller/deleteRecipe.php?recipeID=" + inRecipeID;
        }
        else{
            //false - do not delete
            //alert("Save record");
        }
    }
</script>
<body>
    <?php include 'navbar.php';?>

    <div class="container-fluid">
        <br>
        <div class="textCenter">
            <h2>View Database</h2>
        </div>
        <br>
        <table class="table table-bordered">
            <tr>
                <th class='text-center table-dark'>Recipe Name</th>
                <th class='text-center table-dark'>Recipe Description</th>
            </tr>
            <tbody class="table-group-divider">
            <?php
                while($recipeRow = $stmt->fetch()){
                    echo "<tr>";
                    echo "<td class='text-center'>" . $recipeRow["recipeName"] . "</td>";
                    echo "<td class='text-center'>" . $recipeRow["recipeDescription"] . "</td>";
                    echo "<td class='text-center showDesktop'><a href='adminUpdate.php?recipeID=" . $recipeRow['recipeID'] . "'><button class='btn btn-success'>Update</button></a></td>";
                    echo "<td class='text-center showMobile'><a href='adminUpdate.php?recipeID=" . $recipeRow['recipeID'] . "'><button class='btn btn-success'><img src='../images/icons/editWhite.png' class='editSize'></button></a></td>";

                    echo "<td class='text-center showDesktop'><button class='btn btn-danger' onclick='confirmDelete(" . $recipeRow['recipeID'] . ")'>Delete</button></td>";
                    echo "<td class='text-center showMobile'><button class='btn btn-danger' onclick='confirmDelete(" . $recipeRow['recipeID'] . ")'><img src='../images/icons/deleteWhite.png' class='deleteSize'></button></td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <br>
    </div>

</body>
    <?php include 'footer.php';?>
</html>