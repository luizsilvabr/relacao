<?php

namespace App\Models;

use CodeIgniter\Model;

class ServidoresModel extends Model
{

    protected $table = 'SERVIDOR';
    protected $primaryKey = 'IDSERVIDOR';
    protected $allowedFields = ['NOMESERVIDOR', 'CIDADESERVIDOR'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMESERVIDOR' => 'required|min_length[2]|is_unique[SERVIDOR.NOMESERVIDOR,IDSERVIDOR,{IDSERVIDOR}]',
    ];

    protected $validationMessages = [
        'NOMESERVIDOR' => [
            'required' => 'O campo nome servidor é obrigatório.',
            'min_length' => 'O campo nome servidor deve ter mais de 2 caracteres.',
            'is_unique' => 'Já existe um Servidor com este nome.'
        ]
    ];
}
