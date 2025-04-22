<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 12/06/2014 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.33.1
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../Sip.php';

class ServidorAutenticacaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return 'servidor_autenticacao';
  }

  public function montar() {
    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'IdServidorAutenticacao', 'id_servidor_autenticacao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Nome', 'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'StaTipo', 'sta_tipo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Endereco', 'endereco');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'Porta', 'porta');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'Sufixo', 'sufixo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'UsuarioPesquisa', 'usuario_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'SenhaPesquisa', 'senha_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'ContextoPesquisa', 'contexto_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'AtributoFiltroPesquisa', 'atributo_filtro_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR, 'AtributoRetornoPesquisa', 'atributo_retorno_pesquisa');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM, 'Versao', 'versao');

    $this->configurarPK('IdServidorAutenticacao', InfraDTO::$TIPO_PK_SEQUENCIAL);
  }
}

?>