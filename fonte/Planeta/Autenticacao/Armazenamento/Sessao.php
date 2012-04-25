<?php
namespace Planeta\Autenticacao\Armazenamento;

use Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento;

class Sessao implements InterfaceArmazenamento
{
    const CHAVE_DA_SESSAO = "autenticacao";

    public function __construct()
    {
        $_SESSION[static::CHAVE_DA_SESSAO] = array();
    }

    public function estaVazio()
    {
        return isset($_SESSION[static::CHAVE_DA_SESSAO]) && !$_SESSION[static::CHAVE_DA_SESSAO];
    }

    public function ler()
    {
        if ($this->estaVazio()) {
            return NULL;
        }

        return $_SESSION[static::CHAVE_DA_SESSAO];
    }

    public function escrever($conteudo)
    {
        $_SESSION[static::CHAVE_DA_SESSAO] = $conteudo;
    }

    public function limpar()
    {
        $_SESSION[static::CHAVE_DA_SESSAO] = NULL;
    }
}