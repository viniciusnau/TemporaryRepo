<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 04/11/2011 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.32.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraRegraAuditoriaDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return 'infra_regra_auditoria';
    }

    public function montar()
    {
        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_NUM,
            'IdInfraRegraAuditoria',
            'id_infra_regra_auditoria'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'Descricao',
            'descricao'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'SinAtivo',
            'sin_ativo'
        );

        $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR, 'ObjInfraRegraAuditoriaRecursoDTO');

        $this->configurarPK('IdInfraRegraAuditoria', InfraDTO::$TIPO_PK_INFORMADO);

        $this->configurarExclusaoLogica('SinAtivo', 'N');
    }
}
