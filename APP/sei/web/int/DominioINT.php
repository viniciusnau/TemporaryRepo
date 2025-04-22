<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/05/2008 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.16.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class DominioINT extends InfraINT {

  public static function montarSelectValor($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdAtributo=''){
    $objDominioDTO = new DominioDTO();
    $objDominioDTO->retNumIdDominio();
    $objDominioDTO->retStrValor();
    $objDominioDTO->setOrdStrValor(InfraDTO::$TIPO_ORDENACAO_ASC);


    if ($numIdAtributo!==''){
      $objDominioDTO->setNumIdAtributo($numIdAtributo);
    }

    $objDominioRN = new DominioRN();
    $arrObjDominioDTO = $objDominioRN->listar($objDominioDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjDominioDTO, 'IdDominio', 'Valor');
  }
}
?>