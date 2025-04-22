<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 03/08/2016 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.38.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelAcessoExtProtocoloDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_acesso_ext_protocolo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAcessoExterno',
                                   'id_acesso_externo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL,
                                   'IdProtocolo',
                                   'id_protocolo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'ProtocoloFormatadoProtocolo',
                                              'protocolo_formatado',
                                              'protocolo');

    $this->configurarPK('IdAcessoExterno',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdProtocolo',InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('IdProtocolo','protocolo','id_protocolo');

  }
}
?>