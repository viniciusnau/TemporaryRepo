<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 14/08/2019 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelAcessoExtSerieDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'rel_acesso_ext_serie';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdAcessoExterno', 'id_acesso_externo');
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdSerie', 'id_serie');

    $this->configurarPK('IdAcessoExterno',InfraDTO::$TIPO_PK_INFORMADO);
    $this->configurarPK('IdSerie',InfraDTO::$TIPO_PK_INFORMADO);


  }
}
