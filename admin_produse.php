<?php
    require('connection.php');
    session_start();
    $id_admin = $_SESSION['nume_admin'];
    
    if(!isset($id_admin)){
        header('location: login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header('location:login.php');
    }
    

    //adaugare produse la baza de date
    if(isset($_POST['add_produs'])) {
        $nume_produs = mysqli_real_escape_string($conn, $_POST['nume']);
        $pret_produs = mysqli_real_escape_string($conn, $_POST['pret']);
        $detalii_produs = mysqli_real_escape_string($conn, $_POST['detalii']);
        $imagine = $_FILES['imagine']['name'];
        $dim_imagine = $_FILES['imagine']['size'];
        $tmp_nume_imagine = $_FILES['imagine']['tmp_name'];
        $folder_imagine = 'imagini/'.$imagine;

        $select_nume_produs = mysqli_query($conn, "SELECT nume FROM `produse` WHERE nume='$nume_produs'") or die('Interogare esuata: nu s-au putut prelua datele din BD');

        if(mysqli_num_rows($select_nume_produs) > 0){
            $mesaj[] = 'Acest nume de produs deja exista!';
        } else{
            $adauga_produs = mysqli_query($conn, "INSERT INTO `produse` (`nume`, `pret`, `detalii_produs`, `imagine`)
VALUES('$nume_produs', '$pret_produs', '$detalii_produs', '$imagine')") or die('Interogare esuata: ' . mysqli_error($conn));
  if ($adauga_produs){
                if($dim_imagine > 2000000){
                    $mesaj[] = 'Dimensiunea imaginii este prea mare!';
                } else{
                    move_uploaded_file($tmp_nume_imagine, $folder_imagine);
                    $mesaj[] = "Produsul a fost adaugat cu succes!";
                }
            }
        }
    }

    //sterge produs din Baza de Date
    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $select_delete_imagine = mysqli_query($conn, "SELECT imagine FROM `produse` WHERE id = '$delete_id'")or die('Interogare esuata: nu s-a reusit stergerea datelor din BD');
        $fetch_delete_imagine = mysqli_fetch_assoc($select_delete_imagine);
        unlink('imagini/'.$fetch_delete_imagine['imagine']);

        mysqli_query($conn, "DELETE FROM `produse` WHERE id = '$delete_id'") or die('Interogare esuata: nu s-a putut sterge date din produse');
        mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('Interogare esuata: nu s-au putut sterge datele din cart');
        mysqli_query($conn, "DELETE FROM `lista_de_dorinte` WHERE pid = '$delete_id'") or die('Interogare esuata: nu s-au putut sterge date din lista de dorinte');

        header('location: admin_produse.php ');
    }

    //update la produse
    if (isset($_POST['update_produs'])){
        $update_id = $_POST['update_id'];
        $update_nume = $_POST['update_nume'];
        $update_pret = $_POST['update_pret'];
        $update_detalii = $_POST['update_detalii'];
        $update_imagine = $_FILES['update_imagine']['name'];
        $update_imagine_tmp_nume = $_FILES['update_imagine']['tmp_name'];
        $update_imagine_folder ='imagini/'.$update_imagine;

        $update_query= mysqli_query($conn, "UPDATE `produse` SET `id`='$update_id', `nume`='$update_nume', `pret`='$update_pret', `detalii_produs`='$update_detalii', `imagine`='$update_imagine' WHERE id='$update_id'") or die('Interogare esuata: nu s-au putut acualiza datele');
        if($update_query){
            move_uploaded_file($update_imagine_tmp_nume, $update_imagine_folder);
            header('location: admin_product.php');
        }
    }
?>

<style type="text/css">
    <?php
    include'style.css';
    ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootsrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Administrator panou</title>
</head>

<body>
    <?php  include('admin_header.php');  ?>
    <?php
    if (isset($mesaj)){
        foreach($mesaj as $mesaj){
            echo '
            <div class="mesaj">
            <span>' .$mesaj.'</span>
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>

    <div class="line2"></div>

    <section class="add-produse form-container">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="input-field">
                <label> Denumire produs: </label>
                <input type="text" name="nume" required>
            </div>

            <div class="input-field">
                <label> Pret produs: </label>
                <input type="text" name="pret" required>
            </div>

            <div class="input-field">
                <label> Detalii produs: </label>
                <textarea name="detalii" required></textarea>
            </div>

            <div class="input-field">
                <label> Imagine produs: </label>
                <input type="file" name="imagine" accept="imagini/jpg, imagini/jpeg, imagini/png, imagini/webp" required>
            </div>

            <input type="submit" name="add_produs" value="add_produs" class="btn">
        </form>
    </section>

    <div class="line3"></div>
    <div class="line4"></div>

    <section class="show-products">
        <div class="box-container">
            <?php
            $select_produs = mysqli_query($conn, "SELECT * FROM `produse`") or die('Interogare esuata: nu s-au putut prelua datele pentru afisare.');
            if (mysqli_num_rows($select_produs) > 0) {
                while($fetch_products = mysqli_fetch_assoc($select_produs)){
            ?>
                <div class="box">
                    <img src="imagini/<?php echo $fetch_products['imagine']; ?>">
                    <p>Pret : $<?php echo $fetch_products['pret'];?></p>
                    <h4><?php echo $fetch_products['nume']; ?> </h4>
                    <details> <?php echo $fetch_products['detalii_produs'];?></details>
                    <a href="admin_produse.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">edit</a>
                    <a href="admin_produse.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Sigur vrei sa stergi acest produs?')">delete</a>
                </div>
            <?php
                } 
            }else{
                echo '
                <div class="empty">
                    <p>Inca nu au fost adaugate produse!</p>
                </div>';
            }
            ?>
        </div>
    </section>

    <div class="line"></div>

    <section class="update-container">
        <?php
        if (isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `produse` WHERE id='$edit_id'") or die('Interogare esuata: nu s-au putut afisa datele pentru update.');
            if (mysqli_num_rows($edit_query) > 0){
                while($fetch_edit = mysqli_fetch_assoc($edit_query)){
        ?>
                <form method="POST" enctype="multipart/form-data">
                    <img src="imagini/<?php echo $fetch_edit['imagine'];?>">
                    <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id'];?>">
                    <input type="text" name="update_nume" value="<?php echo $fetch_edit['nume'];?>">
                    <input type="number" name="update_pret" value="<?php echo $fetch_edit['pret'];?>">
                    <textarea name="update_detalii"><?php echo $fetch_edit['detalii_produs'];?></textarea>
                    <input type="file" name="update_imagine" accept="imagini/jpg, imagini/jpeg, imagini/png, imagini/webp">
                    <input type="submit" name="update_produs" value="update" class="edit">
                    <input type="reset" name="" value="cancle" class="option-btn btn" id="close-form">
                </form>
        <?php
                }
            }
            echo "<script> document.querySelector('.update-container').style.display='block'</script> ";
        }
        ?>
    </section>

    <script type="text/javascript" src="script.js"></script>
</body>
</html>
