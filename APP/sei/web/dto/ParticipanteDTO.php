<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/01/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.13.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ParticipanteDTO extends InfraDTO {
	
  public function getStrNomeTabela() {
  	 return 'participante';
  }

  public function montar() {

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdParticipante',
                                   'id_participante');
    
  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL,
                                   'IdProtocolo',
                                   'id_protocolo');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'StaParticipacao',
                                   'sta_participacao');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdContato',
                                   'id_contato');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Sequencia',
                                   'sequencia');
                                   
  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM,
                                              'IdUnidadeGeradoraProtocolo',
                                              'id_unidade_geradora',
                                              'protocolo');
                                              
  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeContato',
                                              'nome',
                                              'contato');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaContato',
                                              'sigla',
                                              'contato');
                                              
  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'EmailContato',
                                              'email',
                                              'contato');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_DBL,
                                              'CpfContato',
                                              'cpf',
                                              'contato');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_DBL,
                                              'CnpjContato',
                                              'cnpj',
                                              'contato')
    ;
    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'StaNaturezaContato',
                                              'sta_natureza',
                                              'contato');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaUnidade',
                                              'sigla',
                                              'unidade');

  	 $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'StaProtocoloProtocolo',
                                              'sta_protocolo',
                                              'protocolo');
                                              
    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'ProtocoloFormatadoProtocolo',
                                              'protocolo_formatado',
                                              'protocolo');                                              

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SinOuvidoriaUnidadeGeradoraProtocolo',
                                              'ugp.sin_ouvidoria',
                                              'unidade ugp');
    
    $this->configurarPK('IdParticipante', InfraDTO::$TIPO_PK_NATIVA );
                                                  
    $this->configurarFK('IdProtocolo', 'protocolo', 'id_protocolo');
    $this->configurarFK('IdContato', 'contato', 'id_contato');
    $this->configurarFK('IdUnidade', 'unidade', 'id_unidade');
    $this->configurarFK('IdUnidadeGeradoraProtocolo','unidade ugp', 'ugp.id_unidade');
  }
}
?>