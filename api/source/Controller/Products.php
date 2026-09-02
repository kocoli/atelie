<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Product\Product;
use Source\Models\Product\Category;

class Products extends Api{

    public function selectAll(array $data) : void {

        $product = new Product();

        $this->call(200, "success", "Lista de produtos", "success")->back($product->selectAll());
    }

    public function selectById(array $data) : void {
        
        if (!isset($data["product_id"]) || empty($data["product_id"]) || !filter_var($data["product_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do produto é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $product = new Product();

        if (!$product->selectById($data["product_id"])) {
            
            $this->call(
                404, 
                "not_found", 
                "Produto não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $category = new Category();

        $category->selectById($product->getCategoryId());

        $response = [
            "id" => $product->getId(),
            "Category" => $category->getName(),
            "Produto" => $product->getName(),
            "Preço" => $product->getPrice(),
            "Estoque" => $product->getStock()
        ];

        $this->call(200, "success", "Produto encontrado", "success")->back($response);

    }

    public function create(array $data) : void {    
    
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!$this->validate($data)){
            
            $this->call(
                400,
                "bad_request",
                "Os campos category_id, name, price e stock são obrigatórios",
                "error"
            )->back();
            return;
        }

        $product = new Product(
            null,
            $data["category_id"],
            $data["name"],
            $data["price"],
            $data["stock"]
        );

        $category = new Category();

        $category->selectById($product->getCategoryId());

        if (!$product->insert()) {
            $this->call(500, "internal_server_error", $product->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "category_name" => $category->getName(),
            "stock" => $product->getStock()
        ];

        $this->call(201, "created", "Produto criado com sucesso", "success")->back($response);
    }

    public function update(array $data) : void {

        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!$this->validate($data)){
            
            $this->call(
                400,
                "bad_request",
                "Os campos category_id, name, price e stock são obrigatórios",
                "error"
            )->back();
            return;
        }

        $product = new Product(
            $data['product_id'],
            $data['category_id'],
            $data['name'],
            $data['price'],
            $data['stock']
        );

        $category = new Category();

        $category->selectById($product->getCategoryId());

        if (!$product->updateById($data['product_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $product->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "category_name" => $category->getName(),
            "stock" => $product->getStock()
        ];

        $this->call(200, "success", "Produto atualizado com sucesso", "success")->back($response);
    }

    public function inactive(array $data) : void {

        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["product_id"]) || empty($data["product_id"]) || !filter_var($data["product_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do produto é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $product = new Product();

        if (!$product->softDeleteById($data["product_id"])) {
            
            $this->call(500,  "internal_server_error",  $product->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Produto inativado com sucesso","success")->back();
    }

    public function delete(array $data) : void {
        
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["product_id"]) || empty($data["product_id"]) || !filter_var($data["product_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do produto é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $product = new Product();

        if (!$product->deleteById($data["product_id"])) {
            
            $this->call(500,  "internal_server_error",  $product->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Produto deletado com sucesso","success")->back();
    }

    public function validate (array $data): bool
    {
        if(!isset($data["category_id"]) || !isset($data["name"]) || !isset($data["price"]) || !isset($data["stock"]) ||
            empty($data["category_id"]) || empty($data["name"]) || empty($data["price"]) || empty($data["stock"]) ||
           !filter_var($data["category_id"], FILTER_VALIDATE_INT) || 
           !filter_var($data["stock"], FILTER_VALIDATE_INT) || 
           !filter_var($data["price"], FILTER_VALIDATE_FLOAT)
        ) {
            return false;
        }
        return true;
    }
}