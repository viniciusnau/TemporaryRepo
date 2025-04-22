<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 11/07/2018 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.41.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class UsuarioHistoricoINT extends InfraINT {

  public static function montarSelectOperacao(
    $strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $numIdUsuario = '', $strIdCodigoAcesso = '', $numIdUsuarioOperacao = '') {
    $objUsuarioHistoricoDTO = new UsuarioHistoricoDTO();
    $objUsuarioHistoricoDTO->retNumIdUsuarioHistorico();
    $objUsuarioHistoricoDTO->retDthOperacao();

    if ($numIdUsuario !== '') {
      $objUsuarioHistoricoDTO->setNumIdUsuario($numIdUsuario);
    }

    if ($strIdCodigoAcesso !== '') {
      $objUsuarioHistoricoDTO->setStrIdCodigoAcesso($strIdCodigoAcesso);
    }

    if ($numIdUsuarioOperacao !== '') {
      $objUsuarioHistoricoDTO->setNumIdUsuarioOperacao($numIdUsuarioOperacao);
    }

    $objUsuarioHistoricoDTO->setOrdDthOperacao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objUsuarioHistoricoRN = new UsuarioHistoricoRN();
    $arrObjUsuarioHistoricoDTO = $objUsuarioHistoricoRN->listar($objUsuarioHistoricoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjUsuarioHistoricoDTO, 'IdUsuarioHistorico', 'Operacao');
  }

  public static function montarSelectStaOperacao(
    $strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado) {
    $objUsuarioHistoricoRN = new UsuarioHistoricoRN();

    $arrObjOperacaoUsuarioHistoricoDTO = $objUsuarioHistoricoRN->listarValoresOperacao();

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjOperacaoUsuarioHistoricoDTO, 'StaOperacao', 'Descricao');
  }
}
