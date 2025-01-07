<?php 
include_once "../menu.php";
//lista todos as contas a pagar
$sqlcontapagar="select * from tbl_conta_pagar where valido='s' ";
//aqui e para o filtro ai pega pela empresa selecionada
if(!empty($_POST['filtroempresa'])) $sqlcontapagar.=" AND id_empresa='$_POST[filtroempresa]' ";
//Filtrar por valor a pagar, pelas condições MAIOR, MENOR OU IGUAL
if(!empty($_POST['filtro_valor']) && !empty($_POST['filtro_condicao'])) {
	// Função para remover formatação
	function removerFormatacao($valor) {
		// Remove pontos e substitui vírgula por ponto
		$valor = str_replace('.', '', $valor); // Remove os pontos
		$valor = str_replace(',', '.', $valor); // Troca a vírgula por ponto
		return (float)$valor; // Retorna como número
	}
	$filtro_valor=removerFormatacao($_POST['filtro_valor']);
	switch($_POST['filtro_condicao']) {
		case 'maior':
			$sqlcontapagar.= " AND valor > $filtro_valor";
			break;
		case 'menor':
			$sqlcontapagar.= " AND valor < $filtro_valor";
			break;
		case 'igual':
			$sqlcontapagar.= " AND valor = $filtro_valor";
			break;
	}
}
//Filtrar por data de pagamento
if(!empty($_POST['filtro_datapag'])) $sqlcontapagar.=" AND data_pagar='$_POST[filtro_datapag]' ";
$querycontapagar=mysqli_query($conn, $sqlcontapagar);

//aqui e pra caso ele digitar somente o valor e nao digitar a condicao ambos
if(!empty($_POST['filtro_valor']) && empty($_POST['filtro_condicao']) || !empty($_POST['filtro_condicao']) && empty($_POST['filtro_valor'])){
	echo '<script>
		// Usando SweetAlert para exibir uma mensagem de erro e redirecionar
		Swal.fire({
			title: "Atencao!",
			text: "Para este filtro digite o valor e o tipo de condição",
			icon: "error",
			confirmButtonText: "OK",
			allowOutsideClick: false
		}).then((result) => {
			// Verifica se o botão "OK" foi clicado
			if (result.isConfirmed) {
				// Redireciona para outra página
				window.location.replace("listar.php");
			}
		});
		</script>';
}
//debug post filtro print_r($_POST);

//aqui e para esconder o filtro caso nao tem reg, nao posso usar o select de cima pois quando for filtrar e nao achar nada iria dar erro por isso fiz esse
$sqlverificanum="select * from tbl_conta_pagar where valido='s' ";
$queryverificanum=mysqli_query($conn, $sqlverificanum);
?>

<!-- Body Content Wrapper -->
<div class="ms-content-wrapper">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome">
                    <h6>Visualizar Contas Pagar</h6>
                    <!--<a href="../doctor-list.html" class="ms-text-primary">Doctors List</a>-->
                </div>
    
                <div class="ms-panel-body">  
                	<?php
					if(mysqli_num_rows($queryverificanum)>0){
					?>
                    <form action="" method="post">
                    <div class="form-row">
                        <div class="col-md-6 mb-2">
                            <label for="validationCustom0001">Empresa*</label>
                            <div class="input-group">
                                <select name="filtroempresa" class="selectcontapagar form-control">
                                    <option value=""><?php if(empty($_POST['filtroempresa'])) echo 'Selecione'; else echo 'Sem Filtro';?></option>
                                    <?php
                                    //aqui e somente para pegar o nome da empresa no filtro
                                    $sqlcontapagarFiltro="select * from tbl_conta_pagar
                                    inner join tbl_empresa on tbl_conta_pagar.id_empresa=tbl_empresa.id_empresa
                                    where tbl_conta_pagar.valido='s' GROUP BY tbl_conta_pagar.id_empresa ";
                                    $querycontapagarFiltro=mysqli_query($conn, $sqlcontapagarFiltro);
                                    while($contapagarFiltro=mysqli_fetch_assoc($querycontapagarFiltro))
                                    {
                                    ?>
                                        <option value="<?php echo $contapagarFiltro['id_empresa'];?>" 
                                        <?php if($contapagarFiltro['id_empresa']==$_POST['filtroempresa']) echo "selected";?>>
                                        <?php echo $contapagarFiltro['nome'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                   
                        <div class="col-md-6 mb-3">
                            <label for="valor">Valor a Pagar:</label>
                            <input type="text" step="0.01" name="filtro_valor" id="valor" class="form-control" placeholder="Digite o valor"
                            value="<?php echo $filtro_valor;?>">
                        </div>
                
                        <div class="col-md-6 mb-3">
                            <label for="condicao">Condição:</label>
                            <select name="filtro_condicao" id="condicao" class="form-control">
                            	<option value="" disabled="disabled" selected="selected">Selecione</option>
                                <option value="maior" <?php if($_POST['filtro_condicao']=="maior") echo "selected";?>>Maior</option>
                                <option value="menor" <?php if($_POST['filtro_condicao']=="menor") echo "selected";?>>Menor</option>
                                <option value="igual" <?php if($_POST['filtro_condicao']=="igual") echo "selected";?>>Igual</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="condicao">Data de Pagamento:</label>
                            <input type="date" name="filtro_datapag" value="<?php echo $_POST['filtro_datapag'];?>" class="form-control" />
                        </div>
                     </div>   
                     <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                     </form>
                     <hr />
                     <?php } ?>
                     
                    <?php
					if(mysqli_num_rows($querycontapagar)>0)
					{
					?>  
                        <div class="table-responsive">
                        <table class="table table-striped thead-primary">
                            <thead>
                                 <tr class="text-center">
                                 	<th scope="col">Empresa</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Data/pag</th>
                                    <th scope="col">Marca/Pagto</th>
                                    <th scope="col">Ações</th>  
                                 </tr>
                            </thead> 
                            <?php
                            foreach($querycontapagar as $contapagar)
                            {
								$sqlempresa="select nome from tbl_empresa where id_empresa='$contapagar[id_empresa]' ";
								$queryempresa=mysqli_query($conn, $sqlempresa);
								$empresa=mysqli_fetch_assoc($queryempresa);
                            ?>
                                <tr class="text-center">
                                    <td><?php echo $empresa['nome'];?></td>
                                    <td><?php echo number_format($contapagar['valor'], 2, ',', '.');?></td>
                                    <td><?php echo date('d/m/Y', strtotime($contapagar['data_pagar']));?></td>
                                    <td align="center">
                                   	<input type="checkbox" name="marcapag" class="marcapag" id="<?php echo $contapagar['id_conta_pagar'];?>"
                                    <?php if($contapagar['pago']==1) echo "checked disabled";?> />
                                    </td>
                                    <td class="">
                                    <?php
									//aqui verifica se o user ja coloco como pago nao deixa alterar para nao dar conflitos, 
									//pois pode quebrar a logica da regra de negocio de valor a ser pago
									if($contapagar['pago']==0){
									?>
                                    <a href="#" id="<?php echo $contapagar['id_conta_pagar'];?>" class="editarPag"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
                                    <?php
									}else echo '<i class="fas fa-exclamation-circle text-danger"></i>';
									?>
                                    <a href="#" id="<?php echo $contapagar['id_conta_pagar'];?>" class="excluirPag"><i class="far fa-trash-alt ms-text-danger"></i></a>
                                    </td> 
                                </tr> 
                            <?php
                            }
                            ?>           
                        </table>
                 		</div>
                 	<?php
					}else echo "<div class='alert alert-danger text-center' role='alert'>Nenhum registro encontrado!</div>";
					?>
                </div>
     		</div>
     	</div>
	</div>
</div>

<script>
/*aqui edita a conta que ele aperta la em cima na lsitagem do loopin*/
$(document).ready(function(){
	$(document).on('click', '.editarPag', function(e) {
		e.preventDefault(); // Impede o comportamento padrão do link
		var id_conta_pagar = $(this).attr("id");
		// Cria um formulário HTML dinamicamente
		var form = $('<form action="cadastro.php" method="post"></form>');
		// Adiciona os campos ao formulário
		form.append('<input type="hidden" name="id_conta_pagar" value="' + id_conta_pagar + '">');
		$('body').append(form);
		form.submit();
	});
	
	/*aqui exclui a conta que ele aperta la em cima na lsitagem do loopin*/
	$(document).on('click', '.excluirPag', function(e) {
		e.preventDefault(); // Impede o comportamento padrão do link
		var id_conta_pagar = $(this).attr("id");
		// Cria um formulário HTML dinamicamente
		var form = $('<form action="script_cadastro.php" method="post"></form>');
		// Adiciona os campos ao formulário
		form.append('<input type="hidden" name="excluir_contapag" value="sim">');
		form.append('<input type="hidden" name="id_conta_pagar" value="' + id_conta_pagar + '">');
		$('body').append(form);
		form.submit();
	});
	
	
	/*aqui marca o pagamento, so nao vai ter como desmarcar, pois tem que fazer a logica reversa para voltar o valor original
	como não foi pedido no doc nao fiz.*/
    $(document).on('change', '.marcapag', function () {
        // Obtém o ID da conta a pagar
        var id_conta_pagar = $(this).attr("id");
        // Verifica se está marcado ou desmarcado
        var marcado = $(this).is(':checked') ? 'sim' : 'nao';
        // Cria o formulário dinamicamente
        var form = $('<form action="script_cadastro.php" method="post"></form>');
		form.append('<input type="hidden" name="marcapagto" value="' + marcado + '">');
        form.append('<input type="hidden" name="id_conta_pagar" value="' + id_conta_pagar + '">');
        // Adiciona o formulário ao corpo e submete
        $('body').append(form);
        form.submit();
    });
});	
</script>

<script>
    // Inicia o Select2
    $(document).ready(function() {
        $('.selectcontapagar').select2();
    });
</script>

<script>
$(document).ready(function(){
	// Seleciona todos os inputs relevantes
	const inputs = document.querySelectorAll('input[name="filtro_valor"]');
	inputs.forEach(function(input) {
		IMask(input, {
			mask: 'num',
			blocks: {
				num: {
					mask: Number,
					thousandsSeparator: '.',
					radix: ',',
					scale: 2,
					signed: true, // Permite números positivos e negativos
					padFractionalZeros: true
				}
			}
		});
	});
});
</script>