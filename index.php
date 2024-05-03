<?php 
    // подключение к бд
    require "connect.php"; 
    // получение значений для фильтра
    require "filter-values.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Медный всадник</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- стили -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<div class="inner">
    <div class="inner-header">
        <h1>Строительство загородных домов - проекты и цены</h1>
    </div>

    <div class="filter">
        
        <form id="filterForm" method="POST">

            <h2>Фильтр</h2>

            <div class="filter-blocks">

                <div class="filter-price">
                    <div class="filter-price-header">
                        <p>СТОИМОСТЬ СТРОИТЕЛЬСТВА</p>
                    </div>

                    <div class="filter-price-inputs">
                        <div class="min">
                            <label for="minPrice">от:</label>
                            <input type="text" id="minPrice" name="minPrice" value=<?= $minPrice; ?>>
                        </div>

                        <div class="max">
                            <label for="maxPrice">до:</label>
                            <input type="text" id="maxPrice" name="maxPrice" value=<?= $maxPrice; ?>>
                        </div>
                    </div>

                </div>

                <div class="filter-square">
                    <div class="filter-square-header">
                        <p>ОБЩАЯ ПЛОЩАДЬ</p>
                    </div>

                    <div class="filter-square-inputs">
                        <div class="min">
                            <label for="minSquare">от:</label>
                            <input type="text" id="minSquare" name="minSquare" value=<?= $minSquare; ?>>
                        </div>
                        <div class="max">
                            <label for="maxSquare">до:</label>
                            <input type="text" id="maxSquare" name="maxSquare" value=<?= $maxSquare; ?>>
                        </div>
                    </div>

                </div>

            </div>

            <div class="filter-buttons">

                <div class="filter-show-button">
                    <button type="button" onclick="applyFilter()">ПРИМЕНИТЬ ФИЛЬТР</button>
                </div>

                <div class="filter-del-button">
                    <button type="button" onclick="resetFilters()">СБРОСИТЬ ФИЛЬТР</button>
                </div>

                <!-- <div class="filter-del-button">
                    <button type="button" onclick="FUNCTION_BEFORE()">СБРОСИТЬ ФИЛЬТР</button>
                </div> -->

                <!-- <script>
                    function FUNCTION_BEFORE() {
                        var parentElement = document.querySelector('.filter-del-button');
                        var existingElement = document.querySelector('.hello-world');

                        if (existingElement) {
                            // Если элемент уже существует, удаляем его
                            parentElement.removeChild(existingElement);
                        } else {
                            // Если элемента нет, создаем новый элемент и вставляем его перед кнопкой
                            var newElement = document.createElement('div');
                            newElement.className = 'hello-world';
                            newElement.textContent = 'Hello world!';
                            parentElement.insertBefore(newElement, parentElement.firstChild);
                        }
                    }
                </script> -->

            </div> 

        </form>

        <!-- кнопка для добавления проекта -->
        <a href="">
            <div class="button" style="margin-top: 20px" onclick="openAddProjectModal(event)">ДОБАВИТЬ ПРОЕКТ</div>
        </a> 
        
        <!-- сортировка -->
        <div class="sort">
            <a id="sortButton" onclick="toggleSort()">СОРТИРОВАТЬ ПО ЦЕНЕ <span id="sortSymbol">&#32;</span></a>
            <a id="sortAreaButton" onclick="toggleAreaSort()">СОРТИРОВАТЬ ПО ПЛОЩАДИ <span id="sortAreaSymbol">&#32;</span></a>
        </div>   
        
        <?php 
            require "filter.php";
        ?>

        <div id="resultContainer"></div>        
        
        <!-- МОДАЛЬНЫЕ ОКНА -->
        <!-- Модальное окно для добавления проекта -->
        <?php include "modal-add.php"; ?>

        <!-- Модальное окно для изменения проекта -->
        <?php include "modal-upd.php"; ?>

        <!-- Модальное окно для удаления проекта -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeDeleteModal()">&times;</span>
                <p>Вы уверены, что хотите удалить эту запись?</p>
                <button onclick="deleteRecord()">Да, удалить</button>
                <button onclick="closeDeleteModal()">Отмена</button>
                <div id="result-del"></div>
            </div>
        </div>

    </div>

    <!-- script для сортировки и фильтрации -->
    <script>
        var sortDirection = 0;  // 0 - не сортировать, 1 - по возрастанию, 2 - по убыванию
        var areaSortDirection = 0;  // 0 - не сортировать, 1 - по возрастанию, 2 - по убыванию

        function toggleSort() { // для сортировки по цене
            sortDirection = (sortDirection + 1) % 3;
            updateSortSymbol();
            updateAreaSortButtonState(); // добавляем вызов функции для обновления состояния второй кнопки
            applyFilter();
        }

        function toggleAreaSort() { // для сортировки по площади
            areaSortDirection = (areaSortDirection + 1) % 3;
            updateAreaSortSymbol();
            updateSortButtonState(); // добавляем вызов функции для обновления состояния первой кнопки
            applyFilter();
        }

        function updateSortButtonState() {
            var sortButton = document.getElementById("sortButton");

            if (areaSortDirection !== 0) {
                // если выбрана сортировка по площади, делаем кнопку сортировки по цене недоступной
                sortButton.disabled = true;
                sortDirection = 0; // сбрасываем направление сортировки по цене
                updateSortSymbol(); // обновляем символ сортировки по цене
            } else {
                // если сортировка по площади не выбрана, делаем кнопку сортировки по цене доступной
                sortButton.disabled = false;
            }
        }

        function updateAreaSortButtonState() {
            var sortAreaButton = document.getElementById("sortAreaButton");

            if (sortDirection !== 0) {
                // если выбрана сортировка по цене, делаем кнопку сортировки по площади недоступной
                sortAreaButton.disabled = true;
                areaSortDirection = 0; // сбрасываем направление сортировки по площади
                updateAreaSortSymbol(); // обновляем символ сортировки по площади
            } else {
                // если сортировка по цене не выбрана, делаем кнопку сортировки по площади доступной
                sortAreaButton.disabled = false;
            }
        }

        function updateSortSymbol() {
            var sortSymbolElement = document.getElementById("sortSymbol");
            
            if (sortDirection == 1) {
                sortSymbolElement.innerHTML = "&#x25B2;"; // символ треугольника вверх
            } else if (sortDirection == 2) {
                sortSymbolElement.innerHTML = "&#x25BC;"; // символ треугольника вниз
            } else {
                sortSymbolElement.innerHTML = ""; // сбрасываем в начальное значение (пустое)
            }
        }

        function updateAreaSortSymbol() {
            var sortAreaSymbolElement = document.getElementById("sortAreaSymbol");

            if (areaSortDirection == 1) {
                sortAreaSymbolElement.innerHTML = "&#x25B2;"; // символ треугольника вверх
            } else if (areaSortDirection == 2) {
                sortAreaSymbolElement.innerHTML = "&#x25BC;"; // символ треугольника вниз
            } else {
                sortAreaSymbolElement.innerHTML = ""; // сбрасываем в начальное значение (пустое)
            }
        }

        function applyFilter() {
            var xhr = new XMLHttpRequest();
            var formData = new FormData(document.getElementById("filterForm"));
            formData.append("sortDirection", sortDirection);
            formData.append("areaSortDirection", areaSortDirection);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("resultContainer").innerHTML = xhr.responseText;
                }
            };

            xhr.open("POST", "filter.php", true);
            xhr.send(formData);
        }

        // вызываем applyFilter при загрузке страницы для отображения начальных данных
        document.addEventListener("DOMContentLoaded", function() {
            applyFilter();
            updateSortSymbol();
            updateAreaSortSymbol();
            updateSortButtonState();
            updateAreaSortButtonState();
        });
    </script>

    <!-- script для сброса фильтра -->
    <script>
        // сброс фильтра
        function resetFilters() {
            document.getElementById("minPrice").value = <?= $minPrice;?>;
            document.getElementById("maxPrice").value = <?=$maxPrice;?>;
            document.getElementById("minSquare").value = <?=$minSquare;?>;
            document.getElementById("maxSquare").value = <?=$maxSquare;?>;
            applyFilter(); // Вызываем функцию applyFilter для сброса фильтров
        }
        
    </script>

    <!-- script для модальных окон (добавление и удаление) -->
    <script>
        // ОТРАБОТЧИК МОДАЛЬНЫХ ОКОН
        function openAddProjectModal(event) {
            event.preventDefault();
            openModal('addProjectModal');
        }

        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
            document.getElementById("result").textContent = '';
        }

        // ОТРАБОТЧИК ПРЕВЬЮ ИЗОБРАЖЕНИЯ
        function previewImage() {
            var input = document.getElementById('projectImage');
            var preview = document.getElementById('imagePreview');

            while (preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var image = document.createElement('img');
                    image.src = e.target.result;
                    preview.appendChild(image);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        // ДОБАВЛЕНИЕ ПРОЕКТА
        function addProject(event) {
            // Отменяем стандартное действие формы (перезагрузку страницы)
            event.preventDefault();

            // Создаем объект XMLHttpRequest
            var request = new XMLHttpRequest();
            // Создаем объект FormData для отправки данных
            var formData = new FormData(document.getElementById("addProjectForm"));

            var projectName = document.getElementById('namepr').value;
            var projectPrice = document.getElementById('price').value;
            var projectSquare = document.getElementById('square').value;
            var projectBrick = document.getElementById('brick').value;
            var projectGasblock = document.getElementById('gasblock').value;
            var projectFrame = document.getElementById('frame').value;
            var projectImage = document.getElementById('projectImage').value;

            formData.append("namepr", projectName);
            formData.append("price", projectPrice);
            formData.append("square", projectSquare);
            formData.append("brick", projectBrick);
            formData.append("gasblock", projectGasblock);
            formData.append("frame", projectFrame);
            formData.append("projectImage", projectImage);

            // Настраиваем запрос
            request.open('POST', 'save_project.php', true);

            // Устанавливаем обработчик события для отслеживания состояния запроса
            request.onreadystatechange = function () {
                if (request.readyState === 4 && request.status === 200) {
                    applyFilter1();
                    resetAddProjectForm();
                    document.getElementById("result").textContent = 'Проект успешно добавлен!';
                }
            };
                
            // Отправляем запрос
            request.send(formData);
        }

        function applyFilter1() {
            var xhr = new XMLHttpRequest();
            var formData = new FormData(document.getElementById("filterForm"));
            formData.append("sortDirection", sortDirection);
            formData.append("areaSortDirection", areaSortDirection);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("resultContainer").innerHTML = xhr.responseText;
                }
            };

            xhr.open("POST", "filter.php", true);
            xhr.send(formData);
        }

        function resetAddProjectForm() {
            // Сбрасываем значения полей формы
            document.getElementById('addProjectForm').reset();
            document.getElementById('imagePreview').textContent = '';
        }
    </script>

    <!-- script для модальных окон (изменение) -->
    <script>
        // ИЗМЕНЕНИЕ ПРОЕКТА
        // JavaScript функции для управления модальным окном изменения
        function openEditModal(event, id, name, price, square, technology) {
            event.preventDefault();

            // Передача данных проекта для изменения
            document.getElementById('editModal').dataset.recordId = id;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editSquare').value = square;

            // Разбиваем строку технологий на массив
            var technologyArray = technology.split(', ');

            // Установка состояния чекбоксов технологий
            if (technologyArray.includes('кирпич')) {
                document.getElementById('brickCheckbox').checked = true;
            } else {
                document.getElementById('brickCheckbox').checked = false;
            }

            if (technologyArray.includes('газобетон')) {
                document.getElementById('gasConcreteCheckbox').checked = true;
            } else {
                document.getElementById('gasConcreteCheckbox').checked = false;
            }

            if (technologyArray.includes('каркас')) {
                document.getElementById('frameCheckbox').checked = true;
            } else {
                document.getElementById('frameCheckbox').checked = false;
            }

            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.getElementById("result-upd").textContent = '';
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
            var recordId = document.getElementById('editModal').dataset.recordId;

            var editedName = document.getElementById('editName').value;
            var editedPrice = document.getElementById('editPrice').value;
            var editedSquare = document.getElementById('editSquare').value;

            // Получение состояния чекбоксов технологий
            var brickCheckboxState = document.getElementById('brickCheckbox').checked;
            var gasConcreteCheckboxState = document.getElementById('gasConcreteCheckbox').checked;
            var frameCheckboxState = document.getElementById('frameCheckbox').checked;

            // Формирование строки технологий
            var editedTechnologyArray = [];
            if (brickCheckboxState) editedTechnologyArray.push('кирпич');
            if (gasConcreteCheckboxState) editedTechnologyArray.push('газобетон');
            if (frameCheckboxState) editedTechnologyArray.push('каркас');
            
            var editedTechnology = editedTechnologyArray.join(', ');

            // AJAX для отправки данных на сервер
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upd-project.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                // Обработка успешного ответа от сервера
                console.log(xhr.responseText);
                //closeEditModal();
                // Дополнительные действия, если нужно, например, обновление интерфейса
                document.getElementById("result-upd").textContent = 'Проект успешно обновлен!';
                applyFilter();
                }
            };
            xhr.send('recordId=' + encodeURIComponent(recordId) +
                '&editedName=' + encodeURIComponent(editedName) +
                '&editedPrice=' + encodeURIComponent(editedPrice) +
                '&editedSquare=' + encodeURIComponent(editedSquare) +
                '&editedTechnology=' + encodeURIComponent(editedTechnology));
});
    </script>

    <script>
        // УДАЛЕНИЕ ПРОЕКТА
        // JavaScript функции для управления модальным окном удаления
        function openDeleteModal(event, id) {
            event.preventDefault()
            // Передача ID записи для удаления
            document.getElementById('deleteModal').dataset.recordId = id;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            document.getElementById("result-del").textContent = '';
        }

        function deleteRecord() {
            var recordId = document.getElementById('deleteModal').dataset.recordId;

            // AJAX для отправки запроса на сервер для удаления записи
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_record.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                // Обработка успешного ответа от сервера
                console.log(xhr.responseText);
                //closeDeleteModal();
                // Дополнительные действия, если нужно, например, обновление интерфейса
                document.getElementById("result-del").textContent = 'Проект успешно удален!';
                applyFilter();
                }
            };
            xhr.send('recordId=' + encodeURIComponent(recordId));
        }

    </script>
</div>

</body>

</html>