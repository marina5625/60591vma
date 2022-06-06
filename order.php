<?php
require('dbconnect.php');
require('auth.php');
require('components/header.php');
if ($_SESSION['username']) {
    //Получение текущего заказа
    $result = $conn->query("SELECT *  FROM orders WHERE status=0 and id_user=" . $_SESSION['id_auth_user']);
    //Если заказа не найдено
    if (!$row = $result->fetch()) {
        //Если был запрос на добавление товара в заказ то создание нового заказа
        if ($_POST['id']) {
            $result = $conn->query("INSERT INTO orders(id_user,status,created_at)
                    VALUES ('" . $_SESSION['id_auth_user'] . "','0','" . date('Y-m-d H:i:s', time()) . "')");
            $id_order = $conn->lastInsertId();
        }
    }
    //Если заказ не найден
    else
    {
        $id_order = $row['id'];
    }
    //Добавление товара к заказу если был запрос на добавление
    if ($_POST['id']) {
        $result = $conn->query("INSERT INTO order_product(id_product,id_order,quantity,price,color)
                    VALUES ('" . $_POST['id'] . "','" . $id_order . "'," . $_POST['quantity'] . ",'" . $_POST['price'] . "','" . $_POST['color'] . "')");
    }
    //Если был запрос на удаление товара из заказа
    if ($_POST['delid']) {
        $result = $conn->query("DELETE FROM order_product WHERE id = ".$_POST['delid']);
        //Если удалился последний товар из заказа то удалить заказ тоже
        $result = $conn->query("SELECT count(*) AS total FROM order_product OP WHERE OP.id_order=".$id_order);
        if ($result->fetch()['total'] == 0) {
            $result = $conn->query("DELETE FROM orders WHERE id = ".$id_order);
            $id_order = null;
        }
    }
    //Получение всех товаров заказа если заказ существует
    if ($id_order)
    {
        $result = $conn->query("SELECT *  FROM products P,order_product OP WHERE P.id = OP.id_product and OP.id_order=".$id_order);
        $result_sum = $conn->query("SELECT sum(OP.price * op.quantity) AS total FROM products P,order_product OP WHERE P.id = OP.id_product and OP.id_order=".$id_order);
    }

    require('components/order.php');
}
else{
    $_SESSION['message'] = 'Для оформления заказа войдите в систему';
    header("Location: login.php");
    die();
}
require ('components/message.php');
require('components/footer.php');