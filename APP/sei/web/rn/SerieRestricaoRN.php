<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 29/07/2016 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.38.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class SerieRestricaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdSerie(SerieRestricaoDTO $objSerieRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieRestricaoDTO->getNumIdSerie())){
      $objInfraException->adicionarValidacao('Tipo de Documento n�o informado.');
    }
  }

  private function validarNumIdOrgao(SerieRestricaoDTO $objSerieRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieRestricaoDTO->getNumIdOrgao())){
      $objInfraException->adicionarValidacao('�rg�o n�o informado.');
    }
  }

  private function validarNumIdUnidade(SerieRestricaoDTO $objSerieRestricaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieRestricaoDTO->getNumIdUnidade())){
      $objSerieRestricaoDTO->setNumIdUnidade(null);
    }
  }

  protected function cadastrarControlado(SerieRestricaoDTO $objSerieRestricaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_cadastrar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdSerie($objSerieRestricaoDTO, $objInfraException);
      $this->validarNumIdOrgao($objSerieRestricaoDTO, $objInfraException);
      $this->validarNumIdUnidade($objSerieRestricaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $ret = $objSerieRestricaoBD->cadastrar($objSerieRestricaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function alterarControlado(SerieRestricaoDTO $objSerieRestricaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_alterar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objSerieRestricaoDTO->isSetNumIdSerie()){
        $this->validarNumIdSerie($objSerieRestricaoDTO, $objInfraException);
      }
      if ($objSerieRestricaoDTO->isSetNumIdOrgao()){
        $this->validarNumIdOrgao($objSerieRestricaoDTO, $objInfraException);
      }
      if ($objSerieRestricaoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objSerieRestricaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $objSerieRestricaoBD->alterar($objSerieRestricaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function excluirControlado($arrObjSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_excluir',__METHOD__,$arrObjSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<InfraArray::contar($arrObjSerieRestricaoDTO);$i++){
        $objSerieRestricaoBD->excluir($arrObjSerieRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function consultarConectado(SerieRestricaoDTO $objSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_consultar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $ret = $objSerieRestricaoBD->consultar($objSerieRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function listarConectado(SerieRestricaoDTO $objSerieRestricaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_listar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $ret = $objSerieRestricaoBD->listar($objSerieRestricaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Restri��es em Tipos de Documentos.',$e);
    }
  }

  protected function contarConectado(SerieRestricaoDTO $objSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_listar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $ret = $objSerieRestricaoBD->contar($objSerieRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Restri��es em Tipos de Documentos.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_desativar',__METHOD__,$arrObjSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSerieRestricaoDTO);$i++){
        $objSerieRestricaoBD->desativar($arrObjSerieRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function reativarControlado($arrObjSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_reativar',__METHOD__,$arrObjSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSerieRestricaoDTO);$i++){
        $objSerieRestricaoBD->reativar($arrObjSerieRestricaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Restri��o em Tipo de Documento.',$e);
    }
  }

  protected function bloquearControlado(SerieRestricaoDTO $objSerieRestricaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_restricao_consultar',__METHOD__,$objSerieRestricaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieRestricaoBD = new SerieRestricaoBD($this->getObjInfraIBanco());
      $ret = $objSerieRestricaoBD->bloquear($objSerieRestricaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Restri��o em Tipo de Documento.',$e);
    }
  }

 */
}
?>