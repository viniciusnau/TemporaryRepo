<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 24/01/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.13.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssuntoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'assunto';
  }

  public function montar() {

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAssunto',
                                   'id_assunto');

     $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                    'IdTabelaAssuntos',
                                    'id_tabela_assuntos');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'CodigoEstruturado',
                                   'codigo_estruturado');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'PrazoCorrente',
                                   'prazo_corrente');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'PrazoIntermediario',
                                   'prazo_intermediario');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'StaDestinacao',
                                   'sta_destinacao');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinEstrutural',
                                   'sin_estrutural');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Observacao',
                                   'observacao');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'IdxAssunto',
                                   'idx_assunto');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SinAtualTabelaAssuntos',
                                              'sin_atual',
                                              'tabela_assuntos');

  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'PalavrasPesquisa');
  	 
     $this->configurarPK('IdAssunto', InfraDTO::$TIPO_PK_NATIVA );

     $this->configurarExclusaoLogica('SinAtivo', 'N');

     $this->configurarFK('IdTabelaAssuntos','tabela_assuntos','id_tabela_assuntos');

  }
}
?>