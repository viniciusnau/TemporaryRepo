<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/10/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.12.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class GrauSigiloDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
 
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,
                                   'StaGrau');

  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,
                                   'Descricao');
  }
}
?>