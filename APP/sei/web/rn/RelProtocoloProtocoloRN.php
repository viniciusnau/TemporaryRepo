<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 30/07/2008 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.21.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelProtocoloProtocoloRN extends InfraRN {
	
	public static $TA_DOCUMENTO_ASSOCIADO = '1';
	public static $TA_PROCEDIMENTO_ANEXADO = '2';
	public static $TA_PROCEDIMENTO_RELACIONADO = '3';
	public static $TA_PROCEDIMENTO_SOBRESTADO = '4';
	public static $TA_PROCEDIMENTO_DESANEXADO = '5';
	public static $TA_DOCUMENTO_MOVIDO = '6';
  public static $TA_DOCUMENTO_CIRCULAR = '7';

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  protected function cadastrarRN0839Controlado(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_cadastrar',__METHOD__,$objRelProtocoloProtocoloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarDblIdProtocolo1RN0844($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarDblIdProtocolo2RN0845($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarNumIdUsuarioRN0846($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarNumIdUnidadeRN0870($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarStrStaAssociacaoRN0847($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarNumSequencia($objRelProtocoloProtocoloDTO, $objInfraException);
      $this->validarDthAssociacaoRN0865($objRelProtocoloProtocoloDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objRelProtocoloProtocoloDTO->setStrSinCiencia('N');
      
      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      $ret = $objRelProtocoloProtocoloBD->cadastrar($objRelProtocoloProtocoloDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Associa��o de Protocolo.',$e);
    }
  }

  protected function alterarControlado(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_alterar',__METHOD__,$objRelProtocoloProtocoloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objRelProtocoloProtocoloDTO->isSetDblIdProtocolo1()){
        $this->validarDblIdProtocolo1RN0844($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetDblIdProtocolo2()){
        $this->validarDblIdProtocolo2RN0845($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuarioRN0846($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidadeRN0870($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetStrStaAssociacao()){
        $this->validarStrStaAssociacaoRN0847($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetStrSinCiencia()){
        $this->validarStrSinCiencia($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetNumSequencia()){
        $this->validarNumSequencia($objRelProtocoloProtocoloDTO, $objInfraException);
      }
      if ($objRelProtocoloProtocoloDTO->isSetDthAssociacao()){
        $this->validarDthAssociacaoRN0865($objRelProtocoloProtocoloDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      $objRelProtocoloProtocoloBD->alterar($objRelProtocoloProtocoloDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Associa��o de Protocolo.',$e);
    }
  }

  protected function excluirRN0842Controlado($arrObjRelProtocoloProtocoloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_excluir',__METHOD__,$arrObjRelProtocoloProtocoloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objComentarioRN = new ComentarioRN();

      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjRelProtocoloProtocoloDTO);$i++){

        $objComentarioDTO = new ComentarioDTO();
        $objComentarioDTO->retNumIdComentario();
        $objComentarioDTO->setDblIdRelProtocoloProtocolo($arrObjRelProtocoloProtocoloDTO[$i]->getDblIdRelProtocoloProtocolo());
        $objComentarioRN->excluir($objComentarioRN->listar($objComentarioDTO));

        $objRelProtocoloProtocoloBD->excluir($arrObjRelProtocoloProtocoloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Associa��o de Protocolo.',$e);
    }
  }

  protected function consultarRN0841Conectado(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_consultar',__METHOD__,$objRelProtocoloProtocoloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      $ret = $objRelProtocoloProtocoloBD->consultar($objRelProtocoloProtocoloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Associa��o de Protocolo.',$e);
    }
  }

  protected function listarRN0187Conectado(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_listar',__METHOD__,$objRelProtocoloProtocoloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      $ret = $objRelProtocoloProtocoloBD->listar($objRelProtocoloProtocoloDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Associa��es de Protocolos.',$e);
    }
  }

  protected function contarRN0843Conectado(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('rel_protocolo_protocolo_listar',__METHOD__,$objRelProtocoloProtocoloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objRelProtocoloProtocoloBD = new RelProtocoloProtocoloBD($this->getObjInfraIBanco());
      $ret = $objRelProtocoloProtocoloBD->contar($objRelProtocoloProtocoloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Associa��es de Protocolos.',$e);
    }
  }

  private function validarDblIdProtocolo1RN0844(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getDblIdProtocolo1())){
      $objInfraException->adicionarValidacao('Primeiro protocolo da associa��o entre protocolos n�o informado.');
    }
  }

  private function validarDblIdProtocolo2RN0845(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getDblIdProtocolo2())){
      $objInfraException->adicionarValidacao('Segundo protocolo da associa��o entre protocolos n�o informado.');
    }
  }

  private function validarNumIdUsuarioRN0846(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio da associa��o entre protocolos n�o informado.');
    }
  }

  private function validarNumIdUnidadeRN0870(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade da associa��o entre protocolos n�o informada.');
    }
  }

  private function validarNumSequencia(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getNumSequencia())){
      $objInfraException->adicionarValidacao('Sequ�ncia da associa��o entre protocolos n�o informada.');
    }
  }
  
  private function validarStrStaAssociacaoRN0847(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){  	  	
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getStrStaAssociacao())){
      $objInfraException->adicionarValidacao('Tipo de associa��o entre protocolos n�o informada.');
    }else{
		 	$arr = $this->tiposAssociacaoProtocoloRN0869();
			if (!in_array($objRelProtocoloProtocoloDTO->getStrStaAssociacao(),InfraArray::converterArrInfraDTO($arr,'StaTipo'))){
				$objInfraException->adicionarValidacao('Tipo de associa��o entre protocolos inv�lida.');
			}
    }
  }

  private function validarStrSinCiencia(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getStrSinCiencia())){
      $objInfraException->adicionarValidacao('Sinalizador de Ci�ncia n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objRelProtocoloProtocoloDTO->getStrSinCiencia())){
        $objInfraException->adicionarValidacao('Sinalizador de Ci�ncia inv�lido.');
      }
    }
  }
  
  private function validarDthAssociacaoRN0865(RelProtocoloProtocoloDTO $objRelProtocoloProtocoloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objRelProtocoloProtocoloDTO->getDthAssociacao())){
      $objInfraException->adicionarValidacao('Data de associa��o de protocolos n�o informada.');
    }else{
      if (!InfraData::validarDataHora($objRelProtocoloProtocoloDTO->getDthAssociacao())){
        $objInfraException->adicionarValidacao('Data de associa��o de protocolos inv�lida.');
      }
    }
  }

  public function tiposAssociacaoProtocoloRN0869(){
  	$arr = array();

  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO);
  	$objTipo->setStrDescricao('Documento Associado');
  	$arr[] = $objTipo;
  	
  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);
  	$objTipo->setStrDescricao('Processo Anexado');
  	$arr[] = $objTipo;
  	
  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_RELACIONADO);
  	$objTipo->setStrDescricao('Processo Relacionado');
  	$arr[] = $objTipo;

  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_SOBRESTADO);
  	$objTipo->setStrDescricao('Processo Sobrestado');
  	$arr[] = $objTipo;

  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_DESANEXADO);
  	$objTipo->setStrDescricao('Processo Desanexado');
  	$arr[] = $objTipo;

  	$objTipo = new TipoDTO();
  	$objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_DOCUMENTO_MOVIDO);
  	$objTipo->setStrDescricao('Documento Movido');
  	$arr[] = $objTipo;

    $objTipo = new TipoDTO();
    $objTipo->setStrStaTipo(RelProtocoloProtocoloRN::$TA_DOCUMENTO_CIRCULAR);
    $objTipo->setStrDescricao('Documento Circular');
    $arr[] = $objTipo;

  	return $arr;  	
  }

}
?>