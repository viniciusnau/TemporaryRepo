<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/01/2007 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class DadosSistemaDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'SistemaDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRecursoDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjGrupoPerfilDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjPerfilDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRelGrupoPerfilPerfilDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRelPerfilRecursoDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjMenuDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjItemMenuDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRelPerfilItemMenuDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRegraAuditoriaDTO');
  }
}

?>