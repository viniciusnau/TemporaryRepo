<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/03/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoArquivamentoEliminacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'StaEliminacao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Descricao');
  }
}
?>