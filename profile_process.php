<?php
include('header.php'); // Подключение header.php, который уже начинает сессию

$userId = $_SESSION['user_id']; // Используем ID пользователя из сессии

$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_photo'])) {
    $fileName = basename($_FILES['profile_photo']['name']);
    $fileTmpName = $_FILES['profile_photo']['tmp_name'];
    $fileDestination = 'uploads/' . $fileName;

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        $sql = "UPDATE users SET profile_photo = '$fileDestination' WHERE id = $userId";
        if ($conn->query($sql) === TRUE) {
            echo "Фото профиля обновлено.";
        } else {
            echo "Ошибка: " . $conn->error;
        }
    } else {
        echo "Ошибка загрузки файла.";
    }
}

$currentProfilePhoto = 'logo.png';
$sql = "SELECT profile_photo FROM users WHERE id = $userId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['profile_photo'])) {
        $currentProfilePhoto = $row['profile_photo'];
    }
}
$conn->close();
?>