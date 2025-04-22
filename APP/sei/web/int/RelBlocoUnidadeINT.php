<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/10/2009 - criado por fbv@trf4.gov.br
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelBlocoUnidadeINT extends InfraINT {

  public static function montarSelectIdUnidadesDisponibilizacao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdBloco){
    $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
    $objRelBlocoUnidadeDTO->retNumIdUnidade();
    $objRelBlocoUnidadeDTO->retStrSiglaUnidade();
    $objRelBlocoUnidadeDTO->retStrDescricaoUnidade();
    $objRelBlocoUnidadeDTO->setNumIdBloco($numIdBloco);
    $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual(),InfraDTO::$OPER_DIFERENTE);

    $objRelBlocoUnidadeDTO->setOrdStrSiglaUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
    $arrObjRelBlocoUnidadeDTO = $objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO);

    foreach($arrObjRelBlocoUnidadeDTO as $objRelBlocoUnidadeDTO){
      $objRelBlocoUnidadeDTO->setStrSiglaUnidade(UnidadeINT::formatarSiglaDescricao($objRelBlocoUnidadeDTO->getStrSiglaUnidade(),$objRelBlocoUnidadeDTO->getStrDescricaoUnidade()));
    }
    
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjRelBlocoUnidadeDTO, 'IdUnidade', 'SiglaUnidade');
  }
}
?>