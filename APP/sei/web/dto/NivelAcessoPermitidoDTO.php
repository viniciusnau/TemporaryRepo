<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 04/04/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class NivelAcessoPermitidoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'nivel_acesso_permitido';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdNivelAcessoPermitido',
                                   'id_nivel_acesso_permitido');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoProcedimento',
                                   'id_tipo_procedimento');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'StaNivelAcesso',
                                   'sta_nivel_acesso');

    $this->configurarPK('IdNivelAcessoPermitido',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>