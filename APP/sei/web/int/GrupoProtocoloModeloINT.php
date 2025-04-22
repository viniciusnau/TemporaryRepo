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

class GrupoProtocoloModeloINT extends InfraINT {

  public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUnidade=''){
    $objGrupoProtocoloModeloDTO = new GrupoProtocoloModeloDTO();
    $objGrupoProtocoloModeloDTO->retNumIdGrupoProtocoloModelo();
    $objGrupoProtocoloModeloDTO->retStrNome();

    if ($numIdUnidade!==''){
      $objGrupoProtocoloModeloDTO->setNumIdUnidade($numIdUnidade);
    }

    $objGrupoProtocoloModeloDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objGrupoProtocoloModeloRN = new GrupoProtocoloModeloRN();
    $arrObjGrupoProtocoloModeloDTO = $objGrupoProtocoloModeloRN->listar($objGrupoProtocoloModeloDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjGrupoProtocoloModeloDTO, 'IdGrupoProtocoloModelo', 'Nome');
  }
}
?>