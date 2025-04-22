<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/09/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class OperacaoServicoINT extends InfraINT {

  public static function montarSelectStaOperacaoServico($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objOperacaoServicoRN = new OperacaoServicoRN();
    $arr = $objOperacaoServicoRN->listarValoresOperacaoServicoConfiguraveis();
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arr, 'StaOperacaoServico', 'Descricao');
  }

  public static function montarSelectOperacaoMonitoramento($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){

    $objOperacaoServicoRN = new OperacaoServicoRN();
    $arrObjTipoOperacaoServicoDTO = $objOperacaoServicoRN->listarValoresOperacaoServico();
    InfraArray::ordenarArrInfraDTO($arrObjTipoOperacaoServicoDTO,'Operacao',InfraArray::$TIPO_ORDENACAO_ASC);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoOperacaoServicoDTO, 'Operacao', 'Operacao');

  }

}
?>