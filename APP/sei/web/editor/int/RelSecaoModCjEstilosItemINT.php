<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/07/2014 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../../SEI.php';

class RelSecaoModCjEstilosItemINT extends InfraINT {

  /*public static function montarSelectIdSecaoModelo($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdSecaoModelo='', $numIdConjuntoEstilosItem=''){
    $objRelSecaoModCjEstilosItemDTO = new RelSecaoModCjEstilosItemDTO();
    $objRelSecaoModCjEstilosItemDTO->retNumIdSecaoModelo();
    $objRelSecaoModCjEstilosItemDTO->retNumIdConjuntoEstilosItem();
    $objRelSecaoModCjEstilosItemDTO->retNumIdSecaoModelo();

    if ($numIdSecaoModelo!==''){
      $objRelSecaoModCjEstilosItemDTO->setNumIdSecaoModelo($numIdSecaoModelo);
    }

    if ($numIdConjuntoEstilosItem!==''){
      $objRelSecaoModCjEstilosItemDTO->setNumIdConjuntoEstilosItem($numIdConjuntoEstilosItem);
    }

    $objRelSecaoModCjEstilosItemDTO->setOrdNumIdSecaoModelo(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelSecaoModCjEstilosItemRN = new RelSecaoModCjEstilosItemRN();
    $arrObjRelSecaoModCjEstilosItemDTO = $objRelSecaoModCjEstilosItemRN->listar($objRelSecaoModCjEstilosItemDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjRelSecaoModCjEstilosItemDTO, array('IdSecaoModelo','IdConjuntoEstilosItem'), 'IdSecaoModelo');
  }*/
}
?>