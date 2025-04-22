<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/03/2014 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelSerieAssuntoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_serie_assunto';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdSerie',
                                   'id_serie');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAssuntoProxy',
                                   'id_assunto_proxy');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Sequencia',
                                   'sequencia');

    
    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
        'NomeSerie',
        'nome',
        'serie');

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
    
    $this->configurarPK('IdSerie',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdAssuntoProxy',InfraDTO::$TIPO_PK_INFORMADO);
    
    $this->configurarFK('IdSerie', 'serie', 'id_serie');
    $this->configurarFK('IdAssuntoProxy', 'assunto_proxy', 'id_assunto_proxy');
    $this->configurarFK('IdAssunto', 'assunto', 'id_assunto');
    

  }
}
?>