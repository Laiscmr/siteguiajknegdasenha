document.addEventListener('DOMContentLoaded', function () {
    const helpWidget = document.querySelector('.help-widget');
    const helpContent = document.querySelector('.help-content');

    helpWidget.addEventListener('click', function () {
        helpContent.classList.toggle('active');
    });

    // Fecha o conteúdo de ajuda se clicar fora dele
    document.addEventListener('click', function (event) {
        if (!helpWidget.contains(event.target) && !helpContent.contains(event.target)) {
            helpContent.classList.remove('active');
        }
    });
});