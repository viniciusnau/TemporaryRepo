<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/05/2011 - criado por mga
*
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class ReplicarSerieDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'StaOperacao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'IdSerie');
  }
}
?>
