<?php
namespace Planeta\Mvc;

class Controlador
{
	protected $visao;
	protected $visaoAutomatica = true;
	
	public function __construct() 
	{
		$this->visao = new Visao();
	}
	
	public function comVisaoAutomatica()
	{
		return $this->visaoAutomatica;
	}
	
	public function renderizar()
	{
		$diretorio = strtolower(\Planeta\Mvc::pegarInstancia()->pegarControlador());
		$arquivo   = strtolower(\Planeta\Mvc::pegarInstancia()->pegarAcao()) . ".php";
		
		$this->visao->conteudo = $this->visao->renderizar($diretorio, $arquivo);
		echo $this->visao->renderizar('layout', 'layout.php');
	}
}