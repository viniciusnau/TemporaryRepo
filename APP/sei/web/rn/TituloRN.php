<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/08/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.41.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class TituloRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrExpressao(TituloDTO $objTituloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTituloDTO->getStrExpressao())){
      $objInfraException->adicionarValidacao('Express�o n�o informada.');
    }else{
      $objTituloDTO->setStrExpressao(trim($objTituloDTO->getStrExpressao()));

      if (strlen($objTituloDTO->getStrExpressao())>100){
        $objInfraException->adicionarValidacao('Express�o possui tamanho superior a 100 caracteres.');
      }
    }
  }

  private function validarStrAbreviatura(TituloDTO $objTituloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTituloDTO->getStrAbreviatura())){
      $objTituloDTO->setStrAbreviatura(null);
    }else{
      $objTituloDTO->setStrAbreviatura(trim($objTituloDTO->getStrAbreviatura()));

      if (strlen($objTituloDTO->getStrAbreviatura())>20){
        $objInfraException->adicionarValidacao('Abreviatura possui tamanho superior a 20 caracteres.');
      }
    }
  }

  private function validarStrExpressaoAbreviatura(TituloDTO $objTituloDTO, InfraException $objInfraException){
    $objTituloBD = new TituloBD($this->getObjInfraIBanco());

    $objTituloDTO_Pesquisa = new TituloDTO();
    $objTituloDTO_Pesquisa->setStrExpressao($objTituloDTO->getStrExpressao());
    if (InfraString::isBolVazia($objTituloDTO->getStrAbreviatura())) {
      $objTituloDTO_Pesquisa->setStrAbreviatura(null);
    }else{
      $objTituloDTO_Pesquisa->setStrAbreviatura($objTituloDTO->getStrAbreviatura());
    }
    if($objTituloBD->contar($objTituloDTO_Pesquisa) > 0){
      $objInfraException->adicionarValidacao('J� existe um T�tulo com a Express�o e a Abreviatura informadas.');
    }

  }

  private function validarStrSinAtivo(TituloDTO $objTituloDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTituloDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTituloDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(TituloDTO $objTituloDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_cadastrar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrExpressao($objTituloDTO, $objInfraException);
      $this->validarStrAbreviatura($objTituloDTO, $objInfraException);
      $this->validarStrExpressaoAbreviatura($objTituloDTO, $objInfraException);
      $this->validarStrSinAtivo($objTituloDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $ret = $objTituloBD->cadastrar($objTituloDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando T�tulo.',$e);
    }
  }

  protected function alterarControlado(TituloDTO $objTituloDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('titulo_alterar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objTituloDTO->isSetStrExpressao()){
        $this->validarStrExpressao($objTituloDTO, $objInfraException);
      }
      if ($objTituloDTO->isSetStrAbreviatura()){
        $this->validarStrAbreviatura($objTituloDTO, $objInfraException);
      }
      if ($objTituloDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objTituloDTO, $objInfraException);
      }
      $this->validarStrExpressaoAbreviatura($objTituloDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $objTituloBD->alterar($objTituloDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando T�tulo.',$e);
    }
  }

  protected function excluirControlado($arrObjTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_excluir',__METHOD__,$arrObjTituloDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objContatoRN = new ContatoRN();
      $objContatoDTO = new ContatoDTO();
      $objContatoDTO->setBolExclusaoLogica(false);
      $objContatoDTO->retNumIdContato();
      $objContatoDTO->setNumMaxRegistrosRetorno(1);

      for ($i=0;$i<count($arrObjTituloDTO);$i++){

        $objContatoDTO->setNumIdTitulo($arrObjTituloDTO[$i]->getNumIdTitulo());

        $objContatoDTO->setStrSinAtivo('S');
        if ($objContatoRN->consultarRN0324($objContatoDTO)!=null){
          $objInfraException->lancarValidacao('Existem contatos utilizando este t�tulo.');
        }

        $objContatoDTO->setStrSinAtivo('N');
        if ($objContatoRN->consultarRN0324($objContatoDTO)!=null){
          $objInfraException->lancarValidacao('Existem contatos inativos utilizando este t�tulo.');
        }

      }

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTituloDTO);$i++){
        $objTituloBD->excluir($arrObjTituloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo T�tulo.',$e);
    }
  }

  protected function consultarConectado(TituloDTO $objTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_consultar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $ret = $objTituloBD->consultar($objTituloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando T�tulo.',$e);
    }
  }

  protected function listarConectado(TituloDTO $objTituloDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_listar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $ret = $objTituloBD->listar($objTituloDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando T�tulos.',$e);
    }
  }

  protected function contarConectado(TituloDTO $objTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_listar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $ret = $objTituloBD->contar($objTituloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando T�tulos.',$e);
    }
  }

  protected function desativarControlado($arrObjTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_desativar',__METHOD__,$arrObjTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTituloDTO);$i++){
        $objTituloBD->desativar($arrObjTituloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando T�tulo.',$e);
    }
  }

  protected function reativarControlado($arrObjTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_reativar',__METHOD__,$arrObjTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTituloDTO);$i++){
        $objTituloBD->reativar($arrObjTituloDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando T�tulo.',$e);
    }
  }

  protected function bloquearControlado(TituloDTO $objTituloDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('titulo_consultar',__METHOD__,$objTituloDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTituloBD = new TituloBD($this->getObjInfraIBanco());
      $ret = $objTituloBD->bloquear($objTituloDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando T�tulo.',$e);
    }
  }


}
