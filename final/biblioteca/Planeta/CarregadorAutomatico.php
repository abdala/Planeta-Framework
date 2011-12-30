<?php
namespace Planeta;

class CarregadorAutomatico
{
	public static function carregar($nomeDaClasse)
	{
		$diretorios = array('../aplicacao', 
						    '../biblioteca');
		
		$nomeDaClasse = str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $nomeDaClasse);
		
		foreach ($diretorios as $diretorio) {
			$localDaClasse = realpath($diretorio) 
						   . DIRECTORY_SEPARATOR 
						   . $nomeDaClasse . ".php";
			
			if (file_exists($localDaClasse)) {
				require($localDaClasse);
				return true;
			}
		}
		return false;
	}
	
	public static function registrar()
	{
		spl_autoload_register('Planeta\CarregadorAutomatico::carregar');
	}
}