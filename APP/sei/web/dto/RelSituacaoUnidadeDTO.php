<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/03/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelSituacaoUnidadeDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_situacao_unidade';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdSituacao',
                                   'id_situacao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
        'SiglaUnidade',
        'sigla',
        'unidade');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
        'DescricaoUnidade',
        'descricao',
        'unidade');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
        'SinAtivoSituacao',
        'sin_ativo',
        'situacao');

    $this->configurarPK('IdUnidade',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdSituacao',InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('IdUnidade', 'unidade', 'id_unidade');
    $this->configurarFK('IdSituacao', 'situacao', 'id_situacao');
  }
}
?>