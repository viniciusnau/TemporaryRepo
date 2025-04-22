<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/05/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AuditoriaProtocoloDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'auditoria_protocolo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL,
                                   'IdAuditoriaProtocolo',
                                   'id_auditoria_protocolo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL,
                                   'IdProtocolo',
                                   'id_protocolo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUsuario',
                                   'id_usuario');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAnexo',
                                   'id_anexo');
    
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Versao',
                                   'versao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DTA,
                                   'Auditoria',
                                   'dta_auditoria');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Recurso');
    
    $this->configurarPK('IdAuditoriaProtocolo',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>