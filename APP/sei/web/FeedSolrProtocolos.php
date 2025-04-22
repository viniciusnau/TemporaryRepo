<?
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 
 * 18/10/2012 - criado por MGA
 * 25/10/2012 - alterado por MKR
 * 19/12/2012 - alterado por MGA
 *
 */

require_once dirname(__FILE__).'/SEI.php';

class FeedSolrProtocolos extends InfraSolrFeed {

	public function __construct(){
	  parent::__construct();
	}
	
	public function getStrServidor(){
    return ConfiguracaoSEI::getInstance()->getValor('Solr','Servidor');
	}

	public function getStrCore(){
    return ConfiguracaoSEI::getInstance()->getValor('Solr','CoreProtocolos');	  
	}
	
	public function getObjInfraLog(){
	  return LogSEI::getInstance();
	}
	
	public function getDiretorioTemporario(){
	  return DIR_SEI_TEMP;
	}
	
	public function getCommitWithin(){
		return ConfiguracaoSEI::getInstance()->getValor('Solr', 'TempoCommitProtocolos', false, 300) * 1000;
	}
}
?>