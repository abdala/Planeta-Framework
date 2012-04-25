<?php
namespace Padrao\Controlador;

use Planeta\Mvc\Controlador;

class Inicial extends Controlador
{
	public function acaoInicial()
	{
        $this->visao->dados = array(array("nome" => "Nome", 
                                          "descricao" => "Descricao"));
		//criado para testar
	}
}