<?php
namespace Padrao\Controlador;

use Planeta\Autenticacao,
    Planeta\Mvc\Controlador,
    \Padrao\Modelo\Postagem;

class Index extends Controlador
{
	public function index()
	{
		$postagem = new Postagem();
		$this->visao->dados = $postagem->buscarTodos();
	}
	
	public function entrar()
	{
		$this->visao->mensagem = "";
		
		if ($_POST) {
			$autenticacao = Autenticacao::pegarInstancia();
			$usuario		  = $_POST['usuario'];
			$senha		  = $_POST['senha'];
			$tabela		  = new Usuario();
			
			if ($autenticacao->autenticar($tabela, 'nome', 'senha', $usuario, $senha)) {
				header('Location: index.php?c=postagem');
			}
			$this->visao->mensagem = "Usuário ou senha inválida";
		}
	}
	
	public function sair()
	{
		Autenticacao::pegarInstancia()->limpar();
		header("Location: index.php");
	}
}


