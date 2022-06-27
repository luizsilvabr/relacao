<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{

    protected $table = 'LOGIN';
    protected $allowedFields = ['USUARIO', 'SENHA', 'TYPE'];
    public function getByNome(string $nome): array
    {
        $rq =  $this->where('USUARIO', $nome)->first();

        return !is_null($rq) ? $rq : [];
    }
}
