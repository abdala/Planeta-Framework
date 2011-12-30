<h1>Inicial do blog</h1>
<p>Essa página tem conteúdo dinâmico</p>
<br />
<?php foreach($this->dados as $dados):?>
<div class="post-item">
		<h3><?php echo $dados['nome']?></h3>
		<p><?php echo $dados['descricao']?></p>
	</div>
	<br />
<?php endforeach;?>
