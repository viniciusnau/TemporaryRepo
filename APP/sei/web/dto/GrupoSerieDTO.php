<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/07/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.19.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class GrupoSerieDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'grupo_serie';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdGrupoSerie',
                                   'id_grupo_serie');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdGrupoSerie', InfraDTO::$TIPO_PK_NATIVA );
    

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>