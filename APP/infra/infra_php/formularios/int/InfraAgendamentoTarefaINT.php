<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 15/12/2011 - criado por tamir_db
 *
 * Vers�o do Gerador de C�digo: 1.32.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once dirname(__FILE__).'/../Infra.php';

class InfraAgendamentoTarefaINT extends InfraINT
{

    public static function montarSelectIdInfraAgendamentoTarefa(
        $strPrimeiroItemValor,
        $strPrimeiroItemDescricao,
        $strValorItemSelecionado
    ) {
        $objInfraAgendamentoTarefaDTO = new InfraAgendamentoTarefaDTO();
        $objInfraAgendamentoTarefaDTO->retNumIdInfraAgendamentoTarefa();
        $objInfraAgendamentoTarefaDTO->retNumIdInfraAgendamentoTarefa();

        if ($strValorItemSelecionado != null) {
            $objInfraAgendamentoTarefaDTO->setBolExclusaoLogica(false);
            $objInfraAgendamentoTarefaDTO->adicionarCriterio(array('SinAtivo', 'IdInfraAgendamentoTarefa'),
                array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
                array('S', $strValorItemSelecionado),
                InfraDTO::$OPER_LOGICO_OR);
        }

        $objInfraAgendamentoTarefaDTO->setOrdNumIdInfraAgendamentoTarefa(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objInfraAgendamentoTarefaRN = new InfraAgendamentoTarefaRN();
        $arrObjInfraAgendamentoTarefaDTO = $objInfraAgendamentoTarefaRN->listar($objInfraAgendamentoTarefaDTO);

        return parent::montarSelectArrInfraDTO(
            $strPrimeiroItemValor,
            $strPrimeiroItemDescricao,
            $strValorItemSelecionado,
            $arrObjInfraAgendamentoTarefaDTO,
            'IdInfraAgendamentoTarefa',
            'IdInfraAgendamentoTarefa'
        );
    }

    public static function montarSelectStaPeriodicidadeExecucao(
        $strPrimeiroItemValor,
        $strPrimeiroItemDescricao,
        $strValorItemSelecionado
    ) {
        $objInfraAgendamentoTarefaRN = new InfraAgendamentoTarefaRN();

        $arrObjInfraAgendamentoPeriodicidadeDTO = $objInfraAgendamentoTarefaRN->listarValoresPeriodicidadeExecucao();

        return parent::montarSelectArrInfraDTO(
            $strPrimeiroItemValor,
            $strPrimeiroItemDescricao,
            $strValorItemSelecionado,
            $arrObjInfraAgendamentoPeriodicidadeDTO,
            'StaPeriodicidadeExecucao',
            'Descricao'
        );
    }
}
