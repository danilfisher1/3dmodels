<!DOCTYPE html>
<html>
<head>
    <title>Автомобили</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style type="text/css">
        .row>* {
            margin-top: 30px;
        }
        .card-img-top {
    object-fit: contain;
}
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php
                        $conn = new mysqli("localhost", "root", "", "3dmodels");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        if (isset($_GET['category_id'])) {
                            $category_id = $_GET['category_id'];
                            // Выполнение SQL-запроса для выбора автомобилей по категории
                            $cars_query = "SELECT * FROM models WHERE vehicle_type_id = $category_id";

                            $cars_result = $conn->query($cars_query);

                            if ($cars_result->num_rows > 0) {
                                while ($car = $cars_result->fetch_assoc()) {
                                    // Получаем строку с путями к файлам и выбираем первый путь
                                    $imageUrls = $car['image_url'];
                                    $imageUrlsArray = explode(',', $imageUrls);
                                    $firstImageUrl = (!empty($imageUrlsArray)) ? trim($imageUrlsArray[0]) : '';

                                    // Создание карточек автомобилей
                                    echo '<div class="col">';
                                    echo '<div class="card shadow-sm">';
                                    echo '<img src="' . $firstImageUrl . '" class="bd-placeholder-img card-img-top" width="100%" height="225">';
                                    echo '<div class="card-body">';
                                    echo '<p class="card-text">' . $car['name'] . '</p>';
                                    echo '<p class="card-text">Цена: ' . $car['price'] . '</p>';
                                    echo '<div class="d-flex justify-content-between align-items-center">';
                                    echo '<div class="btn-group">';
                                    // Возможно, вы хотите добавить дополнительные действия, такие как просмотр подробной информации о автомобиле
                                    // здесь можно добавить ссылку на подробную страницу автомобиля
                                    echo '<a class="btn btn-md btn-outline-secondary" href="model_details.php?model_id=' . $car['id'] . '">Просмотр</a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "Нет доступных автомобилей в данной категории.";
                            }
                        } else {
                            echo "Не указана категория.";
                        }

                        // Закрытие соединения с базой данных
                        $conn->close();
                        ?>

                </div>
            </div>
        </div>
    </main>

    <?php include('footer.html'); ?>
</body>
</html>
