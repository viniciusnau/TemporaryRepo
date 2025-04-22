<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 12/02/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.13.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelProtocoloAssuntoINT extends InfraINT {

  public static function conjuntoPorCodigoDescricaoRI0510($dblIdProtocolo){

    $objRelProtocoloAssuntoDTO = new RelProtocoloAssuntoDTO();
    $objRelProtocoloAssuntoDTO->setDistinct(true);
    $objRelProtocoloAssuntoDTO->retNumSequencia();
    $objRelProtocoloAssuntoDTO->retNumIdAssunto();
    $objRelProtocoloAssuntoDTO->retStrCodigoEstruturadoAssunto();
    $objRelProtocoloAssuntoDTO->retStrDescricaoAssunto();
    $objRelProtocoloAssuntoDTO->setDblIdProtocolo($dblIdProtocolo);
    $objRelProtocoloAssuntoDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelProtocoloAssuntoRN = new RelProtocoloAssuntoRN();
    $arrObjRelProtocoloAssuntoDTO = InfraArray::distinctArrInfraDTO($objRelProtocoloAssuntoRN->listarRN0188($objRelProtocoloAssuntoDTO),'IdAssunto');

    foreach($arrObjRelProtocoloAssuntoDTO as $dto){
      $dto->setStrDescricaoAssunto(AssuntoINT::formatarCodigoDescricaoRI0568($dto->getStrCodigoEstruturadoAssunto(),$dto->getStrDescricaoAssunto()));
    }

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjRelProtocoloAssuntoDTO, 'IdAssunto','DescricaoAssunto');
  }
}
?>