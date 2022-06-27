<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelosModel extends Model
{
    protected $table = 'MODELO';
    protected $primaryKey = 'IDMODELO';
    protected $allowedFields = ['NOMEMODELO'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMEMODELO' => 'required|min_length[2]|is_unique[MODELO.NOMEMODELO,IDMODELO,{IDMODELO}]',
    ];

    protected $validationMessages = [
        'NOMEMODELO' => [
            'required' => 'O campo nome é obrigatório.',
            'min_length' => 'O campo nome deve ter mais de 2 caracteres.',
            'is_unique' => 'Já existe um Modelo com este nome.'
        ]
    ];
}
