<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 12/12/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class SeriePublicacaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdSerie(SeriePublicacaoDTO $objSeriePublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSeriePublicacaoDTO->getNumIdSerie())){
      $objInfraException->adicionarValidacao('Id S�rie n�o informado.');
    }
  }

  private function validarNumIdOrgao(SeriePublicacaoDTO $objSeriePublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSeriePublicacaoDTO->getNumIdOrgao())){
      $objInfraException->adicionarValidacao('Id �rg�o n�o informado.');
    }
  }

  protected function cadastrarControlado(SeriePublicacaoDTO $objSeriePublicacaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_cadastrar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdSerie($objSeriePublicacaoDTO, $objInfraException);
      $this->validarNumIdOrgao($objSeriePublicacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objSeriePublicacaoBD->cadastrar($objSeriePublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando S�rie Publica��o.',$e);
    }
  }

  protected function alterarControlado(SeriePublicacaoDTO $objSeriePublicacaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_alterar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objSeriePublicacaoDTO->isSetNumIdSerie()){
        $this->validarNumIdSerie($objSeriePublicacaoDTO, $objInfraException);
      }
      if ($objSeriePublicacaoDTO->isSetNumIdOrgao()){
        $this->validarNumIdOrgao($objSeriePublicacaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $objSeriePublicacaoBD->alterar($objSeriePublicacaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando S�rie Publica��o.',$e);
    }
  }

  protected function excluirControlado($arrObjSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_excluir',__METHOD__,$arrObjSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSeriePublicacaoDTO);$i++){
        $objSeriePublicacaoBD->excluir($arrObjSeriePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo S�rie Publica��o.',$e);
    }
  }

  protected function consultarConectado(SeriePublicacaoDTO $objSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_consultar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objSeriePublicacaoBD->consultar($objSeriePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando S�rie Publica��o.',$e);
    }
  }

  protected function listarConectado(SeriePublicacaoDTO $objSeriePublicacaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_listar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objSeriePublicacaoBD->listar($objSeriePublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando S�ries Publica��o.',$e);
    }
  }

  protected function contarConectado(SeriePublicacaoDTO $objSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_listar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objSeriePublicacaoBD->contar($objSeriePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando S�ries Publica��o.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_desativar',__METHOD__,$arrObjSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSeriePublicacaoDTO);$i++){
        $objSeriePublicacaoBD->desativar($arrObjSeriePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando S�rie Publica��o.',$e);
    }
  }

  protected function reativarControlado($arrObjSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_reativar',__METHOD__,$arrObjSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSeriePublicacaoDTO);$i++){
        $objSeriePublicacaoBD->reativar($arrObjSeriePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando S�rie Publica��o.',$e);
    }
  }

  protected function bloquearControlado(SeriePublicacaoDTO $objSeriePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_publicacao_consultar',__METHOD__,$objSeriePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSeriePublicacaoBD = new SeriePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objSeriePublicacaoBD->bloquear($objSeriePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando S�rie Publica��o.',$e);
    }
  }

 */
}
?>