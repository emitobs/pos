<?php

namespace App\Services;

class CartService
{
    public function resetCart()
    {
        return [];
    }

    public function addProduct(array $cart, $product, int $quantity, string $detail): array
    {
        $this->validateProduct($product);

        foreach ($cart as $key => $item) {
            if ($item['product_id'] === $product->id && $item['detail'] === $detail) {
                return $this->updateQuantity($cart, $key, $item['quantity'] + $quantity);
            }
        }

        $cartItem = [
            'product_id' => $product->id,
            'product_barcode' => $product->barcode,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'unit' => $product->unitSale->unit,
            'quantity' => $quantity,
            'total' => $quantity * $product->price,
            'detail' => $detail
        ];

        array_push($cart, $cartItem);

        return $cart;
    }

    public function updateQuantity(array $cart, int $productPosition, int $quantity): array
    {
        if (isset($cart[$productPosition])) {
            $cart[$productPosition]['quantity'] = $quantity;
            $cart[$productPosition]['total'] = $quantity * $cart[$productPosition]['product_price'];
        } else {
            throw new \OutOfBoundsException('Invalid product position.');
        }
        return $cart;
    }

    // public function decreaseQty($cart, $productPosition, $quantity)
    // {
    //     if ($cart[$productPosition]['unit'] == 'Kg') {
    //         unset($cart[$productPosition]);
    //     } else {
    //         if ($cart[$productPosition]['quantity'] - $quantity > 0) {
    //             $cart = $this->updateQuantity($cart, $productPosition, $cart[$productPosition]['quantity'] - $quantity);
    //         } else {
    //             unset($cart[$productPosition]);
    //         }
    //     }

    //     return $cart;
    // }

    public function getTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['total'];
        }

        return $total;
    }

    public function getItemsQuantity($cart)
    {
        $totalItems = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        return $totalItems;
    }
    private function validateProduct($product)
    {
        if (!is_object($product) || !isset($product->id, $product->barcode, $product->name, $product->price, $product->unitSale)) {
            throw new \InvalidArgumentException('Invalid product data.');
        }
    }

    public function increaseQty(array $cart, int $position, $product, int $quantity)
    {
        if ($cart[$position]['product_id'] === $product) {
            $cart = $this->updateQuantity($cart, $position, $quantity);
        }
        return $cart;
    }

    public function decreaseQty(array $cart, int $position, $product ,int $quantity): array
    {
        if (!isset($cart[$position])) {
            throw new \OutOfBoundsException('Invalid product position.');
        }

        if ($cart[$position]['product_id'] === $product) {
            $cart = $this->updateQuantity($cart, $position, $quantity);
        }
        return $cart;
    }
}
