<?php

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testCartWithDiscountsAndTax()
    {
        $cart = new Cart();
        $cart->addProduct('T-shirt');
        $cart->addProduct('T-shirt');
        $cart->addProduct('Shoes');
        $cart->addProduct('Jacket');
        $cart->setCurrency('USD');
        $cart->calculateTotal();

        $expectedOutput = "Subtotal: 66.96 $\nTaxes: 9.37 $\nDiscounts: -12.49 $\nTotal: 63.84 $\n";
        $this->expectOutputString($expectedOutput);
        $cart->displayBill();
    }

    public function testCartWithoutDiscountsInEGP()
    {
        $cart = new Cart();
        $cart->addProduct('T-shirt');
        $cart->addProduct('Pants');
        $cart->setCurrency('EGP');
        $cart->calculateTotal();

        $expectedOutput = "Subtotal: 409.35 e£\nTaxes: 57.31 e£\nTotal: 467.4 e£\n";
        $this->expectOutputString($expectedOutput);
        $cart->displayBill();
    }
}
