<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 26/08/2014 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class LembreteRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdUsuario(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrConteudo(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getStrConteudo())){
      $objInfraException->adicionarValidacao('Conte�do n�o informado.');
    }else{
      $objLembreteDTO->setStrConteudo(trim($objLembreteDTO->getStrConteudo()));

      if (strlen($objLembreteDTO->getStrConteudo())>50000){
        $objInfraException->adicionarValidacao('Conte�do possui tamanho superior a 50.000 caracteres.');
      }

      $strConteudoXss = $objLembreteDTO->getStrConteudo();

      $objInfraXSS = new InfraXSS();
      if ($objInfraXSS->verificacaoAvancada($strConteudoXss)){
        throw new InfraException('Lembrete possui conte�do n�o permitido.', null, $objInfraXSS->getStrDiferenca());
      }
    }
  }

  private function validarNumPosicaoX(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getNumPosicaoX())){
      $objInfraException->adicionarValidacao('Posi��o X n�o informada.');
    }
  }

  private function validarNumPosicaoY(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getNumPosicaoY())){
      $objInfraException->adicionarValidacao('Posi��o Y n�o informada.');
    }
  }

  private function validarNumLargura(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getNumLargura())){
      $objInfraException->adicionarValidacao('Largura n�o informada.');
    }
  }

  private function validarNumAltura(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getNumAltura())){
      $objInfraException->adicionarValidacao('Altura n�o informada.');
    }
  }

  private function validarStrCor(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getStrCor())){
      $objInfraException->adicionarValidacao('Cor n�o informada.');
    }else{
      $objLembreteDTO->setStrCor(trim($objLembreteDTO->getStrCor()));

      if (strlen($objLembreteDTO->getStrCor())>7){
        $objInfraException->adicionarValidacao('Cor possui tamanho superior a 7 caracteres.');
      }
    }
  }

  private function validarStrCorTexto(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getStrCorTexto())){
      $objInfraException->adicionarValidacao('Cor do texto n�o informada.');
    }else{
      $objLembreteDTO->setStrCorTexto(trim($objLembreteDTO->getStrCorTexto()));

      if (strlen($objLembreteDTO->getStrCorTexto())>7){
        $objInfraException->adicionarValidacao('Cor do texto possui tamanho superior a 7 caracteres.');
      }
    }
  }

  private function validarStrSinAtivo(LembreteDTO $objLembreteDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objLembreteDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objLembreteDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(LembreteDTO $objLembreteDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_cadastrar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUsuario($objLembreteDTO, $objInfraException);
      $this->validarStrConteudo($objLembreteDTO, $objInfraException);
      $this->validarNumPosicaoX($objLembreteDTO, $objInfraException);
      $this->validarNumPosicaoY($objLembreteDTO, $objInfraException);
      $this->validarNumLargura($objLembreteDTO, $objInfraException);
      $this->validarNumAltura($objLembreteDTO, $objInfraException);
      $this->validarStrCor($objLembreteDTO, $objInfraException);
      $this->validarStrCorTexto($objLembreteDTO, $objInfraException);
      $this->validarStrSinAtivo($objLembreteDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objLembreteDTO->setDthLembrete(InfraData::getStrDataHoraAtual());

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $ret = $objLembreteBD->cadastrar($objLembreteDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Lembrete.',$e);
    }
  }

  protected function alterarControlado(LembreteDTO $objLembreteDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_alterar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objLembreteDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuario($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetStrConteudo()){
        $this->validarStrConteudo($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetNumPosicaoX()){
        $this->validarNumPosicaoX($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetNumPosicaoY()){
        $this->validarNumPosicaoY($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetNumLargura()){
        $this->validarNumLargura($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetNumAltura()){
        $this->validarNumAltura($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetStrCor()){
        $this->validarStrCor($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetStrCorTexto()){
        $this->validarStrCorTexto($objLembreteDTO, $objInfraException);
      }
      if ($objLembreteDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objLembreteDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $objLembreteBD->alterar($objLembreteDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Lembrete.',$e);
    }
  }

  protected function excluirControlado($arrObjLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_excluir',__METHOD__,$arrObjLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjLembreteDTO);$i++){
        $objLembreteBD->excluir($arrObjLembreteDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Lembrete.',$e);
    }
  }

  protected function consultarConectado(LembreteDTO $objLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_consultar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $ret = $objLembreteBD->consultar($objLembreteDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Lembrete.',$e);
    }
  }

  protected function listarConectado(LembreteDTO $objLembreteDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_listar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $ret = $objLembreteBD->listar($objLembreteDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Lembretes.',$e);
    }
  }

  protected function contarConectado(LembreteDTO $objLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_listar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $ret = $objLembreteBD->contar($objLembreteDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Lembretes.',$e);
    }
  }

  protected function desativarControlado($arrObjLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_desativar',__METHOD__,$arrObjLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjLembreteDTO);$i++){
        $objLembreteBD->desativar($arrObjLembreteDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Lembrete.',$e);
    }
  }

  protected function reativarControlado($arrObjLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_reativar',__METHOD__,$arrObjLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjLembreteDTO);$i++){
        $objLembreteBD->reativar($arrObjLembreteDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Lembrete.',$e);
    }
  }

  protected function bloquearControlado(LembreteDTO $objLembreteDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('lembrete_consultar',__METHOD__,$objLembreteDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objLembreteBD = new LembreteBD($this->getObjInfraIBanco());
      $ret = $objLembreteBD->bloquear($objLembreteDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Lembrete.',$e);
    }
  }


}
?>