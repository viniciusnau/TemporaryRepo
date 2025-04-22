<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 02/08/2018 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.41.0
 */

//require_once dirname(__FILE__).'/../Infra.php';

class InfraDadoUsuarioDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return 'infra_dado_usuario';
    }

    public function montar()
    {
        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdUsuario', 'id_usuario');

        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Nome', 'nome');

        $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Valor', 'valor');

        $this->configurarPK('IdUsuario', InfraDTO::$TIPO_PK_INFORMADO);
        $this->configurarPK('Nome', InfraDTO::$TIPO_PK_INFORMADO);
    }
}
