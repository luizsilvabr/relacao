<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Pontos extends BaseController
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
        $data['title'] = 'Adicionar Ponto';
        $data['is_admin'] = $this->session->get('isAdmin');

        if ($this->request->getMethod() === 'post') {
                $data['msg'] = 'Ponto inserido com sucesso!';
            $pontosModel = new \App\Models\PontosModel();
            $dadosPonto = $this->request->getPost();
            if ($pontosModel->insert($dadosPonto)) {
                $data['msg'] = 'Ponto inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir ponto';
                $data['errors'] = $pontosModel->errors();
            }
        }
        $servidoresModel = new \App\Models\ServidoresModel();
        $listaServidores = $servidoresModel->findAll();
        $data['selectServidores'] = $listaServidores;

        $pontosSelectModel = new \App\Models\PontosModel();
        $listaPontos = $pontosSelectModel->findAll();
        $data['selectPontos'] = $listaPontos;
        return view('adicionarPonto', $data);
    }


    public function editar($id)
    {
        $data['msg'] = '';
        $data['errors'] = '';
        $data['title'] = 'Editar Ponto';
        $pontosModel = new \App\Models\PontosModel();
        $ponto = $pontosModel->find($id);
        $data['is_admin'] = $this->session->get('isAdmin');
        if ($this->request->getMethod() === 'post') {
            $ponto->NOMEPONTO = $this->request->getPost('NOMEPONTO');
            $ponto->SERVIDORPONTO = $this->request->getPost('SERVIDORPONTO');
            $ponto->OBSERVACAO = $this->request->getPost('OBSERVACAO');
            $ponto->CONECTA = $this->request->getPost('CONECTA');
            $ponto->MEIO = $this->request->getPost('MEIO');
            $ponto->NOME = $this->request->getPost('NOME');
            $ponto->TELEFONE = $this->request->getPost('TELEFONE');
            $ponto->ENDERECO = $this->request->getPost('ENDERECO');
            $ponto->EMAIL = $this->request->getPost('EMAIL');
            $ponto->PATRIMONIO = $this->request->getPost('PATRIMONIO');
            if ($pontosModel->update($id, $ponto)) {
                $data['msg'] = 'Ponto Atualizado com sucesso!';
            } else {
                $data['errors'] = $pontosModel->errors();
                $data['msg'] = 'Erro ao Atualizar ponto';
            }
        }
        $servidoresModel = new \App\Models\ServidoresModel();
        $listaServidores = $servidoresModel->findAll();
        $data['selectServidores'] = $listaServidores;

        $pontosSelectModel = new \App\Models\PontosModel();
        $listaPontos = $pontosSelectModel->findAll();
        $data['selectPontos'] = $listaPontos;

        $data['ponto'] = $ponto;
        return view('adicionarPonto', $data);
    }

    public function excluir($id = null)
    {

        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Ponto não encontrado...');
            return redirect()->to(base_url('pontos'));
        }
        $pontosModel = new \App\Models\PontosModel();
        if ($pontosModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Ponto deletado com sucesso');
            return redirect()->to('/relacao/pesquisar');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar ponto');
            return redirect()->to('/relacao/pesquisar');
        }
    }
}
