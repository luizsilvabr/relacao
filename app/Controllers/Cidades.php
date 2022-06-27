<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Cidades extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $cidadesModel = new \App\Models\CidadesModel();
        $data['cidades'] = $cidadesModel->find();
        $data['msg'] = $this->session->getFlashdata('msg');
        $data['is_admin'] = $this->session->get('isAdmin');
        return View('cidades', $data);
    }

    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Adicionar Cidade';
        $data['is_admin'] = $this->session->get('isAdmin');

        if ($this->request->getMethod() === 'post') {
            $cidadesModel = new \App\Models\CidadesModel();
            $dadosCidade = $this->request->getPost();
            if ($cidadesModel->insert($dadosCidade)) {
                $data['msg'] = 'Cidade inserida com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir cidade';
                $data['errors'] = $cidadesModel->errors();
            }
        }
        return view('adicionarCidade', $data);
    }

    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Cidade';
        $cidadesModel = new \App\Models\CidadesModel();
        $cidade = $cidadesModel->find($id);
        $data['is_admin'] = $this->session->get('isAdmin');
        if ($this->request->getMethod() === 'post') {
            $cidade->NOMECIDADE = $this->request->getPost('NOMECIDADE');
            if ($cidadesModel->update($id, $cidade)) {
                $data['msg'] = 'Cidade Atualizada com sucesso!';
            } else {
                $data['errors'] = $cidadesModel->errors();
                $data['msg'] = 'Erro ao Atualizar cidade';
            }
        }
        $data['cidade'] = $cidade;
        return view('adicionarCidade', $data);
    }

    public function excluir($id = null)
    {

        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Cidade não encontrada...');
            return redirect()->to(base_url('cidades'));
        }
        $cidadesModel = new \App\Models\CidadesModel();
        if ($cidadesModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Cidade deletada com sucesso');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar cidade');
        }
        return redirect()->to(base_url('cidades'));
    }
}
