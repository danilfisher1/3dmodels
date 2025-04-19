<?php
// Предполагается, что $conn - это ваше подключение к БД
$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
// Включаем отображение ошибок (для отладки)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['model_id'])) {
    $modelId = intval($_POST['model_id']);

    echo "Отладка: model_id = $modelId\n"; // Отладка

    // Пытаемся удалить модель
    $sql = "DELETE FROM models WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Проверяем успешность подготовки запроса
    if (!$stmt) {
        echo "Ошибка подготовки запроса: " . mysqli_error($conn) . "\n"; // Отладка
        exit;
    }

    $stmt->bind_param("i", $modelId);
    if (!$stmt->execute()) {
        // Если SQL выполнить не удалось, выводим ошибку
        echo "Ошибка выполнения запроса: " . $stmt->error . "\n"; // Отладка
    } else {
        if ($stmt->affected_rows > 0) {
            echo 'Модель удалена.';
        } else {
            echo 'Ни одна запись не была удалена. Возможно, модель с таким ID не существует.' . "\n"; // Отладка
        }
    }

    $stmt->close();
} else {
    echo 'Неверный запрос. Переданы не все необходимые данные.' . "\n"; // Отладка
}

$conn->close();
?>
