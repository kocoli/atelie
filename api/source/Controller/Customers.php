<?php

namespace Source\Controller;

use Source\Models\Order\Customer;

class Customers extends Api {

    public function selectAll(array $data) : void {

        if(!$this->authToken (1) && !$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $customer = new Customer();

        $this->call(200, "success", "Lista de clientes", "success")->back($customer->selectAll());
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
        
        if (!isset($data["customer_id"]) || empty($data["customer_id"]) || !filter_var($data["customer_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do cliente é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $customer = new Customer();

        if (!$customer->selectById($data["customer_id"])) {
            
            $this->call(
                404, 
                "not_found", 
                "Cliente não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $customer->getId(),
            "name" => $customer->getName(),
            "phone" => $customer->getPhone(),
            "address" => $customer->getAddress()
        ];

        $this->call(200, "success", "Cliente encontrado", "success")->back($response);

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
            !isset($data['name']) || empty($data['name']) || 
            !isset($data['phone']) || empty($data['phone']) ||
            !isset($data['address']) || empty($data['address'])
        ){
            
            $this->call(
                400,
                "bad_request",
                "Os campos name, phone e address são obrigatórios",
                "error"
            )->back();
            return;
        }

        $customer = new Customer(
            null,
            $data['name'],
            $data['phone'],
            $data['address']
        );

        if (!$customer->insert()) {
            $this->call(500, "internal_server_error", $customer->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $customer->getId(),
            "name" => $customer->getName(),
            "phone" => $customer->getPhone(),
            "address" => $customer->getAddress()
        ];

        $this->call(201, "created", "Cliente cadastrado com sucesso", "success")->back($response);
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
            !isset($data['name']) || empty($data['name']) || 
            !isset($data['phone']) || empty($data['phone']) ||
            !isset($data['address']) || empty($data['address'])
        ){
            
            $this->call(
                400,
                "bad_request",
                "Os campos name, phone e address são obrigatórios",
                "error"
            )->back();
            return;
        }

        $customer = new Customer(
            $data['customer_id'],
            $data['name'],
            $data['phone'],
            $data['address']
        );

        if (!$customer->updateById($data['customer_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $customer->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $customer->getId(),
            "name" => $customer->getName(),
            "phone" => $customer->getPhone(),
            "address" => $customer->getAddress()
        ];


        $this->call(200, "success", "Cliente atualizado com sucesso", "success")->back($response);
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

        if (!isset($data["customer_id"]) || empty($data["customer_id"]) || !filter_var($data["customer_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do cliente é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $customer = new Customer();

        if (!$customer->softDeleteById($data["customer_id"])) {
            
            $this->call(500,  "internal_server_error",  $customer->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Cliente inativado com sucesso","success")->back();
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

        if (!isset($data["customer_id"]) || empty($data["customer_id"]) || !filter_var($data["customer_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do cliente é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $customer = new Customer();

        if (!$customer->deleteById($data["customer_id"])) {
            
            $this->call(500,  "internal_server_error",  $customer->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Cliente deletado com sucesso","success")->back();
    }
}