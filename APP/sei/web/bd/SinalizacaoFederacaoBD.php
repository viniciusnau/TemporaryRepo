<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/12/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class SinalizacaoFederacaoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }

}
