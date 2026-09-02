<?php

namespace Source\Models\Faq;

use Source\Core\Model;

class Question extends Model
{
    private ?int $id;
    private ?string $question;
    private ?string $answer;
    private ?int $typeId;
    private ?int $active;

    private ?string $token = null;

    public function __construct(
        ?int $id = null,
        ?string $question = null,
        ?string $answer = null,
        ?int $typeId = null
    )
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->typeId = $typeId;

        $this->table = 'faq_questions'; // nome da tabela do banco
        $this->primaryKey = 'id'; // nome da chave primária da tabela
        $this->fillable = ['question', 'answer', 'typeId']; // camelCase
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getQuestion() : ?string
    {
        return $this->question;
    }
    
    public function getAnswer() : ?string
    {
        return $this->answer;
    }

    public function getTypeId() : ?int
    {
        return $this->typeId;
    }

    public function getActive() : ?int {
        return $this->active;
    }
 
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function setQuestion(string $question) : void
    {
        $this->question = $question;
    }

    public function setAnswer(string $answer) : void
    {
        $this->answer = $answer;
    }

    public function setTypeId(?int $typeId) : void
    {
        $this->typeId = $typeId;
    }

    public function setActive(?int $active) : void {
        $this->active = $active;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    // public function show() : string {
    //     return "
    //         FAQ {$this->id}  <br>
    //         Categoria: {$this->type->getDescription()}  <br>
    //         Pergunta: {$this->question}  <br>
    //         Resposta: {$this->answer}  <br>
    //     ";
    // }
}