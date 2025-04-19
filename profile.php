<?php
 // Подключение header.php, который уже начинает сессию
include('header.php');
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
    // Выполнение успешного AJAX-запроса для загрузки success.php
    echo '<div id="notification" class="alert alert-success">
        Успешно
    </div>';

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


$username = ''; // Инициализация переменной для имени пользователя
$sql = "SELECT username, profile_photo FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username']; // Имя пользователя из базы данных
    if (!empty($row['profile_photo'])) {
        $currentProfilePhoto = $row['profile_photo'];
    }
}

function getModelsByUserId($conn, $userId) {
    $models = array();
    $sql = "SELECT * FROM models WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $models[] = $row;
    }
    $stmt->close();
    return $models;
}

// Подготовка данных для вывода карточек товаров
$models = getModelsByUserId($conn, $userId);

// Получите список model_id и sale_id из таблицы sales, где buyer_id соответствует id пользователя в сессии
$sqlGetCartModels = "SELECT model_id, id AS sale_id FROM sales WHERE buyer_id = ?";

$stmtGetCartModels = $conn->prepare($sqlGetCartModels);

if ($stmtGetCartModels) {
    $stmtGetCartModels->bind_param("i", $userId);
    $stmtGetCartModels->execute();
    $resultCartModels = $stmtGetCartModels->get_result();
    
    // Создайте массив с model_id
    $cartModelIds = array();
    
    while ($rowCartModel = $resultCartModels->fetch_assoc()) {
        $cartModelIds[] = $rowCartModel['model_id'];
    }
    
    $stmtGetCartModels->close();
} else {
    echo "Ошибка при подготовке запроса для получения моделей в корзине";
}


// Теперь у вас есть массив $cartModelIds с model_id моделей в корзине

// Используйте $cartModelIds для получения информации о моделях
foreach ($models as $model) {
    if (in_array($model['id'], $cartModelIds)) {
        // Этот $model находится в корзине, вы можете его отобразить
        // Тут ваш код для отображения информации о модели
    }
}

// ... остальная часть вашего PHP кода ...


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Добавь стили для фото профиля */


.bi-pencil-square::before {
    width: 24px!important;
    height: 24px!important;
    display: block!important;
}

#profile-photo {

    border-radius: 50%;
    cursor: pointer;
    transition: opacity 0.3s; /* Анимация перехода для плавного изменения прозрачности */
    object-fit: contain;
        object-position: center;
}

/* Стиль для изображения профиля с прозрачностью */
.transparent {
    opacity: 0.5; /* Устанавливаем прозрачность в 50% */
}
.card-img-top {
    object-fit: contain;
}
/* Скрытый input для загрузки изображения */
#profile-image-input {
    opacity: 0;
}
#notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            transition: all 0.5s ease-in-out;
            transform: translateX(100%);
            opacity: 0; /* Изначально элемент полностью прозрачный */
        }
.btn-outline-secondary{
    background-color: #e9ecef!important;
        border-color: #ced4da!important;
}
.btn.btn-md.btn-outline-secondary:hover {
    color: black!important;
}
.modal {
    
    top: -20%!important;
    left: 35%!important;
}
        
    </style>
</head>
<body>
    <div class="mt-5 ml-5 mr-5">
        <div class="container-fluid mr-5 ml-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="container">
                        <div class="profile">
                            <!-- Изображение профиля -->
                            <img src="<?php echo htmlspecialchars($currentProfilePhoto); ?>" alt="Фото профиля" id="profile-photo" class="rounded-circle" width="256" height="256">
                            <!-- Форма для загрузки фото профиля -->
                            <form id="profile-upload-form" action="profile.php" method="post" enctype="multipart/form-data">
                                <input type="file" id="profile-image-input" name="profile_photo" onchange="this.form.submit()">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                
<?php
// Подключение header.php, который уже начинает сессию

$userId = $_SESSION['user_id']; // Используем ID пользователя из сессии

// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка на отправку формы обновления имени пользователя
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $newUsername = $conn->real_escape_string($_POST['username']);

    // SQL запрос на обновление имени пользователя
    $sql = "UPDATE users SET username = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newUsername, $userId);
    if ($stmt->execute()) {
        // Обновление имени пользователя в сессии, если это необходимо
        $_SESSION['username'] = $newUsername;
    } else {
        echo "Ошибка: " . $conn->error;
    }
    $stmt->close();
}

// Остальной код обработки загрузки фото профиля и т.д.
// ...
// Закрытие соединения с базой данных
$conn->close();
?>


                                    <!-- HTML -->
<form id="username-form" action="profile.php" method="post">
    <div class="input-group">
        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" aria-label="Имя пользователя" aria-describedby="username-addon" style="font-weight: bolder;">
        <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">
                <img src="edit.svg" alt="Edit" style="width: 20px; height: 20px;">
            </button>
        </span>
    </div>
</form>


<?php
// Начало сессии, если она еще не была начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");

// Проверка на ошибку подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка, залогинен ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Пользователь не залогинен, перенаправляем на страницу входа
    header("Location: signing.php");
    exit;
}

// Получение user_id из сессии
$seller_id = $_SESSION['user_id'];

// Подготовка SQL запроса для подсчета суммы продаж
$sql = "SELECT SUM(m.price) AS total_sales FROM models m
        INNER JOIN purchases p ON m.id = p.model_id
        WHERE p.seller_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Получение итоговой суммы продаж
$totalSales = $row['total_sales'] ? $row['total_sales'] : 0;

// Вывод общей суммы продаж

// Закрытие соединения с базой данных
$conn->close();
?>

                                
                            </div>
                            <div class="row mt-2">
                                <form>
                                    <div class="input-group">
    <input type="text" class="form-control" value ="Выложено товаров на" aria-label="Продано товаров на" aria-describedby="basic-addon1" style="font-weight: bolder;">
    <span class="input-group-text" id="basic-addon1">
        <p class="text-black d-flex align-items-center justify-content-center mb-0">
                                        <img src="currency-dollar.svg" alt="$" width="20" height="20">
                                        <?php echo $totalSales; ?>
                                    </p>
    </span>
</div>
<div class="row mt-2">
    <div class="btn-group">
        <a class="btn btn-md btn-outline-secondary" href="home.php?logout=true">Выйти</a>
    </div>

    <div class="btn-group mt-2">
        <a class="btn btn-md btn-outline-secondary" href="add_car.php">Добавить Свою Модель</a>
    </div>
</div>

                               </form>     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="btn-group" role="group" aria-label="Basic example">
  <button type="button" class="btn btn-secondary" id="bought">Куплены</button>
  <button type="button" class="btn btn-secondary" id="uploaded">Выложены</button>
  <button type="button" class="btn btn-secondary" id="cart">Корзина</button>
</div>
<?php
// ... предыдущий PHP код ...

$conn = new mysqli("localhost", "root", "", "3dmodels");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
$models = getModelsByUserId($conn, $userId); // Функция getModelsByUserId должна быть определена

// ... PHP код для получения моделей выше ...
$totalPrice = 0;

// Подготовка HTML для "Выложенных" моделей
$uploadedModelsHtml = '';
foreach ($models as $model) {
    $imageUrls = $model['image_url']; // предполагается, что здесь уже содержится URL
    $imageUrlsArray = explode(',', $imageUrls);
    $firstImageUrl = (!empty($imageUrlsArray)) ? trim($imageUrlsArray[0]) : 'placeholder.png'; // 'placeholder.png' - изображение по умолчанию
    $totalPrice += floatval($model['price']); // Преобразование к числовому типу и суммирование

    $uploadedModelsHtml .= '<div class="col">' .
        '<div class="card shadow-sm">' .
        '<img src="' . htmlspecialchars($firstImageUrl) . '" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="Модель">' .
        '<div class="card-body">' .
        '<p class="card-text">' . htmlspecialchars($model['name']) . '</p>' .
        '<p class="card-text">Цена: ' . htmlspecialchars($model['price']) . '</p>' .
        '<div class="d-flex justify-content-between align-items-center">' .
        '<div class="btn-group">' .
        '<a class="btn btn-md btn-outline-secondary" href="model_details.php?model_id=' . $model['id'] . '">Просмотр</a>' .
                '<a type="button" class="btn btn-md btn-outline-danger delete-model" onclick="deleteModel(' . $model['id'] . ')">Удалить</a>' .

        '</div>' .
        '</div>' .
        '</div>' .
        '</div>' .
        '</div>';
}

// Получение купленных моделей
$BuyedModels = '';
$sql = "SELECT * FROM models WHERE id IN (SELECT model_id FROM purchases WHERE buyer_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $imageUrlsArray = explode(',', $row['image_url']);
    $firstImageUrl = !empty($imageUrlsArray[0]) ? trim($imageUrlsArray[0]) : 'placeholder.png';
    // Формирование HTML для каждой купленной модели
    $BuyedModels .= '<div class="col">' .
        '<div class="card shadow-sm">' .
        '<img src="' . htmlspecialchars($firstImageUrl) . '" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="Модель">' .
        '<div class="card-body">' .
        '<p class="card-text">' . htmlspecialchars($row['name']) . '</p>' .
        '<p class="card-text">Цена: ' . htmlspecialchars($row['price']) . '</p>' .
        '<div class="d-flex justify-content-between align-items-center">' .
        '<div class="btn-group">' .
        '<a class="btn btn-md btn-outline-secondary" href="model_details.php?model_id=' . $row['id'] . '">Просмотр</a>' .
        '</div>' .
        '</div>' .
        '</div>' .
        '</div>' .
        '</div>';
}




// Подготовка HTML для моделей в "Корзине"
$cartHtml = '';

// Запрос для получения информации о моделях в корзине и соответствующих sale_id
$sql = "SELECT m.*, s.id AS sale_id FROM models m
        INNER JOIN sales s ON m.id = s.model_id
        WHERE s.buyer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Обработка URL изображений
    $imageUrls = $row['image_url'];
    $imageUrlsArray = explode(',', $imageUrls);
    $firstImageUrl = !empty($imageUrlsArray[0]) ? trim($imageUrlsArray[0]) : 'placeholder.png';

    // HTML для карточки модели
    $cartHtml .= '<div class="col">' .
        '<div class="card shadow-sm">' .
        '<img src="' . htmlspecialchars($firstImageUrl) . '" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="' . htmlspecialchars($row['name']) . '">' .
        '<div class="card-body">' .
        '<p class="card-text">' . htmlspecialchars($row['name']) . '</p>' .
        '<p class="card-text">Цена: ' . htmlspecialchars($row['price']) . ' </p>' .
        '<div class="d-flex justify-content-between align-items-center">' .
        '<div class="btn-group">' .
        '<a class="btn btn-md btn-outline-secondary mr-2" href="model_details.php?model_id=' . $row['id'] . '">Просмотр</a>' .
'<button type="button" class="btn btn-md btn-outline-secondary" onclick="buyModel(' . $row['id'] . ', ' . $row['user_id'] . ')">Купить</button>'.
        '<button type="button" class="btn btn-md btn-outline-danger delete-sale" data-sale-id="' . $row['sale_id'] . '" onclick="deleteModelFromCart(' . $row['sale_id'] . ')">Удалить</button>' .
        '</div>' . // конец btn-group
        '</div>' . // конец d-flex
        '</div>' . // конец card-body
        '</div>' . // конец card
        '</div>'; // конец col
}

$stmt->close();



$conn->close();
?>


<div class="album py-5 bg-body-tertiary">
    <div class="container ">
        <!-- Блок карточек для купленных моделей, изначально скрыт -->
        <!-- Блоки для отображения карточек -->
    <div id="bought-cards-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" style="display: flex;">
        <?php echo $BuyedModels; ?>
    </div>
    <div id="uploaded-cards-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" style="display: none;">
        <?php echo $uploadedModelsHtml; ?>
    </div>
    <div id="cart-cards-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" style="display: none;">
        <?php echo $cartHtml; ?>
    </div>
    </div>
</div>
</div>
            </div>
        </div>

    </div>
<!-- Модальное окно Успеха -->
<div class="modal fade" id="profileSuccessModal" tabindex="-1" role="dialog" aria-labelledby="profileSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileSuccessModalLabel">Успех</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Фото профиля успешно обновлено!
            </div>
        </div>
    </div>
</div>

    <?php include('footer.html'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var profilePhoto = document.getElementById('profile-photo');
    var fileInput = document.getElementById('profile-image-input');
    var defaultPhoto = 'logo.png'; // URL фото по умолчанию
    var hoverPhoto = 'profile.png'; // URL фото при наведении
    var currentPhoto = profilePhoto.src; // Текущее фото профиля

    function showProfileImage() {
        // Если установлено фото профиля, показываем profile.png при наведении
        if (currentPhoto !== defaultPhoto) {
            profilePhoto.src = hoverPhoto;
            profilePhoto.classList.add('transparent');
        }
    }

    function hideProfileImage() {
        // Возвращаем текущее фото профиля при уходе курсора
        profilePhoto.src = currentPhoto;
        profilePhoto.classList.remove('transparent');
    }

// Функция для загрузки фото профиля с устройства
function uploadProfileImage() {
    document.getElementById('profile-image-input').click();
}

    // Обработчик события выбора файла
    fileInput.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var formData = new FormData();
            formData.append('profile_photo', file);

           $.ajax({
    url: 'profile.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        if (response.includes('Фото профиля обновлено')) {
            $('#profileSuccessModal').modal('show'); // Показать модальное окно
        } else {
            alert('Ошибка загрузки фото профиля: ' + response);
        }
    },
    error: function() {
        alert('Ошибка выполнения запроса');
    }
});

        }
    });

    // Назначаем обработчики событий
    if (profilePhoto && fileInput) {
        profilePhoto.addEventListener('click', function() {
            fileInput.click();
        });
        profilePhoto.addEventListener('mouseover', showProfileImage);
        profilePhoto.addEventListener('mouseout', hideProfileImage);
    }
});

    </script>
<script>
       document.addEventListener('DOMContentLoaded', (event) => {
    // Получаем кнопки по их id
    const boughtButton = document.getElementById('bought');
    const uploadedButton = document.getElementById('uploaded');
    const cartButton = document.getElementById('cart');

    // Определяем функцию для скрытия всех блоков
    function hideAllCards() {
        document.getElementById('bought-cards-container').style.display = 'none';
        document.getElementById('uploaded-cards-container').style.display = 'none';
        document.getElementById('cart-cards-container').style.display = 'none';
    }

    // Определяем функцию для показа блока
    function showCards(containerId) {
        hideAllCards();
        document.getElementById(containerId).style.display = 'flex';
    }

    // Добавляем обработчики клика на каждую кнопку
    boughtButton.addEventListener('click', function() {
        showCards('bought-cards-container');
    });

    uploadedButton.addEventListener('click', function() {
        showCards('uploaded-cards-container');
    });

    cartButton.addEventListener('click', function() {
        showCards('cart-cards-container');
    });
});

    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script >
    document.addEventListener('DOMContentLoaded', function () {
    // Обработчик клика на кнопку подтверждения покупки
    $('.confirm-purchase').click(function() {
        var modelId = $(this).data('model-id');
        var sellerId = $(this).data('seller-id');

        $.ajax({
            url: 'purchase_model.php', // Скрипт обработки покупки на сервере
            type: 'POST',
            data: { model_id: modelId, seller_id: sellerId },
            success: function(response) {
                // Если покупка успешна, обновите интерфейс
                $('#model-card-' + modelId).remove(); // Удалить карточку из корзины
                // Добавить карточку в купленные (это может потребовать дополнительного кода)
                $('#bought-cards-container').append(response);
            },
            error: function() {
                alert('Ошибка выполнения запроса');
            }
        });
    });
});

</script>
<script>
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-sale')) {
        var saleId = event.target.getAttribute('data-sale-id');
        if (confirm('Вы уверены, что хотите удалить эту запись о продаже?')) {
            // AJAX-запрос на удаление записи о продаже
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_sale.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(this.responseText);
                    // Перезагрузка страницы или обновление DOM после удаления
                    location.reload();
                } else {
                    alert('Ошибка при удалении записи о продаже');
                }
            };
            xhr.send('sale_id=' + saleId);
        }
    }
});
</script>
<script>
function deleteModel(modelId) {
    if (confirm('Вы уверены, что хотите удалить эту модель?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_model.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Модель удалена.');
                // Обновите вашу страницу или удалите элемент из DOM
                window.location.reload();
            } else {
                alert('Произошла ошибка при удалении модели.');
            }
        };
        xhr.send('model_id=' + modelId);
    }
}
</script>

<script>
function buyModel(modelId, sellerId) {
    if (confirm('Вы уверены, что хотите купить эту модель?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'purchase_model.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Покупка успешно совершена.');
                window.location.reload();
            } else {
                alert('Произошла ошибка при покупке модели.');
            }
        };
        xhr.send('model_id=' + modelId + '&seller_id=' + sellerId);
    }
}

</script>




</body>
</html>