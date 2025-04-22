<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/11/2015 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.36.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AndamentoMarcadorRN extends InfraRN {

  public static $TO_INCLUSAO = 'I';
  public static $TO_ALTERACAO = 'A';
  public static $TO_REMOCAO = 'R';


  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public function listarValoresOperacao(){
    try {

      $arr = array();

      $objOperacaoAndamentoMarcadorDTO = new OperacaoAndamentoMarcadorDTO();
      $objOperacaoAndamentoMarcadorDTO->setStrStaOperacao(self::$TO_INCLUSAO);
      $objOperacaoAndamentoMarcadorDTO->setStrDescricao('Inclus�o');
      $arr[] = $objOperacaoAndamentoMarcadorDTO;

      $objOperacaoAndamentoMarcadorDTO = new OperacaoAndamentoMarcadorDTO();
      $objOperacaoAndamentoMarcadorDTO->setStrStaOperacao(self::$TO_ALTERACAO);
      $objOperacaoAndamentoMarcadorDTO->setStrDescricao('Altera��o');
      $arr[] = $objOperacaoAndamentoMarcadorDTO;

      $objOperacaoAndamentoMarcadorDTO = new OperacaoAndamentoMarcadorDTO();
      $objOperacaoAndamentoMarcadorDTO->setStrStaOperacao(self::$TO_REMOCAO);
      $objOperacaoAndamentoMarcadorDTO->setStrDescricao('Remo��o');
      $arr[] = $objOperacaoAndamentoMarcadorDTO;

      return $arr;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Opera��o.',$e);
    }
  }

  private function validarNumIdMarcador(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getNumIdMarcador())){
      $objInfraException->adicionarValidacao('Marcador n�o informado.');
    }
  }

  private function validarDblIdProcedimento(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if ((!is_array($objAndamentoMarcadorDTO->getDblIdProcedimento()) || InfraArray::contar($objAndamentoMarcadorDTO->getDblIdProcedimento())==0)){
      $objInfraException->adicionarValidacao('Nenhum processo n�o informado.');
    }
  }

  private function validarNumIdUnidade(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarNumIdUsuario(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarDthExecucao(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getDthExecucao())){
      $objInfraException->adicionarValidacao('Data/Hora de Execu��o n�o informada.');
    }else{
      if (!InfraData::validarDataHora($objAndamentoMarcadorDTO->getDthExecucao())){
        $objInfraException->adicionarValidacao('Data/Hora de Execu��o inv�lida.');
      }
    }
  }

  private function validarStrTexto(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getStrTexto())){
      $objAndamentoMarcadorDTO->setStrTexto(null);
    }else{
      $objAndamentoMarcadorDTO->setStrTexto(trim($objAndamentoMarcadorDTO->getStrTexto()));

      if (strlen($objAndamentoMarcadorDTO->getStrTexto())>500){
        $objInfraException->adicionarValidacao('Texto possui tamanho superior a 500 caracteres.');
      }
    }
  }

  private function validarStrStaOperacao(AndamentoMarcadorDTO $objAndamentoMarcadorDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAndamentoMarcadorDTO->getStrStaOperacao())){
      $objInfraException->adicionarValidacao('Opera��o n�o informada.');
    }else{
      if (!in_array($objAndamentoMarcadorDTO->getStrStaOperacao(),InfraArray::converterArrInfraDTO($this->listarValoresOperacao(),'StaOperacao'))){
        $objInfraException->adicionarValidacao('Opera��o inv�lida.');
      }
    }
  }

  protected function cadastrarControlado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO) {
    try{

      $ret = null;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_cadastrar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdMarcador($objAndamentoMarcadorDTO, $objInfraException);
      $this->validarDblIdProcedimento($objAndamentoMarcadorDTO, $objInfraException);
      $this->validarStrTexto($objAndamentoMarcadorDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $arrIdProcedimento = $objAndamentoMarcadorDTO->getDblIdProcedimento();

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->retDblIdProtocolo();
      $objProtocoloDTO->retStrProtocoloFormatado();
      $objProtocoloDTO->setDblIdProtocolo($arrIdProcedimento, InfraDTO::$OPER_IN);

      $objProtocoloRN = new ProtocoloRN();
      $arrObjProtocoloDTO = InfraArray::indexarArrInfraDTO($objProtocoloRN->listarRN0668($objProtocoloDTO),'IdProtocolo');

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());

      $arrIdAlteracao = array();
      foreach($arrObjProtocoloDTO as $dblIdProtocolo => $objProtocoloDTO) {

        $dto = new AndamentoMarcadorDTO();
        $dto->retStrNomeMarcador();
        $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());
        $dto->setDblIdProcedimento($dblIdProtocolo);
        $dto->setStrSinUltimo('S');
        $dto->setNumMaxRegistrosRetorno(1);

        $dto = $this->consultar($dto);

        if ($dto != null) {
          $arrIdAlteracao[] = $dblIdProtocolo;
        }else{
          $dto = new AndamentoMarcadorDTO();
          $dto->setNumIdAndamentoMarcador(null);
          $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());
          $dto->setDblIdProcedimento($dblIdProtocolo);
          $dto->setStrTexto($objAndamentoMarcadorDTO->getStrTexto());
          $dto->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $dto->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
          $dto->setDthExecucao(InfraData::getStrDataHoraAtual());
          $dto->setStrStaOperacao(self::$TO_INCLUSAO);
          $dto->setStrSinUltimo('S');
          $dto->setStrSinAtivo('S');
          $ret = $objAndamentoMarcadorBD->cadastrar($dto);
        }
      }

      if (count($arrIdAlteracao)){
        $objAndamentoMarcadorDTO->setDblIdProcedimento($arrIdAlteracao);
        $this->alterar($objAndamentoMarcadorDTO);
      }

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro adicionando marcador em processo.',$e);
    }
  }

  protected function alterarControlado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_alterar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarNumIdMarcador($objAndamentoMarcadorDTO, $objInfraException);
      $this->validarDblIdProcedimento($objAndamentoMarcadorDTO, $objInfraException);
      $this->validarStrTexto($objAndamentoMarcadorDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $arrIdProcedimento = $objAndamentoMarcadorDTO->getDblIdProcedimento();

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->retDblIdProtocolo();
      $objProtocoloDTO->retStrProtocoloFormatado();
      $objProtocoloDTO->setDblIdProtocolo($arrIdProcedimento, InfraDTO::$OPER_IN);

      $objProtocoloRN = new ProtocoloRN();
      $arrObjProtocoloDTO = InfraArray::indexarArrInfraDTO($objProtocoloRN->listarRN0668($objProtocoloDTO),'IdProtocolo');

      foreach($arrObjProtocoloDTO as $dblIdProtocolo => $objProtocoloDTO) {

        $dto = new AndamentoMarcadorDTO();
        $dto->retNumIdAndamentoMarcador();
        $dto->retStrSinUltimo();
        $dto->retStrTexto();
        $dto->setDblIdProcedimento($dblIdProtocolo);
        $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());

        $arrObjAndamentoMarcadorDTO = $this->listar($dto);

        if (count($arrObjAndamentoMarcadorDTO) == 0) {
          $objInfraException->lancarValidacao('Marcador n�o encontrado no processo '.$objProtocoloDTO->getStrProtocoloFormatado().'.');
        }

        $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());

        foreach ($arrObjAndamentoMarcadorDTO as $dto) {
          if ($dto->getStrSinUltimo() == 'S') {

            if ($dto->getStrTexto()==$objAndamentoMarcadorDTO->getStrTexto()){
              return;
            }

            $dto->setStrSinUltimo('N');
            $objAndamentoMarcadorBD->alterar($dto);
          }
        }

        $dto = new AndamentoMarcadorDTO();
        $dto->setNumIdAndamentoMarcador(null);
        $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());
        $dto->setDblIdProcedimento($dblIdProtocolo);
        $dto->setStrTexto($objAndamentoMarcadorDTO->getStrTexto());
        $dto->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $dto->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
        $dto->setDthExecucao(InfraData::getStrDataHoraAtual());
        $dto->setStrStaOperacao(self::$TO_ALTERACAO);
        $dto->setStrSinUltimo('S');
        $dto->setStrSinAtivo('S');
        $objAndamentoMarcadorBD->cadastrar($dto);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando marcador no processo.',$e);
    }
  }


  protected function removerControlado($arrObjAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_remover',__METHOD__,$arrObjAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());

      foreach($arrObjAndamentoMarcadorDTO as $objAndamentoMarcadorDTO){

        $dto = new AndamentoMarcadorDTO();
        $dto->retNumIdAndamentoMarcador();
        $dto->retStrTexto();
        $dto->retStrSinUltimo();
        $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());
        $dto->setDblIdProcedimento($objAndamentoMarcadorDTO->getDblIdProcedimento());

        $arr = $this->listar($dto);

        $strTexto = '';

        foreach($arr as $dto){

          if ($dto->getStrSinUltimo()=='S'){
            $strTexto = $dto->getStrTexto();
          }

          $dto->setStrSinUltimo('N');
          $dto->setStrSinAtivo('N');
          $objAndamentoMarcadorBD->alterar($dto);
        }

        $dto = new AndamentoMarcadorDTO();
        $dto->setNumIdAndamentoMarcador(null);
        $dto->setNumIdMarcador($objAndamentoMarcadorDTO->getNumIdMarcador());
        $dto->setDblIdProcedimento($objAndamentoMarcadorDTO->getDblIdProcedimento());
        $dto->setStrTexto($strTexto);
        $dto->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $dto->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
        $dto->setDthExecucao(InfraData::getStrDataHoraAtual());
        $dto->setStrStaOperacao(self::$TO_REMOCAO);
        $dto->setStrSinUltimo('N');
        $dto->setStrSinAtivo('N');
        $objAndamentoMarcadorBD->cadastrar($dto);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro removendo marcador do processo.',$e);
    }
  }

  protected function excluirControlado($arrObjAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_excluir',__METHOD__,$arrObjAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAndamentoMarcadorDTO);$i++){
        $objAndamentoMarcadorBD->excluir($arrObjAndamentoMarcadorDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo marcador do processo.',$e);
    }
  }


  protected function consultarConectado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_consultar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      $ret = $objAndamentoMarcadorBD->consultar($objAndamentoMarcadorDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando marcador do processo.',$e);
    }
  }

  protected function listarConectado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_listar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      $ret = $objAndamentoMarcadorBD->listar($objAndamentoMarcadorDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando marcadores do processo.',$e);
    }
  }

  protected function contarConectado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_listar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      $ret = $objAndamentoMarcadorBD->contar($objAndamentoMarcadorDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando marcadores do processo.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_desativar',__METHOD__,$arrObjAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAndamentoMarcadorDTO);$i++){
        $objAndamentoMarcadorBD->desativar($arrObjAndamentoMarcadorDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando marcador do processo.',$e);
    }
  }

  protected function reativarControlado($arrObjAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_reativar',__METHOD__,$arrObjAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAndamentoMarcadorDTO);$i++){
        $objAndamentoMarcadorBD->reativar($arrObjAndamentoMarcadorDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando marcador do processo.',$e);
    }
  }

  protected function bloquearControlado(AndamentoMarcadorDTO $objAndamentoMarcadorDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('andamento_marcador_consultar',__METHOD__,$objAndamentoMarcadorDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objAndamentoMarcadorBD = new AndamentoMarcadorBD($this->getObjInfraIBanco());
      $ret = $objAndamentoMarcadorBD->bloquear($objAndamentoMarcadorDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando marcador do processo.',$e);
    }
  }

 */
}
?>