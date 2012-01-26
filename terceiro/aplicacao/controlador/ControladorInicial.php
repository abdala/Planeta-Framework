<?php
class ControladorInicial extends Planeta_Mvc_Controlador
{
    public function acaoInicial() 
    {
        $postagem = new Postagem();
        $this->visao->dados = $postagem->buscarTodos();
        $this->renderizar();
    }
}