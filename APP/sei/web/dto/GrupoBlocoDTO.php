<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/08/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class GrupoBlocoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'grupo_bloco';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdGrupoBloco', 'id_grupo_bloco');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdUnidade', 'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Nome', 'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'SinAtivo', 'sin_ativo');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'Blocos');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'Documentos');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'SemAssinatura');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'BlocosAssinatura');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'BlocosInternos');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'BlocosReuniao');

    $this->configurarPK('IdGrupoBloco',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
