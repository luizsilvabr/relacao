<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class ModoOperacao extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $modoOperacaoModel = new \App\Models\ModoOperacaoModel();
        $data['modoOperacao'] = $modoOperacaoModel->find();
        $data['msg'] = $this->session->getFlashdata('msg');
        $data['is_admin'] = $this->session->get('isAdmin');
        return View('modoOperacao', $data);
    }

    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Adicionar Modo de Operação';
        $data['is_admin'] = $this->session->get('isAdmin');

        if ($this->request->getMethod() === 'post') {
            $modoOperacaoModel = new \App\Models\ModoOperacaoModel();
            $dadosModoOperacao = $this->request->getPost();
            if ($modoOperacaoModel->insert($dadosModoOperacao)) {
                $data['msg'] = 'Modo de Operação inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir modo de operação';
                $data['errors'] = $modoOperacaoModel->errors();
            }
        }
        return view('adicionarModoOperacao', $data);
    }

    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Modo de Operação';
        $modoOperacaoModel = new \App\Models\ModoOperacaoModel();
        $modoOperacao = $modoOperacaoModel->find($id);
        $data['is_admin'] = $this->session->get('isAdmin');
        if ($this->request->getMethod() === 'post') {
            $modoOperacao->NOMEMODO = $this->request->getPost('NOMEMODO');
            if ($modoOperacaoModel->update($id, $modoOperacao)) {
                $data['msg'] = 'Modo de Operação Atualizado com sucesso!';
            } else {
                $data['errors'] = $modoOperacaoModel->errors();
                $data['msg'] = 'Erro ao Atualizar Modo de Operação';
            }
        }
        $data['modoOperacao'] = $modoOperacao;
        return view('adicionarModoOperacao', $data);
    }

    public function excluir($id = null)
    {

        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Modo de Operação não encontrada...');
            return redirect()->to(base_url('modoOperacao'));
        }
        $modoOperacaoModel = new \App\Models\ModoOperacaoModel();
        if ($modoOperacaoModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Modo de Operação deletado com sucesso');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar modo de operação');
        }
        return redirect()->to(base_url('modoOperacao'));
    }
}
