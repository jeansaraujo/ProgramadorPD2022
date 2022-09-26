<h1>
    Cursos
</h1>
<?php
    $conexao = new PDO("mysql:dbname=recepcao;host=localhost","root","");
    $sqlselect = $conexao->PREPARE("SELECT * FROM categoria");
    $sqlselect->execute();
    $resultado=$sqlselect->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
    if(isset($_POST['sucesso'])){
        $sucesso = $_POST['sucesso'];
        if($sucesso == "true"){
            print "
                <div style='width:30vw; margin:auto; font-size:1.2em; background-color:light-green; margin: solid 2px darkgreen; border-radius:10px;'>
                    <p style='text-align:center; color:darkgreen;'>
                        Cadastro realizado com sucesso!
                    </p>
                </div>
            ";
        }
    }
?>

<div style="width:30vw; margin:auto; font-size:0.8em">
    <form  method="POST">
        <input type="hidden" name="pagina" value="cadastro">
        <input type="hidden" name="cad" value="curso">
        <input type="hidden" name="sucesso" value="true">
        <label>
            Categoria
        </label>
        <select style="width:100%; margin-bottom:10px;" name="categoria" >
            <?php
              foreach($resultado as $res){
                    print "<option value=";
                    print $res['id'].">";
                    print $res['nome']." / ".$res['modalidade'];
                    echo "</option>";
                }
            ?>
        </select>
        <label>
            Nome do Curso
        </label>
        <input style="width:100%; margin-bottom:10px; "type="text" name="nomeCurso">
        <br>
        <table style="width:100%;">
            <tr>
                <td>
                    <label>
                        Data de Inicio
                    </label>
                </td>
                <td>
                    <label>
                        Data de Fim
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <input style="width:100%; margin-bottom:10px; "type="date" name="dataInicio">
                </td>
                <td>
                    <input style="width:100%; margin-bottom:10px; "type="date" name="dataFim">
                </td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td>
                    <label>
                        Carga Horária
                    </label>
                </td>
                <td>
                    <label>
                        Capacidade
                    </label>
                </td>
            </tr>
            <tr>
                <td>
                    <input style="width:100%; margin-bottom:10px; "type="number" name="cargaHoraria">
                </td>
                <td>
                    <input style="width:100%; margin-bottom:10px; "type="number" name="capacidade">
                </td>
            </tr>
        </table>        
        <button>
            Cadastrar
        </button>
    </form>
</div>
