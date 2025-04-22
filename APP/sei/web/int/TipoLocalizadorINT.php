<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/05/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.16.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoLocalizadorINT extends InfraINT {

/*
  public static function montarSelectSigla($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade=''){
    $objTipoLocalizadorDTO = new TipoLocalizadorDTO();
    $objTipoLocalizadorDTO->retNumIdTipoLocalizador();
    $objTipoLocalizadorDTO->retStrSigla();
    $objTipoLocalizadorDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);


    if ($numIdUnidade!==''){
      $objTipoLocalizadorDTO->setNumIdUnidade($numIdUnidade);
    }

    $objTipoLocalizadorRN = new TipoLocalizadorRN();
    $arrObjTipoLocalizadorDTO = $objTipoLocalizadorRN->listar($objTipoLocalizadorDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoLocalizadorDTO, 'IdTipoLocalizador', 'Sigla');
  }
*/
  
  public static function montarSelectNomeRI0676($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTipoLocalizadorDTO = new TipoLocalizadorDTO();
    $objTipoLocalizadorDTO->retNumIdTipoLocalizador();
    $objTipoLocalizadorDTO->retStrNome();
    $objTipoLocalizadorDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);
    $objTipoLocalizadorDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

    $objTipoLocalizadorRN = new TipoLocalizadorRN();
    $arrObjTipoLocalizadorDTO = $objTipoLocalizadorRN->listarRN0610($objTipoLocalizadorDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoLocalizadorDTO, 'IdTipoLocalizador', 'Nome');
  }
  
}
?>