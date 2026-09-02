<?php

namespace Source\Controller;

use Source\Models\Faq\Type;
use Source\Models\Faq\Question;

class FaqQuestions extends Api{

    public function selectAll(array $data) : void {

        $question = new Question();

        $this->call(200, "success", "Lista de perguntas", "success")->back($question->selectAll());
    }

    public function selectById(array $data) : void {
    
        if (!isset($data["question_id"]) || empty($data["question_id"]) || !filter_var($data["question_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da pergunta é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $question = new Question();

        if (!$question->selectById($data["question_id"])) {
            
            $this->call(
                404, 
                "not_found", 
                "Pergunta não encontrada", 
                "error"
            )->back(null);
            return;
        }

        $type = new Type();

        if (!$type->selectById($question->getTypeId())) {
            $this->call(
                400, 
                "bad_request", 
                "Tipo da FAQ não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $question->getId(),
            "question" => $question->getQuestion(),
            "answer" => $question->getAnswer(),
            "type" => $type->getDescription()
        ];

        $this->call(200, "success", "FAQ encontrada", "success")->back($response);

    }

    public function create(array $data) : void {    

        if(!$this->validate($data)){
            
            $this->call(
                400,
                "bad_request",
                "Todos os campos são obrigatórios",
                "error"
            )->back();
            return;
        }

        $question = new Question(
            null,
            $data["question"],
            $data["answer"],
            $data["type_id"]
        );

        if (!$question->insert()) {
            $this->call(500, "internal_server_error", $question->getErrorMessage(), "error")->back();
            return;
        }
        
        $type = new Type();

        if (!$type->selectById($question->getTypeId())) {
            $this->call(
                400, 
                "bad_request", 
                "Tipo da FAQ não encontrado", 
                "error"
            )->back(null);
            return;
        }

        $response = [
            "id" => $question->getId(),
            "question" => $question->getQuestion(),
            "answer" => $question->getAnswer(),
            "type" => $type->getDescription()
        ];

        $this->call(201, "created", "FAQ criada com sucesso", "success")->back($response);
    }

    public function update(array $data) : void {

        if(!$this->validate($data)){
            
            $this->call(
                400,
                "bad_request",
                "Todos os campos são obrigatórios",
                "error"
            )->back();
            return;
        }

        $question = new Question(
            $data['question_id'],
            $data["question"],
            $data["answer"],
            $data["type_id"]
        );

        if (!$question->updateById($data['question_id'])) {

            $this->call(
                500, 
                "internal_server_error", 
                $question->getErrorMessage(), 
                "error"
            )->back();
            return;
        }
        
        $type = new Type();
        $type->selectById($question->getTypeId());

        $response = [
            "id" => $question->getId(),
            "question" => $question->getQuestion(),
            "answer" => $question->getAnswer(),
            "type" => $type->getDescription()
        ];

        $this->call(200, "success", "FAQ atualizada com sucesso", "success")->back($response);
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

        if (!isset($data["question_id"]) || empty($data["question_id"]) || !filter_var($data["question_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da FAQ é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $question = new Question();

        if (!$question->softDeleteById($data["question_id"])) {
            
            $this->call(500,  "internal_server_error",  $question->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","FAQ inativada com sucesso","success")->back();
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

        if (!isset($data["question_id"]) || empty($data["question_id"]) || !filter_var($data["question_id"], FILTER_VALIDATE_INT)) {

            $this->call(
                400, 
                "bad_request", 
                "ID da FAQ é obrigatório e precisa ser um inteiro", 
                "error"
            )->back(null);
            return;
        }

        $question = new Question();

        if (!$question->deleteById($data["question_id"])) {
            
            $this->call(500,  "internal_server_error",  $question->getErrorMessage(),  "error")->back();
            return;
        }

        $this->call(200,"success","FAQ deletada com sucesso","success")->back();
    }

    public function validate (array $data): bool
    {
        if(!isset($data["question"]) || !isset($data["answer"]) || !isset($data["type_id"]) ||
            empty($data["question"]) || empty($data["answer"]) || empty($data["type_id"]) || 
           !filter_var($data["type_id"], FILTER_VALIDATE_INT)
        ) {
            return false;
        }
        return true;
    }
}