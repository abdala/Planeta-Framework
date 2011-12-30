<?php
namespace Planeta;

class Mvc
{
    protected $modulo;
    protected $controlador;
    protected $acao;
	private static $instancia;
    
    /**
     *
     * @return Mvc 
     */
	public static function pegarInstancia()
	{
		if (!self::$instancia) {
			self::$instancia = new Mvc();
		}
		
		return self::$instancia;
	}
	
	private function __construct() 
	{}
    
    public function pegarModulo() 
    {
        return $this->modulo;
    }
    
    public function pegarControlador() 
    {
        return $this->controlador;
    }
    
    public function pegarAcao() 
    {
        return $this->acao;
    }

    public function rodar()
	{
		//pega o modulo, controlador e acao 
		$modulo      = isset($_GET['m']) ? $_GET['m'] : 'padrao';
		$controlador = isset($_GET['c']) ? $_GET['c'] : 'index';
		$acao		 = isset($_GET['a']) ? $_GET['a'] : 'index';
		
		//padronizacao de nomes
		$this->modulo      = ucfirst(strtolower($modulo));
		$this->controlador = ucfirst(strtolower($controlador));
		$this->acao 	   = strtolower($acao);
		
        $nomeClasseControlador = '\\'. $this->modulo . '\\Controlador\\' . $this->controlador;
		
        //verifica se a classe existe
		if (class_exists($nomeClasseControlador)) {
			$controladorObjeto = new $nomeClasseControlador;
			
			//verifica se o metodo existe
			if (method_exists($controladorObjeto, $this->acao)) {
				$controladorObjeto->{$this->acao}();
				
				//verifica se pode renderizar a view automatimente
				if ($controladorObjeto->comVisaoAutomatica()) {
					$controladorObjeto->renderizar();
				}
				return true;
			}
			throw new \Exception('Acao nao existente.');
		}
		throw new \Exception('Controlador nao existente.');
	}
    
    private function __clone() 
	{
		throw \Exception('Nao pode');
	}
}