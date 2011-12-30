<?php
namespace Planeta\Banco;

abstract class Tabela
{
	protected $nome;
	protected $chave;
	
	public function pegarNome()
	{
		return $this->nome;
	}
	
    /**
     *
     * @return \Planeta\Banco
     */
	public function pegarBanco()
	{
		return \Planeta\Banco::pegarInstancia();
	}
	
	public function buscarTodos()
	{
		$sql = sprintf("SELECT * FROM %s", $this->nome);
		return $this->pegarBanco()->pegarConexao()->query($sql)->fetchAll();
	}
	
	public function buscar($id)
	{
		$sql = sprintf("SELECT * FROM %s WHERE %s = %d", $this->nome, $this->chave, $id);
		return $this->pegarBanco()->pegarConexao()->query($sql)->fetch();
	}
	
	public function excluir($id)
	{
		$sql = sprintf("DELETE FROM %s WHERE %s = %d", $this->nome, $this->chave, $id);
		return $this->pegarBanco()->pegarConexao()->exec($sql);
	}
	
	public function inserir($dados)
	{
		unset($dados[$this->chave]);
		$campos  = array_keys($dados);
		$sql     = "INSERT INTO %s(%s) VALUES(:%s)";
		$sql     = sprintf($sql, $this->nome, \implode(",", $campos), \implode(",:", $campos));
		
		$confirmacao = $this->pegarBanco()->pegarConexao()->prepare($sql);
		return $confirmacao->execute($dados);
	}
	
	public function atualizar($dados)
	{
		$set = "";
		$id  = $dados[$this->chave];  
        
		unset($dados[$this->chave]);
		
		foreach ($dados as $campo => $valor) {
			$set .= sprintf("%s = :%s, ", $campo, $campo);
		}
		
		$set = substr($set, 0, strlen($set)-2);
		$sql = "UPDATE %s SET %s WHERE %s = %d";
		$sql = sprintf($sql, $this->nome, $set, $this->chave, $id);
		
        $confirmacao = $this->pegarBanco()->pegarConexao()->prepare($sql);
		return $confirmacao->execute($dados);
	}
}