<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/09/2009 - criado por fbv@trf4.gov.br
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EstadoBlocoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'StaEstado');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Descricao');
  }
}
?>