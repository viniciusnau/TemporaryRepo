<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/07/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelSerieVeiculoPublicacaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdSerie(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelSerieVeiculoPublicacaoDTO->getNumIdSerie())){
      $objInfraException->adicionarValidacao('Tipo do documento n�o informado.');
    }
  }

  private function validarNumIdVeiculoPublicacao(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelSerieVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao())){
      $objInfraException->adicionarValidacao('Ve�culo de Publica��o n�o informado.');
    }
  }

  protected function cadastrarControlado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_cadastrar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdSerie($objRelSerieVeiculoPublicacaoDTO, $objInfraException);
      $this->validarNumIdVeiculoPublicacao($objRelSerieVeiculoPublicacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieVeiculoPublicacaoBD->cadastrar($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro associando Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function alterarControlado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_alterar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelSerieVeiculoPublicacaoDTO->isSetNumIdSerie()){
        $this->validarNumIdSerie($objRelSerieVeiculoPublicacaoDTO, $objInfraException);
      }
      if ($objRelSerieVeiculoPublicacaoDTO->isSetNumIdVeiculoPublicacao()){
        $this->validarNumIdVeiculoPublicacao($objRelSerieVeiculoPublicacaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $objRelSerieVeiculoPublicacaoBD->alterar($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function excluirControlado($arrObjRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_excluir',__METHOD__,$arrObjRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieVeiculoPublicacaoDTO);$i++){
        $objRelSerieVeiculoPublicacaoBD->excluir($arrObjRelSerieVeiculoPublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function consultarConectado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_consultar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieVeiculoPublicacaoBD->consultar($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function listarConectado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_listar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieVeiculoPublicacaoBD->listar($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando associa��es de Tipos de Documento com Ve�culos de Publica��o.',$e);
    }
  }

  protected function contarConectado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_listar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieVeiculoPublicacaoBD->contar($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando associa��es de Tipos de Documento com Ve�culos de Publica��o.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_desativar',__METHOD__,$arrObjRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieVeiculoPublicacaoDTO);$i++){
        $objRelSerieVeiculoPublicacaoBD->desativar($arrObjRelSerieVeiculoPublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function reativarControlado($arrObjRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_reativar',__METHOD__,$arrObjRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelSerieVeiculoPublicacaoDTO);$i++){
        $objRelSerieVeiculoPublicacaoBD->reativar($arrObjRelSerieVeiculoPublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

  protected function bloquearControlado(RelSerieVeiculoPublicacaoDTO $objRelSerieVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_serie_veiculo_publicacao_consultar',__METHOD__,$objRelSerieVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelSerieVeiculoPublicacaoBD = new RelSerieVeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objRelSerieVeiculoPublicacaoBD->bloquear($objRelSerieVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando associa��o de Tipo de Documento com Ve�culo de Publica��o.',$e);
    }
  }

 */
}
?>