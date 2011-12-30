<?php
namespace Padrao\Controlador;

use \Padrao\Modelo\Postagem as Modelo;

class Postagem extends \Planeta\Mvc\Controlador
{
	//listar os dados
	public function index()
	{
		$postagem = new Modelo();
		$this->visao->dados = $postagem->buscarTodos();
	}
	
	//mostrar o formulario
	public function formulario()
	{
		$id    = isset($_GET['id']) ? (int) $_GET['id']: null;
		$dados = array('id' => '', 'nome' => '', 'descricao' => '');
		
		if ($id) {
			$postagem = new Modelo();
			$dados = $postagem->buscar($id);
		}
		
		$this->visao->dados = $dados;
	}
	
	//salvar no banco
	public function salvar()
	{
		if ($_POST) {
			$dados 	  = $_POST;
			$postagem = new Modelo();
			
			if ($dados['id']) {
				$postagem->atualizar($dados);
			} else {
				$postagem->inserir($dados);
			}
		}
		header('Location: index.php?c=postagem');
	}
	
	//excluir do banco
	public function excluir()
	{
		$id       = (int) $_GET['id'];
		$postagem = new Modelo();
		
		$postagem->excluir($id);
		
		header('Location: index.php?c=postagem');
	}
}