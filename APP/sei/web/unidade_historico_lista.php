<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/07/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
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

  PaginaSEI::getInstance()->prepararSelecao('unidade_historico_selecionar');

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  SessaoSEI::getInstance()->setArrParametrosRepasseLink(array('id_unidade','arvore'));

  switch($_GET['acao']){
    case 'unidade_historico_excluir':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjUnidadeHistoricoDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objUnidadeHistoricoDTO = new UnidadeHistoricoDTO();
          $objUnidadeHistoricoDTO->setNumIdUnidadeHistorico($arrStrIds[$i]);
          $arrObjUnidadeHistoricoDTO[] = $objUnidadeHistoricoDTO;
        }
        $objUnidadeHistoricoRN = new UnidadeHistoricoRN();
        $objUnidadeHistoricoRN->excluir($arrObjUnidadeHistoricoDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;

/* 
    case 'unidade_historico_desativar':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjUnidadeHistoricoDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objUnidadeHistoricoDTO = new UnidadeHistoricoDTO();
          $objUnidadeHistoricoDTO->setNumIdUnidadeHistorico($arrStrIds[$i]);
          $arrObjUnidadeHistoricoDTO[] = $objUnidadeHistoricoDTO;
        }
        $objUnidadeHistoricoRN = new UnidadeHistoricoRN();
        $objUnidadeHistoricoRN->desativar($arrObjUnidadeHistoricoDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;

    case 'unidade_historico_reativar':
      $strTitulo = 'Reativar Hist�ricos das Unidades';
      if ($_GET['acao_confirmada']=='sim'){
        try{
          $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
          $arrObjUnidadeHistoricoDTO = array();
          for ($i=0;$i<count($arrStrIds);$i++){
            $objUnidadeHistoricoDTO = new UnidadeHistoricoDTO();
            $objUnidadeHistoricoDTO->setNumIdUnidadeHistorico($arrStrIds[$i]);
            $arrObjUnidadeHistoricoDTO[] = $objUnidadeHistoricoDTO;
          }
          $objUnidadeHistoricoRN = new UnidadeHistoricoRN();
          $objUnidadeHistoricoRN->reativar($arrObjUnidadeHistoricoDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        } 
        header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
        die;
      } 
      break;

 */
    case 'unidade_historico_selecionar':
      $strTitulo = PaginaSEI::getInstance()->getTituloSelecao('Selecionar Hist�rico da Unidade','Selecionar Hist�ricos da Unidade');

      //Se cadastrou alguem
      if ($_GET['acao_origem']=='unidade_historico_cadastrar'){
        if (isset($_GET['id_unidade_historico'])){
          PaginaSEI::getInstance()->adicionarSelecionado($_GET['id_unidade_historico']);
        }
      }
      break;

    case 'unidade_historico_listar':
      $strTitulo = 'Hist�rico da Unidade';
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $arrComandos = array();
  if ($_GET['acao'] == 'unidade_historico_selecionar'){
    $arrComandos[] = '<button type="button" accesskey="T" id="btnTransportarSelecao" value="Transportar" onclick="infraTransportarSelecao();" class="infraButton"><span class="infraTeclaAtalho">T</span>ransportar</button>';
  }

  /* if ($_GET['acao'] == 'unidade_historico_listar' || $_GET['acao'] == 'unidade_historico_selecionar'){ */
    $bolAcaoCadastrar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_cadastrar');
    if ($bolAcaoCadastrar){
      $arrComandos[] = '<button type="button" accesskey="N" id="btnNovo" value="Novo" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_cadastrar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">N</span>ovo</button>';
    }
  /* } */

  $objUnidadeHistoricoDTO = new UnidadeHistoricoDTO();
  $objUnidadeHistoricoDTO->retNumIdUnidadeHistorico();
  $objUnidadeHistoricoDTO->retStrSigla();
  $objUnidadeHistoricoDTO->retStrDescricao();
  $objUnidadeHistoricoDTO->retDtaInicio();
  $objUnidadeHistoricoDTO->retDtaFim();
  $objUnidadeHistoricoDTO->retStrSiglaOrgao();
  $objUnidadeHistoricoDTO->retStrDescricaoOrgao();
  $objUnidadeHistoricoDTO->setNumIdUnidade($_GET['id_unidade']);

  /*
    if ($_GET['acao'] == 'unidade_historico_reativar'){
      //Lista somente inativos
      $objUnidadeHistoricoDTO->setBolExclusaoLogica(false);
      $objUnidadeHistoricoDTO->setStrSinAtivo('N');
    }
   */
  $objUnidadeHistoricoDTO->setOrdDtaInicio(InfraDTO::$TIPO_ORDENACAO_ASC);

  //PaginaSEI::getInstance()->prepararPaginacao($objUnidadeHistoricoDTO);

  $objUnidadeHistoricoRN = new UnidadeHistoricoRN();
  $arrObjUnidadeHistoricoDTO = $objUnidadeHistoricoRN->listar($objUnidadeHistoricoDTO);

  //PaginaSEI::getInstance()->processarPaginacao($objUnidadeHistoricoDTO);
  $numRegistros = count($arrObjUnidadeHistoricoDTO);

  if ($numRegistros > 0){

    $bolCheck = false;

    if ($_GET['acao']=='unidade_historico_selecionar'){
      $bolAcaoReativar = false;
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_consultar');
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_alterar');
      $bolAcaoImprimir = false;
      //$bolAcaoGerarPlanilha = false;
      $bolAcaoExcluir = false;
      $bolAcaoDesativar = false;
      $bolCheck = true;
/*     }else if ($_GET['acao']=='unidade_historico_reativar'){
      $bolAcaoReativar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_reativar');
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_consultar');
      $bolAcaoAlterar = false;
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_excluir');
      $bolAcaoDesativar = false;
 */    }else{
      $bolAcaoReativar = false;
      $bolAcaoConsultar = false;
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_alterar');
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_excluir');
      $bolAcaoDesativar = SessaoSEI::getInstance()->verificarPermissao('unidade_historico_desativar');
    }

    /*
    if ($bolAcaoDesativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="t" id="btnDesativar" value="Desativar" onclick="acaoDesativacaoMultipla();" class="infraButton">Desa<span class="infraTeclaAtalho">t</span>ivar</button>';
      $strLinkDesativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_desativar&acao_origem='.$_GET['acao']);
    }

    if ($bolAcaoReativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="R" id="btnReativar" value="Reativar" onclick="acaoReativacaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">R</span>eativar</button>';
      $strLinkReativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_reativar&acao_origem='.$_GET['acao'].'&acao_confirmada=sim');
    }
     */

    if ($bolAcaoExcluir){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="E" id="btnExcluir" value="Excluir" onclick="acaoExclusaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">E</span>xcluir</button>';
      $strLinkExcluir = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_excluir&acao_origem='.$_GET['acao']);
    }

    /*
    if ($bolAcaoGerarPlanilha){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="P" id="btnGerarPlanilha" value="Gerar Planilha" onclick="infraGerarPlanilhaTabela(\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=infra_gerar_planilha_tabela').'\');" class="infraButton">Gerar <span class="infraTeclaAtalho">P</span>lanilha</button>';
    }
    */

    $strResultado = '';

    /* if ($_GET['acao']!='unidade_historico_reativar'){ */
      $strSumarioTabela = 'Tabela de Hist�ricos da Unidade.';
      $strCaptionTabela = 'Hist�ricos da Unidade';
    /* }else{
      $strSumarioTabela = 'Tabela de Hist�ricos das Unidades Inativos.';
      $strCaptionTabela = 'Hist�ricos das Unidades Inativos';
    } */

    $strResultado .= '<table width="99%" class="infraTable" summary="'.$strSumarioTabela.'">'."\n";
    $strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela($strCaptionTabela,$numRegistros).'</caption>';
    $strResultado .= '<tr>';
    if ($bolCheck) {
      $strResultado .= '<th class="infraTh" width="1%">'.PaginaSEI::getInstance()->getThCheck().'</th>'."\n";
    }
    $strResultado .= '<th class="infraTh" width="10%" >Data Inicial</th>'."\n";
    $strResultado .= '<th class="infraTh" width="10%" >Data Final</th>'."\n";
    $strResultado .= '<th class="infraTh" width="15%" >Sigla</th>'."\n";
    $strResultado .= '<th class="infraTh">Descri��o</th>'."\n";
    $strResultado .= '<th class="infraTh" width="10%" >�rg�o</th>'."\n";

    $strResultado .= '<th class="infraTh" width="10%" >A��es</th>'."\n";

    $strResultado .= '</tr>'."\n";
    $strCssTr='';
    for($i = 0;$i < $numRegistros; $i++){

      $strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
      $strResultado .= $strCssTr;

      if ($bolCheck) {
        if ($arrObjUnidadeHistoricoDTO[$i]->getDtaFim() != null) {
          $strResultado .= '<td valign="top">'.PaginaSEI::getInstance()->getTrCheck($i, $arrObjUnidadeHistoricoDTO[$i]->getNumIdUnidadeHistorico(), $arrObjUnidadeHistoricoDTO[$i]->getStrSigla()).'</td>';
        } else {
          $strResultado .= '<td>&nbsp;</td>';
        }
      }

      $strResultado .= '<td align="center">'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getDtaInicio()).'</td>';
      $strResultado .= '<td align="center">'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getDtaFim()).'</td>';
      $strResultado .= '<td align="center">'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getStrSigla()).'</td>';
      $strResultado .= '<td>'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getStrDescricao()).'</td>';
      $strResultado .= '<td align="center"><a alt="'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getStrDescricaoOrgao()).'" title="'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getStrDescricaoOrgao()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($arrObjUnidadeHistoricoDTO[$i]->getStrSiglaOrgao()).'</a>';

      $strResultado .= '<td align="center">';

      $strResultado .= PaginaSEI::getInstance()->getAcaoTransportarItem($i, $arrObjUnidadeHistoricoDTO[$i]->getNumIdUnidadeHistorico());

      if ($bolAcaoConsultar) {
        //$strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_consultar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_unidade_historico='.$arrObjUnidadeHistoricoDTO[$i]->getNumIdUnidadeHistorico()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeConsultar().'" title="Consultar Hist�rico da Unidade" alt="Consultar Hist�rico da Unidade" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoAlterar && $arrObjUnidadeHistoricoDTO[$i]->getDtaFim() != null) {
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=unidade_historico_alterar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_unidade_historico='.$arrObjUnidadeHistoricoDTO[$i]->getNumIdUnidadeHistorico()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeAlterar().'" title="Alterar Hist�rico da Unidade" alt="Alterar Hist�rico da Unidade" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoDesativar || $bolAcaoReativar || $bolAcaoExcluir) {
        $strId = $arrObjUnidadeHistoricoDTO[$i]->getNumIdUnidadeHistorico();
        $strDescricao = PaginaSEI::getInstance()->formatarParametrosJavaScript($arrObjUnidadeHistoricoDTO[$i]->getStrSigla());
      }
      /*
            if ($bolAcaoDesativar){
              $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoDesativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeDesativar().'" title="Desativar Hist�rico da Unidade" alt="Desativar Hist�rico da Unidade" class="infraImg" /></a>&nbsp;';
            }

            if ($bolAcaoReativar){
              $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoReativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeReativar().'" title="Reativar Hist�rico da Unidade" alt="Reativar Hist�rico da Unidade" class="infraImg" /></a>&nbsp;';
            }
       */

      if ($bolAcaoExcluir && $arrObjUnidadeHistoricoDTO[$i]->getDtaFim() != null) {
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoExcluir(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeExcluir().'" title="Excluir Hist�rico da Unidade" alt="Excluir Hist�rico da Unidade" class="infraImg" /></a>&nbsp;';
      }

      $strResultado .= '</td>'."\n";

      $strResultado .= '</tr>'."\n";
    }
    $strResultado .= '</table>';
  }

  if ($_GET['acao'] == 'unidade_historico_selecionar') {
    $arrComandos[] = '<button type="button" accesskey="F" id="btnFecharSelecao" value="Fechar" onclick="window.close();" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
  } else {
    $arrComandos[] = '<button type="button" accesskey="F" id="btnFechar" value="Fechar" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.PaginaSEI::getInstance()->getAcaoRetorno().'&acao_origem='.$_GET['acao']).PaginaSEI::getInstance()->montarAncora($_GET['id_unidade']).'\'" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
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

<?if(0){?></style><?}?>
<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>
<?if(0){?><script type="text/javascript"><?}?>

function inicializar(){
  if ('<?=$_GET['acao']?>'=='unidade_historico_selecionar'){
    infraReceberSelecao();
    document.getElementById('btnFecharSelecao').focus();
  }else{
    document.getElementById('btnFechar').focus();
  }
  infraEfeitoTabelas(true);
}

<? if ($bolAcaoDesativar){ ?>
function acaoDesativar(id,desc){
  if (confirm("Confirma desativa��o do Hist�rico da Unidade \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}

function acaoDesativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Hist�rico da Unidade selecionado.');
    return;
  }
  if (confirm("Confirma desativa��o dos Hist�ricos das Unidades selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoReativar){ ?>
function acaoReativar(id,desc){
  if (confirm("Confirma reativa��o do Hist�rico da Unidade \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}

function acaoReativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Hist�rico da Unidade selecionado.');
    return;
  }
  if (confirm("Confirma reativa��o dos Hist�ricos das Unidades selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoExcluir){ ?>
function acaoExcluir(id,desc){
  if (confirm("Confirma exclus�o do Hist�rico da Unidade \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}

function acaoExclusaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Hist�rico da Unidade selecionado.');
    return;
  }
  if (confirm("Confirma exclus�o dos Hist�ricos selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmUnidadeHistoricoLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmUnidadeHistoricoLista').submit();
  }
}
<? } ?>

<?if(0){?></script><?}?>
<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmUnidadeHistoricoLista" method="post" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
  <?
  PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
  PaginaSEI::getInstance()->montarAreaTabela($strResultado,$numRegistros);
  //PaginaSEI::getInstance()->montarAreaDebug();
  PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  ?>
</form>
<?
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
