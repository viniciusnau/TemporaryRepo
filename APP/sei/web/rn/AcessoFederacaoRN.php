<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 22/05/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class AcessoFederacaoRN extends InfraRN {

  public static $TAF_PROCESSO_ENVIADO_ORGAO = 1;

  //TST = Tipo Sentido Tramitacao
  public static $TST_ENVIADO = 'E';
  public static $TST_RECEBIDO = 'R';

  //TFU = Tipo Filtro Unidades
  public static $TFU_TODAS = 'T';
  public static $TFU_RECEBIMENTO = 'R';

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public function listarValoresTipo(){
    try {

      $arrObjTipoAcessoFederacaoDTO = array();

      $objTipoAcessoFederacaoDTO = new TipoAcessoFederacaoDTO();
      $objTipoAcessoFederacaoDTO->setNumStaTipo(self::$TAF_PROCESSO_ENVIADO_ORGAO);
      $objTipoAcessoFederacaoDTO->setStrDescricao('Envio para �rg�o');
      $arrObjTipoAcessoFederacaoDTO[] = $objTipoAcessoFederacaoDTO;

      return $arrObjTipoAcessoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Tipo.',$e);
    }
  }

  private function validarStrIdAcessoFederacao(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdAcessoFederacao())){
      $objInfraException->adicionarValidacao('Identificador do SEI Federa��o n�o informado.');
    }else {

      if (!InfraULID::validar($objAcessoFederacaoDTO->getStrIdAcessoFederacao())){
        $objInfraException->lancarValidacao('Identificador do SEI Federa��o '.$objAcessoFederacaoDTO->getStrIdAcessoFederacao().' inv�lido.');
      }

      $dto = new AcessoFederacaoDTO();
      $dto->retStrIdAcessoFederacao();
      $dto->setNumMaxRegistrosRetorno(1);
      $dto->setBolExclusaoLogica(false);
      $dto->setStrIdAcessoFederacao($objAcessoFederacaoDTO->getStrIdAcessoFederacao());
      if ($this->consultar($dto) != null) {
        $objInfraException->adicionarValidacao('J� existe um acesso cadastrado nesta instala��o com o mesmo identificador do SEI Federa��o.');
      }
    }
  }

  private function validarStrIdProcedimentoFederacao(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao())){
      $objInfraException->adicionarValidacao('Processo do SEI Federa��o n�o informado.');
    }
  }

  private function validarStrIdDocumentoFederacao(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdDocumentoFederacao())){
      $objAcessoFederacaoDTO->setStrIdDocumentoFederacao(null);
    }
  }

  private function validarStrIdInstalacaoFederacaoRem(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem())){
      $objInfraException->adicionarValidacao('Instala��o remetente do SEI Federa��o n�o informada.');
    }
  }

  private function validarStrIdOrgaoFederacaoRem(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem())){
      $objInfraException->adicionarValidacao('�rg�o remetente do SEI Federa��o n�o informado.');
    }
  }

  private function validarStrIdUnidadeFederacaoRem(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem())){
      $objInfraException->adicionarValidacao('Unidade remetente do SEI Federa��o n�o informada.');
    }
  }

  private function validarStrIdUsuarioFederacaoRem(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem())){
      $objAcessoFederacaoDTO->setStrIdUsuarioFederacaoRem(null);
    }
  }

  private function validarStrIdInstalacaoFederacaoDest(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest())){
      $objInfraException->adicionarValidacao('Instala��o destinat�ria do SEI Federa��o n�o informada.');
    }
  }

  private function validarStrIdOrgaoFederacaoDest(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest())){
      $objInfraException->adicionarValidacao('�rg�o destinat�rio do SEI Federa��o n�o informado.');
    }
  }

  private function validarStrIdUnidadeFederacaoDest(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest())){
      $objInfraException->adicionarValidacao('Unidade destinat�ria do SEI Federa��o n�o informada.');
    }
  }

  private function validarStrIdUsuarioFederacaoDest(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoDest())){
      $objAcessoFederacaoDTO->setStrIdUsuarioFederacaoDest(null);
    }
  }

  private function validarNumStaTipo(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getNumStaTipo())){
      $objInfraException->adicionarValidacao('Tipo n�o informado.');
    }else{
      if (!in_array($objAcessoFederacaoDTO->getNumStaTipo(),InfraArray::converterArrInfraDTO($this->listarValoresTipo(),'StaTipo'))){
        $objInfraException->adicionarValidacao('Tipo inv�lido.');
      }
    }
  }

  private function validarStrSinAtivo(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objAcessoFederacaoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  private function validarDthLiberacao(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getDthLiberacao())){
      $objInfraException->adicionarValidacao('Data/Hora de libera��o n�o informada.');
    }else{
      if (!InfraData::validarDataHora($objAcessoFederacaoDTO->getDthLiberacao())){
        $objInfraException->adicionarValidacao('Data/Hora de libera��o inv�lida.');
      }
    }
  }
  
  private function validarStrMotivoLiberacao(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrMotivoLiberacao())){
      $objAcessoFederacaoDTO->setStrMotivoLiberacao(null);
    }else{
      $objAcessoFederacaoDTO->setStrMotivoLiberacao(trim($objAcessoFederacaoDTO->getStrMotivoLiberacao()));

      if (strlen($objAcessoFederacaoDTO->getStrMotivoLiberacao())>500){
        $objInfraException->adicionarValidacao('Motivo de libera��o possui tamanho superior a 500 caracteres.');
      }
    }
  }

  private function validarDthCancelamento(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getDthCancelamento())){
      $objAcessoFederacaoDTO->setDthCancelamento(null);
    }else{
      if (!InfraData::validarDataHora($objAcessoFederacaoDTO->getDthCancelamento())){
        $objInfraException->adicionarValidacao('Data/Hora de cancelamento inv�lida.');
      }
    }
  }
  
  private function validarStrMotivoCancelamento(AcessoFederacaoDTO $objAcessoFederacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrMotivoCancelamento())){
      $objAcessoFederacaoDTO->setStrMotivoCancelamento(null);
    }else{
      $objAcessoFederacaoDTO->setStrMotivoCancelamento(trim($objAcessoFederacaoDTO->getStrMotivoCancelamento()));

      if (strlen($objAcessoFederacaoDTO->getStrMotivoCancelamento())>500){
        $objInfraException->adicionarValidacao('Motivo de cancelamento possui tamanho superior a 500 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(AcessoFederacaoDTO $objAcessoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_cadastrar', __METHOD__, $objAcessoFederacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrIdAcessoFederacao($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdProcedimentoFederacao($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdDocumentoFederacao($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdInstalacaoFederacaoRem($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdOrgaoFederacaoRem($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdUnidadeFederacaoRem($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdUsuarioFederacaoRem($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdInstalacaoFederacaoDest($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdOrgaoFederacaoDest($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdUnidadeFederacaoDest($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrIdUsuarioFederacaoDest($objAcessoFederacaoDTO, $objInfraException);
      $this->validarDthLiberacao($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrMotivoLiberacao($objAcessoFederacaoDTO, $objInfraException);
      $this->validarDthCancelamento($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrMotivoCancelamento($objAcessoFederacaoDTO, $objInfraException);
      $this->validarNumStaTipo($objAcessoFederacaoDTO, $objInfraException);
      $this->validarStrSinAtivo($objAcessoFederacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcessoFederacaoBD->cadastrar($objAcessoFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Acesso do SEI Federa��o.',$e);
    }
  }

  protected function excluirControlado($arrObjAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_excluir', __METHOD__, $arrObjAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcessoFederacaoDTO);$i++){
        $objAcessoFederacaoBD->excluir($arrObjAcessoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Acesso do SEI Federa��o.',$e);
    }
  }

  protected function consultarConectado(AcessoFederacaoDTO $objAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_consultar', __METHOD__, $objAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcessoFederacaoBD->consultar($objAcessoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Acesso do SEI Federa��o.',$e);
    }
  }

  protected function listarConectado(AcessoFederacaoDTO $objAcessoFederacaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_listar', __METHOD__, $objAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcessoFederacaoBD->listar($objAcessoFederacaoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Acessos do SEI Federa��o.',$e);
    }
  }

  protected function contarConectado(AcessoFederacaoDTO $objAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_listar', __METHOD__, $objAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcessoFederacaoBD->contar($objAcessoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Acessos do SEI Federa��o.',$e);
    }
  }

  protected function desativarControlado($arrObjAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_desativar', __METHOD__, $arrObjAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcessoFederacaoDTO);$i++){
        $objAcessoFederacaoBD->desativar($arrObjAcessoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Acesso do SEI Federa��o.',$e);
    }
  }

  protected function reativarControlado($arrObjAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_reativar', __METHOD__, $arrObjAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAcessoFederacaoDTO);$i++){
        $objAcessoFederacaoBD->reativar($arrObjAcessoFederacaoDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Acesso do SEI Federa��o.',$e);
    }
  }

  protected function bloquearControlado(AcessoFederacaoDTO $objAcessoFederacaoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_consultar', __METHOD__, $objAcessoFederacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $ret = $objAcessoFederacaoBD->bloquear($objAcessoFederacaoDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Acesso do SEI Federa��o.',$e);
    }
  }

  protected function concederAcessoConectado(EnviarProcessoFederacaoDTO $objEnviarProcessoFederacaoDTO){

    try {
      $objEnviarProcessoFederacaoDTORet = $this->concederAcessoInterno($objEnviarProcessoFederacaoDTO);

      $objProtocoloFederacaoDTO = $objEnviarProcessoFederacaoDTORet->getObjProtocoloFederacaoDTO();
      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProtocoloFederacaoDTO->getStrIdProtocoloFederacao());
      $arrIdInstalacaoFederacao = array_unique(InfraArray::converterArrInfraDTO($this->obterOrgaosAcessoFederacao($objAcessoFederacaoDTO), 'IdInstalacaoFederacao'));

      if (count($arrIdInstalacaoFederacao) > 2) {

        $bolReplicarAcessosOnline = ConfiguracaoSEI::getInstance()->getValor('Federacao', 'ReplicarAcessosOnline', false, true);

        $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
        $objReplicacaoFederacaoRN = new ReplicacaoFederacaoRN();
        foreach ($arrIdInstalacaoFederacao as $strIdInstalacaoFederacao) {
          if ($strIdInstalacaoFederacao != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {

            $bolErroReplicacao = false;
            if ($bolReplicarAcessosOnline) {
              try {
                $objAcessoFederacaoDTOReplicacao = new AcessoFederacaoDTO();
                $objAcessoFederacaoDTOReplicacao->setStrIdInstalacaoFederacaoDest($strIdInstalacaoFederacao);
                $objAcessoFederacaoDTOReplicacao->setStrIdProcedimentoFederacao($objProtocoloFederacaoDTO->getStrIdProtocoloFederacao());
                $this->replicarAcessos($objAcessoFederacaoDTOReplicacao);
              } catch (Exception $e) {
                $bolErroReplicacao = true;
              }
            }

            if (!$bolReplicarAcessosOnline || $bolErroReplicacao){
              $objReplicacaoFederacaoDTO = new ReplicacaoFederacaoDTO();
              $objReplicacaoFederacaoDTO->setStrIdInstalacaoFederacao($strIdInstalacaoFederacao);
              $objReplicacaoFederacaoDTO->setStrIdProtocoloFederacao($objProtocoloFederacaoDTO->getStrIdProtocoloFederacao());
              $objReplicacaoFederacaoDTO->setNumStaTipo(ReplicacaoFederacaoRN::$TRF_ACESSOS);
              $objReplicacaoFederacaoRN->agendar($objReplicacaoFederacaoDTO);
            }
          }
        }
      }

      return $objEnviarProcessoFederacaoDTORet;

    }catch(Exception $e){
      throw new InfraException('Erro enviando processo para Instala��es do SEI Federa��o.',$e);
    }
  }

  protected function concederAcessoInternoControlado(EnviarProcessoFederacaoDTO $objEnviarProcessoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_enviar', __METHOD__, $objEnviarProcessoFederacaoDTO);

      //recebe conjunto de instalacoes destinatarias contendo: IdInstalacaoFederacao, Sigla, Descricao
      $arrObjInstalacaoFederacaoDTO = $objEnviarProcessoFederacaoDTO->getArrObjInstalacaoFederacaoDTO();

      //recebe conjunto de orgaos destinatarios contendo: IdInstalacaoFederacao, IdOrgaoFederacao, Sigla, Descricao
      $arrObjOrgaoFederacaoDTO = InfraArray::indexarArrInfraDTO($objEnviarProcessoFederacaoDTO->getArrObjOrgaoFederacaoDTO(),'IdOrgaoFederacao');

      //recebe conjunto de unidades destinatarias contendo: IdInstalacaoFederacao, IdOrgaoFederacao, IdUnidadeFederacao, Sigla, Descricao
      $arrObjUnidadeFederacaoDTO = InfraArray::indexarArrInfraDTO($objEnviarProcessoFederacaoDTO->getArrObjUnidadeFederacaoDTO(),'IdUnidadeFederacao');

      //recebe conjunto de acessos destinatarios contendo: IdOrgaoFederacao, IdUnidadeFederacao
      $arrObjAcessoFederacaoDTO = InfraArray::indexarArrInfraDTO($objEnviarProcessoFederacaoDTO->getArrObjAcessoFederacaoDTO(), 'IdInstalacaoFederacaoDest', true);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objEnviarProcessoFederacaoDTO->getNumStaTipo() != self::$TAF_PROCESSO_ENVIADO_ORGAO) {
        $objInfraException->lancarValidacao('Tipo do envio inv�lido.');
      }

      if (count($objEnviarProcessoFederacaoDTO->getArrObjAcessoFederacaoDTO()) == 0) {
        $objInfraException->lancarValidacao('Nenhum acesso informado para envio.');
      }

      if (SessaoSEI::getInstance()->isBolHabilitada()) {

        if (InfraString::isBolVazia($objEnviarProcessoFederacaoDTO->getStrMotivo())) {
          $objInfraException->lancarValidacao('Motivo n�o informado.');
        }

        if (InfraString::isBolVazia($objEnviarProcessoFederacaoDTO->getStrSenha())) {
          $objInfraException->lancarValidacao('Senha n�o informada.');
        }

        $objInfraSip = new InfraSip(SessaoSEI::getInstance());
        $objInfraSip->autenticar(SessaoSEI::getInstance()->getNumIdOrgaoUsuario(),
                                 SessaoSEI::getInstance()->getNumIdContextoUsuario(),
                                 SessaoSEI::getInstance()->getStrSiglaUsuario(),
                                 $objEnviarProcessoFederacaoDTO->getStrSenha());
      }

      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->retStrDescricao();
      $objOrgaoDTO->retStrIdOrgaoFederacao();
      $objOrgaoDTO->retStrSinFederacaoEnvio();
      $objOrgaoDTO->setNumIdOrgao(SessaoSEI::getInstance()->getNumIdOrgaoUnidadeAtual());

      $objOrgaoRN = new OrgaoRN();
      $objOrgaoDTORemetente = $objOrgaoRN->consultarRN1352($objOrgaoDTO);

      if ($objOrgaoDTORemetente->getStrSinFederacaoEnvio()=='N'){
        $objInfraException->lancarValidacao('�rg�o '.$objOrgaoDTORemetente->getStrSigla().' da unidade atual n�o est� liberado para envio de processos pelo SEI Federa��o.');
      }

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->retStrSigla();
      $objUnidadeDTO->retStrDescricao();
      $objUnidadeDTO->retStrIdUnidadeFederacao();
      $objUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

      $objUnidadeRN = new UnidadeRN();
      $objUnidadeDTORemetente = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->retStrIdUsuarioFederacao();
      $objUsuarioDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTORemetente = $objUsuarioRN->consultarRN0489($objUsuarioDTO);

      //busca dados para valida��o e envio do processo
      $objProcedimentoDTO = new ProcedimentoDTO();
      $objProcedimentoDTO->retDblIdProcedimento();
      $objProcedimentoDTO->retStrProtocoloProcedimentoFormatado();
      $objProcedimentoDTO->retStrStaNivelAcessoGlobalProtocolo();
      $objProcedimentoDTO->retStrStaEstadoProtocolo();
      $objProcedimentoDTO->retNumIdTipoProcedimento();
      $objProcedimentoDTO->retStrNomeTipoProcedimento();
      $objProcedimentoDTO->retDtaGeracaoProtocolo();
      $objProcedimentoDTO->retStrDescricaoProtocolo();
      $objProcedimentoDTO->retStrIdProtocoloFederacaoProtocolo();
      $objProcedimentoDTO->setDblIdProcedimento($objEnviarProcessoFederacaoDTO->getDblIdProcedimento());

      $objProcedimentoRN = new ProcedimentoRN();
      $objProcedimentoDTO = $objProcedimentoRN->consultarRN0201($objProcedimentoDTO);

      if ($objProcedimentoDTO==null){
        throw new InfraException('Processo n�o encontrado.');
      }

      if ($objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo()==ProtocoloRN::$NA_SIGILOSO){
        $objInfraException->lancarValidacao('N�o � poss�vel enviar um processo sigiloso pelo SEI Federa��o.');
      }

      if ($objProcedimentoDTO->getStrStaEstadoProtocolo()==ProtocoloRN::$TE_PROCEDIMENTO_ANEXADO){
        $objInfraException->lancarValidacao('N�o � poss�vel enviar um processo anexado pelo SEI Federa��o.');
      }

      if ($objProcedimentoDTO->getStrStaEstadoProtocolo()==ProtocoloRN::$TE_PROCEDIMENTO_SOBRESTADO){
        $objInfraException->lancarValidacao('N�o � poss�vel enviar um processo sobrestado pelo SEI Federa��o.');
      }

      //Inicio: sincronizacao de instalacoes, orgaos e unidades (desnecessario, j� sincronizado na pesquisa)
      /*
      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      foreach($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO){
        $objInstalacaoFederacaoRN->sincronizar($objInstalacaoFederacaoDTO);
      }

      $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
      foreach($arrObjOrgaoFederacaoDTO as $objOrgaoFederacaoDTO){
        $objOrgaoFederacaoRN->sincronizar($objOrgaoFederacaoDTO);
      }

      $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
      foreach($arrObjUnidadeFederacaoDTO as $objUnidadeFederacaoDTO){
        $objUnidadeFederacaoRN->sincronizar($objUnidadeFederacaoDTO);
      }
      */
      //Fim: sincronizacao de �rg�os e unidades

      $arrIdInstalacoes = array_keys($arrObjInstalacaoFederacaoDTO);

      //busca dados complementares de cada instalacao
      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();
      $objInstalacaoFederacaoDTO->retDblCnpj();
      $objInstalacaoFederacaoDTO->retStrEndereco();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($arrIdInstalacoes, InfraDTO::$OPER_IN);
      $objInstalacaoFederacaoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $arrObjInstalacaoFederacaoDTOBanco = InfraArray::indexarArrInfraDTO($objInstalacaoFederacaoRN->listar($objInstalacaoFederacaoDTO),'IdInstalacaoFederacao');

      foreach($arrObjInstalacaoFederacaoDTO as $strIdInstalacaoFederacao => $objInstalacaoFederacaoDTO){

        if (!isset($arrObjInstalacaoFederacaoDTOBanco[$strIdInstalacaoFederacao])){
          $objInfraException->lancarValidacao('Instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' n�o encontrada na base de dados local.');
        }

        $arrObjInstalacaoFederacaoDTOBanco[$strIdInstalacaoFederacao]->setStrSeiFederacaoVersao($objInstalacaoFederacaoDTO->getStrSeiFederacaoVersao());
      }

      $arrObjInstalacaoFederacaoDTO = $arrObjInstalacaoFederacaoDTOBanco;

      $bolPrimeiroEnvio = false;

      //protocolo � originario desta instalacao
      if ($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo()==null) {

        //primeiro envio gera identificador
        $objProtocoloDTO = new ProtocoloDTO();
        $objProtocoloDTO->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());

        $objProtocoloRN = new ProtocoloRN();
        $objProtocoloRN->gerarIdentificadorFederacao($objProtocoloDTO);

        $objProcedimentoDTO->setStrIdProtocoloFederacaoProtocolo($objProtocoloDTO->getStrIdProtocoloFederacao());

        $bolPrimeiroEnvio = true;
      }

      //busca dados do SEI Federacao para este processo
      $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
      $objProtocoloFederacaoDTO->retStrIdProtocoloFederacao();
      $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
      $objProtocoloFederacaoDTO->retStrSiglaInstalacaoFederacao();
      $objProtocoloFederacaoDTO->retStrDescricaoInstalacaoFederacao();
      $objProtocoloFederacaoDTO->retStrProtocoloFormatado();
      $objProtocoloFederacaoDTO->retDblCnpjInstalacaoFederacao();
      $objProtocoloFederacaoDTO->retStrEnderecoInstalacaoFederacao();
      $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());

      $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
      $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

      // processo n�o � desta instala��o sincroniza com a origem
      if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()){
        try {
          $objAcessoFederacaoDTOReplicacao = new AcessoFederacaoDTO();
          $objAcessoFederacaoDTOReplicacao->setStrIdInstalacaoFederacaoDest($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao());
          $objAcessoFederacaoDTOReplicacao->setStrIdProcedimentoFederacao($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());
          $this->replicarAcessos($objAcessoFederacaoDTOReplicacao);
        }catch(Exception $e){
          throw new InfraException('N�o foi poss�vel realizar o envio.'."\n\n".'Erro sincronizando dados com a instala��o '.$objProtocoloFederacaoDTO->getStrSiglaInstalacaoFederacao().' origem do processo.', $e);
        }
      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());
      $arrIdOrgaoFederacaoAcesso = InfraArray::converterArrInfraDTO($this->obterOrgaosAcessoFederacao($objAcessoFederacaoDTO),'IdOrgaoFederacao');


      foreach($arrObjAcessoFederacaoDTO as $strIdInstalacaoFederacao => $arrObjAcessoFederacaoDTOPorInstalacao){
        foreach($arrObjAcessoFederacaoDTOPorInstalacao as $objAcessoFederacaoDTO) {
          if (in_array($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest(), $arrIdOrgaoFederacaoAcesso) && !$objInstalacaoFederacaoRN->verificarVersaoReenvio($objInstalacaoFederacaoDTO) ) {
            $objInfraException->lancarValidacao('O SEI da instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' ainda n�o permite novo envio para �rg�os que j� possuem acesso ao processo.');
          }
        }
      }

      if (!$bolPrimeiroEnvio &&
          $objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal() &&
          ($objOrgaoDTORemetente->getStrIdOrgaoFederacao() == null || !in_array($objOrgaoDTORemetente->getStrIdOrgaoFederacao(), $arrIdOrgaoFederacaoAcesso))) {
        $objInfraException->lancarValidacao('�rg�o '.$objOrgaoDTORemetente->getStrSigla().' n�o possui acesso ao processo pelo SEI Federa��o.');
      }


      //Inicio: montagem de dados do processo
      $objProcedimento = new stdClass();
      $objProcedimento->IdProcedimentoFederacao = $objProtocoloFederacaoDTO->getStrIdProtocoloFederacao();

      $objTipoProcedimento = new stdClass();
      $objTipoProcedimento->IdTipoProcedimento = $objProcedimentoDTO->getNumIdTipoProcedimento();
      $objTipoProcedimento->Nome = $objProcedimentoDTO->getStrNomeTipoProcedimento();

      $objProcedimento->TipoProcedimento = $objTipoProcedimento;
      $objProcedimento->ProtocoloFormatado = $objProcedimentoDTO->getStrProtocoloProcedimentoFormatado();
      $objProcedimento->DataAutuacao = $objProcedimentoDTO->getDtaGeracaoProtocolo();
      $objProcedimento->Especificacao = $objProcedimentoDTO->getStrDescricaoProtocolo();
      $objProcedimento->NivelAcesso = $objProcedimentoDTO->getStrStaNivelAcessoGlobalProtocolo();

      //busca interessados do processo
      $objParticipanteDTO = new ParticipanteDTO();
      $objParticipanteDTO->retStrSiglaContato();
      $objParticipanteDTO->retStrNomeContato();
      $objParticipanteDTO->retNumSequencia();
      $objParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_INTERESSADO);
      $objParticipanteDTO->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());
      $objParticipanteDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objParticipanteRN = new ParticipanteRN();
      $arrObjParticipanteDTO = $objParticipanteRN->listarRN0189($objParticipanteDTO);

      $arrInteressados = array();
      foreach($arrObjParticipanteDTO as $objParticipanteDTO){
        $objInteressado = new stdClass();
        $objInteressado->Sigla = $objParticipanteDTO->getStrSiglaContato();
        $objInteressado->Nome = $objParticipanteDTO->getStrNomeContato();
        $arrInteressados[] = $objInteressado;
      }
      $objProcedimento->Interessados = $arrInteressados;

      //Fim: montagem de dados do processo


      //instalacao origem
      $objInstalacaoOrigem = new stdClass();
      $objInstalacaoOrigem->IdInstalacaoFederacao = $objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao();
      $objInstalacaoOrigem->Sigla = $objProtocoloFederacaoDTO->getStrSiglaInstalacaoFederacao();
      $objInstalacaoOrigem->Descricao = $objProtocoloFederacaoDTO->getStrDescricaoInstalacaoFederacao();
      $objInstalacaoOrigem->Cnpj = $objProtocoloFederacaoDTO->getDblCnpjInstalacaoFederacao();
      $objInstalacaoOrigem->Endereco = $objProtocoloFederacaoDTO->getStrEnderecoInstalacaoFederacao();

      //monta dados do processo origem para envio
      $objProcedimentoOrigem = new stdClass();
      $objProcedimentoOrigem->IdProcedimentoFederacao = $objProtocoloFederacaoDTO->getStrIdProtocoloFederacao();
      $objProcedimentoOrigem->TipoProcedimento = null;
      $objProcedimentoOrigem->ProtocoloFormatado = $objProtocoloFederacaoDTO->getStrProtocoloFormatado();
      $objProcedimentoOrigem->DataAutuacao = null;
      $objProcedimentoOrigem->Especificacao = null;
      $objProcedimentoOrigem->NivelAcesso = null;
      $objProcedimentoOrigem->Interessados = null;

      $arrRet = array();

      $dthLiberacao = InfraData::getStrDataHoraAtual();

      $bolNovoEnvio = false;

      //faz envio �nico para todos os �rg�os ou todas as unidades destinatarias de cada instala��o
      foreach($arrObjInstalacaoFederacaoDTO as $strIdInstalacaoFederacao => $objInstalacaoFederacaoDTO){

        $objInstalacaoFederacaoDTO->setObjInfraException(null);

        $arrObjAcessos = array();

        //se enviando para unidade
        foreach($arrObjAcessoFederacaoDTO[$strIdInstalacaoFederacao] as $objAcessoFederacaoDTO){

          $objAcessoFederacaoDTO->setStrIdAcessoFederacao(InfraULID::gerar());

          $objAcessoFederacao = new stdClass();
          $objAcessoFederacao->IdAcessoFederacao = $objAcessoFederacaoDTO->getStrIdAcessoFederacao();
          $objAcessoFederacao->IdOrgaoFederacaoDest = $objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest();
          $objAcessoFederacao->IdUnidadeFederacaoDest = $objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest();
          $objAcessoFederacao->IdUsuarioFederacaoDest = $objAcessoFederacaoDTO->getStrIdUsuarioFederacaoDest();

          $arrObjAcessos[] = $objAcessoFederacao;
        }

        $ret = null;

        try {

          $ret = $objInstalacaoFederacaoRN->executar('concederAcesso',
                                                      $strIdInstalacaoFederacao,
                                                      $objProcedimento,
                                                      $objInstalacaoOrigem,
                                                      $objProcedimentoOrigem,
                                                      $arrObjAcessos,
                                                      $objEnviarProcessoFederacaoDTO->getNumStaTipo(),
                                                      $objEnviarProcessoFederacaoDTO->getStrMotivo(),
                                                      $dthLiberacao);

          if (!is_array($ret) || count($ret) != count($arrObjAcessos)){
            throw new InfraException('Valor inv�lido no retorno do servi�o de envio de processo para o SEI Federa��o.', null, print_r($ret, true));
          }

        } catch (Exception $e) {

          //se ocorreu erro sinaliza e loga
          try {
            $objInstalacaoFederacaoDTO->setObjInfraException($e);
            LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
          }catch(Exception $e2){}

        }

        //se n�o ocorreu erro no envio para a instalcao
        if ($objInstalacaoFederacaoDTO->getObjInfraException() == null) {

          //para cada acesso de �rg�o ou unidade destinatario
          foreach($arrObjAcessoFederacaoDTO[$strIdInstalacaoFederacao] as $objAcessoFederacaoDTO){

            if (!in_array($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest(), $arrIdOrgaoFederacaoAcesso)){
              $bolNovoEnvio = true;
            }

            if (!isset($arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()])){
              throw new InfraException('�rg�o '.$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest().' do SEI Federa��o n�o encontrado ap�s envio.');
            }

            $objOrgaoFederacaoDTO = $arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()];

            if (!isset($arrObjUnidadeFederacaoDTO[$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest()])) {
              throw new InfraException('Unidade '.$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest().' do SEI Federa��o n�o encontrada ap�s envio.');
            }

            $objUnidadeFederacaoDTO = $arrObjUnidadeFederacaoDTO[$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest()];

            $bolRetornou = false;
            foreach($ret as $objAcessoRemoto){
              if ($objAcessoFederacaoDTO->getStrIdAcessoFederacao() == $objAcessoRemoto->IdAcessoFederacao){
                $bolRetornou = true;
                break;
              }
            }

            if (!$bolRetornou){
              if ($objUnidadeFederacaoDTO==null){
                throw new InfraException('Acesso para o �rg�o '.$objOrgaoFederacaoDTO->getStrSigla().' na instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' n�o encontrado ap�s envio.');
              }else{
                throw new InfraException('Acesso para a unidade '.$objUnidadeFederacaoDTO->getStrSigla().'/'.$objOrgaoFederacaoDTO->getStrSigla().' na instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().' n�o encontrado ap�s envio.');
              }
            }


            $arrObjAtributoAndamentoDTO = array();

            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('ORGAO_REMETENTE');
            $objAtributoAndamentoDTO->setStrValor($objOrgaoDTORemetente->getStrSigla().'�'.$objOrgaoDTORemetente->getStrDescricao());
            $objAtributoAndamentoDTO->setStrIdOrigem($objOrgaoDTORemetente->getStrIdOrgaoFederacao());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('UNIDADE_REMETENTE');
            $objAtributoAndamentoDTO->setStrValor($objUnidadeDTORemetente->getStrSigla().'�'.$objUnidadeDTORemetente->getStrDescricao());
            $objAtributoAndamentoDTO->setStrIdOrigem($objUnidadeDTORemetente->getStrIdUnidadeFederacao());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('ORGAO_DESTINATARIO');
            $objAtributoAndamentoDTO->setStrValor($objOrgaoFederacaoDTO->getStrSigla().'�'.$objOrgaoFederacaoDTO->getStrDescricao());
            $objAtributoAndamentoDTO->setStrIdOrigem($objOrgaoFederacaoDTO->getStrIdOrgaoFederacao());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('UNIDADE_DESTINATARIA');
            $objAtributoAndamentoDTO->setStrValor($objUnidadeFederacaoDTO->getStrSigla().'�'.$objUnidadeFederacaoDTO->getStrDescricao());
            $objAtributoAndamentoDTO->setStrIdOrigem($objUnidadeFederacaoDTO->getStrIdUnidadeFederacao());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('MOTIVO');
            $objAtributoAndamentoDTO->setStrValor($objEnviarProcessoFederacaoDTO->getStrMotivo());
            $objAtributoAndamentoDTO->setStrIdOrigem($objAcessoFederacaoDTO->getStrIdAcessoFederacao());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

            $objAtividadeDTO = new AtividadeDTO();
            $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO);
            $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);
            $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
            $objAtividadeDTO->setDblIdProtocolo($objEnviarProcessoFederacaoDTO->getDblIdProcedimento());

            $objAtividadeRN = new AtividadeRN();
            $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);

            $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoRem($objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal());
            $objAcessoFederacaoDTO->setStrIdOrgaoFederacaoRem($objOrgaoDTORemetente->getStrIdOrgaoFederacao());
            $objAcessoFederacaoDTO->setStrIdUnidadeFederacaoRem($objUnidadeDTORemetente->getStrIdUnidadeFederacao());
            $objAcessoFederacaoDTO->setStrIdUsuarioFederacaoRem($objUsuarioDTORemetente->getStrIdUsuarioFederacao());
            $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProtocoloFederacaoDTO->getStrIdProtocoloFederacao());
            $objAcessoFederacaoDTO->setStrIdDocumentoFederacao(null);
            $objAcessoFederacaoDTO->setDthLiberacao($dthLiberacao);
            $objAcessoFederacaoDTO->setStrMotivoLiberacao($objEnviarProcessoFederacaoDTO->getStrMotivo());
            $objAcessoFederacaoDTO->setDthCancelamento(null);
            $objAcessoFederacaoDTO->setStrMotivoCancelamento(null);
            $objAcessoFederacaoDTO->setNumStaTipo($objEnviarProcessoFederacaoDTO->getNumStaTipo());
            $objAcessoFederacaoDTO->setStrSinAtivo('S');

            $arrRet[] = $this->cadastrar($objAcessoFederacaoDTO);
          }
        }
      }

      if (!$bolPrimeiroEnvio && $bolNovoEnvio){
        $objAtividadeDTO = new AtividadeDTO();
        $objAtividadeDTO->setDblIdProtocolo($objEnviarProcessoFederacaoDTO->getDblIdProcedimento());
        $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $objAtividadeDTO->setNumTipoVisualizacao(AtividadeRN::$TV_ENVIO_FEDERACAO);

        $objAtividadeRN = new AtividadeRN();
        $objAtividadeRN->atualizarVisualizacao($objAtividadeDTO);
      }

      $objEnviarProcessoFederacaoDTORet = new EnviarProcessoFederacaoDTO();
      $objEnviarProcessoFederacaoDTORet->setArrObjInstalacaoFederacaoDTO($arrObjInstalacaoFederacaoDTO);
      $objEnviarProcessoFederacaoDTORet->setArrObjAcessoFederacaoDTO($arrRet);
      $objEnviarProcessoFederacaoDTORet->setObjProtocoloFederacaoDTO($objProtocoloFederacaoDTO);
      return $objEnviarProcessoFederacaoDTORet;

    }catch(Exception $e){
      throw new InfraException('Erro enviando processo para Instala��es do SEI Federa��o.',$e);
    }
  }

  protected function processarConcessaoAcessoConectado(ReceberProcessoFederacaoDTO $objReceberProcessoFederacaoDTO){
    $bolAcumulacaoPrevia = FeedSEIProtocolos::getInstance()->isBolAcumularFeeds();

    FeedSEIProtocolos::getInstance()->setBolAcumularFeeds(true);

    $ret = $this->processarConcessaoAcessoInterno($objReceberProcessoFederacaoDTO);

    if (!$bolAcumulacaoPrevia){
      FeedSEIProtocolos::getInstance()->setBolAcumularFeeds(false);
      FeedSEIProtocolos::getInstance()->indexarFeeds();
    }
    return $ret;
  }

  protected function processarConcessaoAcessoInternoControlado(ReceberProcessoFederacaoDTO $objReceberProcessoFederacaoDTO){
    try{

      $objSeiRN = new SeiRN();

      $objInfraException = new InfraException();

      $objInfraParametro = new InfraParametro(BancoSEI::getInstance());

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $strSiglaInstalacaoRemota = $objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal();

      $objInstalacaoFederacaoDTORemetente = $objReceberProcessoFederacaoDTO->getObjInstalacaoFederacaoDTORemetente();
      $objOrgaoFederacaoDTORemetente = $objReceberProcessoFederacaoDTO->getObjOrgaoFederacaoDTORemetente();
      $objUnidadeFederacaoDTORemetente = $objReceberProcessoFederacaoDTO->getObjUnidadeFederacaoDTORemetente();
      $objUsuarioFederacaoDTORemetente = $objReceberProcessoFederacaoDTO->getObjUsuarioFederacaoDTORemetente();
      $objProcedimentoDTORemoto = $objReceberProcessoFederacaoDTO->getObjProcedimentoDTO();
      $objInstalacaoFederacaoDTOOrigem = $objReceberProcessoFederacaoDTO->getObjInstalacaoFederacaoDTOOrigem();
      $objProcedimentoDTOOrigem = $objReceberProcessoFederacaoDTO->getObjProcedimentoDTOOrigem();
      $arrObjAcessoFederacaoDTORemoto = $objReceberProcessoFederacaoDTO->getArrObjAcessoFederacaoDTO();
      $arrIdOrgaoFederacaoDestinatario = array_unique(InfraArray::converterArrInfraDTO($arrObjAcessoFederacaoDTORemoto,'IdOrgaoFederacaoDest'));
      $arrIdUnidadeFederacaoDestinataria = array_unique(InfraArray::converterArrInfraDTO($arrObjAcessoFederacaoDTORemoto,'IdUnidadeFederacaoDest'));

      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->setBolExclusaoLogica(false);
      $objOrgaoDTO->retNumIdOrgao();
      $objOrgaoDTO->retStrIdOrgaoFederacao();
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->retStrDescricao();
      $objOrgaoDTO->retStrSinFederacaoRecebimento();
      $objOrgaoDTO->retNumIdUnidade();
      $objOrgaoDTO->retStrSinAtivo();
      $objOrgaoDTO->setStrIdOrgaoFederacao($arrIdOrgaoFederacaoDestinatario, InfraDTO::$OPER_IN);
      $objOrgaoDTO->setOrdNumIdOrgao(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objOrgaoRN = new OrgaoRN();
      $arrObjOrgaoDTO = InfraArray::indexarArrInfraDTO($objOrgaoRN->listarRN1353($objOrgaoDTO),'IdOrgaoFederacao');

      //verifica se todos os orgaos destinatarios existem na base
      foreach($arrIdOrgaoFederacaoDestinatario as $strIdOrgaoFederacao){
        if (!isset($arrObjOrgaoDTO[$strIdOrgaoFederacao])){
          throw new InfraException('�rg�o destinat�rio '.$strIdOrgaoFederacao.' n�o encontrado na instala��o '.$strSiglaInstalacaoRemota.'.');
        }
      }

      //valida orgaos destinatarios
      foreach($arrObjOrgaoDTO as $objOrgaoDTO){

        if ($objOrgaoDTO->getStrSinFederacaoRecebimento() == 'N') {
          $objInfraException->adicionarValidacao('�rg�o '.$objOrgaoDTO->getStrSigla().' da instala��o '.$strSiglaInstalacaoRemota.' n�o est� habilitado para recebimento de processos pelo SEI Federa��o.');
        }

        if ($objOrgaoDTO->getNumIdUnidade() == null) {
          $objInfraException->adicionarValidacao('�rg�o '.$objOrgaoDTO->getStrSigla().' da instala��o '.$strSiglaInstalacaoRemota.' n�o possui unidade padr�o para recebimento de processos configurada para o SEI Federa��o.');
        }

        if ($objOrgaoDTO->getStrSinAtivo() == 'N'){
          $objInfraException->adicionarValidacao('�rg�o '.$objOrgaoDTO->getStrSigla().' da instala��o '.$strSiglaInstalacaoRemota.' est� desativado.');
        }
      }

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->setBolExclusaoLogica(false);
      $objUnidadeDTO->retStrIdOrgaoFederacao();
      $objUnidadeDTO->retStrIdUnidadeFederacao();
      $objUnidadeDTO->retNumIdUnidade();
      $objUnidadeDTO->retStrSigla();
      $objUnidadeDTO->retStrDescricao();
      $objUnidadeDTO->retNumIdOrgao();
      $objUnidadeDTO->retStrSiglaOrgao();
      $objUnidadeDTO->retStrSinAtivo();
      $objUnidadeDTO->setStrIdUnidadeFederacao($arrIdUnidadeFederacaoDestinataria, InfraDTO::$OPER_IN);
      $objUnidadeDTO->setOrdNumIdOrgao(InfraDTO::$TIPO_ORDENACAO_ASC);
      $objUnidadeDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objUnidadeRN = new UnidadeRN();

      $arrObjUnidadeDTO = InfraArray::indexarArrInfraDTO($objUnidadeRN->listarRN0127($objUnidadeDTO), 'IdUnidadeFederacao');

      //verifica se todas as unidades destinatarias existem na base
      foreach ($arrIdUnidadeFederacaoDestinataria as $strIdUnidadeFederacao) {
        if (!isset($arrObjUnidadeDTO[$strIdUnidadeFederacao])) {
          $objInfraException->lancarValidacao('Unidade com identificador '.$strIdUnidadeFederacao.' do SEI Federa��o n�o encontrada na instala��o '.$strSiglaInstalacaoRemota.'.');
        }
      }


      $numTipoRecebimento = ConfiguracaoSEI::getInstance()->getValor('Federacao', 'TipoRecebimento', false, 1);

      if ($numTipoRecebimento == 1) {

        foreach ($arrObjAcessoFederacaoDTORemoto as $objAcessoFederacaoDTO) {
          $objOrgaoDTO = $arrObjOrgaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()];
          $objUnidadeDTO = $arrObjUnidadeDTO[$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest()];

          if ($objOrgaoDTO->getNumIdUnidade() != $objUnidadeDTO->getNumIdUnidade()) {
            $objInfraException->lancarValidacao('Unidade padr�o para recebimento de processos do �rg�o '.$objOrgaoDTO->getStrSigla().' na instala��o '.$strSiglaInstalacaoRemota.' foi alterada antes do envio.');
          }
        }

        foreach ($arrObjUnidadeDTO as $objUnidadeDTO) {
          if ($objUnidadeDTO->getStrSinAtivo() == 'N') {
            $objInfraException->lancarValidacao('Unidade '.$objUnidadeDTO->getStrSigla().' padr�o para recebimento de processos do �rg�o '.$objUnidadeDTO->getStrSiglaOrgao().' na instala��o '.$strSiglaInstalacaoRemota.' est� desativada.');
          }
        }
      }

      $arrIdUnidadesEnvio = array();

      $objProcedimentoDTO = new ProcedimentoDTO();
      $objProcedimentoDTO->retDblIdProcedimento();
      $objProcedimentoDTO->setStrIdProtocoloFederacaoProtocolo($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

      $objProcedimentoRN = new ProcedimentoRN();
      $objProcedimentoDTO = $objProcedimentoRN->consultarRN0201($objProcedimentoDTO);

      //se � primeira vez que o processo � recebido nesta instalacao
      if ($objProcedimentoDTO == null) {

        //simula login na primeira unidade
        SessaoSEI::getInstance()->simularLogin(SessaoSEI::$USUARIO_SEI, null, null, array_values($arrObjUnidadeDTO)[0]->getNumIdUnidade());

        if ($objInstalacaoFederacaoDTOOrigem->getStrIdInstalacaoFederacao()!=$objInstalacaoFederacaoDTORemetente->getStrIdInstalacaoFederacao()) {

          //verifica se a instalacao origem do processo (que pode n�o ser a remetente) esta cadastrada
          $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
          $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
          $objInstalacaoFederacaoDTO->retDblCnpj();
          $objInstalacaoFederacaoDTO->retStrEndereco();
          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOOrigem->getStrIdInstalacaoFederacao());

          $objInstalacaoFederacaoDTO = $objInstalacaoFederacaoRN->consultar($objInstalacaoFederacaoDTO);

          if ($objInstalacaoFederacaoDTO == null) {

            $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
            $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOOrigem->getStrIdInstalacaoFederacao());
            $objInstalacaoFederacaoDTO->setDblCnpj($objInstalacaoFederacaoDTOOrigem->getDblCnpj());
            $objInstalacaoFederacaoDTO->setStrSigla($objInstalacaoFederacaoDTOOrigem->getStrSigla());
            $objInstalacaoFederacaoDTO->setStrDescricao($objInstalacaoFederacaoDTOOrigem->getStrDescricao());
            $objInstalacaoFederacaoDTO->setStrEndereco($objInstalacaoFederacaoDTOOrigem->getStrEndereco());
            $objInstalacaoFederacaoDTO->setStrStaTipo(InstalacaoFederacaoRN::$TI_REPLICADA);
            $objInstalacaoFederacaoDTO->setStrStaEstado(InstalacaoFederacaoRN::$EI_ANALISE);
            $objInstalacaoFederacaoDTO->setStrStaAgendamento(InstalacaoFederacaoRN::$AI_NENHUM);
            $objInstalacaoFederacaoDTO->setStrSinAtivo('S');
            $objInstalacaoFederacaoRN->cadastrar($objInstalacaoFederacaoDTO);


            $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
            $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
            $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTO->getStrStaEstado());
            $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_REPLICACAO);

            $arrObjAtributoInstalacaoDTO = array();

            $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
            $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
            $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTORemetente->getStrSigla()."�".$objInstalacaoFederacaoDTORemetente->getStrDescricao());
            $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTORemetente->getStrIdInstalacaoFederacao());
            $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

            $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
            $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO_REPLICADA');
            $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTO->getStrSigla()."�".$objInstalacaoFederacaoDTO->getStrDescricao());
            $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
            $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

            $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

            $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
            $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);

          }else {

            if ($objInstalacaoFederacaoDTO->getDblCnpj() != $objInstalacaoFederacaoDTOOrigem->getDblCnpj()) {
              $objInfraException->lancarValidacao('O CNPJ da instala��o '.$objInstalacaoFederacaoDTOOrigem->getStrSigla().' origem do processo � diferente na instala��o '.$strSiglaInstalacaoRemota.'.');
            }

            if ($objInstalacaoFederacaoDTO->getStrEndereco() != $objInstalacaoFederacaoDTOOrigem->getStrEndereco()) {
              $objInfraException->lancarValidacao('O endere�o da instala��o '.$objInstalacaoFederacaoDTOOrigem->getStrSigla().' origem do processo � diferente na instala��o '.$strSiglaInstalacaoRemota.'.');
            }
          }
        }

        //gera registro indicando o processo e a instalacao origem
        $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
        $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());
        $objProtocoloFederacaoDTO->setStrProtocoloFormatado($objProcedimentoDTOOrigem->getStrProtocoloProcedimentoFormatado());
        $objProtocoloFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOOrigem->getStrIdInstalacaoFederacao());

        $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
        $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->cadastrar($objProtocoloFederacaoDTO);


        //busca dados e valida o tipo de processo federacao

        $numIdTipoProcedimentoFederacao = $objInfraParametro->getValor('SEI_ID_TIPO_PROCEDIMENTO_FEDERACAO', false);

        if (InfraString::isBolVazia($numIdTipoProcedimentoFederacao)){
          $objInfraException->lancarValidacao('Tipo de processo do SEI Federa��o n�o configurado na instala��o '.$strSiglaInstalacaoRemota.'.');
        }

        $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
        $objTipoProcedimentoDTO->setBolExclusaoLogica(false);
        $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
        $objTipoProcedimentoDTO->retStrStaNivelAcessoSugestao();
        $objTipoProcedimentoDTO->retStrStaGrauSigiloSugestao();
        $objTipoProcedimentoDTO->retNumIdHipoteseLegalSugestao();
        $objTipoProcedimentoDTO->retStrNome();
        $objTipoProcedimentoDTO->retStrSinAtivo();
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($numIdTipoProcedimentoFederacao);

        $objTipoProcedimentoRN = new TipoProcedimentoRN();
        $objTipoProcedimentoDTO = $objTipoProcedimentoRN->consultarRN0267($objTipoProcedimentoDTO);

        if ($objTipoProcedimentoDTO == null){
          $objInfraException->lancarValidacao('Tipo de processo do SEI Federa��o n�o encontrado na instala��o '.$strSiglaInstalacaoRemota.'.');
        }

        if ($objTipoProcedimentoDTO->getStrSinAtivo() == 'N'){
          $objInfraException->lancarValidacao('Tipo de processo do SEI Federa��o desativado na instala��o '.$strSiglaInstalacaoRemota.'.');
        }

        if ($objTipoProcedimentoDTO->getStrStaNivelAcessoSugestao() == ProtocoloRN::$NA_SIGILOSO){
          $objInfraException->lancarValidacao('Tipo de processo do SEI Federa��o possui n�vel de acesso sugerido como sigiloso na instala��o '.$strSiglaInstalacaoRemota.'.');
        }

        $objRelTipoProcedimentoAssuntoDTO = new RelTipoProcedimentoAssuntoDTO();
        $objRelTipoProcedimentoAssuntoDTO->retNumIdAssunto();
        $objRelTipoProcedimentoAssuntoDTO->retNumSequencia();
        $objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($numIdTipoProcedimentoFederacao);

        $objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
        $arrObjRelTipoProcedimentoAssuntoDTO = $objRelTipoProcedimentoAssuntoRN->listarRN0192($objRelTipoProcedimentoAssuntoDTO);

        //configurado para verificar nomes de tipos iguais
        if (trim($objInfraParametro->getValor('SEI_FEDERACAO_NOME_TIPO_PROCESSO',false,'0')) == '1'){
          $objTipoProcedimentoDTOPorNome = new TipoProcedimentoDTO();
          $objTipoProcedimentoDTOPorNome->setNumMaxRegistrosRetorno(1);
          $objTipoProcedimentoDTOPorNome->setBolExclusaoLogica(false);
          $objTipoProcedimentoDTOPorNome->retNumIdTipoProcedimento();
          $objTipoProcedimentoDTOPorNome->retStrStaNivelAcessoSugestao();
          $objTipoProcedimentoDTOPorNome->retStrStaGrauSigiloSugestao();
          $objTipoProcedimentoDTOPorNome->retNumIdHipoteseLegalSugestao();
          $objTipoProcedimentoDTOPorNome->retStrSinIndividual();
          $objTipoProcedimentoDTOPorNome->retStrNome();
          $objTipoProcedimentoDTOPorNome->retStrSinAtivo();
          $objTipoProcedimentoDTOPorNome->setStrNome($objProcedimentoDTORemoto->getStrNomeTipoProcedimento());
          $objTipoProcedimentoDTOPorNome->setOrdStrSinAtivo(InfraDTO::$TIPO_ORDENACAO_DESC);
          $objTipoProcedimentoDTOPorNome = $objTipoProcedimentoRN->consultarRN0267($objTipoProcedimentoDTOPorNome);

          //se o tipo n�o � individual e
          //n�o � n�vel de acesso restrito com sugest�o de hip�tese legal nula e hip�tese legal obrigat�ria
          if ($objTipoProcedimentoDTOPorNome!=null &&
              $objTipoProcedimentoDTOPorNome->getStrSinIndividual()!='S' &&
              !($objProcedimentoDTORemoto->getStrStaNivelAcessoLocalProtocolo()==ProtocoloRN::$NA_RESTRITO && $objTipoProcedimentoDTOPorNome->getNumIdHipoteseLegalSugestao()==null && trim($objInfraParametro->getValor('SEI_HABILITAR_HIPOTESE_LEGAL')) == '2')) {

            //verificar se o tipo aceita o n�vel de acesso
            $objNivelAcessoPermitidoDTO = new NivelAcessoPermitidoDTO();
            $objNivelAcessoPermitidoDTO->retNumIdNivelAcessoPermitido();
            $objNivelAcessoPermitidoDTO->setStrStaNivelAcesso($objProcedimentoDTORemoto->getStrStaNivelAcessoLocalProtocolo());
            $objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTOPorNome->getNumIdTipoProcedimento());
            $objNivelAcessoPermitidoDTO->setNumMaxRegistrosRetorno(1);

            $objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
            if ($objNivelAcessoPermitidoRN->consultar($objNivelAcessoPermitidoDTO) != null) {

              //verificar se o tipo possui assuntos definidos
              $objRelTipoProcedimentoAssuntoDTO = new RelTipoProcedimentoAssuntoDTO();
              $objRelTipoProcedimentoAssuntoDTO->retNumIdAssunto();
              $objRelTipoProcedimentoAssuntoDTO->retNumSequencia();
              $objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTOPorNome->getNumIdTipoProcedimento());

              $objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
              $arrObjRelTipoProcedimentoAssuntoDTOPorNome = $objRelTipoProcedimentoAssuntoRN->listarRN0192($objRelTipoProcedimentoAssuntoDTO);

              if (count($arrObjRelTipoProcedimentoAssuntoDTOPorNome)) {
                $objTipoProcedimentoDTO = $objTipoProcedimentoDTOPorNome;
                $arrObjRelTipoProcedimentoAssuntoDTO = $arrObjRelTipoProcedimentoAssuntoDTOPorNome;
              }
            }
          }
        }

        //processo
        $objProcedimentoDTO = new ProcedimentoDTO();
        $objProcedimentoDTO->setDblIdProcedimento(null);
        $objProcedimentoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
        $objProcedimentoDTO->setStrSinGerarPendencia('S');

        //protocolo
        $objProtocoloDTO = new ProtocoloDTO();
        $objProtocoloDTO->setStrStaProtocolo(ProtocoloRN::$TP_PROCEDIMENTO);
        $objProtocoloDTO->setStrIdProtocoloFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());
        $objProtocoloDTO->setNumIdUnidadeGeradora(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $objProtocoloDTO->setNumIdUsuarioGerador(SessaoSEI::getInstance()->getNumIdUsuario());

        $objProtocoloDTO->setStrDescricao($objProcedimentoDTORemoto->getStrDescricaoProtocolo());
        $objProtocoloDTO->setDtaGeracao($objProcedimentoDTORemoto->getDtaGeracaoProtocolo());
        $objProtocoloDTO->setStrIdProtocoloFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

        //verifica se o n�vel de acesso recebido da instalacao remetente esta permitido para o tipo de processo federacao local
        $objNivelAcessoPermitidoDTO = new NivelAcessoPermitidoDTO();
        $objNivelAcessoPermitidoDTO->retNumIdNivelAcessoPermitido();
        $objNivelAcessoPermitidoDTO->setStrStaNivelAcesso($objProcedimentoDTORemoto->getStrStaNivelAcessoLocalProtocolo());
        $objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
        $objNivelAcessoPermitidoDTO->setNumMaxRegistrosRetorno(1);

        $objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
        if ($objNivelAcessoPermitidoRN->consultar($objNivelAcessoPermitidoDTO)!=null){
          //nivel recebido permitido localmente
          $objProtocoloDTO->setStrStaNivelAcessoLocal($objProcedimentoDTORemoto->getStrStaNivelAcessoLocalProtocolo());
        }else{
          //assume o n�vel de acesso sugerido para o tipo
          $objProtocoloDTO->setStrStaNivelAcessoLocal($objTipoProcedimentoDTO->getStrStaNivelAcessoSugestao());
        }

        $objProtocoloDTO->setStrStaGrauSigilo(null);

        if ($objProtocoloDTO->getStrStaNivelAcessoLocal()==ProtocoloRN::$NA_PUBLICO){
          $objProtocoloDTO->setNumIdHipoteseLegal(null);
        }else {
          $objProtocoloDTO->setNumIdHipoteseLegal($objTipoProcedimentoDTO->getNumIdHipoteseLegalSugestao());
        }

        //configurado para, se poss�vel, manter o n�mero do processo recebido
        if (trim($objInfraParametro->getValor('SEI_FEDERACAO_NUMERO_PROCESSO')) == '1'){
          $objProtocoloDTONumero = new ProtocoloDTO();
          $objProtocoloDTONumero->retDblIdProtocolo();
          $objProtocoloDTONumero->setStrProtocoloFormatado($objProcedimentoDTOOrigem->getStrProtocoloProcedimentoFormatado());

          $objProtocoloRN = new ProtocoloRN();
          if ($objProtocoloRN->consultarRN0186($objProtocoloDTONumero)==null){
            $objProtocoloDTO->setStrProtocoloFormatado($objProcedimentoDTOOrigem->getStrProtocoloProcedimentoFormatado());
          }
        }

        $objProtocoloDTO->setArrObjParticipanteDTO($this->prepararInteressados($objProcedimentoDTORemoto->getArrObjParticipanteDTO()));

        $arrObjAssuntoDTO = array();
        foreach($arrObjRelTipoProcedimentoAssuntoDTO as $objRelTipoProcedimentoAssuntoDTO){
          $objRelProtocoloAssuntoDTO = new RelProtocoloAssuntoDTO();
          $objRelProtocoloAssuntoDTO->setNumIdAssunto($objRelTipoProcedimentoAssuntoDTO->getNumIdAssunto());
          $objRelProtocoloAssuntoDTO->setNumSequencia($objRelTipoProcedimentoAssuntoDTO->getNumSequencia());
          $arrObjAssuntoDTO[] = $objRelProtocoloAssuntoDTO;
        }
        $objProtocoloDTO->setArrObjRelProtocoloAssuntoDTO($arrObjAssuntoDTO);

        /*
        //adiciona o contato cadastrado como interessado
        $objParticipanteDTO = new ParticipanteDTO();
        $objParticipanteDTO->setNumIdContato($objContatoDTO->getNumIdContato());
        $objParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_INTERESSADO);
        $objParticipanteDTO->setNumSequencia(0);
        $objProtocoloDTO->setArrObjParticipanteDTO(array($objParticipanteDTO));
        */

        $objProtocoloDTO->setArrObjParticipanteDTO(array());
        $objProtocoloDTO->setArrObjObservacaoDTO(array());
        $objProcedimentoDTO->setObjProtocoloDTO($objProtocoloDTO);

        $objProcedimentoRN = new ProcedimentoRN();
        $objProcedimentoDTO = $objProcedimentoRN->gerarRN0156($objProcedimentoDTO);

        //muda processo da coluna gerados para recebidos
        $objAtividadeDTOGeracao = new AtividadeDTO();
        $objAtividadeDTOGeracao->retNumIdAtividade();
        $objAtividadeDTOGeracao->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());
        $objAtividadeDTOGeracao->setNumIdTarefa(TarefaRN::$TI_GERACAO_PROCEDIMENTO);

        $objAtividadeRN = new AtividadeRN();
        $objAtividadeDTOGeracao = $objAtividadeRN->consultarRN0033($objAtividadeDTOGeracao);
        $objAtividadeDTOGeracao->setStrSinInicial('N');
        $objAtividadeRN->alterarCondicaoGeradoRecebido($objAtividadeDTOGeracao);

        $arrIdUnidadesEnvio = InfraArray::converterArrInfraDTO($arrObjUnidadeDTO, 'IdUnidade');

        //remove primeira unidade do array
        array_shift($arrIdUnidadesEnvio);

      }else{

        $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
        $objProtocoloFederacaoDTO->retStrIdProtocoloFederacao();
        $objProtocoloFederacaoDTO->retStrProtocoloFormatado();
        $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
        $objProtocoloFederacaoDTO->retDblCnpjInstalacaoFederacao();
        $objProtocoloFederacaoDTO->retStrEnderecoInstalacaoFederacao();
        $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

        $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
        $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

        //valida dados de origem e n�mero
        if ($objInstalacaoFederacaoDTOOrigem->getDblCnpj() != $objProtocoloFederacaoDTO->getDblCnpjInstalacaoFederacao()){
          $objInfraException->lancarValidacao('CNPJ da Instala��o origem do processo '.InfraUtil::formatarCnpj($objInstalacaoFederacaoDTOOrigem->getDblCnpj()).' n�o corresponde ao registrado na instala��o '.$strSiglaInstalacaoRemota.' '.InfraUtil::formatarCnpj($objProtocoloFederacaoDTO->getDblCnpjInstalacaoFederacao()).'.');
        }

        if ($objInstalacaoFederacaoDTOOrigem->getStrEndereco() != $objProtocoloFederacaoDTO->getStrEnderecoInstalacaoFederacao()) {
          $objInfraException->lancarValidacao('Endere�o da Instala��o origem do processo '.$objInstalacaoFederacaoDTOOrigem->getStrEndereco().' diferente do registrado na instala��o '.$strSiglaInstalacaoRemota.' '.$objProtocoloFederacaoDTO->getStrEnderecoInstalacaoFederacao().'.');
        }

        if ($objProcedimentoDTOOrigem->getStrProtocoloProcedimentoFormatado() != $objProtocoloFederacaoDTO->getStrProtocoloFormatado()){
          $objInfraException->lancarValidacao('Protocolo origem do processo '.$objProcedimentoDTOOrigem->getStrProtocoloProcedimentoFormatado().' n�o corresponde ao registrado na instala��o '.$strSiglaInstalacaoRemota.' '.$objProtocoloFederacaoDTO->getStrProtocoloFormatado().'.');
        }


        //posiciona na unidade que gerou o processo da primeira vez
        $objAtividadeDTO = new AtividadeDTO();
        $objAtividadeDTO->retNumIdUnidadeOrigem();
        $objAtividadeDTO->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());
        $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_GERACAO_PROCEDIMENTO);

        $objAtividadeRN = new AtividadeRN();
        $objAtividadeDTO = $objAtividadeRN->consultarRN0033($objAtividadeDTO);

        SessaoSEI::getInstance()->simularLogin(SessaoSEI::$USUARIO_SEI, null, null, $objAtividadeDTO->getNumIdUnidadeOrigem());

        //verifica se esta aberto na unidade geradora
        $objPesquisaPendenciaDTO = new PesquisaPendenciaDTO();
        $objPesquisaPendenciaDTO->setDblIdProtocolo(array($objProcedimentoDTO->getDblIdProcedimento()));
        $objPesquisaPendenciaDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
        $objPesquisaPendenciaDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $arrObjProcedimentoDTO = $objAtividadeRN->listarPendenciasRN0754($objPesquisaPendenciaDTO);

        //se n�o esta aberto na unidade geradora entao reabre e envia concluindo para a unidade federacao
        if (InfraArray::contar($arrObjProcedimentoDTO) == 0) {

          $objEntradaReabrirProcessoAPI = new EntradaReabrirProcessoAPI();
          $objEntradaReabrirProcessoAPI->setIdProcedimento($objProcedimentoDTO->getDblIdProcedimento());
          $objSeiRN->reabrirProcesso($objEntradaReabrirProcessoAPI);
        }

        foreach ($arrObjUnidadeDTO as $objUnidadeDTO) {
          if ($objUnidadeDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            $arrIdUnidadesEnvio[] = $objUnidadeDTO->getNumIdUnidade();
          }
        }
      }

      //replica dados do �rg�o remetente na instalacao atual criado/alterando registro em orgao_federacao
      $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
      $objOrgaoFederacaoRN->sincronizar($objOrgaoFederacaoDTORemetente);

      //replica dados da unidade remetente na instalacao atual criado/alterando registro em unidade_federacao
      $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
      $objUnidadeFederacaoRN->sincronizar($objUnidadeFederacaoDTORemetente);

      $arrObjAcessoFederacaoDTO = array();

      //gerar acessos para os orgaos
      foreach($arrObjAcessoFederacaoDTORemoto as $objAcessoFederacaoDTORemoto){

        //lanca andamento no processo
        $arrObjAtributoAndamentoDTO = array();

        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('ORGAO_REMETENTE');
        $objAtributoAndamentoDTO->setStrValor($objOrgaoFederacaoDTORemetente->getStrSigla().'�'.$objOrgaoFederacaoDTORemetente->getStrDescricao());
        $objAtributoAndamentoDTO->setStrIdOrigem($objOrgaoFederacaoDTORemetente->getStrIdOrgaoFederacao());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('UNIDADE_REMETENTE');
        $objAtributoAndamentoDTO->setStrValor($objUnidadeFederacaoDTORemetente->getStrSigla().'�'.$objUnidadeFederacaoDTORemetente->getStrDescricao());
        $objAtributoAndamentoDTO->setStrIdOrigem($objUnidadeFederacaoDTORemetente->getStrIdUnidadeFederacao());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

        //obtem dados do orgao destinatario
        if (!isset($arrObjOrgaoDTO[$objAcessoFederacaoDTORemoto->getStrIdOrgaoFederacaoDest()])){
          throw new InfraException('�rg�o '.$objAcessoFederacaoDTORemoto->getStrIdOrgaoFederacaoDest().' n�o encontrado para lan�amento de andamento.');
        }

        $objOrgaoDTO = $arrObjOrgaoDTO[$objAcessoFederacaoDTORemoto->getStrIdOrgaoFederacaoDest()];

        //obtem dados da unidade destinataria
        if (!isset($arrObjUnidadeDTO[$objAcessoFederacaoDTORemoto->getStrIdUnidadeFederacaoDest()])){
          throw new InfraException('Unidade '.$objAcessoFederacaoDTORemoto->getStrIdUnidadeFederacaoDest().' n�o encontrada para lan�amento de andamento.');
        }

        $objUnidadeDTO = $arrObjUnidadeDTO[$objAcessoFederacaoDTORemoto->getStrIdUnidadeFederacaoDest()];

        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('ORGAO_DESTINATARIO');
        $objAtributoAndamentoDTO->setStrValor($objOrgaoDTO->getStrSigla().'�'.$objOrgaoDTO->getStrDescricao());
        $objAtributoAndamentoDTO->setStrIdOrigem($objOrgaoDTO->getStrIdOrgaoFederacao());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('UNIDADE_DESTINATARIA');
        $objAtributoAndamentoDTO->setStrValor($objUnidadeDTO->getStrSigla().'�'.$objUnidadeDTO->getStrDescricao());
        $objAtributoAndamentoDTO->setStrIdOrigem($objUnidadeDTO->getStrIdUnidadeFederacao());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('MOTIVO');
        $objAtributoAndamentoDTO->setStrValor($objReceberProcessoFederacaoDTO->getStrMotivo());
        $objAtributoAndamentoDTO->setStrIdOrigem($objAcessoFederacaoDTORemoto->getStrIdAcessoFederacao());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

        $objAtividadeDTO = new AtividadeDTO();
        $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO);
        $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);

        $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $objAtividadeDTO->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());

        $objAtividadeRN = new AtividadeRN();
        $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);

        //cria acesso local associando dados remotos
        $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
        $objAcessoFederacaoDTO->setStrIdAcessoFederacao($objAcessoFederacaoDTORemoto->getStrIdAcessoFederacao());
        $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoRem($objInstalacaoFederacaoDTORemetente->getStrIdInstalacaoFederacao());
        $objAcessoFederacaoDTO->setStrIdOrgaoFederacaoRem($objOrgaoFederacaoDTORemetente->getStrIdOrgaoFederacao());
        $objAcessoFederacaoDTO->setStrIdUnidadeFederacaoRem($objUnidadeFederacaoDTORemetente->getStrIdUnidadeFederacao());
        $objAcessoFederacaoDTO->setStrIdUsuarioFederacaoRem($objUsuarioFederacaoDTORemetente->getStrIdUsuarioFederacao());
        $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoDest($objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal());
        $objAcessoFederacaoDTO->setStrIdOrgaoFederacaoDest($objAcessoFederacaoDTORemoto->getStrIdOrgaoFederacaoDest());
        $objAcessoFederacaoDTO->setStrIdUnidadeFederacaoDest($objAcessoFederacaoDTORemoto->getStrIdUnidadeFederacaoDest());
        $objAcessoFederacaoDTO->setStrIdUsuarioFederacaoDest(null);
        $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());
        $objAcessoFederacaoDTO->setStrIdDocumentoFederacao(null);
        $objAcessoFederacaoDTO->setNumStaTipo($objReceberProcessoFederacaoDTO->getNumStaTipo());
        $objAcessoFederacaoDTO->setDthLiberacao($objReceberProcessoFederacaoDTO->getDthDataHora());
        $objAcessoFederacaoDTO->setStrMotivoLiberacao($objReceberProcessoFederacaoDTO->getStrMotivo());
        $objAcessoFederacaoDTO->setDthCancelamento(null);
        $objAcessoFederacaoDTO->setStrMotivoCancelamento(null);

        $objAcessoFederacaoDTO->setStrSinAtivo('S');
        $arrObjAcessoFederacaoDTO[] = $this->cadastrar($objAcessoFederacaoDTO);
      }

      //se gerando pela primeira vez e com destino para mais de uma unidade
      if (count($arrIdUnidadesEnvio)) {
        $objEntradaEnviarProcessoAPI = new EntradaEnviarProcessoAPI();
        $objEntradaEnviarProcessoAPI->setIdProcedimento($objProcedimentoDTO->getDblIdProcedimento());
        $objEntradaEnviarProcessoAPI->setUnidadesDestino($arrIdUnidadesEnvio);
        $objEntradaEnviarProcessoAPI->setSinManterAbertoUnidade('S');
        $objSeiRN->enviarProcesso($objEntradaEnviarProcessoAPI);
      }

      //muda visualizacao do processo para vermelho em todas as unidades
      $objAtividadeDTOVisualizacao = new AtividadeDTO();
      $objAtividadeDTOVisualizacao->setDblIdProtocolo($objProcedimentoDTO->getDblIdProcedimento());
      $objAtividadeDTOVisualizacao->setNumTipoVisualizacao(AtividadeRN::$TV_NAO_VISUALIZADO);

      $objAtividadeRN = new AtividadeRN();
      $objAtividadeRN->atualizarVisualizacao($objAtividadeDTOVisualizacao);

      return $arrObjAcessoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro processando envio de processo no SEI Federa��o.',$e);
    }
  }

  protected function cancelarAcessoConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO){

    try {
      $objAcessoFederacaoDTORet = $this->cancelarAcessoInterno($parObjAcessoFederacaoDTO);

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objAcessoFederacaoDTORet->getStrIdProcedimentoFederacao());
      $arrIdInstalacaoFederacao = array_unique(InfraArray::converterArrInfraDTO($this->obterOrgaosAcessoFederacao($objAcessoFederacaoDTO), 'IdInstalacaoFederacao'));

      $bolReplicarAcessosOnline = ConfiguracaoSEI::getInstance()->getValor('Federacao', 'ReplicarAcessosOnline', false, true);

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $objReplicacaoFederacaoRN = new ReplicacaoFederacaoRN();
      foreach ($arrIdInstalacaoFederacao as $strIdInstalacaoFederacao) {
        if ($strIdInstalacaoFederacao != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {

          $bolErroReplicacao = false;
          if ($bolReplicarAcessosOnline) {
            try {
              $objAcessoFederacaoDTOReplicacao = new AcessoFederacaoDTO();
              $objAcessoFederacaoDTOReplicacao->setStrIdInstalacaoFederacaoDest($strIdInstalacaoFederacao);
              $objAcessoFederacaoDTOReplicacao->setStrIdProcedimentoFederacao($objAcessoFederacaoDTORet->getStrIdProcedimentoFederacao());
              $this->replicarAcessos($objAcessoFederacaoDTOReplicacao);
            } catch (Exception $e) {
              $bolErroReplicacao = true;
            }
          }

          if (!$bolReplicarAcessosOnline || $bolErroReplicacao) {
            $objReplicacaoFederacaoDTO = new ReplicacaoFederacaoDTO();
            $objReplicacaoFederacaoDTO->setStrIdInstalacaoFederacao($strIdInstalacaoFederacao);
            $objReplicacaoFederacaoDTO->setStrIdProtocoloFederacao($objAcessoFederacaoDTORet->getStrIdProcedimentoFederacao());
            $objReplicacaoFederacaoDTO->setNumStaTipo(ReplicacaoFederacaoRN::$TRF_ACESSOS);
            $objReplicacaoFederacaoRN->agendar($objReplicacaoFederacaoDTO);
          }
        }
      }
    }catch (Exception $e){
      throw new InfraException('Erro cancelando envio no SEI Federa��o.', $e);
    }
  }

  protected function cancelarAcessoInternoControlado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO)
  {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('acesso_federacao_cancelar', __METHOD__, $parObjAcessoFederacaoDTO);

      $objInfraException = new InfraException();

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->retStrIdProcedimentoFederacao();
      $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoOrigem();
      $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoOrigem();
      $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
      $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoDest();
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoDest();
      $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoDest();
      $objAcessoFederacaoDTO->retNumStaTipo();
      $objAcessoFederacaoDTO->retDthLiberacao();
      $objAcessoFederacaoDTO->retDthCancelamento();
      $objAcessoFederacaoDTO->setStrIdAcessoFederacao($parObjAcessoFederacaoDTO->getStrIdAcessoFederacao());

      $objAcessoFederacaoDTO = $this->consultar($objAcessoFederacaoDTO);

      if ($objAcessoFederacaoDTO == null) {
        throw new InfraException('Registro de acesso do SEI Federa��o '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' n�o encontrado.');
      }

      if ($objAcessoFederacaoDTO->getNumStaTipo() != self::$TAF_PROCESSO_ENVIADO_ORGAO){
        $objInfraException->adicionarValidacao('Acesso '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' n�o corresponde a um envio para o SEI Federa��o.');
      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      if ($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem() != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()){
        throw new InfraException('N�o � poss�vel cancelar o envio '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' realizado por outra instala��o do SEI Federa��o.');
      }

      if ($objAcessoFederacaoDTO->getDthCancelamento() != null) {
        $objInfraException->adicionarValidacao('Envio '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' j� consta como cancelado.');
      }

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->setBolExclusaoLogica(false);
      $objUnidadeDTO->retStrIdUnidadeFederacao();
      $objUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

      $objUnidadeRN = new UnidadeRN();
      $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

      if ($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem() != $objUnidadeDTO->getStrIdUnidadeFederacao()) {
        $objInfraException->adicionarValidacao('Envio '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' n�o foi realizado pela unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
      }

      $objAcessoFederacaoDTORelacionados = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTORelacionados->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTORelacionados->retDthLiberacao();
      $objAcessoFederacaoDTORelacionados->setStrIdInstalacaoFederacaoRem($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem());
      $objAcessoFederacaoDTORelacionados->setStrIdOrgaoFederacaoRem($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem());
      $objAcessoFederacaoDTORelacionados->setStrIdUnidadeFederacaoRem($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem());
      $objAcessoFederacaoDTORelacionados->setStrIdInstalacaoFederacaoDest($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest());
      $objAcessoFederacaoDTORelacionados->setStrIdOrgaoFederacaoDest($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest());
      $objAcessoFederacaoDTORelacionados->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcessoFederacaoDTORelacionados->setStrIdAcessoFederacao($objAcessoFederacaoDTO->getStrIdAcessoFederacao(),InfraDTO::$OPER_DIFERENTE);
      $objAcessoFederacaoDTORelacionados->setOrdDthLiberacao(InfraDTO::$TIPO_ORDENACAO_DESC);

      $arrObjAcessoFederacaoDTORelacionados = $this->listar($objAcessoFederacaoDTORelacionados);

      if (count($arrObjAcessoFederacaoDTORelacionados)){
        if (InfraData::compararDataHora($objAcessoFederacaoDTO->getDthLiberacao(),$arrObjAcessoFederacaoDTORelacionados[0]->getDthLiberacao())>0){
          $objInfraException->adicionarValidacao('Existe envio mais recente da unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().' para o �rg�o '.$objAcessoFederacaoDTO->getStrSiglaOrgaoFederacaoDest().'.');
        }
      }

      $objInfraException->lancarValidacoes();

      if ($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoOrigem() != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {
        try {
          $objAcessoFederacaoDTOReplicacao = new AcessoFederacaoDTO();
          $objAcessoFederacaoDTOReplicacao->setStrIdInstalacaoFederacaoDest($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoOrigem());
          $objAcessoFederacaoDTOReplicacao->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
          $this->replicarAcessos($objAcessoFederacaoDTOReplicacao);
        }catch(Exception $e){
          throw new InfraException('N�o foi poss�vel cancelar o envio.'."\n\n".'Erro sincronizando dados com a instala��o '.$objAcessoFederacaoDTO->getStrSiglaInstalacaoFederacaoOrigem().' origem do processo.', $e);
        }
      }

      $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
      $objAtributoAndamentoDTO->retNumIdAtividade();
      $objAtributoAndamentoDTO->retDblIdProtocoloAtividade();
      $objAtributoAndamentoDTO->setNumIdTarefaAtividade(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO);
      $objAtributoAndamentoDTO->setStrNome('MOTIVO');
      $objAtributoAndamentoDTO->setStrIdOrigem($objAcessoFederacaoDTO->getStrIdAcessoFederacao());

      $objAtributoAndamentoRN = new AtributoAndamentoRN();
      $objAtributoAndamentoDTO = $objAtributoAndamentoRN->consultarRN1366($objAtributoAndamentoDTO);

      if ($objAtributoAndamentoDTO == null){
        $objInfraException->lancarValidacao('Andamento de envio para o acesso '.$parObjAcessoFederacaoDTO->getStrIdAcessoFederacao().' do SEI Federa��o n�o encontrado.');
      }

      $dblIdProtocoloEnvio = $objAtributoAndamentoDTO->getDblIdProtocoloAtividade();
      $numIdAtividadeEnvio = $objAtributoAndamentoDTO->getNumIdAtividade();

      //busca atributos originais para replicacao no novo andamento
      $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
      $objAtributoAndamentoDTO->retStrNome();
      $objAtributoAndamentoDTO->retStrValor();
      $objAtributoAndamentoDTO->retStrIdOrigem();
      $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);

      $arrObjAtributoAndamentoDTO = $objAtributoAndamentoRN->listarRN1367($objAtributoAndamentoDTO);

      //substitui o motivo de liberacao pelo motivo de cancelamento
      foreach ($arrObjAtributoAndamentoDTO as $objAtributoAndamentoDTO) {
        if ($objAtributoAndamentoDTO->getStrNome() == 'MOTIVO') {
          $objAtributoAndamentoDTO->setStrValor($parObjAcessoFederacaoDTO->getStrMotivoCancelamento());
          break;
        }
      }

      //lan�a andamento para o usu�rio atual registrando o cancelamento da libera��o
      $objAtividadeDTO = new AtividadeDTO();
      $objAtividadeDTO->setDblIdProtocolo($dblIdProtocoloEnvio);
      $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objAtividadeDTO->setNumIdUnidadeOrigem(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objAtividadeDTO->setNumIdUsuario(null);
      $objAtividadeDTO->setNumIdUsuarioOrigem(SessaoSEI::getInstance()->getNumIdUsuario());
      $objAtividadeDTO->setDtaPrazo(null);
      $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);
      $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_CANCELAMENTO_ENVIO_PROCESSO_FEDERACAO);

      $objAtividadeRN = new AtividadeRN();
      $ret = $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);

      $objAtividadeDTO = new AtividadeDTO();
      $objAtividadeDTO->setDblIdProtocolo($dblIdProtocoloEnvio);
      $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objAtividadeDTO->setNumTipoVisualizacao(AtividadeRN::$TV_CANCELAMENTO_FEDERACAO);

      $objAtividadeRN->atualizarVisualizacao($objAtividadeDTO);

      //altera andamento original de envio
      $objAtividadeDTO = new AtividadeDTO();
      $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO_CANCELADO);
      $objAtividadeDTO->setNumIdAtividade($numIdAtividadeEnvio);
      $objAtividadeRN->mudarTarefa($objAtividadeDTO);

      //complementa atributos do andamento original alterado
      $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
      $objAtributoAndamentoDTO->setStrNome('USUARIO');
      $objAtributoAndamentoDTO->setStrValor(SessaoSEI::getInstance()->getStrSiglaUsuario().'�'.SessaoSEI::getInstance()->getStrNomeUsuario());
      $objAtributoAndamentoDTO->setStrIdOrigem(SessaoSEI::getInstance()->getNumIdUsuario());
      $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);
      $objAtributoAndamentoRN->cadastrarRN1363($objAtributoAndamentoDTO);

      $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
      $objAtributoAndamentoDTO->setStrNome('DATA_HORA');
      $objAtributoAndamentoDTO->setStrValor($parObjAcessoFederacaoDTO->getDthCancelamento());
      $objAtributoAndamentoDTO->setStrIdOrigem($ret->getNumIdAtividade()); //relaciona com o andamento de cancelamento
      $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);
      $objAtributoAndamentoRN->cadastrarRN1363($objAtributoAndamentoDTO);

      //modifica acesso registrando dados de cancelamento e desativando
      $objAcessoFederacaoDTOCancelamento = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTOCancelamento->setStrMotivoCancelamento($parObjAcessoFederacaoDTO->getStrMotivoCancelamento());
      $objAcessoFederacaoDTOCancelamento->setDthCancelamento($parObjAcessoFederacaoDTO->getDthCancelamento());
      $objAcessoFederacaoDTOCancelamento->setStrSinAtivo('N');
      $objAcessoFederacaoDTOCancelamento->setStrIdAcessoFederacao($objAcessoFederacaoDTO->getStrIdAcessoFederacao());

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $objAcessoFederacaoBD->alterar($objAcessoFederacaoDTOCancelamento);

      $objAcessoFederacaoBD = new AcessoFederacaoBD(BancoSEI::getInstance());
      foreach($arrObjAcessoFederacaoDTORelacionados as $objAcessoFederacaoDTORelacionado){
        $objAcessoFederacaoDTOAnular = new AcessoFederacaoDTO();
        $objAcessoFederacaoDTOAnular->setStrMotivoCancelamento('Anulado devido ao cancelamento do envio de '.substr($objAcessoFederacaoDTO->getDthLiberacao(),0,16));
        $objAcessoFederacaoDTOAnular->setDthCancelamento($parObjAcessoFederacaoDTO->getDthCancelamento());
        $objAcessoFederacaoDTOAnular->setStrSinAtivo('N');
        $objAcessoFederacaoDTOAnular->setStrIdAcessoFederacao($objAcessoFederacaoDTORelacionado->getStrIdAcessoFederacao());
        $objAcessoFederacaoBD->alterar($objAcessoFederacaoDTOAnular);
      }

      return $objAcessoFederacaoDTO;

    } catch (Exception $e) {
      throw new InfraException('Erro cancelando envio no SEI Federa��o.', $e);
    }
  }

  private function prepararInteressados($arrObjParticipanteDTO){
    try{

      $objInfraParametro = new InfraParametro(BancoSEI::getInstance());

      if (!$objInfraParametro->isSetValor('ID_TIPO_CONTATO_FEDERACAO')){
        $objTipoContatoDTO = new TipoContatoDTO();
        $objTipoContatoDTO->setNumIdTipoContato(null);
        $objTipoContatoDTO->setStrNome('SEI Federa��o');
        $objTipoContatoDTO->setStrDescricao('Usu�rios cadastrados atrav�s do SEI Federa��o.');
        $objTipoContatoDTO->setStrStaAcesso(TipoContatoRN::$TA_CONSULTA_RESUMIDA);
        $objTipoContatoDTO->setStrSinSistema('N');
        $objTipoContatoDTO->setStrSinAtivo('S');

        $objTipoContatoRN = new TipoContatoRN();
        $objTipoContatoDTO = $objTipoContatoRN->cadastrarRN0334($objTipoContatoDTO);

        $objInfraParametro->setValor('ID_TIPO_CONTATO_FEDERACAO',$objTipoContatoDTO->getNumIdTipoContato());
      }

      $numIdTipoContato = $objInfraParametro->getValor('ID_TIPO_CONTATO_FEDERACAO');

      $objContatoRN = new ContatoRN();
      $objUsuarioRN = new UsuarioRN();
      foreach($arrObjParticipanteDTO as $objParticipanteDTO){

        $objContatoDTO = new ContatoDTO();
        $objContatoDTO->retNumIdContato();

        if (!InfraString::isBolVazia($objParticipanteDTO->getStrSiglaContato()) && !InfraString::isBolVazia($objParticipanteDTO->getStrNomeContato())){
          $objContatoDTO->setStrSigla($objParticipanteDTO->getStrSiglaContato());
          $objContatoDTO->setStrNome($objParticipanteDTO->getStrNomeContato());
        }else if (!InfraString::isBolVazia($objParticipanteDTO->getStrSiglaContato())){
          $objContatoDTO->setStrSigla($objParticipanteDTO->getStrSiglaContato());
        }else if (!InfraString::isBolVazia($objParticipanteDTO->getStrNomeContato())){
          $objContatoDTO->setStrNome($objParticipanteDTO->getStrNomeContato());
        }else{
          throw new InfraException('Interessado vazio ou nulo.');
        }

        $objContatoDTO->setNumIdTipoContato($numIdTipoContato);
        $objContatoDTO->setOrdNumIdContato(InfraDTO::$TIPO_ORDENACAO_ASC);

        $arrObjContatoDTO = $objContatoRN->listarRN0325($objContatoDTO);

        if (count($arrObjContatoDTO)){
          $objContatoDTO = $arrObjContatoDTO[0];
        }else{
          $objContatoDTO = new ContatoDTO();
          $objContatoDTO->setNumIdContato(null);
          $objContatoDTO->setNumIdTipoContato($numIdTipoContato);
          $objContatoDTO->setNumIdContatoAssociado(null);
          $objContatoDTO->setStrStaNatureza(ContatoRN::$TN_PESSOA_FISICA);
          $objContatoDTO->setStrSigla($objParticipanteDTO->getStrSiglaContato());
          $objContatoDTO->setStrNome($objParticipanteDTO->getStrNomeContato());
          $objContatoDTO->setStrSinEnderecoAssociado('N');
          $objContatoDTO->setStrSinAtivo('S');
          $objContatoDTO = $objContatoRN->cadastrarRN0322($objContatoDTO);
        }

        $objParticipanteDTO->setNumIdContato($objContatoDTO->getNumIdContato());
      }

      return $arrObjParticipanteDTO;
    }catch(Exception $e){
      throw new InfraException('Erro preparando interessados do processo recebido pelo SEI Federa��o.',$e);
    }
  }

  protected function visualizarProcessoConectado(VisualizarProcessoFederacaoDTO $parObjVisualizarProcessoFederacaoDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('processo_consulta_federacao', __METHOD__, $parObjVisualizarProcessoFederacaoDTO);

      $objInfraException = new InfraException();

      $bolAtualizarArvore = false;

      $objProcedimentoDTO = new ProcedimentoDTO();
      $objProcedimentoDTO->retDblIdProcedimento();
      $objProcedimentoDTO->setStrIdProtocoloFederacaoProtocolo($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $objProcedimentoRN = new ProcedimentoRN();
      $objProcedimentoDTO = $objProcedimentoRN->consultarRN0201($objProcedimentoDTO);

      if ($objProcedimentoDTO == null) {
        $objInfraException->lancarValidacao('Processo do SEI Federa��o n�o encontrado na base local.');
      }

      $dblIdProcedimentoLocal = $objProcedimentoDTO->getDblIdProcedimento();

      $objSinalizacaoFederacaoDTO = new SinalizacaoFederacaoDTO();
      $objSinalizacaoFederacaoDTO->retTodos();
      $objSinalizacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao());
      $objSinalizacaoFederacaoDTO->setStrIdProtocoloFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objSinalizacaoFederacaoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

      $objSinalizacaoFederacaoRN = new SinalizacaoFederacaoRN();
      $objSinalizacaoFederacaoDTO = $objSinalizacaoFederacaoRN->consultar($objSinalizacaoFederacaoDTO);

      if ($objSinalizacaoFederacaoDTO != null) {

        if ($objSinalizacaoFederacaoDTO->getNumStaSinalizacao()!=SinalizacaoFederacaoRN::$TSF_NENHUMA) {

          $numStaSinalizacaoOriginal = $objSinalizacaoFederacaoDTO->getNumStaSinalizacao();
          $numStaSinalizacaoNovo = $numStaSinalizacaoOriginal & ~SinalizacaoFederacaoRN::$TSF_ATENCAO;
          $numStaSinalizacaoNovo = $numStaSinalizacaoNovo & ~SinalizacaoFederacaoRN::$TSF_PUBLICACAO;

          $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
          $numSinalizacaoProcesso = $objInfraParametro->getValor('SEI_SINALIZACAO_PROCESSO');

          $objAtividadeDTO = null;

          if ($numSinalizacaoProcesso == '1') {

            $objAtividadeDTOUltima = new AtividadeDTO();
            $objAtividadeDTOUltima->retNumIdAtividade();
            $objAtividadeDTOUltima->retNumIdUsuarioAtribuicao();
            $objAtividadeDTOUltima->retStrStaNivelAcessoGlobalProtocolo();
            $objAtividadeDTOUltima->setDblIdProtocolo($dblIdProcedimentoLocal);
            $objAtividadeDTOUltima->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
            $objAtividadeDTOUltima->setDthConclusao(null);
            $objAtividadeDTOUltima->setOrdNumIdAtividade(InfraDTO::$TIPO_ORDENACAO_DESC);

            $objAtividadeRN = new AtividadeRN();
            $arrObjAtividadeDTO = $objAtividadeRN->listarRN0036($objAtividadeDTOUltima);

            if (count($arrObjAtividadeDTO)) {
              $objAtividadeDTO = $arrObjAtividadeDTO[0];
            }
          }

          if ($numSinalizacaoProcesso == '0' ||
            ($objAtividadeDTO != null && ($objAtividadeDTO->getNumIdUsuarioAtribuicao() == null ||
                $objAtividadeDTO->getNumIdUsuarioAtribuicao() == SessaoSEI::getInstance()->getNumIdUsuario() ||
                $objAtividadeDTO->getStrStaNivelAcessoGlobalProtocolo() == ProtocoloRN::$NA_SIGILOSO))
          ) {

            $objSinalizacaoFederacaoDTO->setDthSinalizacao(gmdate("d/m/Y H:i:s"));
            $objSinalizacaoFederacaoDTO->setNumStaSinalizacao($numStaSinalizacaoNovo);
            $objSinalizacaoFederacaoRN->alterar($objSinalizacaoFederacaoDTO);
            $bolAtualizarArvore = true;
          }
        }
      }else{

        $objSinalizacaoFederacaoDTO = new SinalizacaoFederacaoDTO();
        $objSinalizacaoFederacaoDTO->setStrIdInstalacaoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao());
        $objSinalizacaoFederacaoDTO->setStrIdProtocoloFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
        $objSinalizacaoFederacaoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $objSinalizacaoFederacaoDTO->setDthSinalizacao(gmdate("d/m/Y H:i:s"));
        $objSinalizacaoFederacaoDTO->setNumStaSinalizacao(SinalizacaoFederacaoRN::$TSF_NENHUMA);

        try {
          $objSinalizacaoFederacaoRN->cadastrar($objSinalizacaoFederacaoDTO);
        } catch (Exception $e) {
          LogSEI::getInstance()->gravar('Erro cadastrando sinaliza��o replicada do SEI Federa��o:'."\n".InfraException::inspecionar($e));
        }

      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->adicionarCriterio(array('IdInstalacaoFederacaoRem','IdInstalacaoFederacaoDest'),
                                                array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
                                                array($parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao(), $parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao()),
                                                InfraDTO::$OPER_LOGICO_OR);

      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $arrObjAcessoFederacaoDTO = $this->listar($objAcessoFederacaoDTO);

      if (count($arrObjAcessoFederacaoDTO)==0){
        $objInfraException->lancarValidacao('A instala��o do �rg�o requisitado n�o possui acesso ao processo no SEI Federa��o.');
      }

      $objVisualizacaoProcesso = new stdClass();

      $objProcedimentoLocal = new stdClass();
      if ($parObjVisualizarProcessoFederacaoDTO->isSetStrIdProcedimentoFederacaoAnexado()) {
        $objProcedimentoLocal->IdProcedimentoFederacao = $parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacaoAnexado();
      }else{
        $objProcedimentoLocal->IdProcedimentoFederacao = $parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao();
      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objProcedimentoLocal->VersaoAcessos = $this->obterVersaoAcessos($objAcessoFederacaoDTO);

      $objVisualizacaoProcesso->Procedimento = $objProcedimentoLocal;

      if ($parObjVisualizarProcessoFederacaoDTO->getStrSinProtocolos()=='S') {
        $objVisualizacaoProcesso->SinProtocolos = 'S';
        $objVisualizacaoProcesso->PagProtocolos = $parObjVisualizarProcessoFederacaoDTO->getNumPagProtocolos();
      }else{
        $objVisualizacaoProcesso->SinProtocolos = 'N';
      }

      if ($parObjVisualizarProcessoFederacaoDTO->getStrSinAndamentos()=='S') {
        $objVisualizacaoProcesso->SinAndamentos = 'S';
        $objVisualizacaoProcesso->PagAndamentos = $parObjVisualizarProcessoFederacaoDTO->getNumPagAndamentos();
      }else{
        $objVisualizacaoProcesso->SinAndamentos = 'N';
      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $objVisualizacaoProcessoRet = $objInstalacaoFederacaoRN->executar('visualizarProcesso', $parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao(), $objVisualizacaoProcesso);

      $arrObjUsuarioDTO = array();
      if (is_array($objVisualizacaoProcessoRet->Usuarios)) {
        $numUsuarios = count($objVisualizacaoProcessoRet->Usuarios);
        for ($i = 0; $i < $numUsuarios; $i++) {
          $objUsuarioDTO = new UsuarioDTO();
          $objUsuarioDTO->setNumIdUsuario($objVisualizacaoProcessoRet->Usuarios[$i]->IdUsuario);
          $objUsuarioDTO->setStrSigla($objVisualizacaoProcessoRet->Usuarios[$i]->Sigla);
          $objUsuarioDTO->setStrNome($objVisualizacaoProcessoRet->Usuarios[$i]->Nome);
          $arrObjUsuarioDTO[$objUsuarioDTO->getNumIdUsuario()] = $objUsuarioDTO;
        }
      }

      $arrObjOrgaoDTO = array();
      if (is_array($objVisualizacaoProcessoRet->Orgaos)) {
        $numOrgaos = count($objVisualizacaoProcessoRet->Orgaos);
        for ($i = 0; $i < $numOrgaos; $i++) {
          $objOrgaoDTO = new OrgaoDTO();
          $objOrgaoDTO->setNumIdOrgao($objVisualizacaoProcessoRet->Orgaos[$i]->IdOrgao);
          $objOrgaoDTO->setStrSigla($objVisualizacaoProcessoRet->Orgaos[$i]->Sigla);
          $objOrgaoDTO->setStrDescricao($objVisualizacaoProcessoRet->Orgaos[$i]->Descricao);
          $arrObjOrgaoDTO[$objOrgaoDTO->getNumIdOrgao()] = $objOrgaoDTO;
        }
      }

      $arrObjUnidadeDTO = array();
      if (is_array($objVisualizacaoProcessoRet->Unidades)) {
        $numUnidades = count($objVisualizacaoProcessoRet->Unidades);
        for ($i = 0; $i < $numUnidades; $i++) {
          $objUnidadeDTO = new UnidadeDTO();
          $objUnidadeDTO->setNumIdUnidade($objVisualizacaoProcessoRet->Unidades[$i]->IdUnidade);
          $objUnidadeDTO->setNumIdOrgao($objVisualizacaoProcessoRet->Unidades[$i]->IdOrgao);
          $objUnidadeDTO->setStrSigla($objVisualizacaoProcessoRet->Unidades[$i]->Sigla);
          $objUnidadeDTO->setStrDescricao($objVisualizacaoProcessoRet->Unidades[$i]->Descricao);
          $arrObjUnidadeDTO[$objUnidadeDTO->getNumIdUnidade()] = $objUnidadeDTO;
        }
      }

      $objProcedimentoRemoto = $objVisualizacaoProcessoRet->Procedimento;
      $objUnidadeOrigemRemoto = $objVisualizacaoProcessoRet->UnidadeOrigem;

      $objProcedimentoDTO = new ProcedimentoDTO();
      $objProcedimentoDTO->setDblIdProcedimento($dblIdProcedimentoLocal);
      $objProcedimentoDTO->setStrSiglaUnidadeGeradoraProtocolo($arrObjUnidadeDTO[$objUnidadeOrigemRemoto->IdUnidade]->getStrSigla());
      $objProcedimentoDTO->setStrDescricaoUnidadeGeradoraProtocolo($arrObjUnidadeDTO[$objUnidadeOrigemRemoto->IdUnidade]->getStrDescricao());
      $objProcedimentoDTO->setStrSiglaOrgaoUnidadeGeradoraProtocolo($arrObjOrgaoDTO[$arrObjUnidadeDTO[$objUnidadeOrigemRemoto->IdUnidade]->getNumIdOrgao()]->getStrSigla());
      $objProcedimentoDTO->setStrDescricaoOrgaoUnidadeGeradoraProtocolo($arrObjOrgaoDTO[$arrObjUnidadeDTO[$objUnidadeOrigemRemoto->IdUnidade]->getNumIdOrgao()]->getStrDescricao());
      $objProcedimentoDTO->setStrIdProtocoloFederacaoProtocolo($objProcedimentoRemoto->IdProcedimentoFederacao);
      $objProcedimentoDTO->setStrProtocoloProcedimentoFormatado($objProcedimentoRemoto->ProtocoloFormatado);
      $objProcedimentoDTO->setStrStaNivelAcessoGlobalProtocolo($objProcedimentoRemoto->NivelAcesso);
      $objProcedimentoDTO->setStrNomeTipoProcedimento($objProcedimentoRemoto->TipoProcedimento->Nome);
      $objProcedimentoDTO->setDtaGeracaoProtocolo($objProcedimentoRemoto->DataAutuacao);

      $arrObjParticipanteDTO = array();
      if (is_array($objProcedimentoRemoto->Interessados)) {
        $numInteressados = count($objProcedimentoRemoto->Interessados);
        for ($i = 0; $i < $numInteressados; $i++) {
          $objParticipanteDTO = new ParticipanteDTO();
          $objParticipanteDTO->setStrSiglaContato($objProcedimentoRemoto->Interessados[$i]->Sigla);
          $objParticipanteDTO->setStrNomeContato($objProcedimentoRemoto->Interessados[$i]->Nome);
          $arrObjParticipanteDTO[] = $objParticipanteDTO;
        }
      }
      $objProcedimentoDTO->setArrObjParticipanteDTO($arrObjParticipanteDTO);

      $arrObjRelProtocoloProtocoloDTO = array();
      if (is_array($objVisualizacaoProcessoRet->Protocolos)) {

        $numProtocolos = count($objVisualizacaoProcessoRet->Protocolos);
        for ($i = 0; $i < $numProtocolos; $i++) {

          $objProtocolo = $objVisualizacaoProcessoRet->Protocolos[$i];
          $objUnidadeDTO = $arrObjUnidadeDTO[$objProtocolo->Unidade->IdUnidade];
          $objOrgaoDTO = $arrObjOrgaoDTO[$objUnidadeDTO->getNumIdOrgao()];


          if ($objProtocolo->StaProtocolo == ProtocoloRN::$TP_DOCUMENTO_GERADO || $objProtocolo->StaProtocolo == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO){

            $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
            $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO);
            $objRelProtocoloProtocoloDTO->setStrSinAcessoBasico($objProtocolo->SinAcesso);

            $objDocumento = $objProtocolo->Documento;

            $objDocumentoDTO = new DocumentoDTO();
            $objDocumentoDTO->setStrStaEstadoProtocolo($objProtocolo->StaEstado);
            $objDocumentoDTO->setStrStaProtocoloProtocolo($objProtocolo->StaProtocolo);
            $objDocumentoDTO->setStrIdProtocoloFederacaoProtocolo($objDocumento->IdDocumentoFederacao);
            $objDocumentoDTO->setStrProtocoloDocumentoFormatado($objDocumento->ProtocoloFormatado);
            $objDocumentoDTO->setStrNumero($objDocumento->Numero);
            $objDocumentoDTO->setDtaGeracaoProtocolo($objDocumento->DataGeracao);
            $objDocumentoDTO->setNumIdSerie($objDocumento->Serie->IdSerie);
            $objDocumentoDTO->setStrNomeSerie($objDocumento->Serie->Nome);
            $objDocumentoDTO->setStrSinPdf($objDocumento->SinPdf);
            $objDocumentoDTO->setStrSinZip($objDocumento->SinZip);
            $objDocumentoDTO->setStrSiglaUnidadeGeradoraProtocolo($objUnidadeDTO->getStrSigla());
            $objDocumentoDTO->setStrDescricaoUnidadeGeradoraProtocolo($objUnidadeDTO->getStrDescricao());
            $objDocumentoDTO->setStrSiglaOrgaoUnidadeGeradoraProtocolo($objOrgaoDTO->getStrSigla());
            $objDocumentoDTO->setStrDescricaoOrgaoUnidadeGeradoraProtocolo($objOrgaoDTO->getStrDescricao());

            if (is_array($objDocumento->Assinaturas)){
              $arrObjAssinaturaDTO = array();
              foreach($objDocumento->Assinaturas as $objAssinatura){
                $objAssinaturaDTO = new AssinaturaDTO();
                $objAssinaturaDTO->setNumIdUsuario($objAssinatura->IdUsuario);
                $objAssinaturaDTO->setStrNome($objAssinatura->Nome);
                $objAssinaturaDTO->setStrTratamento($objAssinatura->CargoFuncao);
                $arrObjAssinaturaDTO[] = $objAssinaturaDTO;
              }
              $objDocumentoDTO->setArrObjAssinaturaDTO($arrObjAssinaturaDTO);
            }

            if ($objDocumento->Publicacao != null){
              $objPublicacaoDTO = new PublicacaoDTO();
              $objPublicacaoDTO->setNumIdPublicacao($objDocumento->Publicacao->IdPublicacao);
              $objPublicacaoDTO->setStrTextoInformativo($objDocumento->Publicacao->TextoInformativo);
              $objDocumentoDTO->setObjPublicacaoDTO($objPublicacaoDTO);
            }

            $objRelProtocoloProtocoloDTO->setObjProtocoloDTO2($objDocumentoDTO);

            $arrObjRelProtocoloProtocoloDTO[] = $objRelProtocoloProtocoloDTO;

          }else if ($objProtocolo->StaProtocolo == ProtocoloRN::$TP_PROCEDIMENTO){

            $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
            $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);
            $objRelProtocoloProtocoloDTO->setStrSinAcessoBasico($objProtocolo->SinAcesso);

            $objProcedimentoRemotoAnexado = $objProtocolo->Procedimento;

            $objProcedimentoDTOAnexado = new ProcedimentoDTO();
            $objProcedimentoDTOAnexado->setStrStaEstadoProtocolo($objProtocolo->StaEstado);
            $objProcedimentoDTOAnexado->setStrIdProtocoloFederacaoProtocolo($objProcedimentoRemotoAnexado->IdProcedimentoFederacao);
            $objProcedimentoDTOAnexado->setStrProtocoloProcedimentoFormatado($objProcedimentoRemotoAnexado->ProtocoloFormatado);
            $objProcedimentoDTOAnexado->setDtaGeracaoProtocolo($objProcedimentoRemotoAnexado->DataAutuacao);
            $objProcedimentoDTOAnexado->setNumIdTipoProcedimento($objProcedimentoRemotoAnexado->TipoProcedimento->IdTipoProcedimento);
            $objProcedimentoDTOAnexado->setStrNomeTipoProcedimento($objProcedimentoRemotoAnexado->TipoProcedimento->Nome);
            $objProcedimentoDTOAnexado->setStrSiglaUnidadeGeradoraProtocolo($objUnidadeDTO->getStrSigla());
            $objProcedimentoDTOAnexado->setStrDescricaoUnidadeGeradoraProtocolo($objUnidadeDTO->getStrDescricao());
            $objProcedimentoDTOAnexado->setStrSiglaOrgaoUnidadeGeradoraProtocolo($objOrgaoDTO->getStrSigla());
            $objProcedimentoDTOAnexado->setStrDescricaoOrgaoUnidadeGeradoraProtocolo($objOrgaoDTO->getStrDescricao());

            $objRelProtocoloProtocoloDTO->setObjProtocoloDTO2($objProcedimentoDTOAnexado);

            $arrObjRelProtocoloProtocoloDTO[] = $objRelProtocoloProtocoloDTO;
          }
        }
      }
      $objProcedimentoDTO->setArrObjRelProtocoloProtocoloDTO($arrObjRelProtocoloProtocoloDTO);

      $arrAtividadeDTO = array();
      if (is_array($objVisualizacaoProcessoRet->Andamentos)) {

        $numAndamentos = count($objVisualizacaoProcessoRet->Andamentos);
        for ($i = 0; $i < $numAndamentos; $i++) {

          $objAndamento = $objVisualizacaoProcessoRet->Andamentos[$i];
          $objUsuarioDTO = $arrObjUsuarioDTO[$objAndamento->Usuario->IdUsuario];
          $objUnidadeDTO = $arrObjUnidadeDTO[$objAndamento->Unidade->IdUnidade];

          $objAtividadeDTO = new AtividadeDTO();
          $objAtividadeDTO->setDthAbertura($objAndamento->DataHora);
          $objAtividadeDTO->setStrSinUltimaUnidadeHistorico($objAndamento->SinAberto);
          $objAtividadeDTO->setStrNomeTarefa($objAndamento->Descricao);
          $objAtividadeDTO->setStrSiglaUsuarioOrigem($objUsuarioDTO->getStrSigla());
          $objAtividadeDTO->setStrNomeUsuarioOrigem($objUsuarioDTO->getStrNome());
          $objAtividadeDTO->setStrSiglaUnidade($objUnidadeDTO->getStrSigla());
          $objAtividadeDTO->setStrDescricaoUnidade($objUnidadeDTO->getStrDescricao());

          $arrAtividadeDTO[] = $objAtividadeDTO;
        }
      }
      $objProcedimentoDTO->setArrObjAtividadeDTO($arrAtividadeDTO);

      $objProcedimentoDTO->setStrVersaoAcessos(null);

      if ( $objProcedimentoLocal->VersaoAcessos != $objProcedimentoRemoto->VersaoAcessos) {

        $bolAtualizarArvore = true;

        $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
        $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
        $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());

        $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
        $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

        $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

        try {
          //se nao � a instalacao origem
          if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() != $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {
            $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
            $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoDest($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao());
            $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
            $this->replicarAcessos($objAcessoFederacaoDTO);
          }
        }catch(Exception $e){
          LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
        }

        try {
          //se onde esta consultando nao � a instalacao origem
          if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() != $parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao()) {
            $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
            $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao());
            $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoDest($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao());
            $this->replicarAcessos($objAcessoFederacaoDTO);
          }
        }catch(Exception $e){
          LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
        }

      }

      $objVisualizarProcessoFederacaoDTO = new VisualizarProcessoFederacaoDTO();
      $objVisualizarProcessoFederacaoDTO->setObjProcedimentoDTO($objProcedimentoDTO);
      $objVisualizarProcessoFederacaoDTO->setBolAtualizarArvore($bolAtualizarArvore);
      $objVisualizarProcessoFederacaoDTO->setNumMaxProtocolos($objVisualizacaoProcessoRet->MaxProtocolos);
      $objVisualizarProcessoFederacaoDTO->setNumRegProtocolos($objVisualizacaoProcessoRet->RegProtocolos);
      $objVisualizarProcessoFederacaoDTO->setNumTotProtocolos($objVisualizacaoProcessoRet->TotProtocolos);
      $objVisualizarProcessoFederacaoDTO->setNumMaxAndamentos($objVisualizacaoProcessoRet->MaxAndamentos);
      $objVisualizarProcessoFederacaoDTO->setNumRegAndamentos($objVisualizacaoProcessoRet->RegAndamentos);
      $objVisualizarProcessoFederacaoDTO->setNumTotAndamentos($objVisualizacaoProcessoRet->TotAndamentos);

      return $objVisualizarProcessoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro visualizando processo do SEI Federa��o.',$e);
    }
  }

  protected function processarVisualizacaoProcessoConectado(VisualizarProcessoFederacaoDTO $objVisualizarProcessoFederacaoDTO)
  {
    try {

      $objInstalacaoFederacaoDTO = $objVisualizarProcessoFederacaoDTO->getObjInstalacaoFederacaoDTO();
      $objProcedimentoDTORemoto = $objVisualizarProcessoFederacaoDTO->getObjProcedimentoDTO();

      $objVisualizarProcessoFederacaoDTORet = $this->consultarProcesso($objVisualizarProcessoFederacaoDTO);

      $objProcedimentoDTO = $objVisualizarProcessoFederacaoDTORet->getObjProcedimentoDTO();

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTORemoto->getStrIdProtocoloFederacaoProtocolo());
      $objProcedimentoDTO->setStrVersaoAcessos($this->obterVersaoAcessos($objAcessoFederacaoDTO));

      $objProcedimentoDTOAuditoria = new ProcedimentoDTO();
      $objProcedimentoDTOAuditoria->setDblIdProcedimento($objProcedimentoDTO->getDblIdProcedimento());
      $objProcedimentoDTOAuditoria->setStrIdProtocoloFederacaoProtocolo($objProcedimentoDTO->getStrIdProtocoloFederacaoProtocolo());
      $objProcedimentoDTOAuditoria->setStrProtocoloProcedimentoFormatado($objProcedimentoDTO->getStrProtocoloProcedimentoFormatado());

      AuditoriaSEI::getInstance()->auditar('processo_consulta_federacao', __FILE__, $objProcedimentoDTOAuditoria);

      if ($objProcedimentoDTO->getStrVersaoAcessos() != $objProcedimentoDTORemoto->getStrVersaoAcessos()) {

        $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
        $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
        $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTORemoto->getStrIdProtocoloFederacaoProtocolo());

        $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
        $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

        $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

        try{

          //se a instalcao local n�o � a origem do processo
          if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao()!=$objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {
            $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
            $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoDest($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao());
            $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTORemoto->getStrIdProtocoloFederacaoProtocolo());
            $this->replicarAcessos($objAcessoFederacaoDTO);
          }

        }catch(Exception $e){
          LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
        }

        try{

          //se a instala��o remota n�o � a origem do processo
          if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() != $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()) {
            $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
            $objAcessoFederacaoDTO->setStrIdInstalacaoFederacaoDest($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
            $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTORemoto->getStrIdProtocoloFederacaoProtocolo());
            $this->replicarAcessos($objAcessoFederacaoDTO);
          }

        }catch(Exception $e){
          LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
        }
      }

      return $objVisualizarProcessoFederacaoDTORet;

    } catch (Exception $e) {
      throw new InfraException('Erro processando visualiza��o de processo do SEI Federa��o.', $e);
    }
  }

  protected function visualizarDocumentoConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('documento_consulta_federacao', __METHOD__, $parObjAcessoFederacaoDTO);

      $objProcedimento = new stdClass();
      $objProcedimento->IdProcedimentoFederacao = $parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao();

      $objDocumento = new stdClass();
      $objDocumento->IdDocumentoFederacao = $parObjAcessoFederacaoDTO->getStrIdDocumentoFederacao();

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $objVisualizacaoDocumento = $objInstalacaoFederacaoRN->executar('visualizarDocumento',$parObjAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem(), $objProcedimento, $objDocumento);

      return $objVisualizacaoDocumento->LinkAcesso;

    }catch(Exception $e){
      throw new InfraException('Erro visualizando documento do SEI Federa��o.',$e);
    }
  }

  protected function processarVisualizacaoDocumentoControlado(AcessoFederacaoDTO $objAcessoFederacaoDTO)
  {
    try {

      $objVisualizarProcessoFederacaoDTO = new VisualizarProcessoFederacaoDTO();
      $objVisualizarProcessoFederacaoDTO->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objVisualizarProcessoFederacaoDTO->setStrIdDocumentoFederacao($objAcessoFederacaoDTO->getStrIdDocumentoFederacao());
      $objVisualizarProcessoFederacaoDTO->setStrSinProtocolos('S');
      $objVisualizarProcessoFederacaoDTO->setStrSinAndamentos('N');

      $objVisualizarProcessoFederacaoDTORet = $this->consultarProcesso($objVisualizarProcessoFederacaoDTO);

      $objProcedimentoDTO = $objVisualizarProcessoFederacaoDTORet->getObjProcedimentoDTO();

      $objDocumentoDTO = $objProcedimentoDTO->getArrObjRelProtocoloProtocoloDTO()[0]->getObjProtocoloDTO2();

      $objAcaoFederacaoDTO = new AcaoFederacaoDTO();
      $objAcaoFederacaoDTO->setStrIdAcaoFederacao(InfraULID::gerar());
      $objAcaoFederacaoDTO->setStrIdInstalacaoFederacao($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdOrgaoFederacao($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUnidadeFederacao($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUsuarioFederacao($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcaoFederacaoDTO->setStrIdDocumentoFederacao($objAcessoFederacaoDTO->getStrIdDocumentoFederacao());
      $objAcaoFederacaoDTO->setDthGeracao(Infradata::getStrDataHoraAtual());
      $objAcaoFederacaoDTO->setDthAcesso(null);
      $objAcaoFederacaoDTO->setNumStaTipo(AcaoFederacaoRN::$TA_VISUALIZAR_DOCUMENTO);
      $objAcaoFederacaoDTO->setStrSinAtivo('S');

      $objAcaoFederacaoRN = new AcaoFederacaoRN();
      $objAcaoFederacaoRN->cadastrar($objAcaoFederacaoDTO);

      $objVisualizarDocumentoFederacaoDTO = new VisualizarDocumentoFederacaoDTO();
      $objVisualizarDocumentoFederacaoDTO->setObjDocumentoDTO($objDocumentoDTO);
      $objVisualizarDocumentoFederacaoDTO->setStrLinkAcesso(ConfiguracaoSEI::getInstance()->getValor('SEI', 'URL') . '/controlador_federacao.php?acao='.$objAcaoFederacaoDTO->getStrIdAcaoFederacao());

      return $objVisualizarDocumentoFederacaoDTO;

    } catch (Exception $e) {
      throw new InfraException('Erro processando visualiza��o de documento do SEI Federa��o.', $e);
    }
  }

  protected function consultarProcessoConectado(VisualizarProcessoFederacaoDTO $objVisualizarProcessoFederacaoDTO)
  {
    try {

      $objInfraException = new InfraException();

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->retDblIdProtocolo();
      $objProtocoloDTO->retStrStaNivelAcessoGlobal();
      $objProtocoloDTO->setStrIdProtocoloFederacao($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $objProtocoloRN = new ProtocoloRN();
      $objProtocoloDTO = $objProtocoloRN->consultarRN0186($objProtocoloDTO);

      if ($objProtocoloDTO==null){
        throw new InfraException('Processo n�o encontrado.');
      }

      if ($objProtocoloDTO->getStrStaNivelAcessoGlobal() == ProtocoloRN::$NA_SIGILOSO){
        $objInfraException->lancarValidacao('Processo sigiloso na instala��o '.$objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal().'.');
      }

      $dblIdProcedimento = $objProtocoloDTO->getDblIdProtocolo();

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      if (!$this->verificarAcessoLocal($objAcessoFederacaoDTO)){
        $objInfraException->lancarValidacao('Instala��o '.$objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal().' n�o possui acesso neste processo pelo SEI Federa��o.');
      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->adicionarCriterio(array('IdInstalacaoFederacaoRem','IdInstalacaoFederacaoDest'),
                                                array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
                                                array(SessaoSEIFederacao::getInstance()->getStrIdInstalacaoFederacao(), SessaoSEIFederacao::getInstance()->getStrIdInstalacaoFederacao()),
                                                InfraDTO::$OPER_LOGICO_OR);
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $arrObjAcessoFederacaoDTO = $this->listar($objAcessoFederacaoDTO);

      if (count($arrObjAcessoFederacaoDTO)==0) {

        $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
        $objRelProtocoloProtocoloDTO->retDblIdProtocolo1();
        $objRelProtocoloProtocoloDTO->setDblIdProtocolo2($dblIdProcedimento);
        $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);

        $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
        $objRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->consultarRN0841($objRelProtocoloProtocoloDTO);

        if ($objRelProtocoloProtocoloDTO != null) {

          $objProtocoloDTO = new ProtocoloDTO();
          $objProtocoloDTO->retStrIdProtocoloFederacao();
          $objProtocoloDTO->setDblIdProtocolo($objRelProtocoloProtocoloDTO->getDblIdProtocolo1());

          $objProtocoloRN = new ProtocoloRN();
          $objProtocoloDTO = $objProtocoloRN->consultarRN0186($objProtocoloDTO);

          $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProtocoloDTO->getStrIdProtocoloFederacao());
          $arrObjAcessoFederacaoDTO = $this->listar($objAcessoFederacaoDTO);
        }
      }

      if (count($arrObjAcessoFederacaoDTO)==0){

        try {
          $objAcessoFederacaoDTOReplicacao = new AcessoFederacaoDTO();
          $objAcessoFederacaoDTOReplicacao->setStrIdInstalacaoFederacaoDest(SessaoSEIFederacao::getInstance()->getStrIdInstalacaoFederacao());
          $objAcessoFederacaoDTOReplicacao->setStrIdProcedimentoFederacao($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao());
          $this->replicarAcessos($objAcessoFederacaoDTOReplicacao);
        } catch (Exception $e) {
          LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
        }

        //ALERT
        $objInfraException->lancarValidacao('Nenhum acesso encontrado na instala��o '.$objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal().' para a instala��o '.SessaoSEIFederacao::getInstance()->getStrSiglaInstalacaoFederacao().' neste processo.');
      }

      $arrIdDocumento = null;

      if ($objVisualizarProcessoFederacaoDTO->isSetStrIdDocumentoFederacao()){

        if (is_array($objVisualizarProcessoFederacaoDTO->getStrIdDocumentoFederacao())){
          $arrIdDocumentoFederacao = $objVisualizarProcessoFederacaoDTO->getStrIdDocumentoFederacao();
        }else{
          $arrIdDocumentoFederacao = array($objVisualizarProcessoFederacaoDTO->getStrIdDocumentoFederacao());
        }

        $objDocumentoDTO = new DocumentoDTO();
        $objDocumentoDTO->retStrIdProtocoloFederacaoProtocolo();
        $objDocumentoDTO->retDblIdProcedimento();
        $objDocumentoDTO->retDblIdDocumento();
        $objDocumentoDTO->setStrIdProtocoloFederacaoProtocolo($arrIdDocumentoFederacao, InfraDTO::$OPER_IN);

        $objDocumentoRN = new DocumentoRN();
        $arrObjDocumentoDTO = InfraArray::indexarArrInfraDTO($objDocumentoRN->listarRN0008($objDocumentoDTO),'IdProtocoloFederacaoProtocolo');

        foreach($arrIdDocumentoFederacao as $strIdDocumentoFederacao) {

          if (!isset($arrObjDocumentoDTO[$strIdDocumentoFederacao])) {
            throw new InfraException('Documento '.$strIdDocumentoFederacao.' n�o encontrado.');
          }

          $objDocumentoDTO = $arrObjDocumentoDTO[$strIdDocumentoFederacao];

          if ($objDocumentoDTO->getDblIdProcedimento() != $dblIdProcedimento) {

            $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
            $objRelProtocoloProtocoloDTO->retDblIdRelProtocoloProtocolo();
            $objRelProtocoloProtocoloDTO->setDblIdProtocolo2($objDocumentoDTO->getDblIdProcedimento());
            $objRelProtocoloProtocoloDTO->setDblIdProtocolo1($dblIdProcedimento);
            $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);

            $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
            $objRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->consultarRN0841($objRelProtocoloProtocoloDTO);

            if ($objRelProtocoloProtocoloDTO == null) {
              throw new InfraException('Documento '.$strIdDocumentoFederacao.' n�o pertence ao processo do acesso do SEI Federa��o.');
            }
          }
        }
        $dblIdProcedimento = $objDocumentoDTO->getDblIdProcedimento();
        $arrIdDocumento = InfraArray::converterArrInfraDTO($arrObjDocumentoDTO,'IdDocumento');

      }else if ($objVisualizarProcessoFederacaoDTO->isSetStrIdProcedimentoFederacaoAnexado()) {

        //se o processo n�o � o mesmo do acesso verificar se � anexado
        if ($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao()!=$objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacaoAnexado()){

          $objProtocoloDTO = new ProtocoloDTO();
          $objProtocoloDTO->retDblIdProtocolo();
          $objProtocoloDTO->setStrIdProtocoloFederacao($objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacaoAnexado());
          $objProtocoloDTORecebido = $objProtocoloRN->consultarRN0186($objProtocoloDTO);

          if ($objProtocoloDTORecebido == null){
            throw new InfraException('Protocolo n�o encontrado.');
          }

          $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
          $objRelProtocoloProtocoloDTO->retDblIdRelProtocoloProtocolo();
          $objRelProtocoloProtocoloDTO->setDblIdProtocolo2($objProtocoloDTORecebido->getDblIdProtocolo());
          $objRelProtocoloProtocoloDTO->setDblIdProtocolo1($dblIdProcedimento);
          $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);

          $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
          $objRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->consultarRN0841($objRelProtocoloProtocoloDTO);

          if ($objRelProtocoloProtocoloDTO != null){
            $dblIdProcedimento = $objProtocoloDTORecebido->getDblIdProtocolo();
          }
        }
      }

      $objVisualizarProcessoFederacaoDTORet = new VisualizarProcessoFederacaoDTO();
      $objVisualizarProcessoFederacaoDTORet->setNumRegProtocolos(null);
      $objVisualizarProcessoFederacaoDTORet->setNumTotProtocolos(null);
      $objVisualizarProcessoFederacaoDTORet->setNumRegAndamentos(null);
      $objVisualizarProcessoFederacaoDTORet->setNumTotAndamentos(null);

      $objProcedimentoDTO = new ProcedimentoDTO();
      $objProcedimentoDTO->retStrNomeTipoProcedimento();
      $objProcedimentoDTO->retStrProtocoloProcedimentoFormatado();
      $objProcedimentoDTO->retDtaGeracaoProtocolo();
      $objProcedimentoDTO->retStrDescricaoProtocolo();
      $objProcedimentoDTO->retStrStaNivelAcessoGlobalProtocolo();
      $objProcedimentoDTO->setDblIdProcedimento($dblIdProcedimento);

      if ($objVisualizarProcessoFederacaoDTO->getStrSinProtocolos()=='S') {
        $objProcedimentoDTO->setStrSinDocTodos('S');
        $objProcedimentoDTO->setStrSinProcAnexados('S');
        $objProcedimentoDTO->setStrSinPdf('S');
        $objProcedimentoDTO->setStrSinZip('S');
      }

      if ($objVisualizarProcessoFederacaoDTO->isSetNumPagProtocolos() && $objVisualizarProcessoFederacaoDTO->isSetNumMaxProtocolos()) {

        $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
        $objRelProtocoloProtocoloDTO->retDblIdRelProtocoloProtocolo();
        $objRelProtocoloProtocoloDTO->setStrStaAssociacao(array(RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO,RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO), InfraDTO::$OPER_IN);
        $objRelProtocoloProtocoloDTO->setDblIdProtocolo1($dblIdProcedimento);
        $objRelProtocoloProtocoloDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
        $arrObjRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->listarRN0187($objRelProtocoloProtocoloDTO);

        $arrObjRelProtocoloProtocoloDTOPagina = array_slice($arrObjRelProtocoloProtocoloDTO, ($objVisualizarProcessoFederacaoDTO->getNumPagProtocolos() * $objVisualizarProcessoFederacaoDTO->getNumMaxProtocolos()), $objVisualizarProcessoFederacaoDTO->getNumMaxProtocolos());

        $objVisualizarProcessoFederacaoDTORet->setNumRegProtocolos(count($arrObjRelProtocoloProtocoloDTOPagina));
        $objVisualizarProcessoFederacaoDTORet->setNumTotProtocolos(count($arrObjRelProtocoloProtocoloDTO));

        if (count($arrObjRelProtocoloProtocoloDTOPagina)) {
          $objProcedimentoDTO->setArrObjRelProtocoloProtocoloDTO($arrObjRelProtocoloProtocoloDTOPagina);
        }
      }

      if ($arrIdDocumento!=null){
        $objProcedimentoDTO->setArrDblIdProtocoloAssociado($arrIdDocumento);
      }

      $objProcedimentoRN = new ProcedimentoRN();
      $arrObjProcedimentoDTO = $objProcedimentoRN->listarCompleto($objProcedimentoDTO);

      if (count($arrObjProcedimentoDTO) == 0) {
        throw new InfraException('Processo n�o encontrado.');
      }

      $objProcedimentoDTO = $arrObjProcedimentoDTO[0];

      if ($arrIdDocumento==null) {
        $objParticipanteDTO = new ParticipanteDTO();
        $objParticipanteDTO->retStrSiglaContato();
        $objParticipanteDTO->retStrNomeContato();
        $objParticipanteDTO->setDblIdProtocolo($dblIdProcedimento);
        $objParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_INTERESSADO);

        $objParticipanteRN = new ParticipanteRN();
        $objProcedimentoDTO->setArrObjParticipanteDTO($objParticipanteRN->listarRN0189($objParticipanteDTO));
      }

      $arrRet = array();

      $arrObjRelProtocoloProtocoloDTO = $objProcedimentoDTO->getArrObjRelProtocoloProtocoloDTO();

      $objProtocoloRN = new ProtocoloRN();

      if (InfraArray::contar($arrObjRelProtocoloProtocoloDTO)) {

        $objDocumentoRN = new DocumentoRN();

        foreach ($arrObjRelProtocoloProtocoloDTO as $objRelProtocoloProtocoloDTO) {

          $objRelProtocoloProtocoloDTO->setStrSinAcessoBasico('N');

          if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO) {

            $objDocumentoDTO = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();

            if ($objDocumentoDTO->getStrIdProtocoloFederacaoProtocolo()==null){
              $objProtocoloDTO = new ProtocoloDTO();
              $objProtocoloDTO->setDblIdProtocolo($objDocumentoDTO->getDblIdDocumento());
              $objProtocoloRN->gerarIdentificadorFederacao($objProtocoloDTO);
              $objDocumentoDTO->setStrIdProtocoloFederacaoProtocolo($objProtocoloDTO->getStrIdProtocoloFederacao());
            }

            if ($objDocumentoRN->verificarSelecaoAcessoBasico($objDocumentoDTO)) {
              $objRelProtocoloProtocoloDTO->setStrSinAcessoBasico('S');
            }

            if ($arrIdDocumento!=null){
              if ($objDocumentoDTO->getStrStaEstadoProtocolo() == ProtocoloRN::$TE_DOCUMENTO_CANCELADO) {
                //ALERT
                $objInfraException->lancarValidacao('Documento '.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().' foi cancelado.');
              }

              if ($objRelProtocoloProtocoloDTO->getStrSinAcessoBasico()=='N'){
                //ALERT
                $objInfraException->lancarValidacao('Sem acesso ao documento '.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'.');
              }
            }

            $arrRet[] = $objRelProtocoloProtocoloDTO;

          } else if ($objRelProtocoloProtocoloDTO->getStrStaAssociacao() == RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO) {

            $objProcedimentoDTOAnexado = $objRelProtocoloProtocoloDTO->getObjProtocoloDTO2();

            if ($objProcedimentoDTOAnexado->getStrIdProtocoloFederacaoProtocolo()==null){
              $objProtocoloDTO = new ProtocoloDTO();
              $objProtocoloDTO->setDblIdProtocolo($objProcedimentoDTOAnexado->getDblIdProcedimento());
              $objProtocoloRN->gerarIdentificadorFederacao($objProtocoloDTO);
              $objProcedimentoDTOAnexado->setStrIdProtocoloFederacaoProtocolo($objProtocoloDTO->getStrIdProtocoloFederacao());
            }

            $objRelProtocoloProtocoloDTO->setStrSinAcessoBasico('S');

            $arrRet[] = $objRelProtocoloProtocoloDTO;
          }
        }
      }

      $objProcedimentoDTO->setArrObjRelProtocoloProtocoloDTO($arrRet);

      if ($objVisualizarProcessoFederacaoDTO->getStrSinAndamentos()=='S'){

        $objProcedimentoHistoricoDTO = new ProcedimentoHistoricoDTO();
        $objProcedimentoHistoricoDTO->setDblIdProcedimento($objProcedimentoDTO->getDblIdProcedimento());
        $objProcedimentoHistoricoDTO->setStrStaHistorico(ProcedimentoRN::$TH_EXTERNO);
        $objProcedimentoHistoricoDTO->setStrSinGerarLinksHistorico('N');

        //pagina��o
        $objProcedimentoHistoricoDTO->setNumMaxRegistrosRetorno($objVisualizarProcessoFederacaoDTO->getNumMaxAndamentos());
        $objProcedimentoHistoricoDTO->setNumPaginaAtual($objVisualizarProcessoFederacaoDTO->getNumPagAndamentos());

        $objProcedimentoDTORet = $objProcedimentoRN->consultarHistoricoRN1025($objProcedimentoHistoricoDTO);

        //pagina��o
        $objVisualizarProcessoFederacaoDTORet->setNumRegAndamentos($objProcedimentoHistoricoDTO->getNumRegistrosPaginaAtual());
        $objVisualizarProcessoFederacaoDTORet->setNumTotAndamentos($objProcedimentoHistoricoDTO->getNumTotalRegistros());

        $objProcedimentoDTO->setArrObjAtividadeDTO($objProcedimentoDTORet->getArrObjAtividadeDTO());
      }

      $objVisualizarProcessoFederacaoDTORet->setObjProcedimentoDTO($objProcedimentoDTO);

      return $objVisualizarProcessoFederacaoDTORet;

    } catch (Exception $e) {
      throw new InfraException('Erro consultando processo do SEI Federa��o.', $e);
    }
  }

  protected function pesquisarOrgaosUnidadesEnvioConectado(AcessoFederacaoDTO $objAcessoFederacaoDTO) {
    try{

      $strPalavrasPesquisa = null;
      if ($objAcessoFederacaoDTO->isSetStrPalavrasPesquisa()) {
        $strPalavrasPesquisa = InfraString::prepararIndexacao($objAcessoFederacaoDTO->getStrPalavrasPesquisa(), true);
      }

      if (!$objAcessoFederacaoDTO->isSetStrStaTipoFiltroUnidades()){
        $objAcessoFederacaoDTO->setStrStaTipoFiltroUnidades(self::$TFU_RECEBIMENTO);
      }

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
      $objInstalacaoFederacaoDTO->retStrSigla();
      $objInstalacaoFederacaoDTO->retStrDescricao();

      if ($objAcessoFederacaoDTO->isSetStrIdInstalacaoFederacaoDest()) {
        if (!is_array($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest())) {
          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest());
        }else{
          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest(), InfraDTO::$OPER_IN);
        }
      }

      $objInstalacaoFederacaoDTO->setStrStaEstado(InstalacaoFederacaoRN::$EI_LIBERADA);
      $objInstalacaoFederacaoDTO->setStrStaTipo(InstalacaoFederacaoRN::$TI_LOCAL,InfraDTO::$OPER_DIFERENTE);
      $objInstalacaoFederacaoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $arrObjInstalacaoFederacaoDTO = $objInstalacaoFederacaoRN->listar($objInstalacaoFederacaoDTO);

      $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
      $objUnidadeFederacaoRN = new UnidadeFederacaoRN();

      foreach ($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO) {

        try {

          $objInstalacaoFederacaoDTO->setObjInfraException(null);

          $objInstalacaoRemota = $objInstalacaoFederacaoRN->executar('pesquisarOrgaosUnidades', $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao(), $strPalavrasPesquisa, $objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades());

          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoRemota->IdInstalacaoFederacao);
          $objInstalacaoFederacaoDTO->setStrSigla($objInstalacaoRemota->Sigla);
          $objInstalacaoFederacaoDTO->setStrDescricao($objInstalacaoRemota->Descricao);
          $objInstalacaoFederacaoRN->sincronizar($objInstalacaoFederacaoDTO);

          $objInstalacaoFederacaoDTO->setStrSeiVersao($objInstalacaoFederacaoRN->tratarSeiVersao($objInstalacaoRemota->SeiVersao));
          $objInstalacaoFederacaoDTO->setStrSeiFederacaoVersao($objInstalacaoFederacaoRN->tratarSeiFederacaoVersao($objInstalacaoRemota->SeiFederacaoVersao));

          $arrOrgaos = $objInstalacaoRemota->Orgaos;

          $arrObjOrgaoFederacaoDTO = array();

          foreach ($arrOrgaos as $objOrgao) {

            $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
            $objOrgaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
            $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($objOrgao->IdOrgaoFederacao);
            $objOrgaoFederacaoDTO->setStrSigla($objOrgao->Sigla);
            $objOrgaoFederacaoDTO->setStrDescricao($objOrgao->Descricao);
            $objOrgaoFederacaoRN->sincronizar($objOrgaoFederacaoDTO);

            $arrUnidades = $objOrgao->Unidades;

            $arrObjUnidadeFederacaoDTO = array();

            foreach ($arrUnidades as $objUnidade) {
              $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
              $objUnidadeFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
              $objUnidadeFederacaoDTO->setStrIdUnidadeFederacao($objUnidade->IdUnidadeFederacao);
              $objUnidadeFederacaoDTO->setStrSigla($objUnidade->Sigla);
              $objUnidadeFederacaoDTO->setStrDescricao($objUnidade->Descricao);
              $arrObjUnidadeFederacaoDTO[] = $objUnidadeFederacaoDTO;
              $objUnidadeFederacaoRN->sincronizar($objUnidadeFederacaoDTO);
            }
            $objOrgaoFederacaoDTO->setArrObjUnidadeFederacaoDTO($arrObjUnidadeFederacaoDTO);

            $arrObjOrgaoFederacaoDTO[] = $objOrgaoFederacaoDTO;
          }

          $objInstalacaoFederacaoDTO->setArrObjOrgaoFederacaoDTO($arrObjOrgaoFederacaoDTO);

        } catch (Exception $e) {
          //se ocorreu erro sinaliza e loga
          try {
            $objInstalacaoFederacaoDTO->setObjInfraException($e);
            LogSEI::getInstance()->gravar(InfraException::inspecionar($e));
          } catch (Exception $e2) {
          }
        }
      }


      $arrInstalacoes = array();
      $arrOrgaos = array();
      $arrUnidades = array();

      foreach($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO) {

        if ($objInstalacaoFederacaoDTO->getObjInfraException()==null) {

          $strIdInstalacaoFederacao = $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao();

          if (isset($arrInstalacoes[$strIdInstalacaoFederacao])) {
            throw new InfraException('Identificador do SEI Federa��o '.$strIdInstalacaoFederacao.' duplicado para as instala��es '.$objInstalacaoFederacaoDTO->getStrSigla().' e '.$arrInstalacoes[$strIdInstalacaoFederacao]->getStrSigla().'.');
          }

          if (!InfraULID::validar($strIdInstalacaoFederacao)){
            throw new InfraException('Identificador do SEI Federa��o '.$strIdInstalacaoFederacao.' inv�lido para a instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.');
          }

          $arrInstalacoes[$strIdInstalacaoFederacao] = $objInstalacaoFederacaoDTO;

          $arrOrgaosInstalacao = array();
          $arrUnidadesInstalacao = array();
          foreach($objInstalacaoFederacaoDTO->getArrObjOrgaoFederacaoDTO() as $objOrgaoFederacaoDTO){
            $arrOrgaosInstalacao[$objOrgaoFederacaoDTO->getStrIdOrgaoFederacao()] = $objOrgaoFederacaoDTO;
            foreach($objOrgaoFederacaoDTO->getArrObjUnidadeFederacaoDTO() as $objUnidadeFederacaoDTO){
              $arrUnidadesInstalacao[$objUnidadeFederacaoDTO->getStrIdUnidadeFederacao()] = $objUnidadeFederacaoDTO;
            }
          }

          foreach($arrOrgaosInstalacao as $objOrgaoFederacaoDTO) {

            $strIdOrgaoFederacao = $objOrgaoFederacaoDTO->getStrIdOrgaoFederacao();

            if (isset($arrOrgaos[$strIdOrgaoFederacao])) {
              throw new InfraException('Identificador do SEI Federa��o '.$strIdOrgaoFederacao.' duplicado para os �rg�os '.$objOrgaoFederacaoDTO->getStrSigla().' da instala��o '.$arrInstalacoes[$objOrgaoFederacaoDTO->getStrIdInstalacaoFederacao()]->getStrSigla().' e '.$arrOrgaos[$strIdOrgaoFederacao]->getStrSigla().' da instala��o '.$arrInstalacoes[$arrOrgaos[$strIdOrgaoFederacao]->getStrIdInstalacaoFederacao()]->getStrSigla().'.');
            }

            if (!InfraULID::validar($strIdOrgaoFederacao)) {
              throw new InfraException('Identificador do SEI Federa��o '.$strIdOrgaoFederacao.' inv�lido para o �rg�o '.$objOrgaoFederacaoDTO->getStrSigla().' da instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.');
            }

            $arrOrgaos[$strIdOrgaoFederacao] = $objOrgaoFederacaoDTO;
          }

          foreach ($arrUnidadesInstalacao as $objUnidadeFederacaoDTO) {

            $strIdUnidadeFederacao = $objUnidadeFederacaoDTO->getStrIdUnidadeFederacao();

            if (isset($arrUnidades[$strIdUnidadeFederacao])) {
              throw new InfraException('Identificador do SEI Federa��o '.$strIdUnidadeFederacao.' duplicado para as unidades '.$objUnidadeFederacaoDTO->getStrSigla().' da instala��o '.$arrInstalacoes[$objUnidadeFederacaoDTO->getStrIdInstalacaoFederacao()]->getStrSigla().' e '.$arrUnidades[$strIdUnidadeFederacao]->getStrSigla().' da instala��o '.$arrInstalacoes[$arrUnidades[$strIdUnidadeFederacao]->getStrIdInstalacaoFederacao()]->getStrSigla().'.');
            }

            if (!InfraULID::validar($strIdUnidadeFederacao)) {
              throw new InfraException('Identificador do SEI Federa��o '.$strIdUnidadeFederacao.' inv�lido para a unidade '.$objUnidadeFederacaoDTO->getStrSigla().' da instala��o '.$arrInstalacoes[$objUnidadeFederacaoDTO->getStrIdInstalacaoFederacao()]->getStrSigla().'.');
            }

            $arrUnidades[$strIdUnidadeFederacao] = $objUnidadeFederacaoDTO;
          }
        }
      }


      return $arrObjInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando �rg�os e unidades do SEI Federa��o.',$e);
    }
  }

  protected function processarPesquisaOrgaosUnidadesConectado(AcessoFederacaoDTO $objAcessoFederacaoDTO){
    try{

      $objInfraException = new InfraException();

      $objAcessoFederacaoDTO->setStrPalavrasPesquisa(InfraString::prepararIndexacao($objAcessoFederacaoDTO->getStrPalavrasPesquisa(),true));

      if (InfraString::isBolVazia($objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades())){
        $objAcessoFederacaoDTO->setStrStaTipoFiltroUnidades(self::$TFU_RECEBIMENTO);
      }

      if (!in_array($objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades(),array(self::$TFU_TODAS, self::$TFU_RECEBIMENTO))){
        $objInfraException->lancarValidacao('Tipo do filtro de unidades inv�lido.');
      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

      $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
      $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal());
      $objInstalacaoFederacaoDTO->setStrSigla($objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal());
      $objInstalacaoFederacaoDTO->setStrDescricao($objInstalacaoFederacaoRN->obterDescricaoInstalacaoLocal());
      $objInstalacaoFederacaoDTO->setStrSeiVersao(SEI_VERSAO);
      $objInstalacaoFederacaoDTO->setStrSeiFederacaoVersao(SEI_FEDERACAO_VERSAO);

      $arrObjOrgaoFederacaoDTO = array();

      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->retNumIdOrgao();
      $objOrgaoDTO->retStrIdOrgaoFederacao();
      $objOrgaoDTO->retStrSigla();
      $objOrgaoDTO->retStrDescricao();
      $objOrgaoDTO->retNumIdUnidade();

      if ($objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades() == self::$TFU_RECEBIMENTO) {
        $objOrgaoDTO->setStrSinFederacaoRecebimento('S');
      }

      $objOrgaoDTO->setStrPalavrasPesquisa($objAcessoFederacaoDTO->getStrPalavrasPesquisa());

      $objOrgaoDTO->setNumIdUnidade(null,InfraDTO::$OPER_DIFERENTE);
      $objOrgaoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objOrgaoRN = new OrgaoRN();
      $arrObjOrgaoDTO = $objOrgaoRN->pesquisar($objOrgaoDTO);

      if (count($arrObjOrgaoDTO)) {

        $objUnidadeDTO = new UnidadeDTO();
        $objUnidadeDTO->setBolExclusaoLogica(false);
        $objUnidadeDTO->retNumIdUnidade();
        $objUnidadeDTO->retNumIdOrgao();
        $objUnidadeDTO->retStrIdUnidadeFederacao();
        $objUnidadeDTO->retStrSigla();
        $objUnidadeDTO->retStrDescricao();

        if ($objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades() == self::$TFU_RECEBIMENTO) {
          $objUnidadeDTO->setNumIdUnidade(array_unique(InfraArray::converterArrInfraDTO($arrObjOrgaoDTO,'IdUnidade')), InfraDTO::$OPER_IN);
        }else{
          $objUnidadeDTO->setNumIdOrgao(InfraArray::converterArrInfraDTO($arrObjOrgaoDTO,'IdOrgao'), InfraDTO::$OPER_IN);
        }

        $objUnidadeDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objUnidadeRN = new UnidadeRN();
        $arrObjUnidadeDTO = $objUnidadeRN->listarRN0127($objUnidadeDTO);

        //gera/valida ULIDs para as unidades
        foreach ($arrObjUnidadeDTO as $objUnidadeDTO) {
          if ($objUnidadeDTO->getStrIdUnidadeFederacao() == null) {
            $objUnidadeRN->gerarIdentificadorFederacao($objUnidadeDTO);
          } else if (!InfraULID::validar($objUnidadeDTO->getStrIdUnidadeFederacao())) {
            throw new InfraException('Identificador do SEI Federa��o '.$objUnidadeDTO->getStrIdUnidadeFederacao().' inv�lido para a unidade '.$objUnidadeDTO->getStrSigla().' na instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.');
          }
        }

        $arrObjUnidadeDTO = InfraArray::indexarArrInfraDTO($arrObjUnidadeDTO, 'IdUnidade');

        //gera ULIDs para os �rg�os que ainda n�o possuem
        foreach ($arrObjOrgaoDTO as $objOrgaoDTO) {
          if ($objOrgaoDTO->getStrIdOrgaoFederacao() == null) {
            $objOrgaoRN->gerarIdentificadorFederacao($objOrgaoDTO);
          } else if (!InfraULID::validar($objOrgaoDTO->getStrIdOrgaoFederacao())) {
            throw new InfraException('Identificador do SEI Federa��o '.$objOrgaoDTO->getStrIdOrgaoFederacao().' inv�lido para o �rg�o '.$objOrgaoDTO->getStrSigla().' da instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.');
          }

          $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
          $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($objOrgaoDTO->getStrIdOrgaoFederacao());
          $objOrgaoFederacaoDTO->setStrSigla($objOrgaoDTO->getStrSigla());
          $objOrgaoFederacaoDTO->setStrDescricao($objOrgaoDTO->getStrDescricao());

          $arrObjUnidadeFederacaoDTO = array();
          if ($objAcessoFederacaoDTO->getStrStaTipoFiltroUnidades() == self::$TFU_RECEBIMENTO) {

            if (!isset($arrObjUnidadeDTO[$objOrgaoDTO->getNumIdUnidade()])) {
              throw new InfraException('Unidade para recebimento de processos do SEI Federa��o n�o encontrada para o �rg�o '.$objOrgaoDTO->getStrSigla().' da instala��o '.$objInstalacaoFederacaoDTO->getStrSigla().'.');
            }

            $objUnidadeDTO = $arrObjUnidadeDTO[$objOrgaoDTO->getNumIdUnidade()];
            $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
            $objUnidadeFederacaoDTO->setStrIdUnidadeFederacao($objUnidadeDTO->getStrIdUnidadeFederacao());
            $objUnidadeFederacaoDTO->setStrSigla($objUnidadeDTO->getStrSigla());
            $objUnidadeFederacaoDTO->setStrDescricao($objUnidadeDTO->getStrDescricao());
            $arrObjUnidadeFederacaoDTO[] = $objUnidadeFederacaoDTO;

          }else{

            foreach($arrObjUnidadeDTO as $objUnidadeDTO){
              if ($objUnidadeDTO->getNumIdOrgao()==$objOrgaoDTO->getNumIdOrgao()){
                $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
                $objUnidadeFederacaoDTO->setStrIdUnidadeFederacao($objUnidadeDTO->getStrIdUnidadeFederacao());
                $objUnidadeFederacaoDTO->setStrSigla($objUnidadeDTO->getStrSigla());
                $objUnidadeFederacaoDTO->setStrDescricao($objUnidadeDTO->getStrDescricao());
                $arrObjUnidadeFederacaoDTO[] = $objUnidadeFederacaoDTO;
              }
            }
          }

          $objOrgaoFederacaoDTO->setArrObjUnidadeFederacaoDTO($arrObjUnidadeFederacaoDTO);
          $arrObjOrgaoFederacaoDTO[] = $objOrgaoFederacaoDTO;
        }
      }

      $objInstalacaoFederacaoDTO->setArrObjOrgaoFederacaoDTO($arrObjOrgaoFederacaoDTO);

      return $objInstalacaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro processando listagem de �rg�os e unidades da Instala��o do SEI Federa��o.',$e);
    }
  }

  protected function gerarPdfConectado(VisualizarProcessoFederacaoDTO $objVisualizarProcessoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('procedimento_gerar_pdf', __METHOD__, $objVisualizarProcessoFederacaoDTO);

      $objProcedimento = new stdClass();
      $objProcedimento->IdProcedimentoFederacao = $objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao();

      $arrIdProtocolo = array();
      foreach($objVisualizarProcessoFederacaoDTO->getStrIdDocumentoFederacao() as $strIdDocumentoFederacao){
        $objProtocolo = new stdClass();
        $objProtocolo->IdProtocoloFederacao = $strIdDocumentoFederacao;
        $arrProtocolo[] = $objProtocolo;
      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $strLinkAcesso = $objInstalacaoFederacaoRN->executar('gerarPdf', $objVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao(), $objProcedimento, $arrProtocolo);

      return $strLinkAcesso;

    }catch(Exception $e){
      throw new InfraException('Erro gerando PDF do SEI Federa��o.',$e);
    }
  }

  protected function processarGeracaoPdfControlado(AcessoFederacaoDTO $objAcessoFederacaoDTO)
  {
    try {

      $objAcaoFederacaoDTO = new AcaoFederacaoDTO();
      $objAcaoFederacaoDTO->setStrIdAcaoFederacao(InfraULID::gerar());
      $objAcaoFederacaoDTO->setStrIdInstalacaoFederacao($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdOrgaoFederacao($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUnidadeFederacao($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUsuarioFederacao($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcaoFederacaoDTO->setStrIdDocumentoFederacao(null);
      $objAcaoFederacaoDTO->setDthGeracao(Infradata::getStrDataHoraAtual());
      $objAcaoFederacaoDTO->setDthAcesso(null);
      $objAcaoFederacaoDTO->setNumStaTipo(AcaoFederacaoRN::$TA_GERAR_PDF);
      $objAcaoFederacaoDTO->setStrSinAtivo('S');

      $objParametroAcaoFederacaoDTO = new ParametroAcaoFederacaoDTO();
      $objParametroAcaoFederacaoDTO->setStrNome('id_protocolo_federacao');
      $objParametroAcaoFederacaoDTO->setStrValor(implode(',',$objAcessoFederacaoDTO->getStrIdDocumentoFederacao()));

      $objAcaoFederacaoDTO->setArrObjParametroAcaoFederacaoDTO(array($objParametroAcaoFederacaoDTO));

      $objAcaoFederacaoRN = new AcaoFederacaoRN();
      $objAcaoFederacaoRN->cadastrar($objAcaoFederacaoDTO);

      return ConfiguracaoSEI::getInstance()->getValor('SEI', 'URL') . '/controlador_federacao.php?acao='.$objAcaoFederacaoDTO->getStrIdAcaoFederacao();

    } catch (Exception $e) {
      throw new InfraException('Erro processando gera��o de PDF do SEI Federa��o.', $e);
    }
  }

  protected function gerarZipConectado(VisualizarProcessoFederacaoDTO $objVisualizarProcessoFederacaoDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('procedimento_gerar_zip', __METHOD__, $objVisualizarProcessoFederacaoDTO);

      $objProcedimento = new stdClass();
      $objProcedimento->IdProcedimentoFederacao = $objVisualizarProcessoFederacaoDTO->getStrIdProcedimentoFederacao();

      $arrProtocolo = array();
      foreach($objVisualizarProcessoFederacaoDTO->getStrIdDocumentoFederacao() as $strIdProtocoloFederacao){
        $objProtocolo = new stdClass();
        $objProtocolo->IdProtocoloFederacao = $strIdProtocoloFederacao;
        $arrProtocolo[] = $objProtocolo;
      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $strLinkAcesso = $objInstalacaoFederacaoRN->executar('gerarZip', $objVisualizarProcessoFederacaoDTO->getStrIdInstalacaoFederacao(), $objProcedimento, $arrProtocolo);

      return $strLinkAcesso;

    }catch(Exception $e){
      throw new InfraException('Erro gerando ZIP do SEI Federa��o.',$e);
    }
  }

  protected function processarGeracaoZipControlado(AcessoFederacaoDTO $objAcessoFederacaoDTO)
  {
    try {

      $objAcaoFederacaoDTO = new AcaoFederacaoDTO();
      $objAcaoFederacaoDTO->setStrIdAcaoFederacao(InfraULID::gerar());
      $objAcaoFederacaoDTO->setStrIdInstalacaoFederacao($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdOrgaoFederacao($objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUnidadeFederacao($objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdUsuarioFederacao($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem());
      $objAcaoFederacaoDTO->setStrIdProcedimentoFederacao($objAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcaoFederacaoDTO->setStrIdDocumentoFederacao(null);
      $objAcaoFederacaoDTO->setDthGeracao(Infradata::getStrDataHoraAtual());
      $objAcaoFederacaoDTO->setDthAcesso(null);
      $objAcaoFederacaoDTO->setNumStaTipo(AcaoFederacaoRN::$TA_GERAR_ZIP);
      $objAcaoFederacaoDTO->setStrSinAtivo('S');

      $objParametroAcaoFederacaoDTO = new ParametroAcaoFederacaoDTO();
      $objParametroAcaoFederacaoDTO->setStrNome('id_protocolo_federacao');
      $objParametroAcaoFederacaoDTO->setStrValor(implode(',',$objAcessoFederacaoDTO->getStrIdDocumentoFederacao()));

      $objAcaoFederacaoDTO->setArrObjParametroAcaoFederacaoDTO(array($objParametroAcaoFederacaoDTO));

      $objAcaoFederacaoRN = new AcaoFederacaoRN();
      $objAcaoFederacaoRN->cadastrar($objAcaoFederacaoDTO);

      return ConfiguracaoSEI::getInstance()->getValor('SEI', 'URL') . '/controlador_federacao.php?acao='.$objAcaoFederacaoDTO->getStrIdAcaoFederacao();

    } catch (Exception $e) {
      throw new InfraException('Erro processando gera��o de ZIP do SEI Federa��o.', $e);
    }
  }

  protected function replicarAcessosConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO)
  {
    try {

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdUsuarioFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoDest();
      $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoDest();
      $objAcessoFederacaoDTO->retStrIdUsuarioFederacaoDest();
      $objAcessoFederacaoDTO->retStrIdProcedimentoFederacao();
      $objAcessoFederacaoDTO->retStrIdDocumentoFederacao();
      $objAcessoFederacaoDTO->retDthLiberacao();
      $objAcessoFederacaoDTO->retStrMotivoLiberacao();
      $objAcessoFederacaoDTO->retDthCancelamento();
      $objAcessoFederacaoDTO->retStrMotivoCancelamento();
      $objAcessoFederacaoDTO->retNumStaTipo();
      $objAcessoFederacaoDTO->retStrSinAtivo();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcessoFederacaoDTO->setOrdStrIdAcessoFederacao(InfraDTO::$TIPO_ORDENACAO_ASC);

      $arrObjAcessoFederacaoDTO = $this->listar($objAcessoFederacaoDTO);

      $objProcedimento = new stdClass();
      $objProcedimento->IdProcedimentoFederacao = $parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao();
      $objProcedimento->VersaoAcessos = $this->formatarVersaoAcessos($arrObjAcessoFederacaoDTO);

      if (count($arrObjAcessoFederacaoDTO)) {

          $arrObjAcessos = array();
          $arrIdInstalacaoFederacao = array();
          $arrIdOrgaoFederacao = array();
          $arrIdUnidadeFederacao = array();
          $arrIdUsuarioFederacao = array();
          $arrIdDocumentoFederacao = array();

          foreach ($arrObjAcessoFederacaoDTO as $objAcessoFederacaoDTO) {
            $objAcesso = new stdClass();
            $objAcesso->IdAcessoFederacao = $objAcessoFederacaoDTO->getStrIdAcessoFederacao();
            $objAcesso->IdInstalacaoFederacaoRem = $objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem();
            $objAcesso->IdOrgaoFederacaoRem = $objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem();
            $objAcesso->IdUnidadeFederacaoRem = $objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem();
            $objAcesso->IdUsuarioFederacaoRem = $objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem();
            $objAcesso->IdInstalacaoFederacaoDest = $objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest();
            $objAcesso->IdOrgaoFederacaoDest = $objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest();
            $objAcesso->IdUnidadeFederacaoDest = $objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest();
            $objAcesso->IdUsuarioFederacaoDest = $objAcessoFederacaoDTO->getStrIdUsuarioFederacaoDest();
            $objAcesso->IdProcedimentoFederacao = $objAcessoFederacaoDTO->getStrIdProcedimentoFederacao();
            $objAcesso->IdDocumentoFederacao = $objAcessoFederacaoDTO->getStrIdDocumentoFederacao();
            $objAcesso->DthLiberacao = $objAcessoFederacaoDTO->getDthLiberacao();
            $objAcesso->MotivoLiberacao = $objAcessoFederacaoDTO->getStrMotivoLiberacao();
            $objAcesso->DthCancelamento = $objAcessoFederacaoDTO->getDthCancelamento();
            $objAcesso->MotivoCancelamento = $objAcessoFederacaoDTO->getStrMotivoCancelamento();
            $objAcesso->StaTipo = $objAcessoFederacaoDTO->getNumStaTipo();
            $objAcesso->SinAtivo = $objAcessoFederacaoDTO->getStrSinAtivo();
            $arrObjAcessos[] = $objAcesso;

            if ($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem()!=$parObjAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest()){
              $arrIdInstalacaoFederacao[$objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoRem()] = true;
              $arrIdOrgaoFederacao[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem()] = true;
              $arrIdUnidadeFederacao[$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoRem()] = true;
              if ($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem()!=null) {
                $arrIdUsuarioFederacao[$objAcessoFederacaoDTO->getStrIdUsuarioFederacaoRem()] = true;
              }
            }

            if ($objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest()!=$parObjAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest()){
              $arrIdInstalacaoFederacao[$objAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest()] = true;
              $arrIdOrgaoFederacao[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()] = true;
              $arrIdUnidadeFederacao[$objAcessoFederacaoDTO->getStrIdUnidadeFederacaoDest()] = true;
              if ($objAcessoFederacaoDTO->getStrIdUsuarioFederacaoDest()!=null) {
                $arrIdUsuarioFederacao[$objAcessoFederacaoDTO->getStrIdUsuarioFederacaoDest()] = true;
              }
            }

            if ($objAcessoFederacaoDTO->getStrIdDocumentoFederacao()!=null){
              $arrIdDocumentoFederacao[$objAcessoFederacaoDTO->getStrIdDocumentoFederacao()] = true;
            }
          }

          $arrObjProtocoloFederacao = array();
          if (count($arrIdDocumentoFederacao)){
            $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
            $objProtocoloFederacaoDTO->retStrIdProtocoloFederacao();
            $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
            $objProtocoloFederacaoDTO->retStrProtocoloFormatado();
            $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
            $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao(array_keys($arrIdDocumentoFederacao), InfraDTO::$OPER_IN);

            $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
            $arrObjProtocoloFederacaoDTO = $objProtocoloFederacaoRN->listar($objProtocoloFederacaoDTO);

            foreach($arrObjProtocoloFederacaoDTO as $objProtocoloFederacaoDTO){
              $objProtocoloFederacao = new stdClass();
              $objProtocoloFederacao->IdProtocoloFederacao = $objProtocoloFederacaoDTO->getStrIdProtocoloFederacao();
              $objProtocoloFederacao->IdInstalacaoFederacao = $objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao();
              $objProtocoloFederacao->ProtocoloFormatado = $objProtocoloFederacaoDTO->getStrProtocoloFormatado();
              $arrObjProtocoloFederacao[] = $objProtocoloFederacao;
            }
          }

          $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
          $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
          $objInstalacaoFederacaoDTO->retDblCnpj();
          $objInstalacaoFederacaoDTO->retStrSigla();
          $objInstalacaoFederacaoDTO->retStrDescricao();
          $objInstalacaoFederacaoDTO->retStrEndereco();
          $objInstalacaoFederacaoDTO->setStrIdInstalacaoFederacao(array_keys($arrIdInstalacaoFederacao), InfraDTO::$OPER_IN);

          $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
          $arrObjInstalacaoFederacaoDTO = $objInstalacaoFederacaoRN->listar($objInstalacaoFederacaoDTO);

          $arrObjInstalacoes = array();
          foreach ($arrObjInstalacaoFederacaoDTO as $objInstalacaoFederacaoDTO) {
            $objInstalacao = new stdClass();
            $objInstalacao->IdInstalacaoFederacao = $objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao();
            $objInstalacao->Cnpj = $objInstalacaoFederacaoDTO->getDblCnpj();
            $objInstalacao->Sigla = $objInstalacaoFederacaoDTO->getStrSigla();
            $objInstalacao->Descricao = $objInstalacaoFederacaoDTO->getStrDescricao();
            $objInstalacao->Endereco = $objInstalacaoFederacaoDTO->getStrEndereco();
            $arrObjInstalacoes[] = $objInstalacao;
          }

          $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
          $objOrgaoFederacaoDTO->retStrIdOrgaoFederacao();
          $objOrgaoFederacaoDTO->retStrIdInstalacaoFederacao();
          $objOrgaoFederacaoDTO->retStrSigla();
          $objOrgaoFederacaoDTO->retStrDescricao();
          $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao(array_keys($arrIdOrgaoFederacao), InfraDTO::$OPER_IN);

          $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
          $arrObjOrgaoFederacaoDTO = $objOrgaoFederacaoRN->listar($objOrgaoFederacaoDTO);

          $arrObjOrgaos = array();
          foreach ($arrObjOrgaoFederacaoDTO as $objOrgaoFederacaoDTO) {
            $objOrgao = new stdClass();
            $objOrgao->IdOrgaoFederacao = $objOrgaoFederacaoDTO->getStrIdOrgaoFederacao();
            $objOrgao->IdInstalacaoFederacao = $objOrgaoFederacaoDTO->getStrIdInstalacaoFederacao();
            $objOrgao->Sigla = $objOrgaoFederacaoDTO->getStrSigla();
            $objOrgao->Descricao = $objOrgaoFederacaoDTO->getStrDescricao();
            $arrObjOrgaos[] = $objOrgao;
          }

          $objUnidadeFederacaoDTO = new UnidadeFederacaoDTO();
          $objUnidadeFederacaoDTO->retStrIdUnidadeFederacao();
          $objUnidadeFederacaoDTO->retStrIdInstalacaoFederacao();
          $objUnidadeFederacaoDTO->retStrSigla();
          $objUnidadeFederacaoDTO->retStrDescricao();
          $objUnidadeFederacaoDTO->setStrIdUnidadeFederacao(array_keys($arrIdUnidadeFederacao), InfraDTO::$OPER_IN);

          $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
          $arrObjUnidadeFederacaoDTO = $objUnidadeFederacaoRN->listar($objUnidadeFederacaoDTO);

          $arrObjUnidades = array();
          foreach ($arrObjUnidadeFederacaoDTO as $objUnidadeFederacaoDTO) {
            $objUnidade = new stdClass();
            $objUnidade->IdUnidadeFederacao = $objUnidadeFederacaoDTO->getStrIdUnidadeFederacao();
            $objUnidade->IdInstalacaoFederacao = $objUnidadeFederacaoDTO->getStrIdInstalacaoFederacao();
            $objUnidade->Sigla = $objUnidadeFederacaoDTO->getStrSigla();
            $objUnidade->Descricao = $objUnidadeFederacaoDTO->getStrDescricao();
            $arrObjUnidades[] = $objUnidade;
          }

          $arrObjUsuarios = array();
          if (count($arrIdUsuarioFederacao)) {
            $objUsuarioFederacaoDTO = new UsuarioFederacaoDTO();
            $objUsuarioFederacaoDTO->retStrIdUsuarioFederacao();
            $objUsuarioFederacaoDTO->retStrIdInstalacaoFederacao();
            $objUsuarioFederacaoDTO->retStrSigla();
            $objUsuarioFederacaoDTO->retStrNome();
            $objUsuarioFederacaoDTO->setStrIdUsuarioFederacao(array_keys($arrIdUsuarioFederacao), InfraDTO::$OPER_IN);

            $objUsuarioFederacaoRN = new UsuarioFederacaoRN();
            $arrObjUsuarioFederacaoDTO = $objUsuarioFederacaoRN->listar($objUsuarioFederacaoDTO);

            foreach ($arrObjUsuarioFederacaoDTO as $objUsuarioFederacaoDTO) {
              $objUsuario = new stdClass();
              $objUsuario->IdUsuarioFederacao = $objUsuarioFederacaoDTO->getStrIdUsuarioFederacao();
              $objUsuario->IdInstalacaoFederacao = $objUsuarioFederacaoDTO->getStrIdInstalacaoFederacao();
              $objUsuario->Sigla = $objUsuarioFederacaoDTO->getStrSigla();
              $objUsuario->Nome = $objUsuarioFederacaoDTO->getStrNome();
              $arrObjUsuarios[] = $objUsuario;
            }
          }

          $objInstalacaoFederacaoRN->executar('replicarAcessos',
                                              $parObjAcessoFederacaoDTO->getStrIdInstalacaoFederacaoDest(),
                                              $objProcedimento,
                                              $arrObjAcessos,
                                              $arrObjInstalacoes,
                                              $arrObjOrgaos,
                                              $arrObjUnidades,
                                              $arrObjUsuarios,
                                              $arrObjProtocoloFederacao);
        }

    } catch (Exception $e) {
      throw new InfraException('Erro replicando acessos do SEI Federa��o.', $e);
    }
  }

  protected function processarReplicacaoAcessosControlado(ReplicarAcessosFederacaoDTO $objReplicarAcessosFederacaoDTO){
    try{

      $objInfraException = new InfraException();

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

      $objInstalacaoFederacaoDTORemetente = $objReplicarAcessosFederacaoDTO->getObjInstalacaoFederacaoDTORemetente();
      $objOrgaoFederacaoDTORemetente = $objReplicarAcessosFederacaoDTO->getObjOrgaoFederacaoDTORemetente();
      $objUnidadeFederacaoDTORemetente = $objReplicarAcessosFederacaoDTO->getObjUnidadeFederacaoDTORemetente();
      $objProcedimentoDTOOrigem = $objReplicarAcessosFederacaoDTO->getObjProcedimentoDTO();
      $arrObjAcessoFederacaoDTOReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjAcessoFederacaoDTO();
      $arrObjInstalacaoFederacaoDTOReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjInstalacaoFederacaoDTO();
      $arrObjOrgaoFederacaoReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjOrgaoFederacaoDTO();
      $arrObjUnidadeFederacaoReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjUnidadeFederacaoDTO();
      $arrObjUsuarioFederacaoReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjUsuarioFederacaoDTO();
      $arrObjProtocoloFederacaoDTOReplicacao = $objReplicarAcessosFederacaoDTO->getArrObjProtocoloFederacaoDTO();

      $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
      $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
      $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

      $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
      $objProtocoloFederacaoDTOProcedimento = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

      if ($objProtocoloFederacaoDTOProcedimento == null) {
        $objInfraException->lancarValidacao('Protocolo do SEI Federa��o '.$objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo().' n�o encontrado na instala��o '.$objInstalacaoFederacaoRN->obterSiglaInstalacaoLocal().'.');
      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

      if ($objProcedimentoDTOOrigem->getStrVersaoAcessos() != $this->obterVersaoAcessos($objAcessoFederacaoDTO)) {

        $objInstalacaoFederacaoDTO = new InstalacaoFederacaoDTO();
        $objInstalacaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $arrObjInstalacaoFederacaoDTO = InfraArray::indexarArrInfraDTO($objInstalacaoFederacaoRN->listar($objInstalacaoFederacaoDTO), 'IdInstalacaoFederacao');

        foreach ($arrObjInstalacaoFederacaoDTOReplicacao as $objInstalacaoFederacaoDTO) {
          if (!isset($arrObjInstalacaoFederacaoDTO[$objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao()])) {

            $objInstalacaoFederacaoDTOReplicacao = new InstalacaoFederacaoDTO();
            $objInstalacaoFederacaoDTOReplicacao->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTO->getStrIdInstalacaoFederacao());
            $objInstalacaoFederacaoDTOReplicacao->setDblCnpj($objInstalacaoFederacaoDTO->getDblCnpj());
            $objInstalacaoFederacaoDTOReplicacao->setStrSigla($objInstalacaoFederacaoDTO->getStrSigla());
            $objInstalacaoFederacaoDTOReplicacao->setStrDescricao($objInstalacaoFederacaoDTO->getStrDescricao());
            $objInstalacaoFederacaoDTOReplicacao->setStrEndereco($objInstalacaoFederacaoDTO->getStrEndereco());
            $objInstalacaoFederacaoDTOReplicacao->setStrStaTipo(InstalacaoFederacaoRN::$TI_REPLICADA);
            $objInstalacaoFederacaoDTOReplicacao->setStrStaEstado(InstalacaoFederacaoRN::$EI_ANALISE);
            $objInstalacaoFederacaoDTOReplicacao->setStrStaAgendamento(InstalacaoFederacaoRN::$AI_NENHUM);
            $objInstalacaoFederacaoDTOReplicacao->setStrSinAtivo('S');
            $objInstalacaoFederacaoRN->cadastrar($objInstalacaoFederacaoDTOReplicacao);


            $objAndamentoInstalacaoDTO = new AndamentoInstalacaoDTO();
            $objAndamentoInstalacaoDTO->setStrIdInstalacaoFederacao($objInstalacaoFederacaoDTOReplicacao->getStrIdInstalacaoFederacao());
            $objAndamentoInstalacaoDTO->setStrStaEstado($objInstalacaoFederacaoDTOReplicacao->getStrStaEstado());
            $objAndamentoInstalacaoDTO->setNumIdTarefaInstalacao(TarefaInstalacaoRN::$TI_RECEBIMENTO_REPLICACAO);

            $arrObjAtributoInstalacaoDTO = array();

            $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
            $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO');
            $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTORemetente->getStrSigla()."�".$objInstalacaoFederacaoDTORemetente->getStrDescricao());
            $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTORemetente->getStrIdInstalacaoFederacao());
            $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

            $objAtributoInstalacaoDTO = new AtributoInstalacaoDTO();
            $objAtributoInstalacaoDTO->setStrNome('INSTITUICAO_REPLICADA');
            $objAtributoInstalacaoDTO->setStrValor($objInstalacaoFederacaoDTOReplicacao->getStrSigla()."�".$objInstalacaoFederacaoDTOReplicacao->getStrDescricao());
            $objAtributoInstalacaoDTO->setStrIdOrigem($objInstalacaoFederacaoDTOReplicacao->getStrIdInstalacaoFederacao());
            $arrObjAtributoInstalacaoDTO[] = $objAtributoInstalacaoDTO;

            $objAndamentoInstalacaoDTO->setArrObjAtributoInstalacaoDTO($arrObjAtributoInstalacaoDTO);

            $objAndamentoInstalacaoRN = new AndamentoInstalacaoRN();
            $objAndamentoInstalacaoRN->lancar($objAndamentoInstalacaoDTO);
          }
        }

        //replica dados dos �rg�os
        $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
        foreach ($arrObjOrgaoFederacaoReplicacao as $objOrgaoFederacaoDTO) {
          $objOrgaoFederacaoRN->sincronizar($objOrgaoFederacaoDTO);
        }

        //replica dados das unidades
        $objUnidadeFederacaoRN = new UnidadeFederacaoRN();
        foreach ($arrObjUnidadeFederacaoReplicacao as $objUnidadeFederacaoDTO) {
          $objUnidadeFederacaoRN->sincronizar($objUnidadeFederacaoDTO);
        }

        //replica dados dos usuarios
        $objUsuarioFederacaoRN = new UsuarioFederacaoRN();
        foreach ($arrObjUsuarioFederacaoReplicacao as $objUsuarioFederacaoDTO) {
          $objUsuarioFederacaoRN->sincronizar($objUsuarioFederacaoDTO);
        }

        if (count($arrObjProtocoloFederacaoDTOReplicacao)) {

          $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
          $objProtocoloFederacaoDTO->retStrIdProtocoloFederacao();
          $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao(InfraArray::converterArrInfraDTO($arrObjProtocoloFederacaoDTOReplicacao, 'IdProtocoloFederacao'), InfraDTO::$OPER_IN);

          $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
          $arrObjProtocoloFederacaoDTO = InfraArray::indexarArrInfraDTO($objProtocoloFederacaoRN->listar($objProtocoloFederacaoDTO), 'IdProtocoloFederacao');

          foreach ($arrObjProtocoloFederacaoDTOReplicacao as $objProtocoloFederacaoDTO) {
            if (!isset($arrObjProtocoloFederacaoDTO[$objProtocoloFederacaoDTO->getStrIdProtocoloFederacao()])) {
              $objProtocoloFederacaoRN->cadastrar($objProtocoloFederacaoDTO);
            }
          }
        }

        $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
        $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
        $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoDest();
        $objAcessoFederacaoDTO->retStrIdProcedimentoFederacao();
        $objAcessoFederacaoDTO->retStrSinAtivo();
        $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($objProcedimentoDTOOrigem->getStrIdProtocoloFederacaoProtocolo());

        $arrObjAcessoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listar($objAcessoFederacaoDTO), 'IdAcessoFederacao');

        $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());

        $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
        $objAtividadeRN = new AtividadeRN();
        $objAtributoAndamentoRN = new AtributoAndamentoRN();

        foreach ($arrObjAcessoFederacaoDTOReplicacao as $objAcessoFederacaoDTOReplicado) {
          if (!isset($arrObjAcessoFederacaoDTO[$objAcessoFederacaoDTOReplicado->getStrIdAcessoFederacao()])) {

            //cadastra novo envio
            $objAcessoFederacaoBD->cadastrar($objAcessoFederacaoDTOReplicado);

          } else{

            $objAcessoFederacaoDTOLocal = $arrObjAcessoFederacaoDTO[$objAcessoFederacaoDTOReplicado->getStrIdAcessoFederacao()];

            //envio recebido indica cancelamento
            if ($objAcessoFederacaoDTOLocal->getStrSinAtivo()=='S' && $objAcessoFederacaoDTOReplicado->getStrSinAtivo()=='N') {

              //desativa o registro local
              $objAcessoFederacaoBD->alterar($objAcessoFederacaoDTOReplicado);

              //se o destinat�rio do envio desativado era a instala��o local
              if ($objAcessoFederacaoDTOLocal->getStrIdInstalacaoFederacaoDest() == $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {

                $objUnidadeDTO = new UnidadeDTO();
                $objUnidadeDTO->setBolExclusaoLogica(false);
                $objUnidadeDTO->retNumIdUnidade();
                $objUnidadeDTO->setStrIdUnidadeFederacao($objAcessoFederacaoDTOLocal->getStrIdUnidadeFederacaoDest());

                $objUnidadeRN = new UnidadeRN();
                $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

                SessaoSEI::getInstance()->simularLogin(SessaoSEI::$USUARIO_SEI, null, null, $objUnidadeDTO->getNumIdUnidade());

                $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
                $objAtributoAndamentoDTO->retNumIdAtividade();
                $objAtributoAndamentoDTO->retDblIdProtocoloAtividade();
                $objAtributoAndamentoDTO->setNumIdTarefaAtividade(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO);
                $objAtributoAndamentoDTO->setStrNome('MOTIVO');
                $objAtributoAndamentoDTO->setStrIdOrigem($objAcessoFederacaoDTOLocal->getStrIdAcessoFederacao());
                $objAtributoAndamentoDTO = $objAtributoAndamentoRN->consultarRN1366($objAtributoAndamentoDTO);

                if ($objAtributoAndamentoDTO == null) {
                  $objInfraException->lancarValidacao('Andamento de envio para o acesso '.$objAcessoFederacaoDTOLocal->getStrIdAcessoFederacao().' do SEI Federa��o n�o encontrado.');
                }

                $dblIdProtocoloEnvio = $objAtributoAndamentoDTO->getDblIdProtocoloAtividade();
                $numIdAtividadeEnvio = $objAtributoAndamentoDTO->getNumIdAtividade();

                //busca atributos originais para replicacao no novo andamento
                $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
                $objAtributoAndamentoDTO->retStrNome();
                $objAtributoAndamentoDTO->retStrValor();
                $objAtributoAndamentoDTO->retStrIdOrigem();
                $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);

                $arrObjAtributoAndamentoDTO = $objAtributoAndamentoRN->listarRN1367($objAtributoAndamentoDTO);

                //substitui o motivo de liberacao pelo motivo de cancelamento
                foreach ($arrObjAtributoAndamentoDTO as $objAtributoAndamentoDTO) {
                  if ($objAtributoAndamentoDTO->getStrNome() == 'MOTIVO') {
                    $objAtributoAndamentoDTO->setStrValor($objAcessoFederacaoDTOReplicado->getStrMotivoCancelamento());
                    break;
                  }
                }

                //verifica se esta aberto na unidade geradora
                $objPesquisaPendenciaDTO = new PesquisaPendenciaDTO();
                $objPesquisaPendenciaDTO->setDblIdProtocolo(array($dblIdProtocoloEnvio));
                $objPesquisaPendenciaDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
                $objPesquisaPendenciaDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
                $arrObjProcedimentoDTO = $objAtividadeRN->listarPendenciasRN0754($objPesquisaPendenciaDTO);

                //se n�o esta aberto na unidade geradora entao reabre e envia concluindo para a unidade federacao
                if (InfraArray::contar($arrObjProcedimentoDTO) == 0) {

                  $objEntradaReabrirProcessoAPI = new EntradaReabrirProcessoAPI();
                  $objEntradaReabrirProcessoAPI->setIdProcedimento($dblIdProtocoloEnvio);
                  $objSeiRN = new SeiRN();
                  $objSeiRN->reabrirProcesso($objEntradaReabrirProcessoAPI);
                }

                //lan�a andamento para o usu�rio atual registrando o cancelamento da libera��o
                $objAtividadeDTO = new AtividadeDTO();
                $objAtividadeDTO->setDblIdProtocolo($dblIdProtocoloEnvio);
                $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
                $objAtividadeDTO->setNumIdUnidadeOrigem(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
                $objAtividadeDTO->setNumIdUsuario(null);
                $objAtividadeDTO->setNumIdUsuarioOrigem(SessaoSEI::getInstance()->getNumIdUsuario());
                $objAtividadeDTO->setDtaPrazo(null);
                $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);
                $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_CANCELAMENTO_ENVIO_PROCESSO_FEDERACAO);

                $ret = $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);

                //altera andamento original de envio
                $objAtividadeDTO = new AtividadeDTO();
                $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_PROCESSO_ENVIADO_FEDERACAO_CANCELADO);
                $objAtividadeDTO->setNumIdAtividade($numIdAtividadeEnvio);
                $objAtividadeRN->mudarTarefa($objAtividadeDTO);

                //complementa atributos do andamento original alterado
                $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
                $objAtributoAndamentoDTO->setStrNome('USUARIO');
                $objAtributoAndamentoDTO->setStrValor(SessaoSEI::getInstance()->getStrSiglaUsuario().'�'.SessaoSEI::getInstance()->getStrNomeUsuario());
                $objAtributoAndamentoDTO->setStrIdOrigem(SessaoSEI::getInstance()->getNumIdUsuario());
                $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);
                $objAtributoAndamentoRN->cadastrarRN1363($objAtributoAndamentoDTO);

                $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
                $objAtributoAndamentoDTO->setStrNome('DATA_HORA');
                $objAtributoAndamentoDTO->setStrValor($objAcessoFederacaoDTOReplicado->getDthCancelamento());
                $objAtributoAndamentoDTO->setStrIdOrigem($ret->getNumIdAtividade()); //relaciona com o andamento de cancelamento
                $objAtributoAndamentoDTO->setNumIdAtividade($numIdAtividadeEnvio);
                $objAtributoAndamentoRN->cadastrarRN1363($objAtributoAndamentoDTO);


                //muda visualizacao do processo para vermelho em todas as unidades
                $objAtividadeDTOVisualizacao = new AtividadeDTO();
                $objAtividadeDTOVisualizacao->setDblIdProtocolo($dblIdProtocoloEnvio);
                $objAtividadeDTOVisualizacao->setNumTipoVisualizacao(AtividadeRN::$TV_NAO_VISUALIZADO);
                $objAtividadeRN->atualizarVisualizacao($objAtividadeDTOVisualizacao);
              }
            }
          }
        }

        //replicou no orgao origem
        if ($objProtocoloFederacaoDTOProcedimento->getStrIdInstalacaoFederacao() == $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {
          return true;
        }
      }

      return false;

    }catch(Exception $e){
      throw new InfraException('Erro processando replica��o de acessos do SEI Federa��o.',$e);
    }
  }

  protected function obterVersaoAcessosConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO){
    try{

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica(false);
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->retDthCancelamento();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao());
      $objAcessoFederacaoDTO->setOrdStrIdAcessoFederacao(InfraDTO::$TIPO_ORDENACAO_ASC);
      $arrObjAcessoFederacaoDTO = $this->listar($objAcessoFederacaoDTO);

      return $this->formatarVersaoAcessos($arrObjAcessoFederacaoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro obtendo vers�o de acessos do SEI Federa��o.',$e);
    }
  }

  private function formatarVersaoAcessos($arrObjAcessoFederacaoDTO){
    try{

      $strVersaoAcessos = null;

      if (count($arrObjAcessoFederacaoDTO)) {
        $strAcessos = '';
        foreach($arrObjAcessoFederacaoDTO as $objAcessoFederacaoDTO){
          $strAcessos .= $objAcessoFederacaoDTO->getStrIdAcessoFederacao().$objAcessoFederacaoDTO->getDthCancelamento();
        }
        $strVersaoAcessos = md5($strAcessos);
      }

      return $strVersaoAcessos;

    }catch(Exception $e){
      throw new InfraException('Erro formatando vers�o de acessos do SEI Federa��o.',$e);
    }
  }

  protected function verificarAcessoLocalConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO){
    try {

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();

      $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
      $objProtocoloFederacaoDTO->retStrIdInstalacaoFederacao();
      $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
      $objProtocoloFederacaoDTO = $objProtocoloFederacaoRN->consultar($objProtocoloFederacaoDTO);

      if ($objProtocoloFederacaoDTO->getStrIdInstalacaoFederacao() == $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()) {
        return true;
      }

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setNumMaxRegistrosRetorno(1);
      $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
      $objAcessoFederacaoDTO->adicionarCriterio(
        array('IdInstalacaoFederacaoRem','IdInstalacaoFederacaoDest'),
        array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
        array($objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal(),$objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal()),
        InfraDTO::$OPER_LOGICO_OR
      );
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $objAcessoFederacaoRN = new AcessoFederacaoRN();
      $objAcessoFederacaoDTO = $objAcessoFederacaoRN->consultar($objAcessoFederacaoDTO);
      if ($objAcessoFederacaoDTO != null){
        return true;
      }

      return false;

    }catch(Exception $e){
      throw new InfraException('Erro verificando acesso da instala��o local no processo do SEI Federa��o.', $e);
    }
  }

  protected function obterOrgaosAcessoFederacaoConectado(AcessoFederacaoDTO $parObjAcessoFederacaoDTO){
    try{

      $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
      $objAcessoFederacaoDTO->setBolExclusaoLogica($parObjAcessoFederacaoDTO->isBolExclusaoLogica());
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoRem();
      $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoDest();
      $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($parObjAcessoFederacaoDTO->getStrIdProcedimentoFederacao());

      $objAcessoFederacaoRN = new AcessoFederacaoRN();
      $arrObjAcessoFederacaoDTOBanco = $objAcessoFederacaoRN->listar($objAcessoFederacaoDTO);
      $arrIdOrgaosFederacao = array_unique(array_merge(InfraArray::converterArrInfraDTO($arrObjAcessoFederacaoDTOBanco,'IdOrgaoFederacaoRem'), InfraArray::converterArrInfraDTO($arrObjAcessoFederacaoDTOBanco,'IdOrgaoFederacaoDest')));

      $arrObjOrgaoFederacaoDTO = array();

      if (count($arrIdOrgaosFederacao)) {

        $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
        $objOrgaoFederacaoDTO->retStrIdOrgaoFederacao();
        $objOrgaoFederacaoDTO->retStrIdInstalacaoFederacao();
        $objOrgaoFederacaoDTO->setStrIdOrgaoFederacao($arrIdOrgaosFederacao, InfraDTO::$OPER_IN);
        $objOrgaoFederacaoDTO->setOrdStrSigla(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objOrgaoFederacaoRN = new OrgaoFederacaoRN();
        $arrObjOrgaoFederacaoDTO = $objOrgaoFederacaoRN->listar($objOrgaoFederacaoDTO);
      }

      return $arrObjOrgaoFederacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro obtendo �rg�os do SEI Federa��o com acesso ao processo.', $e);
    }
  }

  protected function gerarRelatorioProcessosConectado(RelatorioFederacaoDTO $parObjRelatorioFederacaoDTO){
    try{

      $ret = array();

      $objRelatorioFederacaoDTO = new RelatorioFederacaoDTO();
      $objRelatorioFederacaoDTO->setDistinct(true);
      $objRelatorioFederacaoDTO->retStrIdProcedimentoFederacao();

      if ($parObjRelatorioFederacaoDTO->isSetStrProtocoloFormatado() && !InfraString::isBolVazia($parObjRelatorioFederacaoDTO->getStrProtocoloFormatado())) {

        $strProtocoloPesquisa = InfraUtil::retirarFormatacao($parObjRelatorioFederacaoDTO->getStrProtocoloFormatado(), false);

        $objRelatorioFederacaoDTO->adicionarCriterio(array('ProtocoloFormatadoPesquisaProtocoloFederacao', 'ProtocoloFormatadoPesquisaProtocoloFederacao', 'ProtocoloFormatadoPesqInvProtocoloFederacao'),
          array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_LIKE, InfraDTO::$OPER_LIKE),
          array($strProtocoloPesquisa, $strProtocoloPesquisa.'%', strrev($strProtocoloPesquisa).'%'),
          array(InfraDTO::$OPER_LOGICO_OR, InfraDTO::$OPER_LOGICO_OR),
          'cProtocoloFederacao');

        $objRelatorioFederacaoDTO->adicionarCriterio(array('ProtocoloFormatadoPesquisaProtocolo', 'ProtocoloFormatadoPesquisaProtocolo', 'ProtocoloFormatadoPesqInvProtocolo'),
          array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_LIKE, InfraDTO::$OPER_LIKE),
          array($strProtocoloPesquisa, $strProtocoloPesquisa.'%', strrev($strProtocoloPesquisa).'%'),
          array(InfraDTO::$OPER_LOGICO_OR, InfraDTO::$OPER_LOGICO_OR),
          'cProtocolo');

        $objRelatorioFederacaoDTO->agruparCriterios(array('cProtocoloFederacao','cProtocolo'), InfraDTO::$OPER_LOGICO_OR);

        $objRelatorioFederacaoDTO->setStrStaProtocoloProtocolo(ProtocoloRN::$TP_PROCEDIMENTO);
      }

      if ($parObjRelatorioFederacaoDTO->isSetDtaInicio() && $parObjRelatorioFederacaoDTO->isSetDtaFim()) {

        $objInfraException = new InfraException();
        InfraData::validarPeriodo($parObjRelatorioFederacaoDTO->getDtaInicio(), $parObjRelatorioFederacaoDTO->getDtaFim(), $objInfraException);
        $objInfraException->lancarValidacoes();


        if (!InfraString::isBolVazia($parObjRelatorioFederacaoDTO->getDtaInicio())) {
          if ($parObjRelatorioFederacaoDTO->getDtaInicio() == $parObjRelatorioFederacaoDTO->getDtaFim()) {
            $objRelatorioFederacaoDTO->adicionarCriterio(array('Liberacao', 'Liberacao'),
              array(InfraDTO::$OPER_MAIOR_IGUAL, InfraDTO::$OPER_MENOR_IGUAL),
              array($parObjRelatorioFederacaoDTO->getDtaInicio().' 00:00:00', $parObjRelatorioFederacaoDTO->getDtaInicio().' 23:59:59'),
              InfraDTO::$OPER_LOGICO_AND);
          } else {
            $objRelatorioFederacaoDTO->adicionarCriterio(array('Liberacao', 'Liberacao'),
              array(InfraDTO::$OPER_MAIOR_IGUAL, InfraDTO::$OPER_MENOR_IGUAL),
              array($parObjRelatorioFederacaoDTO->getDtaInicio().' 00:00:00', $parObjRelatorioFederacaoDTO->getDtaFim().' 23:59:59'),
              InfraDTO::$OPER_LOGICO_AND);
          }
        }
      }

      if ($parObjRelatorioFederacaoDTO->isSetStrIdOrgaoFederacao() && $parObjRelatorioFederacaoDTO->getStrIdOrgaoFederacao()!=null){

        $objRelatorioFederacaoDTO->adicionarCriterio(array('IdOrgaoFederacaoRem','IdOrgaoFederacaoDest'),
          array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
          array($parObjRelatorioFederacaoDTO->getStrIdOrgaoFederacao(), $parObjRelatorioFederacaoDTO->getStrIdOrgaoFederacao()),
          InfraDTO::$OPER_LOGICO_OR);

      }

      $objInstalacaoFederacaoRN = new InstalacaoFederacaoRN();
      $strIdInstalacaoFederacaoLocal = $objInstalacaoFederacaoRN->obterIdInstalacaoFederacaoLocal();

      if ($parObjRelatorioFederacaoDTO->isSetStrStaSentido() && $parObjRelatorioFederacaoDTO->getStrStaSentido()!=null){
        if ($parObjRelatorioFederacaoDTO->getStrStaSentido() == self::$TST_ENVIADO){
          $objRelatorioFederacaoDTO->setStrIdInstalacaoFederacaoRem($strIdInstalacaoFederacaoLocal);
        }else{
          $objRelatorioFederacaoDTO->setStrIdInstalacaoFederacaoDest($strIdInstalacaoFederacaoLocal);
        }
      }else{
        $objRelatorioFederacaoDTO->adicionarCriterio(array('IdInstalacaoFederacaoRem','IdInstalacaoFederacaoDest'),
          array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
          array($strIdInstalacaoFederacaoLocal, $strIdInstalacaoFederacaoLocal),
          InfraDTO::$OPER_LOGICO_OR);
      }

      //pagina��o
      $objRelatorioFederacaoDTO->setNumMaxRegistrosRetorno($parObjRelatorioFederacaoDTO->getNumMaxRegistrosRetorno());
      $objRelatorioFederacaoDTO->setNumPaginaAtual($parObjRelatorioFederacaoDTO->getNumPaginaAtual());

      $objAcessoFederacaoBD = new AcessoFederacaoBD($this->getObjInfraIBanco());
      $arrObjRelatorioFederacaoDTO = $objAcessoFederacaoBD->listar($objRelatorioFederacaoDTO);

      //pagina��o
      $parObjRelatorioFederacaoDTO->setNumTotalRegistros($objRelatorioFederacaoDTO->getNumTotalRegistros());
      $parObjRelatorioFederacaoDTO->setNumRegistrosPaginaAtual($objRelatorioFederacaoDTO->getNumRegistrosPaginaAtual());

      if (count($arrObjRelatorioFederacaoDTO)) {

        $arrStrIdProcedimentoFederacao = InfraArray::converterArrInfraDTO($arrObjRelatorioFederacaoDTO, 'IdProcedimentoFederacao');

        $objProtocoloFederacaoDTO = new ProtocoloFederacaoDTO();
        $objProtocoloFederacaoDTO->retStrIdProtocoloFederacao();
        $objProtocoloFederacaoDTO->retStrProtocoloFormatado();
        $objProtocoloFederacaoDTO->setStrIdProtocoloFederacao($arrStrIdProcedimentoFederacao, InfraDTO::$OPER_IN);

        $objProtocoloFederacaoRN = new ProtocoloFederacaoRN();
        $arrObjProtocoloFederacaoDTO = $objProtocoloFederacaoRN->listar($objProtocoloFederacaoDTO);

        $objPesquisaProtocoloDTO = new PesquisaProtocoloDTO();
        $objPesquisaProtocoloDTO->setStrStaTipo(ProtocoloRN::$TPP_PROCEDIMENTOS);
        $objPesquisaProtocoloDTO->setStrStaAcesso(ProtocoloRN::$TAP_TODOS);
        $objPesquisaProtocoloDTO->setStrIdProtocoloFederacao($arrStrIdProcedimentoFederacao);

        $objProtocoloRN = new ProtocoloRN();
        $arrObjProtocoloDTO = InfraArray::indexarArrInfraDTO($objProtocoloRN->pesquisarRN0967($objPesquisaProtocoloDTO), 'IdProtocoloFederacao');

        $objAcessoFederacaoDTO = new AcessoFederacaoDTO();
        //$objAcessoFederacaoDTO->setBolExclusaoLogica(false);
        $objAcessoFederacaoDTO->retStrIdProcedimentoFederacao();
        $objAcessoFederacaoDTO->retStrIdAcessoFederacao();
        $objAcessoFederacaoDTO->retDthLiberacao();
        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrDescricaoInstalacaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrDescricaoOrgaoFederacaoRem();
        $objAcessoFederacaoDTO->retStrIdUnidadeFederacaoRem();
        $objAcessoFederacaoDTO->retStrSiglaUnidadeFederacaoRem();
        $objAcessoFederacaoDTO->retStrDescricaoUnidadeFederacaoRem();

        $objAcessoFederacaoDTO->retStrIdInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrDescricaoInstalacaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrIdOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrDescricaoOrgaoFederacaoDest();
        $objAcessoFederacaoDTO->retStrSiglaUnidadeFederacaoDest();
        $objAcessoFederacaoDTO->retStrDescricaoUnidadeFederacaoDest();

        $objAcessoFederacaoDTO->retStrSinAtivo();

        $objAcessoFederacaoDTO->setOrdStrIdAcessoFederacao(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objAcessoFederacaoDTO->setStrIdProcedimentoFederacao($arrStrIdProcedimentoFederacao, InfraDTO::$OPER_IN);

        $arrObjAcessoFederacaoDTO = InfraArray::indexarArrInfraDTO($this->listar($objAcessoFederacaoDTO), 'IdProcedimentoFederacao', true);

        foreach ($arrObjProtocoloFederacaoDTO as $objProtocoloFederacaoDTO) {

          $arrObjOrgaoFederacaoDTO = array();
          $numAcessos = count($arrObjAcessoFederacaoDTO[$objProtocoloFederacaoDTO->getStrIdProtocoloFederacao()]);
          for($i=0;$i<$numAcessos;$i++){
            $objAcessoFederacaoDTO = $arrObjAcessoFederacaoDTO[$objProtocoloFederacaoDTO->getStrIdProtocoloFederacao()][$i];
            if (!isset($arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem()])) {
              $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
              $objOrgaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaOrgaoFederacaoRem());
              $objOrgaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoOrgaoFederacaoRem());
              $objOrgaoFederacaoDTO->setStrSinOrigem($i==0?'S':'N');
              $arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoRem()] = $objOrgaoFederacaoDTO;
            }
            if (!isset($arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()])) {
              $objOrgaoFederacaoDTO = new OrgaoFederacaoDTO();
              $objOrgaoFederacaoDTO->setStrSigla($objAcessoFederacaoDTO->getStrSiglaOrgaoFederacaoDest());
              $objOrgaoFederacaoDTO->setStrDescricao($objAcessoFederacaoDTO->getStrDescricaoOrgaoFederacaoDest());
              $objOrgaoFederacaoDTO->setStrSinOrigem('N');
              $arrObjOrgaoFederacaoDTO[$objAcessoFederacaoDTO->getStrIdOrgaoFederacaoDest()] = $objOrgaoFederacaoDTO;
            }
          }

          $arrObjOrgaoFederacaoDTO = array_values($arrObjOrgaoFederacaoDTO);

          InfraArray::ordenarArrInfraDTO($arrObjOrgaoFederacaoDTO,'Sigla',InfraArray::$TIPO_ORDENACAO_ASC);

          $objRelatorioFederacaoDTO = new RelatorioFederacaoDTO();
          $objRelatorioFederacaoDTO->setObjProtocoloFederacaoDTO($objProtocoloFederacaoDTO);
          $objRelatorioFederacaoDTO->setObjProtocoloDTO($arrObjProtocoloDTO[$objProtocoloFederacaoDTO->getStrIdProtocoloFederacao()]);
          $objRelatorioFederacaoDTO->setArrObjAcessoFederacaoDTO($arrObjAcessoFederacaoDTO[$objProtocoloFederacaoDTO->getStrIdProtocoloFederacao()]);
          $objRelatorioFederacaoDTO->setArrObjOrgaoFederacaoDTO($arrObjOrgaoFederacaoDTO);
          $ret[] = $objRelatorioFederacaoDTO;
        }

      }
      return $ret;

    }catch (Exception $e){
      throw new InfraException('Erro gerando relat�rio de processos do SEI Federa��o.', $e);
    }
  }
}
