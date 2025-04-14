<?php

$db = new mysqli('localhost', 'root', '', 'book_catalog');

$sql = "SELECT * FROM person";

$result = $db->query($sql);
if($result == false) {
    die("Błąd w zapytaniu!");
}

while ($row = $result->fetch_assoc()) {

    $id = $row['id'];
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    echo "ID: $id, Imię: $firstName, Nazwisko: $lastName <br>";
}

$db->close();
