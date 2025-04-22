<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/07/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.19.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelUnidadeTipoContatoINT extends InfraINT {

  public static function montarSelectSiglaUnidadeRI1202($numIdTipoContato, &$strSelUnidadesAlteracao, &$strSelUnidadesConsulta){
    
    $objRelUnidadeTipoContatoDTO = new RelUnidadeTipoContatoDTO();
    $objRelUnidadeTipoContatoDTO->retNumIdUnidade();
    $objRelUnidadeTipoContatoDTO->retStrSiglaUnidade();
    $objRelUnidadeTipoContatoDTO->retStrStaAcesso();
    $objRelUnidadeTipoContatoDTO->setOrdStrSiglaUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);
    $objRelUnidadeTipoContatoDTO->setNumIdTipoContato($numIdTipoContato);
    
    $objRelUnidadeTipoContatoRN = new RelUnidadeTipoContatoRN();
    $arrObjRelUnidadeTipoContatoDTO = $objRelUnidadeTipoContatoRN->listarRN0547($objRelUnidadeTipoContatoDTO);

    $arrAlteracao = array();
    $arrConsulta = array();
    foreach($arrObjRelUnidadeTipoContatoDTO as $objRelUnidadeTipoContatoDTO){
      if ($objRelUnidadeTipoContatoDTO->getStrStaAcesso()==TipoContatoRN::$TA_ALTERACAO){
        $arrAlteracao[] = $objRelUnidadeTipoContatoDTO;
      }else{
        $arrConsulta[] = $objRelUnidadeTipoContatoDTO;
      }
    }

    $strSelUnidadesAlteracao = parent::montarSelectArrInfraDTO(null,null,null, $arrAlteracao, 'IdUnidade', 'SiglaUnidade');
    $strSelUnidadesConsulta = parent::montarSelectArrInfraDTO(null,null,null, $arrConsulta, 'IdUnidade', 'SiglaUnidade');
  }
}
?>