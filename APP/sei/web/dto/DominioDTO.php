<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/05/2008 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.16.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class DominioDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'dominio';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdDominio',
                                   'id_dominio');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAtributo',
                                   'id_atributo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Valor',
                                   'valor');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Rotulo',
                                   'rotulo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                  'Ordem',
                                  'ordem');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinPadrao',
                                   'sin_padrao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeAtributo',
                                              'nome',
                                              'atributo');

    $this->configurarPK('IdDominio', InfraDTO::$TIPO_PK_NATIVA );
    

    $this->configurarFK('IdAtributo', 'atributo', 'id_atributo');
    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>