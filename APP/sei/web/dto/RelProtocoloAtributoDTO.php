<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 12/07/2010 - criado por fazenda_db
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelProtocoloAtributoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_protocolo_atributo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL,
                                   'IdProtocolo',
                                   'id_protocolo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAtributo',
                                   'id_atributo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Valor',
                                   'valor');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeAtributo',
                                              'nome',
                                              'atributo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'RotuloAtributo',
                                              'rotulo',
                                              'atributo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM,
                                              'OrdemAtributo',
                                              'ordem',
                                              'atributo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'StaTipoAtributo',
                                              'sta_tipo',
                                              'atributo');

    $this->configurarPK('IdProtocolo',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdAtributo',InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('IdAtributo','atributo','id_atributo');
  }
}
?>