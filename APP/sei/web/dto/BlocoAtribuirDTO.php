<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 15/07/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class BlocoAtribuirDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuarioAtribuicao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjBlocoDTO');
  }
}
?>