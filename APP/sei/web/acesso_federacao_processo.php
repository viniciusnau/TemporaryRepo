<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/05/2012 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.13.1
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

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  SessaoSEI::getInstance()->setArrParametrosRepasseLink(array('arvore', 'id_instalacao_federacao', 'id_orgao_federacao', 'id_procedimento_federacao', 'id_procedimento_federacao_anexado'));

  if(isset($_GET['arvore'])){
    PaginaSEI::getInstance()->setBolArvore($_GET['arvore']);
  }

  PaginaSEI::getInstance()->setTipoPagina(InfraPagina::$TIPO_PAGINA_SIMPLES);

  $arrComandos = array();
  $objVisualizarProcessoFederacaoDTORet = null;
  $objProcedimentoDTO = null;
  $strConjuntoProtocolos = '';
  $strResultadoCabecalho = '';
  $strResultado = '';
  $numDocumentosCheck = 0;
  $numMaxProtocolos = 100;
  $arrPdf = array();

  $strConjuntoProtocolos = !isset($_GET['id_procedimento_federacao_anexado']) ? $_GET['id_procedimento_federacao'] : $_GET['id_procedimento_federacao_anexado'];

  switch($_GET['acao']){

    case 'processo_consulta_federacao':

      $strTitulo = 'Consulta de Processo do SEI Federa��o';

      $objVisualizarProcessoFederacaoDTO = new VisualizarProcessoFederacaoDTO();
      $objVisualizarProcessoFederacaoDTO->setStrIdInstalacaoFederacao($_GET['id_instalacao_federacao']);
      $objVisualizarProcessoFederacaoDTO->setStrIdProcedimentoFederacao($_GET['id_procedimento_federacao']);

      if (isset($_GET['id_procedimento_federacao_anexado'])) {
        $objVisualizarProcessoFederacaoDTO->setStrIdProcedimentoFederacaoAnexado($_GET['id_procedimento_federacao_anexado']);
      }

      $objVisualizarProcessoFederacaoDTO->setStrSinProtocolos('S');
      $objProtocoloDTOPaginacao = new ProtocoloDTO();
      if (!isset($_POST['hdnMaxProtocolos'])) {
        $objProtocoloDTOPaginacao->setNumPaginaAtual(0);
        $objProtocoloDTOPaginacao->setNumMaxRegistrosRetorno(null);
      }else{
        PaginaSEI::getInstance()->prepararPaginacao($objProtocoloDTOPaginacao, $_POST['hdnMaxProtocolos'], false, null, $strConjuntoProtocolos);
      }
      $objVisualizarProcessoFederacaoDTO->setNumPagProtocolos($objProtocoloDTOPaginacao->getNumPaginaAtual());
      $objVisualizarProcessoFederacaoDTO->setNumMaxProtocolos($objProtocoloDTOPaginacao->getNumMaxRegistrosRetorno());

      $objVisualizarProcessoFederacaoDTO->setStrSinAndamentos('N');

      $objAcessoFederacaoRN = new AcessoFederacaoRN();
      $objVisualizarProcessoFederacaoDTORet = $objAcessoFederacaoRN->visualizarProcesso($objVisualizarProcessoFederacaoDTO);

      if (!isset($_POST['hdnMaxProtocolos'])) {
        PaginaSEI::getInstance()->prepararPaginacao($objProtocoloDTOPaginacao, $objVisualizarProcessoFederacaoDTORet->getNumMaxProtocolos(), false, null, $strConjuntoProtocolos);
        $numMaxProtocolos = $objVisualizarProcessoFederacaoDTORet->getNumMaxProtocolos();
      }else{
        $numMaxProtocolos = $_POST['hdnMaxProtocolos'];
      }

      $objProtocoloDTOPaginacao->setNumRegistrosPaginaAtual($objVisualizarProcessoFederacaoDTORet->getNumRegProtocolos());
      $objProtocoloDTOPaginacao->setNumTotalRegistros($objVisualizarProcessoFederacaoDTORet->getNumTotProtocolos());
      PaginaSEI::getInstance()->processarPaginacao($objProtocoloDTOPaginacao, $strConjuntoProtocolos);
      break;

    case 'procedimento_gerar_pdf':

        $strTitulo = 'Gera��o de PDF de Processo do SEI Federa��o';

        $objVisualizarProcessoFederacaoDTO = new VisualizarProcessoFederacaoDTO();
        $objVisualizarProcessoFederacaoDTO->setStrIdInstalacaoFederacao($_GET['id_instalacao_federacao']);
        $objVisualizarProcessoFederacaoDTO->setStrIdProcedimentoFederacao($_GET['id_procedimento_federacao']);
        $objVisualizarProcessoFederacaoDTO->setStrIdDocumentoFederacao(PaginaSEI::getInstance()->getArrStrItensSelecionados($strConjuntoProtocolos));

        $objAcessoFederacaoRN = new AcessoFederacaoRN();
        $strLink = $objAcessoFederacaoRN->gerarPdf($objVisualizarProcessoFederacaoDTO);
        header('Location: '.$strLink);
        die;

    case 'procedimento_gerar_zip':

        $strTitulo = 'Gera��o de ZIP de Processo do SEI Federa��o';

        $objVisualizarProcessoFederacaoDTO = new VisualizarProcessoFederacaoDTO();
        $objVisualizarProcessoFederacaoDTO->setStrIdInstalacaoFederacao($_GET['id_instalacao_federacao']);
        $objVisualizarProcessoFederacaoDTO->setStrIdProcedimentoFederacao($_GET['id_procedimento_federacao']);
        $objVisualizarProcessoFederacaoDTO->setStrIdDocumentoFederacao(PaginaSEI::getInstance()->getArrStrItensSelecionados($strConjuntoProtocolos));

        $objAcessoFederacaoRN = new AcessoFederacaoRN();
        $strLink = $objAcessoFederacaoRN->gerarZip($objVisualizarProcessoFederacaoDTO);
        header('Location: '.$strLink);
        die;

	  default:
	    throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $objProcedimentoDTO = $objVisualizarProcessoFederacaoDTORet->getObjProcedimentoDTO();

  $strResultadoCabecalho = ProcedimentoINT::montarTabelaAutuacao($objProcedimentoDTO);

  $arrObjRelProtocoloProtocoloDTO = $objProcedimentoDTO->getArrObjRelProtocoloProtocoloDTO();

  $numProtocolos = $objVisualizarProcessoFederacaoDTORet->getNumTotProtocolos();

  if ($numProtocolos) {

    $strResultado .= '<table id="tblProtocolos" width="99.3%" class="infraTable" summary="Lista de Protocolos" >
  					  									<caption class="infraCaption" >'.PaginaSEI::getInstance()->gerarCaptionTabela('Protocolos', $numProtocolos, 'Lista de ', $strConjuntoProtocolos).'</caption>'.
        "\n\n". //auditoria
        '<tr>
                                  <th class="infraTh" width="1%">'.PaginaSEI::getInstance()->getThCheck('',$strConjuntoProtocolos).'</th>
                                  <th class="infraTh" width="20%">Processo / Documento</th>
  					  										<th class="infraTh">Tipo</th>
  					  										<th class="infraTh" width="10%">Unidade</th>
  					  										<th class="infraTh" width="10%">�rg�o</th>
  					  										<th class="infraTh" width="15%">Data</th>
                                  <th class="infraTh" width="10%">A��es</th>
  					  									</tr>'.
        "\n\n"; //auditoria

    $strCssTr = '';
    foreach ($arrObjRelProtocoloProtocoloDTO as $objRelProtocoloProtocoloDTO) {

      if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO || $objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO) {
        $strCssTr = ($strCssTr == 'class="infraTrClara"') ? 'class="infraTrEscura"' : 'class="infraTrClara"';
        $strResultado .= '<tr '.$strCssTr.'>'."\n";

        $strAcoes = "";

        if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO) {

          $objDocumentoDTO = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();

          $bolCheck = false;

          if ($objDocumentoDTO->getStrSinPdf() == 'S') {
            $bolCheck = true;
          } else {
            $arrPdf[] = $objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo();
          }

          if ($bolCheck || $objDocumentoDTO->getStrSinZip() == 'S') {
            $bolCheck = true;
          }

          if ($bolCheck) {
            $strResultado .= '<td align="center">'.PaginaSEI::getInstance()->getTrCheck($numDocumentosCheck++, $objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo(), $objDocumentoDTO->getStrNomeSerie(),'N',$strConjuntoProtocolos).'</td>';
          } else {
            $strResultado .= '<td>&nbsp;</td>';
          }


          $strIcones = '';
          $strLinkDocumento = '<a ';
          if ($objRelProtocoloProtocoloDTO->getStrSinAcessoBasico() == 'S') {
            $strLinkDocumento .= ' class="ancoraPadraoAzul" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);" href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=documento_consulta_federacao&id_documento_federacao='.$objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo()).'" target="_blank"';
          } else if ($objDocumentoDTO->getStrStaEstadoProtocolo() == ProtocoloRN::$TE_DOCUMENTO_CANCELADO) {
            $strLinkDocumento .= ' href="javascript:void(0);" class="ancoraPadraoPreta" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);alert(\'Documento cancelado.\')" style="text-decoration: line-through"';
          } else {
            $strLinkDocumento .= ' href="javascript:void(0);" class="ancoraPadraoPreta" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);alert(\'Sem acesso ao documento.\')"';
          }
          $strLinkDocumento .= ' alt="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrNomeSerie()).'" title="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrNomeSerie()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'">'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrProtocoloDocumentoFormatado()).'</a>';


          if ($objRelProtocoloProtocoloDTO->getStrSinAcessoBasico() == 'S') {

            if ($objDocumentoDTO->isSetArrObjAssinaturaDTO()) {
              $strTextoAssinatura = DocumentoINT::montarTooltipAssinatura($objDocumentoDTO);
              $strImagemAssinatura = ($objDocumentoDTO->getStrStaProtocoloProtocolo() == ProtocoloRN::$TP_DOCUMENTO_GERADO) ? Icone::DOCUMENTO_ASSINAR : Icone::DOCUMENTO_AUTENTICAR;
              $strIcones .= '<a href="#" onclick="alert(\''.PaginaSEI::formatarParametrosJavaScript($strTextoAssinatura).'\')" title="'.str_replace("\n", '&#10;', $strTextoAssinatura).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.$strImagemAssinatura.'" class="imagemStatusFederacao" /></a>';
            }else{
              $strIcones .= '<div class="iconeVazio"></div>';
            }

            if ($objDocumentoDTO->isSetObjPublicacaoDTO()) {
              $strTextoPublicacao = PaginaSEI::tratarHTML($objDocumentoDTO->getObjPublicacaoDTO()->getStrTextoInformativo());
              $strIcones .= '<a href="#" onclick="alert(\''.PaginaSEI::formatarParametrosJavaScript($strTextoPublicacao).'\')" title="'.str_replace("\n", '&#10;', $strTextoPublicacao).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.Icone::PUBLICACAO.'" class="imagemStatusFederacao" /></a>';
            }else{
              $strIcones .= '<div class="iconeVazio"></div>';
            }

            $strAcoes = '<a href="#" id="'.$objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo().'"  tipo="d" instalacaoFederacao="'.$_GET['id_instalacao_federacao'].'" processoFederacao="'.$_GET['id_procedimento_federacao'].'" documentoFederacao="'.$objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo().'" protocoloNumero="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrProtocoloDocumentoFormatado()).'" protocoloDescricao="'.PaginaSEI::tratarHTML(trim($objDocumentoDTO->getStrNomeSerie().' '.$objDocumentoDTO->getStrNumero())).'" orgaoSigla="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrSiglaOrgaoUnidadeGeradoraProtocolo()).'"  class="lnkAcoes" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.Icone::FEDERACAO_LINK.'" class="infraImg" title="Menu c�pia protocolo" /></a>';

          }else{
            $strIcones .= '<div class="iconeVazio"></div><div class="iconeVazio"></div>';
          }

          $strResultado .= '<td align="center">'.$strLinkDocumento.$strIcones.'</td>
                            <td align="left">'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrNomeSerie().' '.$objDocumentoDTO->getStrNumero()).'</td>
                            <td align="center"><a alt="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrDescricaoUnidadeGeradoraProtocolo()).'" title="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrDescricaoUnidadeGeradoraProtocolo()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrSiglaUnidadeGeradoraProtocolo()).'</a></td>
                            <td align="center"><a alt="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrDescricaoOrgaoUnidadeGeradoraProtocolo()).'" title="'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrDescricaoOrgaoUnidadeGeradoraProtocolo()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($objDocumentoDTO->getStrSiglaOrgaoUnidadeGeradoraProtocolo()).'</a></td>
                            <td align="center">'.PaginaSEI::tratarHTML($objDocumentoDTO->getDtaGeracaoProtocolo()).'</td>
                            <td align="center">'.$strAcoes.'</td>'."\n";

        } else if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO) {

          $objProcedimentoDTOAnexado = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();

          $strLinkProcessoAnexado = '<a ';
          if ($objRelProtocoloProtocoloDTO->getStrSinAcessoBasico() == 'S') {
            $strLinkProcessoAnexado .= ' class="ancoraPadraoAzul" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);" href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=processo_consulta_federacao&id_procedimento_federacao_anexado='.$objProcedimentoDTOAnexado->getStrIdProtocoloFederacaoProtocolo()).'" target="_blank"';
          } else {
            $strLinkProcessoAnexado .= ' href="javascript:void(0);" class="ancoraPadraoPreta" onclick="infraLimparFormatarTrAcessada(this.parentNode.parentNode);alert(\'Sem acesso ao processo anexado.\')"';
          }
          $strLinkProcessoAnexado .= ' alt="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()).'" title="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()).'" tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'">'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrProtocoloProcedimentoFormatado()).'</a>';

          if ($objRelProtocoloProtocoloDTO->getStrSinAcessoBasico() == 'S') {
            $strAcoes =   '<a href="#" id="'.$objProcedimentoDTOAnexado->getStrIdProtocoloFederacaoProtocolo().'" tipo="p" instalacaoFederacao="'.$_GET['id_instalacao_federacao'].'" processoFederacao="'.$_GET['id_procedimento_federacao'].'" processoAnexadoFederacao="'.$objProcedimentoDTOAnexado->getStrIdProtocoloFederacaoProtocolo().'" protocoloNumero="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrProtocoloProcedimentoFormatado()).'" protocoloDescricao="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()).'" orgaoSigla="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrSiglaOrgaoUnidadeGeradoraProtocolo()).'" class="lnkAcoes"  tabindex="'.PaginaSEI::getInstance()->getProxTabTabela().'"><img src="'.Icone::FEDERACAO_LINK.'" class="infraImg" title="Menu c�pia protocolo" /></a>';
          }

          $strResultado .= '<td>&nbsp;</td>
                            <td align="center">'.$strLinkProcessoAnexado.'</td>
                            <td align="left">'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrNomeTipoProcedimento()).'</td>
                            <td align="center"><a alt="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrDescricaoUnidadeGeradoraProtocolo()).'" title="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrDescricaoUnidadeGeradoraProtocolo()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrSiglaUnidadeGeradoraProtocolo()).'</a></td>
                            <td align="center"><a alt="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrDescricaoOrgaoUnidadeGeradoraProtocolo()).'" title="'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrDescricaoOrgaoUnidadeGeradoraProtocolo()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getStrSiglaOrgaoUnidadeGeradoraProtocolo()).'</a></td>
                            <td align="center">'.PaginaSEI::tratarHTML($objProcedimentoDTOAnexado->getDtaGeracaoProtocolo()).'</td>
                            <td align="center">'.$strAcoes.'</td>';

        }

        $strResultado .= '</tr>';

        //facilita visualiza��o do texto auditado
        $strResultado .= "\n\n";
      }
    }
    $strResultado .= '</table><br>'."\n";
  }

  if (SessaoSEI::getInstance()->verificarPermissao('andamentos_consulta_federacao')) {
    $arrComandos[] = '<button type="button" accesskey="A" name="btnAndamentos" value="Andamentos" onclick="visualizarAndamentos();" class="infraButton"><span class="infraTeclaAtalho">A</span>ndamentos</button>';
  }

  $bolPdf = SessaoSEI::getInstance()->verificarPermissao('procedimento_gerar_pdf');
  $bolZip = SessaoSEI::getInstance()->verificarPermissao('procedimento_gerar_zip');
  if ($numDocumentosCheck > 0){
    if ($bolPdf) {
      $arrComandos[] = '<button type="button" accesskey="P" name="btnGerarPdf" value="Gerar PDF" onclick="gerarPdf();" class="infraButton">Gerar <span class="infraTeclaAtalho">P</span>DF</button>';
      $strLinkPdf = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=procedimento_gerar_pdf&acao_origem='.$_GET['acao']);
    }

    if ($bolZip) {
      $arrComandos[] = '<button type="button" accesskey="Z" name="btnGerarZip" value="Gerar ZIP" onclick="gerarZip();" class="infraButton">Gerar <span class="infraTeclaAtalho">Z</span>IP</button>';
      $strLinkZip = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=procedimento_gerar_zip&acao_origem='.$_GET['acao']);
    }
  }

  $strLinkMontarArvore = '';
  if (!isset($_GET['id_procedimento_federacao_anexado']) && $objVisualizarProcessoFederacaoDTORet != null && $objVisualizarProcessoFederacaoDTORet->getBolAtualizarArvore()) {
    $strLinkMontarArvore = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=procedimento_visualizar&acao_origem='.$_GET['acao'].'&id_procedimento='.$objProcedimentoDTO->getDblIdProcedimento().'&montar_visualizacao=0');
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

  div.iconeVazio {
    display:inline-block;
    width:24px;
  }

<?
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->adicionarJavaScript('js/popover/popper.min.js');
PaginaSEI::getInstance()->adicionarJavaScript('js/clipboard/clipboard.min.js');
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>

  //<script>
  function associarNosClipboard(){
    var arrLnkAcoes =  $('.lnkAcoes');
    for(var i=0;i<arrLnkAcoes.length;i++){
      var lnkAcoes = $(arrLnkAcoes[i]);
      var id = 'popover-content' + lnkAcoes.attr("id");
      var divConteudoPopover = null;

      divConteudoPopover = $(
          '<div id="' + id + '" style="display: none;position:relative;">\n' +
          '  <div class="list-group custom-popover" >\n' +
          '    <a popoverId="' + lnkAcoes.attr("id") + '" tipo="texto" onclick="copiarParaClipboard(this)" data-clipboard-text="' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + '" class="list-group-item d-flex flex-row clipboard clipboard-icon-focus" href="#" ><img class="align-self-center clipboard-icon-img" src="imagens/arvore_copiar_texto.svg"  title="Copiar texto" />&nbsp;<span class="align-self-center">' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + '</span></a>\n' +
          '    <a popoverId="' + lnkAcoes.attr("id") + '" tipo="texto" onclick="copiarParaClipboard(this)" data-clipboard-text="' + lnkAcoes.attr("protocoloDescricao") + ' (' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + ')" class="list-group-item d-flex flex-row clipboard clipboard-icon-focus" href="#" ><img class="align-self-center clipboard-icon-img" src="imagens/arvore_copiar_texto.svg"  title="Copiar texto" />&nbsp;<span class="align-self-center">' + lnkAcoes.attr("protocoloDescricao") + ' (' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + ')</span></a>\n' +
          '    <a popoverId="' + lnkAcoes.attr("id") + '" tipo="link" onclick="copiarParaClipboard(this)" data-clipboard-text="#' + lnkAcoes.attr("tipo") + '{' + lnkAcoes.attr("instalacaoFederacao") + '|' + lnkAcoes.attr("processoFederacao") + '|' + (lnkAcoes.attr("tipo") == 'd' ? lnkAcoes.attr("documentoFederacao") : lnkAcoes.attr("processoAnexadoFederacao")) + '|' + lnkAcoes.attr("protocoloNumero") + '/' + lnkAcoes.attr("orgaoSigla") + '}#" class="list-group-item d-flex flex-row clipboard clipboard-icon-focus" href="#" ><img class="align-self-center clipboard-icon-img" src="imagens/arvore_copiar_editor.svg" title="Copiar link editor"/>&nbsp;<span class="align-self-center">' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + '</span></a>\n' +
          '    <a popoverId="' + lnkAcoes.attr("id") + '" tipo="link" onclick="copiarParaClipboard(this)" data-clipboard-text="#' + lnkAcoes.attr("protocoloDescricao") + ' (' + lnkAcoes.attr("tipo") + '{' + lnkAcoes.attr("instalacaoFederacao") + '|' + lnkAcoes.attr("processoFederacao") + '|' + (lnkAcoes.attr("tipo") == 'd' ? lnkAcoes.attr("documentoFederacao") : lnkAcoes.attr("processoAnexadoFederacao")) + '|' + lnkAcoes.attr("protocoloNumero") + '/' + lnkAcoes.attr("orgaoSigla") + '})#" class="list-group-item d-flex flex-row clipboard clipboard-icon-focus" href="#" ><img class="align-self-center clipboard-icon-img" src="imagens/arvore_copiar_editor.svg" title="Copiar link editor"/>&nbsp;<span class="align-self-center">' + lnkAcoes.attr("protocoloDescricao") + ' (' + lnkAcoes.attr("protocoloNumero") + "/" + lnkAcoes.attr("orgaoSigla") + ')</span></a>\n' +
          '    <a popoverId="' + lnkAcoes.attr("id") + '"  onclick="fecharClipboard(this)" class="list-group-item d-flex flex-row li-fechar clipboard-icon-focus" href="#"  ><span class="align-self-center">Fechar</span></a>\n' +
          '  </div>\n' +
          '</div>'
      );

      $("body").append(divConteudoPopover);
      lnkAcoes.attr("data-toggle","popover");
      lnkAcoes.attr("data-placement","left");

      lnkAcoes.click(function(e) {
        e.preventDefault();
      }) .popover({
        html: true,
        sanitize: false,
        content: function() {
          return $("#"+'popover-content'+ this.id) .html();
        }
      });
      lnkAcoes.on('show.bs.popover', function () {
        $("a[data-toggle=popover]").not($(this)).popover("hide");
      })
      lnkAcoes.on('shown.bs.popover', function () {
        var idPopover = $("#"+this.id).attr("aria-describedby");
        $( "#" +idPopover ).find(".clipboard-icon-focus").first().focus();
      })

    }
  }


  function inicializar(){

    infraEfeitoTabelas();

    <? if ($strLinkMontarArvore!=''){ ?>
    parent.parent.document.getElementById('ifrArvore').src = '<?=$strLinkMontarArvore?>';
    <? } ?>

    associarNosClipboard();

  }

<? if ($bolPdf){ ?>
  function gerarPdf() {

    if (document.getElementById('hdn<?=$strConjuntoProtocolos?>ItensSelecionados').value==''){
      alert('Nenhum documento selecionado.');
      return;
    }

    var pdf = document.getElementById('hdnPdf').value;

    var erro = 0;

    if (pdf!='') {

      selecionados = document.getElementById('hdn<?=$strConjuntoProtocolos?>ItensSelecionados').value;

      if (selecionados!='') {

        pdf = pdf.split(',');
        selecionados = selecionados.split(',');

        for (var j = 0; j<<?=$numDocumentosCheck?>; j++) {

          box = document.getElementById('chk<?=$strConjuntoProtocolos?>Item'+j);

          if (!box.checked){

            infraFormatarTrDesmarcada(box.parentNode.parentNode);

          }else {

            for (var i = 0; i<pdf.length; i++) {
              if (pdf[i]==box.value) {
                box.checked = false;
                infraFormatarTrAcessada(box.parentNode.parentNode);
                erro += 1;
              }
            }
          }
        }
      }
    }

    if (erro) {

      var msg = '';
      if (erro==1){
        msg = 'N�o � poss�vel gerar o PDF para o documento destacado.';
      }else{
        msg = 'N�o � poss�vel gerar o PDF para os documentos destacados.';
      }

      msg += '\n\nDeseja continuar?';

      if (!confirm(msg)){
        return;
      }
    }

    infraSelecionarItens(null,'<?=$strConjuntoProtocolos?>');

    if (document.getElementById('hdn<?=$strConjuntoProtocolos?>ItensSelecionados').value==''){
      alert('Nenhum documento selecionado.');
      return;
    }
    var frm = document.getElementById('frmAcessoFederacaoProcesso');
    var actionAnterior = frm.action;
    frm.action = '<?=$strLinkPdf?>';
    frm.target = '_blank';
    frm.submit();
    frm.action = actionAnterior;
    frm.target = '_self';
  }
<? } ?>

<? if ($bolZip){ ?>

  function gerarZip() {

    if (document.getElementById('hdn<?=$strConjuntoProtocolos?>ItensSelecionados').value==''){
      alert('Nenhum documento selecionado.');
      return;
    }

    var frm = document.getElementById('frmAcessoFederacaoProcesso');
    var actionAnterior = frm.action;
    frm.action = '<?=$strLinkZip?>';
    frm.target = '_blank';
    frm.submit();
    frm.action = actionAnterior;
    frm.target = '_self';
  }

  function OnSubmitForm(){

    if (typeof(parent.exibirAguarde) == 'function') {
      parent.exibirAguarde("ifrVisualizacao");
    }else{
      infraExibirAviso();
    }

    return true;
  }
<? } ?>

  function visualizarAndamentos(){

    if (typeof(parent.exibirAguarde) == 'function') {
      parent.exibirAguarde("ifrVisualizacao");
    }else{
      infraExibirAviso();
    }

    location.href='<?=SessaoSEI::getInstance()->assinarLink('controlador.php?acao=andamentos_consulta_federacao&acao_origem='.$_GET['acao'])?>';
  }

  //</script>

<?
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');
?>
<form id="frmAcessoFederacaoProcesso" method="post" onsubmit="return OnSubmitForm();">
<?
  if ($strResultadoCabecalho!='') {
    PaginaSEI::getInstance()->montarBarraComandosSuperior($arrComandos);
    echo $strResultadoCabecalho.'<br>';
    PaginaSEI::getInstance()->montarAreaTabela($strResultado, $numProtocolos, false, '', null, $strConjuntoProtocolos);
  }
?>
  <input type="hidden" id="hdnPdf" name="hdnPdf" value="<?=implode(',',$arrPdf)?>" />
  <input type="hidden" id="hdnMaxProtocolos" name="hdnMaxProtocolos" value="<?=$numMaxProtocolos?>" />

</form>
<?
PaginaSEI::getInstance()->montarAreaDebug();
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>