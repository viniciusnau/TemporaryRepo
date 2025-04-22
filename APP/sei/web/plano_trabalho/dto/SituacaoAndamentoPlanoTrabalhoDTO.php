<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 27/09/2022 - criado por mgb29
 *
 * Vers�o do Gerador de C�digo: 1.43.1
 */

require_once dirname(__FILE__) . '/../../SEI.php';

class SituacaoAndamentoPlanoTrabalhoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaSituacao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Icone');
  }
}
