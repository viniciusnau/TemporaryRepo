<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 20/12/2007 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.12.0
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__).'/../SEI.php';

class EmailUtilizadoINT extends InfraINT {


  public static function autoCompletarEmail($numIdUnidade,$strPalavrasPesquisa){

    $objEmailUtilizadoDTO=new EmailUtilizadoDTO();
    $objEmailUtilizadoDTO->retStrEmail();
    $objEmailUtilizadoDTO->retNumIdEmailUtilizado();
    $objEmailUtilizadoDTO->setNumIdUnidade($numIdUnidade);
    $objEmailUtilizadoDTO->setStrEmail('%'.$strPalavrasPesquisa.'%',InfraDTO::$OPER_LIKE);
    $objEmailUtilizadoDTO->setOrdStrEmail(InfraDTO::$TIPO_ORDENACAO_ASC);
    $objEmailUtilizadoDTO->setNumMaxRegistrosRetorno(50);

    $objEmailUtilizadoRN=new EmailUtilizadoRN();

    $arrObjEmailUtilizadoDTO = $objEmailUtilizadoRN->listar($objEmailUtilizadoDTO);

    return $arrObjEmailUtilizadoDTO;
  }
}
?>