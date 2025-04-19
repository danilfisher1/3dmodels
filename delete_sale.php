<?php
$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if (isset($_POST['sale_id'])) {
    $saleId = $_POST['sale_id'];

    // SQL-запрос на удаление записи из таблицы sales
    $sql = "DELETE FROM sales WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $saleId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Запись о продаже удалена";
    } else {
        echo "Ошибка при удалении записи о продаже";
    }
    $stmt->close();
}

$conn->close();
?>
