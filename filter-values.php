<?php
    // Получаем минимальное значение price из таблицы projects
    $sqlMinPrice = "SELECT MIN(price) AS minPrice FROM projects";
    $resultMinPrice = $conn->query($sqlMinPrice);

    $minPriceRow = $resultMinPrice->fetch_assoc();
    $minPrice = $minPriceRow['minPrice'];

    // Получаем максимальное значение price из таблицы projects
    $sqlMaxPrice = "SELECT MAX(price) AS maxPrice FROM projects";
    $resultMaxPrice = $conn->query($sqlMaxPrice);

    $maxPriceRow = $resultMaxPrice->fetch_assoc();
    $maxPrice = $maxPriceRow['maxPrice'];

    // Получаем минимальное значение square из таблицы projects
    $sqlMinSquare = "SELECT MIN(square) AS minSquare FROM projects";
    $resultMinSquare = $conn->query($sqlMinSquare);

    $minSquareRow = $resultMinSquare->fetch_assoc();
    $minSquare = $minSquareRow['minSquare'];

    // Получаем максимальное значение square из таблицы projects
    $sqlMaxSquare = "SELECT MAX(square) AS maxSquare FROM projects";
    $resultMaxSquare = $conn->query($sqlMaxSquare);

    $maxSquareRow = $resultMaxSquare->fetch_assoc();
    $maxSquare = $maxSquareRow['maxSquare'];

    // Закрываем запрос, так как будем выполнять еще один
    $resultMinPrice->close();
    $resultMaxPrice->close();
    $resultMinSquare->close();
    $resultMaxSquare->close();

?>