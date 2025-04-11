<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj książkę</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="mt-4">Edytuj książkę</h1>

    <?php 
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("<p class='text-danger'>Nieprawidłowe ID.</p>");
    }

    $id = $_GET['id'];

    $db = new mysqli('localhost', 'root', '', 'book_catalog');

    if ($db->connect_error) {
        die("<p class='text-danger'>Błąd połączenia: " . $db->connect_error . "</p>");
    }

    $sql = "SELECT 
                book.id, 
                CONCAT(author.first_name, ' ', author.last_name) AS author,  
                title.book_title AS title 
            FROM book  
            LEFT JOIN author ON author.ID = book.author  
            LEFT JOIN title ON title.ID = book.title  
            WHERE book.id = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $author = htmlspecialchars($row['author']);
        $title = htmlspecialchars($row['title']);
    } else {
        die("<p class='text-danger'>Nie znaleziono książki.</p>");
    }

    $stmt->close();
    $db->close();
    ?>

<form action="save.php" method="post"> 
    <input type="hidden" name="id" value="<?php echo $id; ?>"> 
 
    <label for="author">Autor:</label> 
    <input type="text" name="author" id="author" value="<?php echo $author; ?>" readonly> 
 
    <label for="title">Tytuł:</label> 
    <input type="text" name="title" id="title" value="<?php echo $title; ?>"> 
 
    <input type="submit" value="Zapisz" class="btn btn-primary"> 
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>