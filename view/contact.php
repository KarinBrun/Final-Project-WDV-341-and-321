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
            <h2>Contact</h2>
        </div>
        <br>
        <form method="post" action="contactThankYou.php" id="contactForm" onsubmit="return submitContact(event)">
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" onclick="clearNameError()">
                        <label for="name">Name</label>
                        <span id="nameError" class="errorMessage"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" onclick="clearEmailError()">
                        <label for="email">Email</label>
                        <span id="emailError" class="errorMessage"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="form-floating form-input">
                        <input type="text" class="form-control" id="subject" name="subject" onclick="clearSubjectError()">
                        <label for="subject">Subject</label>
                        <span id="subjectError" class="errorMessage"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating">
                        <textarea class="form-control" id="message" name="message" placeholder="Message" style="height: 200px" onclick="clearMessageError()"></textarea>
                        <label for="message">Message</label>
                        <span id="messageError" class="errorMessage"></span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-center">
                    <button class="btn btn-primary" type="submit" id="submit" name="submit" value="Submit">Submit</button>
                    <button class="btn btn-danger" type="reset" onclick="resetErrors()">Reset</button>
                </div>
            </div>
            <br>
        </form>
    </div>

</body>
    <?php include 'footer.php';?>
</html>