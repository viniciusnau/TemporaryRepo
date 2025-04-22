<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/08/2012 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ProtocoloModeloINT extends InfraINT {

  public static function montarSelectDescricao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdGrupoProtocoloModelo='', $numIdUnidade='', $numIdUsuario='', $dblIdProtocolo=''){
    $objProtocoloModeloDTO = new ProtocoloModeloDTO();
    $objProtocoloModeloDTO->retDblIdProtocoloModelo();
    $objProtocoloModeloDTO->retStrDescricao();

    if ($numIdGrupoProtocoloModelo!==''){
      $objProtocoloModeloDTO->setNumIdGrupoProtocoloModelo($numIdGrupoProtocoloModelo);
    }

    if ($numIdUnidade!==''){
      $objProtocoloModeloDTO->setNumIdUnidade($numIdUnidade);
    }

    if ($numIdUsuario!==''){
      $objProtocoloModeloDTO->setNumIdUsuario($numIdUsuario);
    }

    if ($dblIdProtocolo!==''){
      $objProtocoloModeloDTO->setDblIdProtocolo($dblIdProtocolo);
    }

    $objProtocoloModeloDTO->setOrdStrDescricao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objProtocoloModeloRN = new ProtocoloModeloRN();
    $arrObjProtocoloModeloDTO = $objProtocoloModeloRN->listar($objProtocoloModeloDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjProtocoloModeloDTO, 'IdProtocoloModelo', 'Descricao');
  }
}
?>