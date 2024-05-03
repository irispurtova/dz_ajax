<?php
// Подключение к базе данных
require "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из AJAX-запроса
    $projectName = $_POST['namepr'];
    $projectPrice = $_POST['price'];
    $projectArea = $_POST['square'];
    $technology = implode(", ", $_POST['technology']);

    $conn->begin_transaction();

    try {
        // Вставка данных в таблицу 'projects'
        $sqlTest = "INSERT INTO projects (namepr, price, square, technology) VALUES ('$projectName', '$projectPrice', '$projectArea', '$technology')";
        if ($conn->query($sqlTest) !== TRUE) {
            throw new Exception("Ошибка при добавлении данных в таблицу 'projects': " . $connect->error);
        }

        // Получение id только что вставленной записи в таблицу 'projects'
        $lastInsertedId = $conn->insert_id;

        // Получение данных из загруженных файлов
        $targetDirectory = "uploads/";
        $uploadedImages = [];

        foreach ($_FILES["projectImage"]["tmp_name"] as $key => $tmp_name) {
            $fileName = basename($_FILES["projectImage"]["name"][$key]);
            $targetFilePath = $targetDirectory . $fileName;

            if (move_uploaded_file($tmp_name, $targetFilePath)) {
                $uploadedImages[] = $targetFilePath;

                // Вставка данных в таблицу 'images'
                $sqlImages1 = "INSERT INTO images (id, img_src) VALUES ('$lastInsertedId', '$targetFilePath')";
                if ($conn->query($sqlImages1) !== TRUE) {
                    throw new Exception("Ошибка при добавлении изображения в таблицу 'images': " . $connect->error);
                }
            } else {
                throw new Exception("Ошибка при загрузке изображения $fileName.");
            }
        }

        // Фиксация транзакции
        $conn->commit();
    } catch (Exception $e) {
        // Откат транзакции в случае ошибки
        $conn->rollback();
        echo "Ошибка: " . $e->getMessage();
    }
}

$conn->close();
?>
