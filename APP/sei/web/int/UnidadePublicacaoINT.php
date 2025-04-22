<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/12/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class UnidadePublicacaoINT extends InfraINT {

  public static function montarSelectIdUnidade($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade=''){
    $objUnidadePublicacaoDTO = new UnidadePublicacaoDTO();
    $objUnidadePublicacaoDTO->retNumIdUnidadePublicacao();
    $objUnidadePublicacaoDTO->retNumIdUnidade();

    if ($numIdUnidade!==''){
      $objUnidadePublicacaoDTO->setNumIdUnidade($numIdUnidade);
    }

    $objUnidadePublicacaoDTO->setOrdNumIdUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUnidadePublicacaoRN = new UnidadePublicacaoRN();
    $arrObjUnidadePublicacaoDTO = $objUnidadePublicacaoRN->listar($objUnidadePublicacaoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUnidadePublicacaoDTO, 'IdUnidadePublicacao', 'IdUnidade');
  }
}
?>