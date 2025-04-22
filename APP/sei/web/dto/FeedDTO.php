<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 03/08/2010 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class FeedDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'feed';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdFeed',
                                   'id_feed');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Conteudo',
                                   'conteudo');

    $this->configurarPK('IdFeed', InfraDTO::$TIPO_PK_NATIVA );

  }
}
?>