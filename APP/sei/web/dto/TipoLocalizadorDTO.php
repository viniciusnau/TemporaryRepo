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

class TipoLocalizadorDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tipo_localizador';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTipoLocalizador',
                                   'id_tipo_localizador');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Sigla',
                                   'sigla');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                    'Descricao',
                                    'descricao');
    
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdTipoLocalizador',InfraDTO::$TIPO_PK_NATIVA );

    $this->configurarFK('IdUnidade', 'unidade', 'id_unidade');
    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>