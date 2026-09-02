<?php

namespace Source\Controller;

use Source\Models\User\Type;

class UsersTypes extends Api
{
    public function listAll(array $data) : void {

        $type = new Type();

        $this->call(200, "success", "Lista de tipos de usuários", "success")->back($type->selectAll());
    }

    public function userTypeById(array $data) : void {

        if (!isset($data['typeId']) || empty($data['typeId']) || !filter_var($data['typeId'], FILTER_VALIDATE_INT)) {
            $this->call(400, "bad_request", "ID do tipo de usuário é obrigatório e precisa ser um inteiro", "error")->back(null);
        }

        $type = new Type();

        if (!$type->selectById($data['typeId'])) {
            $this->call(404, "not_found", "Tipo de usuário não encontrado", "error");
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getName()
        ];

        $this->call(200, "success", "Produto encontrado", "success")->back($response);
    }

    public function createTypeUser(array $data) : void {

        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if (!isset($data['name']) || empty($data['name'])) {
            $this->call(400,
                "bad_request",
                "Nome do tipo de usuário é obrigatório",
                "error")->back();
            return;
        }

        $type = new Type(
            null,
            $data['name']
        );

        if (!$type->insert()) {
            $this->call(500, "internal_server_error", $type->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getName()
        ];

        $this->call(201,"success","Tipo de usuário inserido com sucesso","created")->back($response);
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

        if (!isset($data['name']) || empty($data['name'])) {
            $this->call(400,
                "bad_request",
                "Nome do tipo de usuário é obrigatório",
                "error")->back();
            return;
        }

        $type = new Type(
            $data['typeId'],
            $data['name']
        );

        if (!$type->updateById($data['typeId'])) {
            $this->call(500, "internal_server_error", $type->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $type->getId(),
            "name" => $type->getName()
        ];

        $this->call(200, "success", "Tipo de usuário atualizado com sucesso", "success")->back($response);
    }

    public function inactive(array $data) : void 
    {
        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $type = new Type();

        if(!$type->softDeleteById($data['typeId'])){
            $this->call(500, "internal_server_error", $type->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200,"success","Tipo de usuário inativado com sucesso","success")->back();
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

        $type = new type();

        if(!$type->deleteById($data['typeId'])){
            $this->call(500, "internal_server_error", $type->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200,"success","Tipo de usuário excluído com sucesso","success")->back();
    }
}