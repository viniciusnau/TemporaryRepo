<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/07/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoAcaoFederacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
 
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'StaTipo');
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
  }
}
?>