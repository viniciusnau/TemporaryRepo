<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/07/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.19.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelAssinanteUnidadeINT extends InfraINT {
  
  public static function montarSelectUnidades($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdAssinante){
    $objRelAssinanteUnidadeDTO = new RelAssinanteUnidadeDTO();
    $objRelAssinanteUnidadeDTO->retNumIdUnidade();
    $objRelAssinanteUnidadeDTO->retStrSiglaUnidade();
    $objRelAssinanteUnidadeDTO->retStrDescricaoUnidade();
    
    $objRelAssinanteUnidadeDTO->setNumIdAssinante($numIdAssinante);
    
    $objRelAssinanteUnidadeDTO->setOrdStrSiglaUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelAssinanteUnidadeRN = new RelAssinanteUnidadeRN();
    $arrObjRelAssinanteUnidadeDTO = $objRelAssinanteUnidadeRN->listarRN1380($objRelAssinanteUnidadeDTO);
    
    foreach($arrObjRelAssinanteUnidadeDTO as $objRelAssinanteUnidadeDTO){
      $objRelAssinanteUnidadeDTO->setStrSiglaUnidade(UnidadeINT::formatarSiglaDescricao($objRelAssinanteUnidadeDTO->getStrSiglaUnidade(),$objRelAssinanteUnidadeDTO->getStrDescricaoUnidade()));
    }

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjRelAssinanteUnidadeDTO, 'IdUnidade', 'SiglaUnidade');
  }
}
?>