<?php
require('connection.php');

if (isset($_POST['submit-btn'])) {
    $filter_nume = filter_var($_POST['nume'], FILTER_SANITIZE_STRING); 
    $nume = mysqli_real_escape_string($conn, $filter_nume);           
    
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING); 
    $email = mysqli_real_escape_string($conn, $filter_email);     

    $filter_parola = filter_var($_POST['parola'], FILTER_SANITIZE_STRING); 
    $parola = mysqli_real_escape_string($conn, $filter_parola); 
    
    $filter_cparola = filter_var($_POST['cparola'], FILTER_SANITIZE_STRING); 
    $cparola = mysqli_real_escape_string($conn, $filter_cparola); 

    function validare($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Verificare nume
    if (empty($nume)) {
        $mesaj[] = 'Numele este obligatoriu';
    } else {
        $nume = validare($nume);
    }

    // Verificare email
    if (empty($email)) {
        $mesaj[] = 'Adresa de email este obligatorie';
    } else {
        $email = validare($email);
        // Verificăm dacă adresa de email este validă
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mesaj[] = 'Adresa de email nu este validă';
        }
    }

    // Verificare parolă
    if (empty($parola)) {
        $mesaj[] = 'Parola este obligatorie';
    } elseif (strlen($parola) < 8) {
        $mesaj[] = 'Parola trebuie să aibă cel puțin 8 caractere';
    }

    // Verificare confirmare parolă
    if (empty($cparola)) {
        $mesaj[] = 'Confirmarea parolei este obligatorie';
    } elseif ($parola != $cparola) {
        $mesaj[] = 'Parola și confirmarea parolei nu se potrivesc';
    }

    // Verificare existență email în baza de date
    $select_user = mysqli_query($conn, "SELECT * FROM `utilizatori` WHERE email='$email'") or die('Interogare greșită');
    if (mysqli_num_rows($select_user) > 0) {
        $mesaj[] = 'Adresa de email este deja folosită';
    } else {
        if (empty($mesaj)) {
            mysqli_query($conn, "INSERT INTO `utilizatori` (`nume`, `email`, `parola`) VALUES ('$nume', '$email', '$parola')") or die(mysqli_error($conn));
            $mesaj[] = 'Înregistrare cu succes';
            header('location: login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icons link-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Înregistrare</title>
</head>
<body>
    <?php
    if(isset($mesaj)){
        foreach($mesaj as $mesaj){
            echo'
        
    <div class="mesaj">
        <span>'.$mesaj.'</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
    </div>';
         }
    }
?>
    <section class="form-container">
        <form method="post">
            <h1> Înregistrează-te acum!</h1>
            <input type="text" name="nume" placeholder="Introdu numele tău" value="<?php if(isset($_POST['nume'])) echo $_POST['nume']; ?>">
            <input type="email" name="email" placeholder="Introdu adresa electronică" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
            <input type="password" name="parola" placeholder="Introdu parola">
            <input type="password" name="cparola" placeholder="Confirmă parola">
            <input type="submit" name="submit-btn" value="Înregistrare" class="btn">
            <p>Ai deja un cont? <a href="login.php">Autentificare</a></p>
        </form>
    </section>
</body>
</html>
