<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 19/10/2018 - criado por cjy
*
* Vers�o do Gerador de C�digo: 1.42.0
*/

require_once dirname(__FILE__).'/../SEI.php';

class AvaliacaoDocumentalRN extends InfraRN {

  //status inicial da avaliacao documental
  public static  $TA_AVALIADO = 'A';
  //status quando toda a a composicao cpad do orgao avaliou concordando
  public static  $TA_COMISSAO = 'C';
  public static  $TA_ELIMINACAO_PARCIAL = 'P';
  public static  $TA_ELIMINADO = 'E';

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public function buscarValorAvaliacao($strChave) {
    return   $this->listarValoresAvaliacao()[$strChave]->getStrDescricao();
  }

  public function listarValoresAvaliacao(){
    try {

      $arrObjAvaliacaoAvaliacaoDocumentalDTO = array();

      $objAvaliacaoAvaliacaoDocumentalDTO = new AvaliacaoAvaliacaoDocumentalDTO();
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrStaAvaliacao(self::$TA_AVALIADO);
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrDescricao('Avaliado');
      $arrObjAvaliacaoAvaliacaoDocumentalDTO[self::$TA_AVALIADO] = $objAvaliacaoAvaliacaoDocumentalDTO;

      $objAvaliacaoAvaliacaoDocumentalDTO = new AvaliacaoAvaliacaoDocumentalDTO();
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrStaAvaliacao(self::$TA_COMISSAO);
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrDescricao('Avalia��o CPAD');
      $arrObjAvaliacaoAvaliacaoDocumentalDTO[self::$TA_COMISSAO] = $objAvaliacaoAvaliacaoDocumentalDTO;

      $objAvaliacaoAvaliacaoDocumentalDTO = new AvaliacaoAvaliacaoDocumentalDTO();
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrStaAvaliacao(self::$TA_ELIMINACAO_PARCIAL);
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrDescricao('Elimina��o Parcial');
      $arrObjAvaliacaoAvaliacaoDocumentalDTO[self::$TA_ELIMINACAO_PARCIAL] = $objAvaliacaoAvaliacaoDocumentalDTO;

      $objAvaliacaoAvaliacaoDocumentalDTO = new AvaliacaoAvaliacaoDocumentalDTO();
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrStaAvaliacao(self::$TA_ELIMINADO);
      $objAvaliacaoAvaliacaoDocumentalDTO->setStrDescricao('Eliminado');
      $arrObjAvaliacaoAvaliacaoDocumentalDTO[self::$TA_ELIMINADO] = $objAvaliacaoAvaliacaoDocumentalDTO;

      return $arrObjAvaliacaoAvaliacaoDocumentalDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Avaliacao.',$e);
    }
  }

  private function validarDblIdProcedimento(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getDblIdProcedimento())){
      $objInfraException->adicionarValidacao('Procedimento n�o informado.');
    }
  }

  private function validarNumAvaliacaoDocumental(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getNumIdAvaliacaoDocumental())){
      $objInfraException->adicionarValidacao('Avalia��o Documental n�o informada.');
    }
  }

  private function validarNumIdAssunto(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){

    //nao foi informado id assunto
    if(!$objAvaliacaoDocumentalDTO->isSetNumIdAssunto() || InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getNumIdAssunto())){
      $bolIdAssunto = false;
    }else{
      $bolIdAssunto = true;
    }

    //nao foi informado id assunto proxy
    if(!$objAvaliacaoDocumentalDTO->isSetNumIdAssuntoProxy() || InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getNumIdAssuntoProxy())){
      $bolIdAssuntoProxy = false;
    }else{
      $bolIdAssuntoProxy = true;
    }
    //se nao setou um id assunto proxy nem um id assunto
    if(!$bolIdAssunto && !$bolIdAssuntoProxy){
      $objInfraException->adicionarValidacao('Assunto n�o informado.');
    }else{
      //nao foi informado id assunto proxy
      if(!$bolIdAssuntoProxy){
        $objAssuntoProxyDTO = new AssuntoProxyDTO();
        $objAssuntoProxyDTO->retNumIdAssuntoProxy();
        $objAssuntoProxyDTO->setNumIdAssunto($objAvaliacaoDocumentalDTO->getNumIdAssunto());
        //como pode haver mais de um assunto proxy com o mesmo id assunto, considera o primeiro que encontrar
        $objAssuntoProxyDTO->setNumMaxRegistrosRetorno(1);
        $objAssuntoProxyDTO->setOrdNumIdAssuntoProxy(InfraDTO::$TIPO_ORDENACAO_ASC);
        $objAssuntoProxyRN = new AssuntoProxyRN();
        //seta o id assunto proxy
        $objAvaliacaoDocumentalDTO->setNumIdAssuntoProxy($objAssuntoProxyRN->consultar($objAssuntoProxyDTO)->getNumIdAssuntoProxy());
      }
      //nao foi informado id assunto
      if(!$bolIdAssunto){
        $objAssuntoProxyDTO = new AssuntoProxyDTO();
        $objAssuntoProxyDTO->retNumIdAssunto();
        //s� h� um id assunto proxy na tabela
        $objAssuntoProxyDTO->setNumIdAssuntoProxy($objAvaliacaoDocumentalDTO->getNumIdAssuntoProxy());
        $objAssuntoProxyRN = new AssuntoProxyRN();
        //seta o id assunto proxy
        $objAvaliacaoDocumentalDTO->setNumIdAssunto($objAssuntoProxyRN->consultar($objAssuntoProxyDTO)->getNumIdAssunto());
      }
    }
  }

  private function validarNumIdUsuario(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrStaAvaliacao(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getStrStaAvaliacao())){
      $objInfraException->adicionarValidacao('Situa��o da Avalia��o n�o informada.');
    }else{
      if (!in_array($objAvaliacaoDocumentalDTO->getStrStaAvaliacao(),InfraArray::converterArrInfraDTO($this->listarValoresAvaliacao(),'StaAvaliacao'))){
        $objInfraException->adicionarValidacao('Situa��o da Avalia��o inv�lida.');
      }
    }
  }

  private function validarDtaAvaliacao(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objAvaliacaoDocumentalDTO->getDtaAvaliacao())){
      $objInfraException->adicionarValidacao('Data da Avalia��o n�o informada.');
    }else{
      if (!InfraData::validarData($objAvaliacaoDocumentalDTO->getDtaAvaliacao())){
        $objInfraException->adicionarValidacao('Data da Avalia��o inv�lida.');
      }
    }
  }

  //retorna uma lista de assuntos RelProtocoloAssunto do processo (cujo id foi passado como parametro), de seus documentos e de assuntos dos processos anexados a esse processo e os documentos desse processo
  //recebe um RelProtocoloAssuntoDTO, pois podem ser passados outros atributos para filtrar (por exemplo no cadastro de avaliacao documental, que passa um id assunto pois justamente quer ver se esse assunto j� est� relacionado ao processo)
  protected function listarAssuntosProcessoConectado(RelProtocoloAssuntoDTO $parObjRelProtocoloAssuntoDTO){
    //array que conter� o id do processo dessa avaliacao documental, mais os ids dos processos anexados
    //ser� usado em seguida para buscar os assuntos desses processos e de seus documentos, independente se � o processo principal ou o anexado
    $objProcedimentoDTO = new ProcedimentoDTO();
    $objProcedimentoDTO->setDblIdProcedimento($parObjRelProtocoloAssuntoDTO->getDblIdProtocolo());
    $arrIdProcedimento = InfraArray::converterArrInfraDTO((new ProcedimentoRN())->listarProcessosAnexados($objProcedimentoDTO),"IdProcedimento");
    $arrIdProcedimento[] = $parObjRelProtocoloAssuntoDTO->getDblIdProtocolo();

    //busca os assuntos dos processos retornados antes
    //distinct, pois pode haver assuntos repetidos para processos ou documentos diferentes
    $objRelProtocoloAssuntoDTO = new RelProtocoloAssuntoDTO();
    $objRelProtocoloAssuntoDTO->setDistinct(true);
    $objRelProtocoloAssuntoDTO->retNumIdAssunto();
    $objRelProtocoloAssuntoDTO->retNumIdAssuntoProxy();
    $objRelProtocoloAssuntoDTO->retStrStaProtocolo();
    $objRelProtocoloAssuntoDTO->retDblIdProtocolo();
    $objRelProtocoloAssuntoDTO->retStrProtocoloFormatadoProtocolo();
    $objRelProtocoloAssuntoDTO->retStrCodigoEstruturadoAssunto();
    $objRelProtocoloAssuntoDTO->retStrDescricaoAssunto();
    $objRelProtocoloAssuntoDTO->retNumPrazoCorrenteAssunto();
    $objRelProtocoloAssuntoDTO->retNumPrazoIntermediarioAssunto();
    $objRelProtocoloAssuntoDTO->retStrStaDestinacaoAssunto();
    $objRelProtocoloAssuntoDTO->retStrObservacoesAssunto();
    //ids dos processos, assim sao filtrados todos os processos, documentos, processos anexados e documentos dos processos anexados
    $objRelProtocoloAssuntoDTO->setDblIdProtocoloProcedimento($arrIdProcedimento,InfraDTO::$OPER_IN);
    //ordenacao apenas para exibir na tela sempre na mesma ordem
    $objRelProtocoloAssuntoDTO->setOrdStrCodigoEstruturadoAssunto(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelProtocoloAssuntoRN = new RelProtocoloAssuntoRN();
    //lista os assuntos
    $arrObjRelProtocoloAssuntoDTO = $objRelProtocoloAssuntoRN->listarRN0188($objRelProtocoloAssuntoDTO);

    foreach ($arrObjRelProtocoloAssuntoDTO as $objRelProtocoloAssuntoDTO){
      if($objRelProtocoloAssuntoDTO->getStrStaProtocolo() == ProtocoloRN::$TP_PROCEDIMENTO) {
        $objProcedimentoDTO = new ProcedimentoDTO();
        $objProcedimentoDTO->retStrNomeTipoProcedimento();
        $objProcedimentoDTO->setDblIdProcedimento($objRelProtocoloAssuntoDTO->getDblIdProtocolo());
        $objRelProtocoloAssuntoDTO->setStrTipoProtocolo((new ProcedimentoRN())->consultarRN0201($objProcedimentoDTO)->getStrNomeTipoProcedimento());
      }else{
        $objDocumentoDTO = new DocumentoDTO();
        $objDocumentoDTO->retStrNomeSerie();
        $objDocumentoDTO->setDblIdDocumento($objRelProtocoloAssuntoDTO->getDblIdProtocolo());
        $objRelProtocoloAssuntoDTO->setStrTipoProtocolo((new DocumentoRN())->consultarRN0005($objDocumentoDTO)->getStrNomeSerie());
      }
    }

    return $arrObjRelProtocoloAssuntoDTO;
  }

  private function cadastrarRelProtocoloAssunto(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO){

    //array que conter� o id do processo dessa avaliacao documental, mais os ids dos processos anexados
    //ser� usado em seguida para buscar os assuntos desses processos e de seus documentos, independente se � o processo principal ou o anexado
    $objProcedimentoDTO = new ProcedimentoDTO();
    $objProcedimentoDTO->setDblIdProcedimento($objAvaliacaoDocumentalDTO->getDblIdProcedimento());
    $arrIdProcedimento = InfraArray::converterArrInfraDTO((new ProcedimentoRN())->listarProcessosAnexados($objProcedimentoDTO),"IdProcedimento");
    $arrIdProcedimento[] = $objAvaliacaoDocumentalDTO->getDblIdProcedimento();

    //dto para buscar os assuntos do processo, de seus documentos, de seus processos anexados e dos documentos dos processos anexados
    $objRelProtocoloAssuntoDTO = new RelProtocoloAssuntoDTO();
    $objRelProtocoloAssuntoDTO->setNumIdAssunto($objAvaliacaoDocumentalDTO->getNumIdAssunto());
    $objRelProtocoloAssuntoDTO->setDblIdProtocoloProcedimento($arrIdProcedimento,InfraDTO::$OPER_IN);

    $objRelProtocoloAssuntoRN = new RelProtocoloAssuntoRN();
    //se nao encontrou o assunto, quer dizer que ele nao tem relacao nesses processos ou em seus documentos e deve cadastrar

    if($objRelProtocoloAssuntoRN->contarRN0257($objRelProtocoloAssuntoDTO) == 0){
      //novo dto, que ser� cadastrado
      $objRelProtocoloAssuntoDTO_Novo = new RelProtocoloAssuntoDTO();
      //id do processo que est� sendo avaliado
      $objRelProtocoloAssuntoDTO_Novo->setDblIdProtocoloProcedimento($objAvaliacaoDocumentalDTO->getDblIdProcedimento());
      $objRelProtocoloAssuntoDTO_Novo->setDblIdProtocolo($objAvaliacaoDocumentalDTO->getDblIdProcedimento());
      //unidade do usuario logado
      $objRelProtocoloAssuntoDTO_Novo->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      //id do assunto
      $objRelProtocoloAssuntoDTO_Novo->setNumIdAssunto($objAvaliacaoDocumentalDTO->getNumIdAssunto());
      //numero de sequencia do assunto, n�o tem muita importancia
      $objRelProtocoloAssuntoDTO_Novo->setNumSequencia(0);
      //relaciona o assunto ao processo
      $objRelProtocoloAssuntoRN = new RelProtocoloAssuntoRN();
      $objRelProtocoloAssuntoDTO_Novo = $objRelProtocoloAssuntoRN->cadastrarRN0171($objRelProtocoloAssuntoDTO_Novo);
    }

    return $objAvaliacaoDocumentalDTO;
  }

  //cadastro de uma avaliacao documental
  protected function cadastrarControlado(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO) {
    try{

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_cadastrar',__METHOD__,$objAvaliacaoDocumentalDTO);

      $objInfraException = new InfraException();

      //validacoes padroes
      $this->validarDblIdProcedimento($objAvaliacaoDocumentalDTO, $objInfraException);
      $this->validarNumIdUsuario($objAvaliacaoDocumentalDTO, $objInfraException);
      $this->validarStrStaAvaliacao($objAvaliacaoDocumentalDTO, $objInfraException);
      $this->validarDtaAvaliacao($objAvaliacaoDocumentalDTO, $objInfraException);
      //a validacao de assunto faz dois testes, considerando que pelo menos o id assunto ou o id assunto proxy deve ter sido informado:
      //1. se nao foi informado o id assunto, busca ele a partir do id assunto proxy
      //2. se nao foi informado o id assunto proxy, busca ele a partir do id assunto
      $this->validarNumIdAssunto($objAvaliacaoDocumentalDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      //deve cadastrar/relacionar assunto ao processo, caso seja selecionado um novo na lupa de assuntos
      //seta o id assunto proxy, que � a coluna da tabela de avaliacao documental
      $objAvaliacaoDocumentalDTO = $this->cadastrarRelProtocoloAssunto($objAvaliacaoDocumentalDTO);
      //seta o id assunto com
      //cadastra avaliacao documental
      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      $ret = $objAvaliacaoDocumentalBD->cadastrar($objAvaliacaoDocumentalDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Avalia��o Documental.',$e);
    }
  }
  //alteracao de uma avaliacao documental
  protected function alterarControlado(AvaliacaoDocumentalDTO $parObjAvaliacaoDocumentalDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_alterar',__METHOD__,$parObjAvaliacaoDocumentalDTO);

      $objInfraException = new InfraException();

      $objAvaliacaoDocumentalDTOBanco = new AvaliacaoDocumentalDTO();
      $objAvaliacaoDocumentalDTOBanco->retStrStaAvaliacao();
      $objAvaliacaoDocumentalDTOBanco->setNumIdAvaliacaoDocumental($parObjAvaliacaoDocumentalDTO->getNumIdAvaliacaoDocumental());
      $objAvaliacaoDocumentalDTOBanco = $this->consultar($objAvaliacaoDocumentalDTOBanco);

      if ($objAvaliacaoDocumentalDTOBanco==null){
        throw new InfraException('Registro n�o encontrado.');
      }

      //validacoes padroes
      if ($parObjAvaliacaoDocumentalDTO->isSetNumIdAvaliacaoDocumental()){
        $this->validarNumAvaliacaoDocumental($parObjAvaliacaoDocumentalDTO, $objInfraException);
      }

      if ($parObjAvaliacaoDocumentalDTO->isSetDblIdProcedimento()){
        $this->validarDblIdProcedimento($parObjAvaliacaoDocumentalDTO, $objInfraException);
      }

      if ($parObjAvaliacaoDocumentalDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuario($parObjAvaliacaoDocumentalDTO, $objInfraException);
      }

      if ($parObjAvaliacaoDocumentalDTO->isSetStrStaAvaliacao() && $parObjAvaliacaoDocumentalDTO->getStrStaAvaliacao()!=$objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()){
        $this->validarStrStaAvaliacao($parObjAvaliacaoDocumentalDTO, $objInfraException);

        if (
          ($parObjAvaliacaoDocumentalDTO->getStrStaAvaliacao()==self::$TA_AVALIADO && $objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()!=self::$TA_AVALIADO) ||
          ($parObjAvaliacaoDocumentalDTO->getStrStaAvaliacao()==self::$TA_COMISSAO && $objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()!=self::$TA_AVALIADO) ||
          ($parObjAvaliacaoDocumentalDTO->getStrStaAvaliacao()==self::$TA_ELIMINACAO_PARCIAL && $objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()!=self::$TA_COMISSAO) ||
          ($parObjAvaliacaoDocumentalDTO->getStrStaAvaliacao()==self::$TA_ELIMINADO && $objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()!=self::$TA_COMISSAO && $objAvaliacaoDocumentalDTOBanco->getStrStaAvaliacao()!=self::$TA_ELIMINACAO_PARCIAL)
        ){
          $objInfraException->lancarValidacao('Situa��o da avalia��o n�o permite altera��o.');
        }
      }
      if ($parObjAvaliacaoDocumentalDTO->isSetDtaAvaliacao()){
        $this->validarDtaAvaliacao($parObjAvaliacaoDocumentalDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();




      //a validacao de assunto faz dois testes, considerando que pelo menos o id assunto ou o id assunto proxy deve ter sido informado:
      //1. se nao foi informado o id assunto, busca ele a partir do id assunto proxy
      //2. se nao foi informado o id assunto proxy, busca ele a partir do id assunto
      if ($parObjAvaliacaoDocumentalDTO->isSetNumIdAssunto() || $parObjAvaliacaoDocumentalDTO->isSetNumIdAssuntoProxy()) {
        $this->validarNumIdAssunto($parObjAvaliacaoDocumentalDTO, $objInfraException);

        //deve cadastrar/relacionar assunto ao processo, caso seja selecionado um novo na lupa de assuntos
        //seta o id assunto proxy, que � a coluna da tabela de avaliacao documental
        $parObjAvaliacaoDocumentalDTO =  $this->cadastrarRelProtocoloAssunto($parObjAvaliacaoDocumentalDTO);
      }

      //altera a avaliacao documental
      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      $objAvaliacaoDocumentalBD->alterar($parObjAvaliacaoDocumentalDTO);

    }catch(Exception $e){
      throw new InfraException('Erro alterando Avalia��o Documental.',$e);
    }
  }
  protected function alterarAvaliadoControlado(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO){
    try {

      $this->alterarControlado($objAvaliacaoDocumentalDTO);

      //sempre que � alterada uma avaliacao documental j� realizada, todas avaliacoes cpad negadas devem ser justificadas, assim as avaliacoes cpad ativas sao passadas para nao ativas
      $objCpadAvaliacaoRN = new CpadAvaliacaoRN();
      //testa se havia avaliacoes cpad ativas negadas na tela, que o usuario deve ter justificado
      if($objAvaliacaoDocumentalDTO->isSetArrObjCpadAvaliacaoDTO() && InfraArray::contar($objAvaliacaoDocumentalDTO->getArrObjCpadAvaliacaoDTO()) > 0){
        foreach ($objAvaliacaoDocumentalDTO->getArrObjCpadAvaliacaoDTO() as $objCpadAvaliacaoDTO){
          //altera essas avaliacoes, conforme as informacoes setadas na tela
          $objCpadAvaliacaoRN->alterar($objCpadAvaliacaoDTO);
        }
        //busca as avaliacoes cpad ativas dessa avaliacao documental, independente se negadas ou que concordaram
        $objCpadAvaliacaoDTO_Ativo = new CpadAvaliacaoDTO();
        $objCpadAvaliacaoDTO_Ativo->retNumIdCpadAvaliacao();
        //seta id da avaliacao documental
        $objCpadAvaliacaoDTO_Ativo->setNumIdAvaliacaoDocumental($objAvaliacaoDocumentalDTO->getNumIdAvaliacaoDocumental());
        //lista as avaliacoes cpad
        $arrObjCpadAvaliacaoDTO_Ativo = $objCpadAvaliacaoRN->listar($objCpadAvaliacaoDTO_Ativo);
        //testa se existem ativas
        if(InfraArray::contar($arrObjCpadAvaliacaoDTO_Ativo) > 0){
          //itera nas ativas
          foreach ($arrObjCpadAvaliacaoDTO_Ativo as $objCpadAvaliacaoDTO_Ativo){
            //desativa
            $objCpadAvaliacaoRN->desativar(array($objCpadAvaliacaoDTO_Ativo));
          }
        }
      //se nao havia avaliacoes cpad ativas negadas, o usuario alterou a avaliacao documental e podia haver avaliacoes cpad que componentes estavam de acordo, entao essas avaliacoes cpad devem ser apagadas
      }else{
        //busca avaliacoes cpad ativas
        $objCpadAvaliacaoDTO_Ativo = new CpadAvaliacaoDTO();
        $objCpadAvaliacaoDTO_Ativo->retNumIdCpadAvaliacao();
        //seta id da avaliacao documental
        $objCpadAvaliacaoDTO_Ativo->setNumIdAvaliacaoDocumental($objAvaliacaoDocumentalDTO->getNumIdAvaliacaoDocumental());

        $objCpadAvaliacaoRN = new CpadAvaliacaoRN();
        //exclui
        $objCpadAvaliacaoRN->excluir($objCpadAvaliacaoRN->listar($objCpadAvaliacaoDTO_Ativo));
      }

    }catch(Exception $e){
      throw new InfraException('Erro alterando Avalia��o Documental.',$e);
    }
  }
  //excluir padrao
  protected function excluirControlado($arrObjAvaliacaoDocumentalDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_excluir',__METHOD__,$arrObjAvaliacaoDocumentalDTO);

      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjAvaliacaoDocumentalDTO);$i++){
        $objAvaliacaoDocumentalBD->excluir($arrObjAvaliacaoDocumentalDTO[$i]);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Avalia��o Documental.',$e);
    }
  }
  //consultar padrao
  protected function consultarConectado(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_consultar',__METHOD__,$objAvaliacaoDocumentalDTO);

      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      $ret = $objAvaliacaoDocumentalBD->consultar($objAvaliacaoDocumentalDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Avalia��o Documental.',$e);
    }
  }
  //listar padrao
  protected function listarConectado(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO) {
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_listar',__METHOD__,$objAvaliacaoDocumentalDTO);

      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      $ret = $objAvaliacaoDocumentalBD->listar($objAvaliacaoDocumentalDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Avalia��es Documentais.',$e);
    }
  }


  //contar padrao
  protected function contarConectado(AvaliacaoDocumentalDTO $objAvaliacaoDocumentalDTO){
    try {

      SessaoSEI::getInstance()->validarAuditarPermissao('avaliacao_documental_listar',__METHOD__,$objAvaliacaoDocumentalDTO);

      $objAvaliacaoDocumentalBD = new AvaliacaoDocumentalBD($this->getObjInfraIBanco());
      $ret = $objAvaliacaoDocumentalBD->contar($objAvaliacaoDocumentalDTO);

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Avalia��es Documentais.',$e);
    }
  }




}


