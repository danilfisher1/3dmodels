<!DOCTYPE html>
<html>
<head>
    <title>Категории</title>
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
                // Подключение к базе данных
                $conn = new mysqli("localhost", "root", "", "3dmodels");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Выполнение SQL-запроса для выбора категорий и их первых изображений
                $categories_query = "SELECT vt.id, vt.type_name, 
                                     (SELECT image_url FROM models WHERE vehicle_type_id = vt.id LIMIT 1) AS first_image 
                                     FROM vehicle_types vt";

                $categories_result = $conn->query($categories_query);

                if ($categories_result->num_rows > 0) {
                    while ($category = $categories_result->fetch_assoc()) {
                        $imageUrls = explode(',', $category['first_image']);
                        $firstImageUrl = !empty($imageUrls[0]) ? trim($imageUrls[0]) : 'path_to_default_image.jpg'; // Замените на путь к изображению по умолчанию
                        // Создание карточек категорий
                        echo '<div class="col">';
                        echo '<div class="card shadow-sm">';
                        echo '<img src="' . $firstImageUrl . '" class="bd-placeholder-img card-img-top" width="100%" height="225">';
                        echo '<div class="card-body">';
                        echo '<p class="card-text">' . $category['type_name'] . '</p>';
                        echo '<div class="d-flex justify-content-between align-items-center">';
                        echo '<div class="btn-group">';
                        echo '<a class="btn btn-md btn-outline-secondary" href="cars.php?category_id=' . $category['id'] . '">Перейти</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "Нет доступных категорий";
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
