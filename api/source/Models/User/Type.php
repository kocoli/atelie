<?php

namespace source\Models\User;

use Source\Core\Model;
use Source\Core\Connect;
use Source\Core\JWTToken;

class Type extends Model{

    private ?int $id;
    private ?string $name;
    private ?string $active;

    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?string $name = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        
        $this->table = 'users_types'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['name'];
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    // Setters
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setActive(int $active) : void {
        $this->active = $active;
    }

    public function show() : string {
        return "
            <div>
                <h1>Tipos de Usuários</h1>
                <p>ID: {$this->id}</p>
                <p>Nome: {$this->name}</p>
            </div>
        ";       
    }
}
