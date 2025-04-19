<?php
// Установка соединения с базой данных
$conn = new mysqli("localhost", "root", "", "3dmodels");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION['user_id']; // Используем user_id из сессии

// Выполнение SQL-запроса для выбора моделей, выложенных пользователем
$models_query = "SELECT * FROM models WHERE user_id = $user_id";

$models_result = $conn->query($models_query);

$models_data = array();

if ($models_result->num_rows > 0) {
    // Собираем данные о моделях в массив
    while ($model = $models_result->fetch_assoc()) {
        $models_data[] = array(
            'id' => $model['id'],
            'name' => $model['name'],
            'price' => $model['price'],
            'image_url' => $model['image_url']
        );
    }
}

echo "Hello, PHP is working!";


// Закрываем соединение с базой данных
$conn->close();

// Возвращаем данные в формате JSON
header('Content-Type: application/json');
echo json_encode($models_data);
?>
