<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/02/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
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

  PaginaSEI::getInstance()->verificarSelecao('arquivo_extensao_selecionar');

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  $objArquivoExtensaoDTO = new ArquivoExtensaoDTO();

  $strDesabilitar = '';

  $arrComandos = array();

  switch($_GET['acao']){
    case 'arquivo_extensao_cadastrar':
      $strTitulo = 'Nova Extens�o de Arquivo';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmCadastrarArquivoExtensao" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      $objArquivoExtensaoDTO->setNumIdArquivoExtensao(null);
      $objArquivoExtensaoDTO->setStrExtensao($_POST['txtExtensao']);
      $objArquivoExtensaoDTO->setStrSinInterface(PaginaSEI::getInstance()->getCheckbox($_POST['chkSinInterface']));
      $objArquivoExtensaoDTO->setStrSinServico(PaginaSEI::getInstance()->getCheckbox($_POST['chkSinServico']));
      $objArquivoExtensaoDTO->setStrDescricao($_POST['txaDescricao']);
      $objArquivoExtensaoDTO->setNumTamanhoMaximo($_POST['txtTamanhoMaximo']);
      
      $objArquivoExtensaoDTO->setStrSinAtivo('S');

      if (isset($_POST['sbmCadastrarArquivoExtensao'])) {
        try{
          $objArquivoExtensaoRN = new ArquivoExtensaoRN();
          $objArquivoExtensaoDTO = $objArquivoExtensaoRN->cadastrar($objArquivoExtensaoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Extens�o de Arquivo "'.$objArquivoExtensaoDTO->getStrExtensao().'" cadastrada com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].'&id_arquivo_extensao='.$objArquivoExtensaoDTO->getNumIdArquivoExtensao().PaginaSEI::getInstance()->montarAncora($objArquivoExtensaoDTO->getNumIdArquivoExtensao())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'arquivo_extensao_alterar':
      $strTitulo = 'Alterar Extens�o de Arquivo';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmAlterarArquivoExtensao" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $strDesabilitar = 'disabled="disabled"';

      if (isset($_GET['id_arquivo_extensao'])){
        $objArquivoExtensaoDTO->setNumIdArquivoExtensao($_GET['id_arquivo_extensao']);
        $objArquivoExtensaoDTO->retTodos();
        $objArquivoExtensaoRN = new ArquivoExtensaoRN();
        $objArquivoExtensaoDTO = $objArquivoExtensaoRN->consultar($objArquivoExtensaoDTO);
        if ($objArquivoExtensaoDTO==null){
          throw new InfraException("Registro n�o encontrado.");
        }
      } else {
        $objArquivoExtensaoDTO->setNumIdArquivoExtensao($_POST['hdnIdArquivoExtensao']);
        $objArquivoExtensaoDTO->setStrExtensao($_POST['txtExtensao']);
        $objArquivoExtensaoDTO->setStrSinInterface(PaginaSEI::getInstance()->getCheckbox($_POST['chkSinInterface']));
        $objArquivoExtensaoDTO->setStrSinServico(PaginaSEI::getInstance()->getCheckbox($_POST['chkSinServico']));
        $objArquivoExtensaoDTO->setStrDescricao($_POST['txaDescricao']);
        $objArquivoExtensaoDTO->setNumTamanhoMaximo($_POST['txtTamanhoMaximo']);
        $objArquivoExtensaoDTO->setStrSinAtivo('S');
      }

      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objArquivoExtensaoDTO->getNumIdArquivoExtensao())).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      if (isset($_POST['sbmAlterarArquivoExtensao'])) {
        try{
          $objArquivoExtensaoRN = new ArquivoExtensaoRN();
          $objArquivoExtensaoRN->alterar($objArquivoExtensaoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Extens�o de Arquivo "'.$objArquivoExtensaoDTO->getStrExtensao().'" alterada com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objArquivoExtensaoDTO->getNumIdArquivoExtensao())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'arquivo_extensao_consultar':
      $strTitulo = 'Consultar Extens�o de Arquivo';
      $arrComandos[] = '<button type="button" accesskey="F" name="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($_GET['id_arquivo_extensao'])).'\';" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
      $objArquivoExtensaoDTO->setNumIdArquivoExtensao($_GET['id_arquivo_extensao']);
      $objArquivoExtensaoDTO->setBolExclusaoLogica(false);
      $objArquivoExtensaoDTO->retTodos();
      $objArquivoExtensaoRN = new ArquivoExtensaoRN();
      $objArquivoExtensaoDTO = $objArquivoExtensaoRN->consultar($objArquivoExtensaoDTO);
      if ($objArquivoExtensaoDTO===null){
        throw new InfraException("Registro n�o encontrado.");
      }
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
  $numTamMbDocExterno = $objInfraParametro->getValor('SEI_TAM_MB_DOC_EXTERNO');

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

#lblExtensao {position:absolute;left:0%;top:0%;width:10%;}
#txtExtensao {position:absolute;left:0%;top:6%;width:10%;}
#divSinInterface {position:absolute;left:15%;top:6%;}
#divSinServico {position:absolute;left:30%;top:6%;}

#lblDescricao {position:absolute;left:0%;top:16%;width:70%;}
#txaDescricao {position:absolute;left:0%;top:22%;width:70%;}

#lblTamanhoMaximo {position:absolute;left:0%;top:75%;width:30%;}
#txtTamanhoMaximo {position:absolute;left:0%;top:81%;width:10%;}
#ancAjuda {position:absolute;left:11%;top:81%;}

<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>
function inicializar(){
  if ('<?=$_GET['acao']?>'=='arquivo_extensao_cadastrar'){
    document.getElementById('txtExtensao').focus();
  } else if ('<?=$_GET['acao']?>'=='arquivo_extensao_consultar'){
    infraDesabilitarCamposAreaDados();
  }else{
    document.getElementById('btnCancelar').focus();
  }
  infraEfeitoTabelas();
}

function validarCadastro() {
  if (infraTrim(document.getElementById('txtExtensao').value)=='') {
    alert('Informe a Extens�o.');
    document.getElementById('txtExtensao').focus();
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
<form id="frmArquivoExtensaoCadastro" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
<?
PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
//PaginaSEI::getInstance()->montarAreaValidacao();
PaginaSEI::getInstance()->abrirAreaDados('30em');
?>
  <label id="lblExtensao" for="txtExtensao" accesskey="E" class="infraLabelObrigatorio"><span class="infraTeclaAtalho">E</span>xtens�o:</label>
  <input type="text" id="txtExtensao" name="txtExtensao" class="infraText" value="<?=PaginaSEI::tratarHTML($objArquivoExtensaoDTO->getStrExtensao());?>" onkeypress="return infraMascaraTexto(this,event,10);" maxlength="10" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />

  <div id="divSinInterface" class="infraDivCheckbox">
    <input type="checkbox" id="chkSinInterface" name="chkSinInterface" class="infraCheckbox" <?=PaginaSEI::getInstance()->setCheckbox($objArquivoExtensaoDTO->getStrSinInterface())?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
    <label id="lblSinInterface" for="chkSinInterface" class="infraLabelCheckbox">Interface</label>
  </div>

  <div id="divSinServico" class="infraDivCheckbox">
    <input type="checkbox" id="chkSinServico" name="chkSinServico" class="infraCheckbox" <?=PaginaSEI::getInstance()->setCheckbox($objArquivoExtensaoDTO->getStrSinServico())?>  tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
    <label id="lblSinServico" for="chkSinServico" class="infraLabelCheckbox">Servi�os</label>
  </div>

  <label id="lblDescricao" for="txaDescricao" accesskey="D" class="infraLabelOpcional"><span class="infraTeclaAtalho">D</span>escri��o:</label>
  <textarea id="txaDescricao" name="txaDescricao" rows="8"  class="infraTextarea" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>"><?=PaginaSEI::tratarHTML($objArquivoExtensaoDTO->getStrDescricao());?></textarea>

  <label id="lblTamanhoMaximo" for="txtTamanhoMaximo" accesskey="" class="infraLabelOpcional">Tamanho M�ximo (Mb):</label>
  <input type="text" id="txtTamanhoMaximo" name="txtTamanhoMaximo" onkeypress="return infraMascaraNumero(this, event)" class="infraText" value="<?=PaginaSEI::tratarHTML($objArquivoExtensaoDTO->getNumTamanhoMaximo());?>" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
  <a href="javascript:void(0);" id="ancAjuda" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" <?=PaginaSEI::montarTitleTooltip('Se n�o for preenchido utilizar� automaticamente o limite geral configurado no par�metro SEI_TAM_MB_DOC_EXTERNO ('.$numTamMbDocExterno.'Mb)')?>><img src="<?=PaginaSEI::getInstance()->getIconeAjuda()?>" class="infraImg"/></a>

  <input type="hidden" id="hdnIdArquivoExtensao" name="hdnIdArquivoExtensao" value="<?=$objArquivoExtensaoDTO->getNumIdArquivoExtensao();?>" />
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