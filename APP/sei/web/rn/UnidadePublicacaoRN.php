<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/12/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class UnidadePublicacaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdUnidade(UnidadePublicacaoDTO $objUnidadePublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadePublicacaoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Id Unidade n�o informado.');
    }
  }

  protected function cadastrarControlado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_cadastrar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUnidade($objUnidadePublicacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objUnidadePublicacaoBD->cadastrar($objUnidadePublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Unidade Publica��o.',$e);
    }
  }

  protected function alterarControlado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_alterar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objUnidadePublicacaoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objUnidadePublicacaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $objUnidadePublicacaoBD->alterar($objUnidadePublicacaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Unidade Publica��o.',$e);
    }
  }

  protected function excluirControlado($arrObjUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_excluir',__METHOD__,$arrObjUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUnidadePublicacaoDTO);$i++){
        $objUnidadePublicacaoBD->excluir($arrObjUnidadePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Unidade Publica��o.',$e);
    }
  }

  protected function consultarConectado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_consultar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objUnidadePublicacaoBD->consultar($objUnidadePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Unidade Publica��o.',$e);
    }
  }

  protected function listarConectado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_listar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objUnidadePublicacaoBD->listar($objUnidadePublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Unidades Publica��o.',$e);
    }
  }

  protected function contarConectado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_listar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objUnidadePublicacaoBD->contar($objUnidadePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Unidades Publica��o.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_desativar',__METHOD__,$arrObjUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUnidadePublicacaoDTO);$i++){
        $objUnidadePublicacaoBD->desativar($arrObjUnidadePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Unidade Publica��o.',$e);
    }
  }

  protected function reativarControlado($arrObjUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_reativar',__METHOD__,$arrObjUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUnidadePublicacaoDTO);$i++){
        $objUnidadePublicacaoBD->reativar($arrObjUnidadePublicacaoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Unidade Publica��o.',$e);
    }
  }

  protected function bloquearControlado(UnidadePublicacaoDTO $objUnidadePublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_publicacao_consultar',__METHOD__,$objUnidadePublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadePublicacaoBD = new UnidadePublicacaoBD($this->getObjInfraIBanco());
      $ret = $objUnidadePublicacaoBD->bloquear($objUnidadePublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Unidade Publica��o.',$e);
    }
  }

 */
}
?>