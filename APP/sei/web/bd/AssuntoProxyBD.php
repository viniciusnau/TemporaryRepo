<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/11/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.36.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssuntoProxyBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }

}
?>