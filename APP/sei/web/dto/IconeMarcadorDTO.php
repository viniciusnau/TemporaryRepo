<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 10/11/2015 - criado por mga@trf4.gov.br
 *
 */

require_once dirname(__FILE__).'/../SEI.php';

class IconeMarcadorDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'StaIcone');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Descricao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Arquivo');
  }
}
?>