<?php

class Cart
{
    private $items = [];

    public function addItem($id, $name, $type, $price, $quantity = 1)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = [
                'id'       => $id,
                'name'     => $name,
                'type'     => $type, // new, used, or equipment
                'price'    => $price,
                'quantity' => $quantity
            ];
        }
    }

    public function removeItem($id)
    {
        unset($this->items[$id]);
    }

    public function updateItem($id, $quantity)
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function clearCart()
    {
        $this->items = [];
    }
}
