<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/07/2008 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.19.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class SerieRN extends InfraRN {
   
  public static $TN_SEQUENCIAL_UNIDADE = '1';
  public static $TN_SEQUENCIAL_ORGAO = '2';
  public static $TN_SEQUENCIAL_ANUAL_UNIDADE = '3';
  public static $TN_SEQUENCIAL_ANUAL_ORGAO = '4';
  public static $TN_SEM_NUMERACAO = 'S';
  public static $TN_INFORMADA = 'I';

  public static $TA_INTERNO_EXTERNO = 'T';
  public static $TA_INTERNO = 'I';
  public static $TA_EXTERNO = 'E';
  public static $TA_FORMULARIO = 'F';

  public static $TS_PUBLICACAO_ASSINADOS = 1;
  public static $TS_PERMITE_INTERESSADOS = 2;
  public static $TS_PERMITE_DESTINATARIOS = 3;
  public static $TS_INTERNO_SISTEMA = 4;
  public static $TS_USUARIO_EXTERNO = 5;
  public static $TS_PERMITE_VALOR_MONETARIO = 6;

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public static function listarValoresSinalizacao(){
    try {

      $arrObjSinalizacaoDTO = array();

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_PUBLICACAO_ASSINADOS);
      $objSinalizacaoDTO->setStrDescricao('Permitir publica��o apenas para documentos assinados');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_USUARIO_EXTERNO);
      $objSinalizacaoDTO->setStrDescricao('Permitida inclus�o por usu�rio externo');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_PERMITE_INTERESSADOS);
      $objSinalizacaoDTO->setStrDescricao('Permite interessados');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_PERMITE_DESTINATARIOS);
      $objSinalizacaoDTO->setStrDescricao('Permite destinat�rios');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_PERMITE_VALOR_MONETARIO);
      $objSinalizacaoDTO->setStrDescricao('Permite valor monet�rio');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_INTERNO_SISTEMA);
      $objSinalizacaoDTO->setStrDescricao('Interno do sistema');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      return $arrObjSinalizacaoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Sinaliza��o.',$e);
    }
  }

  protected function cadastrarRN0642Controlado(SerieDTO $objSerieDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_cadastrar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNomeRN0788($objSerieDTO, $objInfraException);
      $this->validarStrDescricaoRN0789($objSerieDTO, $objInfraException);
      $this->validarStrStaAplicabilidade($objSerieDTO, $objInfraException);
      $this->validarNumIdModelo($objSerieDTO, $objInfraException);
      $this->validarNumIdModeloEdocRN1140($objSerieDTO, $objInfraException);
      $this->validarNumIdTipoFormulario($objSerieDTO, $objInfraException);
      $this->validarStrStaNumeracao($objSerieDTO, $objInfraException);
      $this->validarStrSinInteressado($objSerieDTO, $objInfraException);
      $this->validarStrSinDestinatario($objSerieDTO, $objInfraException);
      $this->validarStrSinValorMonetario($objSerieDTO, $objInfraException);
      $this->validarStrSinInterno($objSerieDTO, $objInfraException);
      $this->validarStrSinAssinaturaPublicacao($objSerieDTO, $objInfraException);
      $this->validarStrSinAtivoRN0794($objSerieDTO, $objInfraException);
      $this->validarArrObjRelSerieAssuntoDTO($objSerieDTO, $objInfraException);
      $this->validarArrObjSerieRestricaoDTO($objSerieDTO, $objInfraException);
      $this->validarArrObjRelSerieVeiculoPublicacaoDTO($objSerieDTO, $objInfraException);
      
      $objInfraException->lancarValidacoes();

      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $ret = $objSerieBD->cadastrar($objSerieDTO);
      
      $arrObjRelSerieAssuntoDTO = $objSerieDTO->getArrObjRelSerieAssuntoDTO();
      $objRelSerieAssuntoRN = new RelSerieAssuntoRN();
      foreach($arrObjRelSerieAssuntoDTO as $objRelSerieAssuntoDTO){
        $objRelSerieAssuntoDTO->setNumIdSerie($ret->getNumIdSerie());
        $objRelSerieAssuntoRN->cadastrar($objRelSerieAssuntoDTO);
      }
      
      $arrObjSerieRestricaoDTO = $objSerieDTO->getArrObjSerieRestricaoDTO();
      $objSerieRestricaoRN = new SerieRestricaoRN();
      foreach($arrObjSerieRestricaoDTO as $objSerieRestricaoDTO){
        $objSerieRestricaoDTO->setNumIdSerieRestricao(null);
        $objSerieRestricaoDTO->setNumIdSerie($ret->getNumIdSerie());
        $objSerieRestricaoRN->cadastrar($objSerieRestricaoDTO);
      }

      if (InfraArray::contar($arrObjSerieRestricaoDTO)){
        CacheSEI::getInstance()->setAtributoVersao('SEI_TDNL');
      }

      $objRelSerieVeiculoPublicacaoRN = new RelSerieVeiculoPublicacaoRN();
      $arrObjRelSerieVeiculoPublicacaoDTO = $objSerieDTO->getArrObjRelSerieVeiculoPublicacaoDTO();
      foreach($arrObjRelSerieVeiculoPublicacaoDTO as $objRelSerieVeiculoPublicacaoDTO){
        $objRelSerieVeiculoPublicacaoDTO->setNumIdSerie($ret->getNumIdSerie());        
        $objRelSerieVeiculoPublicacaoRN->cadastrar($objRelSerieVeiculoPublicacaoDTO);
      }

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Tipo de Documento.',$e);
    }
  }

  protected function alterarRN0643Controlado(SerieDTO $objSerieDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('serie_alterar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objSerieDTOBanco = new SerieDTO();
      $objSerieDTOBanco->retTodos();    
      $objSerieDTOBanco->setNumIdSerie($objSerieDTO->getNumIdSerie());
      
      $objSerieDTOBanco = $this->consultarRN0644($objSerieDTOBanco);

      if (!$objSerieDTO->isSetStrStaAplicabilidade()){
      	$objSerieDTO->setStrStaAplicabilidade($objSerieDTOBanco->getStrStaAplicabilidade());
      }else{
        $this->validarStrStaAplicabilidade($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrNome()){
        $this->validarStrNomeRN0788($objSerieDTO, $objInfraException);
      }
      
      if ($objSerieDTO->isSetStrDescricao()){
        $this->validarStrDescricaoRN0789($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetNumIdModelo()){
        $this->validarNumIdModelo($objSerieDTO, $objInfraException);
      }
      
      if ($objSerieDTO->isSetNumIdModeloEdoc()){
        $this->validarNumIdModeloEdocRN1140($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetNumIdTipoFormulario()){
        $this->validarNumIdTipoFormulario($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrStaNumeracao()){
        $this->validarStrStaNumeracao($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrSinInteressado()){
        $this->validarStrSinInteressado($objSerieDTO, $objInfraException);
      }
      
      if ($objSerieDTO->isSetStrSinDestinatario()){
        $this->validarStrSinDestinatario($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrSinValorMonetario()){
        $this->validarStrSinValorMonetario($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrSinInterno()){
        $this->validarStrSinInterno($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetStrSinAssinaturaPublicacao()){
        $this->validarStrSinAssinaturaPublicacao($objSerieDTO, $objInfraException);
      }
      
      if ($objSerieDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivoRN0794($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetArrObjRelSerieAssuntoDTO()) {
        $this->validarArrObjRelSerieAssuntoDTO($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetArrObjSerieRestricaoDTO()) {
        $this->validarArrObjSerieRestricaoDTO($objSerieDTO, $objInfraException);
      }

      if ($objSerieDTO->isSetArrObjRelSerieVeiculoPublicacaoDTO()) {
        $this->validarArrObjRelSerieVeiculoPublicacaoDTO($objSerieDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $objSerieBD->alterar($objSerieDTO);
                     
      
      if ($objSerieDTO->isSetArrObjRelSerieAssuntoDTO()) {
        $objRelSerieAssuntoRN = new RelSerieAssuntoRN();
        $objRelSerieAssuntoDTO = new RelSerieAssuntoDTO();
        $objRelSerieAssuntoDTO->retTodos();
        $objRelSerieAssuntoDTO->setNumIdSerie($objSerieDTO->getNumIdSerie());
        $objRelSerieAssuntoRN->excluir($objRelSerieAssuntoRN->listar($objRelSerieAssuntoDTO));
         
        $arrObjRelSerieAssuntoDTO = $objSerieDTO->getArrObjRelSerieAssuntoDTO();
         
        foreach($arrObjRelSerieAssuntoDTO as $objRelSerieAssuntoDTO){
          $objRelSerieAssuntoDTO->setNumIdSerie($objSerieDTO->getNumIdSerie());
          $objRelSerieAssuntoRN->cadastrar($objRelSerieAssuntoDTO);
        }
      }

      if ($objSerieDTO->isSetArrObjSerieRestricaoDTO()) {

        $objSerieRestricaoDTO = new SerieRestricaoDTO();
        $objSerieRestricaoDTO->retTodos();
        $objSerieRestricaoDTO->setNumIdSerie($objSerieDTO->getNumIdSerie());

        $objSerieRestricaoRN = new SerieRestricaoRN();
        $arrObjSerieRestricaoDTOAntigos = $objSerieRestricaoRN->listar($objSerieRestricaoDTO);

        $arrObjSerieRestricaoDTONovos = $objSerieDTO->getArrObjSerieRestricaoDTO();

        $arrObjSerieRestricaoDTOExclusao = array();

        foreach($arrObjSerieRestricaoDTOAntigos as $objSerieRestricaoDTOAntigo){
          $bolAchouRestricao = false;
          foreach($arrObjSerieRestricaoDTONovos as $objSerieRestricaoDTONovo){
            if ($objSerieRestricaoDTOAntigo->getNumIdOrgao()==$objSerieRestricaoDTONovo->getNumIdOrgao() && $objSerieRestricaoDTOAntigo->getNumIdUnidade()==$objSerieRestricaoDTONovo->getNumIdUnidade()){
              $bolAchouRestricao = true;
              break;
            }
          }

          if (!$bolAchouRestricao){
            $arrObjSerieRestricaoDTOExclusao[] = $objSerieRestricaoDTOAntigo;
          }
        }

        $objSerieRestricaoRN->excluir($arrObjSerieRestricaoDTOExclusao);

        foreach($arrObjSerieRestricaoDTONovos as $objSerieRestricaoDTONovo){
          $bolAchouRestricao = false;
          foreach($arrObjSerieRestricaoDTOAntigos as $objSerieRestricaoDTOAntigo){
            if ($objSerieRestricaoDTOAntigo->getNumIdOrgao()==$objSerieRestricaoDTONovo->getNumIdOrgao() && $objSerieRestricaoDTOAntigo->getNumIdUnidade()==$objSerieRestricaoDTONovo->getNumIdUnidade()){
              $bolAchouRestricao = true;
              break;
            }
          }

          if (!$bolAchouRestricao){
            $objSerieRestricaoDTONovo->setNumIdSerieRestricao(null);
            $objSerieRestricaoDTONovo->setNumIdSerie($objSerieDTO->getNumIdSerie());
            $objSerieRestricaoRN->cadastrar($objSerieRestricaoDTONovo);
          }
        }

        CacheSEI::getInstance()->removerAtributo('SEI_TDR_'.$objSerieDTO->getNumIdSerie());

        CacheSEI::getInstance()->setAtributoVersao('SEI_TDNL');
      }


      if ($objSerieDTO->isSetArrObjRelSerieVeiculoPublicacaoDTO()) {
        $objRelSerieVeiculoPublicacaoRN = new RelSerieVeiculoPublicacaoRN();      
        $objRelSerieVeiculoPublicacaoDTO = new RelSerieVeiculoPublicacaoDTO();
        $objRelSerieVeiculoPublicacaoDTO->retTodos();
        $objRelSerieVeiculoPublicacaoDTO->setNumIdSerie($objSerieDTO->getNumIdSerie());
        $objRelSerieVeiculoPublicacaoRN->excluir($objRelSerieVeiculoPublicacaoRN->listar($objRelSerieVeiculoPublicacaoDTO));
        
        $arrObjRelSerieVeiculoPublicacaoDTO = $objSerieDTO->getArrObjRelSerieVeiculoPublicacaoDTO();
        foreach($arrObjRelSerieVeiculoPublicacaoDTO as $objRelSerieVeiculoPublicacaoDTO){
          $objRelSerieVeiculoPublicacaoDTO->setNumIdSerie($objSerieDTO->getNumIdSerie());
          $objRelSerieVeiculoPublicacaoRN->cadastrar($objRelSerieVeiculoPublicacaoDTO);
        }            
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Tipo de Documento.',$e);
    }
  }

  protected function excluirRN0645Controlado($arrObjSerieDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_excluir',__METHOD__,$arrObjSerieDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $arrIdSerie = InfraArray::converterArrInfraDTO($arrObjSerieDTO, 'IdSerie');

      if (InfraArray::contar($arrIdSerie)) {

        $objSerieDTO = new SerieDTO();
        $objSerieDTO->setBolExclusaoLogica(false);
        $objSerieDTO->retNumIdSerie();
        $objSerieDTO->retStrNome();
        $objSerieDTO->retStrStaAplicabilidade();
        $objSerieDTO->setNumIdSerie($arrIdSerie, InfraDTO::$OPER_IN);

        $arrObjSerieDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0646($objSerieDTO),'IdSerie');

        $objDocumentoRN = new DocumentoRN();
        $objRelControleInternoSerieRN = new RelControleInternoSerieRN();
        $objPublicacaoLegadoRN = new PublicacaoLegadoRN();

        foreach($arrIdSerie as $numIdSerie){

          $strNome = $arrObjSerieDTOConsulta[$numIdSerie]->getStrNome();

          $objDocumentoDTO = new DocumentoDTO();
          $objDocumentoDTO->setNumIdSerie($numIdSerie);

          $numDocumentos = $objDocumentoRN->contarRN0007($objDocumentoDTO);
          if ($numDocumentos) {
            if ($numDocumentos == 1) {
              $objInfraException->lancarValidacao('Existe um documento utilizando o tipo '.$strNome.'.');
            } else {
              $objInfraException->lancarValidacao('Existem '.$numDocumentos.' documentos utilizando o tipo '.$strNome.'.');
            }
          }

          $objRelControleInternoSerieDTO = new RelControleInternoSerieDTO();
          $objRelControleInternoSerieDTO->setNumIdSerie($numIdSerie);

          if ($objRelControleInternoSerieRN->contar($objRelControleInternoSerieDTO)) {
            $objInfraException->lancarValidacao('Tipo de Documento '.$strNome.' faz parte de um Crit�rio de Controle Interno.');
          }


          $objPublicacaoLegadoDTO = new PublicacaoLegadoDTO();
          $objPublicacaoLegadoDTO->setNumIdSerie($numIdSerie);

          if ($objPublicacaoLegadoRN->contar($objPublicacaoLegadoDTO)) {
            $objInfraException->lancarValidacao('Existem publica��es legadas associadas com o tipo de documento '.$strNome.'.');
          }

        }

        $objInfraException->lancarValidacoes();

        $objOperacaoServicoRN = new OperacaoServicoRN();
        $objSerieEscolhaRN = new SerieEscolhaRN();
        $objNumeracaoRN = new NumeracaoRN();
        $objRelSerieVeiculoPublicacaoRN = new RelSerieVeiculoPublicacaoRN();
        $objSerieRestricaoRN = new SerieRestricaoRN();
        $objRelSerieAssuntoRN = new RelSerieAssuntoRN();
        $objRelSeriePlanoTrabalhoRN = new RelSeriePlanoTrabalhoRN();

        foreach($arrIdSerie as $numIdSerie){

          $objSerieEscolhaDTO = new SerieEscolhaDTO();
          $objSerieEscolhaDTO->retNumIdSerie();
          $objSerieEscolhaDTO->retNumIdUnidade();
          $objSerieEscolhaDTO->setNumIdSerie($numIdSerie);
          $objSerieEscolhaRN->excluir($objSerieEscolhaRN->listar($objSerieEscolhaDTO));

          $objOperacaoServicoDTO = new OperacaoServicoDTO();
          $objOperacaoServicoDTO->retNumIdOperacaoServico();
          $objOperacaoServicoDTO->setNumIdSerie($numIdSerie);
          $objOperacaoServicoRN->excluir($objOperacaoServicoRN->listar($objOperacaoServicoDTO));

          $objNumeracaoDTO = new NumeracaoDTO();
          $objNumeracaoDTO->retNumIdNumeracao();
          $objNumeracaoDTO->setNumIdSerie($numIdSerie);
          $objNumeracaoRN->excluir($objNumeracaoRN->listar($objNumeracaoDTO));

          $objRelSerieAssuntoDTO = new RelSerieAssuntoDTO();
          $objRelSerieAssuntoDTO->retNumIdSerie();
          $objRelSerieAssuntoDTO->retNumIdAssuntoProxy();
          $objRelSerieAssuntoDTO->setNumIdSerie($numIdSerie);
          $objRelSerieAssuntoRN->excluir($objRelSerieAssuntoRN->listar($objRelSerieAssuntoDTO));

          $objSerieRestricaoDTO = new SerieRestricaoDTO();
          $objSerieRestricaoDTO->retNumIdSerieRestricao();
          $objSerieRestricaoDTO->setNumIdSerie($numIdSerie);
          $objSerieRestricaoRN->excluir($objSerieRestricaoRN->listar($objSerieRestricaoDTO));

          $objRelSerieVeiculoPublicacaoDTO = new RelSerieVeiculoPublicacaoDTO();
          $objRelSerieVeiculoPublicacaoDTO->retNumIdSerie();
          $objRelSerieVeiculoPublicacaoDTO->retNumIdVeiculoPublicacao();
          $objRelSerieVeiculoPublicacaoDTO->setNumIdSerie($numIdSerie);
          $objRelSerieVeiculoPublicacaoRN->excluir($objRelSerieVeiculoPublicacaoRN->listar($objRelSerieVeiculoPublicacaoDTO));

          $objRelSeriePlanoTrabalhoDTO = new RelSeriePlanoTrabalhoDTO();
          $objRelSeriePlanoTrabalhoDTO->retNumIdSerie();
          $objRelSeriePlanoTrabalhoDTO->retNumIdPlanoTrabalho();
          $objRelSeriePlanoTrabalhoDTO->setNumIdSerie($numIdSerie);
          $objRelSeriePlanoTrabalhoRN->excluir($objRelSeriePlanoTrabalhoRN->listar($objRelSeriePlanoTrabalhoDTO));

        }

        $arrObjSerieAPI = array();
        foreach ($arrObjSerieDTOConsulta as $objSerieDTO) {
          $objSerieAPI = new SerieAPI();
          $objSerieAPI->setIdSerie($objSerieDTO->getNumIdSerie());
          $objSerieAPI->setNome($objSerieDTO->getStrNome());
          $objSerieAPI->setAplicabilidade($objSerieDTO->getStrStaAplicabilidade());
          $arrObjSerieAPI[] = $objSerieAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('excluirTipoDocumento', $arrObjSerieAPI);
        }

        $objSerieBD = new SerieBD($this->getObjInfraIBanco());
        for ($i = 0; $i < count($arrObjSerieDTO); $i++) {
          $objSerieBD->excluir($arrObjSerieDTO[$i]);
        }
      }
      
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Tipo de Documento.',$e);
    }
  }

  protected function consultarRN0644Conectado(SerieDTO $objSerieDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_consultar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      
      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $ret = $objSerieBD->consultar($objSerieDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Tipo de Documento.',$e);
    }
  }

  protected function listarRN0646Conectado(SerieDTO $objSerieDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_listar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $ret = $objSerieBD->listar($objSerieDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Documento.',$e);
    }
  }

  protected function pesquisarConectado(SerieDTO $objSerieDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_listar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieDTO = InfraString::tratarPalavrasPesquisaDTO($objSerieDTO,"Nome");

      if ($objSerieDTO->isSetNumIdAssunto()){
        $objRelSerieAssuntoRN = new RelSerieAssuntoRN();
        $objRelSerieAssuntoDTO = new RelSerieAssuntoDTO();
        $objRelSerieAssuntoDTO->retNumIdSerie();
        $objRelSerieAssuntoDTO->setNumIdAssunto($objSerieDTO->getNumIdAssunto());
        $arrObjRelSerieAssuntoDTO = $objRelSerieAssuntoRN->listar($objRelSerieAssuntoDTO);
        if(InfraArray::contar($arrObjRelSerieAssuntoDTO)) {
          $arrIdSerie = InfraArray::converterArrInfraDTO($arrObjRelSerieAssuntoDTO,"IdSerie");
          $objSerieDTO->setNumIdSerie($arrIdSerie, InfraDTO::$OPER_IN);
        }else{
          $objSerieDTO->setNumIdSerie(null);
        }
      }


      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $ret = $objSerieBD->listar($objSerieDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Processo.',$e);
    }
  }


  protected function contarRN0647Conectado(SerieDTO $objSerieDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_listar',__METHOD__,$objSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objSerieBD = new SerieBD($this->getObjInfraIBanco());
      $ret = $objSerieBD->contar($objSerieDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Tipos de Documento.',$e);
    }
  }

  protected function desativarRN0648Controlado($arrObjSerieDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_desativar',__METHOD__,$arrObjSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdSerie = InfraArray::converterArrInfraDTO($arrObjSerieDTO, 'IdSerie');

      if (InfraArray::contar($arrIdSerie)) {

        $objSerieBD = new SerieBD($this->getObjInfraIBanco());
        for ($i = 0; $i < InfraArray::contar($arrObjSerieDTO); $i++) {
          $objSerieBD->desativar($arrObjSerieDTO[$i]);
        }

        $objSerieDTO = new SerieDTO();
        $objSerieDTO->setBolExclusaoLogica(false);
        $objSerieDTO->retNumIdSerie();
        $objSerieDTO->retStrNome();
        $objSerieDTO->retStrStaAplicabilidade();
        $objSerieDTO->setNumIdSerie($arrIdSerie, InfraDTO::$OPER_IN);

        $arrObjSerieDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0646($objSerieDTO), 'IdSerie');

        $arrObjSerieAPI = array();
        foreach ($arrObjSerieDTOConsulta as $objSerieDTO) {
          $objSerieAPI = new SerieAPI();
          $objSerieAPI->setIdSerie($objSerieDTO->getNumIdSerie());
          $objSerieAPI->setNome($objSerieDTO->getStrNome());
          $objSerieAPI->setAplicabilidade($objSerieDTO->getStrStaAplicabilidade());
          $arrObjSerieAPI[] = $objSerieAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('desativarTipoDocumento', $arrObjSerieAPI);
        }
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Tipo de Documento.',$e);
    }
  }

  protected function reativarRN0649Controlado($arrObjSerieDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('serie_reativar',__METHOD__,$arrObjSerieDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdSerie = InfraArray::converterArrInfraDTO($arrObjSerieDTO, 'IdSerie');

      if (InfraArray::contar($arrIdSerie)) {

        $objSerieBD = new SerieBD($this->getObjInfraIBanco());
        for($i=0;$i<InfraArray::contar($arrObjSerieDTO);$i++){
          $objSerieBD->reativar($arrObjSerieDTO[$i]);
        }

        $objSerieDTO = new SerieDTO();
        $objSerieDTO->setBolExclusaoLogica(false);
        $objSerieDTO->retNumIdSerie();
        $objSerieDTO->retStrNome();
        $objSerieDTO->retStrStaAplicabilidade();
        $objSerieDTO->setNumIdSerie($arrIdSerie, InfraDTO::$OPER_IN);

        $arrObjSerieDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0646($objSerieDTO), 'IdSerie');

        $arrObjSerieAPI = array();
        foreach ($arrObjSerieDTOConsulta as $objSerieDTO) {
          $objSerieAPI = new SerieAPI();
          $objSerieAPI->setIdSerie($objSerieDTO->getNumIdSerie());
          $objSerieAPI->setNome($objSerieDTO->getStrNome());
          $objSerieAPI->setAplicabilidade($objSerieDTO->getStrStaAplicabilidade());
          $arrObjSerieAPI[] = $objSerieAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('reativarTipoDocumento', $arrObjSerieAPI);
        }
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Tipo de Documento.',$e);
    }
  }

  public function listarTiposNumeracaoRN0795(){
  	$arr = array();

  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_SEQUENCIAL_UNIDADE);
  	$objTipoDTO->setStrDescricao('Sequencial na Unidade');
  	$arr[] = $objTipoDTO;
  	
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_SEQUENCIAL_ORGAO);
  	$objTipoDTO->setStrDescricao('Sequencial no �rg�o');
  	$arr[] = $objTipoDTO;

  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_SEQUENCIAL_ANUAL_UNIDADE);
  	$objTipoDTO->setStrDescricao('Sequencial Anual na Unidade');
  	$arr[] = $objTipoDTO;
  	
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_SEQUENCIAL_ANUAL_ORGAO);
  	$objTipoDTO->setStrDescricao('Sequencial Anual no �rg�o');
  	$arr[] = $objTipoDTO;
  	
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_SEM_NUMERACAO);
  	$objTipoDTO->setStrDescricao('Sem Numera��o');
  	$arr[] = $objTipoDTO;
  	
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TN_INFORMADA);
  	$objTipoDTO->setStrDescricao('Informada');
  	$arr[] = $objTipoDTO;
  	
  	return $arr;
  }

  public function listarTiposAplicabilidade(){
  	$arr = array();
  
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TA_INTERNO_EXTERNO);
  	$objTipoDTO->setStrDescricao('Documentos internos e externos');
  	$arr[] = $objTipoDTO;
  	 
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TA_INTERNO);
  	$objTipoDTO->setStrDescricao('Documentos internos');
  	$arr[] = $objTipoDTO;
  
  	$objTipoDTO = new TipoDTO();
  	$objTipoDTO->setStrStaTipo(SerieRN::$TA_EXTERNO);
  	$objTipoDTO->setStrDescricao('Documentos externos');
  	$arr[] = $objTipoDTO;

    $objTipoDTO = new TipoDTO();
    $objTipoDTO->setStrStaTipo(SerieRN::$TA_FORMULARIO);
    $objTipoDTO->setStrDescricao('Formul�rios');
    $arr[] = $objTipoDTO;

  	return $arr;
  }

  private function validarStrNomeRN0788(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{

      $objSerieDTO->setStrNome(trim($objSerieDTO->getStrNome()));
  
      if (strlen($objSerieDTO->getStrNome())>100){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a 100 caracteres.');
      }

      $dto = new SerieDTO();
      $dto->retStrSinAtivo();
      $dto->setNumIdSerie($objSerieDTO->getNumIdSerie(),InfraDTO::$OPER_DIFERENTE);
      $dto->setStrNome($objSerieDTO->getStrNome(),InfraDTO::$OPER_IGUAL);
      $dto->setBolExclusaoLogica(false);
          
      $dto = $this->consultarRN0644($dto);
      if ($dto != NULL){
        if ($dto->getStrSinAtivo() == 'S')
          $objInfraException->adicionarValidacao('Existe outra ocorr�ncia de Tipo de Documento que utiliza o mesmo Nome.');
        else
          $objInfraException->adicionarValidacao('Existe ocorr�ncia inativa de Tipo de Documento que utiliza o mesmo Nome.');    	
      }
    }
  }

  private function validarStrDescricaoRN0789(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrDescricao())){
      //$objInfraException->adicionarValidacao('Descri��o n�o informada.');
      $objSerieDTO->setStrDescricao(null);
    }else{
      $objSerieDTO->setStrDescricao(trim($objSerieDTO->getStrDescricao()));
  
      if (strlen($objSerieDTO->getStrDescricao())>250){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
      }
    }
  }
 
  private function validarStrSinAtivoRN0794(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  private function validarNumIdModelo(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getNumIdModelo())){
    	if ($objSerieDTO->getStrStaAplicabilidade()==SerieRN::$TA_INTERNO_EXTERNO || $objSerieDTO->getStrStaAplicabilidade()==SerieRN::$TA_INTERNO){
    		$objInfraException->adicionarValidacao('Modelo para documentos internos n�o informado.');
    	}else{
        $objSerieDTO->setNumIdModelo(null);
    	}
    }
  }
  
  private function validarNumIdModeloEdocRN1140(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getNumIdModeloEdoc())){
      $objSerieDTO->setNumIdModeloEdoc(null);
    }
  }

  private function validarNumIdTipoFormulario(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getNumIdTipoFormulario())){
      if ($objSerieDTO->getStrStaAplicabilidade()==SerieRN::$TA_FORMULARIO){
        $objInfraException->adicionarValidacao('Formul�rio n�o informado.');
      }else{
        $objSerieDTO->setNumIdTipoFormulario(null);
      }
    }
  }

  private function validarStrSinInteressado(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinInteressado())){
      $objInfraException->adicionarValidacao('Sinalizador de aceite de Interessados n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinInteressado())){
        $objInfraException->adicionarValidacao('Sinalizador de aceite de Interessados inv�lido.');
      }
    }
  }

  private function validarStrSinDestinatario(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinDestinatario())){
      $objInfraException->adicionarValidacao('Sinalizador de aceite de Destinat�rios n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinDestinatario())){
        $objInfraException->adicionarValidacao('Sinalizador de aceite de Destinat�rios inv�lido.');
      }
    }
  }

  private function validarStrSinValorMonetario(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinValorMonetario())){
      $objInfraException->adicionarValidacao('Sinalizador de valor monet�rio n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinValorMonetario())){
        $objInfraException->adicionarValidacao('Sinalizador de valor monet�rio inv�lido.');
      }
    }
  }

  private function validarStrSinInterno(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinInterno())){
      $objInfraException->adicionarValidacao('Sinalizador de tipo de documento interno n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinInterno())){
        $objInfraException->adicionarValidacao('Sinalizador de tipo de documento interno inv�lido.');
      }
    }
  }

  private function validarStrSinAssinaturaPublicacao(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrSinAssinaturaPublicacao())){
      $objInfraException->adicionarValidacao('Sinalizador de assinatura para publica��o n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objSerieDTO->getStrSinAssinaturaPublicacao())){
        $objInfraException->adicionarValidacao('Sinalizador de assinatura para publica��o inv�lido.');
      }
    }
  }
  
  private function validarStrStaNumeracao(SerieDTO $objSerieDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objSerieDTO->getStrStaNumeracao())){
      $objInfraException->adicionarValidacao('Tipo de Numera��o n�o informado.');
    }else{
      $objSerieDTO->setStrStaNumeracao(trim($objSerieDTO->getStrStaNumeracao()));
      
      if (!in_array($objSerieDTO->getStrStaNumeracao(),InfraArray::converterArrInfraDTO($this->listarTiposNumeracaoRN0795(),'StaTipo'))){
      	$objInfraException->adicionarValidacao('Tipo de Numera��o inv�lido.');
      }
    }
  }
  
  private function validarStrStaAplicabilidade(SerieDTO $objSerieDTO, InfraException $objInfraException){
  	if (InfraString::isBolVazia($objSerieDTO->getStrStaAplicabilidade())){
  		$objInfraException->adicionarValidacao('Tipo de Aplicabilidade n�o informado.');
  	}else{
  		$objSerieDTO->setStrStaAplicabilidade(trim($objSerieDTO->getStrStaAplicabilidade()));

  		if (!in_array($objSerieDTO->getStrStaAplicabilidade(),InfraArray::converterArrInfraDTO($this->listarTiposAplicabilidade(),'StaTipo'))){
  			$objInfraException->adicionarValidacao('Tipo de Aplicabilidade inv�lido.');
  		}
  	}
  }

  private function validarArrObjRelSerieAssuntoDTO(SerieDTO $objSerieDTO, InfraException $objInfraException){
    //
  }

  private function validarArrObjSerieRestricaoDTO(SerieDTO $objSerieDTO, InfraException $objInfraException){
    $arrObjSerieRestricaoDTO = $objSerieDTO->getArrObjSerieRestricaoDTO();

    $objUnidadeRN = new UnidadeRN();

    $numRestricoes = InfraArray::contar($arrObjSerieRestricaoDTO);

    for($i=0; $i<$numRestricoes; $i++){

      $objSerieRestricaoDTO = $arrObjSerieRestricaoDTO[$i];

      if (InfraString::isBolVazia($objSerieRestricaoDTO->getNumIdOrgao())){
        $objInfraException->lancarValidacao('�rg�o da restri��o n�o informado.');
      }

      if (InfraString::isBolVazia($objSerieRestricaoDTO->getNumIdUnidade())){

        $objSerieRestricaoDTO->setNumIdUnidade(null);

        //se a unidade � nula s� pode haver um registro para o orgao nas restricoes
        for($j=0;$j<$numRestricoes;$j++){
          if ($j!=$i && $arrObjSerieRestricaoDTO[$j]->getNumIdOrgao()==$objSerieRestricaoDTO->getNumIdOrgao()){
            throw new InfraException('Falha na montagem das restri��es.');
          }
        }

      }else{
        $objUnidadeDTO = new UnidadeDTO();
        $objUnidadeDTO->setBolExclusaoLogica(false);
        $objUnidadeDTO->retNumIdUnidade();
        $objUnidadeDTO->retNumIdOrgao();
        $objUnidadeDTO->retStrSigla();
        $objUnidadeDTO->retStrSiglaOrgao();
        $objUnidadeDTO->setNumIdUnidade($objSerieRestricaoDTO->getNumIdUnidade());

        $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

        if ($objUnidadeDTO==null){
          throw new InfraException('Unidade da restri��o ['.$objSerieRestricaoDTO->getNumIdUnidade().'] n�o encontrada.');
        }

        if ($objUnidadeDTO->getNumIdOrgao()!=$objSerieRestricaoDTO->getNumIdOrgao()){
          throw new InfraException('�rg�o da unidade '.$objUnidadeDTO->getStrSigla().'/'.$objUnidadeDTO->getStrSiglaOrgao().' n�o � igual ao �rg�o da restri��o.');
        }
      }
    }
  }

  private function validarArrObjRelSerieVeiculoPublicacaoDTO(SerieDTO $objSerieDTO, InfraException $objInfraException){
    //
  }

  protected function listarNaoLiberadosNaUnidadeConectado(){

    try{

      $strCache = 'SEI_TDNL_'.CacheSEI::getInstance()->getAtributoVersao('SEI_TDNL').'_'.SessaoSEI::getInstance()->getNumIdUnidadeAtual();

      $arrCache = CacheSEI::getInstance()->getAtributo($strCache);

      if ($arrCache == null) {

        $objSerieRestricaoDTO = new SerieRestricaoDTO();
        $objSerieRestricaoDTO->retNumIdSerie();
        $objSerieRestricaoDTO->retNumIdOrgao();
        $objSerieRestricaoDTO->retNumIdUnidade();

        $objSerieRestricaoRN = new SerieRestricaoRN();
        $arrObjSerieRestricaoDTO = InfraArray::indexarArrInfraDTO($objSerieRestricaoRN->listar($objSerieRestricaoDTO), 'IdSerie', true);

        $numIdOrgao = SessaoSEI::getInstance()->getNumIdOrgaoUnidadeAtual();
        $numIdUnidade = SessaoSEI::getInstance()->getNumIdUnidadeAtual();

        $arrCache = array();
        foreach ($arrObjSerieRestricaoDTO as $numIdSerie => $arrRestricoesTipo) {
          $bolPermitido = false;
          foreach ($arrRestricoesTipo as $objRestricao) {
            if ($objRestricao->getNumIdOrgao() == $numIdOrgao && ($objRestricao->getNumIdUnidade() == null || $objRestricao->getNumIdUnidade() == $numIdUnidade)) {
              $bolPermitido = true;
            }
          }
          if (!$bolPermitido) {
            $arrCache[] = $numIdSerie;
          }
        }

        CacheSEI::getInstance()->setAtributo($strCache, $arrCache, CacheSEI::getInstance()->getNumTempo());
      }

      return InfraArray::gerarArrInfraDTO('SerieDTO','IdSerie',$arrCache);

    }catch(Exception $e){
      throw new InfraException('Erro verificando tipos de documentos n�o liberados para a unidade.', $e);
    }
  }

  protected function listarTiposUnidadeConectado(SerieDTO $parObjSerieDTO){
    try{

      $arrIdSerieNaoLiberados = InfraArray::converterArrInfraDTO($this->listarNaoLiberadosNaUnidade(),'IdSerie');
      $arrIdSerieUnidade = array();

      if ($parObjSerieDTO->getStrSinSomenteUtilizados()=='S'){

        $objSerieEscolhaDTO = new SerieEscolhaDTO();
        $objSerieEscolhaDTO->retNumIdSerie();
        $objSerieEscolhaDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

        if (InfraArray::contar($arrIdSerieNaoLiberados)){
          $objSerieEscolhaDTO->setNumIdSerie($arrIdSerieNaoLiberados, InfraDTO::$OPER_NOT_IN);
        }

        $objSerieEscolhaRN = new SerieEscolhaRN();
        $arrIdSerieUnidade = InfraArray::converterArrInfraDTO($objSerieEscolhaRN->listar($objSerieEscolhaDTO),'IdSerie');

        if (count($arrIdSerieUnidade)==0){
          return array();
        }
      }

      $objSerieDTO = new SerieDTO();
      $objSerieDTO->retNumIdSerie();
      $objSerieDTO->retStrNome();
      $objSerieDTO->retStrStaAplicabilidade();

      $objSerieDTO->setStrSinInterno('N');
      $objSerieDTO->setStrStaAplicabilidade(SerieRN::$TA_EXTERNO,InfraDTO::$OPER_DIFERENTE);

      if (InfraArray::contar($arrIdSerieUnidade)){
        $objSerieDTO->setNumIdSerie($arrIdSerieUnidade, InfraDTO::$OPER_IN);
      }else if (InfraArray::contar($arrIdSerieNaoLiberados)){
        $objSerieDTO->setNumIdSerie($arrIdSerieNaoLiberados, InfraDTO::$OPER_NOT_IN);
      }

      $objSerieDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

      $ret = $this->listarRN0646($objSerieDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando tipos de documento da unidade.', $e);
    }
  }
}
?>