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

class VeiculoImprensaNacionalDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'veiculo_imprensa_nacional';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdVeiculoImprensaNacional',
                                   'id_veiculo_imprensa_nacional');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Sigla',
                                   'sigla');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->configurarPK('IdVeiculoImprensaNacional',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>