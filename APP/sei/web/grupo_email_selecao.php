<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 23/08/2010 - criado por Alexandre_db
 *
 * Vers�o do Gerador de C�digo: 1.12.0
 *
 * Vers�o no CVS: $Id$
 **/

try {
	require_once dirname(__FILE__).'/SEI.php';

	session_start();

	//////////////////////////////////////////////////////////////////////////////
	InfraDebug::getInstance()->setBolLigado(false);
	InfraDebug::getInstance()->setBolDebugInfra(true);
	InfraDebug::getInstance()->limpar();
	//////////////////////////////////////////////////////////////////////////////

	SessaoSEI::getInstance()->validarLink();

	PaginaSEI::getInstance()->prepararSelecao('grupo_email_selecionar');

	SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

	PaginaSEI::getInstance()->salvarCamposPost(array('selGrupoEmail','optInstitucional','optUnidade','hdnTipoSelect'));

	switch($_GET['acao']){
		 
		case 'grupo_email_selecionar':
			$strTitulo = PaginaSEI::getInstance()->getTituloSelecao('Selecionar Grupo de E-mail','Selecionar Grupos de E-mail');
			break;
		default:
			throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
	}
	
	$strTipoPadrao = 'U';
	$strExibirOpcoes = 'visibility:hidden';
	if (SessaoSEI::getInstance()->verificarPermissao('grupo_email_institucional_selecionar')){
		$strTipoPadrao = 'I';
		$strExibirOpcoes = '';
	}
	
	$strTipoSelect = PaginaSEI::getInstance()->recuperarCampo('hdnTipoSelect',$strTipoPadrao);
	if (PaginaSEI::getInstance()->recuperarCampo('selGrupoEmail') !== null){
		$numIdGrupoEmail = PaginaSEI::getInstance()->recuperarCampo('selGrupoEmail');
	}
	if ($_GET['id_grupo'] !== null && $_GET['acao_origem'] == 'grupo_email_cadastrar'){
		$numIdGrupoEmail = $_GET['id_grupo'];		
	}	

	$arrComandos = array();

  $arrComandos[] = '<button type="button" onclick="pesquisar();" accesskey="P" id="btnPesquisar" name="btnPesquisar" value="Pesquisar" class="infraButton" style="width:8em"><span class="infraTeclaAtalho">P</span>esquisar</button>';

	$bolAcaoCadastrar = SessaoSEI::getInstance()->verificarPermissao('grupo_email_cadastrar');
	if ($bolAcaoCadastrar && $strTipoSelect=='U'){
		$arrComandos[] = '<button type="button" accesskey="N" id="btnNovo" value="Novo" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=grupo_email_cadastrar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">N</span>ovo</button>';
	}
	
	if ($_GET['acao'] == 'grupo_email_selecionar'){
		$arrComandos[] = '<button type="button" accesskey="T" id="btnTransportarSelecao" value="Transportar" onclick="infraTransportarSelecao();" class="infraButton"><span class="infraTeclaAtalho">T</span>ransportar</button>';
	}

  $objEmailGrupoEmailDTO = new EmailGrupoEmailDTO();
  $objEmailGrupoEmailDTO->retNumIdEmailGrupoEmail();
  $objEmailGrupoEmailDTO->retStrEmail();
  $objEmailGrupoEmailDTO->retStrDescricao();
  $objEmailGrupoEmailDTO->setStrStaTipoGrupoEmail($strTipoSelect);
  $objEmailGrupoEmailDTO->setStrPalavrasPesquisa($_POST['txtPalavrasPesquisaGrupoEmail'] ?? '');
  $objEmailGrupoEmailDTO->setNumIdGrupoEmail($numIdGrupoEmail);

  PaginaSEI::getInstance()->prepararOrdenacao($objEmailGrupoEmailDTO, 'Descricao', InfraDTO::$TIPO_ORDENACAO_ASC);

  PaginaSEI::getInstance()->prepararPaginacao($objEmailGrupoEmailDTO,500);

  $objEmailGrupoEmailRN = new EmailGrupoEmailRN();
  $arrObjEmailGrupoEmailDTO = $objEmailGrupoEmailRN->pesquisar($objEmailGrupoEmailDTO);

  PaginaSEI::getInstance()->processarPaginacao($objEmailGrupoEmailDTO);

	$numRegistros = InfraArray::contar($arrObjEmailGrupoEmailDTO);
	
	$bolCheck = true;

	/*
	if ($bolAcaoImprimir){
		$bolCheck = true;
		$arrComandos[] = '<button type="button" accesskey="I" id="btnImprimir" value="Imprimir" onclick="infraImprimirTabela();" class="infraButton"><span class="infraTeclaAtalho">I</span>mprimir</button>';
	}
  */
	
	if ($_GET['acao'] == 'grupo_email_selecionar'){
		$arrComandos[] = '<button type="button" accesskey="F" id="btnFecharSelecao" value="Fechar" onclick="window.close();" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
	}else{
		$arrComandos[] = '<button type="button" accesskey="F" id="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
	}
	
	if ($numRegistros > 0){

		$strResultado = '';

		$strSumarioTabela = 'Tabela de Grupos.';
		$strCaptionTabela = 'Grupos';

		$strResultado .= '<table width="99%" class="infraTable" summary="'.$strSumarioTabela.'">'."\n";
		$strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela($strCaptionTabela,$numRegistros).'</caption>';
		$strResultado .= '<tr>';

		if ($bolCheck) {
			$strResultado .= '<th class="infraTh" width="1%">'.PaginaSEI::getInstance()->getThCheck().'</th>'."\n";
		}

		$strResultado .= '<th class="infraTh">'.PaginaSEI::getInstance()->getThOrdenacao($objEmailGrupoEmailDTO,'Descri��o','Descricao',$arrObjEmailGrupoEmailDTO).'</th>'."\n";
		$strResultado .= '<th class="infraTh">'.PaginaSEI::getInstance()->getThOrdenacao($objEmailGrupoEmailDTO,'E-mail','Email',$arrObjEmailGrupoEmailDTO).'</th>'."\n";
		$strResultado .= '<th class="infraTh">A��es</th>'."\n";
		$strResultado .= '</tr>'."\n";
		$strCssTr='';

		for($i = 0;$i < $numRegistros; $i++){

			$strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
			$strResultado .= $strCssTr;

			if ($bolCheck){
				$strResultado .= '<td valign="top">'.PaginaSEI::getInstance()->getTrCheck($i,$arrObjEmailGrupoEmailDTO[$i]->getStrDescricao().' &lt;'.$arrObjEmailGrupoEmailDTO[$i]->getStrEmail().'&gt;',$arrObjEmailGrupoEmailDTO[$i]->getStrDescricao().' &lt;'.$arrObjEmailGrupoEmailDTO[$i]->getStrEmail().'&gt;').'</td>';
			}

			$strResultado .= '<td width="45%" align="left" valign="top">'.PaginaSEI::tratarHTML($arrObjEmailGrupoEmailDTO[$i]->getStrDescricao()).'</td>';
			$strResultado .= '<td width="45%" align="left" valign="top">'.PaginaSEI::tratarHTML($arrObjEmailGrupoEmailDTO[$i]->getStrEmail()).'</td>';
			$strResultado .= '<td align="center" valign="top">';


			$strResultado .= PaginaSEI::getInstance()->getAcaoTransportarItem($i,$arrObjEmailGrupoEmailDTO[$i]->getNumIdEmailGrupoEmail());

			$strResultado .= '</td></tr>'."\n";
		}
		$strResultado .= '</table>';
	}

	$strCheckedInstitucional = '';
	$strCheckedUnidade = '';
	
	if ($strTipoSelect=='I') {
		$strCheckedInstitucional = 'checked="checked"';
    $strItensGrupo = GrupoEmailINT::montarSelectNomeInstitucional('null','&nbsp;',$numIdGrupoEmail);
	}else{
    $strCheckedUnidade = 'checked="checked"';
		$strItensGrupo = GrupoEmailINT::montarSelectNomeUnidade('null','&nbsp;',$numIdGrupoEmail);
	}
	
}catch(Exception $e){
	PaginaSEI::getInstance()->processarExcecao($e);
}

PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
PaginaSEI::getInstance()->montarTitle(PaginaSEI::getInstance()->getStrNomeSistema().' - '.$strTitulo);
PaginaSEI::getInstance()->montarStyle();
PaginaSEI::getInstance()->abrirStyle();
?>

#lblGrupoEmail {position:absolute;left:0%;top:0%;}
#selGrupoEmail {position:absolute;left:0%;top:20%;width:50%;}

#divOptInstitucional {position:absolute; left:55%; top:20%;<?=$strExibirOpcoes?>}
#divOptUnidade{position:absolute; left:75%; top:20%;<?=$strExibirOpcoes?>}

#lblPalavrasPesquisaGrupoEmail{position:absolute;left:0%;top:50%;}
#txtPalavrasPesquisaGrupoEmail{position:absolute;left:0%;top:70%;width:50%;}

<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>

function inicializar(){ 
  if ('<?=$_GET['acao']?>'=='grupo_email_selecionar'){ 
	  infraReceberSelecao();
	  document.getElementById('btnFecharSelecao').focus(); 
  }else{
	  //document.getElementById('btnFechar').focus();
	  setTimeout("document.getElementById('btnFechar').focus()", 50); 
  }

   
  infraEfeitoTabelas(); 
} 

function carregarSelect(tipo){
	document.getElementById('hdnTipoSelect').value=tipo;
	if (document.getElementById('selGrupoEmail').options.length){
	  document.getElementById('selGrupoEmail').options[0].selected = true;
	}
	document.getElementById('frmGrupoSelecao').submit(); 
}

function tratarDigitacao(ev){
  if (infraGetCodigoTecla(ev) == 13){
    document.getElementById('frmGrupoSelecao').submit();
  }
  return true;
}

function pesquisar(){
  document.getElementById('hdnPesquisar').value = '1';
  document.getElementById('frmGrupoSelecao').submit();
}

<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');

?>

<form id="frmGrupoSelecao" method="post"	action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">

<?
//PaginaSEI::getInstance()->montarBarraLocalizacao($strTitulo);
PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
PaginaSEI::getInstance()->abrirAreaDados('10em');
?> 

  <label id="lblGrupoEmail" for="selGrupoEmail" accesskey="G" class="infraLabelOpcional"><span class="infraTeclaAtalho">G</span>rupo:</label>
  <select id="selGrupoEmail" name="selGrupoEmail" onchange="this.form.submit();" class="infraSelect" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>">
    <?=$strItensGrupo?>
  </select>

  <div id="divOptInstitucional" class="infraDivRadio">
    <input type="radio" name="rdoGrupo" id="optInstitucional"	value="optInstitucionalEnviado" onclick="carregarSelect('I');" <?=$strCheckedInstitucional?> class="infraRadio" />
    <label id="lblInstitucional" accesskey="I" for="optInstitucional"	class="infraLabelRadio" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>"><span class="infraTeclaAtalho">I</span>nstitucional</label>
  </div>

  <div id="divOptUnidade" class="infraDivRadio">
    <input type="radio" name="rdoGrupo" id="optUnidade" value="optUnidadeEnviado" onclick="carregarSelect('U');" <?=$strCheckedUnidade?> class="infraRadio" />
    <label id="lblUnidade" accesskey="U" for="optUnidade" class="infraLabelRadio" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>"><span class="infraTeclaAtalho">U</span>nidade</label>
  </div>

  <label id="lblPalavrasPesquisaGrupoEmail" for="txtPalavrasPesquisaGrupoEmail" accesskey="" class="infraLabelOpcional">Palavras-chave para pesquisa:</label>
  <input type="text" id="txtPalavrasPesquisaGrupoEmail" name="txtPalavrasPesquisaGrupoEmail" class="infraText" value="<?=$_POST['txtPalavrasPesquisaGrupoEmail']?>" onkeypress="return tratarDigitacao(event);" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />

  <input type="hidden" id="hdnPesquisar" name="hdnPesquisar" value="<?=$_POST['hdnPesquisar']?>" />
  <input type="hidden" name="hdnTipoSelect" id="hdnTipoSelect" value="<?=$strTipoSelect;?>" />

  <?
	PaginaSEI::getInstance()->fecharAreaDados();
	PaginaSEI::getInstance()->montarAreaTabela($strResultado,$numRegistros);
	PaginaSEI::getInstance()->montarAreaDebug();
	PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
	?>
	
</form>

	<?
	PaginaSEI::getInstance()->fecharBody();
	PaginaSEI::getInstance()->fecharHtml();
	?>