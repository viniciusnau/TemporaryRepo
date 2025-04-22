<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 22/09/2014 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class GrupoUnidadeDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'grupo_unidade';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdGrupoUnidade',
                                   'id_grupo_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'StaTipo',
                                   'sta_tipo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjRelGrupoUnidadeUnidadeDTO');

    $this->configurarPK('IdGrupoUnidade',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>