<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/05/2011 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class TransferirCredencialDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR,'ObjProtocoloDTO');
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'IdUsuario');
  }
}
?>