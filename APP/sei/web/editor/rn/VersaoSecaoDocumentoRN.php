<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/12/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: VersaoSecaoDocumentoRN.php 7876 2013-08-20 14:59:25Z bcu $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class VersaoSecaoDocumentoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdSecaoDocumento(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getNumIdSecaoDocumento())){
      $objInfraException->adicionarValidacao('Se��o do Documento n�o informada.');
    }
  }

  private function validarNumIdUsuario(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarNumIdUnidade(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarDthAtualizacao(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getDthAtualizacao())){
      $objInfraException->adicionarValidacao('Data/hora de atualiza��o n�o informada.');
    }else{
      if (!InfraData::validarData($objVersaoSecaoDocumentoDTO->getDthAtualizacao())){
        $objInfraException->adicionarValidacao('Data/hora de atualiza��o inv�lida.');
      }      
    }
  }
  
  private function validarStrConteudo(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if ($objVersaoSecaoDocumentoDTO->getStrConteudo()==''){
      $objVersaoSecaoDocumentoDTO->setStrConteudo(null);
    }
  }

  private function validarNumVersao(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getNumVersao())){
       $objInfraException->adicionarValidacao('Vers�o da Se��o do Documento n�o informada.');
    }
  }

  
  private function validarStrSinUltima(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVersaoSecaoDocumentoDTO->getStrSinUltima())){
      $objInfraException->adicionarValidacao('Sinalizador de �ltima vers�o n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objVersaoSecaoDocumentoDTO->getStrSinUltima())){
        $objInfraException->adicionarValidacao('Sinalizador de �ltima vers�o inv�lido.');
      }
    }
  }
  
  protected function cadastrarControlado(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_cadastrar',__METHOD__,$objVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdSecaoDocumento($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarNumVersao($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarStrConteudo($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarNumVersao($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarNumIdUsuario($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarNumIdUnidade($objVersaoSecaoDocumentoDTO, $objInfraException);
      $this->validarDthAtualizacao($objVersaoSecaoDocumentoDTO, $objInfraException);
      

      $dto = new VersaoSecaoDocumentoDTO;
      $dto->retStrSiglaUsuario();
      $dto->retStrSiglaOrgaoUsuario();
      $dto->retDthAtualizacao();
      $dto->setNumIdSecaoDocumento($objVersaoSecaoDocumentoDTO->getNumIdSecaoDocumento());
      $dto->setNumVersao($objVersaoSecaoDocumentoDTO->getNumVersao(),InfraDTO::$OPER_MAIOR);
      $dto->setOrdNumVersao(InfraDTO::$TIPO_ORDENACAO_DESC);
      $dto->setNumMaxRegistrosRetorno(1);
      
      $arr = $this->listar($dto);
      
      if (count($arr)){
        $objInfraException->lancarValidacao('Encontrada nova vers�o do documento atualizada por '.$arr[0]->getStrSiglaUsuario().'/'.$arr[0]->getStrSiglaOrgaoUsuario().' em '.$arr[0]->getDthAtualizacao().'.');
      }
      
      $dto = new VersaoSecaoDocumentoDTO;
      $dto->retDblIdVersaoSecaoDocumento();
      $dto->setNumIdSecaoDocumento($objVersaoSecaoDocumentoDTO->getNumIdSecaoDocumento());
      $dto->setStrSinUltima('S');
      $dto->setNumMaxRegistrosRetorno(1);
      
      if ($this->consultar($dto) != null){
        throw new InfraException('Encontrado outro registro de �ltima vers�o para a se��o.');
      }
      
      $objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoDTO->setStrSinUltima('S');

      $objVersaoSecaoDocumentoDTO->setStrConteudo(EditorRN::converterHTML($objVersaoSecaoDocumentoDTO->getStrConteudo()));
      
      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $ret = $objVersaoSecaoDocumentoBD->cadastrar($objVersaoSecaoDocumentoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando vers�o da se��o.',$e);
    }
  }
  
  protected function anularControlado(VersaoSecaoDocumentoDTO $parObjVersaoSecaoDocumentoDTO){
    try{
      
      $objVersaoSecaoDocumentoDTO = new VersaoSecaoDocumentoDTO();
      $objVersaoSecaoDocumentoDTO->setStrSinUltima('N');
      $objVersaoSecaoDocumentoDTO->setDblIdVersaoSecaoDocumento($parObjVersaoSecaoDocumentoDTO->getDblIdVersaoSecaoDocumento());
      
      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $objVersaoSecaoDocumentoBD->alterar($objVersaoSecaoDocumentoDTO);
      
    }catch(Exception $e){
      throw new InfraException('Erro anulando vers�o da se��o.',$e);
    }
  }
  
  protected function excluirControlado($arrObjVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_excluir',__METHOD__,$arrObjVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVersaoSecaoDocumentoDTO);$i++){
        $objVersaoSecaoDocumentoBD->excluir($arrObjVersaoSecaoDocumentoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Vers�o.',$e);
    }
  }

  protected function consultarConectado(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_consultar',__METHOD__,$objVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $ret = $objVersaoSecaoDocumentoBD->consultar($objVersaoSecaoDocumentoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Vers�o.',$e);
    }
  }

  protected function listarConectado(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_listar',__METHOD__,$objVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $ret = $objVersaoSecaoDocumentoBD->listar($objVersaoSecaoDocumentoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Vers�es.',$e);
    }
  }

  protected function contarConectado(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_listar',__METHOD__,$objVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $ret = $objVersaoSecaoDocumentoBD->contar($objVersaoSecaoDocumentoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Vers�es.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVersaoSecaoDocumentoDTO);$i++){
        $objVersaoSecaoDocumentoBD->desativar($arrObjVersaoSecaoDocumentoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Vers�o.',$e);
    }
  }

  protected function reativarControlado($arrObjVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVersaoSecaoDocumentoDTO);$i++){
        $objVersaoSecaoDocumentoBD->reativar($arrObjVersaoSecaoDocumentoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Vers�o.',$e);
    }
  }
  */
  protected function bloquearControlado(VersaoSecaoDocumentoDTO $objVersaoSecaoDocumentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('versao_secao_documento_consultar',__METHOD__,$objVersaoSecaoDocumentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVersaoSecaoDocumentoBD = new VersaoSecaoDocumentoBD($this->getObjInfraIBanco());
      $ret = $objVersaoSecaoDocumentoBD->bloquear($objVersaoSecaoDocumentoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Vers�o.',$e);
    }
  }
}
?>