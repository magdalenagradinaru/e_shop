<?php 
include ('connection.php');

session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Icons link-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
     <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
     <link rel="stylesheet" type="text/css" href="main.css">
     <title>Document</title>

</head>
<body>
    <!--<script type="text/javascript" src="script.js"></script>-->

    <header class="header">
        <div class="flex">
            <a href="administrator.php" class="logo"><img src="img/logo.png" width="70px" height="70px"></a>
            <nav class="navbar">
                <a href="index.php"> Acasă</a>
                <a href="magazin.php"> Magazin</a>
                <a href="contacte.php"> Contacte</a>
            </nav>
            
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
                <?php
                    $select_lista_dorinte = mysqli_query($conn, "SELECT * FROM `lista_de_dorinte` WHERE user_id ='$user_id'") or die ('Nu s-a putut accesa lista de dorinte din BD');
                    $lista_de_dorinte_num_rows = mysqli_num_rows($select_lista_dorinte);
                ?>
                <a href="lista_dorinte.php"><i class="bi bi-heart"></i><sup><?php echo $lista_de_dorinte_num_rows;?></sup></a>
                <?php
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id ='$user_id'") or die ('Nu s-a putut accesa cart-urile din BD');
                    $cart_num_rows = mysqli_num_rows($select_cart);
                ?>
                <a href="cart.php"><i class="bi bi-cart"></i><sup><?php echo $cart_num_rows;?></sup></a>
                <i class="bi bi-list" id="menu-btn"></i>
            </div>


            <div class="user-box">
                <p> Nume de utilizator: <span><?php echo $_SESSION['nume_utilizator']; ?></span></p>
                <p> Email: <span> <?php echo $_SESSION['email_utilizator']; ?> </span></p>
                <form method="post">
                    <input type="hidden" name="logout" value="true">
                    <button type="submit" class="logout-btn"> Delogare</button>
                </form>
            </div>
        </div>
    </header>
    
    <div class="line"></div>
</body>
</html>
