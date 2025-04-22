<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 09/10/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class HipoteseLegalRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrNome(HipoteseLegalDTO $objHipoteseLegalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objHipoteseLegalDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objHipoteseLegalDTO->setStrNome(trim($objHipoteseLegalDTO->getStrNome()));

      if (strlen($objHipoteseLegalDTO->getStrNome())>50){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a 50 caracteres.');
      }
      
      $dto = new HipoteseLegalDTO();
      $dto->setBolExclusaoLogica(false);
      $dto->retStrSinAtivo();
      $dto->setStrNome($objHipoteseLegalDTO->getStrNome());
      $dto->setNumIdHipoteseLegal($objHipoteseLegalDTO->getNumIdHipoteseLegal(),InfraDTO::$OPER_DIFERENTE);
      $dto = $this->consultar($dto);
      if ($dto!=null){
        if ($dto->getStrSinAtivo()=='S'){
          $objInfraException->adicionarValidacao('Existe outra Hip�tese Legal cadastrada com o mesmo nome.');
        }else{
          $objInfraException->adicionarValidacao('Existe outra Hip�tese Legal inativa cadastrada com o mesmo nome.');
        }
      }
    }
  }

  private function validarStrBaseLegal(HipoteseLegalDTO $objHipoteseLegalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objHipoteseLegalDTO->getStrBaseLegal())){
      $objInfraException->adicionarValidacao('Base Legal n�o informada.');
    }else{
      $objHipoteseLegalDTO->setStrBaseLegal(trim($objHipoteseLegalDTO->getStrBaseLegal()));

      if (strlen($objHipoteseLegalDTO->getStrBaseLegal())>50){
        $objInfraException->adicionarValidacao('Base Legal possui tamanho superior a 50 caracteres.');
      }
    }
  }

  private function validarStrDescricao(HipoteseLegalDTO $objHipoteseLegalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objHipoteseLegalDTO->getStrDescricao())){
      $objHipoteseLegalDTO->setStrDescricao(null);
    }else{
      $objHipoteseLegalDTO->setStrDescricao(trim($objHipoteseLegalDTO->getStrDescricao()));

      if (strlen($objHipoteseLegalDTO->getStrDescricao())>500){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 500 caracteres.');
      }
    }
  }
  
  public function validarStrStaNivelAcesso(HipoteseLegalDTO $objHipoteseLegalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objHipoteseLegalDTO->getStrStaNivelAcesso())){
      $objInfraException->adicionarValidacao('N�vel de acesso n�o informado.');
    }else{
      if ($objHipoteseLegalDTO->getStrStaNivelAcesso()!=ProtocoloRN::$NA_RESTRITO && $objHipoteseLegalDTO->getStrStaNivelAcesso()!=ProtocoloRN::$NA_SIGILOSO){
        $objInfraException->adicionarValidacao('N�vel de acesso inv�lido.');
      }
    }
  }

  private function validarStrSinAtivo(HipoteseLegalDTO $objHipoteseLegalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objHipoteseLegalDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objHipoteseLegalDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(HipoteseLegalDTO $objHipoteseLegalDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_cadastrar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNome($objHipoteseLegalDTO, $objInfraException);
      $this->validarStrBaseLegal($objHipoteseLegalDTO, $objInfraException);
      $this->validarStrDescricao($objHipoteseLegalDTO, $objInfraException);
      $this->validarStrStaNivelAcesso($objHipoteseLegalDTO, $objInfraException);
      $this->validarStrSinAtivo($objHipoteseLegalDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $ret = $objHipoteseLegalBD->cadastrar($objHipoteseLegalDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Hip�tese Legal.',$e);
    }
  }

  protected function alterarControlado(HipoteseLegalDTO $objHipoteseLegalDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_alterar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objHipoteseLegalDTO->isSetStrNome()){
        $this->validarStrNome($objHipoteseLegalDTO, $objInfraException);
      }
      if ($objHipoteseLegalDTO->isSetStrBaseLegal()){
        $this->validarStrBaseLegal($objHipoteseLegalDTO, $objInfraException);
      }
      if ($objHipoteseLegalDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objHipoteseLegalDTO, $objInfraException);
      }
      if ($objHipoteseLegalDTO->isSetStrStaNivelAcesso()){
        $this->validarStrSinAtivo($objHipoteseLegalDTO, $objInfraException);
      }
      if ($objHipoteseLegalDTO->isSetStrStaNivelAcesso()){
        $this->validarStrSinAtivo($objHipoteseLegalDTO, $objInfraException);
      }
      
      if ($objHipoteseLegalDTO->isSetStrStaNivelAcesso() || $objHipoteseLegalDTO->isSetStrNome() || $objHipoteseLegalDTO->isSetStrBaseLegal()){
        
        $objHipoteseLegalDTOBanco = new HipoteseLegalDTO();
        $objHipoteseLegalDTOBanco->retStrNome();
        $objHipoteseLegalDTOBanco->retStrBaseLegal();
        $objHipoteseLegalDTOBanco->retStrStaNivelAcesso();
        $objHipoteseLegalDTOBanco->setNumIdHipoteseLegal($objHipoteseLegalDTO->getNumIdHipoteseLegal());        
        $objHipoteseLegalDTOBanco = $this->consultar($objHipoteseLegalDTOBanco);
        
        if ($objHipoteseLegalDTOBanco->getStrStaNivelAcesso()!=$objHipoteseLegalDTO->getStrStaNivelAcesso() ||
            $objHipoteseLegalDTOBanco->getStrNome()!=$objHipoteseLegalDTO->getStrNome() || 
            $objHipoteseLegalDTOBanco->getStrBaseLegal()!=$objHipoteseLegalDTO->getStrBaseLegal()){
          
          $objProtocoloDTO = new ProtocoloDTO();
          $objProtocoloDTO->setNumIdHipoteseLegal($objHipoteseLegalDTO->getNumIdHipoteseLegal());
          
          $objProtocoloRN = new ProtocoloRN();
          $numProtocolos = $objProtocoloRN->contarRN0667($objProtocoloDTO);
          if ($numProtocolos==1){
            $objInfraException->adicionarValidacao('Apenas a descri��o pode ser alterada porque existe um protocolo utilizando esta Hip�tese Legal.');
          }else if ($numProtocolos > 0){
            $objInfraException->adicionarValidacao('Apenas a descri��o pode ser alterada porque existem '.$numProtocolos.' protocolos utilizando esta Hip�tese Legal.');
          }
        }
      }

      $objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $objHipoteseLegalBD->alterar($objHipoteseLegalDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Hip�tese Legal.',$e);
    }
  }

  protected function excluirControlado($arrObjHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_excluir',__METHOD__,$arrObjHipoteseLegalDTO);

      if (count($arrObjHipoteseLegalDTO)){

        //Regras de Negocio
        $objInfraException = new InfraException();
        
        $objHipoteseLegalDTO = new HipoteseLegalDTO();
        $objHipoteseLegalDTO->setBolExclusaoLogica(false);
        $objHipoteseLegalDTO->retNumIdHipoteseLegal();
        $objHipoteseLegalDTO->retStrNome();
        $objHipoteseLegalDTO->setNumIdHipoteseLegal(InfraArray::converterArrInfraDTO($arrObjHipoteseLegalDTO,'IdHipoteseLegal'),InfraDTO::$OPER_IN);
        $arrObjHipoteseLegalDTOBanco = InfraArray::indexarArrInfraDTO($this->listar($objHipoteseLegalDTO),'IdHipoteseLegal');
        
        $objProtocoloRN = new ProtocoloRN();
        $objTipoProcedimentoRN = new TipoProcedimentoRN();
        
        for($i=0;$i<count($arrObjHipoteseLegalDTO);$i++){
          $objProtocoloDTO = new ProtocoloDTO();
          $objProtocoloDTO->retStrProtocoloFormatado();
          $objProtocoloDTO->setNumIdHipoteseLegal($arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal());
          $numProtocolos = $objProtocoloRN->contarRN0667($objProtocoloDTO);
  
          if ($numProtocolos){
            if ($numProtocolos==1){
              $objInfraException->adicionarValidacao('Existe um protocolo associado com a hip�tese legal "'.$arrObjHipoteseLegalDTOBanco[$arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal()]->getStrNome().'".');
            }else{
              $objInfraException->adicionarValidacao('Existem '.$numProtocolos.' protocolos associados com a hip�tese legal "'.$arrObjHipoteseLegalDTOBanco[$arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal()]->getStrNome().'".');
            }
          }
          
          $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
          $objTipoProcedimentoDTO->retStrNome();
          $objTipoProcedimentoDTO->setNumIdHipoteseLegalSugestao($arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal());
          $arrObjTipoProcedimentoDTO = $objTipoProcedimentoRN->listarRN0244($objTipoProcedimentoDTO);
          
          $numTipoProcedimento = count($arrObjTipoProcedimentoDTO);
          if ($numTipoProcedimento){
            if ($numTipoProcedimento==1){
              $objInfraException->adicionarValidacao('O tipo de processo "'.$arrObjTipoProcedimentoDTO[0]->getStrNome().'" est� sugerindo a hip�tese legal "'.$arrObjHipoteseLegalDTOBanco[$arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal()]->getStrNome().'".');
            }else{
              $objInfraException->adicionarValidacao('Os '.$numTipoProcedimento.' tipos de processo abaixo est�o sugerindo a hip�tese legal "'.$arrObjHipoteseLegalDTOBanco[$arrObjHipoteseLegalDTO[$i]->getNumIdHipoteseLegal()]->getStrNome().'":\n'.implode('\n',InfraArray::converterArrInfraDTO($arrObjTipoProcedimentoDTO,'Nome')));
            }
          }
          
        }
        
        $objInfraException->lancarValidacoes();
  
        $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
        for($i=0;$i<count($arrObjHipoteseLegalDTO);$i++){
          $objHipoteseLegalBD->excluir($arrObjHipoteseLegalDTO[$i]);
        }
      }
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Hip�tese Legal.',$e);
    }
  }

  protected function consultarConectado(HipoteseLegalDTO $objHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_consultar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $ret = $objHipoteseLegalBD->consultar($objHipoteseLegalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Hip�tese Legal.',$e);
    }
  }

  protected function listarConectado(HipoteseLegalDTO $objHipoteseLegalDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_listar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $ret = $objHipoteseLegalBD->listar($objHipoteseLegalDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Hip�teses Legais.',$e);
    }
  }

  protected function contarConectado(HipoteseLegalDTO $objHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_listar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $ret = $objHipoteseLegalBD->contar($objHipoteseLegalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Hip�teses Legais.',$e);
    }
  }

  protected function desativarControlado($arrObjHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_desativar',__METHOD__,$arrObjHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjHipoteseLegalDTO);$i++){
        $objHipoteseLegalBD->desativar($arrObjHipoteseLegalDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Hip�tese Legal.',$e);
    }
  }

  protected function reativarControlado($arrObjHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_reativar',__METHOD__,$arrObjHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjHipoteseLegalDTO);$i++){
        $objHipoteseLegalBD->reativar($arrObjHipoteseLegalDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Hip�tese Legal.',$e);
    }
  }

  protected function bloquearControlado(HipoteseLegalDTO $objHipoteseLegalDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('hipotese_legal_consultar',__METHOD__,$objHipoteseLegalDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objHipoteseLegalBD = new HipoteseLegalBD($this->getObjInfraIBanco());
      $ret = $objHipoteseLegalBD->bloquear($objHipoteseLegalDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Hip�tese Legal.',$e);
    }
  }


}
?>