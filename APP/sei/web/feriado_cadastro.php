<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 26/07/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

try {
  require_once dirname(__FILE__).'/SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();

  PaginaSEI::getInstance()->verificarSelecao('feriado_selecionar');

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  PaginaSEI::getInstance()->salvarCamposPost(array('selOrgao'));

  $objFeriadoDTO = new FeriadoDTO();

  $strDesabilitar = '';

  $arrComandos = array();

  switch($_GET['acao']){
    case 'feriado_cadastrar':
      $strTitulo = 'Novo Feriado';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmCadastrarFeriado" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      $objFeriadoDTO->setNumIdFeriado(null);
      $numIdOrgao = PaginaSEI::getInstance()->recuperarCampo('selOrgao');
      if ($numIdOrgao!==''){
        $objFeriadoDTO->setNumIdOrgao($numIdOrgao);
      }else{
        $objFeriadoDTO->setNumIdOrgao(null);
      }

      $objFeriadoDTO->setStrDescricao($_POST['txtDescricao']);
      $objFeriadoDTO->setDtaFeriado($_POST['txtFeriado']);

      if (isset($_POST['sbmCadastrarFeriado'])) {
        try{
          $objFeriadoRN = new FeriadoRN();
          $objFeriadoDTO = $objFeriadoRN->cadastrar($objFeriadoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Feriado "'.$objFeriadoDTO->getStrDescricao().'" cadastrado com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].'&id_feriado='.$objFeriadoDTO->getNumIdFeriado().PaginaSEI::getInstance()->montarAncora($objFeriadoDTO->getNumIdFeriado())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'feriado_alterar':
      $strTitulo = 'Alterar Feriado';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmAlterarFeriado" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $strDesabilitar = 'disabled="disabled"';

      if (isset($_GET['id_feriado'])){
        $objFeriadoDTO->setNumIdFeriado($_GET['id_feriado']);
        $objFeriadoDTO->retTodos();
        $objFeriadoRN = new FeriadoRN();
        $objFeriadoDTO = $objFeriadoRN->consultar($objFeriadoDTO);
        if ($objFeriadoDTO==null){
          throw new InfraException("Registro n�o encontrado.");
        }
      } else {
        $objFeriadoDTO->setNumIdFeriado($_POST['hdnIdFeriado']);
        $objFeriadoDTO->setNumIdOrgao($_POST['selOrgao']);
        $objFeriadoDTO->setStrDescricao($_POST['txtDescricao']);
        $objFeriadoDTO->setDtaFeriado($_POST['txtFeriado']);
      }

      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objFeriadoDTO->getNumIdFeriado())).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      if (isset($_POST['sbmAlterarFeriado'])) {
        try{
          $objFeriadoRN = new FeriadoRN();
          $objFeriadoRN->alterar($objFeriadoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Feriado "'.$objFeriadoDTO->getStrDescricao().'" alterado com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objFeriadoDTO->getNumIdFeriado())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'feriado_consultar':
      $strTitulo = 'Consultar Feriado';
      $arrComandos[] = '<button type="button" accesskey="F" name="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($_GET['id_feriado'])).'\';" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
      $objFeriadoDTO->setNumIdFeriado($_GET['id_feriado']);
      $objFeriadoDTO->setBolExclusaoLogica(false);
      $objFeriadoDTO->retTodos();
      $objFeriadoRN = new FeriadoRN();
      $objFeriadoDTO = $objFeriadoRN->consultar($objFeriadoDTO);
      if ($objFeriadoDTO===null){
        throw new InfraException("Registro n�o encontrado.");
      }
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $strItensSelOrgao = OrgaoINT::montarSelectSiglaPublicacao('','Todos',$objFeriadoDTO->getNumIdOrgao());

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
#lblOrgao {position:absolute;left:0%;top:0%;width:25%;}
#selOrgao {position:absolute;left:0%;top:6%;width:25%;}

#lblDescricao {position:absolute;left:0%;top:16%;width:70%;}
#txtDescricao {position:absolute;left:0%;top:22%;width:70%;}

#lblFeriado {position:absolute;left:0%;top:32%;width:15%;}
#txtFeriado {position:absolute;left:0%;top:38%;width:15%;}
#imgCalFeriado {position:absolute;left:16%;top:38%;}

<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>
function inicializar(){
  if ('<?=$_GET['acao']?>'=='feriado_cadastrar'){
    document.getElementById('selOrgao').focus();
  } else if ('<?=$_GET['acao']?>'=='feriado_consultar'){
    infraDesabilitarCamposAreaDados();
  }else{
    document.getElementById('btnCancelar').focus();
  }
  infraEfeitoTabelas();
}

function validarCadastro() {

  if (!infraSelectSelecionado(document.getElementById('selOrgao'))) {
    alert('Selecione um �rg�o.');
    document.getElementById('selOrgao').focus();
    return false;
  }

  if (infraTrim(document.getElementById('txtDescricao').value)=='') {
    alert('Informe a Descri��o.');
    document.getElementById('txtDescricao').focus();
    return false;
  }

  if (infraTrim(document.getElementById('txtFeriado').value)=='') {
    alert('Informe a Data do Feriado.');
    document.getElementById('txtFeriado').focus();
    return false;
  }

  if (!infraValidarData(document.getElementById('txtFeriado'))){
    return false;
  }

  return true;
}

function OnSubmitForm() {
  return validarCadastro();
}

<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmFeriadoCadastro" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
<?
PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
//PaginaSEI::getInstance()->montarAreaValidacao();
PaginaSEI::getInstance()->abrirAreaDados('30em');
?>
  <label id="lblOrgao" for="selOrgao" accesskey="r" class="infraLabelObrigatorio">�<span class="infraTeclaAtalho">r</span>g�o:</label>
  <select id="selOrgao" name="selOrgao" class="infraSelect" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>">
  <?=$strItensSelOrgao?>
  </select>
  <label id="lblDescricao" for="txtDescricao" accesskey="D" class="infraLabelObrigatorio"><span class="infraTeclaAtalho">D</span>escri��o:</label>
  <input type="text" id="txtDescricao" name="txtDescricao" class="infraText" value="<?=PaginaSEI::tratarHTML($objFeriadoDTO->getStrDescricao());?>" onkeypress="return infraMascaraTexto(this,event,100);" maxlength="100" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />

  <label id="lblFeriado" for="txtFeriado" accesskey="a" class="infraLabelObrigatorio">D<span class="infraTeclaAtalho">a</span>ta do Feriado:</label>
  <input type="text" id="txtFeriado" name="txtFeriado" onkeypress="return infraMascaraData(this, event)" class="infraText" value="<?=PaginaSEI::tratarHTML($objFeriadoDTO->getDtaFeriado());?>" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <img id="imgCalFeriado" title="Selecionar Data do Feriado" alt="Selecionar Data do Feriado" src="<?=PaginaSEI::getInstance()->getIconeCalendario()?>" class="infraImg" onclick="infraCalendario('txtFeriado',this);" />

  <input type="hidden" id="hdnIdFeriado" name="hdnIdFeriado" value="<?=$objFeriadoDTO->getNumIdFeriado();?>" />
  <?
  PaginaSEI::getInstance()->fecharAreaDados();
  //PaginaSEI::getInstance()->montarAreaDebug();
  //PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  ?>
</form>
<?
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>