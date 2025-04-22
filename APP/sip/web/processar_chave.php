<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/07/2018 - criado por mga
*
*
*/

try {
  require_once dirname(__FILE__) . '/Sip.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(true);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  foreach ($_POST as $item) {
    if (is_array($item)) {
      die('Link inv�lido.');
    }
  }

  if (count($_GET) > 1) {
    die('Link inv�lido.');
  }

  foreach ($_GET as $chave => $valor) {
    if (!in_array($chave, array('chave_ativacao', 'chave_desativacao', 'chave_bloqueio'))) {
      die('Link inv�lido.');
    }

    if ($valor == '' || strlen($valor) > 154 || preg_match("/[^0-9a-zA-Z]/", $valor)) {
      die('Link inv�lido.');
    }
  }

  SessaoSip::getInstance(false)->simularLogin();

  $objCodigoAcessoRN = new CodigoAcessoRN();

  $strMsgConfirmacao = '';
  $strMsgResultado = '';

  if (isset($_POST['sbmConfirmacao'])) {
    if (isset($_GET['chave_ativacao'])) {
      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setStrChaveAtivacaoExterna($_GET['chave_ativacao']);
      $objCodigoAcessoDTO = $objCodigoAcessoRN->confirmarAtivacao($objCodigoAcessoDTO);

      $strMsgResultado = 'A autentica��o em 2 fatores foi ativada.';
    } else {
      if (isset($_GET['chave_desativacao'])) {
        $objCodigoAcessoDTO = new CodigoAcessoDTO();
        $objCodigoAcessoDTO->setStrChaveDesativacaoExterna($_GET['chave_desativacao']);
        $objCodigoAcessoDTO = $objCodigoAcessoRN->confirmarDesativacao($objCodigoAcessoDTO);

        $strMsgResultado = 'A autentica��o em 2 fatores foi desativada.';
      } else {
        if (isset($_GET['chave_bloqueio'])) {
          $objCodigoAcessoDTO = new CodigoAcessoDTO();
          $objCodigoAcessoDTO->setStrChaveBloqueioExterna($_GET['chave_bloqueio']);
          $objCodigoAcessoDTO = $objCodigoAcessoRN->confirmarBloqueioUsuario($objCodigoAcessoDTO);

          $strMsgResultado = 'Conta de usu�rio bloqueada no sistema.';
        }
      }
    }

    if ($objCodigoAcessoDTO == null) {
      die('Link inv�lido.');
    }
  } else {
    $objCodigoAcessoDTO = new CodigoAcessoDTO();
    $objCodigoAcessoDTO->setBolExclusaoLogica(false);
    $objCodigoAcessoDTO->retStrSiglaUsuario();
    $objCodigoAcessoDTO->retStrSiglaOrgaoUsuario();
    $objCodigoAcessoDTO->retStrSiglaSistema();
    $objCodigoAcessoDTO->retStrSiglaOrgaoSistema();

    $strChaveExterna = '';
    if (isset($_GET['chave_ativacao'])) {
      $strChaveExterna = $_GET['chave_ativacao'];
    } else {
      if (isset($_GET['chave_desativacao'])) {
        $strChaveExterna = $_GET['chave_desativacao'];
      } else {
        if (isset($_GET['chave_bloqueio'])) {
          $strChaveExterna = $_GET['chave_bloqueio'];
        }
      }
    }

    $objCodigoAcessoDTO->setStrIdCodigoAcesso(strtoupper(substr($strChaveExterna, 0, 26)));
    $objCodigoAcessoDTO = $objCodigoAcessoRN->consultar($objCodigoAcessoDTO);

    if ($objCodigoAcessoDTO == null) {
      die('Link inv�lido.');
    }

    if (isset($_GET['chave_ativacao'])) {
      $strMsgConfirmacao = 'Confirma ativa��o da autentica��o em 2 fatores para o sistema <b>' . $objCodigoAcessoDTO->getStrSiglaSistema() . '</b>?';
    } else {
      if (isset($_GET['chave_desativacao'])) {
        $strMsgConfirmacao = 'Confirma desativa��o da autentica��o em 2 fatores para o sistema <b>' . $objCodigoAcessoDTO->getStrSiglaSistema() . '</b>?';
      } else {
        if (isset($_GET['chave_bloqueio'])) {
          $strMsgConfirmacao = 'Confirma bloqueio da conta de usu�rio <b>' . $objCodigoAcessoDTO->getStrSiglaUsuario() . ' (' . $objCodigoAcessoDTO->getStrSiglaOrgaoUsuario() . ')</b>?';
        }
      }
    }
  }

  PaginaLogin::getInstance()->setObjSistemaDTO(LoginINT::obterSistema($objCodigoAcessoDTO->getStrSiglaSistema(), $objCodigoAcessoDTO->getStrSiglaOrgaoSistema()));
} catch (Exception $e) {
  if ($e instanceof InfraException && $e->contemValidacoes()) {
    $strMsgResultado = $e->__toString();
  } else {
    try {
      LogSip::getInstance()->gravar(InfraException::inspecionar($e));
    } catch (Exception $e2) {
    }
    PaginaLogin::getInstance()->processarExcecao($e);
  }
}
PaginaLogin::getInstance()->montarDocType();
PaginaLogin::getInstance()->abrirHtml();
PaginaLogin::getInstance()->abrirHead();
PaginaLogin::getInstance()->montarMeta();
PaginaLogin::getInstance()->montarTitle('Autentica��o em 2 Fatores');
PaginaLogin::getInstance()->montarStyle();
PaginaLogin::getInstance()->abrirStyle();
?>
#lblConfirmacao {position:absolute;left:2%;top:20%;font-size:1rem;}
#sbmConfirmacao {position:absolute;left:2%;top:60%;}
<?
PaginaLogin::getInstance()->fecharStyle();
PaginaLogin::getInstance()->montarJavaScript();
PaginaLogin::getInstance()->fecharHead();
PaginaLogin::getInstance()->abrirBody();
?>
<form id="frmProcessarChaveAcesso" method="post">
  <?
  if (isset($_POST['sbmConfirmacao'])) {
    echo '<div class="infraAreaValidacao">' . $strMsgResultado . '<div>';
  } else {
    PaginaLogin::getInstance()->abrirAreaDados('10em');
    ?>
    <label id="lblConfirmacao" class="infraLabelOpcional"><?=$strMsgConfirmacao?></label>
    <button type="submit" id="sbmConfirmacao" name="sbmConfirmacao" class="infraButton">Confirmar</button>
    <?
    PaginaLogin::getInstance()->fecharAreaDados();
    //PaginaSip::getInstance()->montarAreaDebug();
    //PaginaSip::getInstance()->montarBarraComandosInferior($arrComandos);
  }
  ?>
</form>
<?
PaginaLogin::getInstance()->fecharBody();
PaginaLogin::getInstance()->fecharHtml();
?>
