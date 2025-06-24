<?php
require('connection.php');
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location: login.php');
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location: login.php');
    exit;
}


    //adaugare produse in lista  de dorinte
    if(isset($_POST['add_to_wishlist'])){
        $produs_id = $_POST['produs_id'];
        $nume_produs = $_POST['nume_produs'];
        $pret_produs = $_POST['pret_produs'];
        $imagine_produs = $_POST['imagine_produs'];

        $numar_dorinte = mysqli_query($conn, "SELECT * FROM lista_de_dorinte WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');
        $nr_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');

        if(mysqli_num_rows($numar_dorinte) > 0){
            $mesaj[] = 'Produsul deja există în lista de dorințe';
        } else if(mysqli_num_rows($nr_cart) > 0){
            $mesaj[] = 'Produsul deja există în coș';
        } else {
            mysqli_query($conn, "INSERT INTO lista_de_dorinte(user_id, pid, nume, pret, imagine) VALUES ('$user_id', '$produs_id', '$nume_produs','$pret_produs','$imagine_produs')");
            $mesaj[] = 'Produsul a fost adăugat cu succes în lista de dorințe!';
        }
    }


    //adaugare produse in lista  de cos
    if(isset($_POST['add_to_cart'])){
        $produs_id = $_POST['produs_id'];
        $nume_produs = $_POST['nume_produs'];
        $pret_produs = $_POST['pret_produs'];
        $imagine_produs = $_POST['imagine_produs'];
        $cantitate_produs = $_POST['cantitate_produs'];



        $nr_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE nume = '$nume_produs' AND user_id = '$user_id'") or die('Nu s-a putut accesa bd');


        if(mysqli_num_rows($nr_cart) > 0){
            $mesaj[] = 'Produsul deja există în coș';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(`user_id`, `pid`, `nume`, `pret`, `cantitate`,`imagine`) VALUES ('$user_id', '$produs_id', '$nume_produs','$pret_produs','$cantitate_produs','$imagine_produs')");
            $mesaj[] = 'Produsul a fost adăugat cu succes în cosul de cumparaturi!';
        }
    }
?>

<style type="text/css">
    <?php include 'main.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <title>Acasa</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detalii">
            <h1> KidoClub</h1>
            <p> Bine ați venit la KidoClub, destinația preferată pentru hainele copiilor! Suntem mândri să vă oferim o gamă largă și variată de haine pentru cei mici, de la nou-născuți până la adolescenți. La noi veți găsi cele mai recente tendințe în modă pentru copii, într-o varietate de stiluri, culori și mărimi. Explorați colecția noastră și transformați garderoba copiilor într-o sursă de bucurie și stil! </p>
        </div>
    </div>
    <!-------Slider-------->
    <div class="container-fluid">
        <div class="hero-slider">
            <div class="slider-item">
                <img src="img/slider.jpg">
                <div class="slider-caption">
                    <span> Test The Quality</span>
                    <h1>  Premium <br> Clothes</h1>
                    <p> Enjoy the style</p>
                    <a href="shop.php" class="btn"> Cumpara</a>
                </div>
            </div>
            <div class="slider-item">
                <img src="img/slider2.jpg">
                <div class="slider-caption">
                    <span> Test The Quality</span>
                    <h1>  Premium <br> Clothes</h1>
                    <p> Enjoy the style</p>
                    <a href="shop.php" class="btn"> Cumpara</a>
                </div>
            </div>
        </div>

        <div class="controls">
        <i class="bi bi-chevron-left prev"></i>
        <i class="bi bi-chevron-right next"></i>
        </div>

    </div>

    <div class="line"></div>

        <div class="services">
            <div class="row">
                
            <div class="box">
                    <img src="img/0.png">
                    <div>
                        <h1> Cumparaturi Rapide</h1>
                    </div>
                </div>

                <div class="box">
                    <img src="img/1.png">
                    <div>
                        <h1> Returnare & Garanție</h1>
                    </div>
                </div>

                <div class="box">
                    <img src="img/2.png">
                    <div>
                        <h1> Suport Online 24/7</h1>
                    </div>
                </div>

            </div>
        </div>
    
        <div class="line2"></div>
        <div class="story">
            <div class="row">
                <div class="box">
                    <span> Povestea noastră</span>
                    <h1> Producerea hainelor de calitate încă din 2018</h1>
                    <p>Cu multă pasiune și determinare, am căutat cu grijă locul potrivit și am ales cele mai frumoase și practice haine pentru cei mici. După luni de pregătiri și emoții, într-o zi însorită de primăvară, "KidoClub" și-a deschis ușile pentru prima dată. A fost un moment de bucurie și entuziasm pentru întreaga noastră familie.

De atunci, am devenit mai mult decât un simplu magazin pentru copii. Am creat o comunitate a părinților și a copiilor care împărtășesc aceeași pasiune pentru frumos și pentru calitate.

La "KidoClub", ne străduim să oferim nu doar haine de calitate, ci și o atmosferă plină de căldură și bunătate. Suntem mândri să fim parte din viața voastră și să vă ajutăm să vă îmbrăcați micuții cu cele mai frumoase și practice haine, astfel încât să se simtă confortabil și să arate minunat în fiecare zi.

Vă mulțumim că sunteți alături de noi în această călătorie minunată!</p>
                         <a href="shop.php" class="btn">Cumpara acum</a>
                </div>
                <div class="box">
                    <img src="img/magazin.jpg">
                </div>
            </div>
        </div>
        <div class="line3">
            <?php /*include 'homeshop.php'*/ ?>
            <?php include 'footer.php' ?>
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
            <script type="text/javascript" src="script2.js"></script>
        </div>
    </div>
</body>
</html>