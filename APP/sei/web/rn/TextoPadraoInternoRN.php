<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/05/2012 - criado por bcu
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TextoPadraoInternoRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarNumIdUnidade(TextoPadraoInternoDTO $objTextoPadraoInternoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTextoPadraoInternoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarStrNome(TextoPadraoInternoDTO $objTextoPadraoInternoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTextoPadraoInternoDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objTextoPadraoInternoDTO->setStrNome(trim($objTextoPadraoInternoDTO->getStrNome()));

      if (strlen($objTextoPadraoInternoDTO->getStrNome()) > $this->getNumMaxTamanhoNome()){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a '.$this->getNumMaxTamanhoNome().' caracteres.');
      }
    }
  }

  public function getNumMaxTamanhoNome(){
    return 50;
  }

  private function validarStrDescricao(TextoPadraoInternoDTO $objTextoPadraoInternoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTextoPadraoInternoDTO->getStrDescricao())){
      $objTextoPadraoInternoDTO->setStrDescricao(null);
    }else{
      $objTextoPadraoInternoDTO->setStrDescricao(trim($objTextoPadraoInternoDTO->getStrDescricao()));

      if (strlen($objTextoPadraoInternoDTO->getStrDescricao())>300){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 300 caracteres.');
      }
    }
  }

  private function validarStrConteudo(TextoPadraoInternoDTO $objTextoPadraoInternoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTextoPadraoInternoDTO->getStrConteudo())){
      $objInfraException->adicionarValidacao('Conte�do n�o informado.');
    }else{
      $objTextoPadraoInternoDTO->setStrConteudo(trim($objTextoPadraoInternoDTO->getStrConteudo()));

      $objImagemFormatoDTO = new ImagemFormatoDTO();
      $objImagemFormatoDTO->retStrFormato();
      $objImagemFormatoDTO->setBolExclusaoLogica(false);

      $objImagemFormatoRN = new ImagemFormatoRN();
      $arrImagemPermitida = InfraArray::converterArrInfraDTO($objImagemFormatoRN->listar($objImagemFormatoDTO), 'Formato');
      if (in_array('jpg', $arrImagemPermitida) && !in_array('jpeg', $arrImagemPermitida)) $arrImagemPermitida[] = 'jpeg';

      $objEditorRN=new EditorRN();
      $objEditorRN->validarTagsCriticas($arrImagemPermitida, $objTextoPadraoInternoDTO->getStrConteudo());

      $strConteudo = $objTextoPadraoInternoDTO->getStrConteudo();

      try {
        SeiINT::validarXss($strConteudo);
      }catch(Exception $e){
        if (strpos($e->__toString(), SeiINT::$MSG_ERRO_XSS) !== false) {
          $objInfraException->adicionarValidacao('Texto Padr�o possui conte�do n�o permitido.');
        }else{
          throw $e;
        }
      }
    }
  }

  protected function cadastrarControlado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_cadastrar',__METHOD__,$objTextoPadraoInternoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdUnidade($objTextoPadraoInternoDTO, $objInfraException);
      $this->validarStrNome($objTextoPadraoInternoDTO, $objInfraException);
      $this->validarStrDescricao($objTextoPadraoInternoDTO, $objInfraException);
      $this->validarStrConteudo($objTextoPadraoInternoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $ret = $objTextoPadraoInternoBD->cadastrar($objTextoPadraoInternoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Texto Padr�o.',$e);
    }
  }

  protected function alterarControlado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_alterar',__METHOD__,$objTextoPadraoInternoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objTextoPadraoInternoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidade($objTextoPadraoInternoDTO, $objInfraException);
      }
      if ($objTextoPadraoInternoDTO->isSetStrNome()){
        $this->validarStrNome($objTextoPadraoInternoDTO, $objInfraException);
      }
      if ($objTextoPadraoInternoDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objTextoPadraoInternoDTO, $objInfraException);
      }
      if ($objTextoPadraoInternoDTO->isSetStrConteudo()){
        $this->validarStrConteudo($objTextoPadraoInternoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $objTextoPadraoInternoBD->alterar($objTextoPadraoInternoDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Texto Padr�o.',$e);
    }
  }

  protected function excluirControlado($arrObjTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_excluir',__METHOD__,$arrObjTextoPadraoInternoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTextoPadraoInternoDTO);$i++){
        $objTextoPadraoInternoBD->excluir($arrObjTextoPadraoInternoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Texto Padr�o.',$e);
    }
  }

  protected function consultarConectado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_consultar',__METHOD__,$objTextoPadraoInternoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $ret = $objTextoPadraoInternoBD->consultar($objTextoPadraoInternoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Texto Padr�o.',$e);
    }
  }

  protected function listarConectado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_listar',__METHOD__,$objTextoPadraoInternoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $ret = $objTextoPadraoInternoBD->listar($objTextoPadraoInternoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Textos Padr�es.',$e);
    }
  }

  protected function contarConectado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_listar',__METHOD__,$objTextoPadraoInternoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $ret = $objTextoPadraoInternoBD->contar($objTextoPadraoInternoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Textos Padr�es.',$e);
    }
  }
  
  protected function obterAutoTextosConectado(){
    
    $objTextoPadraoInternoDTO= new TextoPadraoInternoDTO();
    $objTextoPadraoInternoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
    $objTextoPadraoInternoDTO->retStrNome();
    $objTextoPadraoInternoDTO->retStrDescricao();
    $objTextoPadraoInternoDTO->retStrConteudo();
    $objTextoPadraoInternoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);
    
    $arrObjTextoPadraoInternoDTO=$this->listar($objTextoPadraoInternoDTO);
    
    $strAutoTextosXml = '';
    if (count($arrObjTextoPadraoInternoDTO)>0){
      $strAutoTextosXml = '<autotextos>';
      foreach($arrObjTextoPadraoInternoDTO as $objTextoPadraoInternoDTO){
        $strAutoTextosXml .= '<autotexto nome="'.InfraString::formatarXML($objTextoPadraoInternoDTO->getStrNome()).'" descricao="'.InfraString::formatarXML($objTextoPadraoInternoDTO->getStrDescricao()).'">'.InfraString::formatarXML(str_replace(array("\r\n","\n","\r"),'<br />',$objTextoPadraoInternoDTO->getStrConteudo())).'</autotexto>';
      }
      $strAutoTextosXml .= '</autotextos>';
    }
    return $strAutoTextosXml;
  }
/* 
  protected function desativarControlado($arrObjTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTextoPadraoInternoDTO);$i++){
        $objTextoPadraoInternoBD->desativar($arrObjTextoPadraoInternoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Texto Padr�o.',$e);
    }
  }

  protected function reativarControlado($arrObjTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjTextoPadraoInternoDTO);$i++){
        $objTextoPadraoInternoBD->reativar($arrObjTextoPadraoInternoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Texto Padr�o.',$e);
    }
  }

  protected function bloquearControlado(TextoPadraoInternoDTO $objTextoPadraoInternoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('texto_padrao_interno_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTextoPadraoInternoBD = new TextoPadraoInternoBD($this->getObjInfraIBanco());
      $ret = $objTextoPadraoInternoBD->bloquear($objTextoPadraoInternoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Texto Padr�o.',$e);
    }
  }

 */
}
?>