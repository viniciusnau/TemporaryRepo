<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/11/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class CpadVersaoINT extends InfraINT {

  public static function montarSelectIdCpadVersao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdCpad='', $numIdUsuario='', $numIdUnidade=''){
    $objCpadVersaoDTO = new CpadVersaoDTO();
    $objCpadVersaoDTO->retNumIdCpadVersao();
    $objCpadVersaoDTO->retNumIdCpadVersao();

    if ($numIdCpad!==''){
      $objCpadVersaoDTO->setNumIdCpad($numIdCpad);
    }

    if ($numIdUsuario!==''){
      $objCpadVersaoDTO->setNumIdUsuario($numIdUsuario);
    }

    if ($numIdUnidade!==''){
      $objCpadVersaoDTO->setNumIdUnidade($numIdUnidade);
    }

    $objCpadVersaoDTO->setOrdNumIdCpadVersao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objCpadVersaoRN = new CpadVersaoRN();
    $arrObjCpadVersaoDTO = $objCpadVersaoRN->listar($objCpadVersaoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjCpadVersaoDTO, 'IdCpadVersao', 'IdCpadVersao');
  }
}
