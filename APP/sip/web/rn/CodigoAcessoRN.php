<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 26/06/2018 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.41.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class CodigoAcessoRN extends InfraRN {

  public static $MSG_CODIGO_NAO_INFORMADO = 'C�digo n�o informado.';
  public static $MSG_CODIGO_INVALIDO = 'C�digo inv�lido.';
  public static $MSG_CODIGO_NAO_RECONHECIDO = 'C�digo n�o reconhecido.';

  public function __construct() {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco() {
    return BancoSip::getInstance();
  }

  private function validarNumIdUsuario(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getNumIdUsuario())) {
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarNumIdUsuarioDesativacao(
    CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getNumIdUsuarioDesativacao())) {
      $objCodigoAcessoDTO->setNumIdUsuarioDesativacao(null);
    }
  }

  private function validarNumIdSistema(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getNumIdSistema())) {
      $objInfraException->adicionarValidacao('Sistema n�o informado.');
    }
  }

  private function validarStrChaveGeracao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getStrChaveGeracao())) {
      $objInfraException->adicionarValidacao('Chave de Gera��o n�o informada.');
    } else {
      $objCodigoAcessoDTO->setStrChaveGeracao(trim($objCodigoAcessoDTO->getStrChaveGeracao()));

      if (strlen($objCodigoAcessoDTO->getStrChaveGeracao()) > 32) {
        $objInfraException->adicionarValidacao('Chave de Gera��o possui tamanho superior a 32 caracteres.');
      }

      if (preg_match("/[^0-9a-zA-Z]/", $objCodigoAcessoDTO->getStrChaveGeracao())) {
        $objInfraException->adicionarValidacao('Chave de Gera��o inv�lida.');
      }
    }
  }

  private function validarStrChaveAtivacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getStrChaveAtivacao())) {
      $objCodigoAcessoDTO->setStrChaveAtivacao(null);
    } else {
      $objCodigoAcessoDTO->setStrChaveAtivacao(trim($objCodigoAcessoDTO->getStrChaveAtivacao()));

      if (strlen($objCodigoAcessoDTO->getStrChaveAtivacao()) > 60) {
        $objInfraException->adicionarValidacao('Chave de Ativa��o possui tamanho superior a 60 caracteres.');
      }
    }
  }

  private function validarStrChaveDesativacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getStrChaveDesativacao())) {
      $objCodigoAcessoDTO->setStrChaveDesativacao(null);
    } else {
      $objCodigoAcessoDTO->setStrChaveDesativacao(trim($objCodigoAcessoDTO->getStrChaveDesativacao()));

      if (strlen($objCodigoAcessoDTO->getStrChaveDesativacao()) > 60) {
        $objInfraException->adicionarValidacao('Chave de Desativa��o possui tamanho superior a 60 caracteres.');
      }
    }
  }

  private function validarStrChaveExterna($strChaveExterna, InfraException $objInfraException) {
    if (InfraString::isBolVazia($strChaveExterna)) {
      $objInfraException->adicionarValidacao('Chave externa n�o informada.');
    } else {
      $strChaveExterna = trim($strChaveExterna);

      if (strlen($strChaveExterna) > 154) {
        $objInfraException->adicionarValidacao('Chave externa possui tamanho superior a 154 caracteres.');
      }

      if (preg_match("/[^0-9a-z]/", $strChaveExterna)) {
        $objInfraException->adicionarValidacao('Chave externa inv�lida.');
      }
    }
    return $strChaveExterna;
  }

  private function validarDthGeracao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthGeracao())) {
      $objInfraException->adicionarValidacao('Data/hora de gera��o n�o informada.');
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthGeracao())) {
        $objInfraException->adicionarValidacao('Data/hora de gera��o inv�lida.');
      }
    }
  }

  private function validarDthEnvioAtivacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthEnvioAtivacao())) {
      $objCodigoAcessoDTO->setDthEnvioAtivacao(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthEnvioAtivacao())) {
        $objInfraException->adicionarValidacao('Data/hora de envio do link de ativa��o inv�lida.');
      }
    }
  }

  private function validarDthAtivacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthAtivacao())) {
      $objCodigoAcessoDTO->setDthAtivacao(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthAtivacao())) {
        $objInfraException->adicionarValidacao('Data/hora de ativa��o inv�lida.');
      }
    }
  }

  private function validarDthAcesso(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthAcesso())) {
      $objCodigoAcessoDTO->setDthAcesso(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthAcesso())) {
        $objInfraException->adicionarValidacao('Data/hora do �ltimo acesso inv�lida.');
      }
    }
  }

  private function validarDthEnvioDesativacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthEnvioDesativacao())) {
      $objCodigoAcessoDTO->setDthEnvioDesativacao(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthEnvioDesativacao())) {
        $objInfraException->adicionarValidacao('Data/hora de envio do link de desativa��o inv�lida.');
      }
    }
  }

  private function validarDthDesativacao(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getDthDesativacao())) {
      $objCodigoAcessoDTO->setDthDesativacao(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoAcessoDTO->getDthDesativacao())) {
        $objInfraException->adicionarValidacao('Data/hora de desativa��o inv�lida.');
      }
    }
  }

  private function validarStrEmail(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getStrEmail())) {
      $objCodigoAcessoDTO->setStrEmail(null);
    } else {
      $objCodigoAcessoDTO->setStrEmail(trim($objCodigoAcessoDTO->getStrEmail()));

      if (strlen($objCodigoAcessoDTO->getStrEmail()) > 100) {
        $objInfraException->adicionarValidacao('E-mail possui tamanho superior a 100 caracteres.');
      }

      if (!InfraUtil::validarEmail($objCodigoAcessoDTO->getStrEmail())) {
        $objInfraException->adicionarValidacao('E-mail ' . $objCodigoAcessoDTO->getStrEmail() . ' inv�lido.');
      }

      $objInfraParametro = new InfraParametro(BancoSip::getInstance());
      $strSufixos = $objInfraParametro->getValor('SIP_2_FATORES_SUFIXOS_EMAIL_NAO_PERMTIDOS');
      if ($strSufixos != null) {
        $strEmail = strtolower($objCodigoAcessoDTO->getStrEmail());
        $arrSufixos = explode(',', $strSufixos);
        foreach ($arrSufixos as $strSufixo) {
          $strSufixo = strtolower(trim($strSufixo));
          if ($strSufixo != '' && substr($strEmail, strlen($strSufixo) * -1) == $strSufixo) {
            $objInfraException->adicionarValidacao('N�o s�o permitidos endere�os de e-mail com o sufixo "' . $strSufixo . '".');
          }
        }
      }
    }
  }

  private function validarStrSinAtivo(CodigoAcessoDTO $objCodigoAcessoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoAcessoDTO->getStrSinAtivo())) {
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objCodigoAcessoDTO->getStrSinAtivo())) {
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(CodigoAcessoDTO $objCodigoAcessoDTO) {
    try {
      //Valida Permissao
      /////////////////////////////////////////////////////////////
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_cadastrar');
      /////////////////////////////////////////////////////////////

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUsuario($objCodigoAcessoDTO, $objInfraException);
      $this->validarNumIdUsuarioDesativacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarNumIdSistema($objCodigoAcessoDTO, $objInfraException);
      $this->validarStrChaveGeracao($objCodigoAcessoDTO, $objInfraException);
      $this->validarStrChaveAtivacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarStrChaveDesativacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthGeracao($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthEnvioAtivacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthAtivacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthAcesso($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthEnvioDesativacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarDthDesativacao($objCodigoAcessoDTO, $objInfraException);
      $this->validarStrEmail($objCodigoAcessoDTO, $objInfraException);
      $this->validarStrSinAtivo($objCodigoAcessoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $ret = $objCodigoAcessoBD->cadastrar($objCodigoAcessoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro cadastrando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function alterarControlado(CodigoAcessoDTO $objCodigoAcessoDTO) {
    try {
      //Valida Permissao
      /////////////////////////////////////////////////////////////
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_alterar');
      /////////////////////////////////////////////////////////////

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objCodigoAcessoDTO->isSetNumIdUsuario()) {
        $this->validarNumIdUsuario($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetNumIdUsuarioDesativacao()) {
        $this->validarNumIdUsuarioDesativacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetNumIdSistema()) {
        $this->validarNumIdSistema($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetStrChaveGeracao()) {
        $this->validarStrChaveGeracao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetStrChaveAtivacao()) {
        $this->validarStrChaveAtivacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetStrChaveDesativacao()) {
        $this->validarStrChaveDesativacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthGeracao()) {
        $this->validarDthGeracao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthEnvioAtivacao()) {
        $this->validarDthEnvioAtivacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthAtivacao()) {
        $this->validarDthAtivacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthAcesso()) {
        $this->validarDthAcesso($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthEnvioDesativacao()) {
        $this->validarDthEnvioDesativacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetDthDesativacao()) {
        $this->validarDthDesativacao($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetStrEmail()) {
        $this->validarStrEmail($objCodigoAcessoDTO, $objInfraException);
      }
      if ($objCodigoAcessoDTO->isSetStrSinAtivo()) {
        $this->validarStrSinAtivo($objCodigoAcessoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $objCodigoAcessoBD->alterar($objCodigoAcessoDTO);
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro alterando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function excluirControlado($arrObjCodigoAcessoDTO) {
    try {
      //Valida Permissao
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_excluir');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioRN = new CodigoBloqueioRN();
      $objDispositivoAcessoRN = new DispositivoAcessoRN();
      $objUsuarioHistoricoRN = new UsuarioHistoricoRN();
      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoAcessoDTO); $i++) {
        $objCodigoBloqueioDTO = new CodigoBloqueioDTO();
        $objCodigoBloqueioDTO->setBolExclusaoLogica(false);
        $objCodigoBloqueioDTO->retStrIdCodigoBloqueio();
        $objCodigoBloqueioDTO->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objCodigoBloqueioRN->excluir($objCodigoBloqueioRN->listar($objCodigoBloqueioDTO));

        $objDispositivoAcessoDTO = new DispositivoAcessoDTO();
        $objDispositivoAcessoDTO->setBolExclusaoLogica(false);
        $objDispositivoAcessoDTO->retStrIdDispositivoAcesso();
        $objDispositivoAcessoDTO->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objDispositivoAcessoRN->excluir($objDispositivoAcessoRN->listar($objDispositivoAcessoDTO));

        $objUsuarioHistoricoDTO = new UsuarioHistoricoDTO();
        $objUsuarioHistoricoDTO->retNumIdUsuarioHistorico();
        $objUsuarioHistoricoDTO->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objUsuarioHistoricoRN->excluir($objUsuarioHistoricoRN->listar($objUsuarioHistoricoDTO));

        $objCodigoAcessoBD->excluir($arrObjCodigoAcessoDTO[$i]);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro excluindo Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function consultarConectado(CodigoAcessoDTO $objCodigoAcessoDTO) {
    try {
      /////////////////////////////////////////////////////////////
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_consultar');
      /////////////////////////////////////////////////////////////

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $ret = $objCodigoAcessoBD->consultar($objCodigoAcessoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro consultando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function listarConectado(CodigoAcessoDTO $objCodigoAcessoDTO) {
    try {
      /////////////////////////////////////////////////////////////
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_listar');
      /////////////////////////////////////////////////////////////

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $ret = $objCodigoAcessoBD->listar($objCodigoAcessoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro listando Habilita��es para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function contarConectado(CodigoAcessoDTO $objCodigoAcessoDTO) {
    try {
      /////////////////////////////////////////////////////////////
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_listar');
      /////////////////////////////////////////////////////////////

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $ret = $objCodigoAcessoBD->contar($objCodigoAcessoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro contando Habilita��es para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function desativarControlado($arrObjCodigoAcessoDTO) {
    try {
      //Valida Permissao
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objDispositivoAcessoRN = new DispositivoAcessoRN();
      $objCodigoBloqueioRN = new CodigoBloqueioRN();

      $strDataHora = InfraData::getStrDataHoraAtual();
      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoAcessoDTO); $i++) {
        $dto = new CodigoAcessoDTO();
        $dto->setDthDesativacao($strDataHora);
        $dto->setNumIdUsuarioDesativacao($arrObjCodigoAcessoDTO[$i]->getNumIdUsuarioDesativacao());
        $dto->setStrSinAtivo('N');
        $dto->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objCodigoAcessoBD->alterar($dto);

        $objDispositivoAcessoDTO = new DispositivoAcessoDTO();
        $objDispositivoAcessoDTO->retStrIdDispositivoAcesso();
        $objDispositivoAcessoDTO->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objDispositivoAcessoRN->desativar($objDispositivoAcessoRN->listar($objDispositivoAcessoDTO));

        $objCodigoBloqueioDTO = new CodigoBloqueioDTO();
        $objCodigoBloqueioDTO->retStrIdCodigoBloqueio();
        $objCodigoBloqueioDTO->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objCodigoBloqueioRN->desativar($objCodigoBloqueioRN->listar($objCodigoBloqueioDTO));
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro desativando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function reativarControlado($arrObjCodigoAcessoDTO) {
    try {
      //Valida Permissao
      //SessaoSip::getInstance()->validarPermissao('codigo_acesso_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $strDataHora = InfraData::getStrDataHoraAtual();
      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoAcessoDTO); $i++) {
        $dto = new CodigoAcessoDTO();
        $dto->setDthAtivacao($strDataHora);
        $dto->setStrSinAtivo('S');
        $dto->setStrIdCodigoAcesso($arrObjCodigoAcessoDTO[$i]->getStrIdCodigoAcesso());
        $objCodigoAcessoBD->alterar($dto);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro reativando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  /*
  protected function bloquearControlado(CodigoAcessoDTO $objCodigoAcessoDTO){
    try {

      //Valida Permissao
      SessaoSip::getInstance()->validarPermissao('codigo_acesso_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoAcessoBD = new CodigoAcessoBD($this->getObjInfraIBanco());
      $ret = $objCodigoAcessoBD->bloquear($objCodigoAcessoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Habilita��o para Autentica��o em 2 Fatores.',$e);
    }
  }
  */

  protected function gerarControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->retNumIdUsuario();
      $objUsuarioDTO->retStrSigla();
      $objUsuarioDTO->retStrSiglaOrgao();
      $objUsuarioDTO->setNumIdUsuario($parObjCodigoAcessoDTO->getNumIdUsuario());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultar($objUsuarioDTO);

      if ($objUsuarioDTO == null) {
        throw new InfraException('Usu�rio n�o encontrado.');
      }

      $strChaveGeracao = hash('MD5', random_bytes(32));

      $base32 = new Tuupola\Base32();
      $strChaveDigitavel = chunk_split(strtoupper(str_replace('=', '', $base32->encode($strChaveGeracao))), 4, ' ');

      //$strQrCode = InfraTOTP::gerar(DIR_SIP_TEMP, 'SISTEMA/ORGAO', 'USUARIO', $strChaveGeracao);
      $strQrCode = InfraTOTP::gerar(DIR_SIP_TEMP, InfraString::excluirAcentos($parObjCodigoAcessoDTO->getStrSiglaSistema() . '/' . $parObjCodigoAcessoDTO->getStrSiglaOrgaoSistema()),
        InfraString::excluirAcentos($objUsuarioDTO->getStrSigla() . '/' . $objUsuarioDTO->getStrSiglaOrgao()), $strChaveGeracao);

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setBolExclusaoLogica(false);
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->setNumIdSistema($parObjCodigoAcessoDTO->getNumIdSistema());
      $objCodigoAcessoDTO->setNumIdUsuario($parObjCodigoAcessoDTO->getNumIdUsuario());
      $arrObjCodigoAcessoDTO = $this->listar($objCodigoAcessoDTO);
      foreach ($arrObjCodigoAcessoDTO as $objCodigoAcessoDTO) {
        $objCodigoAcessoDTO->setNumIdUsuarioDesativacao($parObjCodigoAcessoDTO->getNumIdUsuario());
      }
      $this->desativar($arrObjCodigoAcessoDTO);

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setStrIdCodigoAcesso(InfraULID::gerar());
      $objCodigoAcessoDTO->setNumIdUsuario($objUsuarioDTO->getNumIdUsuario());
      $objCodigoAcessoDTO->setNumIdUsuarioDesativacao(null);
      $objCodigoAcessoDTO->setNumIdSistema($parObjCodigoAcessoDTO->getNumIdSistema());
      $objCodigoAcessoDTO->setStrChaveGeracao($strChaveGeracao);
      $objCodigoAcessoDTO->setStrChaveAtivacao(null);
      $objCodigoAcessoDTO->setStrChaveDesativacao(null);
      $objCodigoAcessoDTO->setDthGeracao(InfraData::getStrDataHoraAtual());
      $objCodigoAcessoDTO->setDthEnvioAtivacao(null);
      $objCodigoAcessoDTO->setDthAtivacao(null);
      $objCodigoAcessoDTO->setDthAcesso(null);
      $objCodigoAcessoDTO->setDthEnvioDesativacao(null);
      $objCodigoAcessoDTO->setDthDesativacao(null);
      $objCodigoAcessoDTO->setStrEmail(null);
      $objCodigoAcessoDTO->setStrSinAtivo('N');
      $this->cadastrar($objCodigoAcessoDTO);

      $parObjCodigoAcessoDTO->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $parObjCodigoAcessoDTO->setStrQrCode($strQrCode);
      $parObjCodigoAcessoDTO->setStrChaveDigitavel($strChaveDigitavel);
    } catch (Exception $e) {
      throw new InfraException('Erro gerando Habilita��o para Autentica��o em 2 Fatores.', $e);
    }
  }

  public function validar(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    MailSip::getInstance()->limpar();
    $ret = $this->validarInterno($parObjCodigoAcessoDTO);
    MailSip::getInstance()->enviar();
    return $ret;
  }

  protected function validarInternoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraException = new InfraException();

      $strDataHora = InfraData::getStrDataHoraAtual();

      $parObjCodigoAcessoDTO->setStrCodigoExterno(trim($parObjCodigoAcessoDTO->getStrCodigoExterno()));

      if (InfraString::isBolVazia($parObjCodigoAcessoDTO->getStrCodigoExterno())) {
        $objInfraException->lancarValidacao(self::$MSG_CODIGO_NAO_INFORMADO);
      }

      if (!is_numeric($parObjCodigoAcessoDTO->getStrCodigoExterno())) {
        $objInfraException->lancarValidacao(self::$MSG_CODIGO_INVALIDO);
      }

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retStrChaveGeracao();
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retStrSiglaUsuario();
      $objCodigoAcessoDTO->retNumIdOrgaoUsuario();
      $objCodigoAcessoDTO->setNumIdUsuario($parObjCodigoAcessoDTO->getNumIdUsuario());
      $objCodigoAcessoDTO->setNumIdSistema($parObjCodigoAcessoDTO->getNumIdSistema());
      $objCodigoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());

      $objCodigoAcessoDTO = $this->consultar($objCodigoAcessoDTO);

      if ($objCodigoAcessoDTO == null) {
        $objInfraException->lancarValidacao(self::$MSG_CODIGO_NAO_RECONHECIDO);
      }

      $objCodigoAcessoDTO2 = new CodigoAcessoDTO();
      $objCodigoAcessoDTO2->setDthAcesso($strDataHora);
      $objCodigoAcessoDTO2->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $this->alterar($objCodigoAcessoDTO2);

      $parObjCodigoAcessoDTO->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $parObjCodigoAcessoDTO->setStrSiglaUsuario($objCodigoAcessoDTO->getStrSiglaUsuario());
      $parObjCodigoAcessoDTO->setNumIdOrgaoUsuario($objCodigoAcessoDTO->getNumIdOrgaoUsuario());

      if (InfraTOTP::verificar($objCodigoAcessoDTO->getStrChaveGeracao(), $parObjCodigoAcessoDTO->getStrCodigoExterno(), 10)) {
        $this->adicionarDispositivo($parObjCodigoAcessoDTO);

        return true;
      }

      $objInfraException->lancarValidacao(self::$MSG_CODIGO_INVALIDO . "\n\nCaso tenha informado o c�digo certo ent�o verifique se o hor�rio do seu smartphone est� correto.");
    } catch (Exception $e) {
      throw new InfraException('Erro validando C�digo de Acesso.', $e);
    }
  }

  public function enviarAtivacao(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    MailSip::getInstance()->limpar();
    $ret = $this->enviarAtivacaoInterno($parObjCodigoAcessoDTO);
    MailSip::getInstance()->enviar();
    return $ret;
  }

  protected function enviarAtivacaoInternoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraException = new InfraException();

      if (InfraString::isBolVazia($parObjCodigoAcessoDTO->getStrEmail())) {
        $objInfraException->lancarValidacao('E-mail n�o informado.');
      }

      $this->validarStrEmail($parObjCodigoAcessoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoDTOBanco = new CodigoAcessoDTO();
      $objCodigoAcessoDTOBanco->setBolExclusaoLogica(false);
      $objCodigoAcessoDTOBanco->retStrSiglaUsuario();
      $objCodigoAcessoDTOBanco->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTOBanco->retStrNomeUsuario();
      $objCodigoAcessoDTOBanco->retStrSiglaSistema();
      $objCodigoAcessoDTOBanco->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTOBanco->retStrSinAtivo();
      $objCodigoAcessoDTOBanco->setNumIdUsuario($parObjCodigoAcessoDTO->getNumIdUsuario());
      $objCodigoAcessoDTOBanco->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());

      $objCodigoAcessoDTOBanco = $this->consultar($objCodigoAcessoDTOBanco);

      if ($objCodigoAcessoDTOBanco == null) {
        throw new InfraException('Habilita��o para Autentica��o em 2 Fatores n�o encontrada.');
      }

      if ($objCodigoAcessoDTOBanco->getStrSinAtivo() == 'S') {
        $objInfraException->lancarValidacao('A autentica��o em 2 fatores j� foi ativada.');
      }

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setStrEmail($parObjCodigoAcessoDTO->getStrEmail());

      $objInfraBcrypt = new InfraBcrypt();
      $strChaveAtivacao = strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32));
      $objCodigoAcessoDTO->setStrChaveAtivacao($objInfraBcrypt->hash(md5($strChaveAtivacao)));
      $objCodigoAcessoDTO->setDthEnvioAtivacao(InfraData::getStrDataHoraAtual());
      $objCodigoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
      $this->alterar($objCodigoAcessoDTO);

      $objEmailSistemaDTO = new EmailSistemaDTO();
      $objEmailSistemaDTO->retStrDe();
      $objEmailSistemaDTO->retStrPara();
      $objEmailSistemaDTO->retStrAssunto();
      $objEmailSistemaDTO->retStrConteudo();
      $objEmailSistemaDTO->setNumIdEmailSistema(EmailSistemaRN::$ES_ATIVACAO_2_FATORES);

      $objEmailSistemaRN = new EmailSistemaRN();
      $objEmailSistemaDTO = $objEmailSistemaRN->consultar($objEmailSistemaDTO);

      $strDe = $objEmailSistemaDTO->getStrDe();

      if (strpos($strDe, '@email_sistema@') !== false) {
        $objInfraParametro = new InfraParametro(BancoSip::getInstance());
        $strEmailSistema = $objInfraParametro->getValor('SIP_EMAIL_SISTEMA');

        if (InfraString::isBolVazia($strEmailSistema)) {
          $objInfraException->lancarValidacao('Par�metro SIP_EMAIL_SISTEMA n�o foi configurado.');
        }

        if (!InfraUtil::validarEmail($strEmailSistema)) {
          $objInfraException->lancarValidacao('Valor do par�metro SIP_EMAIL_SISTEMA inv�lido.');
        }

        $strDe = str_replace('@email_sistema@', $strEmailSistema, $strDe);
      }


      $strDe = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strDe);
      $strDe = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strDe);

      $strPara = $objEmailSistemaDTO->getStrPara();
      $strPara = str_replace('@email_usuario@', $parObjCodigoAcessoDTO->getStrEmail(), $strPara);
      $strPara = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strPara);

      $strAssunto = $objEmailSistemaDTO->getStrAssunto();
      $strAssunto = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_usuario@', $objCodigoAcessoDTOBanco->getStrSiglaUsuario(), $strAssunto);
      $strAssunto = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strAssunto);

      $strConteudo = $objEmailSistemaDTO->getStrConteudo();
      $strConteudo = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_usuario@', $objCodigoAcessoDTOBanco->getStrSiglaUsuario(), $strConteudo);
      $strConteudo = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strConteudo);
      $strConteudo = str_replace('@data@', InfraData::getStrDataAtual(), $strConteudo);
      $strConteudo = str_replace('@hora@', date('H:i'), $strConteudo);
      $strConteudo = str_replace('@endereco_ativacao@', ConfiguracaoSip::getInstance()->getValor('Sip', 'URL') . '/processar_chave.php?chave_ativacao=' . $strChaveAtivacao, $strConteudo);

      $objEmailDTO = new EmailDTO();
      $objEmailDTO->setStrDe($strDe);
      $objEmailDTO->setStrPara($strPara);
      $objEmailDTO->setStrAssunto($strAssunto);
      $objEmailDTO->setStrMensagem($strConteudo);

      MailSip::getInstance()->adicionar($objEmailDTO);

      return true;
    } catch (Exception $e) {
      throw new InfraException('Erro no envio da ativa��o da autentica��o em 2 Fatores.', $e);
    }
  }

  protected function confirmarAtivacaoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraParametro = new InfraParametro(BancoSip::getInstance());

      $objInfraException = new InfraException();

      $strChaveExterna = $this->validarStrChaveExterna($parObjCodigoAcessoDTO->getStrChaveAtivacaoExterna(), $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setBolExclusaoLogica(false);
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retStrChaveAtivacao();
      $objCodigoAcessoDTO->retDthEnvioAtivacao();
      $objCodigoAcessoDTO->retDthAtivacao();
      $objCodigoAcessoDTO->retDthDesativacao();
      $objCodigoAcessoDTO->retNumIdUsuario();
      $objCodigoAcessoDTO->retStrSiglaUsuario();
      $objCodigoAcessoDTO->retStrNomeUsuario();
      $objCodigoAcessoDTO->retDthPausa2faUsuario();
      $objCodigoAcessoDTO->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTO->retStrSiglaSistema();
      $objCodigoAcessoDTO->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoOrgaoSistema();
      $objCodigoAcessoDTO->retStrSinAtivo();
      $objCodigoAcessoDTO->setStrIdCodigoAcesso(strtoupper(substr($strChaveExterna, 0, 26)));

      $objCodigoAcessoDTO = $this->consultar($objCodigoAcessoDTO);

      if ($objCodigoAcessoDTO == null) {
        //$objInfraException->lancarValidacao('Registro n�o encontrado.');
        die;
      }

      if ($objCodigoAcessoDTO->getDthDesativacao() != null) {
        $objInfraException->lancarValidacao('Este link n�o � mais v�lido porque ap�s o seu envio outro QR Code foi gerado.');
      }

      $objInfraBcrypt = new InfraBcrypt();
      if (!$objInfraBcrypt->verificar(md5($strChaveExterna), $objCodigoAcessoDTO->getStrChaveAtivacao())) {
        $objInfraException->lancarValidacao('Chave de Ativa��o inv�lida.');
      }

      if ($objCodigoAcessoDTO->getStrSinAtivo() == 'S') {
        $objInfraException->lancarValidacao('A autentica��o em 2 fatores j� foi ativada.');
      }

      $numMinutosChaveAtivacao = $objInfraParametro->getValor('SIP_2_FATORES_TEMPO_MINUTOS_LINK_HABILITACAO');

      if (InfraData::compararDataHora(InfraData::calcularData($numMinutosChaveAtivacao, InfraData::$UNIDADE_MINUTOS, InfraData::$SENTIDO_ATRAS), $objCodigoAcessoDTO->getDthEnvioAtivacao()) < 0) {
        $objInfraException->lancarValidacao('Chave de Ativa��o vencida.');
      }

      if ($objCodigoAcessoDTO->getDthAtivacao() != null) {
        $objInfraException->lancarValidacao('Chave de Ativa��o j� foi utilizada.');
      }

      $objCodigoAcessoDTOAtivacao = new CodigoAcessoDTO();
      $objCodigoAcessoDTOAtivacao->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $this->reativar(array($objCodigoAcessoDTOAtivacao));

      if (InfraData::compararDataHorasSimples(InfraData::getStrDataHoraAtual(), $objCodigoAcessoDTO->getDthPausa2faUsuario()) > 0) {
        $objUsuarioDTO = new UsuarioDTO();
        $objUsuarioDTO->setNumIdUsuario($objCodigoAcessoDTO->getNumIdUsuario());
        $objUsuarioDTO->setNumIdUsuarioOperacao($objCodigoAcessoDTO->getNumIdUsuario());
        $objUsuarioDTO->setStrMotivo('Ativa��o de 2FA pelo usu�rio');
        $objUsuarioDTO->setStrIdCodigoAcesso(null);
        $objUsuarioDTO->setDthPausa2fa(null);

        $objUsuarioRN = new UsuarioRN();
        $objUsuarioRN->removerPausa2fa($objUsuarioDTO);
      }

      return $objCodigoAcessoDTO;
    } catch (Exception $e) {
      throw new InfraException('Erro ativando Autentica��o em 2 Fatores.', $e);
    }
  }

  public function enviarDesativacao(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    MailSip::getInstance()->limpar();
    $ret = $this->enviarDesativacaoInterno($parObjCodigoAcessoDTO);
    MailSip::getInstance()->enviar();
    return $ret;
  }

  protected function enviarDesativacaoInternoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraException = new InfraException();

      $objCodigoAcessoDTOBanco = new CodigoAcessoDTO();
      $objCodigoAcessoDTOBanco->setBolExclusaoLogica(false);
      $objCodigoAcessoDTOBanco->retStrEmail();
      $objCodigoAcessoDTOBanco->retStrSiglaUsuario();
      $objCodigoAcessoDTOBanco->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTOBanco->retStrNomeUsuario();
      $objCodigoAcessoDTOBanco->retStrSiglaSistema();
      $objCodigoAcessoDTOBanco->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTOBanco->retStrSinAtivo();
      $objCodigoAcessoDTOBanco->setNumIdUsuario($parObjCodigoAcessoDTO->getNumIdUsuario());
      $objCodigoAcessoDTOBanco->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());

      $objCodigoAcessoDTOBanco = $this->consultar($objCodigoAcessoDTOBanco);

      if ($objCodigoAcessoDTOBanco == null) {
        throw new InfraException('Habilita��o para Autentica��o em 2 Fatores n�o encontrada.');
      }

      if ($objCodigoAcessoDTOBanco->getStrSinAtivo() == 'N') {
        $objInfraException->lancarValidacao('A autentica��o em 2 fatores j� foi desativada.');
      }

      $parObjCodigoAcessoDTO->setStrEmail($objCodigoAcessoDTOBanco->getStrEmail());

      $objCodigoAcessoDTO = new CodigoAcessoDTO();

      $objInfraBcrypt = new InfraBcrypt();
      $strChaveDesativacao = strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32));
      $objCodigoAcessoDTO->setStrChaveDesativacao($objInfraBcrypt->hash(md5($strChaveDesativacao)));
      $objCodigoAcessoDTO->setDthEnvioDesativacao(InfraData::getStrDataHoraAtual());
      $objCodigoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
      $this->alterar($objCodigoAcessoDTO);

      $objEmailSistemaDTO = new EmailSistemaDTO();
      $objEmailSistemaDTO->retStrDe();
      $objEmailSistemaDTO->retStrPara();
      $objEmailSistemaDTO->retStrAssunto();
      $objEmailSistemaDTO->retStrConteudo();
      $objEmailSistemaDTO->setNumIdEmailSistema(EmailSistemaRN::$ES_DESATIVACAO_2_FATORES);

      $objEmailSistemaRN = new EmailSistemaRN();
      $objEmailSistemaDTO = $objEmailSistemaRN->consultar($objEmailSistemaDTO);

      $strDe = $objEmailSistemaDTO->getStrDe();

      if (strpos($strDe, '@email_sistema@') !== false) {
        $objInfraParametro = new InfraParametro(BancoSip::getInstance());
        $strEmailSistema = $objInfraParametro->getValor('SIP_EMAIL_SISTEMA');

        if (InfraString::isBolVazia($strEmailSistema)) {
          $objInfraException->lancarValidacao('Par�metro SIP_EMAIL_SISTEMA n�o foi configurado.');
        }

        if (!InfraUtil::validarEmail($strEmailSistema)) {
          $objInfraException->lancarValidacao('Valor do par�metro SIP_EMAIL_SISTEMA inv�lido.');
        }

        $strDe = str_replace('@email_sistema@', $strEmailSistema, $strDe);
      }


      $strDe = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strDe);
      $strDe = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strDe);

      $strPara = $objEmailSistemaDTO->getStrPara();
      $strPara = str_replace('@email_usuario@', $objCodigoAcessoDTOBanco->getStrEmail(), $strPara);
      $strPara = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strPara);

      $strAssunto = $objEmailSistemaDTO->getStrAssunto();
      $strAssunto = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_usuario@', $objCodigoAcessoDTOBanco->getStrSiglaUsuario(), $strAssunto);
      $strAssunto = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strAssunto);

      $strConteudo = $objEmailSistemaDTO->getStrConteudo();
      $strConteudo = str_replace('@sigla_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTOBanco->getStrSiglaOrgaoSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_usuario@', $objCodigoAcessoDTOBanco->getStrSiglaUsuario(), $strConteudo);
      $strConteudo = str_replace('@nome_usuario@', $objCodigoAcessoDTOBanco->getStrNomeUsuario(), $strConteudo);
      $strConteudo = str_replace('@data@', InfraData::getStrDataAtual(), $strConteudo);
      $strConteudo = str_replace('@hora@', date('H:i'), $strConteudo);
      $strConteudo = str_replace('@endereco_desativacao@', ConfiguracaoSip::getInstance()->getValor('Sip', 'URL') . '/processar_chave.php?chave_desativacao=' . $strChaveDesativacao, $strConteudo);

      $objEmailDTO = new EmailDTO();
      $objEmailDTO->setStrDe($strDe);
      $objEmailDTO->setStrPara($strPara);
      $objEmailDTO->setStrAssunto($strAssunto);
      $objEmailDTO->setStrMensagem($strConteudo);

      MailSip::getInstance()->adicionar($objEmailDTO);

      return true;
    } catch (Exception $e) {
      throw new InfraException('Erro no envio da desativa��o da autentica��o em 2 Fatores.', $e);
    }
  }

  protected function confirmarDesativacaoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraParametro = new InfraParametro(BancoSip::getInstance());

      $objInfraException = new InfraException();

      $strChaveExterna = $this->validarStrChaveExterna($parObjCodigoAcessoDTO->getStrChaveDesativacaoExterna(), $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setBolExclusaoLogica(false);
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retStrChaveDesativacao();
      $objCodigoAcessoDTO->retDthEnvioDesativacao();
      $objCodigoAcessoDTO->retDthDesativacao();
      $objCodigoAcessoDTO->retNumIdUsuario();
      $objCodigoAcessoDTO->retStrSiglaUsuario();
      $objCodigoAcessoDTO->retStrNomeUsuario();
      $objCodigoAcessoDTO->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTO->retStrSiglaSistema();
      $objCodigoAcessoDTO->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoOrgaoSistema();
      $objCodigoAcessoDTO->retStrSinAtivo();
      $objCodigoAcessoDTO->setStrIdCodigoAcesso(strtoupper(substr($strChaveExterna, 0, 26)));

      $objCodigoAcessoDTO = $this->consultar($objCodigoAcessoDTO);

      if ($objCodigoAcessoDTO == null) {
        //$objInfraException->lancarValidacao('Registro n�o encontrado.');
        die;
      }

      $objInfraBcrypt = new InfraBcrypt();
      if (!$objInfraBcrypt->verificar(md5($strChaveExterna), $objCodigoAcessoDTO->getStrChaveDesativacao())) {
        $objInfraException->lancarValidacao('Chave de Desativa��o inv�lida.');
      }

      if ($objCodigoAcessoDTO->getStrSinAtivo() == 'N') {
        $objInfraException->lancarValidacao('A autentica��o em 2 fatores j� foi desativada.');
      }

      $numMinutosChaveDesativacao = $objInfraParametro->getValor('SIP_2_FATORES_TEMPO_MINUTOS_LINK_HABILITACAO');

      if (InfraData::compararDataHora(InfraData::calcularData($numMinutosChaveDesativacao, InfraData::$UNIDADE_MINUTOS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()), $objCodigoAcessoDTO->getDthEnvioDesativacao()) < 0) {
        $objInfraException->lancarValidacao('Chave de Desativa��o vencida.');
      }

      if ($objCodigoAcessoDTO->getDthDesativacao() != null) {
        $objInfraException->lancarValidacao('Chave de Desativa��o j� foi utilizada.');
      }

      $objCodigoAcessoDTODesativacao = new CodigoAcessoDTO();
      $objCodigoAcessoDTODesativacao->setNumIdUsuarioDesativacao($objCodigoAcessoDTO->getNumIdUsuario());
      $objCodigoAcessoDTODesativacao->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $this->desativar(array($objCodigoAcessoDTODesativacao));

      return $objCodigoAcessoDTO;
    } catch (Exception $e) {
      throw new InfraException('Erro desativando Autentica��o em 2 Fatores.', $e);
    }
  }

  protected function enviarBloqueioUsuarioControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraParametro = new InfraParametro(BancoSip::getInstance());

      $objInfraException = new InfraException();

      $objInfraBcrypt = new InfraBcrypt();

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retNumIdUsuario();
      $objCodigoAcessoDTO->retStrSiglaUsuario();
      $objCodigoAcessoDTO->retStrNomeUsuario();
      $objCodigoAcessoDTO->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTO->retStrEmail();
      $objCodigoAcessoDTO->retStrSiglaSistema();
      $objCodigoAcessoDTO->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoOrgaoSistema();
      $objCodigoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());

      $objCodigoAcessoDTO = $this->consultar($objCodigoAcessoDTO);

      if ($objCodigoAcessoDTO == null) {
        $objInfraException->lancarValidacao('C�digo de Acesso n�o encontrado.');
      }

      $objCodigoBloqueioDTO = new CodigoBloqueioDTO();
      $objCodigoBloqueioDTO->setStrIdCodigoBloqueio(InfraULID::gerar());
      $objCodigoBloqueioDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
      $strChaveExterna = strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32));
      $objCodigoBloqueioDTO->setStrChaveBloqueio($objInfraBcrypt->hash(md5($strChaveExterna)));
      $objCodigoBloqueioDTO->setDthEnvio(InfraData::getStrDataHoraAtual());
      $objCodigoBloqueioDTO->setDthBloqueio(null);
      $objCodigoBloqueioDTO->setStrSinAtivo('S');

      $objCodigoBloqueioRN = new CodigoBloqueioRN();
      $objCodigoBloqueioRN->cadastrar($objCodigoBloqueioDTO);

      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->setBolExclusaoLogica(false);
      $objUsuarioDTO->retNumIdUsuario();
      $objUsuarioDTO->retStrSinBloqueado();
      $objUsuarioDTO->setNumIdUsuario($objCodigoAcessoDTO->getNumIdUsuario());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultar($objUsuarioDTO);

      if ($objUsuarioDTO == null) {
        $objInfraException->lancarValidacao('Usu�rio n�o encontrado.');
      }

      if ($objUsuarioDTO->getStrSinBloqueado() == 'S') {
        $objInfraException->lancarValidacao('Usu�rio j� est� bloqueado.');
      }

      $objEmailSistemaDTO = new EmailSistemaDTO();
      $objEmailSistemaDTO->retStrDe();
      $objEmailSistemaDTO->retStrPara();
      $objEmailSistemaDTO->retStrAssunto();
      $objEmailSistemaDTO->retStrConteudo();
      $objEmailSistemaDTO->setNumIdEmailSistema(EmailSistemaRN::$ES_ALERTA_SEGURANCA);

      $objEmailSistemaRN = new EmailSistemaRN();
      $objEmailSistemaDTO = $objEmailSistemaRN->consultar($objEmailSistemaDTO);

      $strEmailSistema = $objInfraParametro->getValor('SIP_EMAIL_SISTEMA');

      $strDe = $objEmailSistemaDTO->getStrDe();
      $strDe = str_replace('@email_sistema@', $strEmailSistema, $strDe);
      $strDe = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strDe);
      $strDe = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strDe);

      $strPara = $objEmailSistemaDTO->getStrPara();
      $strPara = str_replace('@email_usuario@', $objCodigoAcessoDTO->getStrEmail(), $strPara);

      $strAssunto = $objEmailSistemaDTO->getStrAssunto();
      $strAssunto = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_usuario@', $objCodigoAcessoDTO->getStrSiglaUsuario(), $strAssunto);
      $strAssunto = str_replace('@nome_usuario@', $objCodigoAcessoDTO->getStrNomeUsuario(), $strAssunto);

      $strConteudo = $objEmailSistemaDTO->getStrConteudo();
      $strConteudo = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_usuario@', $objCodigoAcessoDTO->getStrSiglaUsuario(), $strConteudo);
      $strConteudo = str_replace('@nome_usuario@', $objCodigoAcessoDTO->getStrNomeUsuario(), $strConteudo);
      $strConteudo = str_replace('@data@', InfraData::getStrDataAtual(), $strConteudo);
      $strConteudo = str_replace('@hora@', date('H:i'), $strConteudo);
      $strConteudo = str_replace('@endereco_bloqueio@', ConfiguracaoSip::getInstance()->getValor('Sip', 'URL') . '/processar_chave.php?chave_bloqueio=' . $strChaveExterna, $strConteudo);

      $objEmailDTO = new EmailDTO();
      $objEmailDTO->setStrDe($strDe);
      $objEmailDTO->setStrPara($strPara);
      $objEmailDTO->setStrAssunto($strAssunto);
      $objEmailDTO->setStrMensagem($strConteudo);

      MailSip::getInstance()->adicionar($objEmailDTO);
    } catch (Exception $e) {
      throw new InfraException('Erro gerando dados de bloqueio.', $e);
    }
  }

  public function confirmarBloqueioUsuario(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    MailSip::getInstance()->limpar();
    $ret = $this->confirmarBloqueioUsuarioInterno($parObjCodigoAcessoDTO);
    MailSip::getInstance()->enviar();
    return $ret;
  }

  protected function confirmarBloqueioUsuarioInternoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objInfraBcrypt = new InfraBcrypt();

      $objInfraException = new InfraException();

      $strChaveExterna = $this->validarStrChaveExterna($parObjCodigoAcessoDTO->getStrChaveBloqueioExterna(), $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoAcessoDTO = new CodigoAcessoDTO();
      $objCodigoAcessoDTO->setBolExclusaoLogica(false);
      $objCodigoAcessoDTO->retStrIdCodigoAcesso();
      $objCodigoAcessoDTO->retDthEnvioDesativacao();
      $objCodigoAcessoDTO->retDthDesativacao();
      $objCodigoAcessoDTO->retNumIdUsuario();
      $objCodigoAcessoDTO->retStrSiglaUsuario();
      $objCodigoAcessoDTO->retStrNomeUsuario();
      $objCodigoAcessoDTO->retStrSiglaOrgaoUsuario();
      $objCodigoAcessoDTO->retStrSiglaSistema();
      $objCodigoAcessoDTO->retStrSiglaOrgaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoSistema();
      $objCodigoAcessoDTO->retStrDescricaoOrgaoSistema();
      $objCodigoAcessoDTO->retStrEmail();
      $objCodigoAcessoDTO->retStrSinAtivo();
      $objCodigoAcessoDTO->setStrIdCodigoAcesso(strtoupper(substr($strChaveExterna, 0, 26)));

      $objCodigoAcessoDTO = $this->consultar($objCodigoAcessoDTO);

      if ($objCodigoAcessoDTO == null) {
        //$objInfraException->lancarValidacao('Registro n�o encontrado.');
        die;
      }

      $objInfraParametro = new InfraParametro(BancoSip::getInstance());
      $numDiasChaveBloqueio = $objInfraParametro->getValor('SIP_2_FATORES_TEMPO_DIAS_LINK_BLOQUEIO');

      $objCodigoBloqueioDTO = new CodigoBloqueioDTO();
      $objCodigoBloqueioDTO->retStrIdCodigoBloqueio();
      $objCodigoBloqueioDTO->retStrChaveBloqueio();
      $objCodigoBloqueioDTO->retDthBloqueio();
      $objCodigoBloqueioDTO->setDthEnvio(InfraData::calcularData($numDiasChaveBloqueio, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()), InfraDTO::$OPER_MAIOR);
      $objCodigoBloqueioDTO->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());

      $objCodigoBloqueioRN = new CodigoBloqueioRN();
      $arrObjCodigoBloqueioDTO = $objCodigoBloqueioRN->listar($objCodigoBloqueioDTO);
      $objCodigoBloqueioDTO = null;
      foreach ($arrObjCodigoBloqueioDTO as $objCodigoBloqueioDTOBanco) {
        if ($objInfraBcrypt->verificar(md5($strChaveExterna), $objCodigoBloqueioDTOBanco->getStrChaveBloqueio())) {
          $objCodigoBloqueioDTO = $objCodigoBloqueioDTOBanco;
          break;
        }
      }

      if ($objCodigoBloqueioDTO == null) {
        $objInfraException->lancarValidacao('Chave de Bloqueio inv�lida.');
      }

      if ($objCodigoBloqueioDTO->getDthBloqueio() != null) {
        $objInfraException->lancarValidacao('C�digo de bloqueio j� foi utilizado.');
      }

      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->setBolExclusaoLogica(false);
      $objUsuarioDTO->retNumIdUsuario();
      $objUsuarioDTO->retStrSinBloqueado();
      $objUsuarioDTO->setNumIdUsuario($objCodigoAcessoDTO->getNumIdUsuario());

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultar($objUsuarioDTO);

      if ($objUsuarioDTO == null) {
        $objInfraException->lancarValidacao('Usu�rio n�o encontrado.');
      }

      if ($objUsuarioDTO->getStrSinBloqueado() == 'S') {
        $objInfraException->lancarValidacao('Usu�rio j� est� bloqueado.');
      }

      $objCodigoBloqueioDTO->setDthBloqueio(InfraData::getStrDataHoraAtual());
      $objCodigoBloqueioDTO->setStrSinAtivo('N');
      $objCodigoBloqueioRN->alterar($objCodigoBloqueioDTO);

      $objUsuarioDTOBloqueio = new UsuarioDTO();
      $objUsuarioDTOBloqueio->setStrMotivo('Bloqueio efetuado por link em e-mail de alerta de seguran�a.');
      $objUsuarioDTOBloqueio->setStrIdCodigoAcesso($objCodigoAcessoDTO->getStrIdCodigoAcesso());
      $objUsuarioDTOBloqueio->setNumIdUsuario($objCodigoAcessoDTO->getNumIdUsuario());
      $objUsuarioDTOBloqueio->setNumIdUsuarioOperacao($objCodigoAcessoDTO->getNumIdUsuario());
      $objUsuarioRN->bloquear($objUsuarioDTOBloqueio);

      $objEmailSistemaDTO = new EmailSistemaDTO();
      $objEmailSistemaDTO->retStrDe();
      $objEmailSistemaDTO->retStrPara();
      $objEmailSistemaDTO->retStrAssunto();
      $objEmailSistemaDTO->retStrConteudo();
      $objEmailSistemaDTO->setNumIdEmailSistema(EmailSistemaRN::$ES_AVISO_BLOQUEIO);

      $objEmailSistemaRN = new EmailSistemaRN();
      $objEmailSistemaDTO = $objEmailSistemaRN->consultar($objEmailSistemaDTO);

      $strEmailSistema = $objInfraParametro->getValor('SIP_EMAIL_SISTEMA');

      $strDe = $objEmailSistemaDTO->getStrDe();
      $strDe = str_replace('@email_sistema@', $strEmailSistema, $strDe);
      $strDe = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strDe);
      $strDe = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strDe);

      $strPara = $objEmailSistemaDTO->getStrPara();
      $strPara = str_replace('@email_usuario@', $objCodigoAcessoDTO->getStrEmail(), $strPara);

      $strAssunto = $objEmailSistemaDTO->getStrAssunto();
      $strAssunto = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strAssunto);
      $strAssunto = str_replace('@sigla_usuario@', $objCodigoAcessoDTO->getStrSiglaUsuario(), $strAssunto);
      $strAssunto = str_replace('@nome_usuario@', $objCodigoAcessoDTO->getStrNomeUsuario(), $strAssunto);

      $strConteudo = $objEmailSistemaDTO->getStrConteudo();
      $strConteudo = str_replace('@sigla_sistema@', $objCodigoAcessoDTO->getStrSiglaSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_orgao_sistema@', $objCodigoAcessoDTO->getStrSiglaOrgaoSistema(), $strConteudo);
      $strConteudo = str_replace('@sigla_usuario@', $objCodigoAcessoDTO->getStrSiglaUsuario(), $strConteudo);
      $strConteudo = str_replace('@nome_usuario@', $objCodigoAcessoDTO->getStrNomeUsuario(), $strConteudo);
      $strConteudo = str_replace('@data@', InfraData::getStrDataAtual(), $strConteudo);
      $strConteudo = str_replace('@hora@', date('H:i'), $strConteudo);

      $objEmailDTO = new EmailDTO();
      $objEmailDTO->setStrDe($strDe);
      $objEmailDTO->setStrPara($strPara);
      $objEmailDTO->setStrAssunto($strAssunto);
      $objEmailDTO->setStrMensagem($strConteudo);

      MailSip::getInstance()->adicionar($objEmailDTO);

      return $objCodigoAcessoDTO;
    } catch (Exception $e) {
      throw new InfraException('Erro bloqueando usu�rio por e-mail.', $e);
    }
  }

  protected function adicionarDispositivoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objDispositivoAcessoRN = new DispositivoAcessoRN();

      $objInfraBcrypt = new InfraBcrypt();

      $objInfraException = new InfraException();

      $strChaveExterna = null;
      if ($parObjCodigoAcessoDTO->getStrChaveDispositivoExterna() != null) {
        $strChaveExterna = $this->validarStrChaveExterna($parObjCodigoAcessoDTO->getStrChaveDispositivoExterna(), $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $strIdDispositivoAcesso = null;

      if ($strChaveExterna != null) {
        $objInfraParametro = new InfraParametro(BancoSip::getInstance());
        $numDiasValidadeDispositivo = $objInfraParametro->getValor('SIP_2_FATORES_TEMPO_DIAS_VALIDADE_DISPOSITIVO');

        $objDispositivoAcessoDTO = new DispositivoAcessoDTO();
        $objDispositivoAcessoDTO->retStrIdDispositivoAcesso();
        $objDispositivoAcessoDTO->retStrChaveDispositivo();
        $objDispositivoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
        $objDispositivoAcessoDTO->setDthAcesso(InfraData::calcularData($numDiasValidadeDispositivo, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()), InfraDTO::$OPER_MAIOR);

        $arrObjDispositivoAcessoDTO = $objDispositivoAcessoRN->listar($objDispositivoAcessoDTO);

        foreach ($arrObjDispositivoAcessoDTO as $objDispositivoAcessoDTO) {
          if ($objInfraBcrypt->verificar(md5($strChaveExterna), $objDispositivoAcessoDTO->getStrChaveDispositivo())) {
            $strIdDispositivoAcesso = $objDispositivoAcessoDTO->getStrIdDispositivoAcesso();
            break;
          }
        }
      }

      $objDispositivoAcessoDTO = new DispositivoAcessoDTO();

      if ($strIdDispositivoAcesso == null) {
        $objDispositivoAcessoDTO->setStrIdDispositivoAcesso(InfraULID::gerar());
        $objDispositivoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
        $objDispositivoAcessoDTO->setStrSinAtivo('S');
      } else {
        $objDispositivoAcessoDTO->setStrIdDispositivoAcesso($strIdDispositivoAcesso);
      }

      $parObjCodigoAcessoDTO->setStrChaveDispositivoExterna(strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32)));
      $objDispositivoAcessoDTO->setStrChaveDispositivo($objInfraBcrypt->hash(md5($parObjCodigoAcessoDTO->getStrChaveDispositivoExterna())));
      $parObjCodigoAcessoDTO->setStrIdDispositivoAcesso($objDispositivoAcessoDTO->getStrIdDispositivoAcesso());

      if ($parObjCodigoAcessoDTO->getStrSinLiberarDispositivo() == 'S') {
        $objDispositivoAcessoDTO->setDthLiberacao(InfraData::getStrDataHoraAtual());
        $parObjCodigoAcessoDTO->setStrChaveAcessoExterna(strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32)));
        $objDispositivoAcessoDTO->setStrChaveAcesso($objInfraBcrypt->hash(md5($parObjCodigoAcessoDTO->getStrChaveAcessoExterna())));
      } else {
        $objDispositivoAcessoDTO->setDthLiberacao(null);
        $parObjCodigoAcessoDTO->setStrChaveAcessoExterna(null);
        $objDispositivoAcessoDTO->setStrChaveAcesso(null);
      }

      $objDispositivoAcessoDTO->setStrUserAgent(substr($_SERVER['HTTP_USER_AGENT'], 0, 500));
      $objDispositivoAcessoDTO->setDthAcesso(InfraData::getStrDataHoraAtual());
      $objDispositivoAcessoDTO->setStrIpAcesso(InfraUtil::getStrIpUsuario());

      if ($strIdDispositivoAcesso == null) {
        $objDispositivoAcessoRN->cadastrar($objDispositivoAcessoDTO);
      } else {
        $objDispositivoAcessoRN->alterar($objDispositivoAcessoDTO);
      }

      if ($strIdDispositivoAcesso == null) {
        $this->enviarBloqueioUsuario($parObjCodigoAcessoDTO);
      }
    } catch (Exception $e) {
      throw new InfraException('Erro adicionando Dispositivo de Acesso.', $e);
    }
  }

  protected function verificarDispositivoControlado(CodigoAcessoDTO $parObjCodigoAcessoDTO) {
    try {
      $objDispositivoAcessoRN = new DispositivoAcessoRN();

      $objInfraException = new InfraException();

      $strChaveExterna = $this->validarStrChaveExterna($parObjCodigoAcessoDTO->getStrChaveAcessoExterna(), $objInfraException);

      $objInfraException->lancarValidacoes();

      $objInfraBcrypt = new InfraBcrypt();

      $objInfraParametro = new InfraParametro(BancoSip::getInstance());
      $numDiasValidadeDispositivo = $objInfraParametro->getValor('SIP_2_FATORES_TEMPO_DIAS_VALIDADE_DISPOSITIVO');

      $objDispositivoAcessoDTO = new DispositivoAcessoDTO();
      $objDispositivoAcessoDTO->retStrIdDispositivoAcesso();
      $objDispositivoAcessoDTO->retStrChaveAcesso();
      $objDispositivoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());
      $objDispositivoAcessoDTO->setDthAcesso(InfraData::calcularData($numDiasValidadeDispositivo, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()), InfraDTO::$OPER_MAIOR);

      $arrObjDispositivoAcessoDTO = $objDispositivoAcessoRN->listar($objDispositivoAcessoDTO);

      foreach ($arrObjDispositivoAcessoDTO as $objDispositivoAcessoDTO) {
        if ($objInfraBcrypt->verificar(md5($strChaveExterna), $objDispositivoAcessoDTO->getStrChaveAcesso())) {
          $strDataHora = InfraData::getStrDataHoraAtual();

          $objDispositivoAcessoDTO2 = new DispositivoAcessoDTO();
          $parObjCodigoAcessoDTO->setStrChaveAcessoExterna(strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32)));
          $objDispositivoAcessoDTO2->setStrChaveAcesso($objInfraBcrypt->hash(md5($parObjCodigoAcessoDTO->getStrChaveAcessoExterna())));
          $parObjCodigoAcessoDTO->setStrChaveDispositivoExterna(strtolower($parObjCodigoAcessoDTO->getStrIdCodigoAcesso()) . hash('SHA512', random_bytes(32)));
          $objDispositivoAcessoDTO2->setStrChaveDispositivo($objInfraBcrypt->hash(md5($parObjCodigoAcessoDTO->getStrChaveDispositivoExterna())));
          $objDispositivoAcessoDTO2->setDthAcesso($strDataHora);
          $objDispositivoAcessoDTO2->setStrIpAcesso(InfraUtil::getStrIpUsuario());
          $objDispositivoAcessoDTO2->setStrUserAgent(substr($_SERVER['HTTP_USER_AGENT'], 0, 500));
          $objDispositivoAcessoDTO2->setStrIdDispositivoAcesso($objDispositivoAcessoDTO->getStrIdDispositivoAcesso());
          $objDispositivoAcessoRN->alterar($objDispositivoAcessoDTO2);

          $objCodigoAcessoDTO = new CodigoAcessoDTO();
          $objCodigoAcessoDTO->setDthAcesso($strDataHora);
          $objCodigoAcessoDTO->setStrIdCodigoAcesso($parObjCodigoAcessoDTO->getStrIdCodigoAcesso());

          $this->alterar($objCodigoAcessoDTO);

          return $objDispositivoAcessoDTO;
        }
      }

      return null;
    } catch (Exception $e) {
      throw new InfraException('Erro verificando Dispositivo de Acesso.', $e);
    }
  }
}
