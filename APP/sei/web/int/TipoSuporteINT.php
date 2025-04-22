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

class TipoSuporteINT extends InfraINT {

  public static function montarSelectNomeRI0677($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTipoSuporteDTO = new TipoSuporteDTO();
    
    $objTipoSuporteDTO->retNumIdTipoSuporte();
    $objTipoSuporteDTO->retStrNome();
    $objTipoSuporteDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);
    
    if ($strValorItemSelecionado!=null){
      
      $objTipoSuporteDTO->setBolExclusaoLogica(false);
      $objTipoSuporteDTO->adicionarCriterio(array('SinAtivo','IdTipoSuporte'),
                                            array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
                                            array('S',$strValorItemSelecionado),
                                            InfraDTO::$OPER_LOGICO_OR);
    }


    $objTipoSuporteRN = new TipoSuporteRN();
    $arrObjTipoSuporteDTO = $objTipoSuporteRN->listarRN0634($objTipoSuporteDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoSuporteDTO, 'IdTipoSuporte', 'Nome');
  }
}
?>