<?php
// Подключение к базе данных
$mysqli = new mysqli("localhost", "root", "", "3dmodels");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения к базе данных: " . $mysqli->connect_error);
}

// Запрос данных из таблицы "models"
$query = "SELECT * FROM models"; // Обратите внимание, что используется название таблицы "models"
$result = $mysqli->query($query);

// Проверка наличия данных
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Вывод данных на страницу
        echo "ID: " . $row["id"] . "<br>";
        echo "Название: " . $row["name"] . "<br>";
        echo "Описание: " . $row["description"] . "<br>";
        echo "Цена: " . $row["price"] . "<br>";
        echo "Изображение: " . $row["image_url"] . "<br>";
        echo "Полигонаж: " . $row["polygon_count"] . "<br>";
        echo "<hr>";
    }
} else {
    echo "Нет доступных данных.";
}

// Закрытие соединения с базой данных
$mysqli->close();
?>