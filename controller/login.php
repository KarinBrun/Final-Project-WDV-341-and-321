<?php

session_start();
if(isset($_SESSION['validSession']) && $_SESSION['validSession'] === "yes"){
    $validUser = true;
    $data = ['loginStatus'=> 'Success'];
    header('Content-type: application/json');
    http_response_code(200);
    $json = json_encode($data);
    echo $json;
    exit();
}
else{
    $validUser = false;
    if(isset($_POST["inUsername"]) && isset($_POST['inPassword'])){
        $inUsername = $_POST['inUsername'];
        $inPassword = $_POST['inPassword'];
        try{
            require 'dbConnect.php';

            $sql = "SELECT COUNT(*) FROM users WHERE user_username = :username AND user_password = :password";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":username", $inUsername);
            $stmt->bindParam(":password", $inPassword);

            $stmt->execute();

            $rowCount = $stmt->fetchColumn();

            if ($rowCount > 0){
                $validUser = true;
                $_SESSION['validSession'] = "yes";
                $data = ['loginStatus'=> 'Success', 'username'=> $inUsername];
                header('Content-type: application/json');
                http_response_code(200);
                $json = json_encode($data);
                echo $json;
                exit();
            }
            else{
                $validUser = false;
                $errorMsg = "Invalid username/password. Please try again";
                $_SESSION['validSession'] = "no";
                $data = ['loginStatus'=> 'Failure'];
                header('Content-type: application/json');
                http_response_code(401);
                $json = json_encode($data);
                echo $json;
                exit();
            }
        }
        catch(PDOException $e){
            $data = ['loginStatus'=> 'Error'];
            header('Content-type: application/json');
            http_response_code(500);
            $json = json_encode($data);
            echo $json;
            exit();
        }
    }
    else{
    }
}

?>