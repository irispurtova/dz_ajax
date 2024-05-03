<!-- Модальное окно -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>

        <h2>Форма изменения проекта</h2>
        <form id="editForm">
            <table class="tbl">
                <tr>
                    <td style="width: 266px;">Проект:</td>
                    <td><input type='text' id='editName' name='editName' value="" required style="width: 370px;"/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Цена проекта:</td>
                    <td><input type='number' id='editPrice' name='editPrice' value="" required style="width: 370px;"/></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Площадь проекта:</td>
                    <td><input type='number' id='editSquare' name='editSquare' value="" required style="width: 370px;"/></p></td>
                </tr>
                <tr>
                    <td style="width: 266px;">Технология проекта:</td>
                    <td>
                        <label>
                            <input type="checkbox" id="brickCheckbox" value="кирпич"> Кирпич
                        </label>
                        <label>
                            <input type="checkbox" id="gasConcreteCheckbox" value="газобетон"> Газобетон
                        </label>
                        <label>
                            <input type="checkbox" id="frameCheckbox" value="каркас"> Каркас
                        </label>
                    </td>
                </tr>
            </table>

            <input type="submit" class="tbl-submit" value="Сохранить изменения">
        </form>
        <div id="result-upd"></div>
    </div>
</div>