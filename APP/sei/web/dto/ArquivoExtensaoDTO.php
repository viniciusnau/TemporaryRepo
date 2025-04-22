<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/02/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ArquivoExtensaoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'arquivo_extensao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdArquivoExtensao',
                                   'id_arquivo_extensao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Extensao',
                                   'extensao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Descricao',
                                   'descricao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'TamanhoMaximo',
                                   'tamanho_maximo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                  'SinInterface',
                                  'sin_interface');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                  'SinServico',
                                  'sin_servico');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->configurarPK('IdArquivoExtensao',InfraDTO::$TIPO_PK_NATIVA);

    $this->configurarExclusaoLogica('SinAtivo', 'N');

  }
}
?>