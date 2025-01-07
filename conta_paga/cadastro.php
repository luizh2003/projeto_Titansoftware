<?php
include "../menu.php";
$sqlcontapagar="select * from tbl_conta_pagar where id_conta_pagar='$_POST[id_conta_pagar]' ";
$querycontapagar=mysqli_query($conn, $sqlcontapagar);
$contapagar=mysqli_fetch_assoc($querycontapagar);
//print $sqlcontapagar;
?>

<!-- Body Content Wrapper -->
<div class="ms-content-wrapper">
	<div class="row">
		<div class="col-xl-12 col-md-12">
            <form id="myForm" action="script_cadastro.php" method="post">
            <?php
			if(empty($contapagar['id_conta_pagar'])) echo '<input type="hidden" name="cadcontpag" value="sim" />';	
			else echo '<input type="hidden" name="id_conta_pagar" value="'.$contapagar['id_conta_pagar'].'" />';
			?>
			<div class="ms-panel">
            	<div class="ms-panel-header ms-panel-custome">
               	 	<h6>Dados da Conta</h6>
            	</div>
				
                <div class="ms-panel-body"> 
                	<?php if(!empty($contapagar['id_conta_pagar'])) echo '<h2 class="mb-4">Alteração de Dados da Conta</h2>';?>
                    <div class="form-row">
                    
                    	<div class="col-md-6 mb-2">
                            <label for="validationCustom0001">Empresa*</label>
                            <div class="input-group">
                                <select name="empresa" class="selectemp form-control" required>
                                	<option value="" disabled="disabled" selected="selected">Selecione</option>
                                    <?php
									$sqlempresa="select * from tbl_empresa ";
									$queryempresa=mysqli_query($conn, $sqlempresa);
									while($empresa=mysqli_fetch_assoc($queryempresa)){
									?>
                                    	<option value="<?php echo $empresa['id_empresa'];?>" 
										<?php if($empresa['id_empresa']==$contapagar['id_empresa']) echo "selected";?>><?php echo $empresa['nome'];?></option>
                                    <?php	
									}
									?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label for="validationCustom0001">Data do pagto*</label>
                            <div class="input-group">
                                <input type="date" class="form-control" name="data_pag" 
                                value="<?php if(!empty($contapagar['id_conta_pagar'])) echo $contapagar['data_pagar'];?>" required>
                            </div>
                        </div>    
                        	
                       <div class="col-md-6 mb-6">
                            <label for="validationCustom0001">Valor Pago*</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="valor_pagto" 
                                value="<?php if(!empty($contapagar['id_conta_pagar'])) echo $contapagar['valor'];?>" placeholder="Digite o valor" required>
                            </div>
                        </div>  

                        <div class="col-md-12 mb-12">
                    		<button class="btn btn-primary d-inline w-20" name="submitButton" type="submit">
							<?php if(empty($contapagar['id_conta_pagar'])) echo 'Cadastrar'; 
							else echo 'Alterar';?></button>   
                        </div>
					</div>
				</div>
 			</div>
  			</form>
		</div>
	</div>
</div>

<script>
document.getElementById('myForm').addEventListener('submit', function() {
    var submitButton = document.querySelector('button[name="submitButton"]'); 
    submitButton.innerHTML = 'Enviando...';
	submitButton.style.pointerEvents = 'none'; // Desativa a interação com o botão
});
</script>

           
<script>
$(document).ready(function(){
	// Seleciona todos os inputs relevantes
	const inputs = document.querySelectorAll('input[name="valor_pagto"]');
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

<script>
    // Inicia o Select2
    $(document).ready(function() {
        $('.selectemp').select2();
    });
</script>