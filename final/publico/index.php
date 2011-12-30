<?php
ini_set('display_errors', 1);

require '../biblioteca/Planeta/CarregadorAutomatico.php';

Planeta\CarregadorAutomatico::registrar();
Planeta\Mvc::pegarInstancia()->rodar();