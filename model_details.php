
<?php
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];

    // Создайте подключение к базе данных
    $conn = new mysqli("localhost", "root", "", "3dmodels");

    // Проверьте подключение к базе данных
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Подготовьте SQL-запрос для получения image_url на основе model_id
    $sql = "SELECT image_url FROM models WHERE id = $model_id";

    // Выполните SQL-запрос
    $result = $conn->query($sql);

    // Проверьте, успешно ли выполнен запрос
    if ($result) {
        // Получите результат запроса (должен быть только один результат)
        $row = $result->fetch_assoc();

        // Получите image_url из результата и разделите его на отдельные пути
        $image_urls = explode(',', $row['image_url']);
    } else {
        // Если произошла ошибка при выполнении запроса, используйте фото по умолчанию
        $image_urls = ["URL_фото_по_умолчанию"]; // Замените на URL вашей фотографии по умолчанию
    }

    // Пример для получения значения model_format
    $sql_model_format = "SELECT model_format FROM models WHERE id = $model_id";
    $result_model_format = $conn->query($sql_model_format);
    if ($result_model_format) {
        $row_model_format = $result_model_format->fetch_assoc();
        $model_format = $row_model_format['model_format'];
    } else {
        $model_format = "Значение по умолчанию для model_format";
    }

    // Пример для получения значения model_name
    //$sql_model_name = "SELECT model_name FROM models WHERE id = $model_id";
    //$result_model_name = $conn->query($sql_model_name);
    //if ($result_model_name) {
    //    $row_model_name = $result_model_name->fetch_assoc();
    //    $model_name = $row_model_name['model_name'];
    //} else {
    //    $model_name = "Значение по умолчанию для model_name";
    //}

    // Пример для получения значения name 
    $sql_name = "SELECT name FROM models WHERE id = $model_id";
    $result_name = $conn->query($sql_name);
    if ($result_name) {
        $row_name = $result_name->fetch_assoc();
        $name = $row_name['name'];
    } else {
        $name = "Значение по умолчанию для name";
    }

    // Пример для получения значения polygon_count
    $sql_polygon_count = "SELECT polygon_count FROM models WHERE id = $model_id";
    $result_polygon_count = $conn->query($sql_polygon_count);
    if ($result_polygon_count) {
        $row_polygon_count = $result_polygon_count->fetch_assoc();
        $polygon_count = $row_polygon_count['polygon_count'];
    } else {
        $polygon_count = "Значение по умолчанию для polygon_count";
    }

    // Пример для получения значения price
    $sql_price = "SELECT price FROM models WHERE id = $model_id";
    $result_price = $conn->query($sql_price);
    if ($result_price) {
        $row_price = $result_price->fetch_assoc();
        $price = $row_price['price'];
    } else {
        $price = "Значение по умолчанию для price";
    }

    // Пример для получения значения user_id
    $sql_user_id = "SELECT user_id FROM models WHERE id = $model_id";
    $result_user_id = $conn->query($sql_user_id);
    if ($result_user_id) {
        $row_user_id = $result_user_id->fetch_assoc();
        $user_id = $row_user_id['user_id'];
    } else {
        $user_id = "Значение по умолчанию для user_id";
    }

    // Получите vehicle_type_id из таблицы models
    $sql_vehicle_type_id = "SELECT vehicle_type_id FROM models WHERE id = $model_id";
    $result_vehicle_type_id = $conn->query($sql_vehicle_type_id);

    if ($result_vehicle_type_id) {
        $row_vehicle_type_id = $result_vehicle_type_id->fetch_assoc();
        $vehicle_type_id = $row_vehicle_type_id['vehicle_type_id'];

        // Теперь, на основе полученного vehicle_type_id, получите type_name из таблицы vehicle_types
        $sql_type_name = "SELECT type_name FROM vehicle_types WHERE id = $vehicle_type_id";
        $result_type_name = $conn->query($sql_type_name);

        if ($result_type_name) {
            $row_type_name = $result_type_name->fetch_assoc();
            $type_name = $row_type_name['type_name'];
        } else {
            $type_name = "Значение по умолчанию для type_name";
        }
    } else {
        $vehicle_type_id = "Значение по умолчанию для vehicle_type_id";
        $type_name = "Значение по умолчанию для type_name";
    }

    // Пример для получения значения description
    $sql_description = "SELECT description FROM models WHERE id = $model_id";
    $result_description = $conn->query($sql_description);
    if ($result_description) {
        $row_description = $result_description->fetch_assoc();
        $description = $row_description['description'];
    } else {
        $description = "Значение по умолчанию для description";
    }


    // Закройте соединение с базой данных
    $conn->close();
} else {
    // Если model_id не передан, используйте значения по умолчанию для каждого столбца
    $image_urls = ["URL_фото_по_умолчанию"];
    $model_format = "Значение по умолчанию для model_format";
    $model_name = "Значение по умолчанию для model_name";
    $name = "Значение по умолчанию для name";
    $polygon_count = "Значение по умолчанию для polygon_count";
    $price = "Значение по умолчанию для price";
    $user_id = "Значение по умолчанию для user_id";
    $vehicle_type_id = "Значение по умолчанию для vehicle_type_id";
    $type_name = "Значение по умолчанию для type_name";
    $description = "Значение по умолчанию для description";
}
?>
<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Проверка, что POST-запрос был выполнен и передан model_id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['model_id'])) {
    // Получаем значения из сессии и из POST-запроса
    session_start(); // Убедитесь, что сессия уже была начата
    $user_id = $_SESSION['user_id'];
    $model_id = $_POST['model_id'];
    
    // Получаем текущую дату и время
    $sale_date = date("Y-m-d H:i:s");
    
    // Подготавливаем SQL-запрос для проверки уникальности
    $check_sql = "SELECT COUNT(*) FROM sales WHERE buyer_id = ? AND model_id = ? AND seller_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("iii", $user_id, $model_id, $user_id);
    $check_stmt->execute();
    $check_stmt->bind_result($existing_sales);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($existing_sales == 0) {
        // Записи с такой комбинацией buyer_id, model_id, seller_id нет, можно вставить
        // Подготавливаем SQL-запрос с использованием параметров
        $insert_sql = "INSERT INTO sales (buyer_id, model_id, sale_date, seller_id) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iisi", $user_id, $model_id, $sale_date, $user_id);

        // Выполняем SQL-запрос
        if ($insert_stmt->execute()) {
            header('Location: profile.php'); // Перенаправляем пользователя после успешного выполнения
            exit;
        } else {
            echo "Ошибка при выполнении запроса: " . $insert_stmt->error;
        }

        // Закрываем подготовленное выражение
        $insert_stmt->close();
    } else {
        echo "Запись уже существует."; // Выводим сообщение, если запись уже существует
    }
} else {
    // Ваш код, который будет выполняться, если условие не выполнено
    // Например, вы можете добавить здесь какое-либо сообщение или другую логику
}

// Закрываем соединение с базой данных
$conn->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        .carousel {
            max-height: 500px;
        }

        .carousel-item {
            max-height: 500px;
        }

        .carousel-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(2vh);
            z-index: 3;
            opacity: 1;
            transition: opacity 1s;
        }

        .carousel-item{
          z-index: 4;
        }
        
        .me-1 {
            margin-right: 0.25rem!important;
        }

        .bg-warning-subtle {
            background-color: #ffc107;
        }

        .pe-2 {
            padding-right: 1rem;
        }
        .bg-dark-subtle {
    background-color: #ced4da;
}
.border-dark-subtle {
    border-color: #adb5bd!important;
}

.photofl {
    object-fit: contain;

}
.carousel-indicators2{
background-color: #000!important;    
}
.carousel-item img {
        max-width: 100%; /* Установите максимальную ширину изображений внутри carousel-item */
        height: auto; /* Автоматический расчет высоты на основе максимальной ширины */
    }
    
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <main>
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-2 bg-dark"></div>
      <div class="col-md-8">
        <div class="row justify-content-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 bg-dark">
                    <div class="carousel-container">
                        <div id="carouselBackground" class="carousel-background" style="background-image: url(&quot;uploads/photo_2023-09-26_10-53-46.jpg&quot;);"></div>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="max-height: 50vh; overflow: hidden;">
                <ol class="carousel-indicators">
                    <?php
                    // Создайте индикаторы на основе количества путей в image_url
                    for ($i = 0; $i < count($image_urls); $i++) {
                        if ($i === 0) {
                            echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="carousel-indicators2 active"></li>';
                        } else {
                            echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="carousel-indicators2 "></li>';
                        }
                    }
                    ?>
                </ol>
                <div class="carousel-inner" style="max-height: 100%;">
                    <?php
                    // Создайте элементы карусели на основе путей в image_url
                    foreach ($image_urls as $index => $image_url) {
                        if ($index === 0) {
                            echo '<div class="carousel-item active">';
                        } else {
                            echo '<div class="carousel-item">';
                        }
                        echo '<img class=" mx-auto d-block photofl" src="' . $image_url . '" alt="Слайд ' . ($index + 1) . '" style="height: 50vh; ">';
                        echo '</div>';
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="z-index: 10;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only" >Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" style="z-index: 10;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
                </div>
                <div class="col-md-12 bg-dark">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-3 bg-dark text-white">
                                <div class="container-fluid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
    <h5 class="text-white mb-0"><?php echo $name; ?></h5>
</div>

                                        <div class="d-flex align-items-center">
    <h5 class="text-white mb-0">
        <img src="uploads/dollar-symbol.png" alt="$" width="16" height="16">
        <?php echo $price; ?>
    </h5>
    <div class="mx-3"></div>

<!-- Остальная часть HTML-кода с кнопкой и формой -->

<?php
// Проверяем, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Получение user_id из сессии

    // Код для отображения кнопки "Купить" или "В корзине" для авторизованных пользователей
    ?>
    <form method="POST" action="model_details.php?model_id=<?php echo $model_id; ?>">
        <input type="hidden" name="model_id" value="<?php echo $model_id; ?>">
        <?php
        $conn = new mysqli("localhost", "root", "", "3dmodels");

        // Проверка на ошибку подключения
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Проверка, есть ли запись о продаже данной модели для текущего пользователя
        $sqlCheckSale = "SELECT * FROM sales WHERE buyer_id = ? AND model_id = ?";
        $stmtCheckSale = $conn->prepare($sqlCheckSale);
        
        if ($stmtCheckSale) {
            $stmtCheckSale->bind_param("ii", $user_id, $model_id);
            $stmtCheckSale->execute();
            $resultCheckSale = $stmtCheckSale->get_result();
            
            if ($resultCheckSale->num_rows > 0) {
                // Запись о продаже есть, отображаем кнопку "В корзине"
                echo '<a type="button" href="profile.php" class="btn btn-warning">В корзине</a>';
            } else {
                // Записи о продаже нет, отображаем кнопку "Купить"
                echo '<button type="submit" class="btn btn-warning">Купить</button>';
            }
            
            $stmtCheckSale->close();
        } else {
            echo '<a type="button" class="btn btn-warning" disabled>Ошибка</a>';
        }
        $conn->close();
        ?>
    </form>
    <?php
} else {
    // Если пользователь не авторизован, показываем ссылку на страницу регистрации/входа
    echo '<a href="signing.php" class="btn btn-warning">Купить</a>';
}
?>




</div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h4 class="my-0 fw-normal">Описание</h4>
                                        </div>
                                        <div class="card-body">

                                            <ul class="list-unstyled mt-2 mb-2">
                                                <li><?php echo $description; ?></li>
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pl-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h4 class="my-0 fw-normal">Форматы</h4>
                                        </div>
                                        <div class="card-body">
    <div class="gap-2 justify-content-start py-2">
        <?php
        // Проверяем, установлен ли model_id
        if (isset($_GET['model_id'])) {
            $model_id = $_GET['model_id'];

            // Создаем подключение к базе данных
            $conn = new mysqli("localhost", "root", "", "3dmodels");

            // Проверяем подключение к базе данных
            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            // Подготавливаем SQL-запрос для получения model_format на основе model_id
            $sql = "SELECT model_format FROM models WHERE id = $model_id";

            // Выполняем SQL-запрос
            $result = $conn->query($sql);

            // Проверяем успешность выполнения запроса
            if ($result) {
                // Получаем результат запроса (должен быть только один результат)
                $row = $result->fetch_assoc();

                // Разделяем значения model_format по запятой и пробелу
                $model_formats = explode(', ', $row['model_format']);

                // Проходим по массиву model_formats и создаем элемент <span> для каждого формата
                foreach ($model_formats as $format) {
                    echo '<span class="badge bg-dark-subtle border border-dark-subtle text-dark-emphasis rounded-pill mx-1">' . $format . '</span>';
                }
            } else {
                // Обрабатываем случай, если запрос завершается ошибкой
                echo '<span class="badge bg-dark-subtle border border-dark-subtle text-dark-emphasis rounded-pill mx-1">Ошибка</span>';
            }

            // Закрываем соединение с базой данных
            $conn->close();
        } else {
            // Обрабатываем случай, если model_id не установлен
            echo '<span class="badge bg-dark-subtle border border-dark-subtle text-dark-emphasis rounded-pill mx-1">Model ID не установлен</span>';
        }


        ?>
        <?php
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];

    // Создайте подключение к базе данных
    $conn = new mysqli("localhost", "root", "", "3dmodels");

    // Проверьте подключение к базе данных
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Получение type_name из таблицы vehicle_types, соответствующего vehicle_type_id в таблице models
    $sql_type_name = "SELECT vehicle_types.type_name FROM vehicle_types INNER JOIN models ON vehicle_types.id = models.vehicle_type_id WHERE models.id = ?";
    $stmt_type_name = $conn->prepare($sql_type_name);
    $stmt_type_name->bind_param("i", $model_id);
    $stmt_type_name->execute();
    $result_type_name = $stmt_type_name->get_result();
    if ($row_type_name = $result_type_name->fetch_assoc()) {
        $type_name = $row_type_name['type_name'];
    } else {
        $type_name = "Тип не определен";
    }

    // Ваш код для остальных запросов к моделям

    // Закройте соединение с базой данных
    $conn->close();
} else {
    // Ваш код для обработки случая, когда model_id не передан
}
?>

    </div>
</div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 rounded-3 shadow-sm">
                                        <div class="card-header py-3">
                                            <h4 class="my-0 fw-normal">Характеристики модели</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled mt-2 mb-2">
                                                
                                                
                                                <form>
                                                    <div class="input-group pb-2">
                                                        <input type="text" class="form-control" value="Тип авто" aria-label="Тип авто" aria-describedby="basic-addon1" style="font-weight: bolder;">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <p class="text-black d-flex align-items-center justify-content-center mb-0">
                                                        <?php echo $type_name; ?>
                                                            </p>
                                                        </span>
                                                    </div>
                                               </form>
                                                <form>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="Кол-во полигонов" aria-label="Кол-во полигонов" aria-describedby="basic-addon1" style="font-weight: bolder;">
                                                        <span class="input-group-text" id="basic-addon1">
                                                            <p class="text-black d-flex align-items-center justify-content-center mb-0">
                                                        <?php echo $polygon_count; ?>
                                                            </p>
                                                        </span>
                                                    </div>
                                               </form>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3 rounded-3 shadow-sm">
                                      <div class="card-header py-3">
                                          <h4 class="my-0 fw-normal">Продавец</h4>
                                      </div>
                                      <div class="card-body p-0">
                                          <div class="row">
                                              <div class="col-md-3 pt-2 pb-2 ml-2 pr-0">
<?php
// Начало сессии, если она еще не была начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");

// Проверка на ошибку подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Инициализация переменных
$modelUsername = 'Неизвестный';
$defaultProfilePhoto = 'logo.png'; // Путь к фото по умолчанию

// Получение информации о модели
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];

    $modelSql = "SELECT * FROM models WHERE id = $model_id";
    $modelResult = $conn->query($modelSql);

    if ($modelResult && $modelResult->num_rows > 0) {
        $row = $modelResult->fetch_assoc();
        $modelUserId = $row['user_id'];

        $userSql = "SELECT username, profile_photo FROM users WHERE id = $modelUserId";
        $userResult = $conn->query($userSql);

        if ($userResult && $userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $modelUsername = $userRow['username'];
            // Проверка, существует ли файл фото
            $modelProfilePhoto = file_exists($userRow['profile_photo']) ? $userRow['profile_photo'] : $defaultProfilePhoto;
        } else {
            $modelProfilePhoto = $defaultProfilePhoto;
        }
    } else {
        echo "Модель не найдена.";
        $modelProfilePhoto = $defaultProfilePhoto;
    }
} else {
    echo "Не указан ID модели.";
    $modelProfilePhoto = $defaultProfilePhoto;
}

// Закрытие соединения с базой данных
$conn->close();
?>


<?php
if (isset($_GET['model_id'])) {
    $model_id = $_GET['model_id'];

    // Создайте подключение к базе данных
    $conn = new mysqli("localhost", "root", "", "3dmodels");

    // Проверьте подключение к базе данных
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Получение user_id связанного с model_id
    $sql_user_id = "SELECT user_id FROM models WHERE id = ?";
    $stmt_user_id = $conn->prepare($sql_user_id);
    $stmt_user_id->bind_param("i", $model_id);
    $stmt_user_id->execute();
    $result_user_id = $stmt_user_id->get_result();
    if ($row_user_id = $result_user_id->fetch_assoc()) {
        $user_id_of_model = $row_user_id['user_id'];

        // Теперь получаем username используя user_id
        $sql_username = "SELECT username FROM users WHERE id = ?";
        $stmt_username = $conn->prepare($sql_username);
        $stmt_username->bind_param("i", $user_id_of_model);
        $stmt_username->execute();
        $result_username = $stmt_username->get_result();
        if ($row_username = $result_username->fetch_assoc()) {
            $username = $row_username['username'];

            // Теперь, когда у нас есть username, можем начать подсчет
            $sql_count_models = "SELECT COUNT(*) FROM models WHERE user_id = ?";
            $stmt_count_models = $conn->prepare($sql_count_models);
            $stmt_count_models->bind_param("i", $user_id_of_model);
            $stmt_count_models->execute();
            $result_count_models = $stmt_count_models->get_result();
            if ($row_count_models = $result_count_models->fetch_assoc()) {
                $count_models = $row_count_models['COUNT(*)'];
                
            } else {
                echo "Не удалось получить количество моделей пользователя.";
            }
        } else {
            $username = "Неизвестный пользователь";
        }
    } else {
        $username = "Неизвестный пользователь";
    }

    // Закройте соединение с базой данных
    $conn->close();
} else {
    // Ваш код для обработки случая, когда model_id не передан
}
?>



                                                  <img class="rounded-circle me-1" width="70" height="70" src="<?php echo htmlspecialchars($modelProfilePhoto); ?>" alt="Фото продавца">
</div>
                                              <div class="col-md-8 px-0 d-flex flex-column justify-content-center">
                                                  <div class="row ">
                                                      <div class="col-12">
                                                          <!-- Имя продавца -->
                                                          <a class="mx-0" style="font-size: 1.25rem; color: #000;"><?php echo $username; ?></a>
                                                      </div>
                                                  </div>
                                                  <hr style="margin-top: 0rem; margin-bottom: 0rem; border-width: 1px;"> <!-- Горизонтальная линия -->
                                                  <div class="row ">
                                                      <div class="col-12">
                                                          <!-- Количество товаров -->
                                                          <p class="mb-0">Кол-во товаров: <?php echo $count_models; ?></p>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        </div>
        <div class="col-md-2 bg-dark"></div>
      </div>
      </div>
    </main>

    <?php include('footer.html'); ?>

    <script>
        function updateBackground() {
            const activeSlide = document.querySelector('.carousel-item.active');
            const backgroundImage = activeSlide.querySelector('img').getAttribute('src');
            document.getElementById('carouselBackground').style.backgroundImage = `url('${backgroundImage}')`;
        }

        $(document).ready(function () {
            updateBackground();
            $('#carouselExampleIndicators').on('slid.bs.carousel', updateBackground);
        });
    </script>

</body>

</html>
