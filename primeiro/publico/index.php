<?php
function __autoload($nomeClasse) {
	$dir = '../aplicacao/controlador';
    $localClasse = realpath($dir) . '/' . $nomeClasse . '.php';

    if (file_exists($localClasse)) {
        require($localClasse);
        return true;
    }
	return false;
}

//define o nome padrão para o controlador e a acao
$nomeControlador = "inicial";
$nomeAcao        = "inicial";

//verifica se existe parametro "controlador" e se ele tem valor
if (isset($_GET['controlador']) && $_GET['controlador']) {
    $nomeControlador = $_GET['controlador'];
}

//verifica se existe parametro "acao" e se ele tem valor
if (isset($_GET['acao']) && $_GET['acao']) {
    $nomeAcao = $_GET['acao'];
}

//padronizacao de nome
$nomeControlador = 'Controlador' . ucfirst(strtolower($nomeControlador));
$nomeAcao 		 = 'acao' . ucfirst(strtolower($nomeAcao));

//chamada da classe(controlador) e metodo(acao)
if (class_exists($nomeControlador)) {
	$controlador = new $nomeControlador;
	
	if (method_exists($controlador, $nomeAcao)) {
		$controlador->$nomeAcao();
	} else {
        echo "Acao nao encontrada.";
    }
} else {
    echo "Controlador nao encontrado.";
}