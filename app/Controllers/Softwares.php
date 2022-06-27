<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Softwares extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $softwaresModel = new \App\Models\SoftwaresModel();
        $data['softwares'] = $softwaresModel->find();
        $data['msg'] = $this->session->getFlashdata('msg');
        $data['is_admin'] = $this->session->get('isAdmin');
        return View('softwares', $data);
    }

    public function adicionar()
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['is_admin'] = $this->session->get('isAdmin');
        $data['title'] = 'Adicionar Software';

        if ($this->request->getMethod() === 'post') {
            $softwaresModel = new \App\Models\SoftwaresModel();
            $dadosSoftware = $this->request->getPost();
            if ($softwaresModel->insert($dadosSoftware)) {
                $data['msg'] = 'Software inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir software';
                $data['errors'] = $softwaresModel->errors();
            }
        }
        return view('adicionarSoftware', $data);
    }

    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Software';
        $data['is_admin'] = $this->session->get('isAdmin');
        $softwaresModel = new \App\Models\SoftwaresModel();
        $software = $softwaresModel->find($id);
        if ($this->request->getMethod() === 'post') {
            $software->NOMESOFTWARE = $this->request->getPost('NOMESOFTWARE');
            if ($softwaresModel->update($id, $software)) {
                $data['msg'] = 'Software Atualizado com sucesso!';
            } else {
                $data['errors'] = $softwaresModel->errors();
                $data['msg'] = 'Erro ao Atualizar software';
            }
        }
       
        $data['software'] = $software;
        return view('adicionarSoftware', $data);
    }

    public function excluir($id = null)
    {
        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Software não encontrado...');
            return redirect()->to(base_url('softwares'));
        }
        $softwaresModel = new \App\Models\SoftwaresModel();
        if ($softwaresModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Software deletado com sucesso');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar software');
        }
        return redirect()->to(base_url('softwares'));
    }
}
