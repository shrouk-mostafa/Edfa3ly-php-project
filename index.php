<?php

require 'Cart.php';

$currency = 'USD';
$products = [];

foreach ($argv as $arg) {
    if (strpos($arg, '--bill-currency=') !== false) {
        $currency = strtoupper(str_replace('--bill-currency=', '', $arg));
    } elseif ($arg !== 'index.php') {
        $products[] = $arg;
    }
}

if (!empty($products)) {
    $cart = new Cart();
    foreach ($products as $product) {
        $cart->addProduct($product);
    }

    $cart->setCurrency($currency);
    $cart->calculateTotal();
    $cart->displayBill();
} else {
    echo "Please provide products and a bill currency.\n";
}
