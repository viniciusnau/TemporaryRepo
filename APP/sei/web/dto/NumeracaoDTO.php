<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 27/09/2012 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class NumeracaoDTO extends InfraDTO {

  private $numTipoFkOrgao = null;
  private $numTipoFkUnidade = null;

  public function __construct(){
    $this->numTipoFkOrgao = InfraDTO::$TIPO_FK_OPCIONAL;
    $this->numTipoFkUnidade = InfraDTO::$TIPO_FK_OPCIONAL;
    parent::__construct();
  }

  public function getStrNomeTabela() {
  	 return 'numeracao';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdNumeracao',
                                   'id_numeracao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Sequencial',
                                   'sequencial');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Ano',
                                   'ano');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdSerie',
                                   'id_serie');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdOrgao',
                                   'id_orgao');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdUnidade',
                                   'id_unidade');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'NomeSerie',
                                              'nome',
                                              'serie');
    
    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'StaNumeracaoSerie',
                                              'sta_numeracao',
                                              'serie');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaOrgao',
                                              'sigla',
                                              'orgao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'DescricaoOrgao',
                                              'descricao',
                                              'orgao');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'SiglaUnidade',
                                              'sigla',
                                              'unidade');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
                                              'DescricaoUnidade',
                                              'descricao',
                                              'unidade');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_NUM,
                                              'IdOrgaoUnidade',
                                              'id_orgao',
                                              'unidade');

    $this->configurarPK('IdNumeracao',InfraDTO::$TIPO_PK_NATIVA);

    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'SequencialOriginal');
    
    $this->configurarFK('IdSerie', 'serie', 'id_serie');
    $this->configurarFK('IdOrgao', 'orgao', 'id_orgao', $this->getNumTipoFkOrgao());
    $this->configurarFK('IdUnidade', 'unidade', 'id_unidade', $this->getNumTipoFkUnidade());

  }

  public function getNumTipoFkOrgao(){
    return $this->numTipoFkOrgao;
  }

  public function setNumTipoFkOrgao($numTipoFkOrgao){
    $this->numTipoFkOrgao = $numTipoFkOrgao;
  }

  public function getNumTipoFkUnidade(){
    return $this->numTipoFkUnidade;
  }

  public function setNumTipoFkUnidade($numTipoFkUnidade){
    $this->numTipoFkUnidade = $numTipoFkUnidade;
  }

}
?>