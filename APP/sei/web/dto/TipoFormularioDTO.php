<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/07/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.35.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoFormularioDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tipo_formulario';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoFormulario',
                                   'id_tipo_formulario');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdTipoFormulario',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>