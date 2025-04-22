<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/12/2006 - criado por mga
*
*
*/

try {
  require_once dirname(__FILE__) . '/Sip.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  //SessaoSip::getInstance()->validarSessao();
  SessaoSip::getInstance()->validarLink();

  SessaoSip::getInstance()->validarPermissao($_GET['acao']);

  switch ($_GET['acao']) {
    case 'tipo_permissao_excluir':
      try {
        $arrObjTipoPermissaoDTO = array();
        $arrStrId = PaginaSip::getInstance()->getArrStrItensSelecionados();
        for ($i = 0; $i < count($arrStrId); $i++) {
          $objTipoPermissaoDTO = new TipoPermissaoDTO();
          $objTipoPermissaoDTO->setNumIdTipoPermissao($arrStrId[$i]);
          $arrObjTipoPermissaoDTO[] = $objTipoPermissaoDTO;
        }
        $objTipoPermissaoRN = new TipoPermissaoRN();
        $objTipoPermissaoRN->excluir($arrObjTipoPermissaoDTO);
      } catch (Exception $e) {
        PaginaSip::getInstance()->processarExcecao($e);
      }
      break;

    case 'tipo_permissao_listar':
      break;

    default:
      throw new InfraException("A��o '" . $_GET['acao'] . "' n�o reconhecida.");
  }

  $arrComandos = array();
  if (SessaoSip::getInstance()->verificarPermissao('tipo_permissao_cadastrar')) {
    $arrComandos[] = '<input type="button" id="btnNovo" value="Novo" onclick="location.href=\'' . SessaoSip::getInstance()->assinarLink('controlador.php?acao=tipo_permissao_cadastrar') . '\';" class="infraButton" />';
  }
  $objTipoPermissaoDTO = new TipoPermissaoDTO();
  $objTipoPermissaoDTO->retTodos();
  $objTipoPermissaoDTO->setOrdStrDescricao(InfraDTO::$TIPO_ORDENACAO_ASC);
  $objTipoPermissaoRN = new TipoPermissaoRN();
  $arrObjTipoPermissaoDTO = $objTipoPermissaoRN->listar($objTipoPermissaoDTO);

  $numRegistros = count($arrObjTipoPermissaoDTO);

  if ($numRegistros > 0) {
    //$bolAcaoConsultar = SessaoSip::getInstance()->verificarPermissao('tipo_permissao_consultar');
    $bolAcaoAlterar = SessaoSip::getInstance()->verificarPermissao('tipo_permissao_alterar');
    $bolAcaoExcluir = SessaoSip::getInstance()->verificarPermissao('tipo_permissao_excluir');
    //Montar a��es m�ltiplas
    $bolCheck = false;
    if ($bolAcaoExcluir) {
      $bolCheck = true;
      $arrComandos[] = '<input type="button" id="btnExcluir" value="Excluir" onclick="acaoExclusaoMultipla();" class="infraButton" />';
      $strLinkExcluir = SessaoSip::getInstance()->assinarLink('tipo_permissao_lista.php?acao=tipo_permissao_excluir');
    }

    $arrComandos[] = '<input type="button" id="btnImprimir" value="Imprimir" onclick="infraImprimirTabela();" class="infraButton" />';

    $strResultado = '';
    $strResultado .= '<table width="50%" class="infraTable" summary="Tabela de Tipos de Permiss�o cadastrados">' . "\n";
    $strResultado .= '<caption class="infraCaption">' . PaginaSip::getInstance()->gerarCaptionTabela('Tipos de Permiss�o', $numRegistros) . '</caption>';
    $strResultado .= '<tr>';
    if ($bolCheck) {
      $strResultado .= '<th class="infraTh" width="1%">' . PaginaSip::getInstance()->getThCheck() . '</th>';
    }
    $strResultado .= '<th class="infraTh">Descri��o</th>';
    $strResultado .= '<th class="infraTh">A��es</th>';
    $strResultado .= '</tr>' . "\n";
    for ($i = 0; $i < $numRegistros; $i++) {
      if (($i + 2) % 2) {
        $strResultado .= '<tr class="infraTrEscura">';
      } else {
        $strResultado .= '<tr class="infraTrClara">';
      }
      if ($bolCheck) {
        $strResultado .= '<td valign="center">' . PaginaSip::getInstance()->getTrCheck($i, $arrObjTipoPermissaoDTO[$i]->getNumIdTipoPermissao(), $arrObjTipoPermissaoDTO[$i]->getStrDescricao()) . '</td>';
      }
      $strResultado .= '<td>' . PaginaSip::tratarHTML($arrObjTipoPermissaoDTO[$i]->getStrDescricao()) . '</td>';
      $strResultado .= '<td align="center">';
      //if ($bolAcaoConsultar){
      //  $strResultado .= '<a href="'.SessaoSip::getInstance()->assinarLink('controlador.php?acao=tipo_permissao_consultar&id_tipo_permissao='.$arrObjTipoPermissaoDTO[$i]->getNumIdTipoPermissao())).'" tabindex="'.PaginaSip::getInstance()->getProxTabDados().'"><img src="'.PaginaSip::getInstance()->getIconeConsultar().'" title="Consultar Tipo de Permiss�o" alt="Consultar Tipo de Permiss�o" class="infraImg" /></a>&nbsp;';
      //}

      if ($bolAcaoAlterar) {
        $strResultado .= '<a href="' . SessaoSip::getInstance()->assinarLink('controlador.php?acao=tipo_permissao_alterar&id_tipo_permissao=' . $arrObjTipoPermissaoDTO[$i]->getNumIdTipoPermissao()) . '" tabindex="' . PaginaSip::getInstance()->getProxTabDados() . '"><img src="' . PaginaSip::getInstance()->getIconeAlterar() . '" title="Alterar Tipo de Permiss�o" alt="Alterar Tipo de Permiss�o" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoExcluir) {
        $strResultado .= '<a onclick="acaoExcluir(\'' . $arrObjTipoPermissaoDTO[$i]->getNumIdTipoPermissao() . '\',\'' . PaginaSip::formatarParametrosJavaScript($arrObjTipoPermissaoDTO[$i]->getStrDescricao()) . '\');" tabindex="' . PaginaSip::getInstance()->getProxTabDados() . '"><img src="' . PaginaSip::getInstance()->getIconeExcluir() . '" title="Excluir Tipo de Permiss�o" alt="Excluir Tipo de Permiss�o" class="infraImg" /></a>&nbsp;';
      }

      $strResultado .= '</td></tr>' . "\n";
    }
    $strResultado .= '</table>';
  }
  $arrComandos[] = '<input type="button" id="btnFechar" value="Fechar" onclick="location.href=\'' . SessaoSip::getInstance()->assinarLink('controlador.php?acao=' . PaginaSip::getInstance()->getAcaoRetorno() . '&acao_origem=' . $_GET['acao']) . '\'" class="infraButton" />';
} catch (Exception $e) {
  PaginaSip::getInstance()->processarExcecao($e);
}

PaginaSip::getInstance()->montarDocType();
PaginaSip::getInstance()->abrirHtml();
PaginaSip::getInstance()->abrirHead();
PaginaSip::getInstance()->montarMeta();
PaginaSip::getInstance()->montarTitle(PaginaSip::getInstance()->getStrNomeSistema() . ' - Tipos de Permiss�o');
PaginaSip::getInstance()->montarStyle();
PaginaSip::getInstance()->abrirStyle();
?>
<?
PaginaSip::getInstance()->fecharStyle();
PaginaSip::getInstance()->montarJavaScript();
PaginaSip::getInstance()->abrirJavaScript();
?>
  function inicializar(){
  if ('<?=$_GET['acao']?>'=='tipo_permissao_selecionar'){
  infraReceberSelecao();
  }
  infraEfeitoTabelas();
  }

<?
if ($bolAcaoExcluir) { ?>
  function acaoExcluir(id,desc){
  if (confirm("Confirma exclus�o do Tipo de Permiss�o \""+desc+"\"?")){
  document.getElementById('hdnInfraItensSelecionados').value=id;
  document.getElementById('frmTipoPermissaoLista').action='<?=$strLinkExcluir?>';
  document.getElementById('frmTipoPermissaoLista').submit();
  }
  }

  function acaoExclusaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
  alert('Nenhum Tipo de Permiss�o selecionado.');
  return;
  }
  if (confirm("Confirma exclus�o dos Tipos de Permiss�o selecionados?")){
  document.getElementById('frmTipoPermissaoLista').action='<?=$strLinkExcluir?>';
  document.getElementById('frmTipoPermissaoLista').submit();
  }
  }
  <?
} ?>

<?
PaginaSip::getInstance()->fecharJavaScript();
PaginaSip::getInstance()->fecharHead();
PaginaSip::getInstance()->abrirBody('Tipos de Permiss�o', 'onload="inicializar();"');
?>
  <form id="frmTipoPermissaoLista" method="post" action="<?=SessaoSip::getInstance()->assinarLink('tipo_permissao_lista.php?acao=' . $_GET['acao'] . '&acao_origem=' . $_GET['acao'])?>">
    <?
    //PaginaSip::getInstance()->montarBarraLocalizacao('Tipos de Permiss�o');
    PaginaSip::getInstance()->montarBarraComandosSuperior($arrComandos);
    //PaginaSip::getInstance()->abrirAreaDados('5em');
    //PaginaSip::getInstance()->fecharAreaDados();
    PaginaSip::getInstance()->montarAreaTabela($strResultado, $numRegistros);
    //PaginaSip::getInstance()->montarAreaDebug();
    PaginaSip::getInstance()->montarBarraComandosInferior($arrComandos);
    ?>
  </form>
<?
PaginaSip::getInstance()->fecharBody();
PaginaSip::getInstance()->fecharHtml();
?>