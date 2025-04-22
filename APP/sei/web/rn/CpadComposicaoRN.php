<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/11/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class CpadComposicaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdCpadVersao(CpadComposicaoDTO $objCpadComposicaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objCpadComposicaoDTO->getNumIdCpadVersao())){
      $objInfraException->adicionarValidacao('Vers�o n�o informada.');
    }
  }

  private function validarNumIdUsuario(CpadComposicaoDTO $objCpadComposicaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objCpadComposicaoDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarNumIdCargo(CpadComposicaoDTO $objCpadComposicaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objCpadComposicaoDTO->getNumIdCargo())){
      $objInfraException->adicionarValidacao('Cargo n�o informado.');
    }
  }

  private function validarStrSinPresidente(CpadComposicaoDTO $objCpadComposicaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objCpadComposicaoDTO->getStrSinPresidente())){
      $objInfraException->adicionarValidacao('Sinalizador de Presidente n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objCpadComposicaoDTO->getStrSinPresidente())){
        $objInfraException->adicionarValidacao('Sinalizador de Presidente inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(CpadComposicaoDTO $objCpadComposicaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_cadastrar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdCpadVersao($objCpadComposicaoDTO, $objInfraException);
      $this->validarNumIdUsuario($objCpadComposicaoDTO, $objInfraException);
      $this->validarNumIdCargo($objCpadComposicaoDTO, $objInfraException);
      $this->validarStrSinPresidente($objCpadComposicaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $ret = $objCpadComposicaoBD->cadastrar($objCpadComposicaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function alterarControlado(CpadComposicaoDTO $objCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_alterar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objCpadComposicaoDTO->isSetNumIdCpadVersao()){
        $this->validarNumIdCpadVersao($objCpadComposicaoDTO, $objInfraException);
      }
      if ($objCpadComposicaoDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuario($objCpadComposicaoDTO, $objInfraException);
      }
      if ($objCpadComposicaoDTO->isSetNumIdCargo()){
        $this->validarNumIdCargo($objCpadComposicaoDTO, $objInfraException);
      }
      if ($objCpadComposicaoDTO->isSetStrSinPresidente()){
        $this->validarStrSinPresidente($objCpadComposicaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $objCpadComposicaoBD->alterar($objCpadComposicaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function excluirControlado($arrObjCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_excluir',__METHOD__,$arrObjCpadComposicaoDTO);

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjCpadComposicaoDTO);$i++){
        $objCpadComposicaoBD->excluir($arrObjCpadComposicaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function consultarConectado(CpadComposicaoDTO $objCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_consultar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $ret = $objCpadComposicaoBD->consultar($objCpadComposicaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function listarConectado(CpadComposicaoDTO $objCpadComposicaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_listar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $ret = $objCpadComposicaoBD->listar($objCpadComposicaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Composi��es da Comiss�es Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function contarConectado(CpadComposicaoDTO $objCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_listar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $ret = $objCpadComposicaoBD->contar($objCpadComposicaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Composi��es da Comiss�es Permanente de Avalia��o de Documentos.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_desativar',__METHOD__,$arrObjCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjCpadComposicaoDTO);$i++){
        $objCpadComposicaoBD->desativar($arrObjCpadComposicaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function reativarControlado($arrObjCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_reativar',__METHOD__,$arrObjCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjCpadComposicaoDTO);$i++){
        $objCpadComposicaoBD->reativar($arrObjCpadComposicaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

  protected function bloquearControlado(CpadComposicaoDTO $objCpadComposicaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('cpad_composicao_consultar',__METHOD__,$objCpadComposicaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCpadComposicaoBD = new CpadComposicaoBD($this->getObjInfraIBanco());
      $ret = $objCpadComposicaoBD->bloquear($objCpadComposicaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Composi��o da Comiss�o Permanente de Avalia��o de Documentos.',$e);
    }
  }

 */
}
