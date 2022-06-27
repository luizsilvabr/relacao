<?php

namespace App\Models;

use CodeIgniter\Model;

class SoftwaresModel extends Model
{
    protected $table = 'SOFTWARE';
    protected $primaryKey = 'IDSOFTWARE';
    protected $allowedFields = ['NOMESOFTWARE'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMESOFTWARE' => 'required|is_unique[SOFTWARE.NOMESOFTWARE,IDSOFTWARE,{IDSOFTWARE}]',
    ];
    protected $validationMessages = [
        'NOMESOFTWARE' => [
            'required' => 'O campo nome software é obrigatório.',
            'is_unique' => 'Já existe um Software com este nome.'
        ]
    ];
}