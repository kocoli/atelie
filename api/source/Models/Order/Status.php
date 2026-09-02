<?php

namespace Source\Models\Order;

use Source\Core\Model;

class Status extends Model{

    private ?int $id;
    private ?string $status;
    private ?int $active;

    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?string $status = null
    )
    {
        $this->id = $id;
        $this->status = $status;

        $this->table = 'order_status'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['status']; // camelCase
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getActive() : ?int {
        return $this->active;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setStatus(?string $status): void
{
    $this->status = $status;
}

    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
}
