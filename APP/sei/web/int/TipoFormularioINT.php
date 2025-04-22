<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/07/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.35.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoFormularioINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTipoFormularioDTO = new TipoFormularioDTO();
    $objTipoFormularioDTO->retNumIdTipoFormulario();
    $objTipoFormularioDTO->retStrNome();

    if ($strValorItemSelecionado!=null){
      $objTipoFormularioDTO->setBolExclusaoLogica(false);
      $objTipoFormularioDTO->adicionarCriterio(array('SinAtivo','IdTipoFormulario'),array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),array('S',$strValorItemSelecionado),InfraDTO::$OPER_LOGICO_OR);
    }

    $objTipoFormularioDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objTipoFormularioRN = new TipoFormularioRN();
    $arrObjTipoFormularioDTO = $objTipoFormularioRN->listar($objTipoFormularioDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoFormularioDTO, 'IdTipoFormulario', 'Nome');
  }
}
?>