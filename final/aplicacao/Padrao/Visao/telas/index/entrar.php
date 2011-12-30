<?php echo $this->mensagem;?>
<br /><br />
<form action="index.php?c=index&a=entrar" method="post">
	<label>Nome:</label>
	<input type="text" name="usuario" />
	<br /><br />
	<label>Senha:</label>
	<input type="password" name="senha" />
	<br /><br />
	<input type="submit" value="Enviar" />
</form>