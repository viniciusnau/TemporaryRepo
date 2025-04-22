<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/07/2019 - criado por mga
*
*/

try {
  require_once dirname(__FILE__).'/SEI.php';

  session_start();
  
  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  $objAcaoFederacaoDTO = SessaoSEIFederacao::getInstance()->validarLink(false);

  switch ($objAcaoFederacaoDTO->getNumStaTipo()){
    case AcaoFederacaoRN::$TA_VISUALIZAR_DOCUMENTO:
      require_once 'documento_consulta_federacao.php';
      break;

    case AcaoFederacaoRN::$TA_GERAR_PDF:
      require_once 'procedimento_pdf_federacao.php';
      break;

    case AcaoFederacaoRN::$TA_GERAR_ZIP:
      require_once 'procedimento_zip_federacao.php';
      break;

    default:
      throw new InfraException('A��o do SEI Federa��o n�o reconhecida.');
  }

}catch(Throwable $e){
  PaginaSEIFederacao::getInstance()->processarExcecao($e);
}
?>