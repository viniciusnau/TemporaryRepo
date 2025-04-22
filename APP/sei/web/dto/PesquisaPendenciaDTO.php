<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 20/12/2007 - criado por marcio_db
 * 15/06/2018 - cjy - �cone de acompanhamento no controle de processos
 *
 * Vers�o do Gerador de C�digo: 1.12.0
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../SEI.php';

class PesquisaPendenciaDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return null;
    }

    public function montar()
    {
        $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdProtocolo');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuario');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUnidade');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinInicial');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinNaoVisualizados');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinAlterados');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinReaberturasProgramadas');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinAcessoFederacao');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinSigilosos');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinCredenciaisAssinatura');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinPrioritarios');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaEstadoProcedimento');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaTipoAtribuicao');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdUsuarioAtribuicao');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdMarcador');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdTipoProcedimento');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdTipoPrioridade');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdAcompanhamento');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaTipoControlePrazo');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaTipoRetornoProgramado');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinMontandoArvore');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinSinalizacoes');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinAnotacoes');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinObservacoes');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinSituacoes');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinMarcadores');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinInteressados');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinRetornoProgramado');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinCredenciais');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinAcompanhamentos');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinControlePrazo');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinReaberturaProgramada');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinLinhaDireta');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinFederacao');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinHoje');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdDocumento');

        //ordenacao
        $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'Processos');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Nome');

        $this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'AtividadeDTOOrdenacao');
    }
}

?>