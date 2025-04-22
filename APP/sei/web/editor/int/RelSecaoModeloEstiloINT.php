<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/11/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: RelSecaoModeloEstiloINT.php 7875 2013-08-20 14:59:02Z bcu $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class RelSecaoModeloEstiloINT extends InfraINT {

  public static function montarSelectNomeEstilo($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdSecaoModelo='', $numIdEstilo=''){
    $objRelSecaoModeloEstiloDTO = new RelSecaoModeloEstiloDTO();
    //$objRelSecaoModeloEstiloDTO->retNumIdSecaoModelo();
    $objRelSecaoModeloEstiloDTO->retNumIdEstilo();
    $objRelSecaoModeloEstiloDTO->retStrNomeEstilo();

    if ($numIdSecaoModelo!==''){
      $objRelSecaoModeloEstiloDTO->setNumIdSecaoModelo($numIdSecaoModelo);
    }

    if ($numIdEstilo!==''){
      $objRelSecaoModeloEstiloDTO->setNumIdEstilo($numIdEstilo);
    }

    $objRelSecaoModeloEstiloDTO->setOrdStrNomeEstilo(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelSecaoModeloEstiloRN = new RelSecaoModeloEstiloRN();
    $arrObjRelSecaoModeloEstiloDTO = $objRelSecaoModeloEstiloRN->listar($objRelSecaoModeloEstiloDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjRelSecaoModeloEstiloDTO, 'IdEstilo', 'NomeEstilo');
  }
}
?>