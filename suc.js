
            $.ajax({
                url: "success.php",
                type: "GET",
                success: function(data) {
                    $("#success-content").html(data); // Отображение содержимого success.php
                }
            });
