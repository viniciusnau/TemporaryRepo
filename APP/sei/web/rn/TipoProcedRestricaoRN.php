<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/07/2016 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.38.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoProcedRestricaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdTipoProcedimento(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedRestricaoDTO->getNumIdTipoProcedimento())){
      $objInfraException->adicionarValidacao('Tipo de Processo n�o informado.');
    }
  }

  private function validarNumIdOrgao(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedRestricaoDTO->getNumIdOrgao())){
      $objInfraException->adicionarValidacao('�rg�o n�o informado.');
    }
  }

  private function validarNumIdUnidade(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedRestricaoDTO->getNumIdUnidade())){
      $objTipoProcedRestricaoDTO->setNumIdUnidade(null);
    }
  }

  protected function cadastrarControlado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_cadastrar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdTipoProcedimento($objTipoProcedRestricaoDTO, $objInfraException);
      $this->validarNumIdOrgao($objTipoProcedRestricaoDTO, $objInfraException);
      $this->validarNumIdUnidade($objTipoProcedRestricaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedRestricaoBD->cadastrar($objTipoProcedRestricaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function alterarControlado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_alterar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objTipoProcedRestricaoDTO->isSetNumIdTipoProcedimento()){
        $this->validarNumIdTipoProcedimento($objTipoProcedRestricaoDTO, $objInfraException);
      }
      if ($objTipoProcedRestricaoDTO->isSetNumIdOrgao()){
        $this->validarNumIdOrgao($objTipoProcedRestricaoDTO, $objInfraException);
      }
      if ($objTipoProcedRestricaoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objTipoProcedRestricaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $objTipoProcedRestricaoBD->alterar($objTipoProcedRestricaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function excluirControlado($arrObjTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_excluir',__METHOD__,$arrObjTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoProcedRestricaoDTO);$i++){
        $objTipoProcedRestricaoBD->excluir($arrObjTipoProcedRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function consultarConectado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_consultar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedRestricaoBD->consultar($objTipoProcedRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function listarConectado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_listar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedRestricaoBD->listar($objTipoProcedRestricaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Restri��es em Tipos de Processos.',$e);
    }
  }

  protected function contarConectado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_listar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedRestricaoBD->contar($objTipoProcedRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Restri��es em Tipos de Processos.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_desativar',__METHOD__,$arrObjTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoProcedRestricaoDTO);$i++){
        $objTipoProcedRestricaoBD->desativar($arrObjTipoProcedRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function reativarControlado($arrObjTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_reativar',__METHOD__,$arrObjTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoProcedRestricaoDTO);$i++){
        $objTipoProcedRestricaoBD->reativar($arrObjTipoProcedRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Restri��o em Tipo de Processo.',$e);
    }
  }

  protected function bloquearControlado(TipoProcedRestricaoDTO $objTipoProcedRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_proced_restricao_consultar',__METHOD__,$objTipoProcedRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedRestricaoBD = new TipoProcedRestricaoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedRestricaoBD->bloquear($objTipoProcedRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Restri��o em Tipo de Processo.',$e);
    }
  }

 */
}
?>