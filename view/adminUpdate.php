<?php

session_start();    //gives us access to a session, or starts a new one if needed
if($_SESSION['validSession'] !== "yes"){
    //you are NOT a valid user and CANNOT access this page
    header('Location: index.php');
}

$recipeID = $_GET["recipeID"];

$today = date_format(date_create(), "Y-m-d");

$recipeDateUpdated = "";

try{
    require '../controller/dbConnect.php';

    $sql = "SELECT * FROM recipe WHERE recipeID = :recipeID";
    $sqlIngredient = "SELECT * FROM ingredients WHERE recipeID = :recipeID";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":recipeID", $recipeID);

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $recipeRecord = $stmt->fetch();

    $recipeName = $recipeRecord['recipeName'];
    $recipeDescription = $recipeRecord['recipeDescription'];
    $recipeImage = $recipeRecord['recipeImage'];
    $recipeDifficulty = $recipeRecord['recipeDifficulty'];
    $recipeTime = $recipeRecord['recipeTime'];
    $numOfPeople = $recipeRecord['numOfPeople'];
    $instructions = json_decode($recipeRecord['instructions']);

    $stmt2 = $conn->prepare($sqlIngredient);
    $stmt2->bindParam(":recipeID", $recipeID);
    $stmt2->execute();
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $ingredientRecord = $stmt2->fetchAll();
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

let rowCounterIngredientUpdate = <?php echo count($ingredientRecord); ?>;
let rowCounterInstructionUpdate = <?php echo count($instructions); ?>;

function createIngredientUpdateFunc(){
    let tempObject = document.querySelector("#ingredientTemplate");
    let templateObject = tempObject.content.cloneNode(true);

    templateObject.querySelector("label[for=ingredientName]").htmlFor = "ingredientName" + rowCounterIngredientUpdate;
    templateObject.querySelector("label[for=ingredientQTY]").htmlFor = "ingredientQTY" + rowCounterIngredientUpdate;

    let nameObject = templateObject.querySelector("#ingredientName");
    let qtyObject = templateObject.querySelector("#ingredientQTY");
    let idObject = templateObject.querySelector("#ingredientID");
    nameObject.id = "ingredientName" + rowCounterIngredientUpdate;
    nameObject.name = "ingredients" + "[" + rowCounterIngredientUpdate + "]" + "[ingredientName]";
    qtyObject.id = "ingredientQTY" + rowCounterIngredientUpdate;
    qtyObject.name = "ingredients" + "[" + rowCounterIngredientUpdate + "]" + "[ingredientQty]";
    idObject.id = "ingredientID" + rowCounterIngredientUpdate;
    idObject.name = "ingredients" + "[" + rowCounterIngredientUpdate + "]" + "[ingredientID]";

    let divObject = document.querySelector(".ingredientBox");
    divObject.appendChild(templateObject);
    rowCounterIngredientUpdate += 1;
}

function createInstructionUpdateFunc(){
    let tempObject = document.querySelector("#instructionTemplate");
    let templateObject = tempObject.content.cloneNode(true);

    templateObject.querySelector("label[for=instructions]").htmlFor = "instructions" + rowCounterInstructionUpdate;

    let nameObject = templateObject.querySelector("#instructions");
    nameObject.id = "instructions" + rowCounterInstructionUpdate;

    let divObject = document.querySelector(".instructionBox");
    divObject.appendChild(templateObject);
    rowCounterInstructionUpdate += 1;
}

</script>
<body>
    <?php include 'navbar.php';?>

    <div class="container-fluid">
        <br>
        <div class="textCenter">
            <h2>Update Recipe</h2>
        </div>
        <br>
        <form method="post" enctype="multipart/form-data" action="../controller/processUpdate.php?recipeID=<?php echo $recipeID; ?>" class="formBorder">
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="recipeName" placeholder="Recipe Name" name="recipeName" value="<?php echo $recipeName; ?>">
                        <label for="recipeName">Recipe Name</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" id="recipeDesc" placeholder="Recipe Description" style="height: 100px" name="recipeDescription"><?php echo $recipeDescription; ?></textarea>
                        <label for="recipeDesc">Recipe Description</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="fileName" placeholder="File Name" disabled>
                        <label for="fileName">Image Name</label>
                    </div>
                </div>
                <div class="col">
                    <input class="form-control" type="file" name="file" id="file" accept=".jpg, .gif, .png, .svg" disabled>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label>Difficulty</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty1" value=1 <?php if($recipeDifficulty == 1){echo "checked";}?>>
                        <label class="form-check-label" for="difficulty1">Easy</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty2" value=2 <?php if($recipeDifficulty == 2){echo "checked";}?>>
                        <label class="form-check-label" for="difficulty2">Medium</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty3" value=3 <?php if($recipeDifficulty == 3){echo "checked";}?>>
                        <label class="form-check-label" for="difficulty3">Hard</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="recipeTime" placeholder="Recipe Time" name="recipeTime" value="<?php echo $recipeTime; ?>">
                        <label for="recipeTime">How long does it take to make?</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="numOfPeople" placeholder="Number of People" name="numOfPeople" value="<?php echo $numOfPeople; ?>">
                        <label for="recipeName">How many people does it serve?</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label>Ingredient</label>
                </div>
            </div>
            <div class="ingredientBox">
                <?php for($x=0;$x<count($ingredientRecord);$x++){?>
                    <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ingredientQTY<?php echo $x ?>" placeholder="Quantity" name="ingredients[<?php echo $x ?>][ingredientQty]" value="<?php echo $ingredientRecord[$x]['ingredientQTY'] ?>">
                            <label for="ingredientQTY<?php echo $x ?>">Quantity</label>
                        </div>
                    </div>    
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ingredientName<?php echo $x ?>" placeholder="Name" name="ingredients[<?php echo $x ?>][ingredientName]" value="<?php echo $ingredientRecord[$x]['ingredientName'] ?>">
                            <label for="ingredientName<?php echo $x ?>">Measurement and Name</label>
                        </div>
                    </div>
                    <input type="hidden" id="ingredientID<?php echo $x ?>" name="ingredients[<?php echo $x ?>][ingredientID]" value="<?php echo $ingredientRecord[$x]['ingredientID'] ?>">
                </div>
                <br>
                <?php
                } ?>
            </div>
            <template id="ingredientTemplate">
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="Quantity" id="ingredientQTY">
                            <label for="ingredientQTY">Quantity</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" placeholder="Name" id="ingredientName">
                            <label for="ingredientName">Measurement and Name</label>
                        </div>
                    </div>
                    <br>
                </div>
                <input type="hidden" id="ingredientID" value=0>
            </template>
            <div class="row">
                <div class="col">
                    <button class="btn btn-secondary" type="button" id="createIngredient" onclick="createIngredientUpdateFunc()">Add Ingredient</button>
                </div>
            </div>
            <br>
            <div class="instructionBox">
                <?php for($y=0;$y<count($instructions);$y++){?>
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <textarea class="form-control" id="instructions<?php echo $y ?>" placeholder="Instructions" style="height: 150px" name="instructions[]"><?php echo $instructions[$y] ?></textarea>
                            <label for="instructions<?php echo $y ?>">Instructions</label>
                        </div>
                    </div>
                </div>
                <br>
                <?php
                }?>
            </div>
            <template id="instructionTemplate">
                <div class="row">
                    <div class="col">
                    <div class="form-floating">
                            <textarea class="form-control" id="instructions" placeholder="Instructions" style="height: 150px" name="instructions[]"></textarea>
                            <label for="instructions">Instructions</label>
                        </div>
                    </div>
                </div>
                <br>
            </template>
            <div class="row">
                <div class="col">
                    <button class="btn btn-secondary" type="button" id="createInstruction" onclick="createInstructionUpdateFunc()">Add Instructions</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-center">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </div>
            <br>
        </form>
    </div>

</body>
    <?php include 'footer.php';?>
</html>