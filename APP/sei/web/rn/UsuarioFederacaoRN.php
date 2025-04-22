<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/07/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class UsuarioFederacaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrIdUsuarioFederacao(UsuarioFederacaoDTO $objUsuarioFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUsuarioFederacaoDTO->getStrIdUsuarioFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado.');
    }else {

      if (!InfraULID::validar($objUsuarioFederacaoDTO->getStrIdUsuarioFederacao())){
        $objInfraException->lancarValidacao('Identificador do SEI Federa��o '.$objUsuarioFederacaoDTO->getStrIdUsuarioFederacao().' inv�lido.');
      }

      $dto = new UsuarioFederacaoDTO();
      $dto->retStrIdUsuarioFederacao();
      $dto->setNumMaxRegistrosRetorno(1);
      $dto->setBolExclusaoLogica(false);
      $dto->setStrIdUsuarioFederacao($objUsuarioFederacaoDTO->getStrIdUsuarioFederacao());
      if ($this->consultar($dto) != null) {
        $objInfraException->adicionarValidacao('J� existe um Usu�rio cadastrado nesta instala��o com o identificador '.$objUsuarioFederacaoDTO->getStrIdUsuarioFederacao().' do SEI Federa��o.');
      }
    }
  }
  
  private function validarStrIdInstalacaoFederacao(UsuarioFederacaoDTO $objUsuarioFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUsuarioFederacaoDTO->getStrIdInstalacaoFederacao())){
      $objInfraException->adicionarValidacao('Instala��o n�o informada.');
    }
  }

  private function validarStrSigla(UsuarioFederacaoDTO $objUsuarioFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUsuarioFederacaoDTO->getStrSigla())){
      $objInfraException->adicionarValidacao('Sigla n�o informada.');
    }else{
      $objUsuarioFederacaoDTO->setStrSigla(trim($objUsuarioFederacaoDTO->getStrSigla()));

      if (strlen($objUsuarioFederacaoDTO->getStrSigla())>100){
        $objInfraException->adicionarValidacao('Sigla possui tamanho superior a 100 caracteres.');
      }
    }
  }

  private function validarStrNome(UsuarioFederacaoDTO $objUsuarioFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUsuarioFederacaoDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objUsuarioFederacaoDTO->setStrNome(trim($objUsuarioFederacaoDTO->getStrNome()));

      if (strlen($objUsuarioFederacaoDTO->getStrNome())>100){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a 100 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_cadastrar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrIdUsuarioFederacao($objUsuarioFederacaoDTO, $objInfraException);
      $this->validarStrIdInstalacaoFederacao($objUsuarioFederacaoDTO, $objInfraException);
      $this->validarStrSigla($objUsuarioFederacaoDTO, $objInfraException);
      $this->validarStrNome($objUsuarioFederacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioFederacaoBD->cadastrar($objUsuarioFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function alterarControlado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_alterar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objUsuarioFederacaoDTO->isSetStrIdInstalacaoFederacao()){
        $this->validarStrIdInstalacaoFederacao($objUsuarioFederacaoDTO, $objInfraException);
      }
      if ($objUsuarioFederacaoDTO->isSetStrSigla()){
        $this->validarStrSigla($objUsuarioFederacaoDTO, $objInfraException);
      }
      if ($objUsuarioFederacaoDTO->isSetStrNome()){
        $this->validarStrNome($objUsuarioFederacaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $objUsuarioFederacaoBD->alterar($objUsuarioFederacaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function excluirControlado($arrObjUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_excluir', __METHOD__, $arrObjUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUsuarioFederacaoDTO);$i++){
        $objUsuarioFederacaoBD->excluir($arrObjUsuarioFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function consultarConectado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_consultar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioFederacaoBD->consultar($objUsuarioFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function listarConectado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_listar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioFederacaoBD->listar($objUsuarioFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Usu�rios do SEI Federa��o.',$e);
    }
  }

  protected function contarConectado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_listar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioFederacaoBD->contar($objUsuarioFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Usu�rios do SEI Federa��o.',$e);
    }
  }

  protected function desativarControlado($arrObjUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_desativar', __METHOD__, $arrObjUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUsuarioFederacaoDTO);$i++){
        $objUsuarioFederacaoBD->desativar($arrObjUsuarioFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function reativarControlado($arrObjUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_reativar', __METHOD__, $arrObjUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUsuarioFederacaoDTO);$i++){
        $objUsuarioFederacaoBD->reativar($arrObjUsuarioFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function bloquearControlado(UsuarioFederacaoDTO $objUsuarioFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('usuario_federacao_consultar', __METHOD__, $objUsuarioFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioFederacaoBD = new UsuarioFederacaoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioFederacaoBD->bloquear($objUsuarioFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Usu�rio do SEI Federa��o.',$e);
    }
  }

  protected function sincronizarControlado(UsuarioFederacaoDTO $parObjUsuarioFederacaoDTO){
    try{

      $objUsuarioFederacaoDTO = new UsuarioFederacaoDTO();
      $objUsuarioFederacaoDTO->setBolExclusaoLogica(false);
      $objUsuarioFederacaoDTO->retStrIdUsuarioFederacao();
      $objUsuarioFederacaoDTO->retStrSigla();
      $objUsuarioFederacaoDTO->retStrNome();
      $objUsuarioFederacaoDTO->setStrIdUsuarioFederacao($parObjUsuarioFederacaoDTO->getStrIdUsuarioFederacao());

      $objUsuarioFederacaoDTO = $this->consultar($objUsuarioFederacaoDTO);

      if ($objUsuarioFederacaoDTO == null){

        $objUsuarioFederacaoDTO = new UsuarioFederacaoDTO();
        $objUsuarioFederacaoDTO->setStrIdUsuarioFederacao($parObjUsuarioFederacaoDTO->getStrIdUsuarioFederacao());
        $objUsuarioFederacaoDTO->setStrIdInstalacaoFederacao($parObjUsuarioFederacaoDTO->getStrIdInstalacaoFederacao());
        $objUsuarioFederacaoDTO->setStrSigla($parObjUsuarioFederacaoDTO->getStrSigla());
        $objUsuarioFederacaoDTO->setStrNome($parObjUsuarioFederacaoDTO->getStrNome());
        $this->cadastrar($objUsuarioFederacaoDTO);

      }else{

        if ($objUsuarioFederacaoDTO->getStrSigla()!=$parObjUsuarioFederacaoDTO->getStrSigla() || $objUsuarioFederacaoDTO->getStrNome()!=$parObjUsuarioFederacaoDTO->getStrNome()){
          $objUsuarioFederacaoDTO->setStrSigla($parObjUsuarioFederacaoDTO->getStrSigla());
          $objUsuarioFederacaoDTO->setStrNome($parObjUsuarioFederacaoDTO->getStrNome());
          $this->alterar($objUsuarioFederacaoDTO);
        }
      }

    }catch(Exception $e){
      throw new InfraException('Erro sincronizando Usu�rio do SEI Federa��o.',$e);
    }
  }
}
