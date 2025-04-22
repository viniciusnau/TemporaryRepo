<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/03/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class PaisDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'pais';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdPais',
                                   'id_pais');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->configurarPK('IdPais',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>