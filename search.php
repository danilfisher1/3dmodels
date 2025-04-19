<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "3dmodels");

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['query'])) {
    $searchQuery = $conn->real_escape_string($_POST['query']);
    $sql = "SELECT * FROM models WHERE name LIKE '%$searchQuery%'";

    $result = $conn->query($sql);
    $searchResults = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Предполагается, что у вас есть поле image_url в базе данных
            $imageUrls = explode(',', $row['image_url']);
            $firstImageUrl = count($imageUrls) > 0 ? trim($imageUrls[0]) : 'no-image.png'; // Путь к изображению по умолчанию, если не найдены изображения

            ob_start(); // Начало буферизации вывода
?>
            <div class="col pb-2">
                <div class="card shadow-sm">
                    <img src="<?php echo $firstImageUrl; ?>" class="bd-placeholder-img card-img-top" width="100%" height="225">
                    <div class="card-body">
                        <p class="card-text"><?php echo $row['name']; ?></p>
                        <p class="card-text">Цена: <?php echo $row['price']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="btn btn-md btn-outline-secondary" href="model_details.php?model_id=<?php echo $row['id']; ?>">Просмотр</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $searchResults[] = ob_get_clean(); // Завершение буферизации и добавление её содержимого в массив
        }
    } else {
        $searchResults[] = '<div class="col">Нет результатов.</div>';
    }
    echo json_encode($searchResults);
} else {
    echo json_encode(['<div class="col">Поиск не выполнен.</div>']);
}

$conn->close();
?>
