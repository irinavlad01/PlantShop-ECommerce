<?php
include 'dbh.php';

session_start();

if(isset($_POST['submit'])){

    // Preluam datele de pe formular
    $email = htmlentities($_POST['email'], ENT_QUOTES);
    $password = htmlentities($_POST['parola'], ENT_QUOTES);

    // Extragem informatiile din baza de date
    $sql="SELECT * FROM clienti WHERE email = '$email' AND parola = '$password'";
    $select = mysqli_query($conn, $sql) or die('Query failed');
    $rowcount=mysqli_num_rows($select);

    if (($rowcount) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:produse.php?login=success');
    }
    else {
        $message[] = 'Incorrect password or email!';
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
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

<?php
if(isset($message)){
    foreach($message as $message){
        echo '<div class="message" onclick="this.remove();"><p class="message_message">'.$message.'</p></div>';
    }
}
?>

<div class="formular_container">
    <form action="" method="post" class="formular_formular">
        <h3>Autentificare</h3>
        <p><input type="email" name="email" required placeholder="Introduceti email" class="formular_boxes"></p>
        <p><input type="password" name="parola" required placeholder="Introduceti parola" class="formular_boxes"></p>
        <p><input type="submit" name="submit" value="Log in" class="button_button"></p>
        <p>Nu ai cont?</p>
        <a href="register_form.php" class="button_link">
            <button type="button" class="button_button">Inregistreaza-te!</button>
        </a>
    </form>

</div>

</body>
</html>