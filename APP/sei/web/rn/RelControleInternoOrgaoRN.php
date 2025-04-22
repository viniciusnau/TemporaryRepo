<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 14/01/2011 - criado por jonatas_db
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelControleInternoOrgaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdControleInterno(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelControleInternoOrgaoDTO->getNumIdControleInterno())){
      $objInfraException->adicionarValidacao('Controle Interno n�o informado.');
    }
  }

  private function validarNumIdOrgao(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelControleInternoOrgaoDTO->getNumIdOrgao())){
      $objInfraException->adicionarValidacao('Numero do Org�o n�o informado.');
    }
  }

  protected function cadastrarControlado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_cadastrar',__METHOD__,$objRelControleInternoOrgaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdControleInterno($objRelControleInternoOrgaoDTO, $objInfraException);
      $this->validarNumIdOrgao($objRelControleInternoOrgaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $ret = $objRelControleInternoOrgaoBD->cadastrar($objRelControleInternoOrgaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Org�o de Controle Interno.',$e);
    }
  }

  protected function alterarControlado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_alterar',__METHOD__,$objRelControleInternoOrgaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelControleInternoOrgaoDTO->isSetNumIdControleInterno()){
        $this->validarNumIdControleInterno($objRelControleInternoOrgaoDTO, $objInfraException);
      }
      if ($objRelControleInternoOrgaoDTO->isSetNumIdOrgao()){
        $this->validarNumIdOrgao($objRelControleInternoOrgaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $objRelControleInternoOrgaoBD->alterar($objRelControleInternoOrgaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Org�o de Controle Interno.',$e);
    }
  }

  protected function excluirControlado($arrObjRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_excluir',__METHOD__,$arrObjRelControleInternoOrgaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelControleInternoOrgaoDTO);$i++){
        $objRelControleInternoOrgaoBD->excluir($arrObjRelControleInternoOrgaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Org�o de Controle Interno.',$e);
    }
  }

  protected function consultarConectado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_consultar',__METHOD__,$objRelControleInternoOrgaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $ret = $objRelControleInternoOrgaoBD->consultar($objRelControleInternoOrgaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Org�o de Controle Interno.',$e);
    }
  }

  protected function listarConectado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_listar',__METHOD__,$objRelControleInternoOrgaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $ret = $objRelControleInternoOrgaoBD->listar($objRelControleInternoOrgaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Org�os de Controles Internos.',$e);
    }
  }

  protected function contarConectado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_listar',__METHOD__,$objRelControleInternoOrgaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $ret = $objRelControleInternoOrgaoBD->contar($objRelControleInternoOrgaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Org�os de Controles Internos.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelControleInternoOrgaoDTO);$i++){
        $objRelControleInternoOrgaoBD->desativar($arrObjRelControleInternoOrgaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Org�o de Controle Interno.',$e);
    }
  }

  protected function reativarControlado($arrObjRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelControleInternoOrgaoDTO);$i++){
        $objRelControleInternoOrgaoBD->reativar($arrObjRelControleInternoOrgaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Org�o de Controle Interno.',$e);
    }
  }

  protected function bloquearControlado(RelControleInternoOrgaoDTO $objRelControleInternoOrgaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_controle_interno_orgao_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelControleInternoOrgaoBD = new RelControleInternoOrgaoBD($this->getObjInfraIBanco());
      $ret = $objRelControleInternoOrgaoBD->bloquear($objRelControleInternoOrgaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Org�o de Controle Interno.',$e);
    }
  }

 */
}
?>