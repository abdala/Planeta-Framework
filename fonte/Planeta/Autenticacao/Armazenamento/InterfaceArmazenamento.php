<?php
namespace Planeta\Autenticacao\Armazenamento;

interface InterfaceArmazenamento
{
    public function estaVazio();

    public function ler();

    public function escrever($conteudo);

    public function limpar();
}