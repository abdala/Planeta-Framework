<?php
namespace Planeta\Mvc;

class Visao
{
	public function renderizar($diretorio, $arquivo)
	{
		ob_start();
        $modulo = \Planeta\Mvc::pegarInstancia()->pegarModulo();
        $local  = '../aplicacao/' . $modulo . '/Visao/telas/';
		require $local . $diretorio . '/' . $arquivo;
		return ob_get_clean();
	}
}