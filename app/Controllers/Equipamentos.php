<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Equipamentos extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Adicionar Equipamento';
        $data['is_admin'] = $this->session->get('isAdmin');

        if ($this->request->getMethod() === 'post') {
            $equipamentosModel = new \App\Models\EquipamentosModel();
            $dadosEquipamento = $this->request->getPost();
            if ($equipamentosModel->insert($dadosEquipamento)) {
                $data['msg'] = 'Equipamento inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir equipamento';
                $data['errors'] = $equipamentosModel->errors();
            }
        }
        $servidoresModel = new \App\Models\ServidoresModel();
        $listaServidores = $servidoresModel->findAll();
        $data['selectServidores'] = $listaServidores;

        $equipamentosSelectModel = new \App\Models\EquipamentosModel();
        $listaEquipamentos = $equipamentosSelectModel->findAll();
        $data['selectEquipamentos'] = $listaEquipamentos;

        $pontosModel = new \App\Models\PontosModel();
        $listaPontos = $pontosModel->findAll();
        $data['selectPontos'] = $listaPontos;

        $cidadesModel = new \App\Models\CidadesModel();
        $listaCidades = $cidadesModel->findAll();
        $data['selectCidades'] = $listaCidades;

        $softwaresModel = new \App\Models\SoftwaresModel();
        $listaSoftwares = $softwaresModel->findAll();
        $data['selectSoftwares'] = $listaSoftwares;

        $modelosModel = new \App\Models\ModelosModel();
        $listaModelos = $modelosModel->findAll();
        $data['selectModelos'] = $listaModelos;

        $modosModel = new \App\Models\ModoOperacaoModel();
        $listaModos = $modosModel->findAll();
        $data['selectModos'] = $listaModos;

        return view('adicionarAps', $data);
    }
}