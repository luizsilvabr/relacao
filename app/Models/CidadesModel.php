<?php

namespace App\Models;

use CodeIgniter\Model;

class CidadesModel extends Model
{

    protected $table = 'CIDADE';
    protected $primaryKey = 'IDCIDADE';
    protected $allowedFields = ['NOMECIDADE'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMECIDADE' => 'required|min_length[2]|is_unique[CIDADE.NOMECIDADE,IDCIDADE,{IDCIDADE}]',
    ];

    protected $validationMessages = [
        'NOMECIDADE' => [
            'required' => 'O campo nome cidade é obrigatório.',
            'min_length' => 'O campo nome cidade deve ter mais de 2 caracteres.',
            'is_unique' => 'Já existe uma Cidade com este nome.'
        ]
    ];
}
