<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Product\Category;

class Categories extends Api{

    public function selectAll(array $data) : void {
        $category = new Category();

        $this->call(200, "success", "Lista de categorias de produtos", "success")->back($category->selectAll());
    }

    public function selectById(array $data) : void {

        if (!isset($data['category_id']) || empty($data['category_id']) || !filter_var($data['category_id'], FILTER_VALIDATE_INT)) {
            $this->call(
                400, 
                "bad_request", 
                "ID da categoria é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $category = new Category();

        if (!$category->selectById($data['category_id'])) {

            $this->call(
                404, 
                "not_found", 
                "Categoria não encontrada", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $category->getId(),
            "name" => $category->getName()
        ];

        $this->call(200, "success", "Categoria encontrada", "success")->back($response);
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

        if (!isset($data['name']) || empty($data['name'])) {
            $this->call(
                400,
                "bad_request",
                "Nome da categoria é obrigatório",
                "error")->back();
            return;
        }

        $category = new Category(null, $data['name']);

        if (!$category->insert()) {
            $this->call(500, "internal_server_error", $category->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $category->getId(),
            "name" => $category->getName()
        ];

        $this->call(201,"success","Categoria de produto inserida com sucesso","created")->back($response);
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

        if (!isset($data['name']) || empty($data['name'])) {
            $this->call(
                400,
                "bad_request",
                "Campo nome da categoria é obrigatório",
                "error")->back(null);
            return;
        }   

        $category = new Category($data['category_id'], $data['name']);

        if (!$category->updateById($data['category_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $category->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $category->getId(),
            "name" => $category->getName()
        ];

        $this->call(200, "success", "Nome da categoria atualizado com sucesso", "success")->back($response);

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

        if (!isset($data['category_id']) || empty($data['category_id']) || !filter_var($data['category_id'], FILTER_VALIDATE_INT)) {
            $this->call(
                400, 
                "bad_request", 
                "ID da categoria é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $category = new Category();

        if(!$category->softDeleteById($data['category_id'])){

            $this->call(
                500, 
                "internal_server_error", 
                $category->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $this->call(200,"success","Categoria inativada com sucesso","success")->back();
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

        if (!isset($data['category_id']) || empty($data['category_id']) || !filter_var($data['category_id'], FILTER_VALIDATE_INT)) {
            $this->call(
                400, 
                "bad_request", 
                "ID da categoria é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }
        
        $category = new Category();

        if(!$category->deleteById($data['category_id'])){
            $this->call(500, "internal_server_error", $category->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200,"success","Categoria excluída com sucesso","success")->back();        
    }

}