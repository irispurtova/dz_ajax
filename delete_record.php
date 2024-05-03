<?php
// Подключение к базе данных и обработка запроса на удаление записи
require "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recordId'])) {
    $recordId = $_POST['recordId'];

    // Запрос на удаление записи
    $sql = "DELETE FROM projects WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        echo "Запись успешно удалена";
    } else {
        echo "Ошибка удаления записи: " . $conn->error;
    }

    // Закрытие соединения
    $conn->close();
} else {
    echo "Неверный запрос";
}
?>
