<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 13/11/2015 - criado por bcu
*/

try {
  require_once dirname(__FILE__).'/../SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(false);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();

  PaginaSEI::getInstance()->setTipoPagina(InfraPagina::$TIPO_PAGINA_SIMPLES);
  PaginaSEI::getInstance()->setBolAutoRedimensionar(false);

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  switch($_GET['acao']) {

    case 'documento_versao_comparar':

      if ($_GET['versao']!='' && $_GET['versao_comparacao']!='') {
        $objEditorDTO = new EditorDTO();
        $objEditorDTO->setDblIdDocumento($_GET['id_documento']);
        $objEditorDTO->setNumIdBaseConhecimento(null);
        $objEditorDTO->setStrSinCabecalho('S');
        $objEditorDTO->setStrSinRodape('S');
        $objEditorDTO->setStrSinCarimboPublicacao('N');
        $objEditorDTO->setStrSinIdentificacaoVersao('N');
        $objEditorDTO->setStrSinProcessarLinks('N');
        $objEditorDTO->setNumVersao($_GET['versao']);
        $objEditorDTO->setNumVersaoComparacao($_GET['versao_comparacao']);

        $objEditorRN = new EditorRN();
        die($objEditorRN->compararHtmlVersao($objEditorDTO));
      }

      $arr=PaginaSEI::getInstance()->getArrStrItensSelecionados();
      if(count($arr)!=2){
        throw new InfraException('Vers�es para compara��o n�o informadas.');
      }
      if($arr[0]>$arr[1]){
        $arr=array_reverse($arr);
      }

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->retStrProtocoloFormatado();
      $objProtocoloDTO->setDblIdProtocolo($_GET['id_documento']);

      $objProtocoloRN = new ProtocoloRN();
      $objProtocoloDTO = $objProtocoloRN->consultarRN0186($objProtocoloDTO);

      if ($objProtocoloDTO==null){
        throw new InfraException('Documento n�o encontrado.');
      }

      $strTitulo = '<label>Documento '.$objProtocoloDTO->getStrProtocoloFormatado().' - Compara��o das Vers�es '.$arr[0].' e '.$arr[1].'</label>';

      $strLinkComparacao = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=documento_versao_comparar&acao_origem='.$_GET['acao'].'&id_documento='.$_GET['id_documento'].'&versao='.$arr[0].'&versao_comparacao='.$arr[1]);

      SeiINT::montarCabecalhoConteudo($strTitulo, '', $strLinkComparacao, $strCss, $strJsInicializar, $strJsCorpo, $strHtml);

      break;

    default:
      throw new InfraException("A��o '" . $_GET['acao'] . "' n�o reconhecida.");
  }

}catch(Exception $e){
  PaginaSEI::getInstance()->processarExcecao($e);
}
PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
echo '<meta name="viewport" content="width=980" />';
PaginaSEI::getInstance()->montarTitle($strTitulo);
PaginaSEI::getInstance()->montarStyle();
PaginaSEI::getInstance()->abrirStyle();
echo $strCss;
PaginaSEI::getInstance()->fecharStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->abrirJavaScript();
?>
  function inicializar(){
<?=$strJsInicializar?>
  }
<?
echo $strJsCorpo;
PaginaSEI::getInstance()->fecharJavaScript();
PaginaSEI::getInstance()->fecharHead();
echo $strHtml;
PaginaSEI::getInstance()->fecharHtml();
?>