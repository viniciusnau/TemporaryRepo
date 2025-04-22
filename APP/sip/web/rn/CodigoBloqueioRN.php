<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 14/10/2019 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.42.0
 */

require_once dirname(__FILE__) . '/../Sip.php';

class CodigoBloqueioRN extends InfraRN {

  public function __construct() {
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco() {
    return BancoSip::getInstance();
  }

  private function validarStrIdCodigoAcesso(
    CodigoBloqueioDTO $objCodigoBloqueioDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoBloqueioDTO->getStrIdCodigoAcesso())) {
      $objInfraException->adicionarValidacao('C�digo de Acesso n�o informado.');
    }
  }

  private function validarStrChaveBloqueio(CodigoBloqueioDTO $objCodigoBloqueioDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoBloqueioDTO->getStrChaveBloqueio())) {
      $objInfraException->adicionarValidacao('Chave de Bloqueio n�o informada.');
    } else {
      $objCodigoBloqueioDTO->setStrChaveBloqueio(trim($objCodigoBloqueioDTO->getStrChaveBloqueio()));

      if (strlen($objCodigoBloqueioDTO->getStrChaveBloqueio()) > 60) {
        $objInfraException->adicionarValidacao('Chave de Bloqueio possui tamanho superior a 60 caracteres.');
      }
    }
  }

  private function validarDthEnvio(CodigoBloqueioDTO $objCodigoBloqueioDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoBloqueioDTO->getDthEnvio())) {
      $objInfraException->adicionarValidacao('Data/Hora de Envio n�o informada.');
    } else {
      if (!InfraData::validarDataHora($objCodigoBloqueioDTO->getDthEnvio())) {
        $objInfraException->adicionarValidacao('Data/Hora de Envio inv�lida.');
      }
    }
  }

  private function validarDthBloqueio(CodigoBloqueioDTO $objCodigoBloqueioDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoBloqueioDTO->getDthBloqueio())) {
      $objCodigoBloqueioDTO->setDthBloqueio(null);
    } else {
      if (!InfraData::validarDataHora($objCodigoBloqueioDTO->getDthBloqueio())) {
        $objInfraException->adicionarValidacao('Data/Hora de Bloqueio inv�lida.');
      }
    }
  }

  private function validarStrSinAtivo(CodigoBloqueioDTO $objCodigoBloqueioDTO, InfraException $objInfraException) {
    if (InfraString::isBolVazia($objCodigoBloqueioDTO->getStrSinAtivo())) {
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    } else {
      if (!InfraUtil::isBolSinalizadorValido($objCodigoBloqueioDTO->getStrSinAtivo())) {
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_cadastrar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrIdCodigoAcesso($objCodigoBloqueioDTO, $objInfraException);
      $this->validarStrChaveBloqueio($objCodigoBloqueioDTO, $objInfraException);
      $this->validarDthEnvio($objCodigoBloqueioDTO, $objInfraException);
      $this->validarDthBloqueio($objCodigoBloqueioDTO, $objInfraException);
      $this->validarStrSinAtivo($objCodigoBloqueioDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $ret = $objCodigoBloqueioBD->cadastrar($objCodigoBloqueioDTO);

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro cadastrando C�digo de Bloqueio.', $e);
    }
  }

  protected function alterarControlado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_alterar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objCodigoBloqueioDTO->isSetStrIdCodigoAcesso()) {
        $this->validarStrIdCodigoAcesso($objCodigoBloqueioDTO, $objInfraException);
      }
      if ($objCodigoBloqueioDTO->isSetStrChaveBloqueio()) {
        $this->validarStrChaveBloqueio($objCodigoBloqueioDTO, $objInfraException);
      }
      if ($objCodigoBloqueioDTO->isSetDthEnvio()) {
        $this->validarDthEnvio($objCodigoBloqueioDTO, $objInfraException);
      }
      if ($objCodigoBloqueioDTO->isSetDthBloqueio()) {
        $this->validarDthBloqueio($objCodigoBloqueioDTO, $objInfraException);
      }
      if ($objCodigoBloqueioDTO->isSetStrSinAtivo()) {
        $this->validarStrSinAtivo($objCodigoBloqueioDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $objCodigoBloqueioBD->alterar($objCodigoBloqueioDTO);
    } catch (Exception $e) {
      throw new InfraException('Erro alterando C�digo de Bloqueio.', $e);
    }
  }

  protected function excluirControlado($arrObjCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_excluir', __METHOD__, $arrObjCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoBloqueioDTO); $i++) {
        $objCodigoBloqueioBD->excluir($arrObjCodigoBloqueioDTO[$i]);
      }
    } catch (Exception $e) {
      throw new InfraException('Erro excluindo C�digo de Bloqueio.', $e);
    }
  }

  protected function consultarConectado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_consultar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $ret = $objCodigoBloqueioBD->consultar($objCodigoBloqueioDTO);

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro consultando C�digo de Bloqueio.', $e);
    }
  }

  protected function listarConectado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_listar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $ret = $objCodigoBloqueioBD->listar($objCodigoBloqueioDTO);

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro listando C�digos de Bloqueio.', $e);
    }
  }

  protected function contarConectado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_listar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $ret = $objCodigoBloqueioBD->contar($objCodigoBloqueioDTO);

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro contando C�digos de Bloqueio.', $e);
    }
  }

  protected function desativarControlado($arrObjCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_desativar', __METHOD__, $arrObjCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoBloqueioDTO); $i++) {
        $objCodigoBloqueioBD->desativar($arrObjCodigoBloqueioDTO[$i]);
      }
    } catch (Exception $e) {
      throw new InfraException('Erro desativando C�digo de Bloqueio.', $e);
    }
  }

  protected function reativarControlado($arrObjCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_reativar', __METHOD__, $arrObjCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      for ($i = 0; $i < count($arrObjCodigoBloqueioDTO); $i++) {
        $objCodigoBloqueioBD->reativar($arrObjCodigoBloqueioDTO[$i]);
      }
    } catch (Exception $e) {
      throw new InfraException('Erro reativando C�digo de Bloqueio.', $e);
    }
  }

  protected function bloquearControlado(CodigoBloqueioDTO $objCodigoBloqueioDTO) {
    try {
      //SessaoSip::getInstance()->validarAuditarPermissao('codigo_bloqueio_consultar', __METHOD__, $objCodigoBloqueioDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objCodigoBloqueioBD = new CodigoBloqueioBD($this->getObjInfraIBanco());
      $ret = $objCodigoBloqueioBD->bloquear($objCodigoBloqueioDTO);

      return $ret;
    } catch (Exception $e) {
      throw new InfraException('Erro bloqueando C�digo de Bloqueio.', $e);
    }
  }
}
