<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 20/05/2019 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class TarefaInstalacaoINT extends InfraINT {

  public static function montarSelectIdTarefaInstalacao($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado){
    $objTarefaInstalacaoDTO = new TarefaInstalacaoDTO();
    $objTarefaInstalacaoDTO->retNumIdTarefaInstalacao();
    $objTarefaInstalacaoDTO->retNumIdTarefaInstalacao();

    $objTarefaInstalacaoDTO->setOrdNumIdTarefaInstalacao(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objTarefaInstalacaoRN = new TarefaInstalacaoRN();
    $arrObjTarefaInstalacaoDTO = $objTarefaInstalacaoRN->listar($objTarefaInstalacaoDTO);

    return parent::montarSelectArrInfraDTO($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado, $arrObjTarefaInstalacaoDTO, 'IdTarefaInstalacao', 'IdTarefaInstalacao');
  }
}
