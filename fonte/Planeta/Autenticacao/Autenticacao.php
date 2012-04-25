<?php
namespace Planeta\Autenticacao;

use Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento,
    Planeta\Banco\Tabela;

class Autenticacao
{
    protected $armazenamento;

    public function __construct(InterfaceArmazenamento $armazenamento)
    {
        $this->armazenamento = $armazenamento;
    }

    public function definirArmazenamento(InterfaceArmazenamento $armazenamento)
    {
        $this->armazenamento = $armazenamento;
    }

    public function pegarArmazenamento()
    {
        return $this->armazenamento;
    }

    public function autenticar(Tabela $tabela, $nomeColunaUsuario, $nomeColunaSenha, $usuario, $senha)
    {
        $sql = "SELECT * FROM %s WHERE %s = '%s' AND %s = '%s'";
        $sql = sprintf($sql, $tabela->pegarNome(),
                       $nomeColunaUsuario, $usuario,
                       $nomeColunaSenha, $senha);

        $resultado = $tabela->pegarBanco()->pegarConexao()->query($sql)->fetch();

        if ($resultado) {
            $this->armazenamento->escrever($resultado);
            return TRUE;
        }
        return FALSE;
    }

    public function pegarDados()
    {
        return $this->armazenamento->ler();
    }

    public function estaAutenticado()
    {
        return $this->armazenamento->estaVazio();
    }

    public function limpar()
    {
        $this->armazenamento->limpar();
    }
}