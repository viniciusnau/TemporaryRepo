<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 26/10/2009 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AssinaturaINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $dblIdDocumento=''){
    $objAssinaturaDTO = new AssinaturaDTO();
    $objAssinaturaDTO->retNumIdAssinatura();
    $objAssinaturaDTO->retStrNome();

    if ($dblIdDocumento!==''){
      $objAssinaturaDTO->setDblIdDocumento($dblIdDocumento);
    }

    $objAssinaturaDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objAssinaturaRN = new AssinaturaRN();
    $arrObjAssinaturaDTO = $objAssinaturaRN->listarRN1323($objAssinaturaDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjAssinaturaDTO, 'IdAssinatura', 'Nome');
  }

  public static function montarHtmlAssinaturas($arrObjAssinaturaDTO)
  {
    $strAssinaturas = '';
    foreach($arrObjAssinaturaDTO as $objAssinaturaDTO){
      $strAssinaturas .= SeiINT::montarItemCelula($objAssinaturaDTO->getStrNome().' / '.$objAssinaturaDTO->getStrTratamento(),'Assinatura');
    }

    return $strAssinaturas;
  }
}
?>