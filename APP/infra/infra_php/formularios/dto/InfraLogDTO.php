<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 02/05/2008 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.16.0
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraLogDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return 'infra_log';
    }

    public function montar()
    {
        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_NUM,
            'IdInfraLog',
            'id_infra_log'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_DTH,
            'Log',
            'dth_log'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'TextoLog',
            'texto_log'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'Ip',
            'ip'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'StaTipo',
            'sta_tipo'
        );

        $this->adicionarAtributo(InfraDTO::$PREFIXO_DTH, 'Inicial');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_DTH, 'Final');

        $this->configurarPK('IdInfraLog', InfraDTO::$TIPO_PK_INFORMADO);
    }
}
