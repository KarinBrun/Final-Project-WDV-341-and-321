<?php

$page_number = $_GET["page_number"]??1;
$numPerPage = 6;
$offset = (($page_number - 1)* $numPerPage);


try{
    require '../controller/dbconnect.php';

    $sql = "SELECT recipeID, recipeName, recipeImage FROM recipe ORDER BY recipeID LIMIT :offset,:numPerPage";
    $sqlCount = "SELECT COUNT(*) FROM recipe";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":offset", $offset,PDO::PARAM_INT);
    $stmt->bindParam(":numPerPage", $numPerPage,PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $recipes = $stmt->fetchAll();

    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->execute();
    $recipeCount = (int) $stmtCount->fetchColumn();
}
catch(PDOException $e){
    echo $e;
    //header('Location: error.php');
}

$pageCount = (int) ($recipeCount / $numPerPage);
if($recipeCount%$numPerPage != 0){
    $pageCount += 1;
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
        <div class="cards">
            <?php 
            for($r=0;$r<count($recipes);$r++){
                echo "<div class='recipeView'>";
                echo "<br>";
                echo "<a href='recipes.php?recipeID=" . $recipes[$r]['recipeID'] . "' class='noDec'>";
                echo "<img src=' " . $recipes[$r]["recipeImage"] . "' class='recipeViewImage'>";
                echo "<p class='text-center'>" . $recipes[$r]["recipeName"] . "</p>";
                echo "</a>";
                echo "</div>";
            } ?>
        </div>
    <br>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php
                    if($page_number<=2){
                        echo "<a class='page-link' href='?page_number=1' aria-label='Previous'>";
                            echo "<span aria-hidden='true'>&laquo;</span>";
                        echo "</a>";
                    }
                    else{
                        echo "<a class='page-link' href='page_number=". ($page_number-1) ."' aria-label='Previous'>";
                            echo "<span aria-hidden='true'>&laquo;</span>";
                        echo "</a>";
                    } ?>
                </li>
                <?php
                for($p=1;$p<=$pageCount;$p++){
                    if($p == $page_number){
                        echo "<li class='page-item active'><a class='page-link' href='?page_number=". $p ."'>". $p ."</a></li>";
                    }
                    else{
                        echo "<li class='page-item'><a class='page-link' href='?page_number=". $p ."'>". $p ."</a></li>";
                    }
                } ?>
                <li class="page-item">
                    <?php
                    if($page_number>=$pageCount-1){
                        echo "<a class='page-link' href='?page_number=". $pageCount ."' aria-label='Next'>";
                            echo "<span aria-hidden='true'>&raquo;</span>";
                        echo "</a>";
                    }
                    else{
                        echo "<a class='page-link' href='?page_number=". ($page_number + 1) ."' aria-label='Next'>";
                            echo "<span aria-hidden='true'>&raquo;</span>";
                        echo "</a>";
                    }?>
                </li>
            </ul>
        </nav>

    </div>
</body>
    <?php include 'footer.php';?>
</html>