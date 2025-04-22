<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 23/11/2011 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id: SecaoModeloRN.php 10184 2015-07-30 14:20:49Z mga $
*/

require_once dirname(__FILE__).'/../../SEI.php';

class SecaoModeloRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdModelo(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getNumIdModelo())){
      $objInfraException->adicionarValidacao('Modelo n�o informado.');
    }
  }

  private function validarEmUso(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){

    $objSecaoModeloDTOBanco = new SecaoModeloDTO();
    $objSecaoModeloDTOBanco->retStrNome();
    $objSecaoModeloDTOBanco->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo());
    $objSecaoModeloDTOBanco->setBolExclusaoLogica(false);
    $objSecaoModeloDTOBanco = $this->consultar($objSecaoModeloDTOBanco);

    $objSecaoDocumentoDTO = new SecaoDocumentoDTO();
    $objSecaoDocumentoDTO->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo());

    $objSecaoDocumentoRN = new SecaoDocumentoRN();
    if ($objSecaoDocumentoRN->contar($objSecaoDocumentoDTO)){
        $objInfraException->lancarValidacao('Existem documentos utilizando a se��o "'.$objSecaoModeloDTOBanco->getStrNome().'".');
    }
  }

  private function validarStrNome(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objSecaoModeloDTO->setStrNome(trim($objSecaoModeloDTO->getStrNome()));

      if (strlen($objSecaoModeloDTO->getStrNome())>50){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a 50 caracteres.');
      }
    }
    $objSecaoModeloDTOBanco=new SecaoModeloDTO();
    $objSecaoModeloDTOBanco->setStrNome($objSecaoModeloDTO->getStrNome());
    $objSecaoModeloDTOBanco->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
    if ($objSecaoModeloDTO->isSetNumIdSecaoModelo()){
      $objSecaoModeloDTOBanco->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
    }
    if ($this->contar($objSecaoModeloDTOBanco)>0){
      $objInfraException->adicionarValidacao('Nome da se��o j� est� em uso neste modelo.');
    }
    
    
    
  }

  private function validarStrConteudo(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrConteudo())){
      $objSecaoModeloDTO->setStrConteudo(null);
    }

    $strConteudo = $objSecaoModeloDTO->getStrConteudo();

    try {
      SeiINT::validarXss($strConteudo);
    }catch(Exception $e){
      if (strpos($e->__toString(), SeiINT::$MSG_ERRO_XSS) !== false) {
        $objInfraException->adicionarValidacao('Se��o possui conte�do n�o permitido.');
      }else{
        throw $e;
      }
    }
  }

  private function validarNumOrdem(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getNumOrdem())){
      $objInfraException->adicionarValidacao('Ordem n�o informada.');
      return;
    }
    /*
    $objSecaoModeloDTO2 = new SecaoModeloDTO();
    $objSecaoModeloDTO2->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
    $objSecaoModeloDTO2->setNumOrdem($objSecaoModeloDTO->getNumOrdem());
    $objSecaoModeloDTO2->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
    if ($this->contar($objSecaoModeloDTO2)>0) {
    	$objInfraException->adicionarValidacao('Ordem duplicada.');
    }
    */
  }

  private function validarStrSinAssinatura(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinAssinatura())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o de assinatura n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinAssinatura())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o de assinatura inv�lido.');
      }
      if ($objSecaoModeloDTO->getStrSinAssinatura()=='S') {
        $objSecaoModeloDTO2 = new SecaoModeloDTO();
        $objSecaoModeloDTO2->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
        $objSecaoModeloDTO2->setStrSinAssinatura('S');
        $objSecaoModeloDTO2->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
        if ($this->contar($objSecaoModeloDTO2)>0) {
    	    $objInfraException->adicionarValidacao('J� existe se��o de assinatura neste modelo.');
        }
      }
    }
  }

  private function validarStrSinPrincipal(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinPrincipal())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o principal n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinPrincipal())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o principal inv�lido.');
      }
      if ($objSecaoModeloDTO->getStrSinPrincipal()=='S') {
        $objSecaoModeloDTO2 = new SecaoModeloDTO();
        $objSecaoModeloDTO2->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
        $objSecaoModeloDTO2->setStrSinPrincipal('S');
        $objSecaoModeloDTO2->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
        if ($this->contar($objSecaoModeloDTO2)>0) {
    	    $objInfraException->adicionarValidacao('J� existe se��o principal configurada neste modelo.');
        }
      }
    }
  }

  private function validarStrSinDinamica(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinDinamica())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o din�mica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinDinamica())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o din�mica inv�lido.');
      }
      if ($objSecaoModeloDTO->getStrSinDinamica()=='S'){
        $objSecaoModeloDTO->setStrSinSomenteLeitura('S');
      }
    }
  }

  private function validarStrSinHtml(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinHtml())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o com conte�do inicial em HTML n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinHtml())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o com conte�do inicial em HTML inv�lido.');
      }
    }
  }

  private function validarStrSinCabecalho(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinCabecalho())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o de cabe�alho n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinCabecalho())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o de cabe�alho inv�lido.');
      }

      if ($objSecaoModeloDTO->getStrSinCabecalho()=='S') {
        $objSecaoModeloDTO2 = new SecaoModeloDTO();
        $objSecaoModeloDTO2->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
        $objSecaoModeloDTO2->setStrSinCabecalho('S');
        $objSecaoModeloDTO2->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
        if ($this->contar($objSecaoModeloDTO2)>0) {
    	    $objInfraException->adicionarValidacao('J� existe uma se��o de cabe�alho configurada neste modelo.');
        }
      }
    }
  }

  private function validarStrSinRodape(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinRodape())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o de rodap� n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinRodape())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o de rodap� inv�lido.');
      }
      if ($objSecaoModeloDTO->getStrSinRodape()=='S') {
        $objSecaoModeloDTO2 = new SecaoModeloDTO();
        $objSecaoModeloDTO2->setNumIdModelo($objSecaoModeloDTO->getNumIdModelo());
        $objSecaoModeloDTO2->setStrSinRodape('S');
        $objSecaoModeloDTO2->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo(),InfraDTO::$OPER_DIFERENTE);
        if ($this->contar($objSecaoModeloDTO2)>0) {
    	    $objInfraException->adicionarValidacao('J� existe uma se��o de rodap� configurada neste modelo.');
        }
      }
    }
  }

  private function validarStrSinSomenteLeitura(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinSomenteLeitura())){
      $objInfraException->adicionarValidacao('Sinalizador de se��o somente leitura n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinSomenteLeitura())){
        $objInfraException->adicionarValidacao('Sinalizador de se��o somente leitura inv�lido.');
      }
    }
  }

  private function validarStrSinAtivo(SecaoModeloDTO $objSecaoModeloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSecaoModeloDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSecaoModeloDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }
  
  protected function cadastrarControlado(SecaoModeloDTO $objSecaoModeloDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_cadastrar',__METHOD__,$objSecaoModeloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      //nao deixa adicionar se��o em modelo em uso
      //$this->validarEmUso($objSecaoModeloDTO, $objInfraException);

      $this->validarNumIdModelo($objSecaoModeloDTO, $objInfraException);
      $this->validarStrNome($objSecaoModeloDTO, $objInfraException);
      $this->validarStrConteudo($objSecaoModeloDTO, $objInfraException);
      $this->validarNumOrdem($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinCabecalho($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinRodape($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinSomenteLeitura($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinAssinatura($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinPrincipal($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinDinamica($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinHtml($objSecaoModeloDTO, $objInfraException);
      $this->validarStrSinAtivo($objSecaoModeloDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $ret = $objSecaoModeloBD->cadastrar($objSecaoModeloDTO);
      $objRelSecaoModeloEstiloRN = new RelSecaoModeloEstiloRN();

      if ($objSecaoModeloDTO->isSetArrObjRelSecaoModeloEstiloDTO()){
        foreach ($objSecaoModeloDTO->getArrObjRelSecaoModeloEstiloDTO() as $objRelSecaoModeloEstiloDTO){
        	$objRelSecaoModeloEstiloDTO->setNumIdSecaoModelo($ret->getNumIdSecaoModelo());
        	$objRelSecaoModeloEstiloRN->cadastrar($objRelSecaoModeloEstiloDTO);
        }
      }

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Se��o.',$e);
    }
  }

  protected function alterarControlado(SecaoModeloDTO $objSecaoModeloDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_alterar',__METHOD__,$objSecaoModeloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();


      $objSecaoModeloDTOBanco = new SecaoModeloDTO();
      $objSecaoModeloDTOBanco->retNumIdModelo();
      $objSecaoModeloDTOBanco->retStrNomeModelo();
      $objSecaoModeloDTOBanco->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo());

      $objSecaoModeloDTOBanco = $this->consultar($objSecaoModeloDTOBanco);


      if ($objSecaoModeloDTO->isSetNumIdModelo()){
        $this->validarNumIdModelo($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrNome()){
        $this->validarStrNome($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrConteudo()){
        $this->validarStrConteudo($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetNumOrdem()){
        $this->validarNumOrdem($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinCabecalho()){
        $this->validarStrSinCabecalho($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinRodape()){
        $this->validarStrSinRodape($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinSomenteLeitura()){
        $this->validarStrSinSomenteLeitura($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinAssinatura()){
        $this->validarStrSinAssinatura($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinPrincipal()){
        $this->validarStrSinPrincipal($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinDinamica()){
        $this->validarStrSinDinamica($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinHtml()){
        $this->validarStrSinHtml($objSecaoModeloDTO, $objInfraException);
      }
      if ($objSecaoModeloDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objSecaoModeloDTO, $objInfraException);
      }

      /*
      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->setStrStaDocumento(DocumentoRN::$TD_EDITOR_INTERNO);
      $objDocumentoDTO->setNumIdModeloSerie($objSecaoModeloDTOBanco->getNumIdModelo());

      $objDocumentoRN = new DocumentoRN();
      if($objDocumentoRN->contarRN0007($objDocumentoDTO)){
      	$objInfraException->adicionarValidacao('Existem documentos utilizando o modelo interno "'.$objSecaoModeloDTOBanco->getStrNomeModelo().'".');
      }
      */

      $objInfraException->lancarValidacoes();

      if ($objSecaoModeloDTO->isSetArrObjRelSecaoModeloEstiloDTO()){

      	$objRelSecaoModeloEstiloDTO = new RelSecaoModeloEstiloDTO();
      	$objRelSecaoModeloEstiloDTO->retNumIdSecaoModelo();
      	$objRelSecaoModeloEstiloDTO->retNumIdEstilo();
      	$objRelSecaoModeloEstiloDTO->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo());

      	$objRelSecaoModeloEstiloRN = new RelSecaoModeloEstiloRN();
      	$objRelSecaoModeloEstiloRN->excluir($objRelSecaoModeloEstiloRN->listar($objRelSecaoModeloEstiloDTO));

      	foreach ($objSecaoModeloDTO->getArrObjRelSecaoModeloEstiloDTO() as $objRelSecaoModeloEstiloDTO)	{
      		$objRelSecaoModeloEstiloDTO->setNumIdSecaoModelo($objSecaoModeloDTO->getNumIdSecaoModelo());
      		$objRelSecaoModeloEstiloRN->cadastrar($objRelSecaoModeloEstiloDTO);
      	}
      }


      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $objSecaoModeloBD->alterar($objSecaoModeloDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Se��o.',$e);
    }
  }

  protected function excluirControlado($arrObjSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_excluir',__METHOD__,$arrObjSecaoModeloDTO);


      //Regras de Negocio
      $objInfraException = new InfraException();
      for($i=0;$i<count($arrObjSecaoModeloDTO);$i++){
        $this->validarEmUso($arrObjSecaoModeloDTO[$i], $objInfraException);
      }
      $objInfraException->lancarValidacoes();


      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $objRelSecaoModeloEstiloRN = new RelSecaoModeloEstiloRN();
      $objRelSecaoModCjEstilosItemRN= new RelSecaoModCjEstilosItemRN();

      for($i=0;$i<count($arrObjSecaoModeloDTO);$i++){
        $objRelSecaoModeloEstiloDTO = new RelSecaoModeloEstiloDTO();
      	$objRelSecaoModeloEstiloDTO->retNumIdSecaoModelo();
      	$objRelSecaoModeloEstiloDTO->retNumIdEstilo();
      	$objRelSecaoModeloEstiloDTO->setNumIdSecaoModelo($arrObjSecaoModeloDTO[$i]->getNumIdSecaoModelo());
      	$objRelSecaoModeloEstiloRN->excluir($objRelSecaoModeloEstiloRN->listar($objRelSecaoModeloEstiloDTO));

      	$objRelSecaoModCjEstilosItemDTO = new RelSecaoModCjEstilosItemDTO();
      	$objRelSecaoModCjEstilosItemDTO->retNumIdSecaoModelo();
      	$objRelSecaoModCjEstilosItemDTO->retNumIdConjuntoEstilosItem();
      	$objRelSecaoModCjEstilosItemDTO->setNumIdSecaoModelo($arrObjSecaoModeloDTO[$i]->getNumIdSecaoModelo());
      	$objRelSecaoModCjEstilosItemRN->excluir($objRelSecaoModCjEstilosItemRN->listar($objRelSecaoModCjEstilosItemDTO));

        $objSecaoModeloBD->excluir($arrObjSecaoModeloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Se��o.',$e);
    }
  }

  protected function consultarConectado(SecaoModeloDTO $objSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_consultar',__METHOD__,$objSecaoModeloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $ret = $objSecaoModeloBD->consultar($objSecaoModeloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Se��o.',$e);
    }
  }

  protected function listarConectado(SecaoModeloDTO $objSecaoModeloDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_listar',__METHOD__,$objSecaoModeloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $ret = $objSecaoModeloBD->listar($objSecaoModeloDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Se��es.',$e);
    }
  }

  protected function contarConectado(SecaoModeloDTO $objSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_listar',__METHOD__,$objSecaoModeloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $ret = $objSecaoModeloBD->contar($objSecaoModeloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Se��es.',$e);
    }
  }

  protected function desativarControlado($arrObjSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjSecaoModeloDTO);$i++){
        $objSecaoModeloBD->desativar($arrObjSecaoModeloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Se��o.',$e);
    }
  }

  protected function reativarControlado($arrObjSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_reativar');

      //Regras de Negocio
      $objInfraException = new InfraException();

      for($i=0;$i<count($arrObjSecaoModeloDTO);$i++){

        $objSecaoModeloDTO=new SecaoModeloDTO();
        $objSecaoModeloDTO->setNumIdSecaoModelo($arrObjSecaoModeloDTO[$i]->getNumIdSecaoModelo());
        $objSecaoModeloDTO->retNumIdSecaoModelo();
        $objSecaoModeloDTO->retNumIdModelo();
        $objSecaoModeloDTO->retStrNome();
        $objSecaoModeloDTO->setBolExclusaoLogica(false);
        $objSecaoModeloDTO=$this->consultar($objSecaoModeloDTO);
        $this->validarStrNome($objSecaoModeloDTO,$objInfraException);
        $objInfraException->lancarValidacoes();
      }

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());

      for($i=0;$i<count($arrObjSecaoModeloDTO);$i++){

        $objSecaoModeloBD->reativar($arrObjSecaoModeloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Se��o.',$e);
    }
  }

  protected function bloquearControlado(SecaoModeloDTO $objSecaoModeloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('secao_modelo_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSecaoModeloBD = new SecaoModeloBD($this->getObjInfraIBanco());
      $ret = $objSecaoModeloBD->bloquear($objSecaoModeloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Se��o.',$e);
    }
  }


}
?>