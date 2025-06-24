<?php 
require('connection.php');
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location: login.php');
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit-btn'])){
    $errors = array();

    // Validare nume
    if (empty($_POST["nume"])) {
        $errors[] = "Numele este obligatoriu";
    } else {
        $nume = validare($_POST["nume"]);
        // Verificam daca acest camp contine doar litere si spatiu si are cel mult 15 simboluri
        if (!preg_match("/^[A-zА-я]{2,14}(-[A-zА-я]{2,14})?$/",$nume)) {
            $errors[] = "Trebuie introduse doar litere, liniuta - maxim 15 simboluri. Prima litera mare!";
        }
    }

    // Validare email
    if (empty($_POST["email"])) {
        $errors[] = "Emailul este obligatoriu";
    } else {
        $email = validare($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresa de email nu este validă";
        }
    }

    // Validare numar de telefon
    if (empty($_POST["numar"])) {
        $errors[] = "Numărul de telefon este obligatoriu";
    } else {
        $numar = validare($_POST["numar"]);
        if (!preg_match("/^[0-9]{6,15}$/",$numar)) {
            $errors[] = "Numărul de telefon trebuie să conțină doar cifre și să aibă între 10 și 15 caractere";
        }
    }

    // Validare mesaj
    if (empty($_POST["mesaj"])) {
        $errors[] = "Mesajul este obligatoriu";
    } else {
        $mesaj = validare($_POST["mesaj"]);
    }

    if(empty($errors)){
        $select_mesaj = mysqli_query($conn, "SELECT * FROM mesaj WHERE nume='$nume' AND email='$email' AND numar='$numar' AND mesaj='$mesaj'") or die('Interogare esuata: nu se pot selecta date');

        if (mysqli_num_rows($select_mesaj) > 0){
            echo 'Mesajul a fost deja trimis';
        } else {
            $insert_query = "INSERT INTO  mesaj ( nume, email, numar, mesaj)
                            VALUES ('$nume', '$email', '$numar', '$mesaj')";
            $result = mysqli_query($conn, $insert_query);
            if ($result) {
                echo 'Mesajul a fost trimis cu succes!';
            } else {
                echo 'Interogare esuata: ' . mysqli_error($conn);
            }
        }
    } else {
        foreach($errors as $error){
            echo $error . "<br>";
        }
    }
}

function validare($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">

    <title>Acasa</title>
</head>

<body>
    <?php include 'header.php'; ?>

    
    <div class="form-container">
        <h1 class="title"> Lasa un mesaj</h1>
        <form method="post">
            <div class="input-field">
            <label>Nume:</label><br>
            <input type="text" name="nume">
            </div>
            <div class="input-field">
            <label>Email:</label><br>
            <input type="text" name="email">
            </div>
            <div class="input-field">
            <label>Numar:</label><br>
            <input type="number" name="numar">
            </div>
            <div class="input-field">
            <label>Mesaj:</label><br>
            <textarea name="mesaj"></textarea>
            </div>
            <button type="submit" name="submit-btn">Trimite mesajul</button>
</form>
</div>


    <div class="line"></div>
    <div class="line2"></div>

    <div class="address">
    <h1 class="title">Contacte</h1>
    <div class="row">
        <div class="box">
            <i class="bi bi-map-fill"></i>
            <div>
                <h4>Adresa</h4>
                <p>str. Stefan cel Mare, 23/1<br>Moldova, Chisinau</p>
            </div>
        </div>

        <div class="box">
            <i class="bi bi-telephone-fill"></i>
            <div>
                <h4>Telefon</h4>
                <p>+1234567890</p>
            </div>
        </div>

        <div class="box">
            <i class="bi bi-envelope-fill"></i>
            <div>
                <h4>Email</h4>
                <p>gradinaru.madalina8@gmail.com</p>
            </div>
        </div>
    </div>
</div>

            
</div>
</div>
<div class="line3"></div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
