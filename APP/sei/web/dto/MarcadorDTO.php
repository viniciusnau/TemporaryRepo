<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/11/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.36.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class MarcadorDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'marcador';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdMarcador',
                                   'id_marcador');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'StaIcone',
                                   'sta_icone');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'ArquivoIcone');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'Processos');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'Alterados');

    $this->configurarPK('IdMarcador',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>