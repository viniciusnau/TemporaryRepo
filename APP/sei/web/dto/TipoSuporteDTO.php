<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/05/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.16.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoSuporteDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tipo_suporte';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoSuporte',
                                   'id_tipo_suporte');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdTipoSuporte', InfraDTO::$TIPO_PK_NATIVA );

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>