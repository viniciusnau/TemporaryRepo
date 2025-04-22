<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/03/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.13.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssuntoAtualizacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'CodigoEstruturadoAnterior');
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'CodigoEstruturadoAtual');
  	 
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdAssuntoAnterior');
  	 $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdAssuntoAtual');
  }
}
?>
