<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 27/09/2010 - criado por alexandre_db
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class EmailGrupoEmailINT extends InfraINT {

  public static function montarSelectIdEmailGrupo($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdGrupoEmail=''){
    $objEmailGrupoEmailDTO = new EmailGrupoEmailDTO();
    $objEmailGrupoEmailDTO->retNumIdEmailGrupoEmail();
    $objEmailGrupoEmailDTO->retNumIdGrupoEmail();

    if ($numIdGrupoEmail!==''){
      $objEmailGrupoEmailDTO->setNumIdGrupoEmail($numIdGrupoEmail);
    }

    $objEmailGrupoEmailDTO->setOrdNumIdGrupoEmail(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objEmailGrupoEmailRN = new EmailGrupoEmailRN();
    $arrObjEmailGrupoEmailDTO = $objEmailGrupoEmailRN->listar($objEmailGrupoEmailDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjEmailGrupoEmailDTO, 'IdEmailGrupoEmail', 'IdGrupoEmail');
  }
}
?>