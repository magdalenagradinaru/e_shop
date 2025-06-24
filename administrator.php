<?php
    require('connection.php');
    session_start();
$admin_id= $_SESSION['nume_admin'];

 if(!isset($admin_id)){
    header('location: login.php');
 }
 if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Icons link-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
     <link rel="stylesheet" type="text/css" href="style.css">
     <title>Administrator panou</title>
</head>
<body>
    <?php  include('admin_header.php'); ?>
    <div class="line4"></div>
    <section class="dashboard">
    <div class="box-container">

        <!--<div class="box">
            <?php /*
            $total_asteptari=0;
            $select_asteptari= mysqli_query($conn, "SELECT * FROM `comenzi` WHERE stare_achitare = 'pending'" ) or die("Interogare esuata");
            while ($fetch_pending = mysqli_fetch_assoc($select_asteptari)){
                $total_asteptari += $fetch_pending['pret_total'];
            }*/
            ?>
            <h3><?php echo $total_asteptari; ?></h3>
            <p> asteptari in total</p>
        </div>-->

        <div class="box">
            <?php 
            $total_completari=0;
            $select_completari= mysqli_query($conn, "SELECT * FROM `comenzi` WHERE stare_achitare = 'completat'" ) or die("Interogare esuata");
            while ($fetch_completes = mysqli_fetch_assoc($select_completari)){
                $total_completari += $fetch_completes['pret_total'];
            }
            ?>
            <h3><?php echo $total_completari; ?></h3>
            <p> completari in total</p>
        </div>

        <div class="box">
            <?php 
            $select_comenzi= mysqli_query($conn, "SELECT * FROM `comenzi` " ) or die("Interogare esuata");
            $nr_comenzi =mysqli_num_rows($select_comenzi);
            ?>
            <h3><?php echo $nr_comenzi; ?></h3>
            <p> Comenzi plasate</p>
        </div>

        <div class="box">
            <?php 
            $select_produse= mysqli_query($conn, "SELECT * FROM `produse` " ) or die("Interogare esuata");
            $nr_produse =mysqli_num_rows($select_produse);
            ?>
            <h3><?php echo $nr_produse; ?></h3>
            <p> produse adaugate </p>
        </div>

        <div class="box">
            <?php 
            $select_user= mysqli_query($conn, "SELECT * FROM `utilizatori` WHERE tip_utilizator='utilizator'" ) or die("Interogare esuata");
            $nr_utilizatori =mysqli_num_rows($select_user);
            ?>
            <h3><?php echo $nr_utilizatori; ?></h3>
            <p> total utilizatori ordinari </p>
        </div>

        <div class="box">
            <?php 
            $select_admin= mysqli_query($conn, "SELECT * FROM `utilizatori` WHERE tip_utilizator='admin'" ) or die("Interogare esuata");
            $nr_admin =mysqli_num_rows($select_admin);
            ?>
            <h3><?php echo $nr_admin; ?></h3>
            <p> total administratori </p>
        </div>

        <div class="box">
            <?php 
            $select_mesaj= mysqli_query($conn, "SELECT * FROM `mesaj` " ) or die("Interogare esuata");
            $nr_mesaj =mysqli_num_rows($select_mesaj);
            ?>
            <h3><?php echo $nr_mesaj; ?></h3>
            <p> total mesaje </p>
        </div>

    </div>
</section>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>
