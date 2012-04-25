<?php
namespace Planeta\Mvc;

use Planeta\Mvc\Excecao\VisaoNaoExiste;

class Visao
{
    protected $pastas = array();

    public function adicionarPasta($pasta)
    {
        $this->pastas[] = $pasta;
    }

    public function pegarPastas()
    {
        return $this->pastas;
    }

    public function removerPasta($pasta)
    {
        $key = array_search($pasta, $this->pastas);
        if ($key !== FALSE) {
            unset($this->pastas[$key]);
        }
    }

    public function renderizar($diretorio, $arquivo)
    {
        ob_start();
        foreach ($this->pastas as $pasta) {
            $caminhoArquivo = $pasta . '/' . $diretorio . '/' . $arquivo;
            if (file_exists($caminhoArquivo)) {
                require $caminhoArquivo;
                return ob_get_clean();
            }
        }
        throw new VisaoNaoExiste("Visao nao encontrada. " . var_export($this->pastas, TRUE));
    }
}