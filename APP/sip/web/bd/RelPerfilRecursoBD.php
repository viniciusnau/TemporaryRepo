<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/12/2006 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class RelPerfilRecursoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

}

?>