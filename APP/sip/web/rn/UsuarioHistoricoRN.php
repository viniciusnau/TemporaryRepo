<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 11/07/2018 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.41.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class UsuarioHistoricoRN extends InfraRN {

  public static $OPER_BLOQUEAR = 'B';
  public static $OPER_DESBLOQUEAR = 'D';
  public static $OPER_PAUSAR_2FA = 'P';
  public static $OPER_REMOVER_PAUSA_2FA = 'R';

  public function __construct() {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco() {
    return BancoSip::getInstance();
  }

  public function listarValoresOperacao() {
    try {
      $arrObjOperacaoUsuarioHistoricoDTO = array();

      $objOperacaoUsuarioHistoricoDTO = new OperacaoUsuarioHistoricoDTO();
      $objOperacaoUsuarioHistoricoDTO->setStrStaOperacao(self::$OPER_BLOQUEAR);
      $objOperacaoUsuarioHistoricoDTO->setStrDescricao('Bloqueio');
      $arrObjOperacaoUsuarioHistoricoDTO[] = $objOperacaoUsuarioHistoricoDTO;

      $objOperacaoUsuarioHistoricoDTO = new OperacaoUsuarioHistoricoDTO();
      $objOperacaoUsuarioHistoricoDTO->setStrStaOperacao(self::$OPER_DESBLOQUEAR);
      $objOperacaoUsuarioHistoricoDTO->setStrDescricao('Desbloqueio');
      $arrObjOperacaoUsuarioHistoricoDTO[] = $objOperacaoUsuarioHistoricoDTO;

      $objOperacaoUsuarioHistoricoDTO = new OperacaoUsuarioHistoricoDTO();
      $objOperacaoUsuarioHistoricoDTO->setStrStaOperacao(self::$OPER_PAUSAR_2FA);
      $objOperacaoUsuarioHistoricoDTO->setStrDescricao('Pausa');
      $arrObjOperacaoUsuarioHistoricoDTO[] = $objOperacaoUsuarioHistoricoDTO;

      $objOperacaoUsuarioHistoricoDTO = new OperacaoUsuarioHistoricoDTO();
      $objOperacaoUsuarioHistoricoDTO->setStrStaOperacao(self::$OPER_REMOVER_PAUSA_2FA);
      $objOperacaoUsuarioHistoricoDTO->setStrDescricao('Remo��o Pausa');
      $arrObjOperacaoUsuarioHistoricoDTO[] = $objOperacaoUsuarioHistoricoDTO;

      return $arrObjOperacaoUsuarioHistoricoDTO;
    } catch (Exception $e) {
      throw new InfraException('Erro listando valores de Operacao.', $e);
    }
  }

  private function validarNumIdUsuario(UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getNumIdUsuario())) {
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrIdCodigoAcesso(
    UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getStrIdCodigoAcesso())) {
      $objUsuarioHistoricoDTO->setStrIdCodigoAcesso(null);
    }
  }

  private function validarNumIdUsuarioOperacao(
    UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getNumIdUsuarioOperacao())) {
      $objInfraException->adicionarValidacao('Executor n�o informado.');
    }
  }

  private function validarDthOperacao(UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getDthOperacao())) {
      $objInfraException->adicionarValidacao('Data/Hora do hist�rico n�o informada.');
    } else {
      if (!InfraData::validarDataHora($objUsuarioHistoricoDTO->getDthOperacao())) {
        $objInfraException->adicionarValidacao('Data/Hora do hist�rico inv�lida.');
      }
    }
  }

  private function validarDthPausa2fa(UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getDthPausa2fa())) {
      $objUsuarioHistoricoDTO->setDthPausa2fa(null);
    } else {
      if (!InfraData::validarDataHora($objUsuarioHistoricoDTO->getDthPausa2fa())) {
        $objInfraException->adicionarValidacao('Data/Hora de pausa da autentica��o em 2 fatores inv�lida.');
      }
    }
  }

  private function validarStrStaOperacao(
    UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getStrStaOperacao())) {
      $objInfraException->adicionarValidacao('Opera��o n�o informada.');
    } else {
      if (!in_array($objUsuarioHistoricoDTO->getStrStaOperacao(), InfraArray::converterArrInfraDTO($this->listarValoresOperacao(), 'StaOperacao'))) {
        $objInfraException->adicionarValidacao('Opera��o inv�lida.');
      }
    }
  }

  private function validarStrMotivo(UsuarioHistoricoDTO $objUsuarioHistoricoDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objUsuarioHistoricoDTO->getStrMotivo())) {
      $objUsuarioHistoricoDTO->setStrMotivo(null);
    } else {
      $objUsuarioHistoricoDTO->setStrMotivo(trim($objUsuarioHistoricoDTO->getStrMotivo()));

      if (strlen($objUsuarioHistoricoDTO->getStrMotivo()) > 4000) {
        $objInfraException->adicionarValidacao('Motivo possui tamanho superior a 4000 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_cadastrar', __METHOD__, $objUsuarioHistoricoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUsuario($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarStrIdCodigoAcesso($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarNumIdUsuarioOperacao($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarDthOperacao($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarDthPausa2fa($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarStrStaOperacao($objUsuarioHistoricoDTO, $objInfraException);
      $this->validarStrMotivo($objUsuarioHistoricoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioHistoricoBD->cadastrar($objUsuarioHistoricoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro cadastrando Registro de Opera��o.', $e);
    }
  }

  protected function alterarControlado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_alterar', __METHOD__, $objUsuarioHistoricoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objUsuarioHistoricoDTO->isSetNumIdUsuario()) {
        $this->validarNumIdUsuario($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetStrIdCodigoAcesso()) {
        $this->validarStrIdCodigoAcesso($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetNumIdUsuarioOperacao()) {
        $this->validarNumIdUsuarioOperacao($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetDthOperacao()) {
        $this->validarDthOperacao($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetDthPausa2fa()) {
        $this->validarDthPausa2fa($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetStrStaOperacao()) {
        $this->validarStrStaOperacao($objUsuarioHistoricoDTO, $objInfraException);
      }
      if ($objUsuarioHistoricoDTO->isSetStrMotivo()) {
        $this->validarStrMotivo($objUsuarioHistoricoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      $objUsuarioHistoricoBD->alterar($objUsuarioHistoricoDTO);
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro alterando Registro de Opera��o.', $e);
    }
  }

  protected function excluirControlado($arrObjUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_excluir', __METHOD__, $arrObjUsuarioHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjUsuarioHistoricoDTO); $i++) {
        $objUsuarioHistoricoBD->excluir($arrObjUsuarioHistoricoDTO[$i]);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro excluindo Registro de Opera��o.', $e);
    }
  }

  protected function consultarConectado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_consultar', __METHOD__, $objUsuarioHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioHistoricoBD->consultar($objUsuarioHistoricoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro consultando Registro de Opera��o.', $e);
    }
  }

  protected function listarConectado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_listar', __METHOD__, $objUsuarioHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioHistoricoBD->listar($objUsuarioHistoricoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro listando Hist�rico de Opera��es.', $e);
    }
  }

  protected function contarConectado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_listar', __METHOD__, $objUsuarioHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUsuarioHistoricoBD->contar($objUsuarioHistoricoDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro contando Hist�rico de Opera��es.', $e);
    }
  }
  /*
    protected function desativarControlado($arrObjUsuarioHistoricoDTO){
      try {

        //Valida Permissao
        SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_desativar', __METHOD__, $arrObjUsuarioHistoricoDTO);

        //Regras de Negocio
        //$objInfraException = new InfraException();

        //$objInfraException->lancarValidacoes();

        $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
        for($i=0;$i<count($arrObjUsuarioHistoricoDTO);$i++){
          $objUsuarioHistoricoBD->desativar($arrObjUsuarioHistoricoDTO[$i]);
        }

        //Auditoria

      }catch(Exception $e){
        throw new InfraException('Erro desativando Registro de Opera��o.',$e);
      }
    }

    protected function reativarControlado($arrObjUsuarioHistoricoDTO){
      try {

        //Valida Permissao
        SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_reativar', __METHOD__, $arrObjUsuarioHistoricoDTO);

        //Regras de Negocio
        //$objInfraException = new InfraException();

        //$objInfraException->lancarValidacoes();

        $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
        for($i=0;$i<count($arrObjUsuarioHistoricoDTO);$i++){
          $objUsuarioHistoricoBD->reativar($arrObjUsuarioHistoricoDTO[$i]);
        }

        //Auditoria

      }catch(Exception $e){
        throw new InfraException('Erro reativando Registro de Opera��o.',$e);
      }
    }

    protected function bloquearControlado(UsuarioHistoricoDTO $objUsuarioHistoricoDTO){
      try {

        //Valida Permissao
        SessaoSip::getInstance()->validarAuditarPermissao('usuario_historico_consultar', __METHOD__, $objUsuarioHistoricoDTO);

        //Regras de Negocio
        //$objInfraException = new InfraException();

        //$objInfraException->lancarValidacoes();

        $objUsuarioHistoricoBD = new UsuarioHistoricoBD($this->getObjInfraIBanco());
        $ret = $objUsuarioHistoricoBD->bloquear($objUsuarioHistoricoDTO);

        //Auditoria

        return $ret;
      }catch(Exception $e){
        throw new InfraException('Erro bloqueando Registro de Opera��o.',$e);
      }
    }

   */
}
