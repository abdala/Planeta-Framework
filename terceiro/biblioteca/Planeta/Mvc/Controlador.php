<?php
class Planeta_Mvc_Controlador
{
	protected $visao;
	
	public function __construct() 
	{
		$this->visao = new Planeta_Mvc_Visao();
	}
	
	public function renderizar()
	{
		$diretorio = strtolower(Planeta_Mvc::pegarInstancia()->pegarControlador());
		$arquivo   = strtolower(Planeta_Mvc::pegarInstancia()->pegarAcao()) . ".php";
		
		$this->visao->renderizar($diretorio, $arquivo);
	}
}