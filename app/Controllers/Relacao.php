<?php

namespace App\Controllers;

use CodeIgniter\Config\View;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Relacao extends BaseController
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
        return View('relacao', $data);
    }
    public function pesquisar()
    {
        $this->session->getFlashdata('msg') != '' ? $data['msg'] = $this->session->getFlashdata('msg') : $data['msg'] = '';
        // Pesquisa
        $this->session->getFlashdata('servidorPesquisado') != '' ? $servidor = $this->session->getFlashdata('servidorPesquisado') : $servidor = $this->request->getPost('servidor');
        $this->session->getFlashdata('pontoPesquisado') != '' ? $ponto = $this->session->getFlashdata('pontoPesquisado') : $ponto = $this->request->getPost('ponto');
        $this->session->getFlashdata('desc') != '' ? $desc = $this->session->getFlashdata('desc') : $desc = $this->request->getPost('desc');
        $data['desc'] = $desc;
        $data['pontoPesquisado'] = $ponto;
        $data['servidorPesquisado'] = $servidor;
        //  ------------------------------------------------
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

        return View('relacao', $data);
    }

    public function excluirInfo($id = null)
    {
        $desc = $this->request->getPost('desc');
        $pontoPesquisado = $this->request->getPost('pontoPesquisado');
        $servidorPesquisado = $this->request->getPost('servidorPesquisado');
        session()->setFlashData('desc', $desc);
        session()->setFlashData('pontoPesquisado', $pontoPesquisado);
        session()->setFlashData('servidorPesquisado', $servidorPesquisado);
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

    public function excluirTable($id = null)
    {
        $desc = $this->request->getPost('desc');
        $pontoPesquisado = $this->request->getPost('pontoPesquisado');
        $servidorPesquisado = $this->request->getPost('servidorPesquisado');
        session()->setFlashData('desc', $desc);
        session()->setFlashData('pontoPesquisado', $pontoPesquisado);
        session()->setFlashData('servidorPesquisado', $servidorPesquisado);
        if (is_null($id)) {
            $this->session->setFlashdata('msg', 'Equipamento não encontrado...');
            return redirect()->to('/relacao/pesquisar');
        }
        $equipamentosModel = new \App\Models\EquipamentosModel();
        if ($equipamentosModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Equipamento deletado com sucesso');
            return redirect()->to('/relacao/pesquisar');
        } else {
            $this->session->setFlashdata('msg', 'Erro ao deletar equipamento');
            return redirect()->to('/relacao/pesquisar');
        }
    }

    public function editarInfo($id)
    {
        $desc = $this->request->getPost('desc');
        $pontoPesquisado = $this->request->getPost('pontoPesquisado');
        $servidorPesquisado = $this->request->getPost('servidorPesquisado');
        if(isset($_POST['btnEditarPonto'])){
            session()->setFlashData('desc', $desc);
            session()->setFlashData('pontoPesquisado', $pontoPesquisado);
            session()->setFlashData('servidorPesquisado', $servidorPesquisado);
            $connect = mysqli_connect("189.1.145.102", "root", "185101rf", "relacao");
            mysqli_set_charset($connect, "utf8");
            $nomeponto = mysqli_escape_string($connect,$_POST['NOMEPONTO']);
            $servidorponto = mysqli_escape_string($connect,$_POST['SERVIDORPONTO']);
            $observacao = mysqli_escape_string($connect,$_POST['OBSERVACAO']);
            $conecta = mysqli_escape_string($connect,$_POST['CONECTA']);
            $meio = mysqli_escape_string($connect,$_POST['MEIO']);
            $nome = mysqli_escape_string($connect,$_POST['NOME']);
            $telefone = mysqli_escape_string($connect,$_POST['TELEFONE']);
            $endereco = mysqli_escape_string($connect,$_POST['ENDERECO']);
            $email = mysqli_escape_string($connect,$_POST['EMAIL']);
            $patrimonio = mysqli_escape_string($connect,$_POST['PATRIMONIO']); 
            $sinallocal = mysqli_escape_string($connect,$_POST['SINALLOCAL']); 
            $sinalremoto = mysqli_escape_string($connect,$_POST['SINALREMOTO']); 
            $sql = "UPDATE PONTO SET NOMEPONTO = '$nomeponto', SERVIDORPONTO='$servidorponto', OBSERVACAO='$observacao', CONECTA='$conecta', MEIO='$meio', NOME='$nome', EMAIL='$email', ENDERECO='$endereco', EMAIL='$email', TELEFONE='$telefone', PATRIMONIO='$patrimonio', SINALREMOTO='$sinalremoto', SINALLOCAL='$sinallocal' WHERE IDPONTO='$id'";
        if (mysqli_query($connect, $sql)) {
            session()->setFlashData('msg', 'Ponto Atualizado com sucesso!');
            return redirect()->to('/relacao/pesquisar');
        } else {
            session()->setFlashData('msg', 'Erro ao Atualizar ponto');
            return redirect()->to('/relacao/pesquisar');
        }
    }
        session()->setFlashData('msg', 'Não foi possível editar o Ponto');
        return redirect()->to('/relacao/pesquisar');
    }
    public function editarTable($id)
    {
        $equipamentosModel = new \App\Models\EquipamentosModel();
        $equipamento = $equipamentosModel->find($id);
        $data['is_admin'] = $this->session->get('isAdmin');
        $desc = $this->request->getPost('desc');
        $pontoPesquisado = $this->request->getPost('pontoPesquisado');
        $servidorPesquisado = $this->request->getPost('servidorPesquisado');
        session()->setFlashData('desc', $desc);
        session()->setFlashData('pontoPesquisado', $pontoPesquisado);
        session()->setFlashData('servidorPesquisado', $servidorPesquisado);
        if ($this->request->getMethod() === 'post') {
            $equipamento->DESCRICAOEQUIPAMENTO = $this->request->getPost('DESCRICAOEQUIPAMENTO');
            $equipamento->IP = $this->request->getPost('IP');
            $equipamento->CANAL = $this->request->getPost('CANAL');
            $equipamento->COMENTARIOEQUIPAMENTO = $this->request->getPost('COMENTARIOEQUIPAMENTO');
            $equipamento->MODOEQUIPAMENTO = $this->request->getPost('MODOEQUIPAMENTO');
            $equipamento->SOFTWAREEQUIPAMENTO = $this->request->getPost('SOFTWAREEQUIPAMENTO');
            $equipamento->MODELOEQUIPAMENTO = $this->request->getPost('MODELOEQUIPAMENTO');
            $equipamento->PONTOEQUIPAMENTO = $this->request->getPost('PONTOEQUIPAMENTO');
            $equipamento->CIDADEEQUIPAMENTO = $this->request->getPost('CIDADEEQUIPAMENTO');
            if ($equipamentosModel->update($id, $equipamento)) {
                session()->setFlashData('msg', 'Equipamento Atualizado com sucesso!');
                return redirect()->to('/relacao/pesquisar');
            } else {
                $data['errors'] = $equipamentosModel->errors();
                session()->setFlashData('msg', 'Erro ao Atualizar equipamento');
                return redirect()->to('/relacao/pesquisar');
            }
        }
        session()->setFlashData('msg', 'Não foi possível editar o equipamento');
        return redirect()->to('/relacao/pesquisar');
    }
}
