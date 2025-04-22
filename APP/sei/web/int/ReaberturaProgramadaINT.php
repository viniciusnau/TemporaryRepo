<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 04/11/2021 - criado por mgb29
*
* Vers�o do Gerador de C�digo: 1.43.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class ReaberturaProgramadaINT extends InfraINT {

  public static function montarSelectProgramada($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $dblIdProtocolo='', $numIdUnidade='', $numIdUsuario='', $numIdAtividade=''){
    $objReaberturaProgramadaDTO = new ReaberturaProgramadaDTO();
    $objReaberturaProgramadaDTO->retNumIdReaberturaProgramada();
    $objReaberturaProgramadaDTO->retDtaProgramada();

    if ($dblIdProtocolo!==''){
      $objReaberturaProgramadaDTO->setDblIdProtocolo($dblIdProtocolo);
    }

    if ($numIdUnidade!==''){
      $objReaberturaProgramadaDTO->setNumIdUnidade($numIdUnidade);
    }

    if ($numIdUsuario!==''){
      $objReaberturaProgramadaDTO->setNumIdUsuario($numIdUsuario);
    }

    if ($numIdAtividade!==''){
      $objReaberturaProgramadaDTO->setNumIdAtividade($numIdAtividade);
    }

    $objReaberturaProgramadaDTO->setOrdDtaProgramada(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objReaberturaProgramadaRN = new ReaberturaProgramadaRN();
    $arrObjReaberturaProgramadaDTO = $objReaberturaProgramadaRN->listar($objReaberturaProgramadaDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjReaberturaProgramadaDTO, 'IdReaberturaProgramada', 'Programada');
  }
}
