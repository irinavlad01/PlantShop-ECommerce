<?php
    include "dbh.php";
    session_start();

    $user_id =  $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location: login.php');  
   } 

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['add_to_cart'])){
        /*
            $denumire_produs = $_POST['denumire_produs'];
            $imagine_produs = $_POST['imagine_produs'];
            $pret_produs = $_POST['pret_produs'];
            $cantitate_produs = $_POST['cantitate_produs'];

            $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE 'denumire_produs' = '$denumire_produs' AND 'user_id' = '$user_id'") or die ('failed 1');

            if(mysqli_num_rows($select_cart) > 0){
                $message[] = 'poduct ALREADY added to cart!';
            } else {
                mysqli_query($conn, "INSERT INTO cart ('denumire_produs', 'imagine_produs', 'pret_produs', 'cantitate_produs', 'user_id') VALUES ('$denumire_produs', '$imagine_produs', '$pret_produs', '$cantitate_produs', '$user_id');") or die ('failed 2');
                $message[] = 'product added!';
                $message[] = $denumire_produs;
                $message[] = $imagine_produs;
                $message[] = $pret_produs;
                $message[] = $cantitate_produs;
                $message[] = $user_id;

            }


            //metoda procedurala, care nu mergea in situatia asta
            */

            //metoda oop

            $sql = "INSERT INTO cart (denumire_produs, imagine_produs, pret_produs, cantitate_produs, user_id) VALUES (?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($sql);

            $denumire_produs = $_POST['denumire_produs'];
            $imagine_produs = $_POST['imagine_produs'];
            $pret_produs = $_POST['pret_produs'];
            $cantitate_produs = $_POST['cantitate_produs'];

            $stmt->bind_param('ssiii', $denumire_produs, $imagine_produs, $pret_produs, $cantitate_produs, $user_id);
            $stmt->execute();
            $message=[];



            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="message "onclick="this.remove()";>' . $message . '</div>';
            }
            }

    }
    }

    if(isset($_POST['remove'])){
        $id = $_POST['id_produs'];
        $cantitate = $_POST['cantitate_produs'];
        $denumire = $_POST['denumire_produs'];
        $sql1 = "DELETE FROM cart WHERE id = $id";
        //$sql2 = "UPDATE produse SET stoc = stoc + $cantitate WHERE denumire = $denumire";
        $result2 = $conn->query($sql1);
        //$result3 = $conn->query($sql2);

        if($result2){
            $message[] = 'Deleted succesfully';
            header('location:cos.php?remove=succesful');
        } 
    }

    if(isset($_POST['update'])){
        $cantitate_produs = $_POST['cantitate_produs'];
        $id_produs = $_POST['id_produs'];
        $sql4 = "UPDATE cart SET cantitate_produs = '$cantitate_produs' WHERE id = '$id_produs'";
        $result5 = $conn->query($sql4);

        if($result5){
            $message[] = 'Updated succesfully';
            header('location:cos.php?update=succesful');
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Shop - Cos</title>
    <link rel="icon" type="image/x-icon" href="images/logo.ico">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Quicksand&display=swap');
    </style>
    
</head>
<body>
<nav class="navbar">
        <div class="navbar__container">
            
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="produse.php" class="navbar__links">
                        Home
                    </a>
                </li>
                <li class="navbar__item" >
                    <a href="plante_verzi.php" class="navbar__links">
                        Plante verzi
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="flori.php" class="navbar__links">
                        Flori
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="cactusi.php" class="navbar__links">
                        Cactusi
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="plante_false.php" class="navbar__links">
                        Plante false
                    </a>
                </li>
                <li class="navbar__btn">
                    <a href="user.php" class="button">
                    <?php
                    $sql = "SELECT nume, prenume FROM clienti WHERE id=$user_id" or die('failed');
                    $result = $conn->query($sql);

                    if($result){
                    if($result->num_rows > 0){
                       $fetch_user = $result->fetch_assoc();
                       echo "<p>Bine ai revenit, " . $fetch_user['nume'] . " " . $fetch_user['prenume'] . "!</p>";
                    }

                }
                ?>
                    </a>
                </li>
                <li class="navbar_btn">
                    <a href="cos.php" id="navbar__logo">
                        <img src="images/favicon.png" alt="shopping cart" style="width: 80px; height: auto;">
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <h1 style="text-align: left; margin: 20px; color: #523705;" >Coș</h1>
    <?php
        //functie pentru a returna stocul unui produs => pentru maximul de cantitate ce poate fi updated in cos
        function stocProdus($denumire_produs){
            include "dbh.php";
            $sql = "SELECT * FROM produse WHERE denumire = '$denumire_produs';";
        
            if($result = $conn->query($sql)){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo $row['stoc'];
                }
            }
        }
        }

        $sql = "SELECT * FROM cart WHERE user_id = '$user_id';";

        if($result = $conn->query($sql)){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
    ?>

    <div class="wrapper grid">
        <div class="img_container">
                <p class="img_description"><?php echo $row['denumire_produs']; ?></p>
                <img src="images/<?php echo $row['imagine_produs']; ?>" alt="<?php echo $row['denumire_produs']; ?>" class="img_img">
        </div>
        <div>Pret: <?php echo $row['pret_produs'] * $row['cantitate_produs']; ?> lei  <!-- Cantitate:  <?php // echo $row['cantitate_produs']; ?>--> </div>
        <div>
            <form action="" method="post">
                <input type="hidden" name="id_produs" value="<?php echo $row['id']?>">
                Cantitate: <input type="number" name="cantitate_produs" min="1" max="<?php stocProdus($row['denumire_produs'])?>" value="<?php echo $row['cantitate_produs']?>">
            <input type="submit" name="update" value="Modificati" class="button_button">
            </form>
            <br>
            <form action="" method="post">
                <input type="hidden" name="denumire_produs" value="<?php echo $row['denumire_produs']?>">
                <input type="hidden" name="cantitate_produs" value="<?php echo $row['cantitate_produs']?>">
                <input type="hidden" name="id_produs" value="<?php echo $row['id']?>">
                <input type="submit" name="remove" value="Stergeti produs" class="button_button">
            </form>
        </div>
    </div>
    <?php
                }
            }
            else{
                echo"<h3 style='text-align: center'>Cosul este gol!</h3>";
            }
        }
        if(isset($message)){
            foreach($message as $message){
                echo '<div class="message "onclick="this.remove()";>' . $message . '</div>';
        }
    }

    ?>

    </body>
</html>