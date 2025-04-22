<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/12/2007 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.10.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoContatoINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){

    $objTipoContatoDTO = new TipoContatoDTO();
    $objTipoContatoDTO->retNumIdTipoContato();
    $objTipoContatoDTO->retStrNome();
    $objTipoContatoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    if ($strValorItemSelecionado!=null){

      $objTipoContatoDTO->setBolExclusaoLogica(false);
      $objTipoContatoDTO->adicionarCriterio(array('SinAtivo','IdTipoContato'),
        array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
        array('S',$strValorItemSelecionado),
        InfraDTO::$OPER_LOGICO_OR);
    }

    $objTipoContatoRN = new TipoContatoRN();
    $arrObjTipoContatoDTO = $objTipoContatoRN->listarRN0337($objTipoContatoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoContatoDTO, 'IdTipoContato', 'Nome');
  }

  public static function montarSelectNomeUnico($numIdTipoContato){
    $objTipoContatoDTO = new TipoContatoDTO();
    $objTipoContatoDTO->setBolExclusaoLogica(false);
    $objTipoContatoDTO->retNumIdTipoContato();
    $objTipoContatoDTO->retStrNome();
    $objTipoContatoDTO->setNumIdTipoContato($numIdTipoContato);

    $objTipoContatoRN = new TipoContatoRN();
    $arrObjTipoContatoDTO = $objTipoContatoRN->listarRN0337($objTipoContatoDTO);

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjTipoContatoDTO, 'IdTipoContato', 'Nome');
  }

  public static function montarSelectNomeRI0518($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){

    $arrObjTipoContatoDTO = array();

    $objPesquisaTipoContatoDTO = new PesquisaTipoContatoDTO();
    $objPesquisaTipoContatoDTO->setStrStaAcesso(TipoContatoRN::$TA_CONSULTA_RESUMIDA);

    $objTipoContatoRN = new TipoContatoRN();
    $arrIdTipoContatoAcesso = $objTipoContatoRN->pesquisarAcessoUnidade($objPesquisaTipoContatoDTO);

    if (InfraArray::contar($arrIdTipoContatoAcesso)) {

      $objTipoContatoDTO = new TipoContatoDTO();
      $objTipoContatoDTO->retNumIdTipoContato();
      $objTipoContatoDTO->retStrNome();
      $objTipoContatoDTO->setNumIdTipoContato($arrIdTipoContatoAcesso,InfraDTO::$OPER_IN);
      $objTipoContatoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objTipoContatoRN = new TipoContatoRN();
      $arrObjTipoContatoDTO = $objTipoContatoRN->listarRN0337($objTipoContatoDTO);
    }

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoContatoDTO, 'IdTipoContato', 'Nome');
  }

  public static function montarSelectNomeRI0898($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){

    $arrObjTipoContatoDTO = array();

    $objPesquisaTipoContatoDTO = new PesquisaTipoContatoDTO();
    $objPesquisaTipoContatoDTO->setStrStaAcesso(TipoContatoRN::$TA_ALTERACAO);

    $objTipoContatoRN = new TipoContatoRN();
    $arrIdTipoContatoAcesso = $objTipoContatoRN->pesquisarAcessoUnidade($objPesquisaTipoContatoDTO);

    if (InfraArray::contar($arrIdTipoContatoAcesso)){

      $objTipoContatoDTO = new TipoContatoDTO();
      $objTipoContatoDTO->retNumIdTipoContato();
      $objTipoContatoDTO->retStrNome();
      $objTipoContatoDTO->setNumIdTipoContato($arrIdTipoContatoAcesso, InfraDTO::$OPER_IN);
      $objTipoContatoDTO->setStrSinSistema('N');
      $objTipoContatoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

      if ($strValorItemSelecionado!=null){

        $objTipoContatoDTO->setBolExclusaoLogica(false);
        $objTipoContatoDTO->adicionarCriterio(array('SinAtivo','IdTipoContato'),
            array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
            array('S',$strValorItemSelecionado),
            InfraDTO::$OPER_LOGICO_OR);
      }

      $objTipoContatoRN = new TipoContatoRN();
      $arrObjTipoContatoDTO = $objTipoContatoRN->listarRN0337($objTipoContatoDTO);
    }

    if (InfraArray::contar($arrObjTipoContatoDTO)==1){
      $strValorItemSelecionado = $arrObjTipoContatoDTO[0]->getNumIdTipoContato();
    }

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTipoContatoDTO, 'IdTipoContato', 'Nome');
  }
}
?>