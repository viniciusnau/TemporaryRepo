<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 07/06/2010 - criado por fazenda_db
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EmailUnidadeDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'email_unidade';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdEmailUnidade',
                                   'id_email_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Email',
                                   'email');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
          'Sequencia',
          'sequencia');

    $this->configurarPK('IdEmailUnidade',InfraDTO::$TIPO_PK_NATIVA );
    

    $this->configurarFK('IdUnidade', 'unidade', 'id_unidade');
  }
}
?>