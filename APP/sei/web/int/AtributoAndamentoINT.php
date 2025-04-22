<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/11/2009 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AtributoAndamentoINT extends InfraINT {

  public static function montarSelectNomeRI1372($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdAtividade=''){
    $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
    $objAtributoAndamentoDTO->retNumIdAtributoAndamento();
    $objAtributoAndamentoDTO->retStrNome();

    if ($numIdAtividade!==''){
      $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividade);
    }

    $objAtributoAndamentoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objAtributoAndamentoRN = new AtributoAndamentoRN();
    $arrObjAtributoAndamentoDTO = $objAtributoAndamentoRN->listarRN1367($objAtributoAndamentoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjAtributoAndamentoDTO, 'IdAtributoAndamento', 'Nome');
  }
}
?>