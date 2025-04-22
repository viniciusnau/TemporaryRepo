<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/11/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.36.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TabelaAssuntosDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tabela_assuntos';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTabelaAssuntos',
                                   'id_tabela_assuntos');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtual',
                                   'sin_atual');

    $this->configurarPK('IdTabelaAssuntos',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>