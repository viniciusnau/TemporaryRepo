<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 01/12/2014 - criado por mga
 *
 */

require_once dirname(__FILE__).'/../SEI.php';

class ControleUnidadeBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
    parent::__construct($objInfraIBanco);
  }

}
?>