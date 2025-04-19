<?php
// Подключение к базе данных
$conn = new mysqli("localhost", "root", "", "3dmodels");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = []; // Массив для хранения ошибок

// Обработка данных формы при отправке
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, установлены ли переменные
    if (isset($_POST['Email']) && isset($_POST['password'])) {
        $email = $conn->real_escape_string($_POST['Email']);
        $password = $_POST['password'];

        // Проверка, существует ли пользователь с таким email
        $checkUser = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($checkUser->num_rows == 1) {
            $user = $checkUser->fetch_assoc();
            // Проверка пароля
            if (password_verify($password, $user['password_hash'])) {
                // Пароль верный, выполните вход пользователя
                session_start();
                $_SESSION['user_id'] = $user['id'];
                
                // Перенаправьте пользователя на страницу после входа
                header("Location: home.php");
                exit;
            }
        } else {
            $errors[] = "Пользователь с таким Email не существует";
        }
    }
}

$conn->close();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Sign</title>

    
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
   
  </head>
<body class="text-center">
<main class="form-signin">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="w-md-50 mx-auto px-10 px-md-0 py-10">
                            <div class="mb-10">
                              <a class="d-inline-block  mb-10" href="home.php">
                                    <img src="logo.png" width="72" height="72">
                                </a>
                                <h1 class="ls-tight fw-bolder h3 mt-3">Войти</h1>
                            </div>
                            <form method="POST" action="signing.php">
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
                                        <label class="form-label mb-0" for="Email">Email</label>
                                    </div>
                                    <input type="Email" class="form-control" id="Email" name="Email" autocomplete="Email" required>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
                                        <label class="form-label mb-0" for="password">Password</label>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                                </div>
<?php
        // Отображаем ошибку, если она есть
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="text-danger">' . $error . '</div>';
            }
        }
        ?>
                                <div>
                                    <button type="submit" class="btn btn-warning w-100 mt-4 mb-2">Войти</button>
                                </div>

                                <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
                                    <a class=" text-dark text-muted mb-0" for="reg" href="reg.php">Еще не зарегистрированы?</a>
                                </div>

                            </form>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script >
      // Находим все элементы с псевдоэлементом ::after
const elementsWithAfter = document.querySelectorAll('*::after');

// Перебираем найденные элементы
elementsWithAfter.forEach((element) => {
    // Получаем стили псевдоэлемента ::after
    const styles = window.getComputedStyle(element, '::after');

    // Проверяем, есть ли у этого элемента псевдоэлемент ::after и его содержимое
    if (styles && styles.content !== 'none') {
        // Удаляем содержимое псевдоэлемента ::after
        element.style.content = 'none';
    }
});

    </script>
</main>
</body>
</html>
