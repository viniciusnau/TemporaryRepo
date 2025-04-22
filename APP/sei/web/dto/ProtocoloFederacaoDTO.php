<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 28/05/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class ProtocoloFederacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'protocolo_federacao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'IdProtocoloFederacao', 'id_protocolo_federacao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'IdInstalacaoFederacao', 'id_instalacao_federacao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'ProtocoloFormatado', 'protocolo_formatado');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'ProtocoloFormatadoPesquisa', 'protocolo_formatado_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'ProtocoloFormatadoPesqInv', 'protocolo_formatado_pesq_inv');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR, 'SiglaInstalacaoFederacao', 'sigla', 'instalacao_federacao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR, 'DescricaoInstalacaoFederacao', 'descricao', 'instalacao_federacao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_DBL, 'CnpjInstalacaoFederacao', 'cnpj', 'instalacao_federacao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR, 'EnderecoInstalacaoFederacao', 'endereco', 'instalacao_federacao');

    $this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'ProtocoloDTO');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjAcessoFederacaoDTO');

    $this->configurarPK('IdProtocoloFederacao',InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('IdInstalacaoFederacao', 'instalacao_federacao', 'id_instalacao_federacao');

  }
}
