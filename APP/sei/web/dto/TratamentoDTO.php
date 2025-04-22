<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 12/12/2007 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.10.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TratamentoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tratamento';
  }

  public function montar() {

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdTratamento',
                                   'id_tratamento');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Expressao',
                                   'expressao');

  	 $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdTratamento', InfraDTO::$TIPO_PK_NATIVA );

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>