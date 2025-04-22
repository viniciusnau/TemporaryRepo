<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/10/2013 - criado por mga
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
  InfraDebug::getInstance()->setBolEcho(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  switch($_GET['acao']){  	      
              
    case 'tarja_assinatura_montar':
      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->retDblIdDocumento();
      $objDocumentoDTO->retDblIdProcedimento();
      $objDocumentoDTO->retStrNomeSerie();
      $objDocumentoDTO->retStrProtocoloDocumentoFormatado();
      $objDocumentoDTO->retStrProtocoloProcedimentoFormatado();
      $objDocumentoDTO->retStrCrcAssinatura();
      $objDocumentoDTO->retStrQrCodeAssinatura();
      $objDocumentoDTO->retObjPublicacaoDTO();
      $objDocumentoDTO->retNumIdConjuntoEstilos();
      $objDocumentoDTO->retStrSinBloqueado();
      $objDocumentoDTO->retNumIdUnidadeGeradoraProtocolo();
      $objDocumentoDTO->retStrDescricaoTipoConferencia();
      $objDocumentoDTO->setDblIdDocumento($_GET['id_documento']);
      
      $objDocumentoRN = new DocumentoRN();
      $objDocumentoDTO = $objDocumentoRN->consultarRN0005($objDocumentoDTO);
      
      $objAssinaturaRN = new AssinaturaRN();
      echo $objAssinaturaRN->montarTarjas($objDocumentoDTO);
      break;    	
      
    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }
}catch(Exception $e){
  PaginaSEI::getInstance()->processarExcecao($e);
} 
?>