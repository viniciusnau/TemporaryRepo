<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/11/2012 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EmailSistemaBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }

}
?>