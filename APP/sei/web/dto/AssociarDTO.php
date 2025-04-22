<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/04/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.23.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssociarDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdProcedimento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUnidade');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuario');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaNivelAcessoGlobal');
  }
}
?>