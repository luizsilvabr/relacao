<?php

namespace App\Models;

use CodeIgniter\Model;

class ModoOperacaoModel extends Model
{
    protected $table = 'MODO';
    protected $primaryKey = 'IDMODO';
    protected $allowedFields = ['NOMEMODO'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMEMODO' => 'required|min_length[2]|is_unique[MODO.NOMEMODO,IDMODO,{IDMODO}]',
    ];

    protected $validationMessages = [
        'NOMEMODO' => [
            'required' => 'O campo nome é obrigatório.',
            'min_length' => 'O campo nome deve ter mais de 2 caracteres.',
            'is_unique' => 'Já existe um Modelo com este nome.'
        ]
    ];
}
