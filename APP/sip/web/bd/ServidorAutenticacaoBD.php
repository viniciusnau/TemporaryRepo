<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 12/06/2014 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.33.1
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../Sip.php';

class ServidorAutenticacaoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

}

?>