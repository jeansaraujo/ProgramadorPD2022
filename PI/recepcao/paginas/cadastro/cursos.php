<h1 style="text-align:center;">
    Cursos
</h1>
<hr>
<?php
$sqlselect = $conexao->PREPARE("SELECT * FROM categoria");
$sqlselect->execute();
$resultado = $sqlselect->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
if(isset($_GET['alterpag'])){
    $alterpag = $_GET['alterpag'];
    if($alterpag == "ant"){
        $paginacao=$paginacao-limitCursos;
        print $paginacao." / ".limitCursos; 
    }
    if($alterpag == "prox"){
        $paginacao=$paginacao+limitCursos;
        print $paginacao." / ".limitCursos;
    }
}    
if (isset($_POST['sucesso'])) {
    $sucesso = $_POST['sucesso'];
    if ($sucesso == "true") {
        print "
                <div style='width:60vw; margin:auto; font-size:1.2em; padding:5px; border: solid 2px green; border-radius:10px; background:lightgreen;'>
                    <p style='text-align:center; color:darkgreen; font-weight:900;'>
                        Cadastro realizado com sucesso!
                    </p>
                </div>
            ";
    }
}
?>
<div class="row col d-flex justify-content-center mb-4">
    <form method="POST">
        <input class="form-control" type="hidden" name="pagina" value="cadastro">
        <input class="form-control" type="hidden" name="cad" value="curso">
        <input class="form-control" type="hidden" name="sucesso" value="true">
        <?php
        if (isset($ratualiza)) {
            print "<input class='form-control' type='hidden' name='atualizar' value='" . $edicao . "'>";
        }
        ?>
        <div class="row">
            <div class="col">
                <label class="label-control">
                    Nome
                </label>
                <input class="form-control mb-2" type="text" name="nomeCurso">
            </div>
            <div class="col">
                <label class="label-control">
                    Categoria
                </label>
                <select class="form-control" name="categoria">
                    <?php
                    foreach ($resultado as $res) {
                        print "<option value=";
                        print $res['id'] . ">";
                        print $res['nome'] . " / " . $res['modalidade'];
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="label-control">
                    Data de Inicio
                </label>
                <input class="form-control" type="date" name="dataInicio">
            </div>
            <div class="col">
                <label class="label-control">
                    Data de Fim
                </label>
                <input class="form-control" type="date" name="dataFim">
            </div>
            <div class="col">
                <label class="label-control">
                    Carga Horária
                </label>
                <input class="form-control" type="number" name="cargahoraria">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="label-control">
                    Capacidade
                </label>
                <input class="form-control" type="number" name="capacidade">
            </div>
            <div class="col">
                <label class="label-control">
                    Disponilibidade
                </label>
                <select class="form-control" name="disponibilidade">
                    <option value="manha">Manhã</option>
                    <option value="tarde">Tarde</option>
                    <option value="noite">Noite</option>
                </select>
            </div>
            <div class="col d-flex justify-content-center align-items-end">
                <button class="btn btn-outline-primary">
                    Cadastrar
                </button>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs">
            <?php
                if(isset($_GET['catcurso'])){
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="?pagina=cadastro&cad=curso">Todos</a>
                </li>            
            <?php
                }
                else{
            ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="?pagina=cadastro&cad=curso">Todos</a>
                </li>
            <?php
                }
            ?>
            <?php
                $sqlselect = $conexao->PREPARE("SELECT nome AS 'categoria' ,count(*) AS 'qtd' FROM categoria GROUP BY nome");
                $sqlselect->execute();
                $categorias = $sqlselect->fetchAll(PDO::FETCH_ASSOC);
                foreach($categorias as $cat){
                    $catn = $cat["categoria"];
                    print "
                        <li class='nav-item'>
                            <a class='nav-link' href='?pagina=cadastro&cad=curso&catcurso=$catn'>".$cat["categoria"]."</a>
                        </li>
                    ";
                }
            ?>   
        </ul>
    </div>
    <div class="col-12">
        <?php
            $selectQtdCursos = $conexao->PREPARE("select count(*) AS 'qtd' from cursos");
            $selectQtdCursos->execute();
            $qtdCursos =  $selectQtdCursos->fetchAll(PDO::FETCH_ASSOC);
            $qCursos = $qtdCursos[0]["qtd"];
            $paginacao = "0";
            $paginacao=isset($_GET["paginacao"])?$_GET["paginacao"]:"0";
            $categoria=isset($_GET['catcurso'])?$_GET['catcurso']:"0";
            if(isset($_GET['catcurso'])){
                $selectCursos = $conexao->PREPARE("select cursos.id, cursos.nome, categoria.nome as 'categoria', categoria.modalidade FROM cursos join categoria ON cursos.categoria_id = categoria.id WHERE categoria.nome ='".$categoria."' order by categoria.nome LIMIT ".limitCursos ." OFFSET ".$paginacao);
            }
            else{
                $selectCursos = $conexao->PREPARE("select cursos.id, cursos.nome, categoria.nome as 'categoria', categoria.modalidade FROM cursos join categoria ON cursos.categoria_id = categoria.id order by categoria.nome LIMIT ".limitCursos ." OFFSET ".$paginacao);
            }
            $selectCursos->execute();
            $cursos = $selectCursos->fetchAll(PDO::FETCH_ASSOC);
            if(isset($_GET['catcurso'])){
                $selectQtdCursos = $conexao->PREPARE("select count(*) AS 'qtd' from cursos join categoria on cursos.categoria_id = categoria.id WHERE categoria.nome ='".$categoria."'");
                $selectQtdCursos->execute();
                $qtdCursos =  $selectQtdCursos->fetchAll(PDO::FETCH_ASSOC);
                $qCursos = $qtdCursos[0]["qtd"];
            }
            if(($qCursos%limitCursos)==0){
                $paginas = intval($qCursos/limitCursos);    
            }
            else{
                $paginas = intval($qCursos/limitCursos)+1;
            }
            print $paginas;
            if ($qCursos!=0){
        ?>
        <table class="table table-striped">
            <thead>
                <tr style="font-weight:900; text-align:center;">
                    <td>id</td>
                    <td>Curso</td>
                    <td>Categoria</td>
                    <td>Modalidade</td>
                    <td>Ações</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $item = 1;
                foreach ($cursos as $curso) {
                    print
                        "
                            <tr style='text-align:center;'>
                                <td>" . ($item++) . "</td>
                                <td>" . $curso['nome'] . "</td>
                                <td>" . $curso['categoria'] . "</td>
                                <td>" . $curso['modalidade'] . "</td>
                                <td>" . "
                                    <a href='?pagina=cadastro&cad=curso&editar=" . $curso['id'] . "'><i style='color:orange;'class='fa-solid fa-pencil'></i></a>
                                    <a href='?pagina=cadastro&cad=curso&excluir=" . $curso['id'] . "'><i style='color:red;' class='fa-solid fa-trash'></i></a> 
                                    <a href='?pagina=cadastro&cad=curso&detalhes=" . $curso['id'] . "'><i style='color:blue;'class='fa-solid fa-eye'></i></a>" . "</td>
                            </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-12 d-flex justify-content-center align-items-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                $lim = $paginacao-limitCursos;
                if($paginacao==0){
                    print"
                    <li class='page-item disabled'><a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$lim'>Anterior</a></li>
                    ";
                }
                else{
                    print"
                    <li class='page-item'><a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$lim'>Anterior</a></li>
                    ";
                }
                ?>                
                <?php                     
                    for($i = 0; $i<$paginas ;$i++){
                        $p = limitCursos * $i;
                        if($p==$paginacao){
                            print
                            "<li class='page-item active'>
                                <a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$p'>"
                                    .($i+1)."
                                </a>
                            </li>";
                        }
                        else{
                            print 
                            "<li class='page-item'>
                                <a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$p'>"
                                    .($i+1)."
                                </a>
                            </li>";
                        }
                    }
                ?>                
                <?php
                $lim = $paginacao+limitCursos;
                $posicao = (intval($qCursos/limitCursos))*limitCursos;
                if($paginacao==$posicao){
                    print"
                    <li class='page-item disabled'><a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$lim'>Proximo</a></li>
                    ";
                }
                else{
                    print"
                    <li class='page-item'><a class='page-link' href='?pagina=cadastro&cad=curso&paginacao=$lim'>Proximo</a></li>
                    ";
                }
                ?>
            </ul>
            <?php
            }
            else{
                print "<p class='h2 text-center text-danger'>não a itens para essa categoria</p>";
            }
            ?>
        </nav>
        <!--
            Desafio .... alterar paginação
        <form action="?alt=paginacao">            
            <input type="number" step="5" length="5" class="form-control">
            <button class="btn btn-primary">
                Mudar Paginação 
            </button>
        </form>
        -->
    </div>
</div>