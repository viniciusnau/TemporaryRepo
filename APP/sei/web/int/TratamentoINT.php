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

class TratamentoINT extends InfraINT {

  public static function montarSelectExpressaoRI0467($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTratamentoDTO = new TratamentoDTO();
    $objTratamentoDTO->retNumIdTratamento();
    $objTratamentoDTO->retStrExpressao();
    $objTratamentoDTO->setOrdStrExpressao(InfraDTO::$TIPO_ORDENACAO_ASC);


    $objTratamentoRN = new TratamentoRN();
    $arrObjTratamentoDTO = $objTratamentoRN->listarRN0318($objTratamentoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTratamentoDTO, 'IdTratamento', 'Expressao');
  }
}
?>