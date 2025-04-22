<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/09/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class VeiculoImprensaNacionalRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrSigla(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoImprensaNacionalDTO->getStrSigla())){
      $objInfraException->adicionarValidacao('Sigla n�o informada.');
    }else{
      $objVeiculoImprensaNacionalDTO->setStrSigla(trim($objVeiculoImprensaNacionalDTO->getStrSigla()));

      if (strlen($objVeiculoImprensaNacionalDTO->getStrSigla())>15){
        $objInfraException->adicionarValidacao('Sigla possui tamanho superior a 15 caracteres.');
      }
      
      $objVeiculoImprensaNacionalDTOBanco = new VeiculoImprensaNacionalDTO();
      $objVeiculoImprensaNacionalDTOBanco->setStrSigla($objVeiculoImprensaNacionalDTO->getStrSigla());
      $objVeiculoImprensaNacionalDTOBanco->setNumIdVeiculoImprensaNacional($objVeiculoImprensaNacionalDTO->getNumIdVeiculoImprensaNacional(),InfraDTO::$OPER_DIFERENTE);
      
      if ($this->contar($objVeiculoImprensaNacionalDTOBanco)){
        $objInfraException->adicionarValidacao('Existe outro Ve�culo da Imprensa Nacional com a mesma sigla.');
      }
    }
  }

  private function validarStrDescricao(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoImprensaNacionalDTO->getStrDescricao())){
      $objInfraException->adicionarValidacao('Descri��o n�o informada.');
    }else{
      $objVeiculoImprensaNacionalDTO->setStrDescricao(trim($objVeiculoImprensaNacionalDTO->getStrDescricao()));

      if (strlen($objVeiculoImprensaNacionalDTO->getStrDescricao())>250){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_cadastrar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrSigla($objVeiculoImprensaNacionalDTO, $objInfraException);
      $this->validarStrDescricao($objVeiculoImprensaNacionalDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $ret = $objVeiculoImprensaNacionalBD->cadastrar($objVeiculoImprensaNacionalDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function alterarControlado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_alterar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objVeiculoImprensaNacionalDTO->isSetStrSigla()){
        $this->validarStrSigla($objVeiculoImprensaNacionalDTO, $objInfraException);
      }
      if ($objVeiculoImprensaNacionalDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objVeiculoImprensaNacionalDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $objVeiculoImprensaNacionalBD->alterar($objVeiculoImprensaNacionalDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function excluirControlado($arrObjVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_excluir',__METHOD__,$arrObjVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //Regras de Negocio
      $objInfraException = new InfraException();
            
      $objPublicacaoRN = new PublicacaoRN();
      $objPublicacaoLegadoRN = new PublicacaoLegadoRN();
      
      for($i=0;$i<count($arrObjVeiculoImprensaNacionalDTO);$i++){
      
        $objPublicacaoDTO = new PublicacaoDTO();
        $objPublicacaoDTO->setNumIdVeiculoIO($arrObjVeiculoImprensaNacionalDTO[$i]->getNumIdVeiculoImprensaNacional());
        if ($objPublicacaoRN->contarRN1046($objPublicacaoDTO)){
      
          $objVeiculoImprensaNacionalDTO = new VeiculoImprensaNacionalDTO();
          $objVeiculoImprensaNacionalDTO->retStrSigla();
          $objVeiculoImprensaNacionalDTO->setNumIdVeiculoImprensaNacional($arrObjVeiculoImprensaNacionalDTO[$i]->getNumIdVeiculoImprensaNacional());
          $objVeiculoImprensaNacionalDTO = $this->consultar($objVeiculoImprensaNacionalDTO);
      
          $objInfraException->adicionarValidacao('Existem publica��es associadas com o ve�culo "'.$objVeiculoImprensaNacionalDTO->getStrSigla().'".');
        }
        
        $objPublicacaoLegadoDTO = new PublicacaoLegadoDTO();
        $objPublicacaoLegadoDTO->setNumIdVeiculoIO($arrObjVeiculoImprensaNacionalDTO[$i]->getNumIdVeiculoImprensaNacional());
        
        if ($objPublicacaoLegadoRN->contar($objPublicacaoLegadoDTO)){
          $objInfraException->adicionarValidacao('Existem publica��es legadas associadas.');
        }
        
      }
      $objInfraException->lancarValidacoes();
      

      $objSecaoImprensaNacionalRN = new SecaoImprensaNacionalRN(); 
      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      
      for($i=0;$i<count($arrObjVeiculoImprensaNacionalDTO);$i++){
        
        $objSecaoImprensaNacionalDTO = new SecaoImprensaNacionalDTO();
        $objSecaoImprensaNacionalDTO->retNumIdSecaoImprensaNacional();
        $objSecaoImprensaNacionalDTO->setNumIdVeiculoImprensaNacional($arrObjVeiculoImprensaNacionalDTO[$i]->getNumIdVeiculoImprensaNacional());
        $objSecaoImprensaNacionalRN->excluir($objSecaoImprensaNacionalRN->listar($objSecaoImprensaNacionalDTO));
        
        $objVeiculoImprensaNacionalBD->excluir($arrObjVeiculoImprensaNacionalDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function consultarConectado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_consultar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $ret = $objVeiculoImprensaNacionalBD->consultar($objVeiculoImprensaNacionalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function listarConectado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_listar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $ret = $objVeiculoImprensaNacionalBD->listar($objVeiculoImprensaNacionalDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Ve�culos da Imprensa Nacional.',$e);
    }
  }

  protected function contarConectado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_listar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $ret = $objVeiculoImprensaNacionalBD->contar($objVeiculoImprensaNacionalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Ve�culos da Imprensa Nacional.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_desativar',__METHOD__,$arrObjVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVeiculoImprensaNacionalDTO);$i++){
        $objVeiculoImprensaNacionalBD->desativar($arrObjVeiculoImprensaNacionalDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function reativarControlado($arrObjVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_reativar',__METHOD__,$arrObjVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVeiculoImprensaNacionalDTO);$i++){
        $objVeiculoImprensaNacionalBD->reativar($arrObjVeiculoImprensaNacionalDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Ve�culo da Imprensa Nacional.',$e);
    }
  }

  protected function bloquearControlado(VeiculoImprensaNacionalDTO $objVeiculoImprensaNacionalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_imprensa_nacional_consultar',__METHOD__,$objVeiculoImprensaNacionalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoImprensaNacionalBD = new VeiculoImprensaNacionalBD($this->getObjInfraIBanco());
      $ret = $objVeiculoImprensaNacionalBD->bloquear($objVeiculoImprensaNacionalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Ve�culo da Imprensa Nacional.',$e);
    }
  }

 */
}
?>