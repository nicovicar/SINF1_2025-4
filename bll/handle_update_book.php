<?php
require_once("../dsl/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);

    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];
    $editor = $_POST["editor"];
    $language = $_POST["language"];
    $weight = $_POST["weight"];
    $binding = $_POST["binding"];
    $pages = intval($_POST["pages"]);
    $price = floatval($_POST["price"]);
    $date = $_POST["date_of_acquisition"];
    $description = $_POST["description"];
    $importance = intval($_POST["importance"]);

    $stmt = $conn->prepare("SELECT image FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentImage);
    $stmt->fetch();
    $stmt->close();

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $newImage = "../fotos/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $newImage);
    } else {
        $newImage = $currentImage; 
    }

    
    $stmt = $conn->prepare("
        UPDATE books SET 
            title = ?, author = ?, year = ?, editor = ?, language = ?, 
            weight = ?, binding = ?, pages = ?, price = ?, 
            date_of_acquisition = ?, description = ?, importance = ?, image = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "sssssssidssisi",
        $title, $author, $year, $editor, $language,
        $weight, $binding, $pages, $price,
        $date, $description, $importance, $newImage,
        $id
    );

    if ($stmt->execute()) {
        header("Location: ../ui/book.php?id=" . $id);
        exit();
    } else {
        echo "Erro ao atualizar o livro.";
    }

    $stmt->close();
}

$conn->close();
?>
