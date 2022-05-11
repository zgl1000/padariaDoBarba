<section class="section">
    <?php echo validation_errors('
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-3">
                                <label class="text-danger">', '</label>
                            </div>
                        </div>
                    </div>')
    ?>

    <?php echo form_open('produto/alterar?codigo=' . "$produto->id") ?>

    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Alterar Produto</h5>

                    <!-- Horizontal Form -->
                    <form action="/produto/salvaralteracao" method="post">
                        <input type="hidden" name="id" value="<?php echo $produto->id; ?>">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nome</label>
                            <div class="col-sm-4">
                                <input type="text" name="nome" class="form-control" value="<?php echo $produto->nome; ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputCor" class="col-sm-2 col-form-label">Perecível</label>
                            <div class="col-sm-2">
                                <select id="perecivel" name="perecivel" class="form-select">
                                    <optio value="">Selecione a opção</option>
                                    <option <?php if($produto->perecivel) echo "selected='' " ?> value="S">Sim</option>
                                    <option <?php if(!$produto->perecivel) echo "selected='' " ?> value="N">Não</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputTipo" class="col-sm-2 col-form-label">Tipo</label>
                            <div class="col-sm-2">
                                <select id="tipo" name="tipo_produto" class="form-select">
                                    <?php echo $opcoesTipos ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Valor</label>
                            <div class="col-sm-2">
                                <input type="text" name="valor" class="form-control" value="<?php echo $produto->valor; ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Imagem</label>
                            <div class="col-sm-6">
                                <input type="text" name="imagem" class="form-control" value="<?php echo $produto->imagem; ?>">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="/produto" style="text-decoration: none;" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form><!-- End Horizontal Form -->

                </div>
            </div>
        </div>
    </div>
</section>