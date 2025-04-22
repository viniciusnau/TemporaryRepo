<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/11/2013 - criado por mga
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

  PaginaSEI::getInstance()->prepararSelecao('tipo_conferencia_selecionar');

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  switch($_GET['acao']){
    case 'tipo_conferencia_excluir':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjTipoConferenciaDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objTipoConferenciaDTO = new TipoConferenciaDTO();
          $objTipoConferenciaDTO->setNumIdTipoConferencia($arrStrIds[$i]);
          $arrObjTipoConferenciaDTO[] = $objTipoConferenciaDTO;
        }
        $objTipoConferenciaRN = new TipoConferenciaRN();
        $objTipoConferenciaRN->excluir($arrObjTipoConferenciaDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;


    case 'tipo_conferencia_desativar':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjTipoConferenciaDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objTipoConferenciaDTO = new TipoConferenciaDTO();
          $objTipoConferenciaDTO->setNumIdTipoConferencia($arrStrIds[$i]);
          $arrObjTipoConferenciaDTO[] = $objTipoConferenciaDTO;
        }
        $objTipoConferenciaRN = new TipoConferenciaRN();
        $objTipoConferenciaRN->desativar($arrObjTipoConferenciaDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;

    case 'tipo_conferencia_reativar':
      $strTitulo = 'Reativar Tipos de Confer�ncia';
      if ($_GET['acao_confirmada']=='sim'){
        try{
          $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
          $arrObjTipoConferenciaDTO = array();
          for ($i=0;$i<count($arrStrIds);$i++){
            $objTipoConferenciaDTO = new TipoConferenciaDTO();
            $objTipoConferenciaDTO->setNumIdTipoConferencia($arrStrIds[$i]);
            $arrObjTipoConferenciaDTO[] = $objTipoConferenciaDTO;
          }
          $objTipoConferenciaRN = new TipoConferenciaRN();
          $objTipoConferenciaRN->reativar($arrObjTipoConferenciaDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        } 
        header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
        die;
      } 
      break;


    case 'tipo_conferencia_selecionar':
      $strTitulo = PaginaSEI::getInstance()->getTituloSelecao('Selecionar Tipo de Confer�ncia','Selecionar Tipos de Confer�ncia');

      //Se cadastrou alguem
      if ($_GET['acao_origem']=='tipo_conferencia_cadastrar'){
        if (isset($_GET['id_tipo_conferencia'])){
          PaginaSEI::getInstance()->adicionarSelecionado($_GET['id_tipo_conferencia']);
        }
      }
      break;

    case 'tipo_conferencia_listar':
      $strTitulo = 'Tipos de Confer�ncia';
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $arrComandos = array();
  if ($_GET['acao'] == 'tipo_conferencia_selecionar'){
    $arrComandos[] = '<button type="button" accesskey="T" id="btnTransportarSelecao" value="Transportar" onclick="infraTransportarSelecao();" class="infraButton"><span class="infraTeclaAtalho">T</span>ransportar</button>';
  }

  if ($_GET['acao'] == 'tipo_conferencia_listar' || $_GET['acao'] == 'tipo_conferencia_selecionar'){
    $bolAcaoCadastrar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_cadastrar');
    if ($bolAcaoCadastrar){
      $arrComandos[] = '<button type="button" accesskey="N" id="btnNovo" value="Novo" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_cadastrar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">N</span>ovo</button>';
    }
  }

  $objTipoConferenciaDTO = new TipoConferenciaDTO();
  $objTipoConferenciaDTO->retNumIdTipoConferencia();
  $objTipoConferenciaDTO->retStrDescricao();

  if ($_GET['acao'] == 'tipo_conferencia_reativar'){
    //Lista somente inativos
    $objTipoConferenciaDTO->setBolExclusaoLogica(false);
    $objTipoConferenciaDTO->setStrSinAtivo('N');
  }

  PaginaSEI::getInstance()->prepararOrdenacao($objTipoConferenciaDTO, 'Descricao', InfraDTO::$TIPO_ORDENACAO_ASC);
  //PaginaSEI::getInstance()->prepararPaginacao($objTipoConferenciaDTO);

  $objTipoConferenciaRN = new TipoConferenciaRN();
  $arrObjTipoConferenciaDTO = $objTipoConferenciaRN->listar($objTipoConferenciaDTO);

  //PaginaSEI::getInstance()->processarPaginacao($objTipoConferenciaDTO);
  $numRegistros = count($arrObjTipoConferenciaDTO);

  if ($numRegistros > 0){

    $bolCheck = false;

    if ($_GET['acao']=='tipo_conferencia_selecionar'){
      $bolAcaoReativar = false;
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_consultar');
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_alterar');
      $bolAcaoImprimir = false;
      //$bolAcaoGerarPlanilha = false;
      $bolAcaoExcluir = false;
      $bolAcaoDesativar = false;
      $bolCheck = true;
    }else if ($_GET['acao']=='tipo_conferencia_reativar'){
      $bolAcaoReativar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_reativar');
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_consultar');
      $bolAcaoAlterar = false;
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_excluir');
      $bolAcaoDesativar = false;
    }else{
      $bolAcaoReativar = false;
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_consultar');
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_alterar');
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_excluir');
      $bolAcaoDesativar = SessaoSEI::getInstance()->verificarPermissao('tipo_conferencia_desativar');
    }

    
    if ($bolAcaoDesativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="t" id="btnDesativar" value="Desativar" onclick="acaoDesativacaoMultipla();" class="infraButton">Desa<span class="infraTeclaAtalho">t</span>ivar</button>';
      $strLinkDesativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_desativar&acao_origem='.$_GET['acao']);
    }

    if ($bolAcaoReativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="R" id="btnReativar" value="Reativar" onclick="acaoReativacaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">R</span>eativar</button>';
      $strLinkReativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_reativar&acao_origem='.$_GET['acao'].'&acao_confirmada=sim');
    }
    

    if ($bolAcaoExcluir){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="E" id="btnExcluir" value="Excluir" onclick="acaoExclusaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">E</span>xcluir</button>';
      $strLinkExcluir = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_excluir&acao_origem='.$_GET['acao']);
    }

    /*
    if ($bolAcaoGerarPlanilha){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="P" id="btnGerarPlanilha" value="Gerar Planilha" onclick="infraGerarPlanilhaTabela(\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=infra_gerar_planilha_tabela')).'\');" class="infraButton">Gerar <span class="infraTeclaAtalho">P</span>lanilha</button>';
    }
    */

    $strResultado = '';

    if ($_GET['acao']!='tipo_conferencia_reativar'){
      $strSumarioTabela = 'Tabela de Tipos de Confer�ncia.';
      $strCaptionTabela = 'Tipos de Confer�ncia';
    }else{
      $strSumarioTabela = 'Tabela de Tipos de Confer�ncia Inativos.';
      $strCaptionTabela = 'Tipos de Confer�ncia Inativos';
    }

    $strResultado .= '<table width="99%" class="infraTable" summary="'.$strSumarioTabela.'">'."\n";
    $strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela($strCaptionTabela,$numRegistros).'</caption>';
    $strResultado .= '<tr>';
    if ($bolCheck) {
      $strResultado .= '<th class="infraTh" width="1%">'.PaginaSEI::getInstance()->getThCheck().'</th>'."\n";
    }
    $strResultado .= '<th class="infraTh">'.PaginaSEI::getInstance()->getThOrdenacao($objTipoConferenciaDTO,'Descri��o','Descricao',$arrObjTipoConferenciaDTO).'</th>'."\n";
    $strResultado .= '<th class="infraTh" width="15%">A��es</th>'."\n";
    $strResultado .= '</tr>'."\n";
    $strCssTr='';
    for($i = 0;$i < $numRegistros; $i++){

      $strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
      $strResultado .= $strCssTr;

      if ($bolCheck){
        $strResultado .= '<td valign="top">'.PaginaSEI::getInstance()->getTrCheck($i,$arrObjTipoConferenciaDTO[$i]->getNumIdTipoConferencia(),$arrObjTipoConferenciaDTO[$i]->getStrDescricao()).'</td>';
      }
      $strResultado .= '<td>'.PaginaSEI::tratarHTML($arrObjTipoConferenciaDTO[$i]->getStrDescricao()).'</td>';
      $strResultado .= '<td align="center">';

      $strResultado .= PaginaSEI::getInstance()->getAcaoTransportarItem($i,$arrObjTipoConferenciaDTO[$i]->getNumIdTipoConferencia());

      if ($bolAcaoConsultar){
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_consultar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_conferencia='.$arrObjTipoConferenciaDTO[$i]->getNumIdTipoConferencia()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeConsultar().'" title="Consultar Tipo de Confer�ncia" alt="Consultar Tipo de Confer�ncia" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoAlterar){
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_conferencia_alterar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_conferencia='.$arrObjTipoConferenciaDTO[$i]->getNumIdTipoConferencia()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeAlterar().'" title="Alterar Tipo de Confer�ncia" alt="Alterar Tipo de Confer�ncia" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoDesativar || $bolAcaoReativar || $bolAcaoExcluir){
        $strId = $arrObjTipoConferenciaDTO[$i]->getNumIdTipoConferencia();
        $strDescricao = PaginaSEI::getInstance()->formatarParametrosJavaScript($arrObjTipoConferenciaDTO[$i]->getStrDescricao());
      }

      if ($bolAcaoDesativar){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoDesativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeDesativar().'" title="Desativar Tipo de Confer�ncia" alt="Desativar Tipo de Confer�ncia" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoReativar){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoReativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeReativar().'" title="Reativar Tipo de Confer�ncia" alt="Reativar Tipo de Confer�ncia" class="infraImg" /></a>&nbsp;';
      }


      if ($bolAcaoExcluir){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoExcluir(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeExcluir().'" title="Excluir Tipo de Confer�ncia" alt="Excluir Tipo de Confer�ncia" class="infraImg" /></a>&nbsp;';
      }

      $strResultado .= '</td></tr>'."\n";
    }
    $strResultado .= '</table>';
  }
  if ($_GET['acao'] == 'tipo_conferencia_selecionar'){
    $arrComandos[] = '<button type="button" accesskey="F" id="btnFecharSelecao" value="Fechar" onclick="window.close();" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
  }else{
    $arrComandos[] = '<button type="button" accesskey="F" id="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
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
<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>

function inicializar(){
  if ('<?=$_GET['acao']?>'=='tipo_conferencia_selecionar'){
    infraReceberSelecao();
    document.getElementById('btnFecharSelecao').focus();
  }else{
    document.getElementById('btnFechar').focus();
  }
  infraEfeitoTabelas();
}

<? if ($bolAcaoDesativar){ ?>
function acaoDesativar(id,desc){
  if (confirm("Confirma desativa��o do Tipo de Confer�ncia \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}

function acaoDesativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Confer�ncia selecionado.');
    return;
  }
  if (confirm("Confirma desativa��o dos Tipos de Confer�ncia selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoReativar){ ?>
function acaoReativar(id,desc){
  if (confirm("Confirma reativa��o do Tipo de Confer�ncia \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}

function acaoReativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Confer�ncia selecionado.');
    return;
  }
  if (confirm("Confirma reativa��o dos Tipos de Confer�ncia selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoExcluir){ ?>
function acaoExcluir(id,desc){
  if (confirm("Confirma exclus�o do Tipo de Confer�ncia \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}

function acaoExclusaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Confer�ncia selecionado.');
    return;
  }
  if (confirm("Confirma exclus�o dos Tipos de Confer�ncia selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoConferenciaLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmTipoConferenciaLista').submit();
  }
}
<? } ?>

<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmTipoConferenciaLista" method="post" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
  <?
  PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
  //PaginaSEI::getInstance()->abrirAreaDados('5em');
  //PaginaSEI::getInstance()->fecharAreaDados();
  PaginaSEI::getInstance()->montarAreaTabela($strResultado,$numRegistros);
  //PaginaSEI::getInstance()->montarAreaDebug();
  PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  ?>
</form>
<?
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>