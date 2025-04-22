<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 05/07/2018 - criado por mga
 *
 */

require_once dirname(__FILE__) . '/../Sip.php';

class EmailSistemaRN extends InfraRN {

  public static $ES_ATIVACAO_2_FATORES = 1;
  public static $ES_DESATIVACAO_2_FATORES = 2;
  public static $ES_ALERTA_SEGURANCA = 3;
  public static $ES_AVISO_BLOQUEIO = 4;

  public function __construct() {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco() {
    return BancoSip::getInstance();
  }

  private function validarStrDescricao(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrDescricao())) {
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    } else {
      $objEmailSistemaDTO->setStrDescricao(trim($objEmailSistemaDTO->getStrDescricao()));

      if (strlen($objEmailSistemaDTO->getStrDescricao()) > 250) {
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrDe(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrDe())) {
      $objInfraException->adicionarValidacao('Remetente n�o informado.');
    } else {
      $objEmailSistemaDTO->setStrDe(trim($objEmailSistemaDTO->getStrDe()));

      if (strlen($objEmailSistemaDTO->getStrDe()) > 250) {
        $objInfraException->adicionarValidacao('Remetente possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrPara(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrPara())) {
      $objInfraException->adicionarValidacao('Destinat�rio n�o informado.');
    } else {
      $objEmailSistemaDTO->setStrPara(trim($objEmailSistemaDTO->getStrPara()));

      if (strlen($objEmailSistemaDTO->getStrPara()) > 250) {
        $objInfraException->adicionarValidacao('Destinat�rio possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrAssunto(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrAssunto())) {
      $objInfraException->adicionarValidacao('Assunto n�o informado.');
    } else {
      $objEmailSistemaDTO->setStrAssunto(trim($objEmailSistemaDTO->getStrAssunto()));

      if (strlen($objEmailSistemaDTO->getStrAssunto()) > 250) {
        $objInfraException->adicionarValidacao('Assunto possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarStrConteudo(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrConteudo())) {
      $objInfraException->adicionarValidacao('Conte�do n�o informado.');
    } else {
      if (strlen($objEmailSistemaDTO->getStrConteudo()) > 4000) {
        $objInfraException->adicionarValidacao('Conte�do possui tamanho superior a 4000 caracteres.');
      }
    }
  }

  private function validarStrSinAtivo(EmailSistemaDTO $objEmailSistemaDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objEmailSistemaDTO->getStrSinAtivo())) {
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objEmailSistemaDTO->getStrSinAtivo())) {
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(EmailSistemaDTO $objEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_cadastrar', __METHOD__, $objEmailSistemaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrDescricao($objEmailSistemaDTO, $objInfraException);
      $this->validarStrDe($objEmailSistemaDTO, $objInfraException);
      $this->validarStrPara($objEmailSistemaDTO, $objInfraException);
      $this->validarStrAssunto($objEmailSistemaDTO, $objInfraException);
      $this->validarStrConteudo($objEmailSistemaDTO, $objInfraException);
      $this->validarStrSinAtivo($objEmailSistemaDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      $ret = $objEmailSistemaBD->cadastrar($objEmailSistemaDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro cadastrando E-mail do Sistema.', $e);
    }
  }

  protected function alterarControlado(EmailSistemaDTO $objEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_alterar', __METHOD__, $objEmailSistemaDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objEmailSistemaDTO->isSetStrDescricao()) {
        $this->validarStrDescricao($objEmailSistemaDTO, $objInfraException);
      }
      if ($objEmailSistemaDTO->isSetStrDe()) {
        $this->validarStrDe($objEmailSistemaDTO, $objInfraException);
      }
      if ($objEmailSistemaDTO->isSetStrPara()) {
        $this->validarStrPara($objEmailSistemaDTO, $objInfraException);
      }
      if ($objEmailSistemaDTO->isSetStrAssunto()) {
        $this->validarStrAssunto($objEmailSistemaDTO, $objInfraException);
      }
      if ($objEmailSistemaDTO->isSetStrConteudo()) {
        $this->validarStrConteudo($objEmailSistemaDTO, $objInfraException);
      }
      if ($objEmailSistemaDTO->isSetStrSinAtivo()) {
        $this->validarStrSinAtivo($objEmailSistemaDTO, $objInfraException);
      }
      $objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      $objEmailSistemaBD->alterar($objEmailSistemaDTO);
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro alterando E-mail do Sistema.', $e);
    }
  }

  protected function excluirControlado($arrObjEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_excluir', __METHOD__, $arrObjEmailSistemaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjEmailSistemaDTO); $i++) {
        $objEmailSistemaBD->excluir($arrObjEmailSistemaDTO[$i]);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro excluindo E-mail do Sistema.', $e);
    }
  }

  protected function consultarConectado(EmailSistemaDTO $objEmailSistemaDTO) {
    try {
      //Valida Permissao
      //SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_consultar',__METHOD__,$objEmailSistemaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      $ret = $objEmailSistemaBD->consultar($objEmailSistemaDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro consultando E-mail do Sistema.', $e);
    }
  }

  protected function listarConectado(EmailSistemaDTO $objEmailSistemaDTO) {
    try {
      //Valida Permissao
      //SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_listar',__METHOD__,$objEmailSistemaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      $ret = $objEmailSistemaBD->listar($objEmailSistemaDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro listando E-mails do Sistema.', $e);
    }
  }

  protected function contarConectado(EmailSistemaDTO $objEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_listar', __METHOD__, $objEmailSistemaDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      $ret = $objEmailSistemaBD->contar($objEmailSistemaDTO);

      //Auditoria

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro contando E-mails do Sistema.', $e);
    }
  }

  protected function desativarControlado($arrObjEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjEmailSistemaDTO); $i++) {
        $objEmailSistemaBD->desativar($arrObjEmailSistemaDTO[$i]);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro desativando E-mail do Sistema.', $e);
    }
  }

  protected function reativarControlado($arrObjEmailSistemaDTO) {
    try {
      //Valida Permissao
      SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjEmailSistemaDTO); $i++) {
        $objEmailSistemaBD->reativar($arrObjEmailSistemaDTO[$i]);
      }
      //Auditoria

    } catch (Exception $e) {
      throw new InfraException('Erro reativando E-mail do Sistema.', $e);
    }
  }

  /*
    protected function bloquearControlado(EmailSistemaDTO $objEmailSistemaDTO){
      try {

        //Valida Permissao
        SessaoSip::getInstance()->validarAuditarPermissao('email_sistema_consultar');

        //Regras de Negocio
        //$objInfraException = new InfraException();

        //$objInfraException->lancarValidacoes();

        $objEmailSistemaBD = new EmailSistemaBD($this->getObjInfraIBanco());
        $ret = $objEmailSistemaBD->bloquear($objEmailSistemaDTO);

        //Auditoria

        return $ret;
      }catch(Exception $e){
        throw new InfraException('Erro bloqueando E-mail do Sistema.',$e);
      }
    }

   */
}

?>