<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Завершение сессии
    session_destroy();
    // Перенаправление на другую страницу, например, на главную
    header("Location: home.php"); // Измените "index.php" на вашу главную страницу
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

    <style>
        #notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            transition: all 0.5s ease-in-out;
            transform: translateX(100%);
            opacity: 0; /* Изначально элемент полностью прозрачный */
        }


.carousel-item {
  height: 500px; /* Или другая высота, которая подходит для вашего дизайна */
}

.carousel-item img {
  width: 100%; /* Ширина изображения равна ширине карусели */
  height: 500px; /* Высота изображения фиксирована */
  object-fit: cover; /* Обрезает изображение, сохраняя пропорции, чтобы оно покрывало элемент */
}

.carousel-caption {
  background: rgba(0,0,0,0.5); /* Добавьте полупрозрачный фон к подписям для лучшей видимости */
  bottom: 20px; /* Поднимите подписи вверх, если необходимо */
}



    </style>
</head>
<body>
    <?php include('header.php'); ?>
    
    <!-- Карусель с изображениями -->
    <div id="modelCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="uploads/1.png" alt="First slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Лучшие 3D модели автомобилей</h5>
                <p>От классических до современных моделей.</p>
            </div>
        </div>
        <!-- Второй элемент carousel-item -->
        <div class="carousel-item">
            <img class="d-block w-100" src="uploads/2.png" alt="Second slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Современные дизайны</h5>
                <p>Идеальный выбор для визуализации и 3D печати.</p>
            </div>
        </div>
        <!-- Третий элемент carousel-item -->
        <div class="carousel-item">
            <img class="d-block w-100" src="uploads/3.png" alt="Third slide">
            <div class="carousel-caption d-none d-md-block">
                <h5>Качество и детализация</h5>
                <p>Детализированные модели для профессионального использования.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#modelCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#modelCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


    <!-- Блок "О нас" -->
    <section class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>О нашем магазине 3D моделей</h2>
                    <p>На нашем сайте представлен широкий выбор 3D моделей автомобилей всех категорий. От классики до эксклюзивных концепт-каров - у нас найдется модель для каждого проекта!</p>
                </div>
                <div class="col-lg-6">
                    <img src="uploads/4.png" class="img-fluid" alt="3D модели автомобилей">
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Как это работает" -->
    <section class="my-5 bg-light">
        <div class="container">
            <div class="text-center">
                <h2>Как это работает?</h2>
                <p>Купить или продать 3D модель на нашем сайте легко и просто. Воспользуйтесь поиском, чтобы найти нужную модель, или загрузите свою, чтобы начать продажи.</p>
            </div>
            <!-- Добавьте сюда дополнительные блоки информации или функции -->
        </div>
    </section>

    <!-- Блок "Преимущества" -->
    <section class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <img class="card-img-top" src="uploads/photo_2023-12-20_16-40-50 (3).jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Широкий ассортимент</h5>
                            <p class="card-text">Сотни качественных моделей на любой вкус и для любых задач.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <img class="card-img-top" src="uploads/photo_2023-12-20_16-40-50 (5).jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Высокое качество</h5>
                            <p class="card-text">Все модели проверены и оптимизированы для использования в различных 3D приложениях.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <img class="card-img-top" src="uploads/photo_2023-12-20_16-40-52 (1).jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Поддержка продавцов</h5>
                            <p class="card-text">Мы помогаем нашим продавцам на каждом этапе, от загрузки моделей до получения дохода.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Вызов к действию" -->
    <section class="text-center my-5">
        <div class="container">
            <h2>Станьте частью сообщества</h2>
            <p class="lead">Присоединяйтесь к нам и начните продавать или покупать 3D модели сегодня!</p>
            <a href="signing.php" class="btn btn-primary btn-lg">Начать</a>
        </div>
    </section>
    
    <?php include('footer.html'); ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Показать уведомление
            $('#notification').css({
                'transform': 'translateX(0)',
                'opacity': '1'
            });
            
            // Скрыть уведомление через 3 секунды
            setTimeout(function() {
                $('#notification').css({
                    'transform': 'translateX(100%)',
                    'opacity': '0'
                });
                // Добавить 'display: none' после завершения анимации
                setTimeout(function() {
                    $('#notification').css('display', 'none');
                }, 500); // 500 мс - длительность анимации
            }, 3000);
        });
    </script>
</body>
</html>