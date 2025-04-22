<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/05/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoUnidadeDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaTipo');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
  }
}
