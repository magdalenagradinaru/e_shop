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
     <link rel="stylesheet" type="text/css" href="style.css">
     <title>ADMIN</title>

</head>
<body>
    <!--<script type="text/javascript" src="script.js"></script>-->

    <header class="header">
        <div class="flex">
            <a href="administrator.php" class="logo"><img src="img/logo.png" width="70px" height="70px"></a>
<nav class="navbar">
    <a href="administrator.php"> Acasă</a>
    <a href="admin_produse.php"> Produse</a>
    <a href="admin_comenzi.php"> Comenzi</a>
    <a href="admin_user.php"> Utilizator</a>
    <a href="admin_mesaj.php"> Mesaje</a>
</nav>
<div class="icons">
    <i class="bi bi-person" id="user-btn"></i>
     <i class="bi bi-list" id="menu-btn"></i>
</div>
<div class="user-box">
    <p> <span><?php echo $_SESSION['nume']; ?></span></p>
    <p> <span> <?php echo $_SESSION['email']; ?> </span></p>
    <form method="post">
        <input type="hidden" name="logout" value="true">
        <button type="submit" class="logout-btn"> Delogare</button>
    </form>
</div>
</div>
</header>
<div class="banner">
    <div class="detalii">
        <h1> Administrator</h1>
</div>
</div>
<div class="line">
</div>
</body>
</html>