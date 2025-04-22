<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 06/07/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class UnidadeHistoricoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }


  private function validarNumIdUnidade(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarNumIdOrgao(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getNumIdOrgao())){
      $objInfraException->adicionarValidacao('�rg�o n�o informado.');
    }
  }

  private function validarStrSigla(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getStrSigla())){
      $objInfraException->adicionarValidacao('Sigla n�o informada.');
    }else{
      $objUnidadeHistoricoDTO->setStrSigla(trim($objUnidadeHistoricoDTO->getStrSigla()));

      if (strlen($objUnidadeHistoricoDTO->getStrSigla())>30){
        $objInfraException->adicionarValidacao('Sigla possui tamanho superior a 30 caracteres.');
      }
    }
  }

  private function validarStrDescricao(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getStrDescricao())){
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    }else{
      $objUnidadeHistoricoDTO->setStrDescricao(trim($objUnidadeHistoricoDTO->getStrDescricao()));

      if (strlen($objUnidadeHistoricoDTO->getStrDescricao())>250){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarDtaInicio(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getDtaInicio())){
      $objInfraException->adicionarValidacao('Data Inicial n�o informada.');
    }else{
      if (!InfraData::validarData($objUnidadeHistoricoDTO->getDtaInicio())){
        $objInfraException->adicionarValidacao('Data Inicial inv�lida.');
      }
    }
  }

  private function validarDtaFim(UnidadeHistoricoDTO $objUnidadeHistoricoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objUnidadeHistoricoDTO->getDtaFim())){
      if($objUnidadeHistoricoDTO->isSetBolOrigemSIP() && $objUnidadeHistoricoDTO->getBolOrigemSIP()){
        $objUnidadeHistoricoDTO->setDtaFim(null);
      }else{
        $objInfraException->adicionarValidacao('Data Final n�o informada.');
      }
    }else if (!InfraString::isBolVazia($objUnidadeHistoricoDTO->getDtaInicio()) && InfraData::compararDatasSimples($objUnidadeHistoricoDTO->getDtaInicio(), $objUnidadeHistoricoDTO->getDtaFim()) == -1){
      $objInfraException->adicionarValidacao('Data Final deve ser anterior � Data Inicial.');
    }else if (InfraData::compararDatasSimples($objUnidadeHistoricoDTO->getDtaFim(), InfraData::getStrDataAtual()) <= 0){
      $objInfraException->adicionarValidacao('Data Final deve ser anterior � hoje.');
    }else{
      if (!InfraData::validarData($objUnidadeHistoricoDTO->getDtaFim())){
        $objInfraException->adicionarValidacao('Data Final inv�lida.');
      }
    }
  }


  protected function cadastrarControlado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_cadastrar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUnidade($objUnidadeHistoricoDTO, $objInfraException);
      $this->validarNumIdOrgao($objUnidadeHistoricoDTO, $objInfraException);
      $this->validarStrSigla($objUnidadeHistoricoDTO, $objInfraException);
      $this->validarStrDescricao($objUnidadeHistoricoDTO, $objInfraException);
      $this->validarDtaInicio($objUnidadeHistoricoDTO, $objInfraException);
      $this->validarDtaFim($objUnidadeHistoricoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objHistoricoRN = new HistoricoRN();
      $ret = $objHistoricoRN->tratarHistoricoInclusao($objUnidadeHistoricoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Hist�rico da Unidade.',$e);
    }
  }

  protected function alterarControlado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_alterar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objUnidadeHistoricoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objUnidadeHistoricoDTO, $objInfraException);
      }
      if ($objUnidadeHistoricoDTO->isSetNumIdOrgao()){
        $this->validarNumIdOrgao($objUnidadeHistoricoDTO, $objInfraException);
      }
      if ($objUnidadeHistoricoDTO->isSetStrSigla()){
        $this->validarStrSigla($objUnidadeHistoricoDTO, $objInfraException);
      }
      if ($objUnidadeHistoricoDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objUnidadeHistoricoDTO, $objInfraException);
      }
      if ($objUnidadeHistoricoDTO->isSetDtaInicio()){
        $this->validarDtaInicio($objUnidadeHistoricoDTO, $objInfraException);
      }
      if ($objUnidadeHistoricoDTO->isSetDtaFim()){
        $this->validarDtaFim($objUnidadeHistoricoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objHistoricoRN = new HistoricoRN();
      $objHistoricoRN->tratarHistoricoAlteracao($objUnidadeHistoricoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Hist�rico da Unidade.',$e);
    }
  }

  protected function excluirControlado($arrObjUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_excluir',__METHOD__,$arrObjUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      $objHistoricoRN = new HistoricoRN();
      for($i=0;$i<count($arrObjUnidadeHistoricoDTO);$i++){
        $objHistoricoRN->tratarHistoricoExclusao($arrObjUnidadeHistoricoDTO[$i]);
        $objUnidadeHistoricoBD->excluir($arrObjUnidadeHistoricoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Hist�rico da Unidade.',$e);
    }
  }

  protected function consultarConectado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_consultar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUnidadeHistoricoBD->consultar($objUnidadeHistoricoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Hist�rico da Unidade.',$e);
    }
  }

  protected function listarConectado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_listar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUnidadeHistoricoBD->listar($objUnidadeHistoricoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Hist�ricos das Unidades.',$e);
    }
  }

  protected function contarConectado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_listar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUnidadeHistoricoBD->contar($objUnidadeHistoricoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Hist�ricos das Unidades.',$e);
    }
  }
/*
  protected function desativarControlado($arrObjUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_desativar',__METHOD__,$arrObjUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUnidadeHistoricoDTO);$i++){
        $objUnidadeHistoricoBD->desativar($arrObjUnidadeHistoricoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Hist�rico da Unidade.',$e);
    }
  }

  protected function reativarControlado($arrObjUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_reativar',__METHOD__,$arrObjUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjUnidadeHistoricoDTO);$i++){
        $objUnidadeHistoricoBD->reativar($arrObjUnidadeHistoricoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Hist�rico da Unidade.',$e);
    }
  }

  protected function bloquearControlado(UnidadeHistoricoDTO $objUnidadeHistoricoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('unidade_historico_consultar',__METHOD__,$objUnidadeHistoricoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objUnidadeHistoricoBD = new UnidadeHistoricoBD($this->getObjInfraIBanco());
      $ret = $objUnidadeHistoricoBD->bloquear($objUnidadeHistoricoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Hist�rico da Unidade.',$e);
    }
  }

 */
}
