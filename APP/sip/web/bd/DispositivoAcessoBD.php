<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 13/09/2019 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.42.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class DispositivoAcessoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

}
