<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 09/08/2017 - criado por mga
 *
 */

require_once dirname(__FILE__).'/../SEI.php';

class OperacaoAndamentoMarcadorDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {

    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,
        'StaOperacao');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,
        'Descricao');
  }
}
?>