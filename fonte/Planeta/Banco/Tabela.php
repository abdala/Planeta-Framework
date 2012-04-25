<?php
namespace Planeta\Banco;

class Tabela
{
    protected $nome;
    protected $chave;
    protected $banco;

    public function __construct(Banco $banco, $nome, $chave = 'id')
    {
        $this->definirBanco($banco);
        $this->definirNome($nome);
        $this->definirChave($chave);
    }

    public function pegarNome()
    {
        return $this->nome;
    }

    public function definirNome($nome)
    {
        $this->nome = $nome;
    }

    public function pegarChave()
    {
        return $this->chave;
    }

    public function definirChave($chave)
    {
        $this->chave = $chave;
    }

    /**
     *
     * @return Banco
     */
    public function pegarBanco()
    {
        return $this->banco;
    }

    public function definirBanco(Banco $banco)
    {
        $this->banco = $banco;
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
        $campos = array_keys($dados);
        $sql    = "INSERT INTO %s(%s) VALUES(:%s)";
        $sql    = sprintf($sql, $this->nome, \implode(",", $campos), \implode(",:", $campos));

        $confirmacao = $this->pegarBanco()->pegarConexao()->prepare($sql);
        return $confirmacao->execute($dados);
    }

    public function atualizar($dados)
    {
        $set = "";
        $id  = $dados[$this->chave];

        unset($dados[$this->chave]);

        $campos = array_keys($dados);

        foreach ($campos as $campo) {
            $set .= sprintf("%s = :%s, ", $campo, $campo);
        }

        $set = substr($set, 0, strlen($set)-2);
        $sql = "UPDATE %s SET %s WHERE %s = %d";
        $sql = sprintf($sql, $this->nome, $set, $this->chave, $id);

        $confirmacao = $this->pegarBanco()->pegarConexao()->prepare($sql);
        return $confirmacao->execute($dados);
    }
}