<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/04/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class InstalacaoFederacaoRN extends InfraRN {

  private static $objInstalacaoDTOLocal = null;

  public static $TI_LOCAL = 'L';
  public static $TI_ENVIADA = 'E';
  public static $TI_RECEBIDA = 'R';
  public static $TI_REPLICADA = 'P';

  public static $EI_ANALISE = 'A';
  public static $EI_LIBERADA = 'L';
  public static $EI_BLOQUEADA = 'B';

  public static $AI_NENHUM = 'N';
  public static $AI_EMAIL_ENVIADO = 'E';
  public static $AI_IGNORADO = 'I';

  public static $TC_OK = 'OK';
  public static $TC_INDISPONIVEL = 'Indispon�vel';
  public static $TC_ERRO = 'Erro';

  public function __construct(){

    parent::__construct();

    if (self::$objInstalacaoDTOLocal==null){
      self::$objInstalacaoDTOLocal = $this->obterInstalacaoLocal();
    }
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public function normalizarEndereco($strEndereco){
    $ret = $strEndereco;
    $ret = str_replace('https://','',$ret);
    $ret = str_replace('//','/',$ret);
    $ret = str_replace('/sei/controlador_ws.php?servico=federacao','',$ret);
    $ret = str_replace('/controlador_ws.php?servico=federacao','',$ret);
    return $ret;
  }

  public function tratarSeiVersao($strSeiVersao){
    return ($strSeiVersao ?? '4.0.0');
  }

  public function tratarSeiFederacaoVersao($strSeiFederacaoVersao){
    return ($strSeiFederacaoVersao ?? '1.0.0');
  }

  public function autenticarWS($Identificacao){
    try{

      $objInfraException = new InfraException();

      $this->verificarFederacao($Identificacao);

      $Remetente = $Identificacao->Remetente;
      $Destinatario = $Identificacao->Destinatario;
      $Instalacao = $Remetente->Instalacao;
      $strIdentificacaoRemota = $Instalacao->Sigla.' ('.InfraUtil::formatarCnpj($Instalacao->Cnpj).')';

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->retStrDescricaoEstado();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retStrSinAtivo();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrChavePrivada();
      $objInstalacaoFederacaoDTO->retStrChavePublicaRemota();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($Instalacao->IdInstalacaoFederacao);

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' n�o encontrada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      if ($objInstalacaoFederacaoDTO->getDblCnpj()!=$Instalacao->Cnpj){
        $objInfraException->lancarValidacao('CNPJ da instala��o '.$Instalacao->Sigla.' diferente na instala��o remota ('.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj()).').');
      }

      if ($this->normalizarEndereco($objInstalacaoFederacaoDTO->getStrEndereco())!=$this->normalizarEndereco($Instalacao->Endereco)){
        $objInfraException->lancarValidacao('Endere�o da instala��o '.$strIdentificacaoRemota.' diferente na instala��o remota ('.$objInstalacaoFederacaoDTO->getStrEndereco().').');
      }

      if ($objInstalacaoFederacaoDTO->getStrSinAtivo()=='N'){
        $objInfraException->lancarValidacao('Instala��o '.$Instalacao->Sigla.' desativada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_ANALISE) {
        $objInfraException->lancarValidacao('Instala��o '.$Instalacao->Sigla.' em an�lise na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_BLOQUEADA) {
        $objInfraException->lancarValidacao('Instala��o '.$Instalacao->Sigla.' bloqueada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      $Destino = $Destinatario->Instalacao;

      if ($Destino->IdInstalacaoFederacao != $this->obterIdInstalacaoFederacaoLocal()){
        $objInfraException->lancarValidacao('Identificador do SEI Federa��o da instala��o '.$this->obterSiglaInstalacaoLocal().' diferente na instala��o origem.');
      }

      if ($Destino->Cnpj != $this->obterCnpjInstalacaoLocal()){
        $objInfraException->lancarValidacao('CNPJ da instala��o '.$this->obterSiglaInstalacaoLocal().' diferente na instala��o origem ('.InfraUtil::formatarCnpj($this->obterCnpjInstalacaoLocal()).').');
      }

      $this->descriptografarHash($objInstalacaoFederacaoDTO->getStrChavePrivada(), $objInstalacaoFederacaoDTO->getStrChavePublicaRemota(), $Instalacao->Hash, $objInstalacaoFederacaoDTO->getStrSigla(), $objInstalacaoFederacaoDTO->getDblCnpj());

      if ($Instalacao->Sigla!=$objInstalacaoFederacaoDTO->getStrSigla() || $Instalacao->Descricao!=$objInstalacaoFederacaoDTO->getStrDescricao()){
        $objInstalacaoFederacaoDTOSincronizacao = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTOSincronizacao->setStrSigla($Instalacao->Sigla);
        $objInstalacaoFederacaoDTOSincronizacao->setStrDescricao($Instalacao->Descricao);
        $objInstalacaoFederacaoDTOSincronizacao->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $this->sincronizar($objInstalacaoFederacaoDTOSincronizacao);
      }

      $Orgao = $Remetente->Orgao;

      $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
      $objOrgaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($Orgao->IdOrgaoFederacao);
      $objOrgaoFederacaoDTO->setStrSigla($Orgao->Sigla);
      $objOrgaoFederacaoDTO->setStrDescricao($Orgao->Descricao);

      $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
      $objOrgaoFederacaoRN->sincronizar($objOrgaoFederacaoDTO);

      $Unidade = $Remetente->Unidade;
      
      $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
      $objUnidadeFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objUnidadeFederacaoDTO->setStrIdUnidadeFederacao($Unidade->IdUnidadeFederacao);
      $objUnidadeFederacaoDTO->setStrSigla($Unidade->Sigla);
      $objUnidadeFederacaoDTO->setStrDescricao($Unidade->Descricao);

      $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
      $objUnidadeFederacaoRN->sincronizar($objUnidadeFederacaoDTO);


      $Usuario = $Remetente->Usuario;

      $objUsuarioFederacaoDTO = new UsuarioFederacaoDTO();
      $objUsuarioFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objUsuarioFederacaoDTO->setStrIdUsuarioFederacao($Usuario->IdUsuarioFederacao);
      $objUsuarioFederacaoDTO->setStrSigla($Usuario->Sigla);
      $objUsuarioFederacaoDTO->setStrNome($Usuario->Nome);

      $objUsuarioFederacaoRN = new UsuarioFederacaoRN();
      $objUsuarioFederacaoRN->sincronizar($objUsuarioFederacaoDTO);

      SessaoSEIFederacao::getInstance()->logar($objInstalacaoFederacaoDTO, $objOrgaoFederacaoDTO, $objUnidadeFederacaoDTO, $objUsuarioFederacaoDTO);

      return $objInstalacaoFederacaoDTO;

    }catch (Exception $e){
      throw new InfraException('Erro autenticando instala��o.', $e);
    }
  }

  public function verificarFederacao($Identificacao){
    try{
      $objInfraException = new InfraException();

      if (!ConfiguracaoSEI::getInstance()->getValor('Federacao','Habilitado',false,false)) {
        $objInfraException->lancarValidacao('SEI Federa��o desabilitado na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      if (explode('.', SEI_FEDERACAO_VERSAO)[0] != explode('.', $Identificacao->VersaoSeiFederacao)[0]){
        $objInfraException->lancarValidacao('Vers�o do SEI Federa��o da instala��o '.$Identificacao->Remetente->Instalacao->Sigla.' '.$Identificacao->VersaoSeiFederacao.' incompat�vel com a vers�o da instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

    }catch (Exception $e){
      throw new InfraException('Erro verificando SEI Federa��o.', $e);
    }
  }

  public function listarValoresTipo(){
    try {

      $arrObjTipoInstalacaoFederacaoDTO = array();

      $objTipoInstalacaoFederacaoDTO = new TipoInstalacaoFederacaoDTO();
      $objTipoInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_LOCAL);
      $objTipoInstalacaoFederacaoDTO->setStrDescricao('Local');
      $arrObjTipoInstalacaoFederacaoDTO[] = $objTipoInstalacaoFederacaoDTO;

      $objTipoInstalacaoFederacaoDTO = new TipoInstalacaoFederacaoDTO();
      $objTipoInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_ENVIADA);
      $objTipoInstalacaoFederacaoDTO->setStrDescricao('Enviada');
      $arrObjTipoInstalacaoFederacaoDTO[] = $objTipoInstalacaoFederacaoDTO;

      $objTipoInstalacaoFederacaoDTO = new TipoInstalacaoFederacaoDTO();
      $objTipoInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_RECEBIDA);
      $objTipoInstalacaoFederacaoDTO->setStrDescricao('Recebida');
      $arrObjTipoInstalacaoFederacaoDTO[] = $objTipoInstalacaoFederacaoDTO;

      $objTipoInstalacaoFederacaoDTO = new TipoInstalacaoFederacaoDTO();
      $objTipoInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_REPLICADA);
      $objTipoInstalacaoFederacaoDTO->setStrDescricao('Replicada');
      $arrObjTipoInstalacaoFederacaoDTO[] = $objTipoInstalacaoFederacaoDTO;


      return $arrObjTipoInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Tipo.',$e);
    }
  }

  public function listarValoresEstado(){
    try {

      $arrObjEstadoInstalacaoFederacaoDTO = array();

      $objEstadoInstalacaoFederacaoDTO = new EstadoInstalacaoFederacaoDTO();
      $objEstadoInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_ANALISE);
      $objEstadoInstalacaoFederacaoDTO->setStrDescricao('Em An�lise');
      $arrObjEstadoInstalacaoFederacaoDTO[] = $objEstadoInstalacaoFederacaoDTO;

      $objEstadoInstalacaoFederacaoDTO = new EstadoInstalacaoFederacaoDTO();
      $objEstadoInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_LIBERADA);
      $objEstadoInstalacaoFederacaoDTO->setStrDescricao('Liberada');
      $arrObjEstadoInstalacaoFederacaoDTO[] = $objEstadoInstalacaoFederacaoDTO;

      $objEstadoInstalacaoFederacaoDTO = new EstadoInstalacaoFederacaoDTO();
      $objEstadoInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_BLOQUEADA);
      $objEstadoInstalacaoFederacaoDTO->setStrDescricao('Bloqueada');
      $arrObjEstadoInstalacaoFederacaoDTO[] = $objEstadoInstalacaoFederacaoDTO;

      return $arrObjEstadoInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Estado.',$e);
    }
  }

  public function listarValoresAgendamento(){
    try {

      $arrObjAgendamentoInstalacaoFederacaoDTO = array();

      $objAgendamentoInstalacaoFederacaoDTO = new AgendamentoInstalacaoFederacaoDTO();
      $objAgendamentoInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
      $objAgendamentoInstalacaoFederacaoDTO->setStrDescricao('Nenhum');
      $arrObjAgendamentoInstalacaoFederacaoDTO[] = $objAgendamentoInstalacaoFederacaoDTO;

      $objAgendamentoInstalacaoFederacaoDTO = new AgendamentoInstalacaoFederacaoDTO();
      $objAgendamentoInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_EMAIL_ENVIADO);
      $objAgendamentoInstalacaoFederacaoDTO->setStrDescricao('E-mail enviado');
      $arrObjAgendamentoInstalacaoFederacaoDTO[] = $objAgendamentoInstalacaoFederacaoDTO;

      $objAgendamentoInstalacaoFederacaoDTO = new AgendamentoInstalacaoFederacaoDTO();
      $objAgendamentoInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_IGNORADO);
      $objAgendamentoInstalacaoFederacaoDTO->setStrDescricao('Ignorado');
      $arrObjAgendamentoInstalacaoFederacaoDTO[] = $objAgendamentoInstalacaoFederacaoDTO;


      return $arrObjAgendamentoInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Agendamento.',$e);
    }
  }

  private function validarStrIdInstalacaoFederacao(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado.');
    }else {

      if (!InfraULID::validar($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao())){
        $objInfraException->lancarValidacao('Identificador do SEI Federa��o '.$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao().' inv�lido.');
      }

      $dto = new InstalacaoFederacaoDTO();
      $dto->retStrIdInstalacaoFederacao();
      $dto->setNumMaxRegistrosRetorno(1);
      $dto->setBolExclusaoLogica(false);
      $dto->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      if ($this->consultar($dto) != null) {
        $objInfraException->adicionarValidacao('J� existe uma Instala��o cadastrada com o identificador '.$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao().' do SEI Federa��o.');
      }
    }
  }

  private function validarDblCnpj(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getDblCnpj())){
      $objInfraException->adicionarValidacao('CNPJ n�o informado.');
    }else {
      if (!InfraUtil::validarCnpj($objInstalacaoFederacaoDTO->getDblCnpj())) {
        $objInfraException->adicionarValidacao('CNPJ inv�lido.');
      }
    }

    $dto = new InstalacaoFederacaoDTO();
    $dto->setBolExclusaoLogica(false);
    $dto->retStrSinAtivo();
    $dto->retStrSigla();
    $dto->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao(),InfraDTO::$OPER_DIFERENTE);
    $dto->setDblCnpj($objInstalacaoFederacaoDTO->getDblCnpj());

    $dto = $this->consultar($dto);

    if ($dto != null){
      $objInfraException->adicionarValidacao('CNPJ '.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj()).' j� est� associado com a instala��o '.($dto->getStrSinAtivo()=='N' ? 'inativa' : '').' '.$dto->getStrSigla().'.');
    }

  }

  private function validarStrSigla(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrSigla())){
      $objInfraException->adicionarValidacao('Sigla n�o informada.');
    }else{
      $objInstalacaoFederacaoDTO->setStrSigla(trim($objInstalacaoFederacaoDTO->getStrSigla()));

      if (strlen($objInstalacaoFederacaoDTO->getStrSigla())>30){
        $objInfraException->adicionarValidacao('Sigla possui tamanho superior a 30 caracteres.');
      }
    }
  }

  private function validarStrDescricao(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrDescricao())){
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    }else{
      $objInstalacaoFederacaoDTO->setStrDescricao(trim($objInstalacaoFederacaoDTO->getStrDescricao()));

      if (strlen($objInstalacaoFederacaoDTO->getStrDescricao())>100){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 100 caracteres.');
      }
    }
  }

  private function validarStrEndereco(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrEndereco())){
      $objInfraException->adicionarValidacao('Endere�o n�o informado.');
    }else{
      $objInstalacaoFederacaoDTO->setStrEndereco(trim($objInstalacaoFederacaoDTO->getStrEndereco()));

      if (strlen($objInstalacaoFederacaoDTO->getStrEndereco())>250){
        $objInfraException->adicionarValidacao('Endere�o possui tamanho superior a 250 caracteres.');
      }

      $dto = new InstalacaoFederacaoDTO();
      $dto->setBolExclusaoLogica(false);
      $dto->retStrSinAtivo();
      $dto->retStrSigla();
      $dto->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao(),InfraDTO::$OPER_DIFERENTE);
      $dto->setStrEndereco($objInstalacaoFederacaoDTO->getStrEndereco());

      $dto = $this->consultar($dto);

      if ($dto != null){
        $objInfraException->adicionarValidacao('Endere�o "'.$objInstalacaoFederacaoDTO->getStrEndereco().'"" j� est� associado com a instala��o '.($dto->getStrSinAtivo()=='N' ? 'inativa' : '').' '.$dto->getStrSigla().'.');
      }
    }
  }

  private function validarStrStaTipo(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrStaTipo())){
      $objInfraException->adicionarValidacao('Tipo n�o informado.');
    }else{
      if (!in_array($objInstalacaoFederacaoDTO->getStrStaTipo(),InfraArray::converterArrInfraDTO($this->listarValoresTipo(),'StaTipo'))){
        $objInfraException->adicionarValidacao('Tipo inv�lido.');
      }
    }
  }

  private function validarStrStaEstado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrStaEstado())){
      $objInfraException->adicionarValidacao('Estado n�o informado.');
    }else{
      if (!in_array($objInstalacaoFederacaoDTO->getStrStaEstado(),InfraArray::converterArrInfraDTO($this->listarValoresEstado(),'StaEstado'))){
        $objInfraException->adicionarValidacao('Estado inv�lido.');
      }
    }
  }

  private function validarStrStaAgendamento(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrStaAgendamento())){
      $objInfraException->adicionarValidacao('Situa��o de Agendamento n�o informada.');
    }else{
      if (!in_array($objInstalacaoFederacaoDTO->getStrStaAgendamento(),InfraArray::converterArrInfraDTO($this->listarValoresAgendamento(),'StaAgendamento'))){
        $objInfraException->adicionarValidacao('Situa��o de Agendamento inv�lida.');
      }
    }
  }

  private function validarStrSinAtivo(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objInstalacaoFederacaoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_cadastrar', __METHOD__, $objInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarDblCnpj($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrSigla($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrDescricao($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrEndereco($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrStaTipo($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrStaEstado($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrStaAgendamento($objInstalacaoFederacaoDTO, $objInfraException);
      $this->validarStrSinAtivo($objInstalacaoFederacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objInstalacaoFederacaoBD->cadastrar($objInstalacaoFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function alterarControlado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_alterar', __METHOD__, $objInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objInstalacaoFederacaoDTO->isSetDblCnpj()){
        $this->validarDblCnpj($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrSigla()){
        $this->validarStrSigla($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrEndereco()){
        $this->validarStrEndereco($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrStaTipo()){
        $this->validarStrStaTipo($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrStaEstado()){
        $this->validarStrStaEstado($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrStaAgendamento()){
        $this->validarStrStaAgendamento($objInstalacaoFederacaoDTO, $objInfraException);
      }
      if ($objInstalacaoFederacaoDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objInstalacaoFederacaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      $objInstalacaoFederacaoBD->alterar($objInstalacaoFederacaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function excluirControlado($arrObjInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_excluir', __METHOD__, $arrObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objAcessoFederacaoRN = new AcessoFederacaoRN();
      for($i=0;$i<count($arrObjInstalacaoFederacaoDTO);$i++){
        $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
        $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
        $objAcessoFederacaoDTO->setNumMaxRegistrosRetorno(1);
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->adicionarCriterio(array('IdInstalacaoFederacaoRem','IdInstalacaoFederacaoDest'),
                                                  array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
                                                  array($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao(),$arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao()),
                                                  InfraDTO::$OPER_LOGICO_OR);

        if (($objAcessoFederacaoDTO=$objAcessoFederacaoRN->consultar($objAcessoFederacaoDTO))!=null){

          if ($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem() == $arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao()){
            $strSiglaInstalacaoAcesso = $objAcessoFederacaoDTO->getStrSiglaInstalacaoFederacaoRem();
          }else{
            $strSiglaInstalacaoAcesso = $objAcessoFederacaoDTO->getStrSiglaInstalacaoFederacaoDest();
          }
          $objInfraException->adicionarValidacao('N�o � poss�vel excluir a instala��o '.$strSiglaInstalacaoAcesso.' porque existem acessos relacionados.');
        }
      }

      $objInfraException->lancarValidacoes();

      $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
      $objAtributoInstalacaoRN = new AtributoInstalacaoRN();
      $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
      $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
      $objUsuarioFederacaoRN = new UsuarioFederacaoRN();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjInstalacaoFederacaoDTO);$i++){

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->retNumIdAtributoInstalacao();
        $objAtributoInstalacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objAtributoInstalacaoRN->excluir($objAtributoInstalacaoRN->listar($objAtributoInstalacaoDTO));

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->retNumIdAndamentoInstalacao();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoRN->excluir($objAndamentoInstalacaoRN->listar($objAndamentoInstalacaoDTO));

        $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
        $objOrgaoFederacaoDTO->retStrIdOrgaoFederacao();
        $objOrgaoFederacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objOrgaoFederacaoRN->excluir($objOrgaoFederacaoRN->listar($objOrgaoFederacaoDTO));

        $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
        $objUnidadeFederacaoDTO->retStrIdUnidadeFederacao();
        $objUnidadeFederacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objUnidadeFederacaoRN->excluir($objUnidadeFederacaoRN->listar($objUnidadeFederacaoDTO));

        $objUsuarioFederacaoDTO = new UsuarioFederacaoDTO();
        $objUsuarioFederacaoDTO->retStrIdUsuarioFederacao();
        $objUsuarioFederacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objUsuarioFederacaoRN->excluir($objUsuarioFederacaoRN->listar($objUsuarioFederacaoDTO));

        $objInstalacaoFederacaoBD->excluir($arrObjInstalacaoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function consultarConectado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_consultar', __METHOD__, $objInstalacaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      if ($objInstalacaoFederacaoDTO->isRetStrDescricaoTipo()){
        $objInstalacaoFederacaoDTO->retStrStaTipo();
      }

      if ($objInstalacaoFederacaoDTO->isRetStrDescricaoEstado()){
        $objInstalacaoFederacaoDTO->retStrStaEstado();
      }

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objInstalacaoFederacaoBD->consultar($objInstalacaoFederacaoDTO);

      if ($ret != null) {
        if ($objInstalacaoFederacaoDTO->isRetStrDescricaoTipo()) {
          $arrObjTipoInstalacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listarValoresTipo(), 'StaTipo');
          $ret->setStrDescricaoTipo($arrObjTipoInstalacaoFederacaoDTO[$ret->getStrStaTipo()]->getStrDescricao());
        }

        if ($objInstalacaoFederacaoDTO->isRetStrDescricaoEstado()) {
          $arrObjEstadoInstalacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listarValoresEstado(), 'StaEstado');
          $ret->setStrDescricaoEstado($arrObjEstadoInstalacaoFederacaoDTO[$ret->getStrStaEstado()]->getStrDescricao());
        }
      }

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function listarConectado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_listar', __METHOD__, $objInstalacaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      if ($objInstalacaoFederacaoDTO->isRetStrDescricaoTipo()){
        $objInstalacaoFederacaoDTO->retStrStaTipo();
      }

      if ($objInstalacaoFederacaoDTO->isRetStrDescricaoEstado()){
        $objInstalacaoFederacaoDTO->retStrStaEstado();
      }

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objInstalacaoFederacaoBD->listar($objInstalacaoFederacaoDTO);

      if (count($ret)) {

        if ($objInstalacaoFederacaoDTO->isRetStrDescricaoTipo()) {
          $arrObjTipoInstalacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listarValoresTipo(), 'StaTipo');
          foreach($ret as $dto) {
            $dto->setStrDescricaoTipo($arrObjTipoInstalacaoFederacaoDTO[$dto->getStrStaTipo()]->getStrDescricao());
          }
        }

        if ($objInstalacaoFederacaoDTO->isRetStrDescricaoEstado()) {
          $arrObjEstadoInstalacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listarValoresEstado(), 'StaEstado');
          foreach($ret as $dto) {
            $dto->setStrDescricaoEstado($arrObjEstadoInstalacaoFederacaoDTO[$dto->getStrStaEstado()]->getStrDescricao());
          }
        }
      }
      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro listando Instala��es do SEI Federa��o.',$e);
    }
  }

  protected function contarConectado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_listar', __METHOD__, $objInstalacaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objInstalacaoFederacaoBD->contar($objInstalacaoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Instala��es do SEI Federa��o.',$e);
    }
  }

  protected function desativarControlado($arrObjInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_desativar', __METHOD__, $arrObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjInstalacaoFederacaoDTO);$i++){
        $objInstalacaoFederacaoBD->desativar($arrObjInstalacaoFederacaoDTO[$i]);

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
        $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $objInstalacaoFederacaoDTO->retStrStaEstado();
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_DESATIVACAO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function reativarControlado($arrObjInstalacaoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_reativar', __METHOD__, $arrObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoBD = new InstalacaoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjInstalacaoFederacaoDTO);$i++){
        $objInstalacaoFederacaoBD->reativar($arrObjInstalacaoFederacaoDTO[$i]);

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
        $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $objInstalacaoFederacaoDTO->retStrStaEstado();
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($arrObjInstalacaoFederacaoDTO[$i]->getStrIdInstalacaoFederacao());
        $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_REATIVACAO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Instala��o do SEI Federa��o.',$e);
    }
  }

  private function obterServico(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO){
    try {

      $strWSDL = '';

      if (substr($parObjInstalacaoFederacaoDTO->getStrEndereco(),0,8) !== 'https://'){
        $strWSDL = 'https://';
      }

      //se possui endereco completo
      if (strpos($parObjInstalacaoFederacaoDTO->getStrEndereco(),'/controlador_ws.php?servico=federacao') !== false){
        $strWSDL .= $parObjInstalacaoFederacaoDTO->getStrEndereco();
      }else {
        //sen�o assume endere�o padrao "/sei"
        $strWSDL .= $parObjInstalacaoFederacaoDTO->getStrEndereco().'/sei/controlador_ws.php?servico=federacao';
      }

      $objWS = new SoapClient($strWSDL, array ('encoding'=>'ISO-8859-1'));

      return $objWS;

    } catch (Throwable $e) {

      $strIdentificacao = '';
      try {
        if ($parObjInstalacaoFederacaoDTO->isSetStrIdInstalacaoFederacao() && !InfraString::isBolVazia($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao())) {
          $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
          $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
          $objInstalacaoFederacaoDTO->retStrSigla();
          $objInstalacaoFederacaoDTO->retDblCnpj();
          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
          $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);
          if ($objInstalacaoFederacaoDTO != null) {
            $strIdentificacao = ' '.$objInstalacaoFederacaoDTO->getStrSigla().' ('.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj()).')';
          }
        }
      }catch(Throwable $e2){}

      $objInfraException = new InfraException();

      if (strpos(strtoupper($e->__toString()),'CERTIFICATE VERIFY FAILED')!==false){
        $objInfraException->lancarValidacao('N�o foi poss�vel validar o certificado da instala��o'.$strIdentificacao.'.');
      }

      if (strpos(strtoupper($e->__toString()),'FAILED TO LOAD EXTERNAL ENTITY')!==false){
        $objInfraException->lancarValidacao('Problema no certificado ou bloqueio no acesso ao servi�o da instala��o'.$strIdentificacao.'.');
      }

      if (strpos(strtoupper($e->__toString()),'COULDN\'T LOAD FROM')!==false){
        $objInfraException->lancarValidacao('N�o foi poss�vel carregar o servi�o no endere�o da instala��o'.$strIdentificacao.'.');
      }

      if (strpos(strtoupper($e->__toString()),'FAILED TO OPEN STREAM')!==false){
        $objInfraException->lancarValidacao('N�o foi poss�vel acessar o servi�o no endere�o da instala��o'.$strIdentificacao.'.');
      }

      throw new InfraException('Falha na conex�o com a Instala��o'.$strIdentificacao.'.', $e);
    }
  }

  private function obterInstalacaoLocal(){
    try{

      $objInfraException = new InfraException();

      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->setBolExclusaoLogica(false);
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->retStrDescricao();
      $objOrgaoDTO->retDblCnpjContato();
      $objOrgaoDTO->setStrSigla(ConfiguracaoSEI::getInstance()->getValor('SessaoSEI','SiglaOrgaoSistema'));

      $objOrgaoRN = new OrgaoRN();
      $objOrgaoDTO = $objOrgaoRN->consultarRN1352($objOrgaoDTO);

      if ($objOrgaoDTO==null){
        throw new InfraException('�rg�o da instala��o local do SEI Federa��o n�o encontrado.');
      }

      if (InfraString::isBolVazia($objOrgaoDTO->getDblCnpjContato())) {
        if (SessaoSEI::getInstance()->isBolHabilitada()) {
          $objInfraException->lancarValidacao('CNPJ n�o informado no cadastro do �rg�o '.ConfiguracaoSEI::getInstance()->getValor('SessaoSEI', 'SiglaOrgaoSistema').' para o SEI Federa��o.'."\n\n".'Informar por meio do menu Administra��o/�rg�os, a��o "Alterar �rg�o", �cone "Alterar Dados do Contato Associado".');
        }else{
          $objInfraException->lancarValidacao('CNPJ n�o foi cadastrado na instala��o remota.');
        }
      }

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_LOCAL);

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      $strEnderecoLocal = $this->montarEnderecoInstalacaoLocal();

      if ($objInstalacaoFederacaoDTO==null){

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao(InfraULID::gerar());
        $objInstalacaoFederacaoDTO->setStrSigla($objOrgaoDTO->getStrSigla());
        $objInstalacaoFederacaoDTO->setStrDescricao($objOrgaoDTO->getStrDescricao());
        $objInstalacaoFederacaoDTO->setStrEndereco($strEnderecoLocal);
        $objInstalacaoFederacaoDTO->setDblCnpj($objOrgaoDTO->getDblCnpjContato());
        $objInstalacaoFederacaoDTO->setStrChavePrivada(null);
        $objInstalacaoFederacaoDTO->setStrChavePublicaLocal(null);
        $objInstalacaoFederacaoDTO->setStrChavePublicaRemota(null);
        $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_LOCAL);
        $objInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_LIBERADA);
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $objInstalacaoFederacaoDTO->setStrSinAtivo('S');

        $this->cadastrar($objInstalacaoFederacaoDTO);

      }else{

        if ($objInstalacaoFederacaoDTO->getStrSigla()!=$objOrgaoDTO->getStrSigla() ||
            $objInstalacaoFederacaoDTO->getStrDescricao()!=$objOrgaoDTO->getStrDescricao() ||
            $objInstalacaoFederacaoDTO->getDblCnpj()!=$objOrgaoDTO->getDblCnpjContato() ||
            $objInstalacaoFederacaoDTO->getStrEndereco()!=$strEnderecoLocal){

          $objInstalacaoFederacaoDTO->setStrSigla($objOrgaoDTO->getStrSigla());
          $objInstalacaoFederacaoDTO->setStrDescricao($objOrgaoDTO->getStrDescricao());
          $objInstalacaoFederacaoDTO->setDblCnpj($objOrgaoDTO->getDblCnpjContato());
          $objInstalacaoFederacaoDTO->setStrEndereco($strEnderecoLocal);

          $this->alterar($objInstalacaoFederacaoDTO);
        }

      }

      return $objInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro obtendo �rg�o da instala��o local', $e);
    }
  }

  private function montarEnderecoInstalacaoLocal(){
    try {
      $strEndereco = strtolower(trim(ConfiguracaoSEI::getInstance()->getValor('SEI', 'URL')));

      //remove prefixo
      $strEndereco = str_replace(array('http://', 'https://'), '', $strEndereco);

      //URL no padr�o https://endereco/sei
      if (substr($strEndereco, -4) == '/sei') {
        //retornar apenas o "endereco"
        $strEndereco = substr($strEndereco, 0, strlen($strEndereco) - 4);
      } else {
        //passar apontamento completo
        $strEndereco .= '/controlador_ws.php?servico=federacao';
      }

      return $strEndereco;

    }catch(Exception $e){
      throw new InfraException('Erro montando endere�o da instala��o local.', $e);
    }
  }

  public function obterIdInstalacaoFederacaoLocal(){
    return self::$objInstalacaoDTOLocal->getStrIdInstalacaoFederacao();
  }

  public function obterEnderecoInstalacaoLocal(){
    return self::$objInstalacaoDTOLocal->getStrEndereco();
  }

  public function obterCnpjInstalacaoLocal(){
    return self::$objInstalacaoDTOLocal->getDblCnpj();
  }

  public function obterSiglaInstalacaoLocal(){
    return self::$objInstalacaoDTOLocal->getStrSigla();
  }

  public function obterDescricaoInstalacaoLocal(){
    return self::$objInstalacaoDTOLocal->getStrDescricao();
  }

  protected function solicitarRegistroControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_cadastrar', __METHOD__, $parObjInstalacaoFederacaoDTO);

      $objInfraException = new InfraException();

      if (InfraString::isBolVazia($this->obterCnpjInstalacaoLocal())){
        $objInfraException->lancarValidacao('CNPJ da instala��o local n�o informado.');
      }

      $objWS = $this->obterServico($parObjInstalacaoFederacaoDTO);


      try {

        $objInstalacao = new stdClass();
        $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
        $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();
        $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
        $objInstalacao->Descricao = $this->obterDescricaoInstalacaoLocal();
        $objInstalacao->Endereco = $this->obterEnderecoInstalacaoLocal();

        $objRemetente = new stdClass();
        $objRemetente->Instalacao = $objInstalacao;

        $objIdentificacao = new stdClass();
        $objIdentificacao->VersaoSei = SEI_VERSAO;
        $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
        $objIdentificacao->Remetente = $objRemetente;

        $ret = $objWS->solicitarRegistro($objIdentificacao);

      } catch (Exception $e) {
        throw new InfraException('Erro solicitanto registro na Instala��o.', $e);
      }

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($ret->IdInstalacaoFederacao);

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      //se ainda nao existe o registro local
      if ($objInstalacaoFederacaoDTO==null){
        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($ret->IdInstalacaoFederacao);
        $objInstalacaoFederacaoDTO->setDblCnpj($ret->Cnpj);
        $objInstalacaoFederacaoDTO->setStrSigla($ret->Sigla);
        $objInstalacaoFederacaoDTO->setStrDescricao($ret->Descricao);
        $objInstalacaoFederacaoDTO->setStrEndereco($ret->Endereco);
        $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_ENVIADA);
        $objInstalacaoFederacaoDTO->setStrStaEstado($ret->StaEstado);
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $objInstalacaoFederacaoDTO->setStrSinAtivo('S');
        $objInstalacaoFederacaoDTO = $this->cadastrar($objInstalacaoFederacaoDTO);
      }else{

        if ($this->normalizarEndereco($objInstalacaoFederacaoDTO->getStrEndereco())!=$this->normalizarEndereco($ret->Endereco)){
          $objInfraException->lancarValidacao('Endere�o da instala��o '.InfraUtil::formatarCnpj($ret->Cnpj).' ('.$ret->Endereco.') n�o confere com o j� registrado na instala��o local para este CNPJ ('.$objInstalacaoFederacaoDTO->getStrEndereco().').');
        }

        //senao apenas atualiza
        $objInstalacaoFederacaoDTO->setDblCnpj($ret->Cnpj);
        $objInstalacaoFederacaoDTO->setStrSigla($ret->Sigla);
        $objInstalacaoFederacaoDTO->setStrDescricao($ret->Descricao);
        $objInstalacaoFederacaoDTO->setStrStaEstado($ret->StaEstado);
        $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_ENVIADA);
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $this->alterar($objInstalacaoFederacaoDTO);
      }

      $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
      $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
      $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_ENVIO_SOLICITACAO);

      $arrObjAtributoInstalacaoDTO = array();

      $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
      $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
      $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTO->getStrSigla()."�".$objInstalacaoFederacaoDTO->getStrDescricao());
      $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

      $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

      $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
      $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);

      return $objInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro solicitando registro de Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function alterarRegistroControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_alterar', __METHOD__, $parObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();
      $this->validarStrEndereco($parObjInstalacaoFederacaoDTO, $objInfraException);
      $objInfraException->lancarValidacoes();

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTOBanco = $this->consultar($objInstalacaoFederacaoDTO);

      //se realmente houve mudan�a no endere�o
      if ($this->normalizarEndereco($objInstalacaoFederacaoDTOBanco->getStrEndereco())!=$this->normalizarEndereco($parObjInstalacaoFederacaoDTO->getStrEndereco())) {

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
        $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $objInstalacaoFederacaoDTO->setStrEndereco($parObjInstalacaoFederacaoDTO->getStrEndereco());
        $objInstalacaoFederacaoDTO->setNumMaxRegistrosRetorno(1);

        $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

        if ($objInstalacaoFederacaoDTO != null) {
          $objInfraException->lancarValidacao('J� existe uma Instala��o cadastrada com o endere�o '.$parObjInstalacaoFederacaoDTO->getStrEndereco().'.');
        }

        $objWS = $this->obterServico($parObjInstalacaoFederacaoDTO);

        try {

          $objInstalacao = new stdClass();
          $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
          $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();
          $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
          $objInstalacao->Descricao = $this->obterDescricaoInstalacaoLocal();
          $objInstalacao->Endereco = $this->obterEnderecoInstalacaoLocal();

          $objRemetente = new stdClass();
          $objRemetente->Instalacao = $objInstalacao;

          $objIdentificacao = new stdClass();
          $objIdentificacao->VersaoSei = SEI_VERSAO;
          $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
          $objIdentificacao->Remetente = $objRemetente;

          //envia solicita��o de registro padr�o
          $ret = $objWS->solicitarRegistro($objIdentificacao);

        } catch (Exception $e) {
          throw new InfraException('Erro solicitanto registro na Instala��o.', $e);
        }

        if ($ret->IdInstalacaoFederacao != $objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao()){
          $objInfraException->lancarValidacao('Identificador do SEI Federa��o da instala��o remota n�o corresponde ao da instala��o '.$objInstalacaoFederacaoDTOBanco->getStrSigla().'.');
        }

        //se retornou um CNPJ diferente
        if ($ret->Cnpj != $objInstalacaoFederacaoDTOBanco->getDblCnpj()){
          $objInfraException->lancarValidacao('CNPJ da instala��o remota n�o corresponde ao CNPJ da Instala��o '.$objInstalacaoFederacaoDTOBanco->getStrSigla().'.');
        }

        //atualiza dados
        $objInstalacaoFederacaoDTOBanco->setStrEndereco($ret->Endereco);
        $objInstalacaoFederacaoDTOBanco->setDblCnpj($ret->Cnpj);
        $objInstalacaoFederacaoDTOBanco->setStrSigla($ret->Sigla);
        $objInstalacaoFederacaoDTOBanco->setStrDescricao($ret->Descricao);
        $objInstalacaoFederacaoDTOBanco->setStrStaTipo(self::$TI_ENVIADA);
        $objInstalacaoFederacaoDTOBanco->setStrStaEstado($ret->StaEstado);
        $this->alterar($objInstalacaoFederacaoDTOBanco);

        //alteracao do endereco
        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTOBanco->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_ALTERACAO_ENDERECO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('ENDERECO');
        $objAtributoInstalacaoDTO->setStrValor($ret->Endereco);
        $objAtributoInstalacaoDTO->setStrIdOrigem(null);
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);

        //envio da solicitacao
        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTOBanco->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_ENVIO_SOLICITACAO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
        $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTOBanco->getStrSigla()."�".$objInstalacaoFederacaoDTOBanco->getStrDescricao());
        $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);

      }

    }catch(Exception $e){
      throw new InfraException('Erro solicitando altera��o do registro de Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function processarSolicitacaoRegistroControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      $objInfraException = new InfraException();

      $strIdentificacaoRemota = $parObjInstalacaoFederacaoDTO->getStrSigla().' ('.InfraUtil::formatarCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj()).')';

      if ($this->obterIdInstalacaoFederacaoLocal()==$parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()){
        $objInfraException->lancarValidacao('Identificador do SEI Federa��o da instala��o '.$strIdentificacaoRemota.' � igual ao da instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      if ($this->obterCnpjInstalacaoLocal()==$parObjInstalacaoFederacaoDTO->getDblCnpj()){
        $objInfraException->lancarValidacao('CNPJ da instala��o '.$strIdentificacaoRemota.' � igual ao da instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      $objInstalacaoFederacaoDTOBanco = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTOBanco->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTOBanco->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTOBanco->retStrStaTipo();
      $objInstalacaoFederacaoDTOBanco->retStrStaEstado();
      $objInstalacaoFederacaoDTOBanco->retDblCnpj();
      $objInstalacaoFederacaoDTOBanco->retStrEndereco();
      $objInstalacaoFederacaoDTOBanco->retStrSinAtivo();
      $objInstalacaoFederacaoDTOBanco->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTOBanco);

      //se ainda n�o existe cadastra normalmente
      if ($objInstalacaoFederacaoDTO==null){

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objInstalacaoFederacaoDTO->setDblCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj());
        $objInstalacaoFederacaoDTO->setStrSigla($parObjInstalacaoFederacaoDTO->getStrSigla());
        $objInstalacaoFederacaoDTO->setStrDescricao($parObjInstalacaoFederacaoDTO->getStrDescricao());
        $objInstalacaoFederacaoDTO->setStrEndereco($parObjInstalacaoFederacaoDTO->getStrEndereco());
        $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_RECEBIDA);
        $objInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_ANALISE);
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $objInstalacaoFederacaoDTO->setStrSinAtivo('S');
        $objInstalacaoFederacaoDTO = $this->cadastrar($objInstalacaoFederacaoDTO);

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_SOLICITACAO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
        $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTO->getStrSigla()."�".$objInstalacaoFederacaoDTO->getStrDescricao());
        $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);


      }else{


        if ($this->normalizarEndereco($objInstalacaoFederacaoDTO->getStrEndereco())!=$this->normalizarEndereco($parObjInstalacaoFederacaoDTO->getStrEndereco())){
          $objInfraException->lancarValidacao('Endere�o da instala��o diferente para a instala��o '.$strIdentificacaoRemota.' na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
        }

        //evita registro duplo entre as instalacoes (A->B, B->A)
        //if ($objInstalacaoFederacaoDTO->getStrStaTipo()==self::$TI_ENVIADA && $objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_ANALISE){
        //  $objInfraException->lancarValidacao('J� existe solicita��o enviada pela Instala��o '.$this->obterSiglaInstalacaoLocal().' para a instala��o '.$strIdentificacaoRemota.'.');
        //}

        //evita tentativas sucessivas de registro (Instala��o bloqueada passa a ser ignorada)
        if ($objInstalacaoFederacaoDTO->getStrStaEstado()==self::$EI_BLOQUEADA){
          $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' bloqueada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
        }

        if ($objInstalacaoFederacaoDTO->getStrSinAtivo()=='N'){
          $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' consta como desativada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
        }

        //se estava como replicada ou enviada ou liberada ou trocou CNPJ volta para em analise (evitar roubo de identidade)
        if ($objInstalacaoFederacaoDTO->getStrStaTipo()==self::$TI_REPLICADA ||
            $objInstalacaoFederacaoDTO->getStrStaTipo()==self::$TI_ENVIADA ||
            $objInstalacaoFederacaoDTO->getStrStaEstado()==self::$EI_LIBERADA ||
            $objInstalacaoFederacaoDTO->getDblCnpj()!=$parObjInstalacaoFederacaoDTO->getDblCnpj()) {

          //atualiza dados
          $objInstalacaoFederacaoDTO->setStrSigla($parObjInstalacaoFederacaoDTO->getStrSigla());
          $objInstalacaoFederacaoDTO->setStrDescricao($parObjInstalacaoFederacaoDTO->getStrDescricao());
          $objInstalacaoFederacaoDTO->setDblCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj());
          $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_RECEBIDA);
          $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
          $objInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_ANALISE);
          $this->alterar($objInstalacaoFederacaoDTO);

          $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
          $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
          $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
          $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_SOLICITACAO);

          $arrObjAtributoInstalacaoDTO = array();

          $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
          $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
          $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTO->getStrSigla()."�".$objInstalacaoFederacaoDTO->getStrDescricao());
          $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
          $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

          $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

          $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
          $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);

        }else if ($objInstalacaoFederacaoDTO->getStrStaEstado()==self::$EI_ANALISE) {
          //apenas  responde normalmente (pode ter ocorrido erro na Instala��o de origem na primeira tentativa)
        }
      }

      $objInstalacaoFederacaoDTORet = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTORet->setStrIdInstalacaoFederacao($this->obterIdInstalacaoFederacaoLocal());
      $objInstalacaoFederacaoDTORet->setDblCnpj($this->obterCnpjInstalacaoLocal());
      $objInstalacaoFederacaoDTORet->setStrSigla($this->obterSiglaInstalacaoLocal());
      $objInstalacaoFederacaoDTORet->setStrDescricao($this->obterDescricaoInstalacaoLocal());
      $objInstalacaoFederacaoDTORet->setStrEndereco($this->obterEnderecoInstalacaoLocal());
      $objInstalacaoFederacaoDTORet->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());

      return $objInstalacaoFederacaoDTORet;

    }catch(Exception $e){
      throw new InfraException('Erro processando solicita��o de registro de Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function liberarRegistroConectado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      $objInstalacaoFederacaoDTOBanco = $this->prepararLiberacaoInterno($parObjInstalacaoFederacaoDTO);

      $objWS = $this->obterServico($objInstalacaoFederacaoDTOBanco);

      try {

        $objInstalacao = new stdClass();
        $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
        $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();
        $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
        $objInstalacao->Descricao = $this->obterDescricaoInstalacaoLocal();
        $objInstalacao->Endereco = $this->obterEnderecoInstalacaoLocal();
        $objInstalacao->ChavePublica = $objInstalacaoFederacaoDTOBanco->getStrChavePublicaLocal();

        $objRemetente = new stdClass();
        $objRemetente->Instalacao = $objInstalacao;

        $objIdentificacao = new stdClass();
        $objIdentificacao->VersaoSei = SEI_VERSAO;
        $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
        $objIdentificacao->Remetente = $objRemetente;

        $objWS->liberarRegistro($objIdentificacao);

      } catch (Exception $e) {
        throw new InfraException('Erro liberando registro da Instala��o.', $e);
      }

      $this->finalizarLiberacaoInterno($objInstalacaoFederacaoDTOBanco);

    }catch(Exception $e){
      throw new InfraException('Erro liberando registro da Instala��o no SEI Federa��o.',$e);
    }
  }

  protected function prepararLiberacaoInternoControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO){

    SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_liberar', __METHOD__, $parObjInstalacaoFederacaoDTO);

    //Regras de Negocio
    $objInfraException = new InfraException();

    $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
    $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
    $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
    $objInstalacaoFederacaoDTO->retStrEndereco();
    $objInstalacaoFederacaoDTO->retStrStaTipo();
    $objInstalacaoFederacaoDTO->retStrStaEstado();
    $objInstalacaoFederacaoDTO->retStrSinAtivo();
    $objInstalacaoFederacaoDTO->retStrSigla();
    $objInstalacaoFederacaoDTO->retStrDescricao();
    $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

    $objInstalacaoFederacaoDTOBanco = $this->consultar($objInstalacaoFederacaoDTO);

    if ($objInstalacaoFederacaoDTOBanco==null){
      $objInfraException->lancarValidacao('Registro da Instala��o n�o encontrado.');
    }

    if ($objInstalacaoFederacaoDTOBanco->getStrSinAtivo()=='N'){
      $objInfraException->lancarValidacao('Registro da Instala��o consta como desativado.');
    }

    if ($objInstalacaoFederacaoDTOBanco->getStrStaTipo()==InstalacaoFederacaoRN::$TI_REPLICADA){
      $objInfraException->lancarValidacao('N�o � poss�vel liberar uma solicita��o de registro que consta como replicada.');
    }

    if ($objInstalacaoFederacaoDTOBanco->getStrStaTipo()==InstalacaoFederacaoRN::$TI_ENVIADA){
      $objInfraException->lancarValidacao('N�o � poss�vel liberar uma solicita��o de registro enviada para outra Instala��o.');
    }

    if ($objInstalacaoFederacaoDTOBanco->getStrStaEstado()==InstalacaoFederacaoRN::$EI_LIBERADA){
      $objInfraException->lancarValidacao('Instala��o j� consta como liberada.');
    }

    $parChavesLocal = sodium_crypto_box_keypair();
    $chavePrivadaLocal = base64_encode(sodium_crypto_box_secretkey($parChavesLocal));
    $chavePublicaLocal = base64_encode(sodium_crypto_box_publickey($parChavesLocal));

    $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
    $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
    $objInstalacaoFederacaoDTO->setStrChavePublicaLocal($chavePublicaLocal);
    $objInstalacaoFederacaoDTO->setStrChavePrivada($chavePrivadaLocal);
    $this->alterar($objInstalacaoFederacaoDTO);

    $objInstalacaoFederacaoDTOBanco->setStrChavePublicaLocal($chavePublicaLocal);
    $objInstalacaoFederacaoDTOBanco->setStrChavePrivada($chavePrivadaLocal);

    return $objInstalacaoFederacaoDTOBanco;
  }

  protected function finalizarLiberacaoInternoControlado(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTOBanco){

    $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
    $objInstalacaoFederacaoDTO->setStrStaEstado(InstalacaoFederacaoRN::$EI_LIBERADA);
    $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
    $objInstalacaoFederacaoDTO->setStrChavePublicaLocal($objInstalacaoFederacaoDTOBanco->getStrChavePublicaLocal());
    $objInstalacaoFederacaoDTO->setStrChavePrivada($objInstalacaoFederacaoDTOBanco->getStrChavePrivada());
    $this->alterar($objInstalacaoFederacaoDTO);

    $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
    $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
    $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
    $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_ENVIO_LIBERACAO);

    $arrObjAtributoInstalacaoDTO = array();

    $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
    $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
    $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTOBanco->getStrSigla()."�".$objInstalacaoFederacaoDTOBanco->getStrDescricao());
    $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
    $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

    $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

    $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
    $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
  }

  protected function processarLiberacaoRegistroControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      $objInfraException = new InfraException();

      $strIdentificacaoRemota = $parObjInstalacaoFederacaoDTO->getStrSigla().' ('.InfraUtil::formatarCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj()).')';

      //Regras de Negocio
      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrStaTipo();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' n�o possui registro na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      //nao pode liberar um registro que foi recebido em outra Instalacao
      if ($objInstalacaoFederacaoDTO->getStrStaTipo()==InstalacaoFederacaoRN::$TI_RECEBIDA){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' possui solicita��o de registro recebida na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      //pode liberar se foi enviada ou replicada
      if ($objInstalacaoFederacaoDTO->getStrStaTipo()==self::$TI_ENVIADA) {

        $objInstalacaoFederacaoDTO_Banco = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO_Banco->setBolExclusaoLogica(false);
        $objInstalacaoFederacaoDTO_Banco->retStrEndereco();
        $objInstalacaoFederacaoDTO_Banco->retDblCnpj();
        $objInstalacaoFederacaoDTO_Banco->retStrSigla();
        $objInstalacaoFederacaoDTO_Banco->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

        $objInstalacaoFederacaoDTO_Banco = $this->consultar($objInstalacaoFederacaoDTO_Banco);
        $objWS = $this->obterServico($objInstalacaoFederacaoDTO_Banco);

        $parChavesLocal = sodium_crypto_box_keypair();
        $chavePrivadaLocal = base64_encode(sodium_crypto_box_secretkey($parChavesLocal));
        $chavePublicaLocal = base64_encode(sodium_crypto_box_publickey($parChavesLocal));
        $strHash = $this->criptografarTimeStamp($chavePrivadaLocal, $parObjInstalacaoFederacaoDTO->getStrChavePublicaRemota());

        try {

          $objInstalacao = new stdClass();
          $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
          $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
          $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();
          $objInstalacao->Hash = $strHash;
          $objInstalacao->ChavePublica = $chavePublicaLocal;

          $objRemetente = new stdClass();
          $objRemetente->Instalacao = $objInstalacao;

          $objIdentificacao = new stdClass();
          $objIdentificacao->VersaoSei = SEI_VERSAO;
          $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
          $objIdentificacao->Remetente = $objRemetente;

          $objWS->confirmarLiberacao($objIdentificacao);

        } catch (Exception $e) {
          throw new InfraException('Erro confirmando libera��o do registro na Instala��o .', $e);
        }

        //atualiza dados
        $objInstalacaoFederacaoDTO->setStrChavePublicaRemota($parObjInstalacaoFederacaoDTO->getStrChavePublicaRemota());
        $objInstalacaoFederacaoDTO->setStrChavePublicaLocal($chavePublicaLocal);
        $objInstalacaoFederacaoDTO->setStrChavePrivada($chavePrivadaLocal);
        $objInstalacaoFederacaoDTO->setStrSigla($parObjInstalacaoFederacaoDTO->getStrSigla());
        $objInstalacaoFederacaoDTO->setStrDescricao($parObjInstalacaoFederacaoDTO->getStrDescricao());
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $objInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_LIBERADA);

        $this->alterar($objInstalacaoFederacaoDTO);

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_LIBERACAO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
        $objAtributoInstalacaoDTO->setStrValor($parObjInstalacaoFederacaoDTO->getStrSigla()."�".$parObjInstalacaoFederacaoDTO->getStrDescricao());
        $objAtributoInstalacaoDTO->setStrIdOrigem($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
      }
    }catch(Exception $e){
      throw new InfraException('Erro processando libera��o da Instala��o no SEI Federa��o.',$e);
    }
  }

  private function criptografarTimeStamp($chavePrivadaLocal, $strChavePublicaRemota){
    try {
      $strTimeStamp = gmdate("d/m/Y H:i:s");

      $parChavesLocalRemota = sodium_crypto_box_keypair_from_secretkey_and_publickey(
          base64_decode($chavePrivadaLocal),
          base64_decode($strChavePublicaRemota)
      );
      $strNonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
      $strHash = sodium_crypto_box(
          $strTimeStamp,
          $strNonce,
          $parChavesLocalRemota
      );
      return base64_encode($strNonce.$strHash);

    }catch(Exception $e) {
      throw new InfraException('Erro criptografando dados.', $e);
    }
  }

  private function descriptografarHash($strChavePrivada, $strChavePublicaRemota, $strHash, $strSiglaInstalacao, $dblCnpjInstalacao){
    try {

      $parChavesLocalRemota = sodium_crypto_box_keypair_from_secretkey_and_publickey(
          base64_decode($strChavePrivada),
          base64_decode($strChavePublicaRemota)
      );

      $strNonce = substr(base64_decode($strHash), 0, 24);
      $strHash = substr(base64_decode($strHash), 24);
      $dthTimeStamp_Recebido = sodium_crypto_box_open($strHash, $strNonce, $parChavesLocalRemota);

      if ($dthTimeStamp_Recebido === false) {
        throw new InfraException('Dados de criptografia inv�lidos.');
      } else {

        $numSegundosSincronizacao = ConfiguracaoSEI::getInstance()->getValor('Federacao', 'NumSegundosSincronizacao', false, 300);

        if (!is_numeric($numSegundosSincronizacao) || $numSegundosSincronizacao < 0) {
          $numSegundosSincronizacao = 300;
        }

        $dthTimeStamp_Atual = gmdate("d/m/Y H:i:s");

        $numSegundosDiferenca = abs(InfraData::compararDataHora($dthTimeStamp_Atual, $dthTimeStamp_Recebido));

        if ($numSegundosDiferenca > $numSegundosSincronizacao) {
          throw new InfraException('Dados de criptografia expirados para a instala��o '.$strSiglaInstalacao.' ('.InfraUtil::formatarCnpj($dblCnpjInstalacao).').');
        }
      }

    }catch(Exception $e){
      throw new InfraException('Erro nos dados de criptografia para a instala��o '.$strSiglaInstalacao.' ('.InfraUtil::formatarCnpj($dblCnpjInstalacao).').', $e);
    }
  }

  protected function processarConfirmacaoLiberacaoControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO){
    try{

      $strIdentificacaoRemota = $parObjInstalacaoFederacaoDTO->getStrSigla().' ('.InfraUtil::formatarCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj()).')';

      $objInfraException = new InfraException();

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrChavePublicaLocal();
      $objInstalacaoFederacaoDTO->retStrChavePrivada();
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' n�o possui registro na instala��o local.');
      }

      if(InfraString::isBolVazia($objInstalacaoFederacaoDTO->getStrChavePublicaLocal())){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' n�o possui chave p�blica cadastrada na instala��o local.');
      }

      $this->descriptografarHash($objInstalacaoFederacaoDTO->getStrChavePrivada(), $parObjInstalacaoFederacaoDTO->getStrChavePublicaRemota(), $parObjInstalacaoFederacaoDTO->getStrHash(), $parObjInstalacaoFederacaoDTO->getStrSigla(), $parObjInstalacaoFederacaoDTO->getDblCnpj());

      //atualiza dados
      $objInstalacaoFederacaoDTO_Atualizar = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO_Atualizar->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objInstalacaoFederacaoDTO_Atualizar->setStrChavePublicaRemota($parObjInstalacaoFederacaoDTO->getStrChavePublicaRemota());
      $this->alterar($objInstalacaoFederacaoDTO_Atualizar);

    }catch(Exception $e){
     // LogSEI::getInstance()->gravar($e);
      throw new InfraException('Erro processando libera��o da Instala��o no SEI Federa��o.',$e);
    }
  }

  protected function bloquearRegistroConectado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO)
  {

    //Transa��o separada pois para bloquear localmente n�o pode depender da resposta da outra Instala��o
    $objInstalacaoFederacaoDTOBanco = $this->bloquearRegistroInterno($parObjInstalacaoFederacaoDTO);

    try {
      //tenta sinalizar na outra Instala��o a mudan�a na situa��o
      $objWS = $this->obterServico($objInstalacaoFederacaoDTOBanco);

      $objInstalacao = new stdClass();
      $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
      $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
      $objInstalacao->Descricao = $this->obterSiglaInstalacaoLocal();
      $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();

      $objRemetente = new stdClass();
      $objRemetente->Instalacao = $objInstalacao;

      $objIdentificacao = new stdClass();
      $objIdentificacao->VersaoSei = SEI_VERSAO;
      $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
      $objIdentificacao->Remetente = $objRemetente;

      $objWS->bloquearRegistro($objIdentificacao);

    } catch (Exception $e) {
      //apenas loga o erro (evita tentativa de evitar o bloqueio retornando um erro)
      LogSEI::getInstance()->gravar('Erro sinalizando bloqueio para a instala��o remota:'.InfraException::inspecionar($e));
    }
  }

  protected function bloquearRegistroInternoControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_bloquear', __METHOD__, $parObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retStrStaTipo();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->retStrSinAtivo();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTOBanco = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTOBanco==null){
        $objInfraException->lancarValidacao('Registro da Instala��o n�o encontrado.');
      }

      if ($objInstalacaoFederacaoDTOBanco->getStrSinAtivo()=='N'){
        $objInfraException->lancarValidacao('Registro da Instala��o consta como desativado.');
      }

      if ($objInstalacaoFederacaoDTOBanco->getStrStaTipo()==InstalacaoFederacaoRN::$TI_ENVIADA){
        $objInfraException->lancarValidacao('N�o � poss�vel bloquear uma solicita��o de registro enviada para outra Instala��o.');
      }

      if ($objInstalacaoFederacaoDTOBanco->getStrStaEstado()!=InstalacaoFederacaoRN::$EI_BLOQUEADA) {

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->setStrStaEstado(InstalacaoFederacaoRN::$EI_BLOQUEADA);
        $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());

        $this->alterar($objInstalacaoFederacaoDTO);


        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_ENVIO_BLOQUEIO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
        $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTOBanco->getStrSigla()."�".$objInstalacaoFederacaoDTOBanco->getStrDescricao());
        $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTOBanco->getStrIdInstalacaoFederacao());
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
      }

      return $objInstalacaoFederacaoDTOBanco;

    }catch(Exception $e){
      throw new InfraException('Erro bloqueando registro da Instala��o no SEI Federa��o.',$e);
    }
  }

  protected function processarBloqueioRegistroControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      //Regras de Negocio
      $objInfraException = new InfraException();

      $strIdentificacaoRemota = $parObjInstalacaoFederacaoDTO->getStrSigla().' ('.InfraUtil::formatarCnpj($parObjInstalacaoFederacaoDTO->getDblCnpj()).')';

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        $objInfraException->lancarValidacao('Instala��o '.$strIdentificacaoRemota.' n�o possui registro na instala��o remota.');
      }

      //somente bloqueia se estiver em analise ou liberada
      if ($objInstalacaoFederacaoDTO->getStrStaEstado()==self::$EI_ANALISE || $objInstalacaoFederacaoDTO->getStrStaEstado()==self::$EI_LIBERADA) {

        $objInstalacaoFederacaoDTO->setStrStaEstado(self::$EI_BLOQUEADA);

        $this->alterar($objInstalacaoFederacaoDTO);

        $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
        $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
        $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_BLOQUEIO);

        $arrObjAtributoInstalacaoDTO = array();

        $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
        $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
        $objAtributoInstalacaoDTO->setStrValor($parObjInstalacaoFederacaoDTO->getStrSigla()."�".$parObjInstalacaoFederacaoDTO->getStrDescricao());
        $objAtributoInstalacaoDTO->setStrIdOrigem($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
        $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

        $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

        $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
        $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
      }

    }catch(Exception $e){
      throw new InfraException('Erro processando bloqueio da Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function verificarConexaoConectado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO) {
    try{

      $ret = '';

      SessaoSEI::getInstance()->validarAuditarPermissao('instalacao_federacao_verificar_conexao', __METHOD__, $parObjInstalacaoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->retStrSinAtivo();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        $objInfraException->lancarValidacao('Instala��o n�o encontrada.');
      }

      if ($objInstalacaoFederacaoDTO->getStrSinAtivo()=='N'){
        return self::$TC_INDISPONIVEL;
      }

      if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_ANALISE) {
        return self::$TC_INDISPONIVEL;
      }

      if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_BLOQUEADA) {
        return self::$TC_INDISPONIVEL;
      }

      try {

        $ret = $this->executar('verificarConexao', $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      } catch (Exception $e) {
        $ret = self::$TC_ERRO.': '.($e->getMessage()!=null ? $e->getMessage() : $e->__toString());
        LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
      }

      return $ret;


    }catch(Exception $e){
      throw new InfraException('Erro obtendo estado da Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function sincronizarControlado(InstalacaoFederacaoDTO $parObjInstalacaoFederacaoDTO){
    try{

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO == null){

        throw new InfraException('Instala��o '.$parObjInstalacaoFederacaoDTO->getStrSigla().' n�o encontrada.');

      }else{

        if ($objInstalacaoFederacaoDTO->getStrSigla()!=$parObjInstalacaoFederacaoDTO->getStrSigla() || $objInstalacaoFederacaoDTO->getStrDescricao()!=$parObjInstalacaoFederacaoDTO->getStrDescricao()){
          $objInstalacaoFederacaoDTO->setStrSigla($parObjInstalacaoFederacaoDTO->getStrSigla());
          $objInstalacaoFederacaoDTO->setStrDescricao($parObjInstalacaoFederacaoDTO->getStrDescricao());
          $this->alterar($objInstalacaoFederacaoDTO);
        }
      }

    }catch(Exception $e){
      throw new InfraException('Erro sincronizando instala��o do SEI Federa��o.',$e);
    }
  }

  public function executar($func, $strIdInstalacaoFederacao, ...$params) {
    try {

      $objInfraException = new InfraException();

      //Instalacao
      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setBolExclusaoLogica(false);
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->retStrChavePrivada();
      $objInstalacaoFederacaoDTO->retStrChavePublicaRemota();
      $objInstalacaoFederacaoDTO->retStrStaEstado();
      $objInstalacaoFederacaoDTO->retStrSinAtivo();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($strIdInstalacaoFederacao);

      $objInstalacaoFederacaoDTO = $this->consultar($objInstalacaoFederacaoDTO);

      if ($objInstalacaoFederacaoDTO==null){
        throw new InfraException('Instala��o '.$strIdInstalacaoFederacao.' n�o encontrada.');
      }

      if ($objInstalacaoFederacaoDTO->getStrSinAtivo()=='N'){
        $objInfraException->lancarValidacao('Instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' desativada.');
      }

      if ($objInstalacaoFederacaoDTO->getStrStaEstado()!=self::$EI_LIBERADA){
        $objInfraException->lancarValidacao('Instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' n�o est� liberada na instala��o '.$this->obterSiglaInstalacaoLocal().'.');
      }

      $objInstalacao = new stdClass();
      $objInstalacao->IdInstalacaoFederacao = $this->obterIdInstalacaoFederacaoLocal();
      $objInstalacao->Cnpj = $this->obterCnpjInstalacaoLocal();
      $objInstalacao->Endereco = $this->obterEnderecoInstalacaoLocal();
      $objInstalacao->Sigla = $this->obterSiglaInstalacaoLocal();
      $objInstalacao->Descricao = $this->obterDescricaoInstalacaoLocal();
      $objInstalacao->Hash = $this->criptografarTimeStamp($objInstalacaoFederacaoDTO->getStrChavePrivada(), $objInstalacaoFederacaoDTO->getStrChavePublicaRemota());

      //Orgao
      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->retNumIdOrgao();
      $objOrgaoDTO->retStrIdOrgaoFederacao();
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->retStrDescricao();
      $objOrgaoDTO->setNumIdOrgao(SessaoSEI::getInstance()->getNumIdOrgaoUnidadeAtual());

      $objOrgaoRN = new OrgaoRN();
      $objOrgaoDTO = $objOrgaoRN->consultarRN1352($objOrgaoDTO);

      if ($objOrgaoDTO->getStrIdOrgaoFederacao()==null){
        $objOrgaoRN->gerarIdentificadorFederacao($objOrgaoDTO);
      }

      $objOrgao = new stdClass();
      $objOrgao->IdOrgaoFederacao = $objOrgaoDTO->getStrIdOrgaoFederacao();
      $objOrgao->Sigla = $objOrgaoDTO->getStrSigla();
      $objOrgao->Descricao = $objOrgaoDTO->getStrDescricao();

      //Unidade
      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->retNumIdUnidade();
      $objUnidadeDTO->retStrIdUnidadeFederacao();
      $objUnidadeDTO->retStrSigla();
      $objUnidadeDTO->retStrDescricao();
      $objUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

      $objUnidadeRN = new UnidadeRN();
      $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

      if ($objUnidadeDTO->getStrIdUnidadeFederacao()==null){
        $objUnidadeRN->gerarIdentificadorFederacao($objUnidadeDTO);
      }

      $objUnidade = new stdClass();
      $objUnidade->IdUnidadeFederacao = $objUnidadeDTO->getStrIdUnidadeFederacao();
      $objUnidade->Sigla = $objUnidadeDTO->getStrSigla();
      $objUnidade->Descricao = $objUnidadeDTO->getStrDescricao();

      //Usuario
      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->retNumIdUsuario();
      $objUsuarioDTO->retStrIdUsuarioFederacao();
      $objUsuarioDTO->retStrSigla();
      $objUsuarioDTO->retStrNome();
      $objUsuarioDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultarRN0489($objUsuarioDTO);

      if ($objUsuarioDTO->getStrIdUsuarioFederacao()==null){
        $objUsuarioRN->gerarIdentificadorFederacao($objUsuarioDTO);
      }
      
      $objUsuario = new stdClass();
      $objUsuario->IdUsuarioFederacao = $objUsuarioDTO->getStrIdUsuarioFederacao();
      $objUsuario->Sigla = $objUsuarioDTO->getStrSigla();
      $objUsuario->Nome = $objUsuarioDTO->getStrNome();

      $objRemetente = new stdClass();
      $objRemetente->Instalacao = $objInstalacao;
      $objRemetente->Orgao = $objOrgao;
      $objRemetente->Unidade = $objUnidade;
      $objRemetente->Usuario = $objUsuario;

      $objDestinatario = new stdClass();
      $objInstalacaoDestino = new stdClass();
      $objInstalacaoDestino->IdInstalacaoFederacao = $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao();
      $objInstalacaoDestino->Cnpj = $objInstalacaoFederacaoDTO->getDblCnpj();
      $objDestinatario->Instalacao = $objInstalacaoDestino;

      $objIdentificacao = new stdClass();
      $objIdentificacao->VersaoSei = SEI_VERSAO;
      $objIdentificacao->VersaoSeiFederacao = SEI_FEDERACAO_VERSAO;
      $objIdentificacao->Remetente = $objRemetente;
      $objIdentificacao->Destinatario = $objDestinatario;

      //LogSEI::getInstance()->gravar(print_r($objRemetente,true));

      if ($func == 'verificarConexao' || $func == 'pesquisarOrgaosUnidades') {
        ini_set('default_socket_timeout', '10');
      }else {

        $numSegundosTimeoutConexao = ConfiguracaoSEI::getInstance()->getValor('Federacao', 'NumSegundosTimeoutConexao', false, 60);

        if (is_numeric($numSegundosTimeoutConexao) && $numSegundosTimeoutConexao > 0) {
          ini_set('default_socket_timeout', $numSegundosTimeoutConexao);
        }
      }

      $objWS = $this->obterServico($objInstalacaoFederacaoDTO);

      array_unshift($params, $objIdentificacao);

      $ret = call_user_func_array(array($objWS, $func), $params);

    }catch(Throwable $e){

      if (strpos(strtoupper($e->__toString()),'ERROR FETCHING HTTP HEADERS')!==false){
        throw new InfraException('N�o houve resposta para o servi�o solicitado na instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.', $e);
      }

      if (strpos(strtoupper($e->__toString()),'HANDSHAKE TIMED OUT')!==false){
        throw new InfraException('Tempo esgotado para resposta do servi�o solicitado na instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.', $e);
      }

      if ($func == 'verificarConexao') {
        throw $e;
      }

      throw new InfraException('Erro processando servi�o "'.$func.'" do SEI Federa��o na instala��o "'.$objInstalacaoFederacaoDTO->getStrSigla().'".', $e);
    }

    return $ret;
  }

  protected function listarAcessosConectado(ProcedimentoDTO $objProcedimentoDTO){
    try {

      $arrObjInstalacaoFederacaoDTO = array();

      if ($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo()!=null) {

        $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
        $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
        $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrDescricaoInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrDescricaoOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrDescricaoInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrDescricaoOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSinAtivo();
        $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());
        $objAcessoFederacaoDTO->setOrdStrIdAcessoFederacao(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objAcessoFederacaoRN = new AcessoFederacaoRN();
        $arrObjAcessoFederacaoDTO = $objAcessoFederacaoRN->listar($objAcessoFederacaoDTO);

        if (count($arrObjAcessoFederacaoDTO)) {

          $objSinalizacaoFederacaoDTO = new SinalizacaoFederacaoDTO();
          $objSinalizacaoFederacaoDTO->retTodos();
          $objSinalizacaoFederacaoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objSinalizacaoFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());
          $objSinalizacaoFederacaoDTO->setNumStaSinalizacao(SinalizacaoFederacaoRN::$TSF_NENHUMA, InfraDTO::$OPER_DIFERENTE);

          $objSinalizacaoFederacaoRN = new SinalizacaoFederacaoRN();
          $arrObjSinalizacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($objSinalizacaoFederacaoRN->listar($objSinalizacaoFederacaoDTO), 'IdInstalacaoFederacao');

          $arrObjOrgaoFederacaoDTO = array();

          foreach ($arrObjAcessoFederacaoDTO as $objAcessoFederacaoDTO) {

            $strIdInstalacaoFederacaoRem = $objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem();
            if (!isset($arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoRem])) {
              $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
              $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($strIdInstalacaoFederacaoRem);
              $objInstalacaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaInstalacaoFederacaoRem());
              $objInstalacaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoInstalacaoFederacaoRem());
              $objInstalacaoFederacaoDTO->setStrSinAcesso($objAcessoFederacaoDTO->getStrSinAtivo());
              $arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoRem] = $objInstalacaoFederacaoDTO;
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoRem] = array();
            } else if ($objAcessoFederacaoDTO->getStrSinAtivo() == 'S') {
              $arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoRem]->setStrSinAcesso('S');
            }

            $strIdInstalacaoFederacaoDest = $objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest();
            if (!isset($arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoDest])) {
              $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
              $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($strIdInstalacaoFederacaoDest);
              $objInstalacaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaInstalacaoFederacaoDest());
              $objInstalacaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoInstalacaoFederacaoDest());
              $objInstalacaoFederacaoDTO->setStrSinAcesso($objAcessoFederacaoDTO->getStrSinAtivo());
              $arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoDest] = $objInstalacaoFederacaoDTO;
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoDest] = array();
            } else if ($objAcessoFederacaoDTO->getStrSinAtivo() == 'S') {
              $arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacaoDest]->setStrSinAcesso('S');
            }

            $strIdOrgaoFederacaoRem = $objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem();
            if (!isset($arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoRem][$strIdOrgaoFederacaoRem])) {
              $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
              $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($strIdOrgaoFederacaoRem);
              $objOrgaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaOrgaoFederacaoRem());
              $objOrgaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoOrgaoFederacaoRem());
              $objOrgaoFederacaoDTO->setStrSinAcesso($objAcessoFederacaoDTO->getStrSinAtivo());
              $objOrgaoFederacaoDTO->setStrSinOrigem('N');
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoRem][$strIdOrgaoFederacaoRem] = $objOrgaoFederacaoDTO;
            } else if ($objAcessoFederacaoDTO->getStrSinAtivo() == 'S') {
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoRem][$strIdOrgaoFederacaoRem]->setStrSinAcesso('S');
            }

            $strIdOrgaoFederacaoDest = $objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest();
            if (!isset($arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoDest][$strIdOrgaoFederacaoDest])) {
              $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
              $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($strIdOrgaoFederacaoDest);
              $objOrgaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaOrgaoFederacaoDest());
              $objOrgaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoOrgaoFederacaoDest());
              $objOrgaoFederacaoDTO->setStrSinAcesso($objAcessoFederacaoDTO->getStrSinAtivo());
              $objOrgaoFederacaoDTO->setStrSinOrigem('N');
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoDest][$strIdOrgaoFederacaoDest] = $objOrgaoFederacaoDTO;
            } else if ($objAcessoFederacaoDTO->getStrSinAtivo() == 'S') {
              $arrObjOrgaoFederacaoDTO[$strIdInstalacaoFederacaoDest][$strIdOrgaoFederacaoDest]->setStrSinAcesso('S');
            }
          }

          //remove orgao origem NO FEDERA��O da lista para deixar no topo
          $objOrgaoFederacaoDTOOrigem = $arrObjOrgaoFederacaoDTO[$arrObjAcessoFederacaoDTO[0]->getStrIdInstalacaoFederacaoRem()][$arrObjAcessoFederacaoDTO[0]->getStrIdOrgaoFederacaoRem()];
          unset($arrObjOrgaoFederacaoDTO[$arrObjAcessoFederacaoDTO[0]->getStrIdInstalacaoFederacaoRem()][$arrObjAcessoFederacaoDTO[0]->getStrIdOrgaoFederacaoRem()]);
          $objOrgaoFederacaoDTOOrigem->setStrSinOrigem('S');

          foreach ($arrObjOrgaoFederacaoDTO as $strIdInstalacaoFederacao => $arr) {
            $arr = array_values($arr);
            InfraArray::ordenarArrInfraDTO($arr, 'Sigla', InfraArray::$TIPO_ORDENACAO_ASC);
            $arrObjInstalacaoFederacaoDTO[$strIdInstalacaoFederacao]->setArrObjOrgaoFederacaoDTO($arr);
          }

          //coloca instalacao origem em primeiro
          $objInstalacaoFederacaoDTOOrigem = $arrObjInstalacaoFederacaoDTO[$arrObjAcessoFederacaoDTO[0]->getStrIdInstalacaoFederacaoRem()];
          unset($arrObjInstalacaoFederacaoDTO[$arrObjAcessoFederacaoDTO[0]->getStrIdInstalacaoFederacaoRem()]);
          $arrObjInstalacaoFederacaoDTO = array_values($arrObjInstalacaoFederacaoDTO);
          InfraArray::ordenarArrInfraDTO($arrObjInstalacaoFederacaoDTO, 'Sigla', InfraArray::$TIPO_ORDENACAO_ASC);
          $arrObjInstalacaoFederacaoDTO = array_merge(array($objInstalacaoFederacaoDTOOrigem), $arrObjInstalacaoFederacaoDTO);

          //coloca o orgao origem em primeiro na lista da instalacao origem
          $arrObjOrgaoFederacaoDTOOrigem = $arrObjInstalacaoFederacaoDTO[0]->getArrObjOrgaoFederacaoDTO();
          $arrObjOrgaoFederacaoDTOOrigem = array_merge(array($objOrgaoFederacaoDTOOrigem), $arrObjOrgaoFederacaoDTOOrigem);
          $arrObjInstalacaoFederacaoDTO[0]->setArrObjOrgaoFederacaoDTO($arrObjOrgaoFederacaoDTOOrigem);

          foreach ($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO) {

            $objInstalacaoFederacaoDTO->setObjSinalizacaoFederacaoDTO(null);

            if ($objInstalacaoFederacaoDTO->getStrSinAcesso() == 'S' && isset($arrObjSinalizacaoFederacaoDTO[$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()])) {
              $objInstalacaoFederacaoDTO->setObjSinalizacaoFederacaoDTO($arrObjSinalizacaoFederacaoDTO[$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()]);
              unset($arrObjSinalizacaoFederacaoDTO[$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()]);
            }
          }

          //remove sinaliza��es de instala��es sem acesso
          if (count($arrObjSinalizacaoFederacaoDTO)) {
            $objSinalizacaoFederacaoRN->excluir(array_values($arrObjSinalizacaoFederacaoDTO));
          }
        }
      }

      return $arrObjInstalacaoFederacaoDTO;

    } catch (Exception $e) {
      throw new InfraException('Erro listando instala��es com acesso no SEI Federa��o.', $e);
    }
  }

  protected function processarAgendamentoConectado(){
    try {

      //processa replicacoes pendentes
      $objReplicacaoFederacaoRN = new ReplicacaoFederacaoRN();
      $objReplicacaoFederacaoRN->replicar();

      //envia email de aviso sobre solicitacoes
      $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
      $strEmailSistema = $objInfraParametro->getValor('SEI_EMAIL_SISTEMA');
      $strEmailAdministrador = $objInfraParametro->getValor('SEI_EMAIL_ADMINISTRADOR');

      if (!InfraString::isBolVazia($strEmailSistema) && !InfraString::isBolVazia($strEmailAdministrador)) {

        MailSEI::getInstance()->limpar();

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $objInstalacaoFederacaoDTO->retDblCnpj();
        $objInstalacaoFederacaoDTO->retStrSigla();
        $objInstalacaoFederacaoDTO->retStrDescricao();
        $objInstalacaoFederacaoDTO->retStrEndereco();
        $objInstalacaoFederacaoDTO->retStrStaEstado();
        $objInstalacaoFederacaoDTO->retStrStaTipo();
        $objInstalacaoFederacaoDTO->setStrStaTipo(self::$TI_LOCAL, InfraDTO::$OPER_DIFERENTE);
        $objInstalacaoFederacaoDTO->setStrStaAgendamento(self::$AI_NENHUM);
        $arrObjInstalacaoFederacaoDTO = $this->listar($objInstalacaoFederacaoDTO);

        foreach ($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO) {

          $bolEmail = false;

          if ($objInstalacaoFederacaoDTO->getStrStaTipo() == self::$TI_RECEBIDA) {
            if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_ANALISE) {
              $objEmailDTO = new EmailDTO();
              $objEmailDTO->setStrDe($strEmailSistema);
              $objEmailDTO->setStrPara($strEmailAdministrador);
              $objEmailDTO->setStrAssunto('SEI Federa��o - Solicita��o recebida de '.$objInstalacaoFederacaoDTO->getStrSigla());

              $strConteudo = '';
              $strConteudo .= "\n".'Solicita��o de registro recebida no SEI Federa��o de:'."\n\n";
              $strConteudo .= 'CNPJ - '.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj())."\n";
              $strConteudo .= 'Sigla - '.$objInstalacaoFederacaoDTO->getStrSigla()."\n";
              $strConteudo .= 'Descri��o - '.$objInstalacaoFederacaoDTO->getStrDescricao()."\n";
              $strConteudo .= 'Endere�o - '.$objInstalacaoFederacaoDTO->getStrEndereco()."\n";

              $objEmailDTO->setStrMensagem($strConteudo);

              MailSEI::getInstance()->adicionar($objEmailDTO);

              $bolEmail = true;
            }

          }else if ($objInstalacaoFederacaoDTO->getStrStaTipo() == self::$TI_ENVIADA) {
            if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_LIBERADA) {

              $objEmailDTO = new EmailDTO();
              $objEmailDTO->setStrDe($strEmailSistema);
              $objEmailDTO->setStrPara($strEmailAdministrador);
              $objEmailDTO->setStrAssunto('SEI Federa��o - Instala��o liberada por '.$objInstalacaoFederacaoDTO->getStrSigla());

              $strConteudo = '';
              $strConteudo .= "\n".'Instala��o '.$this->obterSiglaInstalacaoLocal().' foi liberada por:'."\n\n";
              $strConteudo .= 'CNPJ - '.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj())."\n";
              $strConteudo .= 'Sigla - '.$objInstalacaoFederacaoDTO->getStrSigla()."\n";
              $strConteudo .= 'Descri��o - '.$objInstalacaoFederacaoDTO->getStrDescricao()."\n";
              $strConteudo .= 'Endere�o - '.$objInstalacaoFederacaoDTO->getStrEndereco()."\n";

              $objEmailDTO->setStrMensagem($strConteudo);

              MailSEI::getInstance()->adicionar($objEmailDTO);

              $bolEmail = true;
            }

          }else if ($objInstalacaoFederacaoDTO->getStrStaTipo() == self::$TI_REPLICADA) {
            if ($objInstalacaoFederacaoDTO->getStrStaEstado() == self::$EI_ANALISE) {
              $objEmailDTO = new EmailDTO();
              $objEmailDTO->setStrDe($strEmailSistema);
              $objEmailDTO->setStrPara($strEmailAdministrador);
              $objEmailDTO->setStrAssunto('SEI Federa��o - Replica��o recebida para '.$objInstalacaoFederacaoDTO->getStrSigla());

              $strConteudo = '';
              $strConteudo .= "\n".'Replica��o de registro recebida no SEI Federa��o para:'."\n\n";
              $strConteudo .= 'CNPJ - '.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTO->getDblCnpj())."\n";
              $strConteudo .= 'Sigla - '.$objInstalacaoFederacaoDTO->getStrSigla()."\n";
              $strConteudo .= 'Descri��o - '.$objInstalacaoFederacaoDTO->getStrDescricao()."\n";
              $strConteudo .= 'Endere�o - '.$objInstalacaoFederacaoDTO->getStrEndereco()."\n";

              $objEmailDTO->setStrMensagem($strConteudo);

              MailSEI::getInstance()->adicionar($objEmailDTO);

              $bolEmail = true;
            }

          }


          $objInstalacaoFederacaoDTO2 = new InstalacaoFederacaoDTO();
          $objInstalacaoFederacaoDTO2->setStrStaAgendamento($bolEmail ? self::$AI_EMAIL_ENVIADO : self::$AI_IGNORADO);
          $objInstalacaoFederacaoDTO2->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
          $this->alterar($objInstalacaoFederacaoDTO2);
        }

        MailSEI::getInstance()->enviar();
      }

    }catch(Exception $e){
      throw new InfraException('Erro processando agendamento do SEI Federa��o.', $e);
    }
  }

  public function verificarVersaoReenvio(InstalacaoFederacaoDTO $objInstalacaoFederacaoDTO){
    if (InfraUtil::compararVersoes($objInstalacaoFederacaoDTO->getStrSeiFederacaoVersao(), '>=', '1.1.0')){
      return true;
    }
    return false;
  }
}
