<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 14/10/2019 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.42.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class CodigoBloqueioBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

}
