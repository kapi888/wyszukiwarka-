<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <?php
    $id = $_REQUEST['id'];

    $db = new mysqli('localhost', 'root', '', 'book_catalog');
    $sql = "SELECT book.id, title.book_title AS title, 
        CONCAT(author.first_name, ' ', author.last_name) AS author
        FROM book 
        LEFT JOIN author ON author.ID = book.author 
        LEFT JOIN title ON title.ID = book.title
        WHERE book.id = $id
        LIMIT 1";    
    $result = $db->query($sql);
    $book = $result->fetch_assoc();
    ?>

    Czy jestes pewien, że chcesz usunąć poniższą książkę: <br>
    <?php
    echo $book['title'] . ' - ' . $book['author'];
    ?>
    <br>
    <a href="delete.php?id=<?php echo $id; ?>">Tak</a>
    <a href="index.php">Nie</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>