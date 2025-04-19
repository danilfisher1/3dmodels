<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка отправленной формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $polygon_count = $_POST["polygon_count"];
    $vehicle_type_id = $_POST["vehicle_type_id"];
    $model_name = $_FILES["model"]["name"];

    // Путь для загрузки модели
    $target_dir = "model_uploads/";
    $target_file = $target_dir . basename($_FILES["model"]["name"]);

    move_uploaded_file($_FILES["model"]["tmp_name"], $target_file);
    $user_id = $_SESSION['user_id'];
    // Вставляем имя модели в таблицу
    $sql = "INSERT INTO models (user_id, name, description, price, image_url, polygon_count, vehicle_type_id, model_name)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    // Привязываем параметры с правильными типами данных и порядком
$stmt->bind_param("issdssis", $user_id, $name, $description, $price, $photos, $polygon_count, $vehicle_type_id, $model_name);


    // Обработка загруженного изображения
    $target_dir = "uploads/";
    $filePaths = array();

    // Проверяем, загружен ли один или несколько файлов
    if (is_array($_FILES["image"]["tmp_name"])) {
        // Несколько файлов
        foreach ($_FILES["image"]["tmp_name"] as $key => $tmp_name) {
            $target_file = $target_dir . basename($_FILES["image"]["name"][$key]);
            move_uploaded_file($_FILES["image"]["tmp_name"][$key], $target_file);
            $filePaths[] = $target_file;
        }
    } else {
        // Один файл
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $filePaths[] = $target_file;
    }

    $photos = implode(", ", $filePaths);

    // Вставка данных в таблицу
    if ($stmt->execute()) {
        // Получаем последний вставленный ID
        $lastInsertId = $stmt->insert_id;

        // Обрабатываем выбранные форматы из скрытого поля
        $formatContainer = $_POST['formatContainer'];
        $formats = explode(',', $formatContainer);
        $formattedFormats = implode(', ', $formats);

        // Вставляем форматы в столбец model_format
        $sqlUpdateFormats = "UPDATE models SET model_format = ? WHERE id = ?";
        $stmtUpdateFormats = $conn->prepare($sqlUpdateFormats);
        $stmtUpdateFormats->bind_param("si", $formattedFormats, $lastInsertId);
        $stmtUpdateFormats->execute();

        include('home.php');
        echo '<div id="notification" class="alert alert-success">
        Успешно
    </div>';
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $stmtUpdateFormats->close();
}

$conn->close();
?>
