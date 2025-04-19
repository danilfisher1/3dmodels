document.getElementById('modelInput').addEventListener('change', function (event) {
    const modelPreview = document.getElementById('modelPreview');
    const selectedModel = event.target.files[0];

    if (selectedModel && selectedModel.name.endsWith('.mview')) {
        const reader = new FileReader();
        reader.onload = function () {
            const modelName = 'model_uploads/' + selectedModel.name; // Путь к выбранному файлу

            const iframe = document.createElement('iframe');
            iframe.width = '100%';
            iframe.height = '550px';
            iframe.frameBorder = '0';
            iframe.allowFullscreen = 'allowfullscreen';
            iframe.scrolling = 'no';
            iframe.classList.add('custom-iframe-style');

            const modelEmbedScript = `
                marmoset.embed('${modelName}', { 
                    width: 1110, 
                    height: 550, 
                    autoStart: true, 
                    fullFrame: false, 
                    pagePreset: true
                });
            `;

            // Создаем содержимое для iframe
            const iframeContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${modelName}</title>
                    <style>
                        body, div {
                            background-color: #34a4a100!important;
                            box-shadow: none !important;
                            padding: 0px!important;
                            margin-top: 0px!important;
                            margin-left: 0px!important;
                            margin-bottom: 0px!important;
                            margin-right: 0px!important;
                        }
                    </style>
                    <script src="https://viewer.marmoset.co/main/marmoset.js"></script>
                </head>
                <body>
                    <script>${modelEmbedScript}</script>
                </body>
                </html>
            `;

            // Записываем содержимое в iframe
            iframe.srcdoc = iframeContent;

            // Очищаем содержимое modelPreview и добавляем iframe
            modelPreview.innerHTML = '';
            modelPreview.appendChild(iframe);
        };
        reader.readAsDataURL(selectedModel);
    } else {
        // Если выбран неправильный формат файла
        modelPreview.innerHTML = 'Выберите файл формата .mview';
    }
});
