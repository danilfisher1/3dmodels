<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Всплывающее уведомление</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    </style>
</head>
<body>
    <!-- Всплывающее уведомление -->
    <div id="notification" class="alert alert-success">
        Успешно
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
