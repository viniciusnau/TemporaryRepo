<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/04/2008 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.14.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelUnidadeTipoContatoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrStaAcesso(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelUnidadeTipoContatoDTO->getStrStaAcesso())){
      $objInfraException->adicionarValidacao('Tipo de acesso n�o informado.');
    }else{
      if ($objRelUnidadeTipoContatoDTO->getStrStaAcesso()!=TipoContatoRN::$TA_CONSULTA_COMPLETA &&
          $objRelUnidadeTipoContatoDTO->getStrStaAcesso()!=TipoContatoRN::$TA_ALTERACAO) {
        $objInfraException->adicionarValidacao('Tipo de acesso inv�lido.');
      }
    }
  }

  protected function cadastrarRN0545Controlado(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_cadastrar',__METHOD__,$objRelUnidadeTipoContatoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdTipoContatoRN0561($objRelUnidadeTipoContatoDTO, $objInfraException);
      $this->validarNumIdUnidadeRN0562($objRelUnidadeTipoContatoDTO, $objInfraException);
      $this->validarStrStaAcesso($objRelUnidadeTipoContatoDTO, $objInfraException);

      if ($this->contarRN0548($objRelUnidadeTipoContatoDTO)>0){
        $objInfraException->adicionarValidacao('Este tipo de contexto j� est� associado com a unidade.');
      }
      
      
      $objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      $ret = $objRelUnidadeTipoContatoBD->cadastrar($objRelUnidadeTipoContatoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando associa��o de Tipo de Contato com Unidade.',$e);
    }
  }
/*
  protected function alterarControlado(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_alterar');

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelUnidadeTipoContatoDTO->isSetNumIdTipoContato()){
        $this->validarNumIdTipoContato($objRelUnidadeTipoContatoDTO, $objInfraException);
      }
      if ($objRelUnidadeTipoContatoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objRelUnidadeTipoContatoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      $objRelUnidadeTipoContatoBD->alterar($objRelUnidadeTipoContatoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando associa��o de Tipo de Contato com Unidade.',$e);
    }
  }
*/
  protected function excluirRN0546Controlado($arrObjRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_excluir',__METHOD__,$arrObjRelUnidadeTipoContatoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelUnidadeTipoContatoDTO);$i++){
        $objRelUnidadeTipoContatoBD->excluir($arrObjRelUnidadeTipoContatoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo associa��o de Tipo de Contato com Unidade.',$e);
    }
  }

  protected function consultarConectado(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      $ret = $objRelUnidadeTipoContatoBD->consultar($objRelUnidadeTipoContatoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando associa��o de Tipo de Contato com Unidade.',$e);
    }
  }

  protected function listarRN0547Conectado(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_listar',__METHOD__,$objRelUnidadeTipoContatoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      $ret = $objRelUnidadeTipoContatoBD->listar($objRelUnidadeTipoContatoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Contexto das Unidades.',$e);
    }
  }

  protected function contarRN0548Conectado(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_listar',__METHOD__,$objRelUnidadeTipoContatoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      $ret = $objRelUnidadeTipoContatoBD->contar($objRelUnidadeTipoContatoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Tipos de Contexto das Unidades.',$e);
    }
  }

/* 
  protected function desativarControlado($arrObjRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelUnidadeTipoContatoDTO);$i++){
        $objRelUnidadeTipoContatoBD->desativar($arrObjRelUnidadeTipoContatoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando associa��o de Tipo de Contato com Unidade.',$e);
    }
  }

  protected function reativarControlado($arrObjRelUnidadeTipoContatoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_unidade_tipo_contato_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelUnidadeTipoContatoBD = new RelUnidadeTipoContatoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelUnidadeTipoContatoDTO);$i++){
        $objRelUnidadeTipoContatoBD->reativar($arrObjRelUnidadeTipoContatoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando associa��o de Tipo de Contato com Unidade.',$e);
    }
  }

 */
  private function validarNumIdTipoContatoRN0561(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelUnidadeTipoContatoDTO->getNumIdTipoContato())){
      $objInfraException->adicionarValidacao('Tipo de Contexto n�o informado na associa��o com Unidade.');
    }
  }

  private function validarNumIdUnidadeRN0562(RelUnidadeTipoContatoDTO $objRelUnidadeTipoContatoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelUnidadeTipoContatoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada na associa��o com Tipo de Contexto.');
    }
  }

}
?>