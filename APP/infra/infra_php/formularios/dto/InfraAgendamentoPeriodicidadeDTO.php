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

//require_once 'Infra.php';

class InfraAgendamentoPeriodicidadeDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return null;
    }

    public function montar()
    {
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaPeriodicidadeExecucao');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
    }
}
