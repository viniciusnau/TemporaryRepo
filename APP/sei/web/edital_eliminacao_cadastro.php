<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/12/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
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


  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  $objEditalEliminacaoDTO = new EditalEliminacaoDTO();

  $strDesabilitar = '';

  $arrComandos = array();

  switch($_GET['acao']){
    case 'edital_eliminacao_cadastrar':
      $strTitulo = 'Novo Edital de Elimina��o';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmCadastrarEditalEliminacao" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      $objEditalEliminacaoDTO->setNumIdEditalEliminacao(null);
      $objEditalEliminacaoDTO->setDblIdProcedimento(null);
      $objEditalEliminacaoDTO->setDblIdDocumento(null);
      $objEditalEliminacaoDTO->setStrStaEditalEliminacao(EditalEliminacaoRN::$TE_CADASTRADO);
      $objEditalEliminacaoDTO->setStrEspecificacao($_POST['txtEspecificacao']);
      //$objEditalEliminacaoDTO->setDtaPublicacao($_POST['txtPublicacao']);


      if (isset($_POST['sbmCadastrarEditalEliminacao'])) {
        try{
          $objEditalEliminacaoRN = new EditalEliminacaoRN();
          $objEditalEliminacaoDTO = $objEditalEliminacaoRN->cadastrar($objEditalEliminacaoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Edital de Elimina��o "'.$objEditalEliminacaoDTO->getNumIdEditalEliminacao().'" cadastrado com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].'&id_edital_eliminacao='.$objEditalEliminacaoDTO->getNumIdEditalEliminacao().PaginaSEI::getInstance()->montarAncora($objEditalEliminacaoDTO->getNumIdEditalEliminacao())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'edital_eliminacao_alterar':
      $strTitulo = 'Alterar Edital de Elimina��o';
      $arrComandos[] = '<button type="submit" accesskey="S" name="sbmAlterarEditalEliminacao" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
      $strDesabilitar = 'disabled="disabled"';

      if (isset($_GET['id_edital_eliminacao'])){
        $objEditalEliminacaoDTO->setNumIdEditalEliminacao($_GET['id_edital_eliminacao']);
        $objEditalEliminacaoDTO->retTodos();
        $objEditalEliminacaoRN = new EditalEliminacaoRN();
        $objEditalEliminacaoDTO = $objEditalEliminacaoRN->consultar($objEditalEliminacaoDTO);
        if ($objEditalEliminacaoDTO==null){
          throw new InfraException("Registro n�o encontrado.");
        }
      } else {
        $objEditalEliminacaoDTO->setNumIdEditalEliminacao($_POST['hdnIdEditalEliminacao']);
        $objEditalEliminacaoDTO->setStrEspecificacao($_POST['txtEspecificacao']);
        //$objEditalEliminacaoDTO->setDtaPublicacao($_POST['txtPublicacao']);
      }

      $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objEditalEliminacaoDTO->getNumIdEditalEliminacao())).'\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

      if (isset($_POST['sbmAlterarEditalEliminacao'])) {
        try{
          $objEditalEliminacaoRN = new EditalEliminacaoRN();
          $objEditalEliminacaoRN->alterar($objEditalEliminacaoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Edital de Elimina��o "'.$objEditalEliminacaoDTO->getNumIdEditalEliminacao().'" alterado com sucesso.');
          header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($objEditalEliminacaoDTO->getNumIdEditalEliminacao())));
          die;
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        }
      }
      break;

    case 'edital_eliminacao_consultar':
      $strTitulo = 'Consultar Edital de Elimina��o';
      $arrComandos[] = '<button type="button" accesskey="F" name="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao'].PaginaSEI::getInstance()->montarAncora($_GET['id_edital_eliminacao'])).'\';" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
      $objEditalEliminacaoDTO->setNumIdEditalEliminacao($_GET['id_edital_eliminacao']);
      $objEditalEliminacaoDTO->setBolExclusaoLogica(false);
      $objEditalEliminacaoDTO->retTodos();
      $objEditalEliminacaoRN = new EditalEliminacaoRN();
      $objEditalEliminacaoDTO = $objEditalEliminacaoRN->consultar($objEditalEliminacaoDTO);
      if ($objEditalEliminacaoDTO===null){
        throw new InfraException("Registro n�o encontrado.");
      }
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
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
<?if(0){?><style><?}?>

#lblEspecificacao {position:absolute;left:0%;top:0%;width:80%;}
#txtEspecificacao {position:absolute;left:0%;top:40%;width:80%;}

/*#lblPublicacao {position:absolute;left:0%;top:0%;width:10%;}*/
/*#txtPublicacao {position:absolute;left:0%;top:40%;width:10%;}*/
/*#imgCalPublicacao {position:absolute;left:10.5%;top:40%;}*/


<?if(0){?></style><?}?>
<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>
<?if(0){?><script type="text/javascript"><?}?>

function inicializar(){
  if ('<?=$_GET['acao']?>'=='edital_eliminacao_cadastrar'){
    document.getElementById('txtEspecificacao').focus();
  } else if ('<?=$_GET['acao']?>'=='edital_eliminacao_consultar'){
    infraDesabilitarCamposAreaDados();
  }else{
    document.getElementById('btnCancelar').focus();
  }
  //infraEfeitoTabelas(true);
}

function validarCadastro() {
  if (infraTrim(document.getElementById('txtEspecificacao').value)=='') {
    alert('Informe a Especifica��o.');
    document.getElementById('txtEspecificacao').focus();
    return false;
  }

  // if (!infraValidarData(document.getElementById('txtPublicacao'))){
  //   return false;
  // }


  return true;
}

function OnSubmitForm() {
  return validarCadastro();
}

<?if(0){?></script><?}?>
<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmEditalEliminacaoCadastro" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
<?
PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
//PaginaSEI::getInstance()->montarAreaValidacao();
PaginaSEI::getInstance()->abrirAreaDados('4.5em');
?>
  <label id="lblEspecificacao" for="txtEspecificacao" accesskey="" class="infraLabelObrigatorio">Especifica��o:</label>
  <input type="text" id="txtEspecificacao" name="txtEspecificacao" class="infraText" value="<?=PaginaSEI::tratarHTML($objEditalEliminacaoDTO->getStrEspecificacao());?>" onkeypress="return infraMascaraTexto(this,event,100);" maxlength="100" tabindex="<?=PaginaSEI::getInstance()->getProxTabDados()?>" />
<?
PaginaSEI::getInstance()->fecharAreaDados();
//PaginaSEI::getInstance()->abrirAreaDados('4.5em');
?>
<!--  <label id="lblPublicacao" for="txtPublicacao" accesskey="" class="infraLabelOpcional">Data de Publica��o:</label>-->
<!--  <input type="text" id="txtPublicacao" name="txtPublicacao" onkeypress="return infraMascaraData(this, event)" class="infraText" value="--><?//=PaginaSEI::tratarHTML($objEditalEliminacaoDTO->getDtaPublicacao());?><!--" tabindex="--><?//=PaginaSEI::getInstance()->getProxTabDados()?><!--" />-->
<!--  <img id="imgCalPublicacao" title="Selecionar Data de Publica��o" alt="Selecionar Data de Publica��o" src="--><?//=PaginaSEI::getInstance()->getIconeCalendario();?><!--" class="infraImg" onclick="infraCalendario('txtPublicacao',this);" />-->
<?
//PaginaSEI::getInstance()->fecharAreaDados();
?>
  <input type="hidden" id="hdnIdEditalEliminacao" name="hdnIdEditalEliminacao" value="<?=$objEditalEliminacaoDTO->getNumIdEditalEliminacao();?>" />
  <?
  //PaginaSEI::getInstance()->montarAreaDebug();
  //PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  ?>
</form>
<?
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
