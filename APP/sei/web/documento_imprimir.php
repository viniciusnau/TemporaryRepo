<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/08/2010 - criado por alexandre_db
*
* Vers�o do Gerador de C�digo:1.6.1
*/
try {
  require_once dirname(__FILE__).'/SEI.php';
  
  session_start();
 
  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////
    
  SessaoSEI::getInstance()->validarLink();
  
  SessaoSEI::getInstance()->validarAuditarPermissao($_GET['acao']);
  
  switch($_GET['acao']){ 
    case 'documento_imprimir_web':

      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->retDblIdDocumento();
      $objDocumentoDTO->retDblIdDocumentoEdoc();
      $objDocumentoDTO->retStrNomeSerie();
      $objDocumentoDTO->retStrStaDocumento();
      $objDocumentoDTO->retStrProtocoloDocumentoFormatado();
      $objDocumentoDTO->retStrProtocoloProcedimentoFormatado();
      $objDocumentoDTO->setDblIdDocumento($_GET['id_documento']);

      $objDocumentoRN = new DocumentoRN();
      $objDocumentoDTO = $objDocumentoRN->consultarRN0005($objDocumentoDTO);

      if ($objDocumentoDTO==null){
        $strConteudo = 'Documento n�o encontrado.';
      }else{

        if ($objDocumentoDTO->getStrStaDocumento()==DocumentoRN::$TD_EDITOR_EDOC){


          if ($objDocumentoDTO->getDblIdDocumentoEdoc()==null){
            die('Documento sem conte�do.');
          }

          $objEDocRN = new EDocRN();
          $dto = new DocumentoDTO();
          $dto->setDblIdDocumentoEdoc($objDocumentoDTO->getDblIdDocumentoEdoc());
          $dto->setStrSinValidarXss('S');

          $strConteudo = $objEDocRN->consultarHTMLDocumentoRN1204($dto);

          $posBody = strpos($strConteudo,'<body>');
          if ($posBody !== false){
            $strConteudo = substr($strConteudo,0,$posBody).'<body onload="javascript:window.print();setTimeout(\'window.close()\',1000);">Processo N�'.$objDocumentoDTO->getStrProtocoloProcedimentoFormatado().'<br /><br />'.substr($strConteudo,$posBody+6);
          }

        }else if ($objDocumentoDTO->getStrStaDocumento()==DocumentoRN::$TD_EDITOR_INTERNO){

          $objEditorDTO = new EditorDTO();
          $objEditorDTO->setDblIdDocumento($objDocumentoDTO->getDblIdDocumento());
          $objEditorDTO->setNumIdBaseConhecimento(null);
          $objEditorDTO->setStrSinCabecalho('S');
          $objEditorDTO->setStrSinRodape('S');
          $objEditorDTO->setStrSinCarimboPublicacao('S');
          $objEditorDTO->setStrSinIdentificacaoVersao('N');
          $objEditorDTO->setStrSinValidarXss('S');

          $objEditorRN = new EditorRN();
          $strConteudo = $objEditorRN->consultarHtmlVersao($objEditorDTO);


          $posBody = strpos($strConteudo,'<body>');
          if ($posBody !== false){
            $strConteudo = substr($strConteudo,0,$posBody).'<body onload="javascript:window.print();setTimeout(\'window.close()\',1000);">'.substr($strConteudo,$posBody+6);
          }

        }else if ($objDocumentoDTO->getStrStaDocumento()==DocumentoRN::$TD_FORMULARIO_AUTOMATICO || $objDocumentoDTO->getStrStaDocumento()==DocumentoRN::$TD_FORMULARIO_GERADO){

          $objDocumentoDTO->setStrSinValidarXss('S');

          $strConteudo = $objDocumentoRN->consultarHtmlFormulario($objDocumentoDTO);

          $posBody = strpos($strConteudo,'<body>');
          if ($posBody !== false){
            $strConteudo = substr($strConteudo,0,$posBody).'<body onload="javascript:window.print();setTimeout(\'window.close()\',1000);">'.substr($strConteudo,$posBody+6);
          }
        }
      }

      echo $strConteudo;

      break;
  
   default:
    throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }
 
}catch(Throwable $e){

  if ($e instanceof InfraException && $e->contemValidacoes()){
    die($e->__toString());
  }

  try{ LogSEI::getInstance()->gravar(InfraException::inspecionar($e)); }catch(Exception $e2){}
  die('Erro na impress�o do documento.');

}
?>