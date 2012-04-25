<?php
namespace Planeta\Autenticacao\Armazenamento;

use Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento;

class NaoPersistente implements InterfaceArmazenamento
{
    protected $dados;

    public function estaVazio()
    {
        return empty($this->dados);
    }

    public function ler()
    {
        return $this->dados;
    }

    public function escrever($conteudo)
    {
        $this->dados = $conteudo;
    }

    public function limpar()
    {
        $this->dados = NULL;
    }
}