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

class ServicoINT extends InfraINT {

  public static function montarSelectIdentificacao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUsuario=''){
    $objServicoDTO = new ServicoDTO();
    $objServicoDTO->retNumIdServico();
    $objServicoDTO->retStrIdentificacao();

    $objServicoDTO->setNumIdUsuario($numIdUsuario);

    if ($strValorItemSelecionado!=null){
      $objServicoDTO->setBolExclusaoLogica(false);
      $objServicoDTO->adicionarCriterio(array('SinAtivo','IdServico'),array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),array('S',$strValorItemSelecionado),InfraDTO::$OPER_LOGICO_OR);
    }

    $objServicoDTO->setOrdStrIdentificacao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objServicoRN = new ServicoRN();
    $arrObjServicoDTO = $objServicoRN->listar($objServicoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjServicoDTO, 'IdServico', 'Identificacao');
  }
}
?>