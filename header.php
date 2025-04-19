<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>

    <title>Магазин 3D Моделей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <style>
        .active {
            
            color: #ffc107; /* Цвет активной ссылки */
        }


        .nav-link.active:hover {
            color: #ffc107; /* Белый цвет текста при наведении на активную ссылку */
        }
html {
  scroll-behavior: smooth;
}

/* Стилизация скроллбара для всего документа */
::-webkit-scrollbar {
  width: 12px; /* ширина скроллбара */
  border-radius: 10px; /* закругленные края */
}

::-webkit-scrollbar-track {
  background: #343a40; /* цвет дорожки - цвет warning */
  
}

::-webkit-scrollbar-thumb {
  background: #ffc107; /* более темный цвет ползунка */
  border-radius: 10px; /* закругленные края */
  border: 3px solid #343a40; /* граница с цветом фона дорожки */
}

::-webkit-scrollbar-thumb:hover {
  background: #d39e00; /* цвет ползунка при наведении */
}
.bg-warning-subtle {
    background-color: #ffc107;
}
#profile-photo1 {

    border-radius: 50%;
    cursor: pointer;
    transition: opacity 0.3s; /* Анимация перехода для плавного изменения прозрачности */
    object-fit: contain;
        object-position: center;
}

#searchResults {
  position: absolute; /* Позиционирование относительно ближайшего относительно позиционированного предка */
  width: 100%; /* Ширина блока может быть изменена в зависимости от вашего дизайна */
  top: 100%; /* Позиционирование сразу под элементом поиска */
  left: 0;
  z-index: 1000; /* Убедитесь, что z-index выше, чем у других элементов на странице */
  background-color: #fff; /* Фон для результатов поиска, может быть изменён */
  border: 1px solid #ddd; /* Добавляет границу вокруг результатов поиска */
  border-top: none; /* Убирает верхнюю границу */
  box-shadow: 0 8px 16px rgba(0,0,0,0.15); /* Добавляет тень для всплывающего эффекта */
  overflow-y: auto; /* Добавляет прокрутку если содержимое превышает высоту */
  max-height: 500px; /* Максимальная высота блока результатов */
}

/* Стиль для контейнера результатов поиска внутри #searchResults */
#searchResults .container {
  padding: 15px;
}
/* Пример стиля для контейнера формы поиска */
.search-container {
  position: relative; /* Теперь #searchResults будет позиционироваться относительно этого элемента */
  /* другие стили */
}


#searchResults {
  position: fixed; /* Теперь блок будет фиксированным и всегда видим на экране */
  top: 92px;
  left: 0;
  
  right: 0;
  z-index: 1000;
  display: none; /* Скрывает результаты поиска по умолчанию */
  /* Ваши остальные стили... */
  
}


#searchResults.show {
  display: block; /* Показывает результаты поиска */
  display: flex;
}

    </style>
</head>
<body>
    <?php include('scroll.php'); ?>
    <header>
        <div class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="logo.png" width="40" height="40" alt="Логотип сайта">
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="home.php" class="nav-link px-2 text-white">Главная</a></li>
                    <li><a href="categories.php" class="nav-link px-2 text-white">Категории</a></li>
                    
                    <li><a href="contests.php" class="nav-link px-2 text-white">Конкурсы</a></li>
                    <li><a href="about.php" class="nav-link px-2 text-white">О Нас</a></li>
                </ul>

                <div class="search-container">
  <form class="col-12">
    <input type="search" class="form-control form-control-dark" id="searchInput" placeholder="Search..." aria-label="Search">
  </form>
  
  <div class="album bg-body-tertiary">
    <div class="container">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-3" id="searchResults">
            <!-- Здесь будут появляться результаты поиска -->
        </div>
    </div>
</div>
</div>

        

                <div class="text-end">
                    <?php

                    $conn = new mysqli("localhost", "root", "", "3dmodels");

// Проверка на ошибку подключения
if (isset($_SESSION['user_id'])) {
    // Получите user_id из сессии
    $user_id = $_SESSION['user_id'];
    
    // Здесь вы должны выполнить запрос к вашей базе данных для получения имени пользователя
    // и сохранения его в переменной $username
    $username = ''; // Инициализация переменной для имени пользователя
if (isset($_SESSION['user_id'])) {
    // Получите user_id из сессии
    $user_id = $_SESSION['user_id'];

    // Здесь вы должны выполнить запрос к вашей базе данных для получения имени пользователя
    // и сохранения его в переменной $username
    $sql = "SELECT username, profile_photo FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username']; // Имя пользователя из базы данных
        if (!empty($row['profile_photo'])) {
            $currentProfilePhoto = $row['profile_photo'];
        }
    }
}
    
    // Здесь также получите путь к фото профиля из базы данных на основе user_id
    // Замените 'your_database_query' на ваш запрос
    $sql = "SELECT profile_photo FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentProfilePhoto = $row['profile_photo'];
        
        // Проверка на null и установка стандартного фото профиля, если не задано
        if ($currentProfilePhoto === null) {
            $currentProfilePhoto = 'profile.png'; // Замените на путь к вашей стандартной фотографии
        }
    } else {
        // Если запрос не успешен или фото профиля отсутствует, установите путь к стандартной фотографии
        $currentProfilePhoto = 'profile.png'; // Замените на путь к вашей стандартной фотографии
    }

    // Выведите меню для авторизованного пользователя в виде ссылки
    echo '<a href="profile.php" class="badge d-flex align-items-center justify-content-center p-1 pe-2 bg-warning rounded-pill">';
    echo '<img class="rounded-circle me-1" width="36" height="36" src="' . $currentProfilePhoto . '" alt="Фото профиля" id="profile-photo1">';
    echo '<h6 class="pt-2 pr-2 pl-2 text-dark">' . $username . '</h6>';
    echo '</a>';
} else {
    // Если пользователь не авторизован, выведите стандартное меню
    echo '<div class="text-end">';
    echo '<a type="button" class="btn btn-outline-light me-2" href="signing.php">Вход</a>';
    echo '<a type="button" class="btn btn-warning"  href="reg.php">Регистрация</a>';
    echo '</div>';

}
?>

                    
                </div>
            </div>
        </div>
        </div>
    </header>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var navLinks = document.querySelectorAll(".nav-link");

            navLinks.forEach(function(link) {
                link.addEventListener("click", function(event) {
                    navLinks.forEach(function(item) {
                        item.classList.remove("active");
                        item.classList.add("text-white");
                    });

                    this.classList.add("active");
                    this.classList.remove("text-white");
                    
                    // Получаем URL из атрибута href ссылки
            var url = this.getAttribute("href");
            
            // Перенаправляем на указанный URL
            window.location.href = url;
            
            event.preventDefault();

                    // Сохраняем состояние в cookie
                    document.cookie = "headerState=" + this.innerText;
                    
                    event.preventDefault();
                });
            });

            // Восстанавливаем состояние при загрузке страницы
            var headerState = getCookie("headerState");
            if (headerState) {
                navLinks.forEach(function(link) {
                    if (link.innerText === headerState) {
                        link.classList.add("active");
                        link.classList.remove("text-white");
                    }
                });
            }
        });

        function getCookie(name) {
            var cookies = document.cookie.split(";");
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.startsWith(name + "=")) {
                    return cookie.substring(name.length + 1);
                }
            }
            return "";
        }
    </script>

<script>
document.addEventListener("DOMContentLoaded", function(){
  var timeout = null;
  var searchResults = document.getElementById("searchResults");

  document.getElementById("searchInput").addEventListener("keyup", function(){
    var searchQuery = this.value;
    clearTimeout(timeout);

    if(searchQuery.length > 0){
      timeout = setTimeout(function () {
        fetch('search.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'query=' + encodeURIComponent(searchQuery)
        })
        .then(response => response.json())
        .then(data => {
          searchResults.innerHTML = data.join(''); // Склеиваем все элементы массива в одну строку HTML
          searchResults.classList.add('show'); // Добавляем класс, чтобы показать результаты
        })
        .catch(error => {
          console.error('Error:', error);
          searchResults.classList.remove('show'); // Удаляем класс, если есть ошибка
        });
      }, 300);
    } else {
      searchResults.classList.remove('show'); // Удаляем класс, чтобы скрыть результаты
      searchResults.innerHTML = ''; // Очищаем предыдущие результаты
    }
  });
});
</script>






</body>
</html>
