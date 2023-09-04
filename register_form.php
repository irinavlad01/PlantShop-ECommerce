<?php
    include "dbh.php";

    if(isset($_POST['submit'])){
        $nume = mysqli_real_escape_string($conn, $_POST['nume']);
        $prenume = mysqli_real_escape_string($conn, $_POST['prenume']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $parola = mysqli_real_escape_string($conn, $_POST['parola']);

        $select = mysqli_query($conn, "SELECT * FROM clienti WHERE email = '$email';") or die('first query failed');

        if(mysqli_num_rows($select)>0){
            $message[] = 'Utilizatorul exista deja!';
        } else {
            mysqli_query($conn, "INSERT INTO clienti (nume, prenume, email, parola) VALUES ('$nume', '$prenume', '$email', '$parola');") or die('second query failed');
            $message[] = 'Inregistrare cu succes!';
            header('location: login.php?register=succes');
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
        <h1 style="color: #523705; text-align: center;">Inregistrare</h1>
        <input type="text" name="nume" required placeholder="Intoduceti nume" class="formular_boxes">
        <br>
        <input type="text" name="prenume" required placeholder="Intoduceti prenume" class="formular_boxes">
        <br>
        <input type="email" name="email" required placeholder="Intoduceti email" class="formular_boxes">
        <br>
        <input type="password" name="parola" required placeholder="Intoduceti parola" class="formular_boxes">
        <br>
        <input type="submit" name="submit" value="Inregistrare" class="button_button">
        <br>
        <a href="login.php" class="button_link">
            <button type="button" class="button_button">Autentifica-te!</button>
        </a>

    </form>
</div>
    
</body>
</html>