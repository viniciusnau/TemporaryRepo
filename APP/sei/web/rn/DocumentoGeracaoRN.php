<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/12/2021 - criado por mgb29
*
* Vers�o do Gerador de C�digo: 1.43.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class DocumentoGeracaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarDblIdDocumento(DocumentoGeracaoDTO $objDocumentoGeracaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objDocumentoGeracaoDTO->getDblIdDocumento())){
      $objInfraException->adicionarValidacao('Documento n�o informado.');
    }
  }

  private function validarNumIdTextoPadraoInterno(DocumentoGeracaoDTO $objDocumentoGeracaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objDocumentoGeracaoDTO->getNumIdTextoPadraoInterno())){
      $objDocumentoGeracaoDTO->setNumIdTextoPadraoInterno(null);
    }
  }

  private function validarDblIdDocumentoModelo(DocumentoGeracaoDTO $objDocumentoGeracaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objDocumentoGeracaoDTO->getDblIdDocumentoModelo())){
      $objDocumentoGeracaoDTO->setDblIdDocumentoModelo(null);
    }
  }

  protected function registrarTextoPadraoControlado(DocumentoGeracaoDTO $parObjDocumentoGeracaoDTO) {
    try{

      $objDocumentoGeracaoDTO = new DocumentoGeracaoDTO();
      $objDocumentoGeracaoDTO->setDblIdDocumento($parObjDocumentoGeracaoDTO->getDblIdDocumento());

      $objDocumentoGeracaoDTO = $this->consultar($objDocumentoGeracaoDTO);

      if ($objDocumentoGeracaoDTO==null){
        $objDocumentoGeracaoDTO = new DocumentoGeracaoDTO();
        $objDocumentoGeracaoDTO->setDblIdDocumentoModelo(null);
        $objDocumentoGeracaoDTO->setNumIdTextoPadraoInterno($parObjDocumentoGeracaoDTO->getNumIdTextoPadraoInterno());
        $objDocumentoGeracaoDTO->setDblIdDocumento($parObjDocumentoGeracaoDTO->getDblIdDocumento());
        $this->cadastrar($objDocumentoGeracaoDTO);
      }else{
        $objDocumentoGeracaoDTO = new DocumentoGeracaoDTO();
        $objDocumentoGeracaoDTO->setNumIdTextoPadraoInterno($parObjDocumentoGeracaoDTO->getNumIdTextoPadraoInterno());
        $objDocumentoGeracaoDTO->setDblIdDocumento($parObjDocumentoGeracaoDTO->getDblIdDocumento());
        $this->alterar($objDocumentoGeracaoDTO);
      }

    }catch(Exception $e){
      throw new InfraException('Erro registrando texto padr�o utilizado no editor.',$e);
    }
  }

  protected function cadastrarControlado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_cadastrar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarDblIdDocumento($objDocumentoGeracaoDTO, $objInfraException);
      $this->validarNumIdTextoPadraoInterno($objDocumentoGeracaoDTO, $objInfraException);
      $this->validarDblIdDocumentoModelo($objDocumentoGeracaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $ret = $objDocumentoGeracaoBD->cadastrar($objDocumentoGeracaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Op��o de Gera��o.',$e);
    }
  }

  protected function alterarControlado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_alterar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objDocumentoGeracaoDTO->isSetDblIdDocumento()){
        $this->validarDblIdDocumento($objDocumentoGeracaoDTO, $objInfraException);
      }
      if ($objDocumentoGeracaoDTO->isSetNumIdTextoPadraoInterno()){
        $this->validarNumIdTextoPadraoInterno($objDocumentoGeracaoDTO, $objInfraException);
      }
      if ($objDocumentoGeracaoDTO->isSetDblIdDocumentoModelo()){
        $this->validarDblIdDocumentoModelo($objDocumentoGeracaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $objDocumentoGeracaoBD->alterar($objDocumentoGeracaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando Op��o de Gera��o.',$e);
    }
  }

  protected function excluirControlado($arrObjDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_excluir', __METHOD__, $arrObjDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjDocumentoGeracaoDTO);$i++){
        $objDocumentoGeracaoBD->excluir($arrObjDocumentoGeracaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Op��o de Gera��o.',$e);
    }
  }

  protected function consultarConectado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_consultar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $ret = $objDocumentoGeracaoBD->consultar($objDocumentoGeracaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Op��o de Gera��o.',$e);
    }
  }

  protected function listarConectado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_listar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $ret = $objDocumentoGeracaoBD->listar($objDocumentoGeracaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Op��es de Gera��o.',$e);
    }
  }

  protected function contarConectado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_listar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $ret = $objDocumentoGeracaoBD->contar($objDocumentoGeracaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Op��es de Gera��o.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_desativar', __METHOD__, $arrObjDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjDocumentoGeracaoDTO);$i++){
        $objDocumentoGeracaoBD->desativar($arrObjDocumentoGeracaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Op��o de Gera��o.',$e);
    }
  }

  protected function reativarControlado($arrObjDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_reativar', __METHOD__, $arrObjDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjDocumentoGeracaoDTO);$i++){
        $objDocumentoGeracaoBD->reativar($arrObjDocumentoGeracaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Op��o de Gera��o.',$e);
    }
  }

  protected function bloquearControlado(DocumentoGeracaoDTO $objDocumentoGeracaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_geracao_consultar', __METHOD__, $objDocumentoGeracaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDocumentoGeracaoBD = new DocumentoGeracaoBD($this->getObjInfraIBanco());
      $ret = $objDocumentoGeracaoBD->bloquear($objDocumentoGeracaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Op��o de Gera��o.',$e);
    }
  }

 */
}
