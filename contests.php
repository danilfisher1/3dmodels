<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Конкурсы</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Конкурс на самый лучший интерьер автомобиля</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <img src="uploads/6.png" class="card-img-top" alt="Изображение конкурса">
                    <div class="card-body">
                        <h5 class="card-title">Станьте лучшим 3D-дизайнером автомобилей!</h5>
                        <p class="card-text">Присоединяйтесь к нашему увлекательному конкурсу и покажите свои лучшие работы! В этом месяце мы ищем самый проработанный интерьер автомобиля. Это ваш шанс выиграть ценные призы и получить признание в сообществе 3D-дизайнеров.</p>
                        
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Как участвовать:</strong> Загрузите свою модель на сайт до конца месяца. Модель, которая получит наибольшую огласку в нашем <a href="https://t.me/fisher_danil">телеграм</a> канале, станет победителем!
                </div>

                <div class="card mb-4">
                    <div class="card-header">Призы</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">1-е место: $500 и специальный трофей</li>
                        <li class="list-group-item">2-е место: $300 и годовая подписка на платформу</li>
                        <li class="list-group-item">3-е место: $200 и скидка на следующую покупку</li>
                    </ul>
                </div>

                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Советы для участников</h5>
                        <p class="card-text">Сосредоточьтесь на качестве и детализации модели, а также на ее оригинальности и привлекательности для потенциальных покупателей. Убедитесь, что ваша модель оптимизирована для различных 3D приложений.</p>
                    </div>
                </div>

                <div class="card text-center mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Дедлайн конкурса</h5>
                        <p class="card-text">Все работы должны быть представлены до 23:59 30-го числа текущего месяца. Победители будут объявлены в первую неделю следующего месяца.</p>
                        <a href="add_car.php" class="btn btn-warning">Загрузить модель</a>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <?php include('footer.html'); ?>

    <!-- Подключение Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
