<?php
    include "dbh.php";
    session_start();

    $user_id =  $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location: login.php');  
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cactusi</title>
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
                $select_user = mysqli_query($conn, "SELECT * FROM clienti WHERE id='$user_id';");
                if(mysqli_num_rows($select_user) > 0){
                    $fetch_user = mysqli_fetch_assoc($select_user);
                }

                ?>
                    <p>Bine ai revenit, <?php echo $fetch_user['nume'] . " " . $fetch_user['prenume']?>!</p>
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
    <h1 class="page_title">Cactusi</h1>

    <div class="wrapper grid">
    <?php
        $sql = "SELECT * FROM produse WHERE cod_categ = 3;";

        if($result = $conn->query($sql)){
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){

    ?> 
        <form action="cos.php" method="post">
            <div class="img_container">
                <p class="img_description"><?php echo $row['denumire']; ?></p>
                <img src="images/<?php echo $row['imagine']; ?>" alt="<?php echo $row['denumire']; ?>" class="img_img">
            </div>
            <div>Pret: <?php echo $row['pret']; ?></div>
            <span class="navbar__btn"><input type="number" min="1" max="<?php echo $row['stoc']; ?>" name="cantitate_produs" value="1"></span>
            <input type="hidden" name="imagine_produs" value="<?php echo $row['imagine']; ?>">
            <input type="hidden" name="denumire_produs" value="<?php echo $row['denumire']; ?>">
            <input type="hidden" name="pret_produs" value="<?php echo $row['pret']; ?>">
            <span class="navbar__btn"><input type="submit" value="Adauga in cos" name="add_to_cart" class="button"></span>
        </form>

    <?php
        
                }
            }
        }
    ?>
    </div>

<?php
        if(isset($message)){
            foreach($message as $message){
                echo '<div onclick="this.remove()";>' . $message . '</div>';
         }
        }
    ?>
</body>
</html>