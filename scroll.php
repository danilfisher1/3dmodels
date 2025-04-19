<?php
// scroll.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* Стили для кнопки скроллинга */
#scrollToTopButton {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: none;
  z-index: 99;
  border: none;
  outline: none;
  
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 10px;
}

#scrollToTopButton:hover {
  background-color: #555;
}
</style>
</head>
<body>

<!-- Содержимое вашей страницы -->
<div class="fs-2 mx-3 mb-3" id="scrollToTopButton" onclick="scrollToTop()">

<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0m-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707z"></path>
</svg>
</div>

<script>
// Показываем кнопку когда страница проскроллена на 20px от верха
window.onscroll = function() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("scrollToTopButton").style.display = "block";
  } else {
    document.getElementById("scrollToTopButton").style.display = "none";
  }
};

// Плавно скроллим к верху страницы
function scrollToTop() {
  window.scrollTo({top: 0, behavior: 'smooth'});
}
</script>

</body>
</html>
