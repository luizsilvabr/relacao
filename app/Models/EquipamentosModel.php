<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipamentosModel extends Model
{
    protected $table = 'EQUIPAMENTO';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['DESCRICAOEQUIPAMENTO', 'IP', 'COMENTARIOEQUIPAMENTO', 'MODOEQUIPAMENTO', 'SOFTWAREEQUIPAMENTO', 'MODELOEQUIPAMENTO', 'PONTOEQUIPAMENTO', 'CIDADEEQUIPAMENTO', 'CANAL','COORDENADAS'];
    protected $returnType = 'object';

    protected $validationRules = [
        'DESCRICAOEQUIPAMENTO' => 'required|is_unique[EQUIPAMENTO.DESCRICAOEQUIPAMENTO,ID,{ID}]',
        'MODELOEQUIPAMENTO' => 'required',
        'MODOEQUIPAMENTO' => 'required',
        'SOFTWAREEQUIPAMENTO' => 'required',
        'CIDADEEQUIPAMENTO' => 'required',
        'PONTOEQUIPAMENTO' => 'required',
        'IP' => 'required|is_unique[EQUIPAMENTO.IP,ID,{ID}]',
    ];

    protected $validationMessages = [
        'DESCRICAOEQUIPAMENTO' => [
            'required' => 'O campo descrição do equipamento é obrigatório.',
            'is_unique' => 'Já existe um Equipamento com esta Descrição.'
        ],
        'MODELOEQUIPAMENTO' => [
            'required' => 'O campo modelos é obrigatório.',
        ],
        'MODOEQUIPAMENTO' => [
            'required' => 'O campo modos é obrigatório.',
        ],
        'SOFTWAREEQUIPAMENTO' => [
            'required' => 'O campo softwares é obrigatório.',
        ],
        'CIDADEEQUIPAMENTO' => [
            'required' => 'O campo cidades é obrigatório.',
        ],
        'PONTOEQUIPAMENTO' => [
            'required' => 'O campo pontos é obrigatório.',
        ],
        'IP' => [
            'required' => 'O campo ip é obrigatório.',
            'is_unique' => 'Já existe um Equipamento com este ip.'
        ],
    ];
    
}
