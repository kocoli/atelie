<?php

namespace Source\Models\Product;

use Source\Core\Model;

class Product extends Model
{
    private ?int $id;
    private ?int $categoryId;
    private ?string $name;
    private ?float $price;
    private ?int $stock;
    private ?int $active;

    public function __construct
    (
        ?int $id = null,
        ?int $categoryId = null,
        ?string $name = null,
        ?float $price = null,
        ?int $stock = null
    )
    {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;

        $this->table = 'products';
        $this->primaryKey = 'id';
        $this->fillable = ['categoryId', 'name', 'price', 'stock'];
    }

    //-----------------------------------

    public function getId() : ?int {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getPrice() : ?float
    {
        return $this->price;
    }

    public function getStock() : ?int
    {
        return $this->stock;
    }
    
    public function getActive() : ?int {
        return $this->active;
    }

    //-----------------------------------

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function setCategoryId(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function setStock(?int $stock) : void
    {
        $this->stock = $stock;
    }

    public function setActive(?int $active) : void {
        $this->active = $active;
    }
    
    //-----------------------------------

    public function discount(float $percentualDesconto) : ?float
    {
        $priceFinal = $this->price * (1 - ($percentualDesconto/100));
        return $this->price = round($priceFinal, 2);
    }

    public function show() : void
    {
        $numFormatado = number_format($this->price, 2, ",", ".");

        echo "
            ====PRODUTO==== <br>
            Nome: {$this->name}<br>
            Categoria: {$this->categoryId}<br>
            Preço: R$ {$numFormatado} <br><br>
        ";
    }
}