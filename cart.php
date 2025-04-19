<?php
$conn = new mysqli("localhost", "root", "", "3dmodels");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных от клиента
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->modelId)) {
    // Если данные не были получены или отсутствует modelId, вернуть ошибку
    http_response_code(400); // Ошибка "Плохой запрос"
    echo json_encode(array("message" => "Неправильные данные."));
    exit();
}

// Предполагая, что у вас есть сессия и в ней хранится buyer_id текущего пользователя
$buyerId = $_SESSION['buyer_id'];

if (!$buyerId) {
    // Отладочное сообщение, если buyer_id отсутствует в сессии
    error_log("buyer_id отсутствует в сессии");
}

// Вставка данных в таблицу confirm_buy
$sql = "INSERT INTO confirm_buy (sales_id, buyer_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $data->modelId, $buyerId);

if ($stmt->execute()) {
    // Успешно вставлено, вернуть успешный ответ
    http_response_code(200); // ОК
    echo json_encode(array("message" => "Покупка успешно подтверждена."));
} else {
    // Ошибка при вставке
    http_response_code(500); // Внутренняя ошибка сервера
    echo json_encode(array("message" => "Произошла ошибка при подтверждении покупки."));
    
    // Отладочное сообщение, если есть ошибка при вставке
    error_log("Ошибка при вставке данных: " . $stmt->error);
}

// Закрыть соединение с базой данных
$conn->close();
?>
