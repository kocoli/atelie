<?php

namespace Source\Models\Faq;

use Source\Core\Model;

class Type extends Model
{
    private ?int $id;
    private ?string $description;
    private ?int $active;

    private ?string $token = null;

    public function __construct(
        ?int $id = null, 
        ?string $descripition = null
    )
    {
        $this->id = $id;
        $this->description = $descripition;

        $this->table = 'faq_types'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['description']; // camelCase
    }

    public function getId() : ?int {
        return $this->id;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function getActive() : ?int {
        return $this->active;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function setDescription(string $descripition) : void {
        $this->description = $descripition;
    }

    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function show() : ?string {
        return "Categoria: {$this->id} - Nome: {$this->description} <br>";
    }
}