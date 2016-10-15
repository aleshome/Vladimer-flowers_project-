<?php
class CartController
{
    public function actionIndex()
    {
        # Тут показывается сама карзина покупателя только сделать проверку на empty(Session::get('products'))
        # Получаем данные из карзины
        $productsInCart = Cart::getProducts();
        if(empty($productsInCart)) {
            Redirect::to('/');
        }

        if($productsInCart)
        {
            # получаем всю информацию об товарах из списка сессии
            $productsIds = array_keys($productsInCart);
            # Получаем инфу о каждом продукте по ID полученному ранее
            $products = Products::prodItemById($productsIds);

            # Теперь считаем что у нас получилось
            $totalPrice = Cart::getTotalPrice($products);
        }
        include_once SKIN.'/cart/home/index.php';

        return true;
    }

    public function actionCheckout()
    {
        $productsInCart = Cart::getProducts();
        # получаем всю информацию об товарах из списка сессии
        $productsIds = array_keys($productsInCart);
        # Получаем инфу о каждом продукте по ID полученному ранее
        $products = Products::prodItemById($productsIds);

        # Теперь считаем что у нас получилось
        $totalPrice = Cart::getTotalPrice($products);

        $random = Cart::generate_random(9);

        $timeIsNow = date("D Y");

        include_once SKIN.'/cart/checkout/index.php';
        
        return true;
    }

    public function actionOrderNow()
    {
        # Если чел не авторизован или да всё равно берём из _POST Только либо из сессии внутри формы или так просто
        $userName = Security::escape($_POST['userName']);
        $userPhone = $_POST['userPhone'];
        $userComment = $_POST['userComment'];
        $productList = json_encode($_SESSION['products']);
        $tovarniyCheckNumber = $_POST['tovarniyCheckNumber'];
            # идёт запрос на сохранение инфы в базе данных и очистке корзины покупателя
        $productQuantity = Cart::countItems(); # Всего товаров было куплено за этот товарный чек
        $dateSell = $_POST['dateSell'];
        $nameHoTake = $_POST['nameHoTake'];
        $phoneHoTake = $_POST['phoneHoTake'];
        $datetime_deliver = $_POST['datetime_deliver'];
        $address_deliver  = $_POST['address_deliver'];
        $user_id = $_SESSION['user_id'];
        $date_order = date('Y-m-d');
        $payment_method = $_POST['payment_method'];

        if(!empty($user_id)) {
            $productsInCart = Cart::getProducts();
            # получаем всю информацию об товарах из списка сессии
            $productsIds = array_keys($productsInCart);
            # Получаем инфу о каждом продукте по ID полученному ранее
            $products = Products::prodItemById($productsIds);

            # Теперь считаем что у нас получилось
            $totalPrice = Cart::getTotalPrice($products);

            # если пользователь который покупает товар уже авторизован то тогда заносим информацию в таблицу с персональной историей покупок
            DataBase::insertFromTable('tbl_user_order', array(
                'order_number' => $tovarniyCheckNumber,
                'product_list' => $productList,
                'date_order' => $dateSell,
                'order_price' => $totalPrice,
                'user_id' => $user_id
            ));
        }
        # Когла заказ оформлен и скинут в Базу данных нужно сформировать сообщение в Телеграм через бота
        DataBase::insertFromTable('tbl_order', array(
            'userName' => $userName,
            'userPhone' => $userPhone,
            'userComment' => $userComment,
            'orderList' => $productList,
            'oder_qty' => $productQuantity,
            'check_tovarniy' => $tovarniyCheckNumber,
            'dateSellMoment' => $dateSell,
            'nameHoTake' => $nameHoTake,
            'phoneHoTake' => $phoneHoTake,
            'datetime_deliver' => $datetime_deliver,
            'address_deliver' => $address_deliver,
            'user_id' => $user_id,
            'date_order' => $date_order,
            'user_have_1' => Session::get('val_1'),
            'user_have_2' => Session::get('val_2'),
            'user_have_3' => Session::get('val_3'),
            'payment_method' => $payment_method,
        ));

        # это такой момент для dashboard админа что вот по такому то чеку общее колличество товаров oder_qty
        # Так же админу и в админку должно  приходить уведомление я щас про почту или телеграм что чел у тебя заказ такой то на сайте новый
        # Это тот момент что если чел зарегестрирован тогда ерём его из сессии и пихаем сюда в базу а и да если авторизован тогда добавляем поле Адрес доставки

        Cart::clear(); # Очистка карзины
        Redirect::to('/contacts'); # человека перебрасывает на главную страницу (так то бы ещё сделать какой нить статус который бы проверялся на главной что чел ты заказал всё ок Созвон)

    }

    public function actionUpdateOrder()
    {
        foreach ($_SESSION['products'] as $id => $qty) {
            $_SESSION['products'][$id] = $_POST[$id];
        }

        #echo '<pre>',print_r($_SESSION['products'],1),'</pre>';
        Redirect::to('/cart');

        return true;
    }
    
    public function actionDelete($id)
    {
        $id = intval($id);

        Cart::deleteItem($id);

        return true;
    }

    public function actionAdd($id = false )
    {
        # Тут всё просто идёт добавление товара в карзину из каталога продукции
        $id = intval($id);
        $val_1 = $_POST['val_1'];
        $val_2 = $_POST['val_2'];
        $val_3 = $_POST['val_3'];
        
        Cart::addProduct($id, $val_1, $val_2, $val_3);
        # Возвращаем клиента туда откдуа он пришёл потому что я этого не знаю где он был
        $referer = $_SERVER['HTTP_REFERER'];
        Redirect::to('/');
        
        return true;
    }

    public function actionAddSuperBuket()
    {
        $data = array();

        $data['roses_count'] = $_POST['roses_count'];
        $data['dlinna_roses'] = $_POST['dlinna_roses'];
        $data['color_roses'] = $_POST['color_roses'];

        $data['xrizontemi_count'] = $_POST['xrizontemi_count'];
        $data['xrizontemi_type'] = $_POST['xrizontemi_type'];
        $data['xrizontemi_color'] = $_POST['xrizontemi_color'];

        $data['lilii_count'] = $_POST['lilii_count'];
        $data['lilii_color'] = $_POST['lilii_color'];

        $data['irisi_count'] = $_POST['irisi_count'];
        $data['irisi_color'] = $_POST['irisi_color'];

        $data['tulpani_count'] = $_POST['tulpani_count'];
        $data['tulpani_color'] = $_POST['tulpani_color'];

        $data['gerberi_count'] = $_POST['gerberi_count'];
        $data['gerberi_color'] = $_POST['gerberi_color'];

        $data['kolkalli_count'] = $_POST['kolkalli_count'];
        $data['kolkalli_color'] = $_POST['kolkalli_color'];

        $data['orxidei_count'] = $_POST['orxidei_count'];
        $data['orxidei_color'] = $_POST['orxidei_color'];
        # Блок оформление и  формирование заказа
        $data['design_oformlenie'] = $_POST['design_oformlenie'];
        $data['oformlenie_prazdnichnoy_lentoy'] = $_POST['oformlenie_prazdnichnoy_lentoy'];
        $data['besplatno_perevizat_lentoy'] = $_POST['besplatno_perevizat_lentoy'];
        $data['oformit_buket_is_hard'] = $_POST['oformit_buket_is_hard'];
        $data['dostavka_client'] = $_POST['dostavka_client'];
        $data['dostavka_client_savomivoz'] = $_POST['dostavka_client_savomivoz'];

        echo '<pre>',print_r($data,1),'</pre>';

        if(empty($data['roses_count'])) {
            echo 'Не заказаны розы<br/>';
        } else {
            $data['roses_count'];
            $data['dlinna_roses'];
            $data['color_roses'];
        }

        if(empty($data['xrizontemi_count'])) {
            echo 'No order from Hrizontemi<br/>';
        } else {
            $data['xrizontemi_count'];
            $data['xrizontemi_type'];
            $data['xrizontemi_color'];
        }

        if(empty($data['lilii_count'])) {
            echo 'No order from Lilii<br/>';
        } else {
            $data['lilii_count'];
            $data['lilii_color'];
        }

        if(empty($data['irisi_count'])) {
            echo 'No order from Irisi<br/>';
        } else {
            $data['irisi_count'];
            $data['irisi_color'];
        }

        if(empty($data['tulpani_count'])) {
            echo 'No order from Tulpani<br/>';
        } else {
            $data['tulpani_count'];
            $data['tulpani_color'];
        }

        if(empty($data['gerberi_count'])) {
            echo 'No order from Gerberi<br/>';
        } else {
            $data['gerberi_count'];
            $data['gerberi_color'];
        }

        if(empty($data['kolkalli_count'])) {
            echo 'No order from Koalli<br/>';
        } else {
            $data['kolkalli_count'];
            $data['kolkalli_color'];
        }

        if(empty($data['orxidei_count'])) {
            echo 'No order from Orxidei<br/>';
        } else {
            $data['orxidei_count'];
            $data['orxidei_color'];
        }

        if(empty($data['design_oformlenie'])) {
            echo 'Не выбрано подарочное оформление<br/>';
        } else {
            $data['design_oformlenie'];
        }

        if(empty($data['oformlenie_prazdnichnoy_lentoy'])) {
            echo 'Не выбрано оформление правздничной лентой )<br/>';
        } else {
            $data['oformlenie_prazdnichnoy_lentoy'];
        }

        if(empty($data['besplatno_perevizat_lentoy'])) {
            echo 'Не выбрано оформление бесплатной лентой)<br/>';
        } else {
            $data['besplatno_perevizat_lentoy'];
        }

        if(empty($data['oformit_buket_is_hard'])) {
            echo 'Не выбрано оформление сердцем толи из роз толи как )<br/>';
        } else {
            $data['oformit_buket_is_hard'];
        }

        if(empty($data['dostavka_client'])) {
            echo 'Не выбран вариант доставки до клиента)<br/>';
        } else {
            $data['dostavka_client'];
        }

        if(empty($data['dostavka_client_savomivoz'])) {
            echo 'Не выбрано доставка методом самовывоза )<br/>';
        } else {
            $data['dostavka_client_savomivoz'];
        }

        return true;
    }

    public function actionAddResponse($id)
    {
        # То же самое что и сверху только с использованием Ajax на стороне клиента
        $id = intval($id);
        Cart::addProduct($id);
        Redirect::to($_SERVER['HTTP_REFERER']);
        return true;
    }
}
