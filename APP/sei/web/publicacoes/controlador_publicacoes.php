<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/06/2013 - criado por MKR
*
*/

try {

	require_once dirname(__FILE__).'/../SEI.php';

	session_start();

	SessaoPublicacoes::getInstance()->validarLink();

  ManutencaoSEI::validarInterface();

	infraTratarErroFatal(SessaoPublicacoes::getInstance(),'controlador_publicacoes.php?acao=infra_erro_fatal_logar'); 			
		
	switch($_GET['acao']) {
			
	  case 'publicacao_pesquisar':
		  require_once 'publicacao_pesquisar.php';
		  break;
									 
	  case 'publicacao_visualizar':
	    require_once 'publicacao_visualizar.php';
	    break;
		    
		case 'publicacao_relacionada_visualizar':
		  require_once 'publicacao_relacionada_visualizar.php';
		  break;

    case 'publicacao_ajuda':
      require_once 'ajuda_publicacao.php';
      break;


    default:

      foreach($SEI_MODULOS as $objModulo){
        if ($objModulo->executar('processarControladorPublicacoes', $_GET['acao'])!=null){
          return;
        }
      }

		  if (!InfraControlador::processar($_GET['acao'], PaginaPublicacoes::getInstance(), SessaoPublicacoes::getInstance(), BancoSEI::getInstance())){
			  throw new InfraException('A��o \''.$_GET['acao'].'\' n�o reconhecida pelo controlador.');
		  }
  }

}catch(Throwable $e){
	PaginaPublicacoes::getInstance()->processarExcecao($e);
}
?>