<?php

$name = $_POST["name"];
$email = $_POST["email"];
$comment = $_POST["message"];
$today = date('m/d/Y');
$post = json_encode($_POST);

//honeypot
$subject = $_POST['subject'];
if($subject === ""){
    //honeypot is empty
}
else{
    die("Die Bot Die");
}


$to = "$email";
$subject = "Thank you for contacting us!";

$message = "
<html>
<head>
<title>Meal Fusion - Recipe Site</title>
</head>
<body style='font-family: Verdana, Geneva, Tahoma, sans-serif;
font-size: 18px;
color: #102542;
background-color: #FFFFFF;
text-align: center;'>
<h3>Dear $name,</h3>
        <p>
            Thank you for contacting us.
            <br>
            <br>
            Your message is the following;<br>
                $comment
            <br>
            <br>
            We will contact you soon at $email
            <br>
            <br>
            -Thank you! Meal Fusion
            <br>
            Date sent: $today
            <br>
        </p>
</body>
</html>
";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: contact@karinbrun.name' . "\r\n";
$headers .= 'Cc: kbrun86@gmail.com' . "\r\n";

if(mail($to,$subject,$message,$headers,'-fcontact@karinbrun.name')){
	//echo "A confirmation email has been sent to $email.";
}
else {
	echo "There was an error sending the confirmation email to the customer.";
}


$to2 = "contact@karinbrun.name";
$subject2 = "Meal Fusion - Contact Info";
$message2 = "
<html>
<p>Name: $name</p>
<p>Email: $email</p>
<p>Message: $comment</p>
<p>Date: $today</p>
</html>
";
$headers2 = "From : contact@karinbrun.name" . "\r\n";

if(mail($to2, $subject2, $message2, $headers2)){
    //echo "mail() processed correctly";
}
else {
    echo "ERROR - mail function had issues";
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
            <h2>Contact</h2>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h5 class="text-center">Thank you <?php echo $name; ?> for contacting us!</h5>
        <h5 class="text-center">We will get back to you soon!</h5>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>    

</body>
    <?php include 'footer.php';?>
</html>