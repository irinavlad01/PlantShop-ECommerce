<?php

include "dbh.php";

$sql = "DELETE FROM clienti WHERE id = 124";

$result = mysqli_query($conn, $sql);
if($result){
    echo "Succesful";
} else {
    echo "Error";
}

