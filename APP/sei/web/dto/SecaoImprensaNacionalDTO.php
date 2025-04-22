<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/09/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class SecaoImprensaNacionalDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'secao_imprensa_nacional';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdSecaoImprensaNacional',
                                   'id_secao_imprensa_nacional');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdVeiculoImprensaNacional',
                                   'id_veiculo_imprensa_nacional');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaVeiculoImprensaNacional',
                                              'sigla',
                                              'veiculo_imprensa_nacional');

    $this->configurarPK('IdSecaoImprensaNacional',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarFK('IdVeiculoImprensaNacional', 'veiculo_imprensa_nacional', 'id_veiculo_imprensa_nacional');
  }
}
?>