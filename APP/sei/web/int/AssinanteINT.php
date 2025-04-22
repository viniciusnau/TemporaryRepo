<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 13/10/2009 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssinanteINT extends InfraINT {

  public static function montarSelectCargoFuncaoUnidadeUsuarioRI1344($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUsuario){

    $objUsuarioDTO = new UsuarioDTO();
    $objUsuarioDTO->setNumIdUsuario($numIdUsuario);

    $objUsuarioRN = new UsuarioRN();
    $arrCargoFuncao = InfraArray::converterArrInfraDTO($objUsuarioRN->listarCargoFuncao($objUsuarioDTO),'CargoFuncao');

    $arrValores = array();
    foreach($arrCargoFuncao as $strCargoFuncao){
      $arrValores[InfraPagina::tratarHTML($strCargoFuncao)] = $strCargoFuncao;
    }

    return parent::montarSelectArray($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrValores);
  }
}
?>