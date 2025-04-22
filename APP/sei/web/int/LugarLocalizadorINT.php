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

class LugarLocalizadorINT extends InfraINT {

  public static function montarSelectNomeRI0678($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade=''){
    $objLugarLocalizadorDTO = new LugarLocalizadorDTO();
    $objLugarLocalizadorDTO->retNumIdLugarLocalizador();
    $objLugarLocalizadorDTO->retStrNome();
    $objLugarLocalizadorDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objLugarLocalizadorDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

    if ($strValorItemSelecionado!=null){
      
      $objLugarLocalizadorDTO->setBolExclusaoLogica(false);
      $objLugarLocalizadorDTO->adicionarCriterio(array('SinAtivo','IdLugarLocalizador'),
                                            array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
                                            array('S',$strValorItemSelecionado),
                                            InfraDTO::$OPER_LOGICO_OR);
    }
    
    $objLugarLocalizadorRN = new LugarLocalizadorRN();
    $arrObjLugarLocalizadorDTO = $objLugarLocalizadorRN->listarRN0655($objLugarLocalizadorDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjLugarLocalizadorDTO, 'IdLugarLocalizador', 'Nome');
  }
}
?>