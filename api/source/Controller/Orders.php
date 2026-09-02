<?php

namespace Source\Controller;

use Source\Models\Order\Order;
use Source\Models\Order\Customer;
use Source\Models\Order\Status;

class Orders extends Api {

    public function selectAll(array $data) : void {

        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $orders = new Order();

        $this->call(200, "success", "Lista de encomendas", "success")->back($orders->selectAll());
    }

    public function selectById(array $data) : void {
        
        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data['order_id']) || empty($data['order_id']) || !filter_var($data['order_id'], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da encomenda é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $orders = new Order();

        if (!$orders->selectById($data['order_id'])) {
            
            $this->call(
                404, 
                "not_found", 
                "Encomenda não encontrada", 
                "error"
            )->back(null);
            return;
        }

        $customer = new Customer();
        $customer->selectById($orders->getCustomerId());

        $status = new Status();
        $status->selectById($orders->getStatusId());

        $response = [
            "id" => $orders->getId(),
            "Cliente" => $customer->getName(),
            "Status" => $status->getStatus()
        ];

        $this->call(200, "success", "Encomenda encontrada", "success")->back($response);

    }

    public function create(array $data) : void {
        
        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(
            !isset($data['customer_id']) || empty($data['customer_id']) || 
            !isset($data['status_id']) || empty($data['status_id']) 
        ){
            
            $this->call(
                400,
                "bad_request",
                "Os campos customer_id e status_id são obrigatórios",
                "error"
            )->back();
            return;
        }

        $orders = new Order(
            null,
            $data['customer_id'],
            $data['status_id']
        );

        if (!$orders->insert()) {
            $this->call(500, "internal_server_error", $orders->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $orders->getId(),
            "customer_id" => $orders->getCustomerId(),
            "Status_id" => $orders->getStatusId()
        ];

        $this->call(201, "created", "Encomenda cadastrada com sucesso", "success")->back($response);
    }

    public function update(array $data) : void {

        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(
            !isset($data['customer_id']) || empty($data['customer_id']) || 
            !isset($data['status_id']) || empty($data['status_id']) 
        ){
            
            $this->call(
                400,
                "bad_request",
                "Os campos customer_id e status_id são obrigatórios",
                "error"
            )->back();
            return;
        }

        $orders = new Order(
            $data['order_id'],
            $data['customer_id'],
            $data['status_id']
        );

        if (!$orders->updateById($data['order_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $orders->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $orders->getId(),
            "customer_id" => $orders->getCustomerId(),
            "Status_id" => $orders->getStatusId()
        ];


        $this->call(200, "success", "Encomenda atualizada com sucesso", "success")->back($response);
    }

    public function inactive(array $data) : void {

        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["order_id"]) || empty($data["order_id"]) || !filter_var($data["order_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da Encomenda é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $orders = new Order();

        if (!$orders->softDeleteById($data["order_id"])) {
            
            $this->call(500,  "internal_server_error",  $orders->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Encomenda inativada com sucesso","success")->back();
    }

    public function delete(array $data) : void {
        
        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["order_id"]) || empty($data["order_id"]) || !filter_var($data["order_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da Encomenda é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $orders = new Order();

        if (!$orders->deleteById($data["order_id"])) {
            
            $this->call(500,  "internal_server_error",  $orders->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Encomenda deletada com sucesso","success")->back();
    }

}