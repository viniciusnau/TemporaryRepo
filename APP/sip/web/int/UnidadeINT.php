<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/12/2006 - criado por mga
*
*
*/

require_once dirname(__FILE__) . '/../Sip.php';

class UnidadeINT extends InfraINT {

  public static function montarSelectSigla(
    $strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdOrgao = '') {
    $objUnidadeDTO = new UnidadeDTO();
    $objUnidadeDTO->retNumIdUnidade();

    if ($numIdOrgao !== '') {
      $objUnidadeDTO->setNumIdOrgao($numIdOrgao);
    }

    $objUnidadeDTO->retStrSigla();
    $objUnidadeDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUnidadeRN = new UnidadeRN();

    $arrObjUnidadeDTO = $objUnidadeRN->listar($objUnidadeDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUnidadeDTO, 'IdUnidade', 'Sigla');
  }

  public static function montarSelectSiglaAutorizadas(
    $strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdOrgao, $numIdSistema) {
    $objUnidadesAutorizadasDTO = new UnidadesAutorizadasDTO();
    $objUnidadesAutorizadasDTO->setNumIdSistema($numIdSistema);
    $objUnidadesAutorizadasDTO->setNumIdOrgaoUnidade($numIdOrgao);

    //Testa ap�s o set porque string 'null' � convertida para null no DTO
    if (InfraString::isBolVazia($objUnidadesAutorizadasDTO->getNumIdSistema())) {
      return '';
    }

    if (InfraString::isBolVazia($objUnidadesAutorizadasDTO->getNumIdOrgaoUnidade())) {
      return '';
    }

    $objUnidadeRN = new UnidadeRN();
    $arrObjRelHierarquiaUnidadeDTO = $objUnidadeRN->obterAutorizadas($objUnidadesAutorizadasDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjRelHierarquiaUnidadeDTO, 'IdUnidade', 'SiglaUnidade');
  }

  public static function formatarSiglaDescricao($strSigla, $strDescricao) {
    return $strSigla . ' - ' . $strDescricao;
  }
}

?>