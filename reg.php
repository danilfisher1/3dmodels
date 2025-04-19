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
    if (isset($_POST['Email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        $email = $conn->real_escape_string($_POST['Email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmPassword'];

        // Проверка совпадения паролей
        if ($password == $confirm_password) {
            // Хеширование пароля
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Проверка, существует ли уже такой email
$checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($checkEmail->num_rows == 0) {
    // Вставка нового пользователя
    $sql = "INSERT INTO users (email, password_hash) VALUES ('$email', '$password_hash')";

    if ($conn->query($sql) === TRUE) {
        // Обрезаем email до символа "@" и вставляем в "username"
        $username = explode("@", $email)[0];
        $updateUsernameSql = "UPDATE users SET username='$username' WHERE email='$email'";
        $conn->query($updateUsernameSql);

        // Перенаправление после успешной регистрации
        header('Location: signing.php');
        exit;
    } else {
        $errors[] = "Error: " . $conn->error;
    }
} else {
    $errors[] = "Пользователь с таким Email уже существует";
}

        } else {
            $errors[] = "Пароли не совпадают";
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
            /* Добавляем стили для отображения ошибки */
        .error-message {
            color: red;
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
                                <h1 class="ls-tight fw-bolder h3 mt-3">Зарегистрироваться</h1>
                            </div>
                            <form method="POST" action="reg.php">
    <div class="mb-2">
        <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
            <label class="form-label mb-0" for="Email">Email</label>
            <div id="emailError" class="text-danger"></div>
        </div>
        <input type="Email" class="form-control" id="Email" name="Email" autocomplete="Email" required>
    </div>
    <div class="mb-3">
        <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
            <label class="form-label mb-0" for="password">Password</label>
        </div>
        <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
    </div>
    <div class="mb-3">
        <div class="d-flex justify-content-between gap-2 mb-2 align-items-center">
            <label class="form-label mb-0" for="confirmPassword">Confirm Password</label>
            <div id="passwordError" class="text-danger"></div>
        </div>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" autocomplete="current-password" required>
        
        <?php
        // Отображаем ошибку, если она есть
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="text-danger">' . $error . '</div>';
            }
        }
        ?>
    </div>
    <div>
        <button type="submit" class="btn btn-warning w-100 mt-4 mb-5">Регистрация</button>
    </div>
</form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
      <script>
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirmPassword");
    var emailInput = document.getElementById("Email");
    var passwordError = document.getElementById("passwordError");
    var emailError = document.getElementById("emailError");

    confirmPasswordInput.addEventListener("input", function () {
        var password = passwordInput.value;
        var confirmPassword = confirmPasswordInput.value;

        if (password !== confirmPassword) {
            passwordError.textContent = "Пароли не совпадают";
        } else {
            passwordError.textContent = "";
        }
    });

    emailInput.addEventListener("input", function() {
        var email = emailInput.value;
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        if (!emailRegex.test(email)) {
            emailError.textContent = "Неправильный формат электронной почты";
        } else {
            emailError.textContent = "";
        }
    });
</script>

   
</main>
</body>
</html>
