<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 24/08/2015 - criado por mga
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__).'/../SEI.php';

class ResultadoPesquisaSolrDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR,'ObjInfraDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Cabecalho');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Rodape');
  }
}
?>