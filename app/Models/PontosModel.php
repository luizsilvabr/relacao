<?php

namespace App\Models;

use CodeIgniter\Model;

class PontosModel extends Model
{

    protected $table = 'PONTO';
    protected $primaryKey = 'IDPONTO';
    protected $allowedFields = ['NOMEPONTO', 'SERVIDORPONTO', 'LATITUDE', 'LONGITUDE', 'OBSERVACAO', 'CONECTA', 'MEIO', 'NOME', 'TELEFONE','ENDERECO', 'EMAIL', 'PATRIMONIO'];
    protected $returnType = 'object';

    protected $validationRules = [
        'NOMEPONTO' => 'required|is_unique[PONTO.NOMEPONTO,IDPONTO{IDPONTO}]',
        'SERVIDORPONTO' => 'required',
        'MEIO' => 'required',
        'CONECTA' => 'required',
    ];

    protected $validationMessages = [
        'NOMEPONTO' => [
            'required' => 'O campo nome do ponto é obrigatório.',
            'is_unique' => 'Já existe um ponto com este nome.'
        ],
        'SERVIDORPONTO' => [
            'required' => 'O campo servidor é obrigatório.',
        ],
        'CONECTA' => [
            'required' => 'O campo "recebe sinal de" é obrigatório.',
        ],
        'MEIO' => [
            'required' => 'O campo "tipo de mídia" é obrigatório.',
        ],
    ];
}
