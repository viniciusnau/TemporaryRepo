<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/12/2007 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.12.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class CidadeINT extends InfraINT {

  public static function montarSelectIdCidadeNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUf='', $numIdPais=null){
    if($numIdPais == null){
      $numIdPais = PaisINT::buscarIdPaisBrasil();
    }
    $objCidadeDTO = new CidadeDTO();
    $objCidadeDTO->retNumIdCidade();
    $objCidadeDTO->retStrNome();
    $objCidadeDTO->retStrSinCapital();
    $objCidadeDTO->setNumIdPais($numIdPais);

    if ($numIdPais==PaisINT::buscarIdPaisBrasil()) {
      $objCidadeDTO->setNumIdUf($numIdUf);
      $objCidadeDTO->setNumTipoFkUf(InfraDTO::$TIPO_FK_OBRIGATORIA);
    }else{
      if ($numIdUf!='' && $numIdUf!='null') {
        $objCidadeDTO->setNumIdUf($numIdUf);
      }
    }

    $objCidadeDTO->setOrdStrSinCapital(InfraDTO::$TIPO_ORDENACAO_DESC);
    $objCidadeDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objCidadeRN = new CidadeRN();
    $arrObjCidadeDTO = $objCidadeRN->listarRN0410($objCidadeDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjCidadeDTO, 'IdCidade', 'Nome');
  }

  public static function montarSelectNomeNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $strSiglaUf, $numIdPais=null){
    if($numIdPais == null){
      $numIdPais = PaisINT::buscarIdPaisBrasil();
    }
    $objCidadeDTO = new CidadeDTO();
    //$objCidadeDTO->retNumIdCidade();
    $objCidadeDTO->retStrNome();
    $objCidadeDTO->setNumIdPais($numIdPais);

    if ($numIdPais==PaisINT::buscarIdPaisBrasil()) {
      $objCidadeDTO->setNumTipoFkUf(InfraDTO::$TIPO_FK_OBRIGATORIA);
    }
    
    $objCidadeDTO->setOrdStrSinCapital(InfraDTO::$TIPO_ORDENACAO_DESC);
    $objCidadeDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    if ($strSiglaUf!==''){
      $objCidadeDTO->setStrSiglaUf($strSiglaUf);
    }

    $objCidadeRN = new CidadeRN();    
    $arrObjCidadeDTO = $objCidadeRN->listarRN0410($objCidadeDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjCidadeDTO, 'Nome', 'Nome');
  }
}
?>