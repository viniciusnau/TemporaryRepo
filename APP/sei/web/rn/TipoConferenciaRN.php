<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/11/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoConferenciaRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrDescricao(TipoConferenciaDTO $objTipoConferenciaDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoConferenciaDTO->getStrDescricao())){
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    }else{
      $objTipoConferenciaDTO->setStrDescricao(trim($objTipoConferenciaDTO->getStrDescricao()));

      if (strlen($objTipoConferenciaDTO->getStrDescricao())>250){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrSinAtivo(TipoConferenciaDTO $objTipoConferenciaDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoConferenciaDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTipoConferenciaDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(TipoConferenciaDTO $objTipoConferenciaDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_cadastrar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrDescricao($objTipoConferenciaDTO, $objInfraException);
      $this->validarStrSinAtivo($objTipoConferenciaDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $ret = $objTipoConferenciaBD->cadastrar($objTipoConferenciaDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Tipo de Confer�ncia.',$e);
    }
  }

  protected function alterarControlado(TipoConferenciaDTO $objTipoConferenciaDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_alterar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objTipoConferenciaDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objTipoConferenciaDTO, $objInfraException);
      }
      if ($objTipoConferenciaDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objTipoConferenciaDTO, $objInfraException);
      }

      if ($objTipoConferenciaDTO->isSetStrDescricao()){
      
        $objTipoConferenciaDTOBanco = new TipoConferenciaDTO();
        $objTipoConferenciaDTOBanco->retStrDescricao();
        $objTipoConferenciaDTOBanco->setNumIdTipoConferencia($objTipoConferenciaDTO->getNumIdTipoConferencia());
        $objTipoConferenciaDTOBanco = $this->consultar($objTipoConferenciaDTOBanco);
      
        if ($objTipoConferenciaDTOBanco->getStrDescricao()!=$objTipoConferenciaDTO->getStrDescricao()){
      
          $objDocumentoDTO = new DocumentoDTO();
          $objDocumentoDTO->setNumIdTipoConferencia($objTipoConferenciaDTO->getNumIdTipoConferencia());
      
          $objDocumentoRN = new DocumentoRN();
          $numDocumentos = $objDocumentoRN->contarRN0007($objDocumentoDTO);
          if ($numDocumentos){
            if ($numDocumentos == 1){
              $objInfraException->adicionarValidacao('N�o � poss�vel alterar a descri��o porque existe um documento utilizando este Tipo de Confer�ncia.');
            }else{
              $objInfraException->adicionarValidacao('N�o � poss�vel alterar a descri��o porque existem '.$numDocumentos.' documentos utilizando este Tipo de Confer�ncia.');
            }
          }
        }
      }
      
      $objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $objTipoConferenciaBD->alterar($objTipoConferenciaDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Tipo de Confer�ncia.',$e);
    }
  }

  protected function excluirControlado($arrObjTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_excluir',__METHOD__,$arrObjTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoConferenciaDTO);$i++){
        $objTipoConferenciaBD->excluir($arrObjTipoConferenciaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Tipo de Confer�ncia.',$e);
    }
  }

  protected function consultarConectado(TipoConferenciaDTO $objTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_consultar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $ret = $objTipoConferenciaBD->consultar($objTipoConferenciaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Tipo de Confer�ncia.',$e);
    }
  }

  protected function listarConectado(TipoConferenciaDTO $objTipoConferenciaDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_listar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $ret = $objTipoConferenciaBD->listar($objTipoConferenciaDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Confer�ncia.',$e);
    }
  }

  protected function contarConectado(TipoConferenciaDTO $objTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_listar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $ret = $objTipoConferenciaBD->contar($objTipoConferenciaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Tipos de Confer�ncia.',$e);
    }
  }

  protected function desativarControlado($arrObjTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_desativar',__METHOD__,$arrObjTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoConferenciaDTO);$i++){
        $objTipoConferenciaBD->desativar($arrObjTipoConferenciaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Tipo de Confer�ncia.',$e);
    }
  }

  protected function reativarControlado($arrObjTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_reativar',__METHOD__,$arrObjTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTipoConferenciaDTO);$i++){
        $objTipoConferenciaBD->reativar($arrObjTipoConferenciaDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Tipo de Confer�ncia.',$e);
    }
  }

  protected function bloquearControlado(TipoConferenciaDTO $objTipoConferenciaDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_conferencia_consultar',__METHOD__,$objTipoConferenciaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoConferenciaBD = new TipoConferenciaBD($this->getObjInfraIBanco());
      $ret = $objTipoConferenciaBD->bloquear($objTipoConferenciaDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Tipo de Confer�ncia.',$e);
    }
  }


}
?>