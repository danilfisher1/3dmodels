<!DOCTYPE html>
<html lang="ru">
<head>
    <title>О нас</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">О нас</h1>

        <div class="row">
            <div class="col-lg-6">
                <h2>Наша миссия</h2>
                <p>Наш сайт создан для того, чтобы предоставить дизайнерам и любителям 3D-моделирования уникальную платформу для обмена, продажи и покупки качественных 3D-моделей автомобилей. Мы стремимся облегчить доступ к высококачественным моделям и создать сообщество единомышленников.</p>
            </div>
            <div class="col-lg-6">
                <h2>Наши ценности</h2>
                <p>Мы ценим креативность, качество и инновации. Наша команда постоянно работает над улучшением платформы, чтобы сделать процесс покупки и продажи максимально удобным и безопасным.</p>
            </div>
        </div>

        <h2 class="text-center mt-5">Наша команда</h2>
        <div class="row text-center mt-4">
            <!-- Пример карточки сотрудника -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://avatars.mds.yandex.net/get-kinopoisk-post-img/1101236/6e7e2207d259c48b7d34dbb436d3f108/960x540" class="card-img-top" alt="Фото сотрудника">
                    <div class="card-body">
                        <h5 class="card-title">Фишер Данил</h5>
                        <p class="card-text">Основатель и CEO. Энтузиаст 3D-моделирования с многолетним опытом.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://cdn.nur.kz/images/1120x630/798107b8b06e9cff.jpeg" class="card-img-top" alt="Фото сотрудника">
                    <div class="card-body">
                        <h5 class="card-title">Бондаренко Александра</h5>
                        <p class="card-text">Тьютор по 3D-моделингу</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="https://lifeactor.ru/uploads/posts/2017-01/1485630959_354p33jtq5aqsq2q2ezagg-default.jpg" class="card-img-top" alt="Фото сотрудника">
                    <div class="card-body">
                        <h5 class="card-title">Бугиль Ярослав</h5>
                        <p class="card-text">Администратор Сайта</p>
                    </div>
                </div>
            </div>
            <!-- Добавьте дополнительные карточки для других членов команды -->
        </div>

        <h2 class="text-center mt-5">Контакты</h2>
        <div class="row text-center mt-4">
            <div class="col-md-6">
                <h5>Электронная почта</h5>
                <p>danilfisher@3dgamedev.ru</p>
            </div>
            <div class="col-md-6">
                <h5>Телефон</h5>
                <p>+7 999 109 8546</p>
            </div>
        </div>
    </div>

    <?php include('footer.html'); ?>
    
    <!-- Подключение Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
