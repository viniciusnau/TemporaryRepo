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

class VocativoINT extends InfraINT {

  public static function montarSelectExpressaoRI0469($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objVocativoDTO = new VocativoDTO();
    $objVocativoDTO->retNumIdVocativo();
    $objVocativoDTO->retStrExpressao();
    $objVocativoDTO->setOrdStrExpressao(InfraDTO::$TIPO_ORDENACAO_ASC);


    $objVocativoRN = new VocativoRN();
    $arrObjVocativoDTO = $objVocativoRN->listarRN0310($objVocativoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjVocativoDTO, 'IdVocativo', 'Expressao');
  }
}
?>