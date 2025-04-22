<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 16/09/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ServicoRN extends InfraRN
{

  public function __construct()
  {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco()
  {
    return BancoSEI::getInstance();
  }

  private function validarNumIdUsuario(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getNumIdUsuario())) {
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrIdentificacao(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrIdentificacao())) {
      $objInfraException->adicionarValidacao('Identifica��o n�o informada.');
    } else {

      $objServicoDTO_Banco = new ServicoDTO();
      $objServicoDTO_Banco->setStrIdentificacao(trim($objServicoDTO->getStrIdentificacao()));
      $objServicoDTO_Banco->setNumIdUsuario($objServicoDTO->getNumIdUsuario());
      $objServicoDTO_Banco->setNumIdServico($objServicoDTO->getNumIdServico(), InfraDTO::$OPER_DIFERENTE);

      if ($this->contar($objServicoDTO_Banco)) {
        $objInfraException->adicionarValidacao('J� existe um servi�o com esta identifica��o neste sistema.');
      }

      $objServicoDTO->setStrIdentificacao(trim($objServicoDTO->getStrIdentificacao()));

      if (strlen($objServicoDTO->getStrIdentificacao()) > 50) {
        $objInfraException->adicionarValidacao('Identifica��o possui tamanho superior a 50 caracteres.');
      }
    }
  }

  private function validarStrDescricao(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrDescricao())) {
      $objServicoDTO->setStrDescricao(null);
    } else {
      $objServicoDTO->setStrDescricao(trim($objServicoDTO->getStrDescricao()));

      if (strlen($objServicoDTO->getStrDescricao()) > 250) {
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrServidor(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if ($objServicoDTO->getStrSinServidor() == "S" && InfraString::isBolVazia($objServicoDTO->getStrServidor())) {
      $objInfraException->adicionarValidacao('Servidor n�o informado.');
    } else {
      $objServicoDTO->setStrServidor(str_replace(' ', '', $objServicoDTO->getStrServidor()));
    }
  }

  private function validarStrSinChaveAcesso(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrSinChaveAcesso())) {
      $objInfraException->adicionarValidacao('Sinalizador de autentica��o por Chave de Acesso n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objServicoDTO->getStrSinChaveAcesso())) {
        $objInfraException->adicionarValidacao('Sinalizador de autentica��o por Chave de Acesso inv�lido.');
      }
    }
  }

  private function validarStrSinServidor(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrSinServidor())) {
      $objInfraException->adicionarValidacao('Sinalizador de autentica��o por Endere�o n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objServicoDTO->getStrSinServidor())) {
        $objInfraException->adicionarValidacao('Sinalizador de autentica��o por Endere�o inv�lido.');
      }
    }
  }
  
  private function validarStrSinAtivo(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrSinAtivo())) {
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objServicoDTO->getStrSinAtivo())) {
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  private function validarStrSinLinkExterno(ServicoDTO $objServicoDTO, InfraException $objInfraException)
  {
    if (InfraString::isBolVazia($objServicoDTO->getStrSinLinkExterno())) {
      $objInfraException->adicionarValidacao('Sinalizador de Link Externo n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objServicoDTO->getStrSinLinkExterno())) {
        $objInfraException->adicionarValidacao('Sinalizador de Link Externo inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_cadastrar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUsuario($objServicoDTO, $objInfraException);
      $this->validarStrIdentificacao($objServicoDTO, $objInfraException);
      $this->validarStrDescricao($objServicoDTO, $objInfraException);
      $this->validarStrServidor($objServicoDTO, $objInfraException);
      $this->validarStrSinServidor($objServicoDTO, $objInfraException);
      $this->validarStrSinChaveAcesso($objServicoDTO, $objInfraException);
      $this->validarStrSinLinkExterno($objServicoDTO, $objInfraException);
      $this->validarStrSinAtivo($objServicoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $ret = $objServicoBD->cadastrar($objServicoDTO);

      //Auditoria

      return $ret;

    } catch (Exception $e) {
      throw new InfraException('Erro cadastrando Servi�o.', $e);
    }
  }


  protected function alterarControlado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_alterar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objServicoDTO->isSetNumIdUsuario()) {
        $this->validarNumIdUsuario($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrIdentificacao()) {
        $this->validarStrIdentificacao($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrDescricao()) {
        $this->validarStrDescricao($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrServidor()) {
        $this->validarStrServidor($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrSinServidor()) {
        $this->validarStrSinServidor($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrSinChaveAcesso()) {
        $this->validarStrSinChaveAcesso($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrSinLinkExterno()) {
        $this->validarStrSinLinkExterno($objServicoDTO, $objInfraException);
      }

      if ($objServicoDTO->isSetStrSinAtivo()) {
        $this->validarStrSinAtivo($objServicoDTO, $objInfraException);
      }


      $objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $objServicoBD->alterar($objServicoDTO);

      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro alterando Servi�o.', $e);
    }
  }

  protected function excluirControlado($arrObjServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_excluir', __METHOD__, $arrObjServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objOperacaoServicoRN = new OperacaoServicoRN();
      $objMonitoramentoServicoRN = new MonitoramentoServicoRN();
      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjServicoDTO); $i++) {

        $objOperacaoServicoDTO = new OperacaoServicoDTO();
        $objOperacaoServicoDTO->retNumIdOperacaoServico();
        $objOperacaoServicoDTO->setNumIdServico($arrObjServicoDTO[$i]->getNumIdServico());
        $objOperacaoServicoRN->excluir($objOperacaoServicoRN->listar($objOperacaoServicoDTO));

        $objMonitoramentoServicoDTO = new MonitoramentoServicoDTO();
        $objMonitoramentoServicoDTO->retDblIdMonitoramentoServico();
        $objMonitoramentoServicoDTO->setNumIdServico($arrObjServicoDTO[$i]->getNumIdServico());
        $objMonitoramentoServicoRN->excluir($objMonitoramentoServicoRN->listar($objMonitoramentoServicoDTO));

        $objServicoBD->excluir($arrObjServicoDTO[$i]);
      }

      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro excluindo Servi�o.', $e);
    }
  }

  protected function consultarConectado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_consultar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $ret = $objServicoBD->consultar($objServicoDTO);
      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro consultando Servi�o.', $e);
    }
  }

  protected function listarConectado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_listar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $ret = $objServicoBD->listar($objServicoDTO);

      //Auditoria

      return $ret;

    } catch (Exception $e) {
      throw new InfraException('Erro listando Servi�os.', $e);
    }
  }

  protected function contarConectado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_listar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $ret = $objServicoBD->contar($objServicoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro contando Servi�os.', $e);
    }
  }

  protected function desativarControlado($arrObjServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_desativar', __METHOD__, $arrObjServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjServicoDTO); $i++) {
        $objServicoBD->desativar($arrObjServicoDTO[$i]);
      }

      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro desativando Servi�o.', $e);
    }
  }

  protected function reativarControlado($arrObjServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_reativar', __METHOD__, $arrObjServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjServicoDTO); $i++) {
        $objServicoBD->reativar($arrObjServicoDTO[$i]);
      }

      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro reativando Servi�o.', $e);
    }
  }

  protected function bloquearControlado(ServicoDTO $objServicoDTO)
  {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('servico_consultar', __METHOD__, $objServicoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objServicoBD = new ServicoBD($this->getObjInfraIBanco());
      $ret = $objServicoBD->bloquear($objServicoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro bloqueando Servi�o.', $e);
    }
  }

  public static function gerarChaveAcessoControlado( ServicoDTO $objServicoDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('servico_gerar_chave_acesso', __METHOD__, $objServicoDTO);

      $strRandom = random_bytes(32);
      $strSha256 = hash('sha256', $strRandom);

      $objInfraBcrypt = new InfraBcrypt();
      $strChave = $objInfraBcrypt->hash(md5($strSha256));

      $strCrc = strtolower(hash('crc32b', $objServicoDTO->getNumIdServico()));

      $objServicoDTO_Chave = new ServicoDTO();
      $objServicoDTO_Chave->setStrCrc($strCrc);
      $objServicoDTO_Chave->setStrChaveAcesso($strChave);
      $objServicoDTO_Chave->setStrSinChaveAcesso('S');
      $objServicoDTO_Chave->setNumIdServico($objServicoDTO->getNumIdServico());

      $objServicoBD = new ServicoBD(BancoSEI::getInstance());
      $objServicoBD->alterar($objServicoDTO_Chave);

      $objServicoDTORet = new ServicoDTO();
      $objServicoDTORet->setStrChaveCompleta($strCrc.$strSha256);

      return $objServicoDTORet;

    }catch(Exception $e){
      throw new InfraException('Erro gerando chave de acesso para o Servi�o.', $e);
    }
  }

}
?>