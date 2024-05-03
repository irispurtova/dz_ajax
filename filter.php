<?php
require "connect.php";

if (isset($_POST['sortDirection'])) {
    $sortDirection = $_POST['sortDirection'];
} else {
    $sortDirection = 0;
}

if (isset($_POST['areaSortDirection'])) {
    $areaSortDirection = $_POST['areaSortDirection'];
} else {
    $areaSortDirection = 0;
}

// Проверка наличия данных и их валидности
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : $minPrice;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : $maxPrice; // Используем максимальное значение из базы данных
$minSquare = isset($_POST['minSquare']) ? intval($_POST['minSquare']) : $minSquare;
$maxSquare = isset($_POST['maxSquare']) ? intval($_POST['maxSquare']) : $maxSquare; // Используем максимальное значение из базы данных

// Дополнительная проверка на корректность диапазона значений
if ($minPrice < 0 || $maxPrice < 0 || $minSquare < 0 || $maxSquare < 0 || $minPrice > $maxPrice || $minSquare > $maxSquare) {
    die("Некорректные значения фильтра.");
}

if (isset($_POST['minPrice'])||isset($_POST['maxPrice'])||isset($_POST['minSquare'])||isset($_POST['maxSquare'])) {
    $sql = "SELECT 
    p.id, p.namepr, p.price, p.square, p.technology, 
    (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) 
    AS img_src 
    FROM projects p 
    WHERE price BETWEEN $minPrice AND $maxPrice 
    AND square BETWEEN $minSquare AND $maxSquare";
}
else {
    $sql = "SELECT p.id, p.namepr, p.price, p.square, p.technology (SELECT i.img_src FROM images i WHERE i.id = p.id LIMIT 1) AS img_src FROM projects p";
}

// сортировка по цене добавляет order by
if ($sortDirection == 1) {
    $sql .= " ORDER BY price ASC";
} elseif ($sortDirection == 2) {
    $sql .= " ORDER BY price DESC";
} 

// сортировка по площади добавляет order by
if ($areaSortDirection == 1) {
    $sql .= " ORDER BY square ASC";
} elseif ($areaSortDirection == 2) {
    $sql .= " ORDER BY square DESC";
} 

if (($sortDirection == 0)&&($areaSortDirection == 0)) {
    $sql .= " ORDER BY id";
}

//echo $sql;

$result = $conn->query($sql);

include "print_project.php";
?>