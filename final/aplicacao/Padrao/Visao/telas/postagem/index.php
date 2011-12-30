<a class="btn" href="index.php?c=postagem&a=formulario">Novo</a>
<br /><br />
<table class="zebra-striped">
	<tr>
		<th>Nome</th>
		<th>Descricao</th>
		<th></th>
	</tr>
	<?php foreach($this->dados as $dados):?>
		<tr>
			<td><?php echo $dados['nome']?></td>
			<td><?php echo $dados['descricao']?></td>
			<td>
				<a href="index.php?c=postagem&a=formulario&id=<?php echo $dados['id']?>">Editar</a> | 
				<a href="index.php?c=postagem&a=excluir&id=<?php echo $dados['id']?>">Excluir</a> 
			</td>
		</tr>
	<?php endforeach;?>
</table>