<?php
    require('connection.php');
    session_start();
$id_admin= $_SESSION['nume_admin'];

 if(!isset($id_admin)){
    header('location: login.php');
 }
 if(isset($_POST['logout'])){
    session_destroy();
    header('location:login.php');
 }

 
//sterge produs din Baza de Date
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `utilizatori` WHERE id = '$delete_id'") or die('Interogare esuată!');
$mesaj[]="Utilizatorul a fost sters cu succes";
    header('location: admin_comenzi.php');
}

//update la statusul de achitare
if(isset($_POST['update_comanda'])){
    $comanda_id= $_POST['comanda_id'];
    $update_achitare= $_POST['update_achitare'];

    mysqli_query($conn,"UPDATE `comenzi` SET stare_achitare = '$update_achitare' WHERE id='$comanda_id'" ) or die('Nu s-a putut actualiza starea de achitare');
}


?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Administrator panou</title>
</head>

<body>
    <?php  include('admin_header.php'); ?>

    <?php
    if (isset($mesaj)) {
        foreach ($mesaj as $mesaj) {
            echo '
            <div class="mesaj">
                <span>' . $mesaj . '</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
            </div>';
        }
    }
    ?>

    <div class="line4"></div>
    <div class="order-container">
        <h1 class="title"> Conturi de utilizator in total </h1>
        <div class="box-container">
            <?php
            $select_comenzi = mysqli_query($conn, "SELECT * FROM `comenzi`") or die('Interogare esuată');
            if (mysqli_num_rows($select_comenzi) > 0) {
                while ($fetch_comenzi = mysqli_fetch_assoc($select_comenzi)) {
            ?>
                   
                   
                   <div class="box">
                        <p> Nume utilizator: <span><?php echo $fetch_comenzi['nume']; ?></span></p>
                        <p> ID utilizator: <span><?php echo $fetch_comenzi['user_id']; ?></span></p>
                        <p> Plasat: <span><?php echo $fetch_comenzi['plasat']; ?></span></p>
                        <p> Numar: <span><?php echo $fetch_comenzi['numar']; ?></span></p>
                        <p> Email: <span><?php echo $fetch_comenzi['email']; ?></span></p>
                        <p> Pret total: <span><?php echo $fetch_comenzi['total_pret']; ?></span></p>
                        <p> Metode de plata: <span><?php echo $fetch_comenzi['metoda']; ?></span></p>
                        <p> Adresa: <span><?php echo $fetch_comenzi['adresa']; ?></span></p>
                        <p> Total produse: <span><?php echo $fetch_comenzi['total_produse']; ?></span></p>

                        <form method="POST">
                            <input type="hidden" name="comanda_id" value="<?php echo $fetch_comenzi['id']; ?>">
                        <select name="update_achitare">
                            <option disabled <?php if($fetch_comenzi['stare_achitare']=="plasat") echo 'selected'; ?>>Plasat</option>
                            <option disabled <?php if($fetch_comenzi['stare_achitare']=="completat") echo 'selected'; ?>>Completat</option>
                            <option value="plasat">Plasat</option>
                            <option value="completat">Completat</option>
                        </select>
                        <input type="submit" name="update_comanda" value="actualizare achitare" class="btn">
                        </form>
<a href="admin_comenzi.php?delete=<?php echo $fetch_comenzi['id'];?>;" onclick="return confirm('Sterge aceasta comanda');" class="delete"> Sterge</a>
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
    <div class="line"></div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
