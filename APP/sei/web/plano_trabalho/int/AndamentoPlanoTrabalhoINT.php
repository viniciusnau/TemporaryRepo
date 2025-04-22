<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 27/09/2022 - criado por mgb29
 *
 * Vers�o do Gerador de C�digo: 1.43.1
 */

require_once dirname(__FILE__) . '/../../SEI.php';

class AndamentoPlanoTrabalhoINT extends InfraINT {

  public static function montarSelectStaSituacao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado) {
    $objAndamentoPlanoTrabalhoRN = new AndamentoPlanoTrabalhoRN();

    $arrObjSituacaoAndamentoPlanoTrabalhoDTO = $objAndamentoPlanoTrabalhoRN->listarValoresSituacao();

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjSituacaoAndamentoPlanoTrabalhoDTO, 'StaSituacao', 'Descricao');
  }

}
