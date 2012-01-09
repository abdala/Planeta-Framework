<?php
class ControladorInicial extends Planeta_Mvc_Controlador
{
    public function acaoInicial() 
    {
        $this->visao->titulo = "Blog Planeta Framework";
        $this->renderizar();
    }
}