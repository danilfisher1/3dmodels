<?php
// Создайте подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");

// Проверьте подключение к базе данных
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $searchQuery = $_POST['query'];

    // Используйте подготовленные выражения для защиты от SQL-инъекций
    $stmt = $pdo->prepare("SELECT id, name FROM models WHERE name LIKE ?");
    $stmt->execute(["%{$searchQuery}%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Возвращаем результат в формате JSON
    echo json_encode($results);
}
 else {
    // Выведите сообщение об ошибке, если параметр query не передан
    echo "Ошибка: Параметр 'query' не передан.";
}
?>
