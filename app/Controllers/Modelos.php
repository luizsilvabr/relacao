<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Modelos extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $modelosModel = new \App\Models\ModelosModel();
        $data['modelos'] = $modelosModel->find();
        $data['msg'] = $this->session->getFlashdata('msg');
        $data['is_admin'] = $this->session->get('isAdmin');
        return View('modelos', $data);
    }

    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Adicionar Modelo';
        $data['is_admin'] = $this->session->get('isAdmin');

        if ($this->request->getMethod() === 'post') {
            $modelosModel = new \App\Models\ModelosModel();
            $dadosModel = $this->request->getPost();
            if ($modelosModel->insert($dadosModel)) {
                $data['msg'] = 'Model inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir modelo';
                $data['errors'] = $modelosModel->errors();
            }
        }
        return view('adicionarModelo', $data);
    }

    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Modelo';
        $modelosModel = new \App\Models\ModelosModel();
        $modelo = $modelosModel->find($id);
        $data['is_admin'] = $this->session->get('isAdmin');
        if ($this->request->getMethod() === 'post') {
            $modelo->NOMEMODELO = $this->request->getPost('NOMEMODELO');
            if ($modelosModel->update($id, $modelo)) {
                $data['msg'] = 'Modelo Atualizado com sucesso!';
            } else {
                $data['errors'] = $modelosModel->errors();
                $data['msg'] = 'Erro ao Atualizar modelo';
            }
        }
        $data['modelo'] = $modelo;
        return view('adicionarModelo', $data);
    }

    public function excluir($id = null)
    {

        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Cidade não encontrada...');
            return redirect()->to(base_url('cidades'));
        }
        $modelosModel = new \App\Models\ModelosModel();
        if ($modelosModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Modelo deletado com sucesso');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar modelo');
        }
        return redirect()->to(base_url('modelos'));
    }
}
