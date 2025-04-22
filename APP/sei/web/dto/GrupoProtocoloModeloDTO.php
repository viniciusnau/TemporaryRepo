<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/08/2012 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class GrupoProtocoloModeloDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'grupo_protocolo_modelo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdGrupoProtocoloModelo',
                                   'id_grupo_protocolo_modelo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->configurarPK('IdGrupoProtocoloModelo',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>