<?php

namespace Source\Models\Order;

use Source\Core\Model;

class Order extends Model{
    private ?int $id;
    private ?int $customerId;
    private ?int $statusId;
    private ?int $active;

    private ?string $token = null;

    // Construtor
    public function __construct(?int $id = null, ?int $customerId = null, ?int $statusId = null) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->statusId = $statusId;

        $this->table = 'orders'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['customerId', 'statusId']; // camelCase
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getCustomerId(): ?int {
        return $this->customerId;
    }

    public function getStatusId(): ?int {
        return $this->statusId;
    }

    public function getActive() : ?int {
        return $this->active;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setCustomerId(?int $customerId): void {
        $this->customerId = $customerId;
    }

    public function setStatusId(?int $statusId): void {
        $this->statusId = $statusId;
    }

    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}