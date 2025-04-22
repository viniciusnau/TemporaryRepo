<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/11/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoConferenciaINT extends InfraINT {

  public static function montarSelectDescricao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTipoConferenciaDTO = new TipoConferenciaDTO();
    $objTipoConferenciaDTO->retNumIdTipoConferencia();
    $objTipoConferenciaDTO->retStrDescricao();

    if ($strValorItemSelecionado!=null){
      $objTipoConferenciaDTO->setBolExclusaoLogica(false);
      $objTipoConferenciaDTO->adicionarCriterio(array('SinAtivo','IdTipoConferencia'),array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),array('S',$strValorItemSelecionado),InfraDTO::$OPER_LOGICO_OR);
    }

    $objTipoConferenciaDTO->setOrdStrDescricao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objTipoConferenciaRN = new TipoConferenciaRN();
    $arrObjTipoConferenciaDTO = $objTipoConferenciaRN->listar($objTipoConferenciaDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoConferenciaDTO, 'IdTipoConferencia', 'Descricao');
  }
}
?>