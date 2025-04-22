<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 26/07/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class FeriadoINT extends InfraINT {

  public static function montarSelectDescricao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdOrgao=''){
    $objFeriadoDTO = new FeriadoDTO();
    $objFeriadoDTO->retNumIdFeriado();
    $objFeriadoDTO->retStrDescricao();

    if ($numIdOrgao!==''){
      $objFeriadoDTO->setNumIdOrgao($numIdOrgao);
    }

    $objFeriadoDTO->setOrdStrDescricao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objFeriadoRN = new FeriadoRN();
    $arrObjFeriadoDTO = $objFeriadoRN->listar($objFeriadoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjFeriadoDTO, 'IdFeriado', 'Descricao');
  }
}
?>