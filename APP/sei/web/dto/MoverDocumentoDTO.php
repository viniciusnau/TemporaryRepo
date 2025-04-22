<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/12/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.25.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class MoverDocumentoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL,'IdProcedimentoOrigem');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL,'IdProcedimentoDestino');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL,'IdDocumento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Motivo');
  }
}
?>