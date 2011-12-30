<form action="?c=postagem&a=salvar" method="post">
	<input type="hidden" name="id" value="<?php echo $this->dados['id']?>" />
    <div class="clearfix">
		<label>Nome:</label>
        <div class="input">
            <input name="nome" class="xxlarge" value="<?php echo $this->dados['nome']?>" />
        </div>
	</div>
    <div class="clearfix">
		<label>Descrição:</label>
        <div class="input">
            <textarea name="descricao" rows="7" class="xxlarge"><?php echo $this->dados['descricao']?></textarea>
        </div>
	</div>
    <div class="clearfix">
        <div class="input">
            <input type="submit" value="Salvar" class="btn primary" />
        </div>
	</div>
</form>