<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/03/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AlertaDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'alerta';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdAlerta',
                                   'id_alerta');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinBlocoAssinatura',
                                   'sin_bloco_assinatura');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinBlocoReuniao',
                                   'sin_bloco_reuniao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinControleProcessos',
                                   'sin_controle_processos');

    $this->configurarPK('IdAlerta',InfraDTO::$TIPO_PK_NATIVA);

  }
}
?>