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
            <h2>Submit New Recipe</h2>
        </div>
        <br>
        <form method="post" enctype="multipart/form-data" action="../controller/addRecipe.php" class="formBorder" id="recipeForm">
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="recipeName" placeholder="Recipe Name" name="recipeName">
                        <label for="recipeName">Recipe Name</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" id="recipeDesc" placeholder="Recipe Description" style="height: 100px" name="recipeDescription"></textarea>
                        <label for="recipeDesc">Recipe Description</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating form-input">
                        <input type="text" class="form-control" id="recipeMeal" placeholder="Recipe Meal" name="recipeMeal">
                        <label for="recipeMeal">Which meal is this for?</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="fileName" placeholder="File Name" name="recipeImage">
                        <label for="fileName">Image Name</label>
                    </div>
                </div>
                <div class="col">
                    <input class="form-control" type="file" name="file" id="file" accept=".jpg, .gif, .png, .svg">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <label>Difficulty</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty1" value=1>
                        <label class="form-check-label" for="difficulty1">Easy</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty2" value=2>
                        <label class="form-check-label" for="difficulty2">Medium</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="difficultyRadio" id="difficulty3" value=3>
                        <label class="form-check-label" for="difficulty3">Hard</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="recipeTime" placeholder="Recipe Time" name="recipeTime">
                        <label for="recipeTime">How long does it take to make?</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="numOfPeople" placeholder="Number of People" name="numOfPeople">
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
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ingredientQTY0" placeholder="Quantity" name="ingredients[0][ingredientQty]">
                            <label for="ingredientQTY0">Quantity</label>
                        </div>
                    </div>    
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ingredientName0" placeholder="Name" name="ingredients[0][ingredientName]">
                            <label for="ingredientName0">Measurement and Name</label>
                        </div>
                    </div>
                </div>
                <br>
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
                </div>
                <br>
            </template>
            <div class="row">
                <div class="col">
                    <button class="btn btn-secondary" type="button" id="createIngredient">Add Ingredient</button>
                </div>
            </div>
            <br>
            <div class="instructionBox">
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <textarea class="form-control" id="instructions1" placeholder="Instructions" style="height: 150px" name="instructions[]"></textarea>
                            <label for="instructions1">Instructions</label>
                        </div>
                    </div>
                </div>
                <br>
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
                    <button class="btn btn-secondary" type="button" id="createInstruction">Add Instructions</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-center">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>
            </div>
            <br>
        </form>
    </div>

</body>
    <?php include 'footer.php';?>
</html>