<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Servidores extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $servidoresModel = new \App\Models\ServidoresModel();
        $data['servidores'] = $servidoresModel->find();
        $data['msg'] = $this->session->getFlashdata('msg');
        $data['is_admin'] = $this->session->get('isAdmin');
        return View('servidores', $data);
    }

    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['is_admin'] = $this->session->get('isAdmin');
        $data['title'] = 'Adicionar Servidor';

        if ($this->request->getMethod() === 'post') {
            $servidorModel = new \App\Models\ServidoresModel();
            $dadosServidor = $this->request->getPost();
            if ($servidorModel->insert($dadosServidor)) {
                $data['msg'] = 'Servidor inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir servidor';
                $data['errors'] = $servidorModel->errors();
            }
        }
        return view('adicionarServidor', $data);
    }

    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Servidor';
        $data['is_admin'] = $this->session->get('isAdmin');
        $servidorModel = new \App\Models\ServidoresModel();
        $servidor = $servidorModel->find($id);
        if ($this->request->getMethod() === 'post') {
            $servidor->NOMESERVIDOR = $this->request->getPost('NOMESERVIDOR');
            if ($servidorModel->update($id, $servidor)) {
                $data['msg'] = 'Servidor Atualizado com sucesso!';
            } else {
                $data['errors'] = $servidorModel->errors();
                $data['msg'] = 'Erro ao Atualizar servidor';
            }
        }
       
        $data['servidor'] = $servidor;
        return view('adicionarServidor', $data);
    }

    public function excluir($id = null)
    {
        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Servidor não encontrado...');
            return redirect()->to(base_url('servidores'));
        }
        $servidorModel = new \App\Models\ServidoresModel();
        if ($servidorModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Servidor deletado com sucesso');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar servidor');
        }
        return redirect()->to(base_url('servidores'));
    }
}
