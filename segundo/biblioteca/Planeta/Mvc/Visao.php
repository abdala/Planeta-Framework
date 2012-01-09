<?php
class Planeta_Mvc_Visao
{
	public function renderizar($diretorio, $arquivo)
	{
        $local  = '../aplicacao/visao/';
		require $local . $diretorio . '/' . $arquivo;
	}
}