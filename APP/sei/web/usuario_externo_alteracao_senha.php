<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 27/04/2012 - criado por mga
*/

try {
  require_once dirname(__FILE__).'/SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////
	
  SessaoSEIExterna::getInstance()->validarLink();

  $numTamSenhaUsuarioExterno = ConfiguracaoSEI::getInstance()->getValor('SEI', 'TamSenhaUsuarioExterno', false, TAM_SENHA_USUARIO_EXTERNO);

  global $SEI_MODULOS;
  $bolAutenticacaoExterna = false;

  switch($_GET['acao']){
    
      case 'usuario_externo_alterar_senha':

        $objUsuarioDTO = new UsuarioDTO();
        $objUsuarioDTO->setBolExclusaoLogica(false);
        $objUsuarioDTO->retNumIdUsuario();
        $objUsuarioDTO->retStrSigla();
        $objUsuarioDTO->retStrNome();
        $objUsuarioDTO->retStrStaTipo();
        $objUsuarioDTO->setNumIdUsuario(SessaoSEIExterna::getInstance()->getNumIdUsuarioExterno());

        $objUsuarioRN = new UsuarioRN();
        $objUsuarioDTO = $objUsuarioRN->consultarRN0489($objUsuarioDTO);

        $objUsuarioAPI = new UsuarioAPI();
        $objUsuarioAPI->setIdUsuario($objUsuarioDTO->getNumIdUsuario());
        $objUsuarioAPI->setSigla($objUsuarioDTO->getStrSigla());
        $objUsuarioAPI->setNome($objUsuarioDTO->getStrNome());
        $objUsuarioAPI->setStaTipo($objUsuarioDTO->getStrStaTipo());

        foreach ($SEI_MODULOS as $seiModulo) {
          if ($seiModulo->executar('verificarLoginExterno', $objUsuarioAPI)===true) {
            PaginaSEIExterna::getInstance()->adicionarMensagem('Usu�rio autenticado externamente, n�o � poss�vel alterar a senha.');
            $bolAutenticacaoExterna=true;
         }
        }

      $strTitulo = 'Altera��o de Senha';
      
      if (isset($_POST['sbmSalvar'])) {
        
      	$objUsuarioDTO = new UsuarioDTO();
      	$objUsuarioDTO->setStrSenha($_POST['pwdSenhaAtual']);
      	$objUsuarioDTO->setStrSenhaNova($_POST['pwdSenhaNova']);
        $objUsuarioDTO->setNumIdUsuario(SessaoSEIExterna::getInstance()->getNumIdUsuarioExterno());

      	$objUsuarioRN = new UsuarioRN();
      	$objUsuarioRN->alterarSenha($objUsuarioDTO);
      	
      	PaginaSEIExterna::getInstance()->adicionarMensagem('Senha alterada com sucesso.');
        header('Location: '.SessaoSEIExterna::getInstance()->assinarLink('controlador_externo.php?acao=usuario_externo_principal'));
        die;
      }
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

}catch(Exception $e){
  PaginaSEIExterna::getInstance()->processarExcecao($e, true);
} 

PaginaSEIExterna::getInstance()->montarDocType();
PaginaSEIExterna::getInstance()->abrirHtml();
PaginaSEIExterna::getInstance()->abrirHead();
PaginaSEIExterna::getInstance()->montarMeta();
PaginaSEIExterna::getInstance()->montarTitle(PaginaSEIExterna::getInstance()->getStrNomeSistema().' - '.$strTitulo);
PaginaSEIExterna::getInstance()->montarStyle();
PaginaSEIExterna::getInstance()->abrirStyle();
?>

#lblSenhaAtual {position:absolute;left:0%;top:0%;}
#pwdSenhaAtual {position:absolute;left:0%;top:12%;width:18em;}

#lblSenhaNova {position:absolute;left:0%;top:30%;}
#pwdSenhaNova {position:absolute;left:0%;top:42%;width:18em;}

#lblSenhaConfirma {position:absolute;left:0%;top:60%;}
#pwdSenhaConfirma {position:absolute;left:0%;top:72%;width:18em;}

#sbmSalvar {width:8em;}
#btnCancelar {width:8em;}

<?
PaginaSEIExterna::getInstance()->fecharStyle();
PaginaSEIExterna::getInstance()->montarJavaScript();
PaginaSEIExterna::getInstance()->abrirJavaScript();
?>
function inicializar(){
  <?if(!$bolAutenticacaoExterna){?>
  document.getElementById('pwdSenhaAtual').focus();
  <?}?>
}

function OnSubmitForm() {
  return validarForm();
}

function validarForm() {

  if (infraTrim(document.getElementById('pwdSenhaAtual').value)=='') {
    alert('Informe a Senha Atual.');
    document.getElementById('pwdSenhaAtual').focus();
    return false;
  }

  if (infraTrim(document.getElementById('pwdSenhaNova').value)=='') {
    alert('Informe a Nova Senha.');
    document.getElementById('pwdSenhaNova').focus();
    return false;
  }
  
  if (infraTrim(document.getElementById('pwdSenhaNova').value).length < <?=$numTamSenhaUsuarioExterno?>) {
    alert('A Nova Senha deve ter pelo menos <?=$numTamSenhaUsuarioExterno?> caracteres.');
    document.getElementById('pwdSenhaNova').focus();
    return false;
  }
  
  if (infraTrim(document.getElementById('pwdSenhaConfirma').value)=='') {
    alert('Repita a Nova Senha.');
    document.getElementById('pwdSenhaConfirma').focus();
    return false;
  }
  
  if (infraTrim(document.getElementById('pwdSenhaNova').value)!=infraTrim(document.getElementById('pwdSenhaConfirma').value)) {
    alert('Confirma��o da Nova Senha n�o confere.');
    document.getElementById('pwdSenhaConfirma').focus();
    return false;
  }

  if (infraTrim(document.getElementById('pwdSenhaAtual').value)==infraTrim(document.getElementById('pwdSenhaNova').value)) {
  alert('O valor do campo Nova Senha � igual ao da Senha Atual.');
  document.getElementById('pwdSenhaNova').focus();
  return false;
  }

  return true;
}
<?
PaginaSEIExterna::getInstance()->fecharJavaScript();
PaginaSEIExterna::getInstance()->fecharHead();
PaginaSEIExterna::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmUsuarioExternoAlteracaoSenha" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEIExterna::getInstance()->assinarLink('controlador_externo.php?acao='.$_GET['acao'])?>">
<?
PaginaSEIExterna::getInstance()->montarBarraComandosSuperior(array());
if(!$bolAutenticacaoExterna){
PaginaSEIExterna::getInstance()->abrirAreaDados('15em');
?>  	
  <label id="lblSenhaAtual" for="pwdSenhaAtual" accesskey="" class="infraLabelObrigatorio">Senha Atual:</label>  
  <?=InfraINT::montarInputPassword('pwdSenhaAtual', PaginaSEIExterna::tratarHTML($_POST['pwdSenhaAtual']), 'tabindex="'.PaginaSEIExterna::getInstance()->getProxTabDados().'"')?>

  <label id="lblSenhaNova" for="pwdSenhaNova" accesskey="" class="infraLabelObrigatorio">Nova Senha (no m�nimo <?=$numTamSenhaUsuarioExterno?> caracteres com letras e n�meros):</label>
  <?=InfraINT::montarInputPassword('pwdSenhaNova', PaginaSEIExterna::tratarHTML($_POST['pwdSenhaNova']), 'tabindex="'.PaginaSEIExterna::getInstance()->getProxTabDados().'"')?>

  <label id="lblSenhaConfirma" for="pwdSenhaConfirma" accesskey="" class="infraLabelObrigatorio">Confirmar Nova Senha:</label>
  <?=InfraINT::montarInputPassword('pwdSenhaConfirma', PaginaSEIExterna::tratarHTML($_POST['pwdSenhaConfirma']), 'tabindex="'.PaginaSEIExterna::getInstance()->getProxTabDados().'"')?>

<?
PaginaSEIExterna::getInstance()->fecharAreaDados();
?>
  <button type="submit" accesskey="S" id="sbmSalvar" name="sbmSalvar" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>&nbsp;&nbsp;
  <button type="button" accesskey="C" id="btnCancelar" name="btnCancelar" value="Cancelar" onclick="location.href='<?=SessaoSEIExterna::getInstance()->assinarLink('controlador_externo.php?acao=usuario_externo_principal&acao_origem='.$_GET['acao'])?>';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>

</form>
<?
}
PaginaSEIExterna::getInstance()->montarAreaDebug();
PaginaSEIExterna::getInstance()->fecharBody();
PaginaSEIExterna::getInstance()->fecharHtml();
?>