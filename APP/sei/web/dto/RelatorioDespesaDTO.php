<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/06/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.17.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelatorioDespesaDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SiglaOrgao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'NomeUsuario');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SiglaUnidade');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinPadrao');
  }
}
?>