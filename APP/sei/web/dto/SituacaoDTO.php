<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/09/2014 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class SituacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'situacao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,'IdSituacao','id_situacao');
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,'Nome','nome');
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,'Descricao','descricao');
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,'SinAtivo','sin_ativo');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR,'ObjRelSituacaoUnidadeDTO');

    $this->configurarPK('IdSituacao',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>