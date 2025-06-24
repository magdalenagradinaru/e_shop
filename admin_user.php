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

 
//sterge utilizator din Baza de Date
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `utilizatori` WHERE id = '$delete_id'") or die('Interogare esuată!');
$mesaj[]="Utilizatorul a fost sters cu succes";
    header('location: admin_user.php');
    exit;
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
    <?php  include('admin_header.php');  ?>

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
    <div class="message-container">
        <h1 class="title"> Conturi de utilizator in total </h1>
        <div class="box-container">
            <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `utilizatori`") or die('Interogare esuată');
            if (mysqli_num_rows($select_user) > 0) {
                while ($fetch_user = mysqli_fetch_assoc($select_user)) {
            ?>
                   
                   
                   <div class="box">
                        <p> ID-ul utilizatorului: <span><?php echo $fetch_user['id']; ?></span></p>
                        <p> Nume: <span><?php echo $fetch_user['nume']; ?></span></p>
                        <p> Email: <span><?php echo $fetch_user['email']; ?></span></p>
                        <p>Tip utilizator: <span style="color:<?php if($fetch_user[`tip_utilizator`]=='admin'){echo 'red';};?>">
                        <?php echo $fetch_user['tip_utilizator']; ?></span></p>
                        <a href="admin_user.php?delete=<?php echo $fetch_user['id']; ?>" onclick="return confirm('Sterge acest utlizator');">Sterge</a>
                    </div>
            <?php
                }
            } else {
                echo '
                <div class="empty">
                    <p>Inca nu au fost adaugate mesaje!</p>
                </div>';
            }
            ?>
        </div>
    </div>
    <div class="line"></div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
