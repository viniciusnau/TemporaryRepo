<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/06/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TarjaAssinaturaINT extends InfraINT {

  public static function montarSelectStaTarjaAssinatura($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTarjaAssinaturaRN = new TarjaAssinaturaRN();
    $arrObjTipoDTO = $objTarjaAssinaturaRN->listarTiposTarjaAssinatura();
    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoDTO, 'StaTipo', 'Descricao');
  }
}
?>