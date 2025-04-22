<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/03/2014 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelSerieAssuntoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdSerie(RelSerieAssuntoDTO $objRelSerieAssuntoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelSerieAssuntoDTO->getNumIdSerie())){
      $objInfraException->adicionarValidacao('Tipo de Documento n�o informado.');
    }
  }

  private function validarNumIdAssunto(RelSerieAssuntoDTO $objRelSerieAssuntoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelSerieAssuntoDTO->getNumIdAssunto())){
      $objInfraException->adicionarValidacao('Assunto n�o informado.');
    }
  }

  private function validarNumSequencia(RelSerieAssuntoDTO $objRelSerieAssuntoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelSerieAssuntoDTO->getNumSequencia())){
      $objInfraException->adicionarValidacao('Sequ�ncia n�o informada.');
    }
  }

  protected function cadastrarControlado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_cadastrar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdSerie($objRelSerieAssuntoDTO, $objInfraException);
      $this->validarNumIdAssunto($objRelSerieAssuntoDTO, $objInfraException);
      $this->validarNumSequencia($objRelSerieAssuntoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objAssuntoProxyDTO = new AssuntoProxyDTO();
      $objAssuntoProxyDTO->retNumIdAssuntoProxy();
      $objAssuntoProxyDTO->setNumIdAssunto($objRelSerieAssuntoDTO->getNumIdAssunto());
      $objAssuntoProxyDTO->setNumMaxRegistrosRetorno(1);
      $objAssuntoProxyDTO->setOrdNumIdAssuntoProxy(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objAssuntoProxyRN = new AssuntoProxyRN();
      $objAssuntoProxyDTO = $objAssuntoProxyRN->consultar($objAssuntoProxyDTO);

      if ($objAssuntoProxyDTO == null){
        throw new InfraException('Assunto n�o consta na tabela de utiliza��o.');
      }


      $objRelSerieAssuntoDTO->setNumIdAssuntoProxy($objAssuntoProxyDTO->getNumIdAssuntoProxy());

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieAssuntoBD->cadastrar($objRelSerieAssuntoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Assunto associado ao Tipo de Documento.',$e);
    }
  }

  /*
  protected function alterarControlado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_alterar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelSerieAssuntoDTO->isSetNumIdSerie()){
        $this->validarNumIdSerie($objRelSerieAssuntoDTO, $objInfraException);
      }
      if ($objRelSerieAssuntoDTO->isSetNumIdAssunto()){
        $this->validarNumIdAssunto($objRelSerieAssuntoDTO, $objInfraException);
      }
      if ($objRelSerieAssuntoDTO->isSetNumSequencia()){
        $this->validarNumSequencia($objRelSerieAssuntoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $objRelSerieAssuntoBD->alterar($objRelSerieAssuntoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Assunto associado ao Tipo de Documento.',$e);
    }
  }
  */

  protected function excluirControlado($arrObjRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_excluir',__METHOD__,$arrObjRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieAssuntoDTO);$i++){
        $objRelSerieAssuntoBD->excluir($arrObjRelSerieAssuntoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Assunto associado ao Tipo de Documento.',$e);
    }
  }

  protected function consultarConectado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_consultar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieAssuntoBD->consultar($objRelSerieAssuntoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Assunto associado ao Tipo de Documento.',$e);
    }
  }

  protected function listarConectado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_listar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieAssuntoBD->listar($objRelSerieAssuntoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Assuntos associados ao Tipo de Documento.',$e);
    }
  }

  protected function contarConectado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_listar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieAssuntoBD->contar($objRelSerieAssuntoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Assuntos associados ao Tipo de Documento.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_desativar',__METHOD__,$arrObjRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieAssuntoDTO);$i++){
        $objRelSerieAssuntoBD->desativar($arrObjRelSerieAssuntoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Assunto associado ao Tipo de Documento.',$e);
    }
  }

  protected function reativarControlado($arrObjRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_reativar',__METHOD__,$arrObjRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieAssuntoDTO);$i++){
        $objRelSerieAssuntoBD->reativar($arrObjRelSerieAssuntoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Assunto associado ao Tipo de Documento.',$e);
    }
  }

  protected function bloquearControlado(RelSerieAssuntoDTO $objRelSerieAssuntoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_assunto_consultar',__METHOD__,$objRelSerieAssuntoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieAssuntoBD = new RelSerieAssuntoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieAssuntoBD->bloquear($objRelSerieAssuntoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Assunto associado ao Tipo de Documento.',$e);
    }
  }

 */
}
?>