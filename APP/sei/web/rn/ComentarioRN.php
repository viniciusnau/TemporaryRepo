<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 04/10/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class ComentarioRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarDblIdProcedimento(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getDblIdProcedimento())){
      $objInfraException->adicionarValidacao('Processo n�o informado.');
    }
  }

  private function validarDblIdRelProtocoloProtocolo(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getDblIdRelProtocoloProtocolo())){
      $objComentarioDTO->setDblIdRelProtocoloProtocolo(null);
    }
  }

  private function validarNumIdUnidade(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarNumIdUsuario(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrDescricao(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getStrDescricao())){
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    }else{
      $objComentarioDTO->setStrDescricao(trim($objComentarioDTO->getStrDescricao()));

      if (strlen($objComentarioDTO->getStrDescricao())>4000){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 4000 caracteres.');
      }
    }
  }

  private function validarDthComentario(ComentarioDTO $objComentarioDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objComentarioDTO->getDthComentario())){
      $objInfraException->adicionarValidacao('Data n�o informada.');
    }else{
      if (!InfraData::validarDataHora($objComentarioDTO->getDthComentario())){
        $objInfraException->adicionarValidacao('Data inv�lida.');
      }
    }
  }

  protected function cadastrarControlado(ComentarioDTO $objComentarioDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_cadastrar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarDblIdProcedimento($objComentarioDTO, $objInfraException);
      $this->validarDblIdRelProtocoloProtocolo($objComentarioDTO, $objInfraException);
      $this->validarNumIdUnidade($objComentarioDTO, $objInfraException);
      $this->validarNumIdUsuario($objComentarioDTO, $objInfraException);
      $this->validarStrDescricao($objComentarioDTO, $objInfraException);
      $this->validarDthComentario($objComentarioDTO, $objInfraException);

      /*
      $dto = new ComentarioDTO();
      $dto->retNumIdComentario();
      $dto->setNumIdComentario($objComentarioDTO->getNumIdComentario(),InfraDTO::$OPER_DIFERENTE);
      $dto->setDblIdProtocolo($objComentarioDTO->getDblIdProtocolo());
      $dto->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      if ($this->contar($dto) > 0){
        $objInfraException->adicionarValidacao('J� existe um Coment�rio para o processo nesta Unidade.');
      }
      */

      $objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $ret = $objComentarioBD->cadastrar($objComentarioDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Coment�rio.',$e);
    }
  }

  protected function alterarControlado(ComentarioDTO $objComentarioDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('comentario_alterar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      //Regras de Negocio

      if ($objComentarioDTO->isSetDblIdProcedimento()){
        $this->validarDblIdProcedimento($objComentarioDTO, $objInfraException);
      }
      if ($objComentarioDTO->isSetDblIdRelProtocoloProtocolo()){
        $this->validarDblIdRelProtocoloProtocolo($objComentarioDTO, $objInfraException);
      }
      if ($objComentarioDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objComentarioDTO, $objInfraException);
      }
      if ($objComentarioDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuario($objComentarioDTO, $objInfraException);
      }
      if ($objComentarioDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objComentarioDTO, $objInfraException);
      }
      if ($objComentarioDTO->isSetDthComentario()){
        $this->validarDthComentario($objComentarioDTO, $objInfraException);
      }

      $objComentarioDTO_Banco = new ComentarioDTO();
      $objComentarioDTO_Banco->retTodos();
      $objComentarioDTO_Banco->setNumIdComentario($objComentarioDTO->getNumIdComentario());
      $objComentarioDTO_Banco = $this->consultar($objComentarioDTO_Banco);

      if ($objComentarioDTO->isSetDblIdProcedimento() && $objComentarioDTO->getDblIdProcedimento()!=$objComentarioDTO_Banco->getDblIdProcedimento()){
        $objInfraException->lancarValidacao('N�o � poss�vel alterar o processo de um Coment�rio.');
      }

      if ($objComentarioDTO->isSetDblIdRelProtocoloProtocolo() && $objComentarioDTO->getDblIdRelProtocoloProtocolo()!=$objComentarioDTO_Banco->getDblIdRelProtocoloProtocolo()){
        $objInfraException->lancarValidacao('N�o � poss�vel alterar o protocolo de um Coment�rio.');
      }

      if ($objComentarioDTO_Banco->getNumIdUnidade() != SessaoSEI::getInstance()->getNumIdUnidadeAtual()) {
        $objInfraException->lancarValidacao('N�o � poss�vel alterar um Coment�rio de outra unidade.');
      }

      if ($objComentarioDTO->isSetNumIdUnidade() && $objComentarioDTO->getNumIdUnidade()!=$objComentarioDTO_Banco->getNumIdUnidade()) {
        $objInfraException->lancarValidacao('N�o � poss�vel alterar a unidade de um Coment�rio.');
      }


      $objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $objComentarioBD->alterar($objComentarioDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Coment�rio.',$e);
    }
  }

  protected function excluirControlado($arrObjComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_excluir',__METHOD__,$arrObjComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjComentarioDTO);$i++){
        $objComentarioBD->excluir($arrObjComentarioDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Coment�rio.',$e);
    }
  }

  protected function consultarConectado(ComentarioDTO $objComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_consultar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $ret = $objComentarioBD->consultar($objComentarioDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Coment�rio.',$e);
    }
  }

  protected function listarConectado(ComentarioDTO $objComentarioDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_listar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $ret = $objComentarioBD->listar($objComentarioDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Coment�rios.',$e);
    }
  }

  protected function contarConectado(ComentarioDTO $objComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_listar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $ret = $objComentarioBD->contar($objComentarioDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Coment�rios.',$e);
    }
  }

/* 
  protected function desativarControlado($arrObjComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_desativar',__METHOD__,$arrObjComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjComentarioDTO);$i++){
        $objComentarioBD->desativar($arrObjComentarioDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Coment�rio.',$e);
    }
  }

  protected function reativarControlado($arrObjComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_reativar',__METHOD__,$arrObjComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjComentarioDTO);$i++){
        $objComentarioBD->reativar($arrObjComentarioDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Coment�rio.',$e);
    }
  }

  protected function bloquearControlado(ComentarioDTO $objComentarioDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('comentario_consultar',__METHOD__,$objComentarioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioBD = new ComentarioBD($this->getObjInfraIBanco());
      $ret = $objComentarioBD->bloquear($objComentarioDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Coment�rio.',$e);
    }
  }

 */
}
