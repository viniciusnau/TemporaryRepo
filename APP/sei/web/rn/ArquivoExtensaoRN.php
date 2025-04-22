<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 08/02/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ArquivoExtensaoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrExtensao(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getStrExtensao())){
      $objInfraException->adicionarValidacao('Extens�o n�o informada.');
    }else{
      $objArquivoExtensaoDTO->setStrExtensao(trim($objArquivoExtensaoDTO->getStrExtensao()));

      if(substr($objArquivoExtensaoDTO->getStrExtensao(),0,1)=='.') {
      	$objInfraException->adicionarValidacao('N�o cadastrar o ponto inicial da Extens�o.');
      }
      if (strlen($objArquivoExtensaoDTO->getStrExtensao())>10){
        $objInfraException->adicionarValidacao('Extens�o possui tamanho superior a 10 caracteres.');
      }
      
      $dto = new ArquivoExtensaoDTO();
      $dto->retStrSinAtivo();
      $dto->setNumIdArquivoExtensao($objArquivoExtensaoDTO->getNumIdArquivoExtensao(),InfraDTO::$OPER_DIFERENTE);
      $dto->setStrExtensao($objArquivoExtensaoDTO->getStrExtensao(),InfraDTO::$OPER_IGUAL);
      $dto->setBolExclusaoLogica(false);
      
      $dto = $this->consultar($dto);
      if ($dto != NULL){
        if ($dto->getStrSinAtivo() == 'S')
          $objInfraException->adicionarValidacao('Existe outra ocorr�ncia cadastrada com a mesma Extens�o.');
        else
          $objInfraException->adicionarValidacao('Existe ocorr�ncia inativa cadastrada com a mesma Extens�o.');
      }
    }
  }

  private function validarStrDescricao(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getStrDescricao())){
      $objArquivoExtensaoDTO->setStrDescricao(null);
    }else{
      $objArquivoExtensaoDTO->setStrDescricao(trim($objArquivoExtensaoDTO->getStrDescricao()));

      if (strlen($objArquivoExtensaoDTO->getStrDescricao())>250){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }

  private function validarNumTamanhoMaximo(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getNumTamanhoMaximo())){
      $objArquivoExtensaoDTO->setNumTamanhoMaximo(null);
    }else{
      
      $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
      $numTamMbDocExterno = $objInfraParametro->getValor('SEI_TAM_MB_DOC_EXTERNO');

      if (!is_numeric($numTamMbDocExterno) || $numTamMbDocExterno < 1){
        $objInfraException->adicionarValidacao('Valor do par�metro SEI_TAM_MB_DOC_EXTERNO inv�lido.');
      }

      if (!is_numeric($objArquivoExtensaoDTO->getNumTamanhoMaximo()) || ($objArquivoExtensaoDTO->getNumTamanhoMaximo() < 1 || $objArquivoExtensaoDTO->getNumTamanhoMaximo() > $numTamMbDocExterno)){
        $objInfraException->adicionarValidacao('Tamanho m�ximo deve ser um valor entre 1 e '.$numTamMbDocExterno.'.');
      }
    }
  }

  private function validarStrSinInterface(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getStrSinInterface())){
      $objInfraException->adicionarValidacao('Sinalizador de Interface n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objArquivoExtensaoDTO->getStrSinInterface())){
        $objInfraException->adicionarValidacao('Sinalizador de Interface inv�lido.');
      }
    }
  }

  private function validarStrSinServico(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getStrSinServico())){
      $objInfraException->adicionarValidacao('Sinalizador de Servi�o n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objArquivoExtensaoDTO->getStrSinServico())){
        $objInfraException->adicionarValidacao('Sinalizador de Servi�o inv�lido.');
      }
    }
  }

  private function validarStrSinAtivo(ArquivoExtensaoDTO $objArquivoExtensaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objArquivoExtensaoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objArquivoExtensaoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(ArquivoExtensaoDTO $objArquivoExtensaoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_cadastrar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrExtensao($objArquivoExtensaoDTO, $objInfraException);
      $this->validarStrDescricao($objArquivoExtensaoDTO, $objInfraException);
      $this->validarNumTamanhoMaximo($objArquivoExtensaoDTO, $objInfraException);
      $this->validarStrSinInterface($objArquivoExtensaoDTO, $objInfraException);
      $this->validarStrSinServico($objArquivoExtensaoDTO, $objInfraException);
      $this->validarStrSinAtivo($objArquivoExtensaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $ret = $objArquivoExtensaoBD->cadastrar($objArquivoExtensaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Extens�o de Arquivo.',$e);
    }
  }

  protected function alterarControlado(ArquivoExtensaoDTO $objArquivoExtensaoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_alterar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objArquivoExtensaoDTO->isSetStrExtensao()){
        $this->validarStrExtensao($objArquivoExtensaoDTO, $objInfraException);
      }

      if ($objArquivoExtensaoDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objArquivoExtensaoDTO, $objInfraException);
      }

      if ($objArquivoExtensaoDTO->isSetNumTamanhoMaximo()) {
        $this->validarNumTamanhoMaximo($objArquivoExtensaoDTO, $objInfraException);
      }

      if ($objArquivoExtensaoDTO->isSetStrSinInterface()) {
        $this->validarStrSinInterface($objArquivoExtensaoDTO, $objInfraException);
      }

      if ($objArquivoExtensaoDTO->isSetStrSinServico()) {
        $this->validarStrSinServico($objArquivoExtensaoDTO, $objInfraException);
      }

      if ($objArquivoExtensaoDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objArquivoExtensaoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $objArquivoExtensaoBD->alterar($objArquivoExtensaoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Extens�o de Arquivo.',$e);
    }
  }

  protected function excluirControlado($arrObjArquivoExtensaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_excluir',__METHOD__,$arrObjArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdArquivoExtensao = InfraArray::converterArrInfraDTO($arrObjArquivoExtensaoDTO, 'IdArquivoExtensao');

      if (InfraArray::contar($arrIdArquivoExtensao)) {

        $objArquivoExtensaoDTO = new ArquivoExtensaoDTO();
        $objArquivoExtensaoDTO->setBolExclusaoLogica(false);
        $objArquivoExtensaoDTO->retNumIdArquivoExtensao();
        $objArquivoExtensaoDTO->retStrExtensao();
        $objArquivoExtensaoDTO->setNumIdArquivoExtensao($arrIdArquivoExtensao, InfraDTO::$OPER_IN);

        $arrObjArquivoExtensaoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listar($objArquivoExtensaoDTO), 'IdArquivoExtensao');

        $arrObjArquivoExtensaoAPI = array();
        foreach ($arrObjArquivoExtensaoDTOConsulta as $objArquivoExtensaoDTO) {
          $objArquivoExtensaoAPI = new ArquivoExtensaoAPI();
          $objArquivoExtensaoAPI->setIdArquivoExtensao($objArquivoExtensaoDTO->getNumIdArquivoExtensao());
          $objArquivoExtensaoAPI->setExtensao($objArquivoExtensaoDTO->getStrExtensao());
          $arrObjArquivoExtensaoAPI[] = $objArquivoExtensaoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('excluirArquivoExtensao', $arrObjArquivoExtensaoAPI);
        }

        $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
        for ($i = 0; $i < count($arrObjArquivoExtensaoDTO); $i++) {
          $objArquivoExtensaoBD->excluir($arrObjArquivoExtensaoDTO[$i]);
        }
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Extens�o de Arquivo.',$e);
    }
  }

  protected function consultarConectado(ArquivoExtensaoDTO $objArquivoExtensaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_consultar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $ret = $objArquivoExtensaoBD->consultar($objArquivoExtensaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Extens�o de Arquivo.',$e);
    }
  }

  protected function listarConectado(ArquivoExtensaoDTO $objArquivoExtensaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_listar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $ret = $objArquivoExtensaoBD->listar($objArquivoExtensaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Extens�es de Arquivos.',$e);
    }
  }

  protected function contarConectado(ArquivoExtensaoDTO $objArquivoExtensaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_listar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $ret = $objArquivoExtensaoBD->contar($objArquivoExtensaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Extens�es de Arquivos.',$e);
    }
  }

  protected function desativarControlado($arrObjArquivoExtensaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_desativar',__METHOD__,$arrObjArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdArquivoExtensao = InfraArray::converterArrInfraDTO($arrObjArquivoExtensaoDTO, 'IdArquivoExtensao');

      if (InfraArray::contar($arrIdArquivoExtensao)) {

        $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
        for ($i = 0; $i < count($arrObjArquivoExtensaoDTO); $i++) {
          $objArquivoExtensaoBD->desativar($arrObjArquivoExtensaoDTO[$i]);
        }

        $objArquivoExtensaoDTO = new ArquivoExtensaoDTO();
        $objArquivoExtensaoDTO->setBolExclusaoLogica(false);
        $objArquivoExtensaoDTO->retNumIdArquivoExtensao();
        $objArquivoExtensaoDTO->retStrExtensao();
        $objArquivoExtensaoDTO->setNumIdArquivoExtensao($arrIdArquivoExtensao, InfraDTO::$OPER_IN);

        $arrObjArquivoExtensaoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listar($objArquivoExtensaoDTO), 'IdArquivoExtensao');

        $arrObjArquivoExtensaoAPI = array();
        foreach ($arrObjArquivoExtensaoDTOConsulta as $objArquivoExtensaoDTO) {
          $objArquivoExtensaoAPI = new ArquivoExtensaoAPI();
          $objArquivoExtensaoAPI->setIdArquivoExtensao($objArquivoExtensaoDTO->getNumIdArquivoExtensao());
          $objArquivoExtensaoAPI->setExtensao($objArquivoExtensaoDTO->getStrExtensao());
          $arrObjArquivoExtensaoAPI[] = $objArquivoExtensaoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('desativarArquivoExtensao', $arrObjArquivoExtensaoAPI);
        }
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Extens�o de Arquivo.',$e);
    }
  }

  protected function reativarControlado($arrObjArquivoExtensaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_reativar',__METHOD__,$arrObjArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdArquivoExtensao = InfraArray::converterArrInfraDTO($arrObjArquivoExtensaoDTO, 'IdArquivoExtensao');

      if (InfraArray::contar($arrIdArquivoExtensao)) {

        $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
        for ($i = 0; $i < count($arrObjArquivoExtensaoDTO); $i++) {
          $objArquivoExtensaoBD->reativar($arrObjArquivoExtensaoDTO[$i]);
        }

        $objArquivoExtensaoDTO = new ArquivoExtensaoDTO();
        $objArquivoExtensaoDTO->setBolExclusaoLogica(false);
        $objArquivoExtensaoDTO->retNumIdArquivoExtensao();
        $objArquivoExtensaoDTO->retStrExtensao();
        $objArquivoExtensaoDTO->setNumIdArquivoExtensao($arrIdArquivoExtensao, InfraDTO::$OPER_IN);

        $arrObjArquivoExtensaoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listar($objArquivoExtensaoDTO), 'IdArquivoExtensao');

        $arrObjArquivoExtensaoAPI = array();
        foreach ($arrObjArquivoExtensaoDTOConsulta as $objArquivoExtensaoDTO) {
          $objArquivoExtensaoAPI = new ArquivoExtensaoAPI();
          $objArquivoExtensaoAPI->setIdArquivoExtensao($objArquivoExtensaoDTO->getNumIdArquivoExtensao());
          $objArquivoExtensaoAPI->setExtensao($objArquivoExtensaoDTO->getStrExtensao());
          $arrObjArquivoExtensaoAPI[] = $objArquivoExtensaoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('reativarArquivoExtensao', $arrObjArquivoExtensaoAPI);
        }

      }
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Extens�o de Arquivo.',$e);
    }
  }

  protected function bloquearControlado(ArquivoExtensaoDTO $objArquivoExtensaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('arquivo_extensao_consultar',__METHOD__,$objArquivoExtensaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objArquivoExtensaoBD = new ArquivoExtensaoBD($this->getObjInfraIBanco());
      $ret = $objArquivoExtensaoBD->bloquear($objArquivoExtensaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Extens�o de Arquivo.',$e);
    }
  }


}
?>