<?php 
    include ('connection.php');

   session_start();
   /*
    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location: login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location:login.php");
    }*/

    


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
            <h1>Lista cu dorinte</h1>
              </div>
    </div>
    <div class="line"></div>

    <section class="shop">
    <h1 class="titlu">Lista mea cu dorinte </h1>    

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

    <div class="box-container">
    <?php 
    $grand_total=0;
    $select_lista_dorinte= mysqli_query($conn, "SELECT * FROM `lista_de_dorinte`") or die('Nu se poate accesa tabelul produse');
    if(mysqli_num_rows($select_lista_dorinte)>0){
        while($fetch_dorinte=mysqli_fetch_assoc($select_lista_dorinte)){
            ?>
<form method="post" class="box">
    <img src="imagini/<?php echo $fetch_dorinte['imagine'];?>">
    <div class="pret"> <?php echo $fetch_dorinte['pret'];?></div>
    <div class="nume"> <?php echo $fetch_dorinte['nume'];?></div>

    <input type="hidden" name="produs_id" value="<?php echo $fetch_dorinte['id'];?>">
    <input type="hidden" name="nume_produs" value="<?php echo $fetch_dorinte['nume'];?>">
    <input type="hidden" name="pret_produs" value="<?php echo $fetch_dorinte['pret'];?>">
    <input type="hidden" name="imagine_produs" value="<?php echo $fetch_dorinte['imagine'];?>">
<div class="icon">
    <a href="view_page.php?pid=<?php echo $fetch_dorinte['id']; ?>" class="bi bi-eye-fill"></a>
    <a href="lista_dorinte.php?delete=<?php echo $fetch_dorinte['id'];?>" class="bi bi-x" onclick="return confirm('Ești sigur că vrei să ștergi acest produs din lista de dorințe?')"></a>
    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
        </div>
        </form>


        <?php
                $grand_total+=$fetch_dorinte['pret'];
        }
    }else{
        echo'<p class="empty">Inca nu au fost adaugate produse</p>';
    }
    ?>
    </div>
    </div>
    <div class="lista_dorinte_total">
        <p> Total spre plata: <span>$<?php echo $grand_total;?>/-</span></p>
        <a href="magazin.php">Continua cumparaturile</a>
        <a href="lista_dorinte.php?delete_all"class="btn2 <?php echo ($grand_total)?'':'disabled'?>" onclick="return
        confirm('esti sigur ca vrei sa stergi toate produsele din lista de dorinte?')"></a>
</div>
    </section>

    <div class="line3"></div>
    
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
