<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/01/2007 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class PermissaoDelegarDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuario');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjPermissaoDTO');
  }
}

?>