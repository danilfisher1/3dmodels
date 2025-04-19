<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['model_id'], $_POST['seller_id'])) {
    $modelId = intval($_POST['model_id']);
    $buyerId = $_SESSION['user_id'];
    $sellerId = intval($_POST['seller_id']);

    // Попытка добавления записи в таблицу purchases
    $sql = "INSERT INTO purchases (buyer_id, seller_id, model_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iii", $buyerId, $sellerId, $modelId);
        if ($stmt->execute()) {
            echo 'Покупка успешно совершена.';
        } else {
            echo 'Не удалось совершить покупку.';
        }
        $stmt->close();
    } else {
        echo 'Ошибка запроса: ' . $conn->error;
    }
} else {
    echo 'Неверный запрос.';
}

$conn->close();
?>