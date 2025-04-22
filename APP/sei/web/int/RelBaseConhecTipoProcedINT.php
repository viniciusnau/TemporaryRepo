<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/10/2010 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelBaseConhecTipoProcedINT extends InfraINT {

  public static function montarSelectNomeTipoProcedimento($numIdBaseConhecimento){
    
  	$objRelBaseConhecTipoProcedDTO = new RelBaseConhecTipoProcedDTO();
    $objRelBaseConhecTipoProcedDTO->retNumIdTipoProcedimento();
    $objRelBaseConhecTipoProcedDTO->retStrNomeTipoProcedimento();

    $objRelBaseConhecTipoProcedDTO->setNumIdBaseConhecimento($numIdBaseConhecimento);

    $objRelBaseConhecTipoProcedDTO->setOrdStrNomeTipoProcedimento(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelBaseConhecTipoProcedRN = new RelBaseConhecTipoProcedRN();
    $arrObjRelBaseConhecTipoProcedDTO = $objRelBaseConhecTipoProcedRN->listar($objRelBaseConhecTipoProcedDTO);

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjRelBaseConhecTipoProcedDTO, 'IdTipoProcedimento', 'NomeTipoProcedimento');
  }
}
?>