<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 07/08/2009 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.27.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraParametroDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return 'infra_parametro';
    }

    public function montar()
    {
        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'Nome',
            'nome'
        );

        $this->adicionarAtributoTabela(
            InfraDTO::$PREFIXO_STR,
            'Valor',
            'valor'
        );

        $this->configurarPK('Nome', InfraDTO::$TIPO_PK_INFORMADO);
    }
}
