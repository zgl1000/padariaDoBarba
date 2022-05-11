<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
</head>

<body>
    <h1>Produtos da Padaria</h1>

    

    <table class="table table-striped">
        <thead>
            <tr>
                <?php 
                    if($usuarioLogado){
                        echo "
                        <th>Alterar</th>
                        <th>Excluir</th>
                        ";
                    }
                ?>
                
                <th>Nome</th>
                <th>Perecível</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Imagem</th>
            </tr>
            <?php echo $tabela; ?>
        </thead>

    </table>

    <div class="row">

    <?php 
        if($usuarioLogado){
            echo "<div style='margin: 15px 0;'>   
            <a 
                href='/produto/formnovo'
                class='btn btn-primary'
            >
                Novo
            </a>
        </div>";
        }
    ?>
    </div>
</body>

</html>