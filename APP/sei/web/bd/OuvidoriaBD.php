<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/07/2013 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class OuvidoriaBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }

}
?>