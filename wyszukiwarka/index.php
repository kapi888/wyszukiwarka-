<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>wyszukiwanie wg. autora</h1>
    <form action="index.php" method="post">
        <div class="row">
            <label for="name" class="col form-label">Nazwisko autora:</label>
            <input type="text" name="name" id="name" class="col form-control">
            <input type="submit" value="Szukaj" class="col btn btn-primary">
        </div>
    </form>
    <?php
    $name = "%";
    if (isset($_POST['name'])) {
        $name = "%" . $_POST['name'] . "%";
    }

    
    $sql = "SELECT 
        book.id,
        CONCAT(author.first_name, ' ', author.last_name) AS author, 
        title.book_title AS title 
        FROM book 
        LEFT JOIN author ON author.ID = book.author 
        LEFT JOIN title ON title.ID = book.title 
        WHERE author.last_name LIKE '" . $name . "' 
        OR author.first_name LIKE '" . $name . "'";

    
    $db = new mysqli('localhost', 'root', '', 'book_catalog');
    $result = $db->query($sql);

   
    echo '<table class="table">';
    echo "<tr><th>ID</th><th>Autor</th><th>Tytuł</th><th>Edytuj</th><th>Usuń</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $author = $row['author'];
        $title = $row['title'];
        $editLink = '<a href="edit.php?id=' . $id . '">Edytuj</a>';
        $removeLink = '<a href="remove.php?id=' . $id . '">Usun</a>';
        echo "<tr>";
        echo "<td>$id</td><td>$author</td><td>$title</td>";
        echo "<td>$editLink</td><td>$removeLink</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>