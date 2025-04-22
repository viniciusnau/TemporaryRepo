<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 24/08/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class PesquisaPublicacaoSolrDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return null;
  }
  
  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_ARR,'NumIdOrgao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'PalavrasChave');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Resumo');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'IdUnidadeResponsavel');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'IdSerie');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'Numero');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'ProtocoloPesquisa');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'IdVeiculoPublicacao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DTA,'Geracao');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR,'StaPeriodoData');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DTA,'Inicio');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DTA,'Fim');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM,'InicioPaginacao');
  }
}
?>