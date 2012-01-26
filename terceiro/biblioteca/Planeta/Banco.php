<?php
class Planeta_Banco
{
	private $conexao;
	private static $instancia;
	
	public static function pegarInstancia()
	{
		if (!self::$instancia) {
			self::$instancia = new Planeta_Banco();
		}
		
		return self::$instancia;
	}
	
	public function pegarConexao()
	{
		return $this->conexao;
	}
	
	private function __construct() 
	{
		$this->conexao = new PDO('mysql:dbname=blog;host=127.0.0.1', 
                                  'root', 
                                  '123456', 
                                  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
	}
	
	private function __clone() 
	{
		throw Exception('Nao pode');
	}
}