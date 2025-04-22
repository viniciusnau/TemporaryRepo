<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/07/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.35.0
*
* Vers�o no CVS: $Id$
*/

try {
  require_once dirname(__FILE__).'/SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(true);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();

  PaginaSEI::getInstance()->prepararSelecao('tipo_formulario_selecionar');

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  switch($_GET['acao']){
    case 'tipo_formulario_excluir':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjTipoFormularioDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objTipoFormularioDTO = new TipoFormularioDTO();
          $objTipoFormularioDTO->setNumIdTipoFormulario($arrStrIds[$i]);
          $arrObjTipoFormularioDTO[] = $objTipoFormularioDTO;
        }
        $objTipoFormularioRN = new TipoFormularioRN();
        $objTipoFormularioRN->excluir($arrObjTipoFormularioDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;


    case 'tipo_formulario_desativar':
      try{
        $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
        $arrObjTipoFormularioDTO = array();
        for ($i=0;$i<count($arrStrIds);$i++){
          $objTipoFormularioDTO = new TipoFormularioDTO();
          $objTipoFormularioDTO->setNumIdTipoFormulario($arrStrIds[$i]);
          $arrObjTipoFormularioDTO[] = $objTipoFormularioDTO;
        }
        $objTipoFormularioRN = new TipoFormularioRN();
        $objTipoFormularioRN->desativar($arrObjTipoFormularioDTO);
        PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
      }catch(Exception $e){
        PaginaSEI::getInstance()->processarExcecao($e);
      } 
      header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
      die;

    case 'tipo_formulario_reativar':
      $strTitulo = 'Reativar Tipos de Formul�rios';
      if ($_GET['acao_confirmada']=='sim'){
        try{
          $arrStrIds = PaginaSEI::getInstance()->getArrStrItensSelecionados();
          $arrObjTipoFormularioDTO = array();
          for ($i=0;$i<count($arrStrIds);$i++){
            $objTipoFormularioDTO = new TipoFormularioDTO();
            $objTipoFormularioDTO->setNumIdTipoFormulario($arrStrIds[$i]);
            $arrObjTipoFormularioDTO[] = $objTipoFormularioDTO;
          }
          $objTipoFormularioRN = new TipoFormularioRN();
          $objTipoFormularioRN->reativar($arrObjTipoFormularioDTO);
          PaginaSEI::getInstance()->adicionarMensagem('Opera��o realizada com sucesso.');
        }catch(Exception $e){
          PaginaSEI::getInstance()->processarExcecao($e);
        } 
        header('Location: '.SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao_origem'].'&acao_origem='.$_GET['acao']));
        die;
      } 
      break;


    case 'tipo_formulario_selecionar':
      $strTitulo = PaginaSEI::getInstance()->getTituloSelecao('Selecionar Tipo de Formul�rio','Selecionar Tipos de Formul�rios');

      //Se cadastrou alguem
      if ($_GET['acao_origem']=='tipo_formulario_cadastrar'){
        if (isset($_GET['id_tipo_formulario'])){
          PaginaSEI::getInstance()->adicionarSelecionado($_GET['id_tipo_formulario']);
        }
      }
      break;

    case 'tipo_formulario_listar':
      $strTitulo = 'Tipos de Formul�rios';
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $arrComandos = array();
  if ($_GET['acao'] == 'tipo_formulario_selecionar'){
    $arrComandos[] = '<button type="button" accesskey="T" id="btnTransportarSelecao" value="Transportar" onclick="infraTransportarSelecao();" class="infraButton"><span class="infraTeclaAtalho">T</span>ransportar</button>';
  }

  if ($_GET['acao'] == 'tipo_formulario_listar' || $_GET['acao'] == 'tipo_formulario_selecionar'){
    $bolAcaoCadastrar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_cadastrar');
    if ($bolAcaoCadastrar){
      $arrComandos[] = '<button type="button" accesskey="N" id="btnNovo" value="Novo" onclick="location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_cadastrar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao']).'\'" class="infraButton"><span class="infraTeclaAtalho">N</span>ovo</button>';
    }
  }

  $objTipoFormularioDTO = new TipoFormularioDTO();
  $objTipoFormularioDTO->retNumIdTipoFormulario();
  $objTipoFormularioDTO->retStrNome();
  $objTipoFormularioDTO->retStrDescricao();

  if ($_GET['acao'] == 'tipo_formulario_reativar'){
    //Lista somente inativos
    $objTipoFormularioDTO->setBolExclusaoLogica(false);
    $objTipoFormularioDTO->setStrSinAtivo('N');
  }

  PaginaSEI::getInstance()->prepararOrdenacao($objTipoFormularioDTO, 'Nome', InfraDTO::$TIPO_ORDENACAO_ASC);
  //PaginaSEI::getInstance()->prepararPaginacao($objTipoFormularioDTO);

  $objTipoFormularioRN = new TipoFormularioRN();
  $arrObjTipoFormularioDTO = $objTipoFormularioRN->listar($objTipoFormularioDTO);

  //PaginaSEI::getInstance()->processarPaginacao($objTipoFormularioDTO);
  $numRegistros = count($arrObjTipoFormularioDTO);

  if ($numRegistros > 0){

    $bolCheck = false;

    if ($_GET['acao']=='tipo_formulario_selecionar'){
      $bolAcaoVisualizar = false;
      $bolAcaoClonar = false;
      $bolAcaoReativar = false;
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_consultar');
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_alterar');
      $bolAcaoImprimir = false;
      //$bolAcaoGerarPlanilha = false;
      $bolAcaoExcluir = false;
      $bolAcaoDesativar = false;
      $bolCheck = true;
      $bolAcaoAtributoListar = false;
    }else if ($_GET['acao']=='tipo_formulario_reativar'){
      $bolAcaoVisualizar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_visualizar');
      $bolAcaoClonar = false;
      $bolAcaoReativar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_reativar');
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_consultar');
      $bolAcaoAlterar = false;
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_excluir');
      $bolAcaoDesativar = false;
      $bolAcaoAtributoListar = false;
    }else{
      $bolAcaoVisualizar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_visualizar');
      $bolAcaoClonar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_clonar');
      $bolAcaoReativar = false;
      $bolAcaoConsultar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_consultar');
      $bolAcaoAlterar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_alterar');
      $bolAcaoImprimir = true;
      //$bolAcaoGerarPlanilha = SessaoSEI::getInstance()->verificarPermissao('infra_gerar_planilha_tabela');
      $bolAcaoExcluir = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_excluir');
      $bolAcaoDesativar = SessaoSEI::getInstance()->verificarPermissao('tipo_formulario_desativar');
      $bolAcaoAtributoListar = SessaoSEI::getInstance()->verificarPermissao('atributo_listar');
    }

    
    if ($bolAcaoDesativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="t" id="btnDesativar" value="Desativar" onclick="acaoDesativacaoMultipla();" class="infraButton">Desa<span class="infraTeclaAtalho">t</span>ivar</button>';
      $strLinkDesativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_desativar&acao_origem='.$_GET['acao']);
    }

    if ($bolAcaoReativar){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="R" id="btnReativar" value="Reativar" onclick="acaoReativacaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">R</span>eativar</button>';
      $strLinkReativar = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_reativar&acao_origem='.$_GET['acao'].'&acao_confirmada=sim');
    }
    

    if ($bolAcaoExcluir){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="E" id="btnExcluir" value="Excluir" onclick="acaoExclusaoMultipla();" class="infraButton"><span class="infraTeclaAtalho">E</span>xcluir</button>';
      $strLinkExcluir = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_excluir&acao_origem='.$_GET['acao']);
    }

    /*
    if ($bolAcaoGerarPlanilha){
      $bolCheck = true;
      $arrComandos[] = '<button type="button" accesskey="P" id="btnGerarPlanilha" value="Gerar Planilha" onclick="infraGerarPlanilhaTabela(\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=infra_gerar_planilha_tabela').'\');" class="infraButton">Gerar <span class="infraTeclaAtalho">P</span>lanilha</button>';
    }
    */

    $strResultado = '';

    if ($_GET['acao']!='tipo_formulario_reativar'){
      $strSumarioTabela = 'Tabela de Tipos de Formul�rios.';
      $strCaptionTabela = 'Tipos de Formul�rios';
    }else{
      $strSumarioTabela = 'Tabela de Tipos de Formul�rios Inativos.';
      $strCaptionTabela = 'Tipos de Formul�rios Inativos';
    }

    $strResultado .= '<table width="99%" class="infraTable" summary="'.$strSumarioTabela.'">'."\n";
    $strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela($strCaptionTabela,$numRegistros).'</caption>';
    $strResultado .= '<tr>';
    if ($bolCheck) {
      $strResultado .= '<th class="infraTh" width="1%">'.PaginaSEI::getInstance()->getThCheck().'</th>'."\n";
    }
    $strResultado .= '<th class="infraTh" width="20%">'.PaginaSEI::getInstance()->getThOrdenacao($objTipoFormularioDTO,'Nome','Nome',$arrObjTipoFormularioDTO).'</th>'."\n";
    $strResultado .= '<th class="infraTh">'.PaginaSEI::getInstance()->getThOrdenacao($objTipoFormularioDTO,'Descri��o','Descricao',$arrObjTipoFormularioDTO).'</th>'."\n";
    $strResultado .= '<th class="infraTh" width="25%">A��es</th>'."\n";
    $strResultado .= '</tr>'."\n";
    $strCssTr='';

    $objAtributoDTO = new AtributoDTO();
    $objAtributoDTO->setDistinct(true);
    $objAtributoDTO->retNumIdTipoFormulario();
    $objAtributoDTO->setNumIdTipoFormulario(InfraArray::converterArrInfraDTO($arrObjTipoFormularioDTO,'IdTipoFormulario'),InfraDTO::$OPER_IN);

    $objAtributoRN = new AtributoRN();
    $arrIdTipoFormularioComAtributos = InfraArray::converterArrInfraDTO($objAtributoRN->listarRN0165($objAtributoDTO),'IdTipoFormulario');

    for($i = 0;$i < $numRegistros; $i++){

      $strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
      $strResultado .= $strCssTr;

      if ($bolCheck){
        $strResultado .= '<td valign="top">'.PaginaSEI::getInstance()->getTrCheck($i,$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario(),$arrObjTipoFormularioDTO[$i]->getStrNome()).'</td>';
      }
      $strResultado .= '<td valign="top">'.PaginaSEI::tratarHTML($arrObjTipoFormularioDTO[$i]->getStrNome()).'</td>';
      $strResultado .= '<td>'.nl2br(PaginaSEI::tratarHTML($arrObjTipoFormularioDTO[$i]->getStrDescricao())).'</td>';
      $strResultado .= '<td valign="top" align="center">';

      $strResultado .= PaginaSEI::getInstance()->getAcaoTransportarItem($i,$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario());

      if ($bolAcaoVisualizar && in_array($arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario(),$arrIdTipoFormularioComAtributos)) {
        $strResultado .= '<a href="#" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);infraAbrirJanelaModal(\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_visualizar&id_tipo_formulario='.$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario()).'\',700,500)" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.Icone::PRE_VISUALIZAR.'" title="Visualizar Tipo de Formul�rio" alt="Visualizar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoAtributoListar){
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=atributo_listar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_formulario='.$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.Icone::VALORES.'" title="Campos do Tipo de Formul�rio" alt="Campos do Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      //if ($bolAcaoConsultar){
      //  $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_consultar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_formulario='.$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeConsultar().'" title="Consultar Tipo de Formul�rio" alt="Consultar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      //}

      if ($bolAcaoAlterar){
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_alterar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_formulario='.$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeAlterar().'" title="Alterar Tipo de Formul�rio" alt="Alterar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoClonar){
        $strResultado .= '<a href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=tipo_formulario_clonar&acao_origem='.$_GET['acao'].'&acao_retorno='.$_GET['acao'].'&id_tipo_formulario_origem='.$arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeClonar().'" title="Clonar Tipo de Formul�rio" alt="Clonar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoDesativar || $bolAcaoReativar || $bolAcaoExcluir){
        $strId = $arrObjTipoFormularioDTO[$i]->getNumIdTipoFormulario();
        $strDescricao = PaginaSEI::getInstance()->formatarParametrosJavaScript($arrObjTipoFormularioDTO[$i]->getStrNome());
      }

      if ($bolAcaoDesativar){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoDesativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeDesativar().'" title="Desativar Tipo de Formul�rio" alt="Desativar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoReativar){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoReativar(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeReativar().'" title="Reativar Tipo de Formul�rio" alt="Reativar Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      if ($bolAcaoExcluir){
        $strResultado .= '<a href="'.PaginaSEI::getInstance()->montarAncora($strId).'" onclick="acaoExcluir(\''.$strId.'\',\''.$strDescricao.'\');" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.PaginaSEI::getInstance()->getIconeExcluir().'" title="Excluir Tipo de Formul�rio" alt="Excluir Tipo de Formul�rio" class="infraImg" /></a>&nbsp;';
      }

      $strResultado .= '</td></tr>'."\n";
    }
    $strResultado .= '</table>';
  }
  if ($_GET['acao'] == 'tipo_formulario_selecionar'){
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
  if ('<?=$_GET['acao']?>'=='tipo_formulario_selecionar'){
    infraReceberSelecao();
    document.getElementById('btnFecharSelecao').focus();
  }else{
    document.getElementById('btnFechar').focus();
  }
  infraEfeitoTabelas();
}

<? if ($bolAcaoDesativar){ ?>
function acaoDesativar(id,desc){
  if (confirm("Confirma desativa��o do Tipo de Formul�rio \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}

function acaoDesativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Formul�rio selecionado.');
    return;
  }
  if (confirm("Confirma desativa��o dos Tipos de Formul�rios selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkDesativar?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoReativar){ ?>
function acaoReativar(id,desc){
  if (confirm("Confirma reativa��o do Tipo de Formul�rio \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}

function acaoReativacaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Formul�rio selecionado.');
    return;
  }
  if (confirm("Confirma reativa��o dos Tipos de Formul�rios selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkReativar?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}
<? } ?>

<? if ($bolAcaoExcluir){ ?>
function acaoExcluir(id,desc){
  if (confirm("Confirma exclus�o do Tipo de Formul�rio \""+desc+"\"?")){
    document.getElementById('hdnInfraItemId').value=id;
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}

function acaoExclusaoMultipla(){
  if (document.getElementById('hdnInfraItensSelecionados').value==''){
    alert('Nenhum Tipo de Formul�rio selecionado.');
    return;
  }
  if (confirm("Confirma exclus�o dos Tipos de Formul�rios selecionados?")){
    document.getElementById('hdnInfraItemId').value='';
    document.getElementById('frmTipoFormularioLista').action='<?=$strLinkExcluir?>';
    document.getElementById('frmTipoFormularioLista').submit();
  }
}
<? } ?>

<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmTipoFormularioLista" method="post" action="<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'])?>">
  <?
  PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
  //PaginaSEI::getInstance()->abrirAreaDados('5em');
  //PaginaSEI::getInstance()->fecharAreaDados();
  PaginaSEI::getInstance()->montarAreaTabela($strResultado,$numRegistros);
  PaginaSEI::getInstance()->montarAreaDebug();
  PaginaSEI::getInstance()->montarBarraComandosInferior($arrComandos);
  ?>
</form>
<?
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>