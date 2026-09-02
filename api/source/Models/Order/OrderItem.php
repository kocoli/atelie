<?php

namespace Source\Models\Order;

use Source\Core\Model;

class OrderItem extends Model{

    private ?int $id;
    private ?int $orderId;
    private ?int $productId;
    private ?int $quantity;
    private ?int $active;

    private ?string $token = null;

    // Construtor
    public function __construct(?int $id = null, ?int $orderId = null, ?int $productId = null, ?int $quantity = null) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;

        $this->table = 'order_items'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['orderId', 'productId', 'quantity']; // camelCase
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getOrderId(): ?int {
        return $this->orderId;
    }

    public function getProductId(): ?int {
        return $this->productId;
    }

    public function getQuantity(): ?int {
        return $this->quantity;
    }
    
    public function getActive() : ?int {
        return $this->active;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setOrderId(?int $orderId): void {
        $this->orderId = $orderId;
    }

    public function setProductId(?int $productId): void {
        $this->productId = $productId;
    }

    public function setQuantity(?int $quantity): void {
        $this->quantity = $quantity;
    }
    
    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
