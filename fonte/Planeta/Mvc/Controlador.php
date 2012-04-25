<?php
namespace Planeta\Mvc;

class Controlador
{
    protected $visao;
    protected $visaoAutomatica = TRUE;

    public function comVisaoAutomatica()
    {
        return $this->pegarVisaoAutomatica();
    }

    public function definirVisaoAutomatica($visaoAutomatica)
    {
        $this->visaoAutomatica = (bool)$visaoAutomatica;
    }

    public function pegarVisaoAutomatica()
    {
        return $this->visaoAutomatica;
    }

    public function definirVisao(Visao $visao)
    {
        $this->visao = $visao;
    }

    public function pegarVisao()
    {
        return $this->visao;
    }

    public function renderizar($controlador, $acao)
    {
        $diretorio = strtolower($controlador);
        $arquivo   = strtolower($acao) . ".php";

        $this->visao->conteudo = $this->visao->renderizar($diretorio, $arquivo);
        return $this->visao->renderizar('layout', 'layout.php');
    }
}