<?php

namespace source\Models\Product;

use Source\Core\Model;

class Category extends Model{
    private ?int $id;
    private ?string $name;
    private ?int $active;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
    )
    {
        $this->id = $id;
        $this->name = $name;

        $this->table = 'categories';
        $this->primaryKey = 'id';
        $this->fillable = ['name'];

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

    public function setActive(?int $active) : void {
        $this->active = $active;
    }
}
