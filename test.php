<?php
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

stocProdus("Trandafiri");