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

    if(isset($_POST['order_btn'])){
        $nume=mysqli_real_escape_string($conn, $_POST['nume']);
        $email=mysqli_real_escape_string($conn, $_POST['email']);
        $numar=mysqli_real_escape_string($conn, $_POST['numar']);
        $metoda=mysqli_real_escape_string($conn, $_POST['metoda']);
        $adresa=mysqli_real_escape_string($conn, $_POST['oras']);
        $plasat= date(d-M-Y);
        $cart_total=0;
        $cart_produs[]='';
        $cart_query=mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$user_id'") or die('Interogare esuata');

        if (mysqli_num_rows($cart_query)>0){
            while($cart_item= mysqli_fetch_assoc($cart_query)){
                $cart_produs[]=$cart_item['nume'].'('.$cart_item['cantitate'].')';
                $sub_total= ($$cart_item['pret']*$cart_item['cantitate']);
                $cart_total+=$sub_total;
            }
            
        }
$total_produse=implode(', ',$cart_produs);
mysqli_query($conn, "INSERT INTO comenzi (user_id, nume, numar, email, metoda, adresa, total_produse, Total_pret, plasat) VALUES ($user_id, $nume, $numar, $email, $metoda, $adresa, $total_pret, $plasat)");
mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
$mesaj[]='Comanda plasata cu succes';
header('location:checkout.php');
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

    <div class="banner">
        <div class="detalii">
            <h1>Comenzi</h1>
            </div>
    </div>
    <div class="line"></div>

    <div class="checkout-form">
        <h1 class="title">Procesul de achitare</h1>
        <?php 
if(isset($mesaj)){
    foreach($mesaj as $msg){
        echo '
        <div class="mesaj">
            <span>'.$msg.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
        </div>';
    }
}
?>
<div class="display-order">
    <?php
$select_cart=mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('interogare esuata');
$total=0;
$grand_total=0;

if(mysqli_num_rows($select_cart)>0){
    while($fetch_cart= mysqli_fetch_assoc($select_cart)){
        $total_pret=($fetch_cart['pret']* $fetch_cart['cantitate']);
        $grand_total=$total+=$total_pret;
        ?>
        <div class="box-container">
            <div class="box">
                <img src="imagini/<?php echo $fetch_cart['imagine'];?>">
                <span><?$fetch_cart['nume'];?>(<?=$fetch_cart['cantitate']; ?>) </span>
    </div>
    </div>
<?php      
}
}
    ?>
    <span class="grand-total"> Suma Totala: $<?=$grand_total;?> </span>
</div>
<form method="post">
    <div class="input-field">
        <label> Numele </label>
        <input type="text" name="nume" placeholder="Introdu numele tau">
    </div>

    <div class="input-field">
        <label> Email </label>
        <input type="text" name="email" placeholder="Introdu numele tau">
    </div>

    <div class="input-field">
        <label> Selecteaza metoda de plata </label>
<select name="method">
    <option selected disabled>selecteaza</option>
    <option value="cash">Cash(la primire)</option>
    <option value="cars">Card</option>
</select>
       </div>
    <option value="cash">Cash(la primire)</option>
    <div class="input-field">
        <label> Adresa </label>
        <input type="text" name="oras" placeholder="Strada, orasul">
    </div>
    <input type="submit" name="order-btn" class="btn" value="Comanda acum">
</form>
</div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
