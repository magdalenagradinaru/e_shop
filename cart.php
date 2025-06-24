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

    

    //Update qty
    if(isset($_POST['update_qty_btn'])){
        $update_qty_id =$_POST['update_qty_id'];
        $update_value= $_POST['update_qty'];

        $update_query= mysqli_query($conn,"UPDATE `cart` SET cantitate='$update_value'") or die('Interogare esuata');
    if($update_query){
        header('location: cart.php');
    }
    }


    //sterge produs din lista de dorinte
    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        

         mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('Interogare esuata: nu s-au putut sterge date din lista de dorinte');

        header('location: cart.php ');
    }

    //sterge toate produsele din lista de dorinte
    if (isset($_GET['delete_all'])){
        $delete_id = $_GET['delete_all'];
        
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Interogare esuata: nu s-au putut sterge date din lista de dorinte');

        header('location: cart.php ');
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



    <div class="banner">
        <div class="detalii">
            <h1>Lista mea de cumparaturi</h1>
            
        </div>
    </div>

    <section class="shop">

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

    <div class="box-container">
    <?php 
    $grand_total=0;
    $select_cart= mysqli_query($conn, "SELECT * FROM `cart`") or die('Nu se poate accesa tabelul produse');
    if(mysqli_num_rows($select_cart)>0){
        while($fetch_cart=mysqli_fetch_assoc($select_cart)){
            ?>
<div class="box">
<div class="icon">
    <a href="view_page.php?pid=<?php echo $fetch_dorinte['id']; ?>" class="bi bi-eye-fill"></a>
    <a href="lista_dorinte.php?delete=<?php echo $fetch_dorinte['id'];?>" class="bi bi-x" onclick="return confirm('Ești sigur că vrei să ștergi acest produs din lista de dorințe?')"></a>
    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
        </div>

    <img src="imagini/<?php echo $fetch_cart['imagine'];?>">
    <div class="pret"> <?php echo $fetch_cart['pret'];?></div>
    <div class="nume"> <?php echo $fetch_cart['nume'];?></div>

    <!--<form method="post">
        <input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id']; ?>">
        <div class="qty">
            <input type="number" min="1" name="update_qty" value="<?php echo $fetch_cart['cantitate']; ?>">
            <input type="submit" name="update_qty_btn" value="update">
        </div>
        </form>-->
<div class="total-amt">
    Total: <span><?php $total_amt= ($fetch_cart['pret']*$fetch_cart['cantitate'])?></span>
        </div>
        </div>

        <?php
                $grand_total+=$total_amt;
        }
    }else{
        echo'<p class="empty">Inca nu au fost adaugate produse</p>';
    }
    ?>
    


<div class="lista_dorinte_total">
        <p> Total spre plata: <span>$<?php echo $grand_total;?>/-</span></p>
        <a href="magazin.php">Continua cumparaturile</a>
        <a href="cart.php?delete_all"class="btn2 <?php echo ($grand_total)?'':'disabled'?>" onclick="return
        confirm('esti sigur ca vrei sa stergi toate produsele din lista de dorinte?')"></a>
</div>
    </section>

    <div class="line3"></div>
    <?php include 'checkout.php'; ?>
    <div class="line"></div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
