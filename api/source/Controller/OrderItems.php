<?php

namespace Source\Controller;

use Source\Models\Order\Order;
use Source\Models\Order\OrderItem;
use Source\Models\Order\Customer;
use Source\Models\Product\Product;

class OrderItems extends Api {

    public function selectAll(array $data) : void {

        $item = new OrderItem();

        $this->call(200, "success", "Lista de Itens da Encomenda", "success")->back($item->selectAll());
    }

    public function selectById(array $data) : void {

        if (!isset($data['orderItem_id']) || empty($data['orderItem_id']) || !filter_var($data['orderItem_id'], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do item da encomenda é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $item = new OrderItem();

        if (!$item->selectById($data['orderItem_id'])) {
            
            $this->call(
                404, 
                "not_found", 
                "Item não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $product = new Product();
        $product->selectById($item->getId());

        $response = [
            "id" => $item->getId(),
            "order_id" => $item->getOrderId(),
            "product" => $product->getName(),
            "quatity" => $item->getQuantity()
        ];

        $this->call(200, "success", "Encomenda encontrada", "success")->back($response);

    }

    public function create(array $data) : void {
    
        // var_dump($data);
        // die();

        if(
            !isset($data['order_id'], $data['product_id'], $data['quantity']) ||
            empty($data['order_id']) || empty($data['product_id']) ||
            !filter_var($data['order_id'], FILTER_VALIDATE_INT) ||
            !filter_var($data['product_id'], FILTER_VALIDATE_INT) ||
            !filter_var($data['quantity'], FILTER_VALIDATE_INT) 
        ){           
            $this->call(
                400,
                "bad_request",
                "Todos os campos são obrigatórios e devem se inteiros",
                "error"
            )->back();
            return;
        }

        $item = new OrderItem(
            null,
            $data['order_id'],
            $data['product_id'],
            $data['quantity']
        );

        if (!$item->insert()) {
            $this->call(500, "internal_server_error", $item->getErrorMessage(), "error")->back();
            return;
        }

        $product = new Product();
        $product->selectById($item->getProductId());

        $response = [
            "id" => $item->getId(),
            "order_id" => $item->getOrderId(),
            "Produto" => $product->getName(),
            "quantity" => $item->getQuantity()
        ];

        $this->call(201, "created", "Encomenda cadastrada com sucesso", "success")->back($response);
    }

    public function update(array $data) : void {
        if(
            !isset($data['order_id'], $data['product_id'], $data['quantity']) ||
            empty($data['order_id']) || empty($data['product_id']) ||
            !filter_var($data['order_id'], FILTER_VALIDATE_INT) ||
            !filter_var($data['product_id'], FILTER_VALIDATE_INT) ||
            !filter_var($data['quantity'], FILTER_VALIDATE_INT) 
        ){           
            $this->call(
                400,
                "bad_request",
                "Todos os campos são obrigatórios e devem se inteiros",
                "error"
            )->back();
            return;
        }

        $item = new OrderItem(
            $data['orderItem_id'],
            $data['order_id'],
            $data['product_id'],
            $data['quantity']
        );

        if (!$item->updateById($data['orderItem_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $item->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $product = new Product();
        $product->selectById($item->getProductId());

        $response = [
            "id" => $item->getId(),
            "order_id" => $item->getOrderId(),
            "Produto" => $product->getName(),
            "quantity" => $item->getQuantity()
        ];

        $this->call(200, "success", "Item do pedido atualizado com sucesso", "success")->back($response);
    }

    public function inactive(array $data) : void {

        if (!isset($data["orderItem_id"]) || empty($data["orderItem_id"]) || !filter_var($data["orderItem_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do item do pedido é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $item = new OrderItem();

        if (!$item->softDeleteById($data["orderItem_id"])) {
            
            $this->call(500, "internal_server_error",  $item->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Item da Encomenda inativado com sucesso","success")->back();
    }

    public function delete(array $data) : void {
        
        if (!isset($data["orderItem_id"]) || empty($data["orderItem_id"]) || !filter_var($data["orderItem_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do item do pedido é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $item = new OrderItem();

        if (!$item->deleteById($data["orderItem_id"])) {
            
            $this->call(500,  "internal_server_error",  $item->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Item da Encomenda deletado com sucesso","success")->back();
    }

}