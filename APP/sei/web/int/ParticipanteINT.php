<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/01/2008 - criado por marcio_db
*
* Vers�o do Gerador de C�digo: 1.13.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ParticipanteINT extends InfraINT {

  public static function conjuntoPorParticipacaoRI0513($dblIdProtocolo,$arrStaParticipacao){
    $objParticipanteDTO = new ParticipanteDTO();
    $objParticipanteDTO->retNumIdContato();
    $objParticipanteDTO->retStrNomeContato();
    $objParticipanteDTO->retStrSiglaContato();
    $objParticipanteDTO->setDblIdProtocolo($dblIdProtocolo);
    $objParticipanteDTO->setStrStaParticipacao($arrStaParticipacao,InfraDTO::$OPER_IN);
    
    $objParticipanteDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);
    
    $objParticipanteRN = new ParticipanteRN();
    $arrObjParticipanteDTO = $objParticipanteRN->listarRN0189($objParticipanteDTO);

    foreach($arrObjParticipanteDTO as $objParticipanteDTO){
      $objParticipanteDTO->setStrNomeContato(ContatoINT::formatarNomeSiglaRI1224($objParticipanteDTO->getStrNomeContato(),$objParticipanteDTO->getStrSiglaContato()));
    }

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjParticipanteDTO, 'IdContato','NomeContato');
  }		
  
  public static function montarSelectInteressados($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $dblIdProtocolo){
    $objParticipanteDTO = new ParticipanteDTO();
    $objParticipanteDTO->retNumIdParticipante();
    $objParticipanteDTO->retStrNomeContato();
    $objParticipanteDTO->setDblIdProtocolo($dblIdProtocolo);
    $objParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_INTERESSADO);
    $objParticipanteDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);
    
    $objParticipanteRN = new ParticipanteRN();
    $arrObjParticipanteDTO = $objParticipanteRN->listarRN0189($objParticipanteDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjParticipanteDTO, 'IdParticipante','NomeContato');
  }	
  
}
?>