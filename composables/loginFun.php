<?php
include "../lib/lib.php";
function login($db) {}
function auth() {}

function check ($email, $password, $db) {
    $countsql = "SELECT * FROM login WHERE password = :password AND email = :email";
    $con = $db->prepare($countsql);
    $con->bindValue(":email", $email, PDO::PARAM_STR);
    $con->bindValue(":password", $password, PDO::PARAM_STR);
    $con->execute();
    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    echo("<br>");
    $dataValue = count($data);
    
    if ($dataValue == 0) {
        header("location:/final/login.php?loginerror=1");
    } else if ($dataValue == 1) {
        echo "Přihlášení proběhlo úspěšně";
        $_SESSION['loged'] = true;
        header("location:/final/page.php");
        exit();
    } else {
        echo"jsi kkt";
    }
}

function register ($email, $password, $db) {
    $countsql = "INSERT INTO login (id, password, email) VALUES (NULL, :password, :email)";
    $con = $db->prepare($countsql);
    $con->bindValue(":email", $email, PDO::PARAM_STR);
    $con->bindValue(":password", $password, PDO::PARAM_STR);
    $con->execute();
    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    echo count($data);
    header("location:/final/login.php");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['job']) && $_POST['job'] === 'LOGIN') {
        echo "login";

        if (isset($_POST['email'], $_POST['password'], $_POST['job'])) {
            $mail = $_POST["email"];
            $pass = $_POST["password"];
            $job = $_POST["job"];

            if (empty($mail) or empty($pass)) {
                $mesage = "<p>Nevyplnil jsi email nebo heslo</p>";
                header("location:/final/login.php?message='$message'&email={$_POST['email']}");
            } else {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    echo "Email address " . $mail . " is considered valid.\n";

                    switch ($job) {
                        case "LOGIN":
                            $passwordH = hashing($pass);
                            check($mail, $passwordH, $db);
                            break;
                        case "REGISTER":
                            $pass2 = $_POST['password2'];
                            if ($pass === $pass2) {
                                $passwordH = hashing($pass);
                                register($mail, $passwordH, $db);
                                echo "register";
                            }
                            break;
                    }
                } else {
                    echo "Email address " . $mail . " is considered invalid.";
                    header("location:/final/login.php?message='invalid email'&email={$_POST['email']}");
                }
            }
        }else if (isset($_POST['job']) && $_POST['job'] === 'REGISTER') {
        echo "register";
        }
    }
}
