<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/12/2021 - criado por mgb29
*
* Vers�o do Gerador de C�digo: 1.43.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class DocumentoGeracaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'documento_geracao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL, 'IdDocumento', 'id_documento');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DBL, 'IdDocumentoModelo', 'id_documento_modelo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdTextoPadraoInterno', 'id_texto_padrao_interno');

    $this->configurarPK('IdDocumento',InfraDTO::$TIPO_PK_INFORMADO);

  }
}
