<?php
    require('connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="slick.css"/>
    <link rel="stylesheet" href="main.css">

    <title>Acasa </title>
</head>
<body>
    <section class="popular-brands">
        <h2> Produsele noastre</h2>
        <div class="controls">
            <i class="bi bi-chevron left"></i>
            <i class="bi bi-chevron right"></i>
        </div>
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

        <div class="popular-brands-content">
    <?php 
    $select_produs= mysqli_query($conn, "SELECT * FROM `produse`") or die('Nu se poate accesa tabelul produse');
    if(mysqli_num_rows($select_produs)>0){
        while($fetch_produse=mysqli_fetch_assoc($select_produs)){
            ?>
<form method="post" class="card">
    <img src="imagini/<?php echo $fetch_produse['imagine'];?>">
    <div class="pret"><?php echo $fetch_produse['pret'];?></div>
    <div class="nume"> <?php echo $fetch_produse['nume'];?></div>

    <input type="hidden" name="produs_id" value="<?php echo $fetch_produse['id'];?>">
    <input type="hidden" name="nume_produs" value="<?php echo $fetch_produse['nume'];?>">
    <input type="hidden" name="pret_produs" value="<?php echo $fetch_produse['pret'];?>">
    <input type="hidden" name="cantitate_produs" value="1" min="1">
    <input type="hidden" name="imagine_produs" value="<?php echo $fetch_produse['imagine'];?>">
<div class="icon">
    <a href="view_page.php?pid=<?php echo $fetch_produse['id']; ?>" class="bi bi-eye-fill"></a>
    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
        </div>
        </form>


        <?php

        }
    }else{
        echo'<p class="empty">Inca nu au fost adaugate produse</p>';
    }
    ?>
    </section>



    <script src="jguary.js"></script>
    <script src="slick.js"></script>

    <script type="text/javascript">
    $('.popular-brands-content').slick({
  lazyLoad: 'ondemand',
  slidesToShow: 4,
  slidesToScroll: 1,
  nextArrow: $('.controls .right'),
  prevArrow: $('.controls .left'),
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
    </script>
</body>
</html>