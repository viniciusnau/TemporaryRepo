<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/06/2007 - criado por mga
*
*
* Vers�o do Gerador de C�digo:1.2.3
*/

require_once dirname(__FILE__) . '/../Sip.php';

class LoginBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

}

?>