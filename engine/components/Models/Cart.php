<?php
# исходя из названия понятно что файл отвечает за работу со Столом Закзаов 
class Cart
{
    public static function addProduct($id, $val_1 = false, $val_2 = false, $val_3 = false)
    {
        $products = array();

        # Если в карзине уже есть товары
        if(isset($_SESSION['products']))
        {
            # Тогда заполним массив товарами
            $productsInCart = $_SESSION['products'];
        }
        # если товар есть в карзине, но был добавлен ещё раз, тогда увеличиваем колл-во товаров
        if(array_key_exists($id, $productsInCart))
        {
            $productsInCart[$id] ++;
        } else {
            # Если такого товара ещё не было в карзине тогда присвоим ему значение 1
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;
        $_SESSION['val_1']    = $val_1;
        $_SESSION['val_2']    = $val_2;
        $_SESSION['val_3']    = $val_3;

        return self::countItems();
    }
    
    public static function getProducts()
    {
        if(isset($_SESSION['products']))
        {
            return $_SESSION['products'];
        } 
        
        return false;
    }
    
    public static function generate_random($length)
    {
        $characters = '0123456789987654321';
        $charactersLength = strlen($characters);
        
        $randomString = '';
        
        for($i = 0; $i < $length; $i++):
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        endfor;
        
        return $randomString;
    }
    
    public static function clear()
    {
        if(isset($_SESSION['products']))
        {
            unset($_SESSION['products']);
        }
    }

    public static function getTotalPrice($products)
    {
        $productInCart = self::getProducts();

        if($productInCart)
        {
            $total = 0;

            foreach($products as $item):
                $total += $item['price'] * $productInCart[$item['id']];
            endforeach;
        }

        return $total;
    }

    public static function deleteItem($id)
    {
        unset($_SESSION['products'][$id]);
        Redirect::to('/cart');
    }

    public static function countItems()
    {
        if(isset($_SESSION['products']))
        {
            $count = 0;

            foreach($_SESSION['products'] as $id => $quentity):
                $count = $count + $quentity;
            endforeach;

            return $count;
        } else {
            return 0;
        }
    }
}
