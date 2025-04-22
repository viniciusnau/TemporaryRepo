<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/10/2010 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelBaseConhecTipoProcedDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_base_conhec_tipo_proced';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoProcedimento',
                                   'id_tipo_procedimento');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdBaseConhecimento',
                                   'id_base_conhecimento');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeTipoProcedimento',
                                              'nome',
                                              'tipo_procedimento');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'DescricaoBaseConhecimento',
                                              'descricao',
                                              'base_conhecimento');
  	 
  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'StaEstadoBaseConhecimento',
                                              'sta_estado',
                                              'base_conhecimento');
  	 
  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM,
                                              'IdUnidadeBaseConhecimento',
                                              'id_unidade',
                                              'base_conhecimento');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaUnidadeBaseConhecimento',
                                              'sigla',
                                              'unidade');
  	 
    $this->configurarPK('IdTipoProcedimento',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdBaseConhecimento',InfraDTO::$TIPO_PK_INFORMADO);
    
    $this->configurarFK('IdBaseConhecimento','base_conhecimento','id_base_conhecimento');
    $this->configurarFK('IdTipoProcedimento','tipo_procedimento','id_tipo_procedimento');
    $this->configurarFK('IdUnidadeBaseConhecimento','unidade','id_unidade');

  }
}
?>