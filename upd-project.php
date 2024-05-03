<?php
// Подключение к базе данных и обработка запроса на изменение проекта
require "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordId'])) {
    $recordId = $_POST['recordId'];
    $editedName = $_POST['editedName'];
    $editedPrice = $_POST['editedPrice'];
    $editedSquare = $_POST['editedSquare'];
    $editedTechnology = $_POST['editedTechnology'];

    // Запрос на изменение проекта
    $sql = "UPDATE projects SET namepr='$editedName', price='$editedPrice', square='$editedSquare', technology='$editedTechnology' WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        echo "Проект успешно изменен";
    } else {
        echo "Ошибка изменения проекта: " . $conn->error;
    }

    // Закрытие соединения
    $conn->close();
} else {
    echo "Неверный запрос";
}
?>
