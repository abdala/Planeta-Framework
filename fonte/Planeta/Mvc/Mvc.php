<?php
namespace Planeta\Mvc;

use Planeta\Mvc\Excecao\ControladorNaoExiste,
    Planeta\Mvc\Excecao\AcaoNaoExiste;

class Mvc
{
    protected $modulo;
    protected $controlador;
    protected $acao;

    public function __construct($modulo, $controlador, $acao)
    {
        $this->definirModulo($modulo);
        $this->definirControlador($controlador);
        $this->definirAcao($acao);
    }

    public function pegarModulo()
    {
        return $this->modulo;
    }

    public function definirModulo($modulo)
    {
        $this->modulo = strtolower($modulo);
    }

    public function pegarControlador()
    {
        return $this->controlador;
    }

    public function definirControlador($controlador)
    {
        $this->controlador = strtolower($controlador);
    }

    public function pegarAcao()
    {
        return $this->acao;
    }

    public function definirAcao($acao)
    {
        $this->acao = strtolower($acao);
    }

    public function criarObjetoControlador()
    {
        $nomeClasseControlador = '\\'. ucfirst($this->pegarModulo())
                               . '\\Controlador\\'
                                . ucfirst($this->pegarControlador());

        //verifica se a classe existe
        if (class_exists($nomeClasseControlador)) {
            $controlador = new $nomeClasseControlador();
            return $controlador;
        }

        throw new ControladorNaoExiste('Controlador nao existente.');
    }

    public function chamarAcao(Controlador $controlador)
    {
        $acao = "acao" . ucfirst($this->pegarAcao());
        //verifica se o metodo existe
        if (method_exists($controlador, $acao)) {
            call_user_method($acao, $controlador);

            //verifica se pode renderizar a view automatimente
            if ($controlador->comVisaoAutomatica()) {
                return $controlador->renderizar($this->pegarControlador(), $this->pegarAcao());
            }
            return TRUE;
        }
        throw new AcaoNaoExiste('Acao nao existente.');
    }

    public function rodar($pastaAplicacao)
    {
        $pastaPadraoVisao = $pastaAplicacao . '/' . $this->pegarModulo() . '/Visao/telas';

        $visao = new Visao();
        $visao->adicionarPasta($pastaPadraoVisao);

        $controlador = $this->criarObjetoControlador();
        $controlador->definirVisao($visao);

        return $this->chamarAcao($controlador);
    }
}