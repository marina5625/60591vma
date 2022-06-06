<?php if (!is_null($id_order)) { ?>
    <h2>Ваш заказ:</h2>
    <ol class="order-list">

        <?php while ($item = $result->fetch()) {?>
            <li>
                <a class="order-card"  href="product.php?product_id=<?= $item['id'] ?>">
                    <table>
                        <tr>
                            <td><img src="<?= $item['img_url'] ?>" width="156" height="120" alt="<?= $item['title'] ?>"></td>
                            <td>
                                <h3><?= $item['title'] ?></h3>

                                <div>
                                    <span class="price"><?= $item['price'] ?></span>
                                    Количество: <?= $item['quantity'] ?>

                                    Цвет: <span class="color-<?= $item['color'] ?>"><?= $item['color'] ?></span>

                                </div>

                            </td>
                            <td>
                                <form method="post" action="..\order.php">

                                    <input type="hidden" name="delid" value="<?= $item['id'] ?>">
                                    <p><input type="submit" value="Удалить"></p>
                                </form>
                            </td>
                        </tr>
                    </table>
                </a>
            </li>
        <?php }; ?>
    </ol>
    <h2>Сумма заказа: <b><?= $result_sum->fetch()['total'] ?></b></h2>
<?php }
else echo '<h2>Заказы отсутствуют</h2>'
?>
