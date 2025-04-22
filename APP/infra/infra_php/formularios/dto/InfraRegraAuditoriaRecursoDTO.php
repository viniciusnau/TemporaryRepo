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

class InfraRegraAuditoriaRecursoDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return 'infra_regra_auditoria_recurso';
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
            'Recurso',
            'recurso'
        );


        $this->adicionarAtributoTabelaRelacionada(
            InfraDTO::$PREFIXO_STR,
            'SinAtivoInfraRegraAuditoria',
            'sin_ativo',
            'infra_regra_auditoria'
        );

        $this->configurarPK('IdInfraRegraAuditoria', InfraDTO::$TIPO_PK_INFORMADO);
        $this->configurarPK('Recurso', InfraDTO::$TIPO_PK_INFORMADO);

        $this->configurarFK('IdInfraRegraAuditoria', 'infra_regra_auditoria', 'id_infra_regra_auditoria');
    }
}
