<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/07/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class OrgaoHistoricoINT extends InfraINT {

  public static function montarSelectSigla($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdOrgao=''){
    $objOrgaoHistoricoDTO = new OrgaoHistoricoDTO();
    $objOrgaoHistoricoDTO->retNumIdOrgaoHistorico();
    $objOrgaoHistoricoDTO->retStrSigla();

    if ($numIdOrgao!==''){
      $objOrgaoHistoricoDTO->setNumIdOrgao($numIdOrgao);
    }

    $objOrgaoHistoricoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objOrgaoHistoricoRN = new OrgaoHistoricoRN();
    $arrObjOrgaoHistoricoDTO = $objOrgaoHistoricoRN->listar($objOrgaoHistoricoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjOrgaoHistoricoDTO, 'IdOrgaoHistorico', 'Sigla');
  }
}
