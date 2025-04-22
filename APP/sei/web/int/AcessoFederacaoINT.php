<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 22/05/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class AcessoFederacaoINT extends InfraINT {

  public static function montarSelectStaTipo($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objAcessoFederacaoRN = new AcessoFederacaoRN();

    $arrObjTipoAcessoFederacaoDTO = $objAcessoFederacaoRN->listarValoresTipo();

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoAcessoFederacaoDTO, 'StaTipo', 'Descricao');

  }

  public static function montarSelectStaSentido($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $arr = array(AcessoFederacaoRN::$TST_ENVIADO => 'Enviado',
                 AcessoFederacaoRN::$TST_RECEBIDO => 'Recebido');
    return parent::montarSelectArray($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arr);
  }

}
