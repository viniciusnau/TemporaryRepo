<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/03/2023 - criado por mgb29
*
* Vers�o do Gerador de C�digo: 1.43.2
*/

//require_once dirname(__FILE__).'/../Infra.php';

class InfraErroPhpTipoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'StaTipo');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Erro');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaTratamento');
  }
}
