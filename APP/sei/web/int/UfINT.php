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

class UfINT extends InfraINT {

  public static function montarSelectSiglaSigla($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdPais=null){
    if($numIdPais==null){
      $numIdPais = PaisINT::buscarIdPaisBrasil();
    }
    $objUfDTO = new UfDTO();
    $objUfDTO->retStrSigla();
    if ($numIdPais!='') {
      $objUfDTO->setNumIdPais($numIdPais);
    }
    $objUfDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);


    $objUfRN = new UfRN();
    $arrObjUfDTO = $objUfRN->listarRN0401($objUfDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUfDTO, 'Sigla', 'Sigla');
  }

  public static function montarSelectSiglaNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdPais=null){
    if($numIdPais == null){
      $numIdPais = PaisINT::buscarIdPaisBrasil();
    }
    $objUfDTO = new UfDTO();
    $objUfDTO->retNumIdUf();
    $objUfDTO->retStrSigla();
    $objUfDTO->retStrNome();
    $objUfDTO->setNumIdPais($numIdPais);
    $objUfDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUfRN = new UfRN();
    $arrObjUfDTO = $objUfRN->listarRN0401($objUfDTO);

    foreach($arrObjUfDTO as $objUfDTO){
      if(!InfraString::isBolVazia($objUfDTO->getStrSigla() )) {
        $objUfDTO->setStrSigla($objUfDTO->getStrSigla() . ' - ' . $objUfDTO->getStrNome());
      }else{
        $objUfDTO->setStrSigla($objUfDTO->getStrNome());
      }
    }
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUfDTO, 'IdUf', 'Sigla');
  }

  public static function montarSelectSiglaRI0416($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdPais=null){
    if($numIdPais==null){
      $numIdPais = PaisINT::buscarIdPaisBrasil();
    }
    $objUfDTO = new UfDTO();
    $objUfDTO->retNumIdUf();
    $objUfDTO->retStrSigla();
    $objUfDTO->setNumIdPais($numIdPais);
    $objUfDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUfRN = new UfRN();
    $arrObjUfDTO = $objUfRN->listarRN0401($objUfDTO);
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUfDTO, 'IdUf', 'Sigla');
  }
}
?>