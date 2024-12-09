<?php

$recipeID = $_GET["recipeID"];

try{
    require '../controller/dbConnect.php';

    $sql = "SELECT * FROM recipe WHERE recipeID = :recipeID";
    $sqlIngredient = "SELECT * FROM ingredients WHERE recipeID = :recipeID";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":recipeID", $recipeID);

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $recipeRecord = $stmt->fetch();

    $recipeName = json_encode($recipeRecord['recipeName']);
    $recipeDescription = json_encode($recipeRecord['recipeDescription']);
    $recipeImage = json_encode($recipeRecord['recipeImage']);
    $recipeDifficulty = json_encode($recipeRecord['recipeDifficulty']);
    $recipeTime = json_encode($recipeRecord['recipeTime']);
    $numOfPeople = json_encode($recipeRecord['numOfPeople']);
    $instructions = $recipeRecord['instructions'];

    $stmt2 = $conn->prepare($sqlIngredient);
    $stmt2->bindParam(":recipeID", $recipeID);
    $stmt2->execute();
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $ingredientRecord = $stmt2->fetchAll();

    $ingredientRecordJSON = json_encode($ingredientRecord);

    // echo json_encode($recipeRecord);
    // echo json_encode($ingredientRecord);
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
    <script src="../model/Recipe.js"></script>
    <script src="../model/Ingredient.js"></script>
    <script>

        let ingredientArray = [];
        let ingredientRecords = <?php echo $ingredientRecordJSON; ?>;

        for(i=0;i<ingredientRecords.length;i++){
            let qty = parseFloat(ingredientRecords[i].ingredientQTY);
            let ingredient = new Ingredient(ingredientRecords[i].ingredientName,qty);
            ingredientArray.push(ingredient);
        }

        let recipeNameJS = <?php echo $recipeName ?>;
        let recipeDescriptionJS = <?php echo $recipeDescription ?>;
        let recipeImageJS = <?php echo $recipeImage ?>;
        let recipeDifficultyJS = parseInt(<?php echo $recipeDifficulty ?>);
        let recipeTimeJS = <?php echo $recipeTime ?>;
        let numOfPeopleJS = <?php echo $numOfPeople ?>;
        let instructionsJS = <?php echo $instructions ?>;
        
        let recipe = new Recipe(recipeNameJS, recipeDescriptionJS, recipeImageJS, recipeDifficultyJS, recipeTimeJS, numOfPeopleJS, ingredientArray, instructionsJS);

        let JSONrecipe = JSON.stringify(recipe);
        
        deleteCookie("currentRecipe");
        setCookie("currentRecipe", JSONrecipe, 1);

        function runRecipeCard(){
            return displayRecipeCard(recipe);
        }

    </script>
<body onload="runRecipeCard()">
    <?php include 'navbar.php';?>

    <div class="container-fluid">
        <br>
        <div class="recipeDiv">

        </div>
    </div>
    <br>

</body>
    <?php include 'footer.php';?>
</html>