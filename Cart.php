<?php

class Cart
{
    private $products = [];
    private $catalog = [
        'T-shirt' => 10.99,
        'Pants' => 14.99,
        'Jacket' => 19.99,
        'Shoes' => 24.99,
    ];
    private $currencyRates = [
        'USD' => 1,
        'EGP' => 15.00,  // Example conversion rate
        'EUR' => 0.85,   // Example conversion rate
    ];
    private $currency = 'USD';
    private $subtotal = 0;
    private $taxRate = 0.14;
    private $discounts = 0;
    private $total = 0;

    public function addProduct($product)
    {
        if (isset($this->catalog[$product])) {
            $this->products[] = $product;
        } else {
            echo "Product $product is not available in the catalog.\n";
        }
    }

    public function setCurrency($currency)
    {
        if (isset($this->currencyRates[$currency])) {
            $this->currency = $currency;
        } else {
            echo "Currency not supported. Using USD by default.\n";
        }
    }

    private function calculateSubtotal()
    {
        foreach ($this->products as $product) {
            $this->subtotal += $this->catalog[$product];
        }
    }

    private function applyDiscounts()
    {
        $tShirts = count(array_keys($this->products, 'T-shirt'));
        $jackets = count(array_keys($this->products, 'Jacket'));
        $shoes = count(array_keys($this->products, 'Shoes'));

        // Shoes 10% off
        if ($shoes > 0) {
            $this->discounts += $shoes * ($this->catalog['Shoes'] * 0.10);
        }

        // Buy two T-shirts, get a jacket half off
        if ($tShirts >= 2 && $jackets > 0) {
            $this->discounts += $this->catalog['Jacket'] * 0.50;
        }
    }

    public function calculateTotal()
    {
        $this->calculateSubtotal();
        $this->applyDiscounts();

        $tax = $this->subtotal * $this->taxRate;
        $this->total = ($this->subtotal + $tax - $this->discounts) * $this->currencyRates[$this->currency];
    }

    public function displayBill()
    {
        $tax = $this->subtotal * $this->taxRate * $this->currencyRates[$this->currency];
        $subtotalInCurrency = $this->subtotal * $this->currencyRates[$this->currency];
        $discountInCurrency = $this->discounts * $this->currencyRates[$this->currency];
        $currencySymbol = $this->currency === 'USD' ? '$' : 'e£';

        echo "Subtotal: $subtotalInCurrency $currencySymbol\n";
        echo "Taxes: $tax $currencySymbol\n";
        if ($this->discounts > 0) {
            echo "Discounts: -$discountInCurrency $currencySymbol\n";
        }
        echo "Total: $this->total $currencySymbol\n";
    }
}
