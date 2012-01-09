<?php
ini_set('display_errors', 1);

require '../biblioteca/Planeta/CarregadorAutomatico.php';

Planeta_CarregadorAutomatico::registrar();
Planeta_Mvc::pegarInstancia()->rodar();