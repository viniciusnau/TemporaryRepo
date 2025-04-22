<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/12/2019 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelGrupoFedOrgaoFedRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdGrupoFederacao(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelGrupoFedOrgaoFedDTO->getNumIdGrupoFederacao())){
      $objInfraException->adicionarValidacao('Grupo do SEI Federa��o n�o informado.');
    }
  }

  private function validarStrIdOrgaoFederacao(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelGrupoFedOrgaoFedDTO->getStrIdOrgaoFederacao())){
      $objInfraException->adicionarValidacao('�rg�o do SEI Federa��o n�o informado.');
    }else{
      $objRelGrupoFedOrgaoFedDTO->setStrIdOrgaoFederacao(trim($objRelGrupoFedOrgaoFedDTO->getStrIdOrgaoFederacao()));

      if (strlen($objRelGrupoFedOrgaoFedDTO->getStrIdOrgaoFederacao())>26){
        $objInfraException->adicionarValidacao('�rg�o do SEI Federa��o possui tamanho superior a 26 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_cadastrar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdGrupoFederacao($objRelGrupoFedOrgaoFedDTO, $objInfraException);
      $this->validarStrIdOrgaoFederacao($objRelGrupoFedOrgaoFedDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $ret = $objRelGrupoFedOrgaoFedBD->cadastrar($objRelGrupoFedOrgaoFedDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function alterarControlado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_alterar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelGrupoFedOrgaoFedDTO->isSetNumIdGrupoFederacao()){
        $this->validarNumIdGrupoFederacao($objRelGrupoFedOrgaoFedDTO, $objInfraException);
      }
      if ($objRelGrupoFedOrgaoFedDTO->isSetStrIdOrgaoFederacao()){
        $this->validarStrIdOrgaoFederacao($objRelGrupoFedOrgaoFedDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $objRelGrupoFedOrgaoFedBD->alterar($objRelGrupoFedOrgaoFedDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function excluirControlado($arrObjRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_excluir', __METHOD__, $arrObjRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelGrupoFedOrgaoFedDTO);$i++){
        $objRelGrupoFedOrgaoFedBD->excluir($arrObjRelGrupoFedOrgaoFedDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function consultarConectado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_consultar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $ret = $objRelGrupoFedOrgaoFedBD->consultar($objRelGrupoFedOrgaoFedDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function listarConectado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_listar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $ret = $objRelGrupoFedOrgaoFedBD->listar($objRelGrupoFedOrgaoFedDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando �rg�os do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function contarConectado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_listar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $ret = $objRelGrupoFedOrgaoFedBD->contar($objRelGrupoFedOrgaoFedDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando �rg�os do Grupo do SEI Federa��o.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_desativar', __METHOD__, $arrObjRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelGrupoFedOrgaoFedDTO);$i++){
        $objRelGrupoFedOrgaoFedBD->desativar($arrObjRelGrupoFedOrgaoFedDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function reativarControlado($arrObjRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_reativar', __METHOD__, $arrObjRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelGrupoFedOrgaoFedDTO);$i++){
        $objRelGrupoFedOrgaoFedBD->reativar($arrObjRelGrupoFedOrgaoFedDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

  protected function bloquearControlado(RelGrupoFedOrgaoFedDTO $objRelGrupoFedOrgaoFedDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('rel_grupo_fed_orgao_fed_consultar', __METHOD__, $objRelGrupoFedOrgaoFedDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelGrupoFedOrgaoFedBD = new RelGrupoFedOrgaoFedBD($this->getObjInfraIBanco());
      $ret = $objRelGrupoFedOrgaoFedBD->bloquear($objRelGrupoFedOrgaoFedDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando �rg�o do Grupo do SEI Federa��o.',$e);
    }
  }

 */
}
