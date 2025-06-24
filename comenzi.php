<?php 
    include ('connection.php');

   session_start();
   
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location: login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location:login.php");
    }


    //adaugare produse in lista de cos
    if(isset($_POST['add_to_cart'])){
        $produs_id = $_POST['produs_id'];
        $nume_produs = $_POST['nume_produs'];
        $pret_produs = $_POST['pret_produs'];
        $imagine_produs = $_POST['imagine_produs'];
        $cantitate_produs = 1;


        $nr_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');

        if(mysqli_num_rows($nr_cart) > 0){
            $mesaj[] = 'Produsul deja există în coș';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `nume`, `pret`, `cantitate`,`imagine`) VALUES ('$user_id', '$produs_id', '$nume_produs','$pret_produs','$cantitate_produs','$imagine_produs')");
            $mesaj[] = 'Produsul a fost adăugat cu succes în coșul de cumpărături!';
        }
    }

    //sterge produs din lista de dorinte
    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        

         mysqli_query($conn, "DELETE FROM `lista_de_dorinte` WHERE id = '$delete_id'") or die('Interogare esuata: nu s-au putut sterge date din lista de dorinte');

        header('location: lista_dorinte.php ');
    }

    //sterge produs din lista de dorinte
    if (isset($_GET['delete_all'])){
        $delete_id = $_GET['delete_all'];
        
         mysqli_query($conn, "DELETE FROM `lista_de_dorinte` WHERE user_id = '$user_id'") or die('Interogare esuata: nu s-au putut sterge date din lista de dorinte');

        header('location: lista_dorinte.php ');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">

    <title>Acasa</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <div class="detalii">
            <h1>Comenzi</h1>
        </div>
    </div>
    <div class="line"></div>

    <div class="order-section">
        <div class="box-container">
            <?php
        $select_comenzi=mysqli_query($conn,"SELECT * FROM comenzi WHERE user_id ='$user_id'") or die('Interogare esuata');
        if(mysqli_num_rows($select_comenzi)>0){
            while( $fetch_comenzi= mysqli_fetch_assoc($select_comenzi)){

            ?>
<div class="box">
        <p> Nume utilizator: <span><?php echo $fetch_comenzi['nume']; ?></span></p>
        <p> Plasat: <span><?php echo $fetch_comenzi['plasat']; ?></span></p>
        <p> Numar: <span><?php echo $fetch_comenzi['numar']; ?></span></p>
        <p> Email: <span><?php echo $fetch_comenzi['email']; ?></span></p>
        <p> Pret total: <span><?php echo $fetch_comenzi['total_pret']; ?></span></p>
        <p> Metode de plata: <span><?php echo $fetch_comenzi['metoda']; ?></span></p>
        <p> Adresa: <span><?php echo $fetch_comenzi['adresa']; ?></span></p>
        <p> Total produse: <span><?php echo $fetch_comenzi['total_produse']; ?></span></p>
</div>

            <?php
        }
    } else {
        echo '
        <div class="empty">
            <p>Inca nu au fost plasate comenzi!</p>
        </div>';
    }
    
            ?>

</div>
</div>
    <div class="line3"></div>
    
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
