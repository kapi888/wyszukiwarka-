<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (!isset($_POST['id']) || !isset($_POST['title'])) { 
        die("Błąd: Brak wymaganych danych."); 
    } 

    $id = intval($_POST['id']); 
    $title_name = trim($_POST['title']); 

    $db = new mysqli("localhost", "root", "", "book_catalog"); 

    if ($db->connect_error) { 
        die("Błąd połączenia: " . $db->connect_error); 
    } 

    $stmt = $db->prepare("SELECT id FROM book WHERE id = ?"); 
    $stmt->bind_param("i", $id); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($row = $result->fetch_assoc()) { 
        $stmt = $db->prepare("SELECT id FROM title WHERE book_title = ?");
        $stmt->bind_param("s", $title_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($title_row = $result->fetch_assoc()) {
            $title_id = $title_row['id'];
        } else {
            $stmt = $db->prepare("INSERT INTO title (book_title) VALUES (?)");
            $stmt->bind_param("s", $title_name);
            if ($stmt->execute()) {
                $title_id = $stmt->insert_id;
            } else {
                die("Błąd: Nie udało się dodać nowego tytułu.");
            }
        }

        $stmt = $db->prepare("UPDATE book SET title = ? WHERE id = ?"); 
        $stmt->bind_param("ii", $title_id, $id);

        if ($stmt->execute()) { 
            header("Location: index.php?msg=updated"); 
            exit(); 
        } else { 
            echo "Błąd aktualizacji książki."; 
        }
    } else { 
        echo "Błąd: Książka o podanym ID nie istnieje."; 
    } 

    $stmt->close(); 
    $db->close();
} 
?>