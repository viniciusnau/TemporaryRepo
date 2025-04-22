<?
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 
 * 08/11/2006 - criado por MGA
 *
 */

require_once dirname(__FILE__) . '/Sip.php';

class SessaoSip extends InfraSessao {

  private static $instance = null;


  //inicio - atributos para simular login
  private $numIdOrgaoSistema = null;
  private $numIdSistema = null;
  private $strSiglaOrgaoUsuario = null;
  private $numIdOrgaoUsuario = null;
  private $numIdUsuario = null;
  private $strSiglaUsuario = null;
  private $strNomeUsuario = null;
  private $numIdUnidadeAtual = null;
  private $numIdOrgaoUnidadeAtual = null;

  //fim - atributos para simular login


  public static function getInstance($bolHabilitada = true) {
    if (self::$instance == null) {
      self::$instance = new SessaoSip($bolHabilitada);
    }
    return self::$instance;
  }

  public function __construct($bolHabilitada) {
    parent::__construct($bolHabilitada);
  }

  public function getStrSiglaOrgaoSistema() {
    return ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'SiglaOrgaoSistema');
  }

  public function getStrSiglaSistema() {
    return ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'SiglaSistema');
  }

  public function getStrPaginaLogin() {
    return ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'PaginaLogin');
  }

  public function getStrSipWsdl() {
    return ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'SipWsdl');
  }

  public function getStrSipChaveAcesso() {
    return ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'ChaveAcesso');
  }

  //inicio - fun��es para simular um login
  public function setNumIdOrgaoSistema($numIdOrgaoSistema) {
    $this->numIdOrgaoSistema = $numIdOrgaoSistema;
  }

  public function setNumIdSistema($numIdSistema) {
    $this->numIdSistema = $numIdSistema;
  }

  public function setStrSiglaOrgaoUsuario($strSiglaOrgaoUsuario) {
    $this->strSiglaOrgaoUsuario = $strSiglaOrgaoUsuario;
  }

  public function setNumIdOrgaoUsuario($numIdOrgaoUsuario) {
    $this->numIdOrgaoUsuario = $numIdOrgaoUsuario;
  }

  public function setNumIdUsuario($numIdUsuario) {
    $this->numIdUsuario = $numIdUsuario;
  }

  public function setStrSiglaUsuario($strSiglaUsuario) {
    $this->strSiglaUsuario = $strSiglaUsuario;
  }

  public function setStrNomeUsuario($strNomeUsuario) {
    $this->strNomeUsuario = $strNomeUsuario;
  }

  public function setNumIdUnidadeAtual($numIdUnidadeAtual) {
    $this->numIdUnidadeAtual = $numIdUnidadeAtual;
  }

  public function setNumIdOrgaoUnidadeAtual($numIdOrgaoUnidadeAtual) {
    $this->numIdOrgaoUnidadeAtual = $numIdOrgaoUnidadeAtual;
  }

  public function getNumIdOrgaoSistema() {
    return (!$this->isBolHabilitada()) ? $this->numIdOrgaoSistema : parent::getNumIdOrgaoSistema();
  }

  public function getNumIdSistema() {
    return (!$this->isBolHabilitada()) ? $this->numIdSistema : parent::getNumIdSistema();
  }

  public function getStrSiglaOrgaoUsuario() {
    return (!$this->isBolHabilitada()) ? $this->strSiglaOrgaoUsuario : parent::getStrSiglaOrgaoUsuario();
  }

  public function getNumIdOrgaoUsuario() {
    return (!$this->isBolHabilitada()) ? $this->numIdOrgaoUsuario : parent::getNumIdOrgaoUsuario();
  }

  public function getNumIdUsuario() {
    return (!$this->isBolHabilitada()) ? $this->numIdUsuario : parent::getNumIdUsuario();
  }

  public function getStrSiglaUsuario() {
    return (!$this->isBolHabilitada()) ? $this->strSiglaUsuario : parent::getStrSiglaUsuario();
  }

  public function getStrNomeUsuario() {
    return (!$this->isBolHabilitada()) ? $this->strNomeUsuario : parent::getStrNomeUsuario();
  }

  public function getNumIdUnidadeAtual() {
    return (!$this->isBolHabilitada()) ? $this->numIdUnidadeAtual : parent::getNumIdUnidadeAtual();
  }

  public function getNumIdOrgaoUnidadeAtual() {
    return (!$this->isBolHabilitada()) ? $this->numIdOrgaoUnidadeAtual : parent::getNumIdOrgaoUnidadeAtual();
  }

  //fim - fun��es para simular um login

  public function getObjInfraAuditoria() {
    return AuditoriaSip::getInstance();
  }

  public function getObjInfraLog() {
    return LogSip::getInstance();
  }

  public function simularLogin() {
    try {
      $objInfraParametro = new InfraParametro(BancoSip::getInstance());

      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->retNumIdUsuario();
      $objUsuarioDTO->retNumIdOrgao();
      $objUsuarioDTO->retStrSiglaOrgao();
      $objUsuarioDTO->retStrSigla();
      $objUsuarioDTO->retStrNome();

      $objUsuarioDTO->setNumIdUsuario($objInfraParametro->getValor('ID_USUARIO_SIP'));

      $objUsuarioRN = new UsuarioRN();
      $objUsuarioDTO = $objUsuarioRN->consultar($objUsuarioDTO);

      if ($objUsuarioDTO == null) {
        throw new InfraException('Usu�rio ID_USUARIO_SIP n�o encontrado.');
      }

      //Usu�rio
      $this->setNumIdOrgaoUsuario($objUsuarioDTO->getNumIdOrgao());
      $this->setStrSiglaOrgaoUsuario($objUsuarioDTO->getStrSiglaOrgao());
      $this->setNumIdUsuario($objUsuarioDTO->getNumIdUsuario());
      $this->setStrSiglaUsuario($objUsuarioDTO->getStrSigla());
      $this->setStrNomeUsuario($objUsuarioDTO->getStrNome());

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->retNumIdUnidade();
      $objUnidadeDTO->retNumIdOrgao();
      $objUnidadeDTO->setNumIdUnidade($objInfraParametro->getValor('ID_UNIDADE_TESTE'));

      $objUnidadeRN = new UnidadeRN();
      $objUnidadeDTO = $objUnidadeRN->consultar($objUnidadeDTO);

      if ($objUnidadeDTO == null) {
        throw new InfraException('Unidade ID_UNIDADE_TESTE n�o encontrado.');
      }

      $this->setNumIdUnidadeAtual($objUnidadeDTO->getNumIdUnidade());
      $this->setNumIdOrgaoUnidadeAtual($objUnidadeDTO->getNumIdOrgao());

      //Sistema
      $objSistemaDTO = new SistemaDTO();
      $objSistemaDTO->retNumIdSistema();
      $objSistemaDTO->retNumIdOrgao();
      $objSistemaDTO->setNumIdSistema($objInfraParametro->getValor('ID_SISTEMA_SIP'));

      $objSistemaRN = new SistemaRN();
      $objSistemaDTO = $objSistemaRN->consultar($objSistemaDTO);

      if ($objSistemaDTO == null) {
        throw new InfraException('Sistema ID_SISTEMA_SIP n�o encontrado.');
      }

      $this->setNumIdOrgaoSistema($objSistemaDTO->getNumIdOrgao());
      $this->setNumIdSistema($objSistemaDTO->getNumIdSistema());
    } catch (Exception $e) {
      throw new InfraException('Erro simulando login.', $e);
    }
  }

  public function getStrLinkTrocarUnidade() {
    $arrUrl = explode('/', ConfiguracaoSip::getInstance()->getValor('Sip', 'URL'));

    if (ConfiguracaoSip::getInstance()->getValor('SessaoSip', 'https')) {
      if ($arrUrl[0] == 'http') {
        $arrUrl[0] = 'https';
      }
    }

    return $arrUrl[0] . '//' . $arrUrl[2] . $_SERVER['SCRIPT_NAME'] . '?acao=principal';
  }
}

?>