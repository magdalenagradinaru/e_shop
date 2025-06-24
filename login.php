<?php
session_start();

require('connection.php');

// Functia pentru validarea datelor
function validare($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initializam variabilele pentru mesajele de eroare
$emailErr = $parolaErr = "";
$mesaj = array();

if (isset($_POST['submit-btn'])){
    // Validarea adresei de email
    if (empty($_POST["email"])) {
        $emailErr = "Campul trebuie obligatoriu completat";
    } else {
        $email = validare($_POST["email"]);
        // Verificam daca adresa de e-mail a fost scrisa corect folosind filtre
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Ati introdus o adresa de e-mail nevalida!";
        }
    }

    // Validarea parolei
    if (empty($_POST["parola"])) {
        $parolaErr = "Campul trebuie obligatoriu completat";
    } else {
        $parola = validare($_POST["parola"]);
        // Verificam daca parola respecta pattern-ul (cel putin 8 caractere si cel putin o cifra)
        if (!preg_match("/^(?=.*[0-9]).{8,}$/", $parola)) {
            $parolaErr = "Parola trebuie să conțină cel puțin 8 caractere și cel puțin o cifră!";
        }
    }

    if(empty($emailErr) && empty($parolaErr)){
        $filter_email = filter_var($email, FILTER_SANITIZE_STRING); 
        $email = mysqli_real_escape_string($conn, $filter_email);     

        $filter_parola = filter_var($parola, FILTER_SANITIZE_STRING); 
        $parola = mysqli_real_escape_string($conn, $filter_parola); 
        
        $select_user = mysqli_query($conn, "SELECT * FROM `utilizatori` WHERE email='$email' AND parola='$parola'") or die('Interogare gresita');
       
        if (mysqli_num_rows($select_user) > 0){
            $row = mysqli_fetch_assoc($select_user);
            if($row['tip_utilizator'] == 'admin'){
                $_SESSION['nume_admin'] = $row['nume'];
                $_SESSION['email_admin'] = $row['email'];
                $_SESSION['id_admin'] = $row['id'];
                header('Location: administrator.php');
                exit; 
            } else if($row['tip_utilizator'] == 'utilizator') {
                $_SESSION['nume_utilizator'] = $row['nume'];
                $_SESSION['email_utilizator'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: index.php');
                exit; 
            }
        } else {
            $mesaj[] = 'Email sau parolă incorectă';
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
    <title>Autentificare</title>
</head>
<body>
    <?php
    if(!empty($mesaj)){
        foreach($mesaj as $msg){
            echo'
        
    <div class="mesaj">
        <span>'.$msg.'</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
    </div>';
         }
    }
?>
    <section class="form-container">
        <form method="post">
            <h1> Autentificare</h1>
            <div class="input-field">
                <label>Adresa electronică </label><br>
                <input type="email" name="email" placeholder="Introdu adresa electronică">
                <span class="error"><?php echo $emailErr;?></span> <!-- Afiseaza mesajul de eroare pentru adresa de email -->
            </div>
            <div class="input-field">
                <label>Parola </label><br>
                <input type="password" name="parola" placeholder="Introdu parola">
                <span class="error"><?php echo $parolaErr;?></span> <!-- Afiseaza mesajul de eroare pentru parola -->
            </div>
            <input type="submit" name="submit-btn" value="Autentificare" class="btn">
            <p>Încă nu ai un cont? <a href="inregistrare.php">Înregistrare</a></p>
        </form>
    </section>
</body>
</html>
