<?php
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="project">
                <div class="img" style='background-image: url("<?= $row['img_src']; ?>"); background-repeat: no-repeat; background-size:545px 364px;'>
                    <div class="pic_text">
                        <span style="color: white; font-weight: bold"><?= $row['square']; ?> м<sup>2</sup></span>
                        <a href=#>
                            <div class="button" onclick="openEditModal(event, '<?php echo $row['id']; ?>', 
                                                                        '<?php echo htmlspecialchars($row['namepr'], ENT_QUOTES, 'UTF-8'); ?>', 
                                                                        '<?php echo $row['price']; ?>', 
                                                                        '<?php echo $row['square']; ?>',
                                                                        '<?php echo htmlspecialchars($row['technology'], ENT_QUOTES, 'UTF-8'); ?>')">Изменить</div>
                        </a>
                        <a href=#>
                            <div class="button" onclick="openDeleteModal(event, <?php echo $row['id']; ?>)">Удалить</div>
                        </a>
                        
                    </div>
                    <div class="text">
                        <p><strong><?= $row['namepr']; ?></strong></p>
                        <p
                            style="border-top: solid #eeeeee 1px; border-bottom: solid #eeeeee 1px;">
                            <?= number_format($row['price'], 0, '.', ' ') ?></p>
                        <p>Технология: <strong><?= $row['technology']; ?></strong></p>
                    </div>
                </div>                                
            </div>
            <?php
        }
    } 
?>