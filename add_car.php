<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}// Начинаем сессию

// Проверяем, установлена ли сессия с пользовательским ID
if (!isset($_SESSION['user_id'])) {
    // Если сессия не установлена, перенаправляем пользователя на страницу входа
    header("Location: signing.php"); // Замените "login.php" на URL вашей страницы входа
    exit(); // Завершаем выполнение скрипта
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Добавить автомобиль</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://viewer.marmoset.co/main/marmoset.js"></script>

    <style>
        .card-img-top {
            object-fit: cover;
        }
        .bg-dark-subtle {
            background-color: #ced4da;
        }
        .border-dark-subtle {
            border-color: #adb5bd!important;
        }
        /* Стиль для кнопки выбора файла, подобный классу "btn btn-warning" */
        input[type="file"] {
            display: none; /* Скрываем стандартную кнопку выбора файла */
        }

        .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #ffc107; /* Цвет фона, подобный классу "btn-warning" */
            color: #000; /* Цвет текста, подобный классу "btn-warning" */
            border-radius: 5px;
            width: 15%; /* Ширина кнопки */
        }

        /* Стиль для текста загрузки файла */
        label[for="photoInput"] {
            margin-bottom: 10px;
            display: block;
        }

        #document {
            background-color: #f0f0f0!important; /* Новый цвет фона */
        }
        .close {
    position: absolute!important;
    top: 5px!important;
    right: 5px!important;
    color: white!important; /* Цвет крестика */
    background-color: #000000!important; /* Цвет фона за крестиком */
    border-radius: 10%!important; /* Добавляем скругление для создания круглого фона */
    
    cursor: pointer!important;
}


    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header bg-warning text-white">
                        <h2 class="mb-0">Добавить автомобиль</h2>
                    </div>
                <form action="add_car_process.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Имя автомобиля:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание:</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена:</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="photoInput" style="max-width: 17%;" class="custom-file-upload">Выбрать Фото</label>
                        <input type="file" id="photoInput" name="image[]" accept="image/*" multiple required>
                    </div>
                    <div id="photoGallery" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"></div>
                    <div class="form-group">
                        <!--<label for="modelInput" style="max-width: 17%;" class="custom-file-upload">Добавить модель</label>-->
                        <input type="file" id="modelInput" name="model" accept=".mview">
                    </div>
                    <div id="modelPreview" class="d-grid gap-3" style="grid-template-columns: 3fr;">
                        
                    </div>

                    <div class="form-group">
                        <label for="polygon_count">Количество полигонов:</label>
                        <input type="number" class="form-control" name="polygon_count" required>
                    </div>
                    <div class="form-group">
                        <label for="modelFormat">Формат модели:</label>
                        <select class="form-control" id="modelFormat" name="modelFormat">
                            <option value="GLB">Выбор Формата</option>
                            <option value="Maya">Maya</option>
                            <option value="Blend">Blend</option>
                            <option value="STL">STL</option>
                            <option value="OBJ">OBJ</option>
                            <option value="FBX">FBX</option>
                        </select>
                    </div>
                    <div id="formatContainer" class="d-flex justify-content-start py-2">
                        <!-- Здесь будут отображаться выбранные форматы -->
                    </div>
                    <input type="hidden" name="formatContainer" id="formatContainerInput" value="">

                    <div class="form-group">
                        <label for="vehicle_type_id">Тип транспортного средства:</label>
                        <select class="form-control" name="vehicle_type_id" id="vehicleType" required>
                            <option value="">Выберите тип транспортного средства</option>
                            <option value="1">Суперкары</option>
                            <option value="2">Спорткары</option>
                            <option value="3">Болиды</option>
                            <option value="4">Маслкары</option>
                            <option value="5">Спортивная классика</option>
                            <option value="6">Купе</option>
                            <option value="7">Седаны</option>
                            <option value="8">Компакты</option>
                            <option value="9">Вездеходы</option>
                            <option value="10">Внедорожники</option>
                            <option value="11">Фургоны</option>
                            <option value="12">Мотоциклы</option>
                            <option value="13">Велосипеды</option>
                            <option value="14">Экстренные службы</option>
                            <option value="15">Военный транспорт</option>
                            <option value="16">Коммерческий транспорт</option>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning custom-file-upload">Добавить авто</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно для просмотра фотографии в полноразмерном режиме -->
    <div class="modal" id="photoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Просмотр фотографии</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" class="img-fluid mx-auto d-block" alt="Фотография">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

<script>
    const photoInput = document.getElementById("photoInput");
    const photoGallery = document.getElementById("photoGallery");

    photoInput.addEventListener("change", function () {
        const files = this.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function (e) {
                const photoCard = createPhotoCard(e.target.result, file.name);
                photoGallery.appendChild(photoCard);

                const closeButton = photoCard.querySelector(".close");
                closeButton.addEventListener("click", function () {
                    photoCard.remove();
                });
            };

            reader.readAsDataURL(file);
        }
    });

    function createPhotoCard(imageSrc, imageName) {
        const col = document.createElement("div");
        col.className = "col";

        const card = document.createElement("div");
        card.className = "card shadow-sm position-relative"; // Добавляем класс для позиционирования элементов

        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.className = "close px-2 pb-2";
        closeButton.innerHTML = "&times;";
        
        

        const img = document.createElement("img");
        img.src = imageSrc;
        img.className = "bd-placeholder-img card-img-top";
        img.width = 225;
        img.height = 225;

        const cardBody = document.createElement("div");
        cardBody.className = "card-body";

        const cardText = document.createElement("p");
        cardText.className = "card-text";
        cardText.innerText = imageName;

        const buttonGroup = document.createElement("div");
        buttonGroup.className = "d-flex justify-content-between align-items-center";

        const button = document.createElement("button");
        button.type = "button";
        button.className = "btn btn-md btn-outline-secondary";
        button.setAttribute("data-bs-toggle", "modal");
        button.setAttribute("data-bs-target", "#photoModal");
        button.innerText = "Увеличить";

        card.appendChild(img);
        card.appendChild(closeButton);
        card.appendChild(cardBody);
        buttonGroup.appendChild(button);
        cardBody.appendChild(cardText);
        cardBody.appendChild(buttonGroup);
        col.appendChild(card);

        return col;
    }
</script>
<script >
    var myModal = document.getElementById('modal')
var myInput = document.getElementById('photoModal')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formatSelect = document.getElementById('modelFormat');
            const formatContainer = document.getElementById('formatContainer');

            formatSelect.addEventListener('change', function () {
                const selectedFormat = formatSelect.value;

                // Применяем формат
                applyFormat(selectedFormat);

                // Удаляем выбранный формат из списка
                const optionToRemove = formatSelect.querySelector(`option[value='${selectedFormat}']`);
                if (optionToRemove) {
                    optionToRemove.remove();
                }
            });

            function applyFormat(format) {
                // Ваш код для применения формата
                // Например, добавление выбранного формата в блок
                const formatBadge = document.createElement('span');
                formatBadge.className = 'badge bg-dark-subtle border border-dark-subtle text-dark-emphasis rounded-pill mx-2';
                formatBadge.textContent = format;
                formatContainer.appendChild(formatBadge);

                // Обновление скрытого поля
                const formatContainerInput = document.getElementById('formatContainerInput');
                const selectedFormats = Array.from(formatContainer.children).map(span => span.textContent);
                formatContainerInput.value = selectedFormats.join(',');
            }

        });
    </script>

    <script src="https://viewer.marmoset.co/main/marmoset.js"></script>
    <script src="model_view.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
