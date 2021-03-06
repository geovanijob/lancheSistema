<?php
include "menu.php";
verificaPermissao();

if (isset($_GET["id"])) {
    $id = trim($_GET["id"]);
    $sql = "SELECT * FROM promocao WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        $prodCod = $dados->id;
        $titulo = $dados->titulo;
        $datainicio = $dados->data_inicio;
        $datatermino = $dados->data_fim;
        $total = $dados->total;
        $imagem = $dados->imagem;
    } else {
        $imagem = $id = $titulo = $datainicio = $datatermino = $total = $prodCod = "";
    }
} else {
    $imagem = $id = $titulo = $datainicio = $datatermino = $total = $prodCod = "";
}
?>

<div class="container well">
    <h1>Cadastro de Promoção</h1>
    <a href="listarPromocao.php" class="btn btn-default pull-right">
        <i class="glyphicon glyphicon-search"></i> Listar Promoções
    </a>
    <div class="clearfix"></div><br>
    <form method="POST" action="salvarPromocao.php" enctype="multipart/form-data">

        <div class="row well">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="col-md-6" id="promol">
                <br><br><br>
                <div class="control-group">
                    <label>Titulo</label>
                    <div class="controls">
                        <input type="text" name="titulo" class="form-control" 
                               placeholder="Informe um Titulo Para a Promoção" required value="<?= $titulo; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label>Data de Início</label>
                    <div class="controls">
                        <input type="date" name="data_inicio" id="data_inicio" class="form-control" required value="<?= $datainicio; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label>Data de Término</label>
                    <div class="controls">
                        <input type="date" name="data_fim" id="data_fim"  class="form-control" required value="<?= $datatermino; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label>Imagem</label>
                    <div class="controls">
                        <input type="file" name="imagem_principal" class="form-control" value="<?= $imagem; ?>">
                        <input type="hidden" name="imagem_principal" value="<?= $imagem; ?>">
                    </div>
                </div>

            </div>

            <div class="col-md-6" align="center">
                <h3 class="titulo">Selecione os Produtos</h3>
                <?php
                if ($prodCod == "") {
                    echo '<select multiple="multiple" id="select-promo" name="produtosPromo[]" class="form-control">';
                } else {
                    echo '<select multiple="multiple" id="select-promo" name="produtosPromo[]" class="form-control" disabled>';
                }
                ?>

                <?php
                $sql = "SELECT * FROM produto WHERE ativo = 1 ORDER BY id_categoria";
                $consulta = $pdo->prepare($sql);
                $consulta->execute();
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='$dados->id'>$dados->nome</option>";
                }
                ?>
                </select>
                <br>

                <div class="col-md-10 col-md-offset-1">
                    <div class="control-group">
                        <label>Total:</label>
                        <div class="controls">
                            <input type="text" name="total" class="form-control valor" placeholder="Valor Total" required value="<?= $total; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-warning pull-right">Salvar</button>
        </div>
    </form>
</div>


<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
        crossorigin="anonymous">
</script>-->
<script src="../js/jquery-ui.js"></script>
<script>
    $('#select-promo').multiSelect();
</script>