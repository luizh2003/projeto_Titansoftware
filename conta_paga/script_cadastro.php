<?php
include "../menu.php";

if($_POST['cadcontpag']=="sim" || !empty($_POST['id_conta_pagar']) && empty($_POST['excluir_contapag']) && empty($_POST['marcapagto']))
{
	// Função para remover formatação
	function removerFormatacao($valor) {
		// Remove pontos e substitui vírgula por ponto
		$valor = str_replace('.', '', $valor); // Remove os pontos
		$valor = str_replace(',', '.', $valor); // Troca a vírgula por ponto
		return (float)$valor; // Retorna como número
	}
	
	// Capturar e validar os campos com filter_input
    $id_empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);
    $data_pag = filter_input(INPUT_POST, 'data_pag', FILTER_SANITIZE_EMAIL);
	// Capturar e validar os campos com filter_input
    $valor_pagto = removerFormatacao(filter_input(INPUT_POST, 'valor_pagto', FILTER_SANITIZE_STRING));
	
    // Verificar se todos os campos estão preenchidos caso o user tente bular no front
    if($id_empresa && $data_pag && $valor_pagto) 
	{
		//aqui faz insert e update baseado no que vem de la simplificado e resumido para melhoria do codigo
		if(empty($_POST['id_conta_pagar'])) $userbd="insert into tbl_conta_pagar set ";
		else $userbd="update tbl_conta_pagar set ";
		$userbd.="
		id_empresa='$id_empresa',
		valor='$valor_pagto',
		data_pagar='$data_pag'
		";
		if(!empty($_POST['id_conta_pagar'])){
			$userbd.=" where id_conta_pagar='$_POST[id_conta_pagar]' ";	
		}
		//aqui e pra so definir como 0 na hora que inserir, depois quando for fazer update nao faz nada com esse campo
		else $userbd.=" ,pago='0' "; 
		$queryuserbd=mysqli_query($conn, $userbd);
	}
	else{
		echo '<script>
		// Usando SweetAlert para exibir uma mensagem de erro e redirecionar
		Swal.fire({
			title: "Atencao!",
			text: "Confira os campos",
			icon: "error",
			confirmButtonText: "OK",
			allowOutsideClick: false
		}).then((result) => {
			// Verifica se o botão "OK" foi clicado
			if (result.isConfirmed) {
				// Redireciona para outra página
				window.location.replace("cadastro.php");
			}
		});
		</script>';
		exit();
	}
	header("Location:listar.php");
}

//aqui excluir a contas a pagar, invalida no banco somente mais continua na base, vai que o user aperto sem querer.
if($_POST['excluir_contapag']=="sim")
{
	$excluircontaspagar="update tbl_conta_pagar set valido='n' where id_conta_pagar='$_POST[id_conta_pagar]' ";	
	$queryexcluircontaspagar=mysqli_query($conn, $excluircontaspagar);
	header("Location:listar.php");
}

//aqui comeca logica para quando for dar baixa na conta marca como pag
if(!empty($_POST['marcapagto']))
{
	$dateatual=date('Y-m-d');
	/*
	print "<pre>";
	print_r($_POST);
	print "</pre>";
	*/
	//aqui faz um select pegando a conta valida
	$sqlcontapagar="select data_pagar, valor, pago from tbl_conta_pagar where id_conta_pagar='$_POST[id_conta_pagar]' and valido='s' ";
	$querycontapagar=mysqli_query($conn, $sqlcontapagar);
	$contapagar=mysqli_fetch_assoc($querycontapagar);
	
	if($dateatual<$contapagar['data_pagar']){
		//aqui e contas pagas antes da data de pagamento tera um desconto de 5% sobre o valor
		$valor_final = $contapagar['valor'] * 0.95;
        //echo "Pagamento antecipado: Valor com desconto: R$ " . number_format($valor_final, 2, ',', '.');
	}
	else if($dateatual==$contapagar['data_pagar']){
		 // Contas pagas no dia correto não têm desconto
        $valor_final = $contapagar['valor'];
        //echo "Pagamento no dia: Valor sem desconto: R$ " . number_format($valor_final, 2, ',', '.');
	}
	else if($dateatual>$contapagar['data_pagar']){
		// Contas pagas após a data de pagamento têm acréscimo de 10%
        $valor_final = $contapagar['valor'] * 1.10;
        //echo "Pagamento atrasado: Valor com acréscimo: R$ " . number_format($valor_final, 2, ',', '.');
	}
	
	//aqui verifica se esta como 0 ou seja nao foi pago ai entra aqui, caso o usuario tente burla o checbox disabled apos pago para nao realizar 
	//nenhuma acao na coluna valor
	//obs: aqui teria como fazer a logica reversa para armazenar o valor original e quando o user desmarcar o checbox como pago voltar o valor originall
	//mas não foi pedido por isso não fiz.
	if($contapagar['pago']==0){
		//aqui atualiza o valor a ser pago
		$atualizavalorpago="update tbl_conta_pagar set valor='$valor_final', pago='1' where id_conta_pagar='$_POST[id_conta_pagar]' ";	
		$queryatualizavalorpago=mysqli_query($conn, $atualizavalorpago);
	}
	header("Location:listar.php");
}
?>
