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

class LinkAcessoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuario');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdProcedimento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'ProtocoloProcedimentoFormatado');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'LinkProcesso');
    
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdDocumento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'ProtocoloDocumentoFormatado');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'LinkDocumento');
    
  }
}
?>