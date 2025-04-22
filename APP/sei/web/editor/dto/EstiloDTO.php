<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/11/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: EstiloDTO.php 7875 2013-08-20 14:59:02Z bcu $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class EstiloDTO extends InfraDTO {
 
  private $numTipoPK = null;
  
  public function __construct(){
    parent::__construct();
    $this->numTipoPK = InfraDTO::$TIPO_PK_NATIVA;
  }

  public function setNumTipoPK($numTipoPK){
    $this->numTipoPK = $numTipoPK;
  }
  
  public function getStrNomeTabela() {
  	 return 'estilo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdEstilo',
                                   'id_estilo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Nome',
                                   'nome');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'Formatacao',
                                   'formatacao');

    $this->configurarPK('IdEstilo',$this->numTipoPK);

  }
}
?>