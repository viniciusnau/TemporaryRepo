<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 04/04/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class NivelAcessoPermitidoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdTipoProcedimento(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objNivelAcessoPermitidoDTO->getNumIdTipoProcedimento())){
      $objInfraException->adicionarValidacao('Tipo de Processo n�o informado.');
    }
  }

  private function validarStrStaNivelAcesso(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objNivelAcessoPermitidoDTO->getStrStaNivelAcesso())){
      $objInfraException->adicionarValidacao('N�vel de Acesso n�o informado.');
    }else{
    	$objProtocoloRN = new ProtocoloRN();
      if (!in_array($objNivelAcessoPermitidoDTO->getStrStaNivelAcesso(),InfraArray::converterArrInfraDTO($objProtocoloRN->listarNiveisAcessoRN0878(),'StaNivel'))){
        $objInfraException->adicionarValidacao('N�vel de Acesso inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_cadastrar',__METHOD__,$objNivelAcessoPermitidoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdTipoProcedimento($objNivelAcessoPermitidoDTO, $objInfraException);
      $this->validarStrStaNivelAcesso($objNivelAcessoPermitidoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $ret = $objNivelAcessoPermitidoBD->cadastrar($objNivelAcessoPermitidoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando N�vel de Acesso Permitido.',$e);
    }
  }

  protected function alterarControlado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_alterar',__METHOD__,$objNivelAcessoPermitidoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objNivelAcessoPermitidoDTO->isSetNumIdTipoProcedimento()){
        $this->validarNumIdTipoProcedimento($objNivelAcessoPermitidoDTO, $objInfraException);
      }
      if ($objNivelAcessoPermitidoDTO->isSetStrStaNivelAcesso()){
        $this->validarStrStaNivelAcesso($objNivelAcessoPermitidoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $objNivelAcessoPermitidoBD->alterar($objNivelAcessoPermitidoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando N�vel de Acesso Permitido.',$e);
    }
  }

  protected function excluirControlado($arrObjNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_excluir',__METHOD__,$arrObjNivelAcessoPermitidoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjNivelAcessoPermitidoDTO);$i++){
        $objNivelAcessoPermitidoBD->excluir($arrObjNivelAcessoPermitidoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo N�vel de Acesso Permitido.',$e);
    }
  }

  protected function consultarConectado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_consultar',__METHOD__,$objNivelAcessoPermitidoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $ret = $objNivelAcessoPermitidoBD->consultar($objNivelAcessoPermitidoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando N�vel de Acesso Permitido.',$e);
    }
  }

  protected function listarConectado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_listar',__METHOD__,$objNivelAcessoPermitidoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $ret = $objNivelAcessoPermitidoBD->listar($objNivelAcessoPermitidoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando N�veis de Acesso Permitidos.',$e);
    }
  }

  protected function contarConectado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_listar',__METHOD__,$objNivelAcessoPermitidoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $ret = $objNivelAcessoPermitidoBD->contar($objNivelAcessoPermitidoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando N�veis de Acesso Permitidos.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjNivelAcessoPermitidoDTO);$i++){
        $objNivelAcessoPermitidoBD->desativar($arrObjNivelAcessoPermitidoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando N�vel de Acesso Permitido.',$e);
    }
  }

  protected function reativarControlado($arrObjNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjNivelAcessoPermitidoDTO);$i++){
        $objNivelAcessoPermitidoBD->reativar($arrObjNivelAcessoPermitidoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando N�vel de Acesso Permitido.',$e);
    }
  }

  protected function bloquearControlado(NivelAcessoPermitidoDTO $objNivelAcessoPermitidoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('nivel_acesso_permitido_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objNivelAcessoPermitidoBD = new NivelAcessoPermitidoBD($this->getObjInfraIBanco());
      $ret = $objNivelAcessoPermitidoBD->bloquear($objNivelAcessoPermitidoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando N�vel de Acesso Permitido.',$e);
    }
  }

 */
}
?>