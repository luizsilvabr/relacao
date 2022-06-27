<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Usuarios extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->session = \Config\Services::session();
	}
	public function index()
	{
		if (session('isLoggedIn')) {
			return redirect()->to(base_url('/relacao'));
		} else {
			return view('login');
		}
	}

	public function signIn()
	{
		$nome = $this->request->getPost('USUARIO');
		$password = $this->request->getPost('SENHA');
		$usuariosModel = new \App\Models\UsuariosModel();
		$dadosUsuario = $usuariosModel->getByNome($nome);
		if (count($dadosUsuario) > 0) {
			$senha = $dadosUsuario['SENHA'];
			if ($password === $senha) {
				session()->set('isLoggedIn', true);
				session()->set('isAdmin', $dadosUsuario['TYPE']);
				session()->setFlashData('msgLogin', 'Login efetuado com sucesso!');
				return redirect()->to(base_url('/relacao'));
			} else {
				session()->setFlashData('msg', 'Usuário ou Senha incorretos');
				return redirect()->to('/login');
			}
		} else {
			session()->setFlashData('msg', 'Usuário ou Senha incorretos');
			return redirect()->to('/login');
		}
	}

	public function signOut()
	{
		unset($_SESSION['isLoggedIn']);
		session()->setFlashData('msgLogin', 'Logout efetuado com sucesso!');
		return redirect()->to(base_url('/login'));
	}
}
