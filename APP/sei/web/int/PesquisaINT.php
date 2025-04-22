<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/03/2020 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class PesquisaINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUsuario='', $numIdUnidade=''){
    $objPesquisaDTO = new PesquisaDTO();
    $objPesquisaDTO->retNumIdPesquisa();
    $objPesquisaDTO->retStrNome();

    if ($numIdUsuario!==''){
      $objPesquisaDTO->setNumIdUsuario($numIdUsuario);
    }

    if ($numIdUnidade!==''){
      $objPesquisaDTO->setNumIdUnidade($numIdUnidade);
    }

    $objPesquisaDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objPesquisaRN = new PesquisaRN();
    $arrObjPesquisaDTO = $objPesquisaRN->listar($objPesquisaDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjPesquisaDTO, 'IdPesquisa', 'Nome');
  }
}
