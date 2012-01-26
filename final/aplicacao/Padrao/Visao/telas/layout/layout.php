<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="keywords" content="html css php tst programacao">
		<meta http-equiv="description" content="Arquivo de demonstração de utilização de CSS">
		<title>Planeta Framework</title>
		<link rel="stylesheet" type="text/css" href="estilo/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
	</head>
	<body>
		<div class="topbar topbar-inner">
			<div class="container">
				<h3><a href="#">Blog</a></h3>
				<ul class="nav">
		            <li class="active"><a href="index">Home</a></li>
		            <li><a href="?c=postagem">Postagem</a></li>
		         </ul>
		    </div>
		</div>
		<div class="container">
			<div class="content">
				<?php echo $this->conteudo?>
			</div>
	    </div>
	    <br /><br />
	</body>
</html>