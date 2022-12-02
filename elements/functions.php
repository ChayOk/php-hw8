<?php

function getProducts()
{
    $ch = curl_init();
    $options = [
        CURLOPT_URL => "https://fakestoreapi.com/products",
        CURLOPT_RETURNTRANSFER => true
    ];

    curl_setopt_array($ch, $options);

    $result = curl_exec($ch);
    $errors = curl_errno($ch);

    if ($errors) {
        echo 'Errors (' . $errors . ') ' . curl_error($ch);
    } else{
        return json_decode($result, true);
    }
}

function showProducts()
{
    $data = getProducts();
    $html = '';

    foreach($data as $product){
        if (strlen($product['title']) > 66) {
            $productTitle  = mb_substr($product['title'], 0, 66);
        }else{
            $productTitle = $product['title'];
        }

        $html .= '
        <div class="product">
            <img src="'. $product['image'] .'" alt="'. $product['title'] .'">
            <div class="product_info">
                <p class="product_category">'. $product['category'] .'</p>
                <h3 class="product_title">'. $productTitle .'</h3>
                <p class="product_price">$'. $product['price'] .'</p>
                <a class="product_but" href="/?id='. $product['id'] .'&title='. $productTitle .'&price='. $product['price'] .'">Добавить в корзину</a>
            </div>
        </div>
        ';
    }

    if (!empty($html)) {
        echo '<div class="product_list">'. $html .'</div>';
    }
}

function addCart()
{
    if ($_GET['id']) {
        // $id    = setcookie('id', $_GET['id'],       time()+1800);
        // $title = setcookie('title', $_GET['title'], time()+1800);
        // $price = setcookie('price', $_GET['price'], time()+1800);
        $n = count($_COOKIE) + 1;
        $cook_val = array('id' => $_GET['id'], 'title' => $_GET['title'], 'price' => $_GET['price']);
    
        $cook = setcookie('product' . $n, serialize($cook_val),time()+1800);

        if ($_COOKIE) {
            for ($i = 1; $i <= $n; $i++) { 
                // $prod = 'product' . $i;
                $get_cook = unserialize($_COOKIE['product'.$i]);
                // echo $get_cook['title'] . ' ' . $get_cook['price'] . '<br>';
            }
        } 
    }

    $html = '';
    $html .= '            
            <img src="../img/cart-icon.svg" alt="" srcset="">
            <div class="cart_count">
                <span>'. $n .'</span>
            </div>
        ';

    if ($cook) {
        echo '<a href="/cart/" class="cart">'. $html .'</a>';
    }
}