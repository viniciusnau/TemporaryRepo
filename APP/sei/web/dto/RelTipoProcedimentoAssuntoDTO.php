<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 03/12/2007 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.9.2
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelTipoProcedimentoAssuntoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_tipo_procedimento_assunto';
  }

  public function montar() {

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoProcedimento',
                                   'id_tipo_procedimento');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAssuntoProxy',
                                   'id_assunto_proxy');
                                   
  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Sequencia',
                                   'sequencia');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeTipoProcedimento',
                                              'nome',
                                              'tipo_procedimento');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM,
                                              'IdAssunto',
                                              'id_assunto',
                                              'assunto_proxy');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'CodigoEstruturadoAssunto',
                                              'codigo_estruturado',
                                              'assunto');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'DescricaoAssunto',
                                              'descricao',
                                              'assunto');
                                              
    $this->configurarPK('IdTipoProcedimento',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdAssuntoProxy',InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('IdTipoProcedimento', 'tipo_procedimento', 'id_tipo_procedimento');
    $this->configurarFK('IdAssuntoProxy', 'assunto_proxy', 'id_assunto_proxy');
    $this->configurarFK('IdAssunto', 'assunto', 'id_assunto');
  }
}
?>