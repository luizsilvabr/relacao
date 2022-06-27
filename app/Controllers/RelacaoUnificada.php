<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class RelacaoUnificada extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $this->session->getFlashdata('msg') != '' ? $data['msg'] = $this->session->getFlashdata('msg') : $data['msg'] = '';
        $data['msgLogin'] = $this->session->getFlashdata('msgLogin');
        $data['is_admin'] = $this->session->get('isAdmin');
        $searched = '';
        $data['searched'] = $searched;
        return View('relacaoUnificada', $data);
    }
    public function pesquisar()
    {
        $this->session->getFlashdata('msg') != '' ? $data['msg'] = $this->session->getFlashdata('msg') : $data['msg'] = '';
        $ponto = $this->request->getPost('ponto');
        $servidor = $this->request->getPost('servidor');
        $desc = $this->request->getPost('desc');
        $data['desc'] = $desc;
        $data['pontoPesquisado'] = $ponto;
        $data['servidorPesquisado'] = $servidor;
        $data['searched'] = '';
        $this->db = db_connect();
        if (!empty($ponto) and !empty($servidor) and !empty($desc)) {
            $info = "SELECT
            PONTO.IDPONTO AS idponto,
            PONTO.NOME AS nomepessoa,
            PONTO.TELEFONE AS telefone,
            PONTO.ENDERECO AS endereco,
            PONTO.EMAIL AS email,
            PONTO.OBSERVACAO AS observacao,
            PONTO.SINALLOCAL AS sinalocal,
            PONTO.SINALREMOTO AS sinalremoto,
            PONTO.NOMEPONTO as ponto,
            PONTO.PATRIMONIO as patrimonio,
            PONTO.SERVIDORPONTO,
            SERVIDOR.NOMESERVIDOR as servidor,
            PONTO.CONECTA,
            PONTO.MEIO,
            SERVIDOR.IDSERVIDOR
           FROM PONTO
           LEFT JOIN EQUIPAMENTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
           LEFT JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
           LEFT JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
           LEFT JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
           LEFT JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
           LEFT JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
           WHERE
           PONTO.NOMEPONTO = '$ponto' AND EQUIPAMENTO.DESCRICAOEQUIPAMENTO LIKE '%$desc%'
           GROUP BY IDPONTO;";
            $query = $this->db->query($info);
            $data['infos'] = $query->getResult();

            $table = "SELECT
            EQUIPAMENTO.ID AS idequipamento,
            EQUIPAMENTO.DESCRICAOEQUIPAMENTO AS descricao, 
            EQUIPAMENTO.CANAL as canal,
            EQUIPAMENTO.IP as ip, 
            EQUIPAMENTO.COMENTARIOEQUIPAMENTO as comentario, 
            SOFTWARE.NOMESOFTWARE as nomesoftware,
            SOFTWARE.IDSOFTWARE, 
            MODO.NOMEMODO as modo,
            SERVIDOR.NOMESERVIDOR as servidor, 
            MODELO.NOMEMODELO as modelo,
            MODELO.IDMODELO, 
            PONTO.NOMEPONTO as ponto, 
            PONTO.IDPONTO,
            CIDADE.NOMECIDADE as cidade,
            CIDADE.IDCIDADE,
            EQUIPAMENTO.MODOEQUIPAMENTO
           FROM EQUIPAMENTO
           JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
           JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
           JOIN PONTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
           JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
           JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
           JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
           WHERE
           PONTO.NOMEPONTO = '$ponto' AND EQUIPAMENTO.DESCRICAOEQUIPAMENTO LIKE '%$desc%'";
            $query = $this->db->query($table);
            $data['tables'] = $query->getResult();
        }
        if (!empty($ponto) and !empty($servidor) and empty($desc)) {
            $info = "SELECT
            PONTO.IDPONTO AS idponto,
            PONTO.NOME AS nomepessoa,
            PONTO.TELEFONE AS telefone,
            PONTO.ENDERECO AS endereco,
            PONTO.EMAIL AS email,
            PONTO.OBSERVACAO AS observacao,
            PONTO.SINALLOCAL AS sinalocal,
            PONTO.SINALREMOTO AS sinalremoto,
            PONTO.NOMEPONTO as ponto,
            PONTO.PATRIMONIO as patrimonio,
            PONTO.SERVIDORPONTO,
            SERVIDOR.NOMESERVIDOR as servidor,
            PONTO.CONECTA,
            PONTO.MEIO,
            SERVIDOR.IDSERVIDOR
           FROM PONTO
           LEFT JOIN EQUIPAMENTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
           LEFT JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
           LEFT JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
           LEFT JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
           LEFT JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
           LEFT JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
           WHERE
           PONTO.NOMEPONTO = '$ponto'
           GROUP BY IDPONTO;";
            $query = $this->db->query($info);
            $data['infos'] = $query->getResult();
            $table = "SELECT
                EQUIPAMENTO.ID AS idequipamento,
                EQUIPAMENTO.DESCRICAOEQUIPAMENTO AS descricao, 
                EQUIPAMENTO.CANAL as canal,
                EQUIPAMENTO.IP as ip, 
                EQUIPAMENTO.COMENTARIOEQUIPAMENTO as comentario, 
                SOFTWARE.NOMESOFTWARE as nomesoftware,
                SOFTWARE.IDSOFTWARE, 
                MODO.NOMEMODO as modo,
                SERVIDOR.NOMESERVIDOR as servidor, 
                MODELO.NOMEMODELO as modelo,
                MODELO.IDMODELO, 
                PONTO.NOMEPONTO as ponto, 
                PONTO.IDPONTO,
                CIDADE.NOMECIDADE as cidade,
                CIDADE.IDCIDADE,
                EQUIPAMENTO.MODOEQUIPAMENTO
                FROM EQUIPAMENTO
                JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
                JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
                JOIN PONTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
                JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
                JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
                JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
                WHERE
                PONTO.NOMEPONTO = '$ponto';";
            $query = $this->db->query($table);
            $data['tables'] = $query->getResult();
        }
        if (!empty($servidor) and !empty($desc) and empty($ponto)) {
            $info = "SELECT
            PONTO.IDPONTO AS idponto,
            PONTO.NOME AS nomepessoa,
            PONTO.TELEFONE AS telefone,
            PONTO.ENDERECO AS endereco,
            PONTO.EMAIL AS email,
            PONTO.OBSERVACAO AS observacao,
            PONTO.SINALLOCAL AS sinalocal,
            PONTO.SINALREMOTO AS sinalremoto,
            PONTO.NOMEPONTO as ponto,
            PONTO.PATRIMONIO as patrimonio,
            PONTO.SERVIDORPONTO,
            SERVIDOR.NOMESERVIDOR as servidor,
            PONTO.CONECTA,
            PONTO.MEIO,
            SERVIDOR.IDSERVIDOR
           FROM PONTO
           LEFT JOIN EQUIPAMENTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
           LEFT JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
           LEFT JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
           LEFT JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
           LEFT JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
           LEFT JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
           WHERE
           SERVIDOR.IDSERVIDOR = '$servidor' AND EQUIPAMENTO.DESCRICAOEQUIPAMENTO LIKE '%$desc%'
           GROUP BY IDPONTO;";
            $query = $this->db->query($info);
            $data['infos'] = $query->getResult();

            $table = "SELECT
            EQUIPAMENTO.ID AS idequipamento,
            EQUIPAMENTO.DESCRICAOEQUIPAMENTO AS descricao, 
            EQUIPAMENTO.CANAL as canal,
            EQUIPAMENTO.IP as ip, 
            EQUIPAMENTO.COMENTARIOEQUIPAMENTO as comentario, 
            SOFTWARE.NOMESOFTWARE as nomesoftware,
            SOFTWARE.IDSOFTWARE, 
            MODO.NOMEMODO as modo,
            SERVIDOR.NOMESERVIDOR as servidor, 
            MODELO.NOMEMODELO as modelo,
            MODELO.IDMODELO, 
            PONTO.NOMEPONTO as ponto, 
            PONTO.IDPONTO,
            CIDADE.NOMECIDADE as cidade,
            CIDADE.IDCIDADE,
            EQUIPAMENTO.MODOEQUIPAMENTO
            FROM EQUIPAMENTO
            JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
            JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
            JOIN PONTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
            JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
            JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
            JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
            WHERE
            SERVIDOR.IDSERVIDOR = '$servidor' AND EQUIPAMENTO.DESCRICAOEQUIPAMENTO LIKE '%$desc%';";
            $query = $this->db->query($table);
            $data['tables'] = $query->getResult();
        }
        if (!empty($servidor) and empty($desc) and empty($ponto)) {
            $info = "SELECT
            PONTO.IDPONTO AS idponto,
            PONTO.NOME AS nomepessoa,
            PONTO.TELEFONE AS telefone,
            PONTO.ENDERECO AS endereco,
            PONTO.EMAIL AS email,
            PONTO.OBSERVACAO AS observacao,
            PONTO.SINALLOCAL AS sinalocal,
            PONTO.SINALREMOTO AS sinalremoto,
            PONTO.NOMEPONTO as ponto,
            PONTO.PATRIMONIO as patrimonio,
            PONTO.SERVIDORPONTO,
            SERVIDOR.NOMESERVIDOR as servidor,
            PONTO.CONECTA,
            PONTO.MEIO,
            SERVIDOR.IDSERVIDOR
           FROM PONTO
           LEFT JOIN EQUIPAMENTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
           LEFT JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
           LEFT JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
           LEFT JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
           LEFT JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
           LEFT JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
           WHERE
           SERVIDOR.IDSERVIDOR = '$servidor'
           GROUP BY IDPONTO;";
            $query = $this->db->query($info);
            $data['infos'] = $query->getResult();

            $table = "SELECT
            EQUIPAMENTO.ID AS idequipamento,
            EQUIPAMENTO.DESCRICAOEQUIPAMENTO AS descricao, 
            EQUIPAMENTO.CANAL as canal,
            EQUIPAMENTO.IP as ip, 
            EQUIPAMENTO.COMENTARIOEQUIPAMENTO as comentario, 
            SOFTWARE.NOMESOFTWARE as nomesoftware,
            SOFTWARE.IDSOFTWARE, 
            MODO.NOMEMODO as modo,
            SERVIDOR.NOMESERVIDOR as servidor, 
            MODELO.NOMEMODELO as modelo,
            MODELO.IDMODELO, 
            PONTO.NOMEPONTO as ponto, 
            PONTO.IDPONTO,
            CIDADE.NOMECIDADE as cidade,
            CIDADE.IDCIDADE,
            EQUIPAMENTO.MODOEQUIPAMENTO
            FROM EQUIPAMENTO
            JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
            JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
            JOIN PONTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
            JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
            JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
            JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
            WHERE
            SERVIDOR.IDSERVIDOR = '$servidor'";
            $query = $this->db->query($table);
            $data['tables'] = $query->getResult();
        }
        if (!empty($desc) and empty($servidor) and empty($ponto)) {
            $data['infos'] = '';
            $table = "SELECT
            EQUIPAMENTO.ID AS idequipamento,
            EQUIPAMENTO.DESCRICAOEQUIPAMENTO AS descricao, 
            EQUIPAMENTO.CANAL as canal,
            EQUIPAMENTO.IP as ip, 
            EQUIPAMENTO.COMENTARIOEQUIPAMENTO as comentario, 
            SOFTWARE.NOMESOFTWARE as nomesoftware,
            SOFTWARE.IDSOFTWARE, 
            MODO.NOMEMODO as modo,
            SERVIDOR.NOMESERVIDOR as servidor, 
            MODELO.NOMEMODELO as modelo,
            MODELO.IDMODELO, 
            PONTO.NOMEPONTO as ponto, 
            PONTO.IDPONTO,
            CIDADE.NOMECIDADE as cidade,
            CIDADE.IDCIDADE,
            EQUIPAMENTO.MODOEQUIPAMENTO
            FROM EQUIPAMENTO
            JOIN SOFTWARE ON EQUIPAMENTO.SOFTWAREEQUIPAMENTO = SOFTWARE.IDSOFTWARE
            JOIN MODO ON EQUIPAMENTO.MODOEQUIPAMENTO = MODO.IDMODO
            JOIN PONTO ON EQUIPAMENTO.PONTOEQUIPAMENTO = PONTO.IDPONTO
            JOIN SERVIDOR ON PONTO.SERVIDORPONTO = SERVIDOR.IDSERVIDOR
            JOIN MODELO ON EQUIPAMENTO.MODELOEQUIPAMENTO = MODELO.IDMODELO
            JOIN CIDADE ON EQUIPAMENTO.CIDADEEQUIPAMENTO = CIDADE.IDCIDADE
            WHERE
            EQUIPAMENTO.DESCRICAOEQUIPAMENTO LIKE '%$desc%';";
            $query = $this->db->query($table);
            $data['tables'] = $query->getResult();
        }
        if (empty($data['tables']) and empty($data['infos'])) {
            $data['msg'] = 'Sua consulta não foi encontrada.';
            $data['searched'] = '';
            return View('relacao', $data);
        }
        $data['is_admin'] = $this->session->get('isAdmin');

        $servidoresModel = new \App\Models\ServidoresModel();
        $listaServidores = $servidoresModel->findAll();
        $data['selectServidores'] = $listaServidores;

        $pontosSelectModel = new \App\Models\PontosModel();
        $listaPontos = $pontosSelectModel->findAll();
        $data['selectPontos'] = $listaPontos;

        $equipamentosSelectModel = new \App\Models\EquipamentosModel();
        $listaEquipamentos = $equipamentosSelectModel->findAll();
        $data['selectEquipamentos'] = $listaEquipamentos;

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

        return View('relacaoUnificada', $data);
    }
}
