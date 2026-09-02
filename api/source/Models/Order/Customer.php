<?php

namespace Source\Models\Order;

use Source\Core\Model;

class Customer extends Model{
    private ?int $id;
    private ?string $name;
    private ?string $phone;
    private ?string $address;
    private ?int $active;

    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $phone = null,
        ?string $address = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;

        $this->table = 'customers'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['name', 'phone', 'address']; // camelCase
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getActive() : ?int {
        return $this->active;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }
    
    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
