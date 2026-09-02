<?php

namespace Source\Controller;

use Source\Models\Faq\Type;

class FaqTypes extends Api{

    public function selectAll(array $data) : void {

        $type = new Type();

        $this->call(200, "success", "Lista de categorias das FAQs", "success")->back($type->selectAll());
    }

    public function selectById(array $data) : void {
        
        if (!isset($data["type_id"]) || empty($data["type_id"]) || !filter_var($data["type_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do tipo da FAQ é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $type = new Type();

        if (!$type->selectById($data["type_id"])) {
            
            $this->call(
                404, 
                "not_found", 
                "Tipo da FAQ não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getDescription()
        ];

        $this->call(200, "success", "Tipo da FAQ encontrado", "success")->back($response);

    }

    public function create(array $data) : void {    
    
        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!isset($data['description'])){
            
            $this->call(
                400,
                "bad_request",
                "Nome do tipo (categoria) obrigatório",
                "error"
            )->back();
            return;
        }

        $type = new Type(
            null,
            $data['description']
        );

        if (!$type->insert()) {
            $this->call(500, "internal_server_error", $type->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getDescription()
        ];

        $this->call(201, "created", "Categoria da FAQ criada com sucesso", "success")->back($response);
    }

    public function update(array $data) : void {

        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!isset($data['description'])){
            
            $this->call(
                400,
                "bad_request",
                "Nome do tipo (categoria) obrigatório",
                "error"
            )->back();
            return;
        }

        $type = new Type(
            $data['type_id'],
            $data['description']
        );

        if (!$type->updateById($data['type_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $type->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getDescription()
        ];

        $this->call(200, "success", "Categoria da FAQ atualizada com sucesso", "success")->back($response);
    }

    public function inactive(array $data) : void {

        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["type_id"]) || empty($data["type_id"]) || !filter_var($data["type_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do tipo da FAQ é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $type = new Type();

        if (!$type->softDeleteById($data["type_id"])) {
            
            $this->call(500,  "internal_server_error",  $type->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Categoria inativada com sucesso","success")->back();
    }

    public function delete(array $data) : void {
        
        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data["type_id"]) || empty($data["type_id"]) || !filter_var($data["type_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do tipo da FAQ é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $type = new Type();

        if (!$type->deleteById($data["type_id"])) {
            
            $this->call(500,  "internal_server_error",  $type->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Categoria deletada com sucesso","success")->back();
    }
}