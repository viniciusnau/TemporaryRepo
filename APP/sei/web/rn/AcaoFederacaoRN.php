<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/07/2019 - criado por mga
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class AcaoFederacaoRN extends InfraRN {

  public static $TA_VISUALIZAR_DOCUMENTO = 1;
  public static $TA_GERAR_PDF = 2;
  public static $TA_GERAR_ZIP = 3;

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrIdInstalacaoFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdInstalacaoFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado para a Instala��o.');
    }else{
      $objAcaoFederacaoDTO->setStrIdInstalacaoFederacao(trim($objAcaoFederacaoDTO->getStrIdInstalacaoFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdInstalacaoFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para a Instala��o inv�lido.');
      }
    }
  }

  private function validarStrIdOrgaoFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdOrgaoFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado para o �rgao.');
    }else{
      $objAcaoFederacaoDTO->setStrIdOrgaoFederacao(trim($objAcaoFederacaoDTO->getStrIdOrgaoFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdOrgaoFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para o �rgao inv�lido.');
      }
    }
  }
  
  private function validarStrIdUnidadeFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdUnidadeFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado para a Unidade.');
    }else{
      $objAcaoFederacaoDTO->setStrIdUnidadeFederacao(trim($objAcaoFederacaoDTO->getStrIdUnidadeFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdUnidadeFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para a Unidade inv�lido.');
      }
    }
  }

  private function validarStrIdUsuarioFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdUsuarioFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado para o Usu�rio.');
    }else{
      $objAcaoFederacaoDTO->setStrIdUsuarioFederacao(trim($objAcaoFederacaoDTO->getStrIdUsuarioFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdUsuarioFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para o Usu�rio inv�lido.');
      }
    }
  }

  private function validarStrIdProcedimentoFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdProcedimentoFederacao())){
      $objAcaoFederacaoDTO->setStrIdProcedimentoFederacao(null);
    }else{
      $objAcaoFederacaoDTO->setStrIdProcedimentoFederacao(trim($objAcaoFederacaoDTO->getStrIdProcedimentoFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdProcedimentoFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para o Processo inv�lido.');
      }
    }
  }

  private function validarStrIdDocumentoFederacao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrIdDocumentoFederacao())){
      $objAcaoFederacaoDTO->setStrIdDocumentoFederacao(null);
    }else{
      $objAcaoFederacaoDTO->setStrIdDocumentoFederacao(trim($objAcaoFederacaoDTO->getStrIdDocumentoFederacao()));

      if (!InfraULID::validar($objAcaoFederacaoDTO->getStrIdDocumentoFederacao())){
        $objInfraException->adicionarValidacao('Identificador do SEI Federa��o para o Documento inv�lido.');
      }
    }
  }
  
  private function validarDthGeracao(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getDthGeracao())){
      $objInfraException->adicionarValidacao('Data/Hora de Gera��o n�o informada.');
    }else{
      if (!InfraData::validarDataHora($objAcaoFederacaoDTO->getDthGeracao())){
        $objInfraException->adicionarValidacao('Data/Hora de Gera��o inv�lida.');
      }
    }
  }

  private function validarDthAcesso(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getDthAcesso())){
      $objAcaoFederacaoDTO->setDthAcesso(null);
    }else{
      if (!InfraData::validarDataHora($objAcaoFederacaoDTO->getDthAcesso())){
        $objInfraException->adicionarValidacao('Data/Hora de Acesso inv�lida.');
      }
    }
  }

  private function validarNumStaTipo(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getNumStaTipo())){
      $objInfraException->adicionarValidacao('Tipo da a��o do SEI Federa��o n�o informado.');
    }else{
      if (!in_array($objAcaoFederacaoDTO->getNumStaTipo(), InfraArray::converterArrInfraDTO($this->listarValoresTipo(),'StaTipo'))) {
        $objInfraException->adicionarValidacao('Tipo da a��o do SEI Federa��o inv�lido.');
      }
    }
  }

  private function validarStrSinAtivo(AcaoFederacaoDTO $objAcaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcaoFederacaoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objAcaoFederacaoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  public function listarValoresTipo(){
    $arr = array();

    $objTipoAcaoFederacaoDTO = new TipoAcaoFederacaoDTO();
    $objTipoAcaoFederacaoDTO->setNumStaTipo(self::$TA_VISUALIZAR_DOCUMENTO);
    $objTipoAcaoFederacaoDTO->setStrDescricao('Visualizar Documento');
    $arr[] = $objTipoAcaoFederacaoDTO;

    $objTipoAcaoFederacaoDTO = new TipoAcaoFederacaoDTO();
    $objTipoAcaoFederacaoDTO->setNumStaTipo(self::$TA_GERAR_PDF);
    $objTipoAcaoFederacaoDTO->setStrDescricao('Gerar PDF');
    $arr[] = $objTipoAcaoFederacaoDTO;

    $objTipoAcaoFederacaoDTO = new TipoAcaoFederacaoDTO();
    $objTipoAcaoFederacaoDTO->setNumStaTipo(self::$TA_GERAR_ZIP);
    $objTipoAcaoFederacaoDTO->setStrDescricao('Gerar ZIP');
    $arr[] = $objTipoAcaoFederacaoDTO;

    return $arr;
  }


  protected function cadastrarControlado(AcaoFederacaoDTO $objAcaoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_cadastrar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrIdInstalacaoFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrIdOrgaoFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrIdUnidadeFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrIdUsuarioFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrIdProcedimentoFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrIdDocumentoFederacao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarDthGeracao($objAcaoFederacaoDTO, $objInfraException);
      $this->validarDthAcesso($objAcaoFederacaoDTO, $objInfraException);
      $this->validarNumStaTipo($objAcaoFederacaoDTO, $objInfraException);
      $this->validarStrSinAtivo($objAcaoFederacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcaoFederacaoBD->cadastrar($objAcaoFederacaoDTO);

      if ($objAcaoFederacaoDTO->isSetArrObjParametroAcaoFederacaoDTO()) {
        $objParametroAcaoFederacaoRN = new ParametroAcaoFederacaoRN();
        foreach ($objAcaoFederacaoDTO->getArrObjParametroAcaoFederacaoDTO() as $objParametroAcaoFederacaoDTO) {
          $objParametroAcaoFederacaoDTO->setStrIdAcaoFederacao($ret->getStrIdAcaoFederacao());
          $objParametroAcaoFederacaoRN->cadastrar($objParametroAcaoFederacaoDTO);
        }
      }

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando A��o do SEI Federa��o.',$e);
    }
  }

  protected function alterarControlado(AcaoFederacaoDTO $objAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_alterar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objAcaoFederacaoDTO->isSetStrIdInstalacaoFederacao()){
        $this->validarStrIdInstalacaoFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrIdOrgaoFederacao()){
        $this->validarStrIdOrgaoFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrIdUnidadeFederacao()){
        $this->validarStrIdUnidadeFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrIdUsuarioFederacao()){
        $this->validarStrIdUsuarioFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrIdProcedimentoFederacao()){
        $this->validarStrIdProcedimentoFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrIdDocumentoFederacao()){
        $this->validarStrIdDocumentoFederacao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetDthGeracao()){
        $this->validarDthGeracao($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetDthAcesso()){
        $this->validarDthAcesso($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetNumStaTipo()){
        $this->validarNumStaTipo($objAcaoFederacaoDTO, $objInfraException);
      }
      if ($objAcaoFederacaoDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objAcaoFederacaoDTO, $objInfraException);
      }
      $objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $objAcaoFederacaoBD->alterar($objAcaoFederacaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando A��o do SEI Federa��o.',$e);
    }
  }

  protected function excluirControlado($arrObjAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_excluir', __METHOD__, $arrObjAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objParametroAcaoFederacaoRN = new ParametroAcaoFederacaoRN();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcaoFederacaoDTO);$i++){

        $objParametroAcaoFederacaoDTO = new ParametroAcaoFederacaoDTO();
        $objParametroAcaoFederacaoDTO->retStrIdAcaoFederacao();
        $objParametroAcaoFederacaoDTO->retStrNome();
        $objParametroAcaoFederacaoDTO->setStrIdAcaoFederacao($arrObjAcaoFederacaoDTO[$i]->getStrIdAcaoFederacao());
        $objParametroAcaoFederacaoRN->excluir($objParametroAcaoFederacaoRN->listar($objParametroAcaoFederacaoDTO));

        $objAcaoFederacaoBD->excluir($arrObjAcaoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo A��o do SEI Federa��o.',$e);
    }
  }

  protected function consultarConectado(AcaoFederacaoDTO $objAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_consultar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      if ($objAcaoFederacaoDTO->isRetArrObjParametroAcaoFederacaoDTO()){
        $objAcaoFederacaoDTO->retStrIdAcaoFederacao();
      }

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcaoFederacaoBD->consultar($objAcaoFederacaoDTO);

      if ($ret != null){
        if ($objAcaoFederacaoDTO->isRetArrObjParametroAcaoFederacaoDTO()){

          $objParametroAcaoFederacaoDTO = new ParametroAcaoFederacaoDTO();
          $objParametroAcaoFederacaoDTO->retStrNome();
          $objParametroAcaoFederacaoDTO->retStrValor();
          $objParametroAcaoFederacaoDTO->setStrIdAcaoFederacao($ret->getStrIdAcaoFederacao());

          $objParametroAcaoFederacaoRN = new ParametroAcaoFederacaoRN();
          $ret->setArrObjParametroAcaoFederacaoDTO(InfraArray::indexarArrInfraDTO($objParametroAcaoFederacaoRN->listar($objParametroAcaoFederacaoDTO),'Nome'));
        }
      }

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando A��o do SEI Federa��o.',$e);
    }
  }

  protected function listarConectado(AcaoFederacaoDTO $objAcaoFederacaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_listar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcaoFederacaoBD->listar($objAcaoFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando A��es do SEI Federa��o.',$e);
    }
  }

  protected function contarConectado(AcaoFederacaoDTO $objAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_listar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcaoFederacaoBD->contar($objAcaoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando A��es do SEI Federa��o.',$e);
    }
  }

  protected function desativarControlado($arrObjAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_desativar', __METHOD__, $arrObjAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcaoFederacaoDTO);$i++){
        $objAcaoFederacaoBD->desativar($arrObjAcaoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando A��o do SEI Federa��o.',$e);
    }
  }

  protected function reativarControlado($arrObjAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_reativar', __METHOD__, $arrObjAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcaoFederacaoDTO);$i++){
        $objAcaoFederacaoBD->reativar($arrObjAcaoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando A��o do SEI Federa��o.',$e);
    }
  }

  protected function bloquearControlado(AcaoFederacaoDTO $objAcaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acao_federacao_consultar', __METHOD__, $objAcaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcaoFederacaoBD = new AcaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcaoFederacaoBD->bloquear($objAcaoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando A��o do SEI Federa��o.',$e);
    }
  }
}
