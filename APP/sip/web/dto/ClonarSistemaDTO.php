<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/01/2007 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class ClonarSistemaDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdOrgaoSistemaOrigem');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdSistemaOrigem');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdOrgaoSistemaDestino');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SiglaDestino');

    //Dados em separado porque a importa��o de sistema utiliza a mesma estrutura
    $this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'DadosSistemaDTO');
  }
}

?>