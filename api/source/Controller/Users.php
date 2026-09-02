<?php

namespace Source\Controller;

use Source\Models\User\User;

class Users extends Api
{
    //users comuns

    public function register (array $data): void
    {
        if(!isset($data['password']) || empty($data['password'])) {
            $this->call(400,
                "bad_request",
                "A senha é obrigatória.",
                "error")->back();
            return;
        }

        if(!$this->validateNameEmail($data)){
            $this->call(400,
                "bad_request",
                "Nome e e-mail são obrigatórios. O e-mail deve ser válido.",
                "error")->back();
            return;
        }

        $user = new User(
            null,
            2,
            $data['name'],
            $data['email'],
            $data['password']
        );

        if(!$user->insert()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail()
        ];

        $this->call(201,"success","Usuário inserido com sucesso","created")->back($response);
    }

    public function auth (array $data): void
    {
        if(!isset($data['email'], $data['password']) ||
            empty($data['email']) || empty($data['password']) ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(
                400,
                "bad_request",
                "E-mail e senha são obrigatórios. O e-mail deve ser válido.",
                "error")->back();
            return;
        }

        $user = new User();   
        
        if(!$user->login($data['email'], $data['password'])) {
            $this->call(
                401,
                "unauthorized",
                $user->getErrorMessage(),
                "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(), //parou de funcionar quando alterei aqui
            "photo" => $user->getPhoto(),
            "token" => $user->getToken(),
        ];

        $this->call(
            200,
            "success",
            "Usuário logado com sucesso",
            "success")->back($response);
    }

    public function listUsers(array $data) : void {
        $user = new User();

        $this->call(200, "success", "Lista de usuários", "success")->back($user->selectAll());
    }

    public function update (array $data): void
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        // fazer o update do usuário agora autenticado
        $user = new User(
            $this->userAuthId,
            2,
            $data['name'],
            $data['email'],
            $data['password'],
            $data['photo']
        );

        if (!$user->updateById($this->userAuthId)) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "typeId" => $user->getTypeId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "photo" => $user->getPhoto(),
        ];

        $this->call(200,"success","Usuário atualizado com sucesso","success")->back($response);
    }

    //users admins

    public function registerAdmin(array $data) : void {

        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!isset($data['password']) || empty($data['password'])) {
            $this->call(400,
                "bad_request",
                "A senha de administrador é obrigatória.",
                "error")->back();
            return;
        }

        if(!$this->validateNameEmail($data)){
            $this->call(400,
                "bad_request",
                "Nome e e-mail do administrador são obrigatórios. O e-mail deve ser válido.",
                "error")->back();
            return;
        }

        $user = new User(
            null,
            1,
            $data['name'],
            $data['email'],
            $data['password']
        );

        if(!$user->insert()) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail()
        ];

        $this->call(201,"success","Administrador inserido com sucesso","created")->back($response);        
    }

    public function authAdmin (array $data): void
    {
        if(!isset($data['email'], $data['password']) ||
            empty($data['email']) || empty($data['password']) ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(
                400,
                "bad_request",
                "E-mail e senha são obrigatórios. O e-mail deve ser válido.",
                "error")->back();
            return;
        }

        $user = new User();
        if(!$user->login($data['email'], $data['password'], 1)) {
            $this->call(
                401,
                "unauthorized",
                $user->getErrorMessage(),
                "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "photo" => $user->getPhoto(),
            "token" => $user->getToken(),
        ];

        $this->call(
            200,
            "success",
            "Usuário logado com sucesso",
            "success")->back($response);
    }

    public function updateAdmin (array $data): void
    {
        if(!$this->authToken (1)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        // validar campos
        if(!isset($data['email'], $data['password']) ||
            empty($data['email']) || empty($data['password']) ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->call(
                400,
                "bad_request",
                "E-mail e senha são obrigatórios. O e-mail deve ser válido.",
                "error")->back();
            return;
        }


        // fazer o update do usuário ADMIN agora autenticado
        $user = new User();
        
        $user = new User(
            $this->userAuthId,
            1,
            $data['name'],
            $data['email'],
            $data['password'],
            $data['photo']
        );

        if (!$user->updateById($this->userAuthId)) {
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $user->getId(),
            "typeId" => $user->getTypeId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "photo" => $user->getPhoto(),
        ];

        $this->call(200,"success","Administrador atualizado com sucesso","success")->back($response);
    }

    //outras funções

    public function inactive(array $data) : void 
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $user = new User();

        if(!$user->softDeleteById($this->userAuthId)){
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200,"success","Usuário inativado com sucesso","success")->back();
    }

    public function deleteRegister(array $data) : void 
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $user = new User();

        if(!$user->deleteById($this->userAuthId)){
            $this->call(500, "internal_server_error", $user->getErrorMessage(), "error")->back();
            return;
        }

        $this->call(200,"success","Usuário excluído com sucesso","success")->back();
    }

    // Valida somente Nome e Email, mas pode ser alterada para validar mais campos
    private function validateNameEmail(array $data): bool
    {
        if(!isset($data["name"],$data["email"]) ||
            empty($data["name"]) || empty($data["email"]) ||
            !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}