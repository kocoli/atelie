<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Order\Status;

class StatusController extends Api {

    public function selectAll(array $data) : void {
        $status = new Status();

        $this->call(200, "success", "Lista de Status", "success")->back($status->selectAll());
    }

    public function selectById(array $data) : void {

        if (!isset($data["status_id"]) || empty($data["status_id"]) || !filter_var($data["status_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do status é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $status = new Status();

        if (!$status->selectById($data["status_id"])) {
            
            $this->call(
                404, 
                "not_found", 
                "Status não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $status->getId(),
            "status" => $status->getStatus()
        ];

        $this->call(200, "success", "Status encontrado", "success")->back($response);
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

        if (!isset($data["status"]) || empty($data["status"])) {
            $this->call(
                400,
                "bad_request",
                "Status é obrigatório",
                "error"
            )->back();
            return;
        }

        $status = new Status(null, $data["status"]);

        if (!$status->insert()) {
            $this->call(500, "internal_server_error", $status->getErrorMessage(), "error")->back();
            return;
        }

        $response = [
            "id" => $status->getId(),
            "status" => $status->getStatus()
        ];

        $this->call(201, "created", "Status criado com sucesso", "success")->back($response);
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

        if (!isset($data["status_id"]) || empty($data["status_id"]) || !filter_var($data["status_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do status é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $status = new Status(
            $data["status_id"],
            $data['status']
        );

        if (!$status->updateById($data['status_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $status->getErrorMessage(), 
                "error"
            )->back();
            return;
        }

        $response = [
            "id" => $status->getId(),
            "status" => $status->getStatus()
        ];

        $this->call(200, "success", "Status atualizado com sucesso", "success")->back($response);
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

        if (!isset($data["status_id"]) || empty($data["status_id"]) || !filter_var($data["status_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do status é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $status = new Status();

        if (!$status->softDeleteById($data["status_id"])) {
            
            $this->call(500,  "internal_server_error",  $status->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Status inativado com sucesso","success")->back();
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

        if (!isset($data["status_id"]) || empty($data["status_id"]) || !filter_var($data["status_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID do status é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $status = new Status();

        if (!$status->deleteById($data["status_id"])) {
            
            $this->call(500,  "internal_server_error",  $status->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","Status deletado com sucesso","success")->back();        
    }
}