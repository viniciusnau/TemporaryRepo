<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/12/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: VersaoSecaoDocumentoINT.php 7875 2013-08-20 14:59:02Z bcu $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class VersaoSecaoDocumentoINT extends InfraINT {

  public static function montarSelectIdSecaoDocumento($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdSecaoDocumento=''){
    $objVersaoSecaoDocumentoDTO = new VersaoSecaoDocumentoDTO();
    $objVersaoSecaoDocumentoDTO->retNumVersao();
    $objVersaoSecaoDocumentoDTO->retNumIdSecaoDocumento();
    $objVersaoSecaoDocumentoDTO->retNumIdSecaoDocumento();

    if ($numIdSecaoDocumento!==''){
      $objVersaoSecaoDocumentoDTO->setNumIdSecaoDocumento($numIdSecaoDocumento);
    }

    $objVersaoSecaoDocumentoDTO->setOrdNumIdSecaoDocumento(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objVersaoSecaoDocumentoRN = new VersaoSecaoDocumentoRN();
    $arrObjVersaoSecaoDocumentoDTO = $objVersaoSecaoDocumentoRN->listar($objVersaoSecaoDocumentoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjVersaoSecaoDocumentoDTO, "array('Versao','IdSecaoDocumento')", 'IdSecaoDocumento');
  }
}
?>