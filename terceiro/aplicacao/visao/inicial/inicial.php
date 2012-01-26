<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="keywords" content="html css php planeta programacao">
		<meta http-equiv="description" content="Arquivo de demonstração">
		<title>Planeta Framework</title>
	</head>
    <body>
        <h1>Inicial do blog</h1>
        <p>Página com conteúdo dinâmico</p>
        <br />
        <?php foreach($this->dados as $dados):?>
            <div class="post-item">
                <h3><?php echo $dados['nome']?></h3>
                <p><?php echo $dados['descricao']?></p>
            </div>
            <br />
        <?php endforeach;?>
    </body>
</html>