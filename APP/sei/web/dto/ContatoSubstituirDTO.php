<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/12/2010 - criado por jonatas_db
*
* Vers�o do Gerador de C�digo: 1.12.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ContatoSubstituirDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {

  	$this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdContato');
  	$this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjContato');  	
                                              
  }
}
?>