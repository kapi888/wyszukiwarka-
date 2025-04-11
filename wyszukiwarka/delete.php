<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

 
    $db = new mysqli("localhost", "root", "", "book_catalog");

  
    if ($db->connect_error) {
        die("Błąd połączenia: " . $db->connect_error);
    }

 
    $sql = "DELETE FROM book WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        echo "Błąd podczas usuwania książki.";
    }

    $stmt->close();
    $db->close();
} else {
    echo "Nieprawidłowe żądanie.";
}
?>