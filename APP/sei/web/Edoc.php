<?
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 
 * 12/11/2007 - criado por MGA
 *
 */

require_once dirname(__FILE__).'/SEI.php';

class Edoc {

  private static $instance = null;
  
 	public static function getInstance() { 
	    if (self::$instance == null) { 
        self::$instance = new Edoc();
	    } 
	    return self::$instance; 
	} 
 	 
  public function getWebService($strWSDL){
	  
    $objWS = null;
    
	  $ws = ConfiguracaoSEI::getInstance()->getValor('Edoc','Servidor').'/eDoc.SI/'.$strWSDL.'.asmx?WSDL';
  	
	  try {

	    if(!@file_get_contents($ws)){
	      throw new InfraException('Falha na leitura do arquivo WSDL ('.$strWSDL.')');
	    }

	    $objWS = new SoapClient($ws, array('encoding'=>'ISO-8859-1',
                                    	    'style' => SOAP_RPC,
                                    	    'use'   => SOAP_ENCODED,
                                    	    'location' => $ws));

	  } catch(Exception $e){
	    throw new InfraException('N�o foi poss�vel estabelecer conex�o com o reposit�rio de documentos (e-Doc).',$e);
	  }
	  
	  return $objWS;
  }
  
}
?>