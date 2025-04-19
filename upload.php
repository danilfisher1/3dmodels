<?php
// Путь, куда будет сохранено загруженное изображение
$uploadDir = 'uploads/';

if ($_FILES['profile_image']) {
    $tmpFileName = $_FILES['profile_image']['tmp_name'];
    $newFileName = $uploadDir . $_FILES['profile_image']['name'];

    if (move_uploaded_file($tmpFileName, $newFileName)) {
        // Загрузка успешна, можно обновить фото профиля в базе данных
        // Здесь ты можешь добавить код для обновления фото в базе данных
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
