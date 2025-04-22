<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 27/05/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class OrgaoFederacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'orgao_federacao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'IdOrgaoFederacao', 'id_orgao_federacao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'IdInstalacaoFederacao', 'id_instalacao_federacao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Sigla', 'sigla');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Descricao', 'descricao');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjUnidadeFederacaoDTO');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinAcesso');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinOrigem');

    $this->configurarPK('IdOrgaoFederacao',InfraDTO::$TIPO_PK_INFORMADO);
  }
}
