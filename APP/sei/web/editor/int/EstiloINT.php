<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/11/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: EstiloINT.php 7875 2013-08-20 14:59:02Z bcu $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class EstiloINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objEstiloDTO = new EstiloDTO();
    $objEstiloDTO->retNumIdEstilo();
    $objEstiloDTO->retStrNome();

    $objEstiloDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objEstiloRN = new EstiloRN();
    $arrObjEstiloDTO = $objEstiloRN->listar($objEstiloDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjEstiloDTO, 'IdEstilo', 'Nome');
  }
}
?>