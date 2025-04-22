<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/07/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class UnidadeHistoricoINT extends InfraINT {

  public static function montarSelectSigla($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade=''){
    $objUnidadeHistoricoDTO = new UnidadeHistoricoDTO();
    $objUnidadeHistoricoDTO->retNumIdUnidadeHistorico();
    $objUnidadeHistoricoDTO->retStrSigla();


    if ($numIdUnidade!==''){
      $objUnidadeHistoricoDTO->setNumIdUnidade($numIdUnidade);
    }

    $objUnidadeHistoricoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUnidadeHistoricoRN = new UnidadeHistoricoRN();
    $arrObjUnidadeHistoricoDTO = $objUnidadeHistoricoRN->listar($objUnidadeHistoricoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUnidadeHistoricoDTO, 'IdUnidadeHistorico', 'Sigla');
  }
}
