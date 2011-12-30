<?php
namespace Planeta;

class Autenticacao
{
	private static $instancia;
	
	public static function pegarInstancia()
	{
		if (!self::$instancia) {
			self::$instancia = new Autenticacao();
		}
		
		return self::$instancia;
	}
	
	private function __construct() 
	{
		session_start();
	}
	
	public function autenticar(Banco\Tabela $tabela, $nomeColunaUsuario, $nomeColunaSenha, $usuario, $senha)
	{
		$sql = "SELECT * FROM %s WHERE %s = '%s' AND %s = '%s'";
		$sql = sprintf($sql, $tabela->pegarNome(), 
					   $nomeColunaUsuario, $usuario,
					   $nomeColunaSenha, $senha);
					   
		$resultado = $tabela->pegarBanco()->pegarConexao()->query($sql)->fetch();
		
		if ($resultado) {
			$_SESSION['autenticacao'] = $resultado;
			return true;
		}
		return false;
	}
	
	public function estaAutenticado()
	{
		return (bool) count($_SESSION['autenticacao']);
	}
	
	public function limpar()
	{
		unset($_SESSION['autenticacao']);	
	}
	
	private function __clone() 
	{
		throw Exception('Nao pode');
	}
}