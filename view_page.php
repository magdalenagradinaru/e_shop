<?php 
    include ('connection.php');
    session_start();/*
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location: login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location:login.php");
    }*/

    /*//adaugare produse in lista de dorinte
    if(isset($_POST['add_to_wishlist'])){
        $produs_id = $_POST['produs_id'];
        $nume_produs = $_POST['nume_produs'];
        $pret_produs = $_POST['pret_produs'];
        $imagine_produs = $_POST['imagine_produs'];

        $numar_dorinte = mysqli_query($conn, "SELECT * FROM `lista_de_dorinte` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');
        $nr_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');

        if(mysqli_num_rows($numar_dorinte) > 0){
            $mesaj[] = 'Produsul deja există în lista de dorințe';
        } else if(mysqli_num_rows($nr_cart) > 0){
            $mesaj[] = 'Produsul deja există în coș';
        } else {
            mysqli_query($conn, "INSERT INTO `lista_de_dorinte`(`user_id`, `pid`, `nume`, `pret`, `imagine`) VALUES ('$user_id', '$produs_id', '$nume_produs','$pret_produs','$imagine_produs')");
            $mesaj[] = 'Produsul a fost adăugat cu succes în lista de dorințe!';
        }
    }


    //adaugare produse in lista de cos
    if(isset($_POST['add_to_cart'])){
        $produs_id = $_POST['produs_id'];
        $nume_produs = $_POST['nume_produs'];
        $pret_produs = $_POST['pret_produs'];
        $imagine_produs = $_POST['imagine_produs'];
        $cantitate_produs = $_POST['cantitate_produs'];

        $user_id = $_SESSION['user_id'];

        $nr_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');

        if(mysqli_num_rows($nr_cart) > 0){
            $mesaj[] = 'Produsul deja există în coș';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `nume`, `pret`, `cantitate`,`imagine`) VALUES ('$user_id', '$produs_id', '$nume_produs','$pret_produs','$cantitate_produs','$imagine_produs')");
            $mesaj[] = 'Produsul a fost adăugat cu succes în coșul de cumpărături!';
        }
    }*/
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

    <style>

.detalii {
  font-weight: bold;
  font-size: 1.2em; 
  color: black;
}

</style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detalii">
            <h1>Detalii despre produse</h1>
        </div>
    </div>
    <section class="view_page">
        
    <?php 
if(isset($mesaj)){
    foreach($mesaj as $mesaj){
        echo '
        <div class="mesaj">
            <span>'.$mesaj.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>';
    }
}
?>

    ?>
    <?php 
    if (isset($_GET['pid'])){
        $pid= $_GET['pid'];
        $select_produse= mysqli_query($conn, "SELECT * FROM `produse` WHERE id='$pid'") or die('Nu s-a reusit accesarea la tabelul produse');

    if (mysqli_num_rows($select_produse)>0){
        while($fetch_produse = mysqli_fetch_assoc($select_produse)){
    ?>
    <form method="post">
        <img src="imagini/<?php echo $fetch_produse['imagine'];?>">
       <div class="detalii">
       <div class="pret"><?php echo $fetch_produse['pret'];?></div>
        <div class="nume"><?php echo $fetch_produse['nume'];?></div>
        <div class="detalii"><?php echo $fetch_produse['detalii_produs'];?></div>


        <input type="hidden" name="produs_id" value="<?php echo $fetch_produse['id'];?>">
        <input type="hidden" name="nume_produs" value="<?php echo $fetch_produse['nume'];?>">
        <input type="hidden" name="pret_produs" value="<?php echo $fetch_produse['pret'];?>">
        <input type="hidden" name="imagine_produs" value="<?php echo $fetch_produse['imagine'];?>">
        <!--
        <div class="icon">
            <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
            <input type="number" name="cantitate_produs" value="1" min="1" class="cantitate">
            <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
        </div>-->    
    </div>
    </form>
    <?php
            }
        }
    }
    ?>
    </section>

    
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
