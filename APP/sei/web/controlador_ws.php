<?php

try{
  require_once dirname(__FILE__).'/SEI.php';
  
	session_start();
	
	SessaoSEI::getInstance(false);
	
	$strArq = null;
	
  switch ($_GET['servico']) {

    case 'sei':
      $strArq .= 'ws/sei.wsdl';
      break;

    case 'federacao':
      $strArq .= 'ws/federacao.wsdl';
      break;

    case 'sip':
      $strArq .= 'ws/sei_sip.wsdl';
      break;    

    case 'assinador':
      $strArq .= 'ws/assinador.wsdl';
      break;

    default:
    	
      foreach($SEI_MODULOS as $objModulo){
        if (($strArq = $objModulo->executar('processarControladorWebServices', $_GET['servico']))!=null){
          break;
        }
      }

    	if ($strArq == null){
        die('Servi�o ['.$_GET['servico'].'] inv�lido.');
    	}
  }

  $strServidor = ConfiguracaoSEI::getInstance()->getValor('SEI','URL');

  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'){
    $strServidor = str_replace('http://','https://',$strServidor);
  }else{
    $strServidor = str_replace('https://','http://',$strServidor);
  }

  InfraPagina::montarHeaderDownload($strArq);
  $strWsdl = file_get_contents($strArq);
  $strWsdl = str_replace('[servidor]', $strServidor, $strWsdl);

  die(trim($strWsdl));

}catch (Throwable $e){
  try {
    LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
  }catch (Throwable $e2){}
}
?>