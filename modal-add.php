<div id="addProjectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addProjectModal')">&times;</span>

        <h2>Форма добавления проекта</h2>
        <form method="post" enctype="multipart/form-data" id="addProjectForm">
            <table class="tbl">
                <tr>
                    <td style="width: 266px;">Проект:</td>
                    <td><input type='text' id='namepr' name='namepr' placeholder="Введите название проекта" required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Цена проекта:</td>
                    <td><input type='number' id='price' name='price' placeholder="Введите цену проекта" required/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Площадь проекта:</td>
                    <td><input type='number' id='square' name='square' placeholder="Введите площадь проекта" required/></p></td>
                </tr>                        
                <tr>
                    <td style="width: 266px;">Технология проекта:</td>
                    <td>
                        <label>
                            <input type="checkbox" name="technology[]" id="brick" value="кирпич"> Кирпич
                        </label>
                        <label>
                            <input type="checkbox" name="technology[]" id="gasblock" value="газобетон"> Газобетон
                        </label>
                        <label>
                            <input type="checkbox" name="technology[]" id="frame" value="каркас"> Каркас
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="width: 266px;">Фото:</td>
                    <td>
                        <input type="file" id="projectImage" name="projectImage[]" accept="image/*" onchange="previewImage()">
                        <div id="imagePreview"></div>
                    </td>
                </tr>
            </table>

            <input type='submit' class="tbl-submit" value='Добавить проект' onclick="addProject(event)">
        </form>
        <div id="result"></div>
    </div>
</div>

<?php require "save_project.php"; ?>