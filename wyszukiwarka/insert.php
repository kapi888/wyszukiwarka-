<?php

if(isset($_POST['submit'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
 
    $db = new mysqli('localhost','root','','db');

    $sql = "INSERT INTO person (firstName, lastName) 
                VALUES ('$firstName', '$lastName')";
  
    if($db->query($sql)) {
        echo "Dodano rekord do bazy danych";
    } else {
       
        echo "Błąd podczas dodawania rekordu do bazy danych";
    }
}
?>

<form action="insert.php" method="post">
    <input type="text" name="firstName" placeholder="Imię">
    <input type="text" name="lastName" placeholder="Nazwisko">
    <input type="submit" name="submit" value="Wyślij">
</form>