<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/03/2023 - criado por mgb29
*
* Vers�o do Gerador de C�digo: 1.43.2
*/

//require_once dirname(__FILE__).'/../Infra.php';

class InfraErroPhpDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'infra_erro_php';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'IdInfraErroPhp', 'id_infra_erro_php');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'StaTipo', 'sta_tipo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Arquivo', 'arquivo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'Linha', 'linha');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Erro', 'erro');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DTH, 'Cadastro', 'dth_cadastro');

    $this->configurarPK('IdInfraErroPhp',InfraDTO::$TIPO_PK_INFORMADO);

  }
}
