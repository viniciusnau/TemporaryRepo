<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class IndexacaoRN extends InfraRN {

  public static $TO_PROTOCOLO_METADADOS = '1';
  public static $TO_PROTOCOLO_METADADOS_E_CONTEUDO = '2';
  public static $TO_PROTOCOLO_ACESSO = '3';
  public static $TO_PROTOCOLO_ASSINATURA = '4';
  public static $TO_PROCESSO_COM_DOCUMENTOS_METADADOS = '5';
  public static $TO_PROCESSO_COM_DOCUMENTOS_METADADOS_E_CONTEUDO = '6';
  public static $TO_PROCESSO_COM_DOCUMENTOS_ACESSO = '7';
  public static $TO_PROCESSO_COM_DOCUMENTOS_TRAMITACAO = '8';
  public static $TO_PUBLICACAO = '9';
  public static $TO_BASE_CONHECIMENTO_LIBERAR = '10';
  public static $TO_BASE_CONHECIMENTO_CANCELAR_LIBERACAO = '11';
  
  public static $TAI_PUBLICO = 'P';
  public static $TAI_RESTRITO = 'R';

  public function __construct(){
    parent::__construct(); 
  }

 	protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function montarAssinantes($arrIdDocumentos){
    try {

      $arrRet = array();

      $objAssinaturaDTO = new AssinaturaDTO();
      $objAssinaturaDTO->retDblIdDocumento();
      $objAssinaturaDTO->retNumIdUsuario();
      $objAssinaturaDTO->setDblIdDocumento($arrIdDocumentos, InfraDTO::$OPER_IN);

      $objAssinaturaRN = new AssinaturaRN();
      $arrObjAssinaturaDTOTodos = InfraArray::indexarArrInfraDTO($objAssinaturaRN->listarRN1323($objAssinaturaDTO), 'IdDocumento', true);

      foreach($arrIdDocumentos as $dblIdDocumento) {

        $strIdAssinante = '';
        if (isset($arrObjAssinaturaDTOTodos[$dblIdDocumento])) {
          foreach ($arrObjAssinaturaDTOTodos[$dblIdDocumento] as $objAssinaturaDTO) {
            $strIdAssinante .= $objAssinaturaDTO->getNumIdUsuario() . ';';
          }
          if ($strIdAssinante != '') {
            $strIdAssinante = ';' . $strIdAssinante;
          }
        }

        if ($strIdAssinante==''){
          $strIdAssinante = 'NULL';
        }

        $arrRet[$dblIdDocumento] = $strIdAssinante;
      }

      return $arrRet;

    }catch (Exception $e){
      throw new InfraException('Erro montando assinantes.',$e);
    }
  }

  private function montarUnidadesAcesso(&$arrIdUnidadesAcesso, $arrIdProcedimentos){
    try {

      $arrTemp = array_diff($arrIdProcedimentos, array_keys($arrIdUnidadesAcesso));

      if (count($arrTemp)) {
        $objAcessoDTO = new AcessoDTO();
        $objAcessoDTO->setDistinct(true);
        $objAcessoDTO->retDblIdProtocolo();
        $objAcessoDTO->retNumIdUnidade();
        $objAcessoDTO->retStrStaTipo();
        $objAcessoDTO->setDblIdProtocolo($arrTemp, InfraDTO::$OPER_IN);
        $objAcessoDTO->setStrStaTipo(array(AcessoRN::$TA_RESTRITO_UNIDADE, AcessoRN::$TA_CONTROLE_INTERNO), InfraDTO::$OPER_IN);

        $objAcessoRN = new AcessoRN();
        $arrObjAcessoDTO = InfraArray::indexarArrInfraDTO($objAcessoRN->listar($objAcessoDTO), 'IdProtocolo', true);

        foreach ($arrTemp as $dblIdProcedimento) {
          $strIdUnidadeAcesso = 'NULL';

          if (isset($arrObjAcessoDTO[$dblIdProcedimento])) {

            $arrAcessoRestritoUnidade = array();
            $arrAcessoControleInterno = array();

            foreach ($arrObjAcessoDTO[$dblIdProcedimento] as $objAcessoDTO) {
              if ($objAcessoDTO->getStrStaTipo() == AcessoRN::$TA_RESTRITO_UNIDADE) {
                $arrAcessoRestritoUnidade[] = $objAcessoDTO->getNumIdUnidade();
              } else {
                $arrAcessoControleInterno[] = $objAcessoDTO->getNumIdUnidade();
              }
            }
            if (count($arrAcessoRestritoUnidade) || count($arrAcessoControleInterno)) {
              $strIdUnidadeAcesso = ';'.implode(';', array_unique(array_merge($arrAcessoRestritoUnidade, $arrAcessoControleInterno))).';';
            }

          }
          $arrIdUnidadesAcesso[$dblIdProcedimento] = $strIdUnidadeAcesso;
        }
      }

    }catch (Exception $e){
      throw new InfraException('Erro montando unidades de acesso.',$e);
    }
  }

  private function montarUnidadesTramitacao(&$arrIdUnidadesTramitacao, $arrIdProcedimentos){
    try {

      $arrTemp = array_diff($arrIdProcedimentos, array_keys($arrIdUnidadesTramitacao));

      if (count($arrTemp)) {
        $objAtividadeDTO = new AtividadeDTO();
        $objAtividadeDTO->setDistinct(true);
        $objAtividadeDTO->retDblIdProtocolo();
        $objAtividadeDTO->retNumIdUnidade();
        $objAtividadeDTO->setDblIdProtocolo($arrTemp, InfraDTO::$OPER_IN);
        $objAtividadeDTO->setNumIdTarefa(array(TarefaRN::$TI_GERACAO_PROCEDIMENTO, TarefaRN::$TI_PROCESSO_REMETIDO_UNIDADE), InfraDTO::$OPER_IN);

        $objAtividadeRN = new AtividadeRN();
        $arrObjAtividadeDTOTodos = InfraArray::indexarArrInfraDTO($objAtividadeRN->listarRN0036($objAtividadeDTO), 'IdProtocolo', true);

        foreach ($arrTemp as $dblIdProcedimento) {
          $strIdUnidadeTramitacao = '';
          if (isset($arrObjAtividadeDTOTodos[$dblIdProcedimento])) {
            foreach ($arrObjAtividadeDTOTodos[$dblIdProcedimento] as $objAtividadeDTO) {
              $strIdUnidadeTramitacao .= $objAtividadeDTO->getNumIdUnidade().';';
            }
            if ($strIdUnidadeTramitacao != '') {
              $strIdUnidadeTramitacao = ';'.$strIdUnidadeTramitacao;
            }
          }

          if ($strIdUnidadeTramitacao == '') {
            $strIdUnidadeTramitacao = 'NULL';
          }

          $arrIdUnidadesTramitacao[$dblIdProcedimento] = $strIdUnidadeTramitacao;
        }
      }

    }catch (Exception $e){
      throw new InfraException('Erro montando unidades de tramita��o.',$e);
    }
  }

  protected function indexarProtocoloConectado(IndexacaoDTO $parObjIndexacaoDTO){
  	
  	try {

      LimiteSEI::getInstance()->configurarNivel2();

      if (FeedSEIProtocolos::getInstance()->isBolIgnorarFeeds()){
        return;
      }

      $strStaOperacao = $parObjIndexacaoDTO->getStrStaOperacao();
      $arrIdProtocolos = $parObjIndexacaoDTO->getArrIdProtocolos();

     	if (InfraArray::contar($arrIdProtocolos)){

        $bolAcesso = ($strStaOperacao == IndexacaoRN::$TO_PROTOCOLO_ACESSO || $strStaOperacao == IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_ACESSO);
        $bolTramitacao = ($strStaOperacao == IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_TRAMITACAO);
        $bolAssinatura = ($strStaOperacao == IndexacaoRN::$TO_PROTOCOLO_ASSINATURA);
        $bolCompleto = !$bolAcesso && !$bolTramitacao && !$bolAssinatura;
        $bolConteudo = ($strStaOperacao == IndexacaoRN::$TO_PROTOCOLO_METADADOS_E_CONTEUDO || $strStaOperacao == IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_METADADOS_E_CONTEUDO);

        $objRelProtocoloProtocoloRN	= new RelProtocoloProtocoloRN();

	  		if ($strStaOperacao==IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_METADADOS ||
            $strStaOperacao==IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_METADADOS_E_CONTEUDO ||
            $strStaOperacao==IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_ACESSO ||
            $strStaOperacao==IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_TRAMITACAO) {

          //buscar processos anexados
          $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
          $objRelProtocoloProtocoloDTO->retDblIdProtocolo2();
          $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);
          $objRelProtocoloProtocoloDTO->setDblIdProtocolo1($arrIdProtocolos, InfraDTO::$OPER_IN);
          $arrIdProtocolos = array_merge($arrIdProtocolos, InfraArray::converterArrInfraDTO($objRelProtocoloProtocoloRN->listarRN0187($objRelProtocoloProtocoloDTO), 'IdProtocolo2'));

          //buscar documentos dos processos
	      	$objRelProtocoloProtocoloDTO 	= new RelProtocoloProtocoloDTO();
	      	$objRelProtocoloProtocoloDTO->retDblIdProtocolo2();
	      	$objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO);
	      	$objRelProtocoloProtocoloDTO->setDblIdProtocolo1($arrIdProtocolos, InfraDTO::$OPER_IN);
	      	$arrIdDocumentos = InfraArray::converterArrInfraDTO($objRelProtocoloProtocoloRN->listarRN0187($objRelProtocoloProtocoloDTO),'IdProtocolo2');

        }else{
          $arrIdDocumentos = array();
        }

        $arrPaginacao = array_chunk(array_merge($arrIdProtocolos, $arrIdDocumentos), 500);

        $arrIdProtocolosRemocao = array();
        $arrIdUnidadesAcesso = array();
        $arrIdUnidadesTramitacao = array();

        $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
        $numIdSerieOuvidoria = $objInfraParametro->getValor('ID_SERIE_OUVIDORIA');


        $objProtocoloDTOIdx = new ProtocoloDTO();
        $objProtocoloDTOIdx->retDblIdProtocolo();
        $objProtocoloDTOIdx->retStrStaProtocolo();
        $objProtocoloDTOIdx->retStrStaNivelAcessoGlobal();
        $objProtocoloDTOIdx->retStrStaNivelAcessoLocal();
        $objProtocoloDTOIdx->retStrStaEstado();
        $objProtocoloDTOIdx->retStrSinEliminado();
        $objProtocoloDTOIdx->retStrStaDocumentoDocumento();
        $objProtocoloDTOIdx->retNumIdSerieDocumento();
        $objProtocoloDTOIdx->retNumIdUnidadeGeradora();
        $objProtocoloDTOIdx->retDblIdProcedimentoDocumento();

        if ($bolCompleto) {
          $objProtocoloDTOIdx->retNumIdTipoProcedimentoProcedimento();
          $objProtocoloDTOIdx->retNumIdTipoProcedimentoDocumento();
          $objProtocoloDTOIdx->retStrDescricao();
          $objProtocoloDTOIdx->retStrProtocoloFormatado();
          $objProtocoloDTOIdx->retStrProtocoloFormatadoPesquisa();
          $objProtocoloDTOIdx->retNumIdUsuarioGerador();
          $objProtocoloDTOIdx->retStrNumeroDocumento();
          $objProtocoloDTOIdx->retStrNomeArvoreDocumento();
          $objProtocoloDTOIdx->retDinValorDocumento();
          $objProtocoloDTOIdx->retDtaGeracao();
          $objProtocoloDTOIdx->retNumIdOrgaoUnidadeGeradora();
          $objProtocoloDTOIdx->retStrProtocoloFormatadoProcedimentoDocumento();
          $objProtocoloDTOIdx->retDblIdProcedimentoDocumento();
          $objProtocoloDTOIdx->retDtaInclusao();
        }

        if ($bolConteudo) {
          $objProtocoloDTOIdx->retStrConteudoDocumento();
        }

        $objProtocoloRN = new ProtocoloRN();

        $objDocumentoRN = new DocumentoRN();

        $objObservacaoDTOIdx = new ObservacaoDTO();
        $objObservacaoDTOIdx->retDblIdProtocolo();
        $objObservacaoDTOIdx->retNumIdUnidade();
        $objObservacaoDTOIdx->retStrDescricao();

        $objObservacaoRN = new ObservacaoRN();

        $objRelProtocoloAssuntoDTOIdx = new RelProtocoloAssuntoDTO();
        $objRelProtocoloAssuntoDTOIdx->retDblIdProtocolo();
        $objRelProtocoloAssuntoDTOIdx->retNumIdAssuntoProxy();

        $objRelProtocoloAssuntoRN = new RelProtocoloAssuntoRN();

        $objParticipanteDTOIdx = new ParticipanteDTO();
        $objParticipanteDTOIdx->retDblIdProtocolo();
        $objParticipanteDTOIdx->retNumIdContato();
        $objParticipanteDTOIdx->retStrStaParticipacao();
        $objParticipanteDTOIdx->setStrStaParticipacao(array(ParticipanteRN::$TP_INTERESSADO, ParticipanteRN::$TP_REMETENTE, ParticipanteRN::$TP_DESTINATARIO), InfraDTO::$OPER_IN);

        $objParticipanteRN = new ParticipanteRN();

        $objPublicacaoDTOIdx = new PublicacaoDTO();
        $objPublicacaoDTOIdx->retDblIdDocumento();
        $objPublicacaoDTOIdx->retStrStaEstado();

        $objPublicacaoRN = new PublicacaoRN();

        $objAnexoDTOIdx = new AnexoDTO();
        $objAnexoDTOIdx->retNumIdAnexo();
        $objAnexoDTOIdx->retDblIdProtocolo();
        $objAnexoDTOIdx->retStrNome();
        $objAnexoDTOIdx->retDthInclusao();

        $objAnexoRN = new AnexoRN();

        foreach($arrPaginacao as $arrIdProtocolos) {

          $objProtocoloDTOIdx->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);

          $arrObjProtocoloDTO = $objProtocoloRN->listarRN0668($objProtocoloDTOIdx);

          $arrIdProcedimentos = array();
          $arrIdDocumentosGerados = array();
          $arrIdDocumentosRecebidos = array();

          foreach ($arrObjProtocoloDTO as $objProtocoloDTO) {

            $strStaProtocolo = $objProtocoloDTO->getStrStaProtocolo();

            if ($strStaProtocolo == ProtocoloRN::$TP_PROCEDIMENTO) {

              $arrIdProcedimentos[$objProtocoloDTO->getDblIdProtocolo()] = true;

            } else if ($strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_GERADO || $strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO) {

              $arrIdProcedimentos[$objProtocoloDTO->getDblIdProcedimentoDocumento()] = true;

              if ($strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_GERADO) {
                $arrIdDocumentosGerados[] = $objProtocoloDTO->getDblIdProtocolo();
              }

              if ($strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO){
                $arrIdDocumentosRecebidos[] = $objProtocoloDTO->getDblIdProtocolo();
              }
            }
          }

          $arrIdProcedimentos = array_keys($arrIdProcedimentos);

          if ($bolCompleto) {

            $objObservacaoDTOIdx->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);
            $arrObservacaoDTO = InfraArray::indexarArrInfraDTO($objObservacaoRN->listarRN0219($objObservacaoDTOIdx), 'IdProtocolo', true);

            $objRelProtocoloAssuntoDTOIdx->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);
            $arrRelProtocoloAssuntoDTO = InfraArray::indexarArrInfraDTO($objRelProtocoloAssuntoRN->listarRN0188($objRelProtocoloAssuntoDTOIdx), 'IdProtocolo', true);

            $objParticipanteDTOIdx->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);
            $arrObjParticipanteDTO = InfraArray::indexarArrInfraDTO($objParticipanteRN->listarRN0189($objParticipanteDTOIdx), 'IdProtocolo', true);
          }

          if (count($arrIdDocumentosGerados) || count($arrIdDocumentosRecebidos)) {
            $arrIdAssinaturas = $this->montarAssinantes(array_merge($arrIdDocumentosGerados, $arrIdDocumentosRecebidos));
          }

          if (count($arrIdDocumentosGerados)) {

            $objPublicacaoDTOIdx->setDblIdDocumento($arrIdDocumentosGerados, InfraDTO::$OPER_IN);
            $arrObjPublicacaoDTO = InfraArray::indexarArrInfraDTO($objPublicacaoRN->listarRN1045($objPublicacaoDTOIdx), 'IdDocumento');

            foreach ($arrObjProtocoloDTO as $objProtocoloDTO) {
              //se o documento gerado tem registro de publicacao
              if (isset($arrObjPublicacaoDTO[$objProtocoloDTO->getDblIdProtocolo()]) && $arrObjPublicacaoDTO[$objProtocoloDTO->getDblIdProtocolo()]->getStrStaEstado() == PublicacaoRN::$TE_PUBLICADO) {
                $objProtocoloDTO->setStrSinPublicado('S');
              } else {
                $objProtocoloDTO->setStrSinPublicado('N');
              }
            }
          }

          $arrObjAnexoDTO = array();
          if (count($arrIdDocumentosRecebidos)){
            $objAnexoDTOIdx->setDblIdProtocolo($arrIdDocumentosRecebidos, InfraDTO::$OPER_IN);
            $arrObjAnexoDTO = InfraArray::indexarArrInfraDTO($objAnexoRN->listarRN0218($objAnexoDTOIdx),'IdProtocolo');
          }

          $this->montarUnidadesAcesso($arrIdUnidadesAcesso, $arrIdProcedimentos);

          if ($bolCompleto || $bolTramitacao) {
            $this->montarUnidadesTramitacao($arrIdUnidadesTramitacao, $arrIdProcedimentos);
          }

          foreach ($arrObjProtocoloDTO as $objProtocoloDTO) {

            //sigilosos, cancelados ou eliminados nao devem ser indexados
            if ($objProtocoloDTO->getStrStaNivelAcessoGlobal() == ProtocoloRN::$NA_SIGILOSO ||
              $objProtocoloDTO->getStrStaEstado() == ProtocoloRN::$TE_DOCUMENTO_CANCELADO ||
              $objProtocoloDTO->getStrSinEliminado() == 'S') {
              $arrIdProtocolosRemocao[] = $objProtocoloDTO->getDblIdProtocolo();
              continue;
            }

            $dblIdProtocolo = $objProtocoloDTO->getDblIdProtocolo();
            $strStaProtocolo = $objProtocoloDTO->getStrStaProtocolo();
            $strStaDocumentoDocumento = $objProtocoloDTO->getStrStaDocumentoDocumento();

            $arrFormatadoFeed = array();

            if ($bolCompleto) {

              $arrFormatadoFeed['id_prot'] = $objProtocoloDTO->getDblIdProtocolo();
              $arrFormatadoFeed['desc'] = $objProtocoloDTO->getStrDescricao();
              $arrFormatadoFeed['id_org_ger'] = $objProtocoloDTO->getNumIdOrgaoUnidadeGeradora();
              $arrFormatadoFeed['id_uni_ger'] = $objProtocoloDTO->getNumIdUnidadeGeradora();
              $arrFormatadoFeed['prot_pesq'] = $objProtocoloDTO->getStrProtocoloFormatadoPesquisa();
              $arrFormatadoFeed['id_serie'] = $objProtocoloDTO->getNumIdSerieDocumento();
              $arrFormatadoFeed['dta_ger'] = $objProtocoloDTO->getDtaGeracao();
              $arrFormatadoFeed['dta_inc'] = $objProtocoloDTO->getDtaInclusao();
              $arrFormatadoFeed['id_usu_ger'] = $objProtocoloDTO->getNumIdUsuarioGerador();
              $arrFormatadoFeed['sta_prot'] = $strStaProtocolo;
              $arrFormatadoFeed['numero'] = $objProtocoloDTO->getStrNumeroDocumento();
              $arrFormatadoFeed['nome_arvore'] = $objProtocoloDTO->getStrNomeArvoreDocumento();
              $arrFormatadoFeed['aux1'] = SeiINT::formatarDinIndexacao($objProtocoloDTO->getDinValorDocumento());
              $arrFormatadoFeed['aux2'] = $objProtocoloDTO->getStrStaNivelAcessoLocal();

              $strIdInteressado = '';
              $strIdRemetente = '';
              $strIdDestinatario = '';
              if (isset($arrObjParticipanteDTO[$dblIdProtocolo])) {

                foreach ($arrObjParticipanteDTO[$dblIdProtocolo] as $objParticipanteDTO) {

                  switch ($objParticipanteDTO->getStrStaParticipacao()) {
                    case ParticipanteRN::$TP_INTERESSADO:
                      $strIdInteressado .= $objParticipanteDTO->getNumIdContato().';';
                      break;

                    case ParticipanteRN::$TP_REMETENTE:
                      $strIdRemetente .= $objParticipanteDTO->getNumIdContato().';';
                      break;

                    case ParticipanteRN::$TP_DESTINATARIO:
                      $strIdDestinatario .= $objParticipanteDTO->getNumIdContato().';';
                      break;
                  }
                }

                if ($strIdInteressado != '') {
                  $strIdInteressado = ';'.$strIdInteressado;
                }
                if ($strIdRemetente != '') {
                  $strIdRemetente = ';'.$strIdRemetente;
                }
                if ($strIdDestinatario != '') {
                  $strIdDestinatario = ';'.$strIdDestinatario;
                }
              }

              if ($strIdInteressado == '') {
                $strIdInteressado = 'NULL';
              }

              if ($strIdRemetente == '') {
                $strIdRemetente = 'NULL';
              }

              if ($strIdDestinatario == '') {
                $strIdDestinatario = 'NULL';
              }

              $arrFormatadoFeed['id_int'] = $strIdInteressado;
              $arrFormatadoFeed['id_rem'] = $strIdRemetente;
              $arrFormatadoFeed['id_dest'] = $strIdDestinatario;

              if (isset($arrObservacaoDTO[$dblIdProtocolo])) {
                foreach ($arrObservacaoDTO[$dblIdProtocolo] as $objObservacaoDTO) {
                  $arrFormatadoFeed['obs_'.$objObservacaoDTO->getNumIdUnidade()] = $objObservacaoDTO->getStrDescricao();
                }
              }

              $strProtocoloAssunto = '';
              if (isset($arrRelProtocoloAssuntoDTO[$dblIdProtocolo])) {
                foreach ($arrRelProtocoloAssuntoDTO[$dblIdProtocolo] as $objRelProtocoloAssuntoDTO) {
                  $strProtocoloAssunto .= $objRelProtocoloAssuntoDTO->getNumIdAssuntoProxy().';';
                }
                if ($strProtocoloAssunto != '') {
                  $strProtocoloAssunto = ';'.$strProtocoloAssunto;
                }
              }

              if ($strProtocoloAssunto == '') {
                $strProtocoloAssunto = 'NULL';
              }

              $arrFormatadoFeed['id_assun'] = $strProtocoloAssunto;

            }

            if ($bolCompleto || $bolAssinatura){
              if ($strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_GERADO || $strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO) {
                $arrFormatadoFeed['id_assin'] = $arrIdAssinaturas[$dblIdProtocolo];
              }
            }

            //se documento interno sem assinatura ou formulario da ouvidoria entao deixar apenas para a unidade geradora
            if ((($strStaDocumentoDocumento == DocumentoRN::$TD_EDITOR_INTERNO ||
                  $strStaDocumentoDocumento == DocumentoRN::$TD_FORMULARIO_GERADO ||
                  $strStaDocumentoDocumento == DocumentoRN::$TD_EDITOR_EDOC) && $arrIdAssinaturas[$dblIdProtocolo] == 'NULL')
              ||
              ($strStaDocumentoDocumento == DocumentoRN::$TD_FORMULARIO_AUTOMATICO && $objProtocoloDTO->getNumIdSerieDocumento() == $numIdSerieOuvidoria)) {

              $arrFormatadoFeed['id_uni_aces'] = ';'.$objProtocoloDTO->getNumIdUnidadeGeradora().';';
              $arrFormatadoFeed['tipo_aces_g'] = self::$TAI_RESTRITO;

            } else {

              if ($strStaProtocolo == ProtocoloRN::$TP_PROCEDIMENTO) {
                $arrFormatadoFeed['id_uni_aces'] = $arrIdUnidadesAcesso[$dblIdProtocolo];
              } else {
                $arrFormatadoFeed['id_uni_aces'] = $arrIdUnidadesAcesso[$objProtocoloDTO->getDblIdProcedimentoDocumento()];
              }

              if ($objProtocoloDTO->getStrStaNivelAcessoGlobal() == ProtocoloRN::$NA_PUBLICO || ($strStaProtocolo == ProtocoloRN::$TP_DOCUMENTO_GERADO && $objProtocoloDTO->getStrSinPublicado() == 'S')) {
                $arrFormatadoFeed['tipo_aces_g'] = self::$TAI_PUBLICO;
              } else {
                $arrFormatadoFeed['tipo_aces_g'] = self::$TAI_RESTRITO;
              }
            }


            switch ($strStaProtocolo) {

              case ProtocoloRN::$TP_PROCEDIMENTO:

                if ($bolCompleto) {
                  $arrFormatadoFeed['id_proc'] = $objProtocoloDTO->getDblIdProtocolo();
                  $arrFormatadoFeed['id_doc'] = null;
                  $arrFormatadoFeed['id_anexo'] = null;
                  $arrFormatadoFeed['id_tipo_proc'] = $objProtocoloDTO->getNumIdTipoProcedimentoProcedimento();
                  $arrFormatadoFeed['prot_proc'] = $objProtocoloDTO->getStrProtocoloFormatado();
                  $arrFormatadoFeed['prot_doc'] = null;
                }

                if ($bolCompleto || $bolTramitacao) {
                  $arrFormatadoFeed['id_uni_tram'] = $arrIdUnidadesTramitacao[$objProtocoloDTO->getDblIdProtocolo()];
                }

                $objInfraFeedDTO = new InfraFeedDTO();
                $objInfraFeedDTO->setStrUrl('P'.$objProtocoloDTO->getDblIdProtocolo());
                $objInfraFeedDTO->setStrMimeType('text/plain');
                $objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
                $objInfraFeedDTO->setStrCaminhoArquivo(null);
                $objInfraFeedDTO->setBinConteudo(null);

                FeedSEIProtocolos::getInstance()->adicionarFeed($objInfraFeedDTO);

                break;

              case ProtocoloRN::$TP_DOCUMENTO_GERADO:

                if ($bolCompleto) {
                  $arrFormatadoFeed['id_proc'] = $objProtocoloDTO->getDblIdProcedimentoDocumento();
                  $arrFormatadoFeed['id_doc'] = $objProtocoloDTO->getDblIdProtocolo();
                  $arrFormatadoFeed['id_anexo'] = null;
                  $arrFormatadoFeed['id_tipo_proc'] = $objProtocoloDTO->getNumIdTipoProcedimentoDocumento();
                  $arrFormatadoFeed['prot_proc'] = $objProtocoloDTO->getStrProtocoloFormatadoProcedimentoDocumento();
                  $arrFormatadoFeed['prot_doc'] = $objProtocoloDTO->getStrProtocoloFormatado();
                }

                if ($bolCompleto || $bolTramitacao) {
                  $arrFormatadoFeed['id_uni_tram'] = $arrIdUnidadesTramitacao[$objProtocoloDTO->getDblIdProcedimentoDocumento()];
                }

                $objInfraFeedDTO = new InfraFeedDTO();
                $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo());
                $objInfraFeedDTO->setStrMimeType('text/html');
                $objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
                $objInfraFeedDTO->setStrCaminhoArquivo(null);

                if ($bolConteudo) {

                  if ($strStaDocumentoDocumento == DocumentoRN::$TD_FORMULARIO_AUTOMATICO) {
                    $objDocumentoDTO = new DocumentoDTO();
                    $objDocumentoDTO->setDblIdDocumento($objProtocoloDTO->getDblIdProtocolo());
                    $objProtocoloDTO->setStrConteudoDocumento($objDocumentoRN->consultarHtmlFormulario($objDocumentoDTO));
                  }

                  $objInfraFeedDTO->setBinConteudo(DocumentoINT::limparHtml($objProtocoloDTO->getStrConteudoDocumento()));

                } else {
                  $objInfraFeedDTO->setBinConteudo(null);
                }

                FeedSEIProtocolos::getInstance()->adicionarFeed($objInfraFeedDTO);

                break;

              case ProtocoloRN::$TP_DOCUMENTO_RECEBIDO:

                if ($bolCompleto) {
                  $arrFormatadoFeed['id_proc'] = $objProtocoloDTO->getDblIdProcedimentoDocumento();
                  $arrFormatadoFeed['id_doc'] = $objProtocoloDTO->getDblIdProtocolo();
                  $arrFormatadoFeed['id_anexo'] = null;
                  $arrFormatadoFeed['id_tipo_proc'] = $objProtocoloDTO->getNumIdTipoProcedimentoDocumento();
                  $arrFormatadoFeed['prot_proc'] = $objProtocoloDTO->getStrProtocoloFormatadoProcedimentoDocumento();
                  $arrFormatadoFeed['prot_doc'] = $objProtocoloDTO->getStrProtocoloFormatado();
                }

                if ($bolCompleto || $bolTramitacao) {
                  $arrFormatadoFeed['id_uni_tram'] = $arrIdUnidadesTramitacao[$objProtocoloDTO->getDblIdProcedimentoDocumento()];
                }

                $objInfraFeedDTO = new InfraFeedDTO();

                if (!isset($arrObjAnexoDTO[$objProtocoloDTO->getDblIdProtocolo()])) {
                  $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo());
                  $objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
                  $objInfraFeedDTO->setStrMimeType('text/plain');
                  $objInfraFeedDTO->setStrCaminhoArquivo(null);
                  $objInfraFeedDTO->setBinConteudo(null);
                } else {
                  $objAnexoDTO = $arrObjAnexoDTO[$objProtocoloDTO->getDblIdProtocolo()];
                  $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo().'-A'.$objAnexoDTO->getNumIdAnexo());

                  if ($bolCompleto) {
                    $arrFormatadoFeed['id_anexo'] = $objAnexoDTO->getNumIdAnexo();
                  }

                  $objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
                  $this->configurarIndexacaoAnexo($parObjIndexacaoDTO, $objInfraFeedDTO, $objAnexoDTO);
                }

                FeedSEIProtocolos::getInstance()->adicionarFeed($objInfraFeedDTO);
                break;
            }
          }

          FeedSEIProtocolos::getInstance()->indexarFeeds();

        }

	  		if (InfraArray::contar($arrIdProtocolosRemocao)){
	  		  $objIndexacaoDTO 	= new IndexacaoDTO();
	  		  $objIndexacaoDTO->setArrIdProtocolos($arrIdProtocolosRemocao);
	  		  
	  		  $objIndexacaoRN = new IndexacaoRN();
	  		  $objIndexacaoRN->prepararRemocaoProtocolo($objIndexacaoDTO);	  		  
	  		}
	  		
	  	  FeedSEIProtocolos::getInstance()->indexarFeeds();
	  	  
     	}

    }catch(Exception $e){
      LogSEI::getInstance()->gravar('Erro indexando protocolo.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro indexando protocolo.',$e);
    }  	
  }

  protected function indexarPublicacaoConectado(IndexacaoDTO $parObjIndexacaoDTO){

    try {

      LimiteSEI::getInstance()->configurarNivel2();

      $arrObjPublicacaoDTO = $parObjIndexacaoDTO->getArrObjPublicacaoDTO();

      if (InfraArray::contar($arrObjPublicacaoDTO)){

        $arrIdProtocolos = array();

        foreach($arrObjPublicacaoDTO as $objPublicacaoDTO){

          if (!$objPublicacaoDTO->isSetNumIdPublicacaoLegado()){
            $objPublicacaoDTO->setNumIdPublicacaoLegado(null);
          }

          if ($objPublicacaoDTO->getNumIdPublicacaoLegado()==null){
            $arrIdProtocolos[] = $objPublicacaoDTO->getDblIdDocumento();
          }

          $arrFormatadoFeed = array();

          $arrFormatadoFeed['id_pub'] = $objPublicacaoDTO->getNumIdPublicacao();
          $arrFormatadoFeed['id_pub_leg'] = $objPublicacaoDTO->getNumIdPublicacaoLegado();
          $arrFormatadoFeed['id_doc'] = $objPublicacaoDTO->getDblIdDocumento();
          $arrFormatadoFeed['id_proc'] = $objPublicacaoDTO->getDblIdProcedimentoDocumento();
          $arrFormatadoFeed['id_prot_agrup'] = $objPublicacaoDTO->getDblIdProtocoloAgrupadorProtocolo();
          $arrFormatadoFeed['id_org_resp'] = $objPublicacaoDTO->getNumIdOrgaoUnidadeResponsavelDocumento();
          $arrFormatadoFeed['id_uni_resp'] = $objPublicacaoDTO->getNumIdUnidadeResponsavelDocumento();
          $arrFormatadoFeed['id_serie'] = $objPublicacaoDTO->getNumIdSerieDocumento();
          $arrFormatadoFeed['numero'] = $objPublicacaoDTO->getStrNumeroDocumento();
          $arrFormatadoFeed['prot_proc'] 	= $objPublicacaoDTO->getStrProtocoloProcedimentoFormatado();
          $arrFormatadoFeed['prot_pesq']	= $objPublicacaoDTO->getStrProtocoloFormatadoPesquisaProtocolo();
          $arrFormatadoFeed['prot_doc'] 	= $objPublicacaoDTO->getStrProtocoloFormatadoProtocolo();

          $arrFormatadoFeed['dta_doc'] = $objPublicacaoDTO->getDtaGeracaoProtocolo();
          $arrFormatadoFeed['dta_pub'] = $objPublicacaoDTO->getDtaPublicacao();
          $arrFormatadoFeed['num_pub'] = $objPublicacaoDTO->getNumNumero();
          $arrFormatadoFeed['id_veic_pub'] = $objPublicacaoDTO->getNumIdVeiculoPublicacao();
          $arrFormatadoFeed['resumo'] = $objPublicacaoDTO->getStrResumo();
          $arrFormatadoFeed['id_veic_io'] = $objPublicacaoDTO->getNumIdVeiculoIO();
          $arrFormatadoFeed['dta_pub_io'] = $objPublicacaoDTO->getDtaPublicacaoIO();
          $arrFormatadoFeed['id_sec_io'] = $objPublicacaoDTO->getNumIdSecaoIO();
          $arrFormatadoFeed['pag_io'] = $objPublicacaoDTO->getStrPaginaIO();

          $objInfraFeedDTO = new InfraFeedDTO();

          if ($objPublicacaoDTO->getNumIdPublicacao()!=null){
            $strId = 'P'.$objPublicacaoDTO->getNumIdPublicacao();
          }else{
            $strId = 'L'.$objPublicacaoDTO->getNumIdPublicacaoLegado();
          }

          $objInfraFeedDTO->setStrUrl($strId);
          $objInfraFeedDTO->setStrMimeType('text/html');
          $objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
          $objInfraFeedDTO->setStrCaminhoArquivo(null);
          $objInfraFeedDTO->setBinConteudo(DocumentoINT::limparHtml($objPublicacaoDTO->getStrConteudoDocumento()));

          FeedSEIPublicacoes::getInstance()->adicionarFeed($objInfraFeedDTO);
        }

        FeedSEIPublicacoes::getInstance()->indexarFeeds();

        $objPublicacaoRN = new PublicacaoRN();
        $objPublicacaoRN->gravarCamposPesquisa($arrObjPublicacaoDTO);

        if (count($arrIdProtocolos)) {
          $objIndexacaoDTO = new IndexacaoDTO();
          $objIndexacaoDTO->setArrIdProtocolos($arrIdProtocolos);
          $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PROTOCOLO_METADADOS);

          $objIndexacaoRN = new IndexacaoRN();
          $objIndexacaoRN->indexarProtocolo($objIndexacaoDTO);
        }
      }

    }catch(Exception $e){
      LogSEI::getInstance()->gravar('Erro indexando publica��o.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro indexando publica��o.',$e);
    }
  }

  protected function indexarBaseConhecimentoConectado(IndexacaoDTO $objIndexacaoDTO){
  	
  	try {

      LimiteSEI::getInstance()->configurarNivel2();

  		$arrObjBaseConhecimentoDTO = $objIndexacaoDTO->getArrObjBaseConhecimentoDTO();
  		
  		if (InfraArray::contar($arrObjBaseConhecimentoDTO)){

		 		$objBaseConhecimentoRN = new BaseConhecimentoRN();
		 		
	  		foreach($arrObjBaseConhecimentoDTO as $parObjBaseConhecimentoDTO){
	  		
		 		  $objBaseConhecimentoDTO = new BaseConhecimentoDTO();
		 		  
			  	$objBaseConhecimentoDTO->retNumIdBaseConhecimento();
			  	$objBaseConhecimentoDTO->retStrDescricao();
			  	$objBaseConhecimentoDTO->retStrConteudo();
			  	$objBaseConhecimentoDTO->retNumIdUnidade();
					$objBaseConhecimentoDTO->retDthLiberacao();
					
			  	$objBaseConhecimentoDTO->setNumIdBaseConhecimento($parObjBaseConhecimentoDTO->getNumIdBaseConhecimento());
			  	
					$objBaseConhecimentoDTO = $objBaseConhecimentoRN->consultar($objBaseConhecimentoDTO);
			  	
		  	  $arrFormatadoFeed = array();
		  	  
		  	  $arrFormatadoFeed['id_bc'] = $objBaseConhecimentoDTO->getNumIdBaseConhecimento();
		  	  $arrFormatadoFeed['desc']	= $objBaseConhecimentoDTO->getStrDescricao();
		  	  $arrFormatadoFeed['id_uni'] = $objBaseConhecimentoDTO->getNumIdUnidade();
		  	  $arrFormatadoFeed['dta_ger'] = substr($objBaseConhecimentoDTO->getDthLiberacao(),0,10);
							  
					$objInfraFeedDTO = new InfraFeedDTO();
		  	  
		      $objInfraFeedDTO->setStrUrl('B'.$objBaseConhecimentoDTO->getNumIdBaseConhecimento());
		      $objInfraFeedDTO->setStrMimeType('text/html'); 
		  		$objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
		  		$objInfraFeedDTO->setStrCaminhoArquivo(null);
				  $objInfraFeedDTO->setBinConteudo(DocumentoINT::limparHtml($objBaseConhecimentoDTO->getStrConteudo()));
				  
					FeedSEIBasesConhecimento::getInstance()->adicionarFeed($objInfraFeedDTO);					
		  	  			
		  		// Monta os arrays de anexos da Base de Conhecimento (Se Houver)
		    	$objAnexoDTO=	new AnexoDTO();
		    	$objAnexoRN	= new AnexoRN();
		    	$objAnexoDTO->setNumIdBaseConhecimento($objBaseConhecimentoDTO->getNumIdBaseConhecimento());
		    	$objAnexoDTO->retNumIdAnexo();
		    	$objAnexoDTO->retStrNome();
		    	$objAnexoDTO->retDthInclusao();
		    	$arrAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);
		  			  	
		    	if (count($arrAnexoDTO) > 0){
		    		
			    	foreach ($arrAnexoDTO as $objAnexoDTO) {
		
			    		$objInfraFeedDTO = new InfraFeedDTO();  
							$objInfraFeedDTO->setStrUrl('B'.$objBaseConhecimentoDTO->getNumIdBaseConhecimento().'-A'.$objAnexoDTO->getNumIdAnexo());

							$arrFormatadoFeed['id_anexo'] 	= $objAnexoDTO->getNumIdAnexo();
							$arrFormatadoFeed['nome_anexo'] = $objAnexoDTO->getStrNome();
							$objInfraFeedDTO->setArrMetaTags($arrFormatadoFeed);
		  		  	
							$this->configurarIndexacaoAnexo($objIndexacaoDTO, $objInfraFeedDTO, $objAnexoDTO);
		    			
		    			FeedSEIBasesConhecimento::getInstance()->adicionarFeed($objInfraFeedDTO);	
		  	  	}
		    	}
	  		}
	  	  FeedSEIBasesConhecimento::getInstance()->indexarFeeds();
  		}	  	
    }catch(Exception $e){
      LogSEI::getInstance()->gravar('Erro indexando Base de Conhecimento.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro indexando Base de Conhecimento.',$e);
    }  	
  }

  protected function prepararRemocaoProtocoloConectado(IndexacaoDTO $objIndexacaoDTO){
  	try {

      if (FeedSEIProtocolos::getInstance()->isBolIgnorarFeeds()){
        return;
      }

  		$arrIdProtocolos = $objIndexacaoDTO->getArrIdProtocolos();
  		
  		if (InfraArray::contar($arrIdProtocolos)){
  			
	    	$objProtocoloDTO 	= new ProtocoloDTO();
	    	$objProtocoloDTO->retDblIdProtocolo();
	    	$objProtocoloDTO->retStrStaProtocolo();
	    	$objProtocoloDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_ASC);
	    	$objProtocoloDTO->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);
	    	
	    	$objProtocoloRN = new ProtocoloRN();
	    	$arrObjProtocoloDTO = $objProtocoloRN->listarRN0668($objProtocoloDTO);
	    	
	    	//pode j� ter sido exclu�do
	    	if (count($arrObjProtocoloDTO)){
		    	
		    	foreach ($arrObjProtocoloDTO as $objProtocoloDTO){
		    		
		    		switch ($objProtocoloDTO->getStrStaProtocolo()) {
		    			case ProtocoloRN::$TP_PROCEDIMENTO:
					  		$objInfraFeedDTO = new InfraFeedDTO();  
					      $objInfraFeedDTO->setStrUrl('P'.$objProtocoloDTO->getDblIdProtocolo());
								$objInfraFeedDTO->setStrMimeType('text/plain');
								$objInfraFeedDTO->setArrMetaTags(null);
								$objInfraFeedDTO->setBinConteudo(null);
					  		FeedSEIProtocolos::getInstance()->removerFeed($objInfraFeedDTO);
		    				break;
		    				
		    			case ProtocoloRN::$TP_DOCUMENTO_GERADO:
					  		$objInfraFeedDTO = new InfraFeedDTO();  
					      $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo());
								$objInfraFeedDTO->setStrMimeType('text/plain');
								$objInfraFeedDTO->setArrMetaTags(null);
								$objInfraFeedDTO->setBinConteudo(null);
					  		FeedSEIProtocolos::getInstance()->removerFeed($objInfraFeedDTO);
		    				break;
		    				
		    			case ProtocoloRN::$TP_DOCUMENTO_RECEBIDO:
					    	$objAnexoDTO =	new AnexoDTO();
					    	$objAnexoDTO->retNumIdAnexo();
					    	$objAnexoDTO->retStrNome();
					    	$objAnexoDTO->setDblIdProtocolo($objProtocoloDTO->getDblIdProtocolo());
					
					    	$objAnexoRN = new AnexoRN();
					    	$arrAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);
					    	
					    	if (count($arrAnexoDTO)==0){
						  		$objInfraFeedDTO = new InfraFeedDTO();  
						      $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo());
									$objInfraFeedDTO->setStrMimeType('text/plain');
									$objInfraFeedDTO->setArrMetaTags(null);
									$objInfraFeedDTO->setBinConteudo(null);
						  		FeedSEIProtocolos::getInstance()->removerFeed($objInfraFeedDTO);
						  		
					    	}else{
					    	
						    	foreach ($arrAnexoDTO as $objAnexoDTO) {
							  		$objInfraFeedDTO = new InfraFeedDTO();  
							      $objInfraFeedDTO->setStrUrl('D'.$objProtocoloDTO->getDblIdProtocolo().'-A'.$objAnexoDTO->getNumIdAnexo());
										$objInfraFeedDTO->setStrMimeType(InfraUtil::getStrMimeType($objAnexoDTO->getStrNome()));
										$objInfraFeedDTO->setArrMetaTags(null);
										$objInfraFeedDTO->setBinConteudo(null);
										
							  		FeedSEIProtocolos::getInstance()->removerFeed($objInfraFeedDTO);
						    	}
					    	}
		  				 	break;
		    		}
		    	}
	    	}	    		  		
  		}  		
  	}catch(Exception $e){
  	  LogSEI::getInstance()->gravar('Erro preparando remo��o do Protocolo.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro preparando remo��o do Protocolo.',$e);
    } 
  }
  
  protected function prepararRemocaoBaseConhecimentoConectado(IndexacaoDTO $objIndexacaoDTO){
  	try {
  		
 			$arrObjBaseConhecimentoDTO = $objIndexacaoDTO->getArrObjBaseConhecimentoDTO();
 			
 			if (InfraArray::contar($arrObjBaseConhecimentoDTO)){
 				
	  		foreach($arrObjBaseConhecimentoDTO as $objBaseConhecimentoDTO){
		  		$objInfraFeedDTO = new InfraFeedDTO();
		      $objInfraFeedDTO->setStrUrl('B'.$objBaseConhecimentoDTO->getNumIdBaseConhecimento());
					$objInfraFeedDTO->setStrMimeType('text/plain');
					$objInfraFeedDTO->setArrMetaTags(null);
					$objInfraFeedDTO->setBinConteudo(null);
		  		FeedSEIBasesConhecimento::getInstance()->removerFeed($objInfraFeedDTO);


          $objAnexoDTO =	new AnexoDTO();
          $objAnexoDTO->retNumIdAnexo();
          $objAnexoDTO->retStrNome();
          $objAnexoDTO->setNumIdBaseConhecimento($objBaseConhecimentoDTO->getNumIdBaseConhecimento());

          $objAnexoRN = new AnexoRN();
          $arrAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);
          foreach ($arrAnexoDTO as $objAnexoDTO) {
            $objInfraFeedDTO = new InfraFeedDTO();
            $objInfraFeedDTO->setStrUrl('B'.$objBaseConhecimentoDTO->getNumIdBaseConhecimento().'-A'.$objAnexoDTO->getNumIdAnexo());
            $objInfraFeedDTO->setStrMimeType(InfraUtil::getStrMimeType($objAnexoDTO->getStrNome()));
            $objInfraFeedDTO->setArrMetaTags(null);
            $objInfraFeedDTO->setBinConteudo(null);
            FeedSEIBasesConhecimento::getInstance()->removerFeed($objInfraFeedDTO);
          }
	  		}
 			}
  	}catch(Exception $e){
  	  LogSEI::getInstance()->gravar('Erro preparando remo��o da Base de Conhecimento.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro preparando remo��o da Base de Conhecimento.',$e);
    } 
  }
  
  protected function prepararRemocaoPublicacaoConectado(IndexacaoDTO $parObjIndexacaoDTO){
    try {
  
   			$arrObjPublicacaoDTO = $parObjIndexacaoDTO->getArrObjPublicacaoDTO();
  
   			if (InfraArray::contar($arrObjPublicacaoDTO)){
   			  	   			     			   
   			  foreach($arrObjPublicacaoDTO as $objPublicacaoDTO){
   			    $objInfraFeedDTO = new InfraFeedDTO();   			    
   			    $objInfraFeedDTO->setStrUrl('P'.$objPublicacaoDTO->getNumIdPublicacao());
   			    $objInfraFeedDTO->setStrMimeType('text/html');
   			    $objInfraFeedDTO->setArrMetaTags(null);
   			    $objInfraFeedDTO->setBinConteudo(null);
   			    FeedSEIPublicacoes::getInstance()->removerFeed($objInfraFeedDTO);
   			  }
   			}
   			
    }catch(Exception $e){
      LogSEI::getInstance()->gravar('Erro preparando remo��o da Base de Conhecimento.'."\n".InfraException::inspecionar($e));
      //throw new InfraException('Erro preparando remo��o da Base de Conhecimento.',$e);
    }
  }

  private function configurarIndexacaoAnexo(IndexacaoDTO $parObjIndexacaoDTO, InfraFeedDTO $objInfraFeedDTO, AnexoDTO $objAnexoDTO){
    
    $objInfraFeedDTO->setStrMimeType('text/plain');
    $objInfraFeedDTO->setStrCaminhoArquivo(null);
    $objInfraFeedDTO->setBinConteudo(null);
    	
    $strMimeType = InfraUtil::getStrMimeType($objAnexoDTO->getStrNome());
    
    $strTipo = substr($strMimeType,0,6);
    
    if ($strTipo!='video/' &&  $strTipo!='audio/' &&  $strTipo!='image/' && $strMimeType!='application/zip' && $strMimeType!='application/rar'){
      
      $objInfraFeedDTO->setStrMimeType($strMimeType);

      $strStaOperacao = $parObjIndexacaoDTO->getStrStaOperacao();

      if ($strStaOperacao==IndexacaoRN::$TO_PROTOCOLO_METADADOS_E_CONTEUDO ||
          $strStaOperacao==IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_METADADOS_E_CONTEUDO ||
          $strStaOperacao==IndexacaoRN::$TO_BASE_CONHECIMENTO_LIBERAR){
        	
				$objAnexoRN = new AnexoRN();
				$objInfraFeedDTO->setStrCaminhoArquivo($objAnexoRN->obterLocalizacao($objAnexoDTO));
      }
    }
  }

  protected function gerarIndexacaoCompletaConectado(IndexacaoDTO $parObjIndexacaoDTO){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoCompleta', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
      }

      if (!InfraString::isBolVazia($parObjIndexacaoDTO->getDthInicio())) {
        if (!InfraData::validarData($parObjIndexacaoDTO->getDthInicio())) {
          $objInfraException->lancarValidacao("Data inicial [".$parObjIndexacaoDTO->getDthInicio()."] inv�lida.\n");
        }
      }

      if (!InfraString::isBolVazia($parObjIndexacaoDTO->getDthFim())) {
        if (!InfraData::validarData($parObjIndexacaoDTO->getDthFim())) {
          $objInfraException->lancarValidacao("Data final [".$parObjIndexacaoDTO->getDthFim()."] inv�lida.\n");
        }

        if (InfraData::compararDatas($parObjIndexacaoDTO->getDthInicio(), $parObjIndexacaoDTO->getDthFim()) < 0) {
          $objInfraException->lancarValidacao("Per�odo inv�lido.");
        }
      }

      $strMsg = 'Indexa��o Completa - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objProtocoloRN 	= new ProtocoloRN();

      $objProtocoloDTO 	= new ProtocoloDTO();
      $objProtocoloDTO->setDistinct(true);
      $objProtocoloDTO->retDtaInclusao();

      if (!InfraString::isBolVazia($parObjIndexacaoDTO->getDthInicio())) {
        if (InfraString::isBolVazia($parObjIndexacaoDTO->getDthFim())){
          $objProtocoloDTO->setDtaInclusao($parObjIndexacaoDTO->getDthInicio(),InfraDTO::$OPER_MENOR_IGUAL);
        }else{
          $objProtocoloDTO->adicionarCriterio(array('Inclusao','Inclusao'),
                                              array(InfraDTO::$OPER_MAIOR_IGUAL, InfraDTO::$OPER_MENOR_IGUAL),
                                              array($parObjIndexacaoDTO->getDthInicio(),$parObjIndexacaoDTO->getDthFim()),
                                              InfraDTO::$OPER_LOGICO_AND);
        }
      }

      $objProtocoloDTO->setOrdDtaInclusao(InfraDTO::$TIPO_ORDENACAO_DESC);

      $arrObjProtocoloDTOData = $objProtocoloRN->listarRN0668($objProtocoloDTO);

      $objIndexacaoRN = new IndexacaoRN();
      $objIndexacaoDTO = new IndexacaoDTO();

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax(count($arrObjProtocoloDTOData));
      }

      $numTotalRegistros = 0;
      foreach($arrObjProtocoloDTOData as $objProtocoloDTOData){

        $dtaInclusao = $objProtocoloDTOData->getDtaInclusao();

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo('Indexa��o Completa - '.$dtaInclusao.'...');
          $prb->moverProximo();
        }

        $objProtocoloDTO = new ProtocoloDTO();
        $objProtocoloDTO->retDblIdProtocolo();
        $objProtocoloDTO->setDtaInclusao($dtaInclusao);
        $objProtocoloDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_DESC);
        $arrObjProtocoloDTO = $objProtocoloRN->listarRN0668($objProtocoloDTO);

        $numRegistros 			=	count($arrObjProtocoloDTO);
        $numRegistrosPagina = 50;
        $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

        for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

          if ($numPaginaAtual == ($numPaginas - 1)) {
            $numRegistrosAtual = $numRegistros;
          } else {
            $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
          }

          $strMsg = 'Indexa��o Completa - '.$dtaInclusao . ' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

          if (!InfraUtil::isBolLinhaDeComando()) {
            $prb->setStrRotulo($strMsg);
          }

          $this->logar($strMsg);


          $arrObjProtocoloDTOPagina = array_slice($arrObjProtocoloDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

          $objIndexacaoDTO->setArrIdProtocolos(InfraArray::converterArrInfraDTO($arrObjProtocoloDTOPagina,'IdProtocolo'));
          $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PROTOCOLO_METADADOS_E_CONTEUDO);

          $objIndexacaoRN->indexarProtocolo($objIndexacaoDTO);
        }
        $numTotalRegistros += $numRegistros;
      }

      $numSegProtocolos = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o Completa - '.$numTotalRegistros.' protocolos indexados em '.InfraData::formatarTimestamp($numSegProtocolos);

      if (!InfraString::isBolVazia($parObjIndexacaoDTO->getDthInicio())) {
        if (InfraString::isBolVazia($parObjIndexacaoDTO->getDthFim())) {
          $strMsg .= ' (iniciando em '.$parObjIndexacaoDTO->getDthInicio().')';
        }else{
          $strMsg .= ' ('.$parObjIndexacaoDTO->getDthInicio().' at� '.$parObjIndexacaoDTO->getDthFim().')';
        }
      }

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o completa de processos/documentos.',$e);
    }
  }

  protected function gerarIndexacaoParcialConectado(IndexacaoDTO $parObjIndexacaoDTO){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoParcial', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
      }

      if (InfraString::isBolVazia($parObjIndexacaoDTO->getDthInicio())){
        $objInfraException->lancarValidacao('Data/hora inicial n�o informada.');
      }

      if (InfraString::isBolVazia($parObjIndexacaoDTO->getDthFim())){
        $objInfraException->lancarValidacao('Data/hora final n�o informada.');
      }

      if (!InfraData::validarDataHora($parObjIndexacaoDTO->getDthInicio().':00')) {
        $objInfraException->lancarValidacao("Data/Hora inicial [" . $parObjIndexacaoDTO->getDthInicio() . "] inv�lida.\n");
      }

      if (!InfraData::validarDataHora($parObjIndexacaoDTO->getDthFim().':59')) {
        $objInfraException->lancarValidacao("Data/Hora final [" . $parObjIndexacaoDTO->getDthFim() . "] inv�lida.\n");
      }

      if (InfraData::compararDataHora($parObjIndexacaoDTO->getDthInicio().':00',$parObjIndexacaoDTO->getDthFim().':59')<0){
        $objInfraException->lancarValidacao("Per�odo inv�lido.");
      }

      $strMsg = 'Indexa��o Parcial - iniciando...['.$parObjIndexacaoDTO->getDthInicio().' ate '.$parObjIndexacaoDTO->getDthFim().']';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $objIndexacaoRN = new IndexacaoRN();
      $objIndexacaoDTO = new IndexacaoDTO();

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $dthIni = $parObjIndexacaoDTO->getDthInicio().':00';
      $dthFim = $parObjIndexacaoDTO->getDthFim().':59';

      $objAtividadeDTO = new AtividadeDTO();
      $objAtividadeDTO->setDistinct(true);
      $objAtividadeDTO->retDblIdProtocolo();

      $objAtividadeDTO->adicionarCriterio(array('Abertura','Abertura'),
          array(InfraDTO::$OPER_MAIOR_IGUAL,InfraDTO::$OPER_MENOR_IGUAL),
          array($dthIni,$dthFim),
          InfraDTO::$OPER_LOGICO_AND,
          'criterioAbertura');

      $objAtividadeDTO->adicionarCriterio(array('Conclusao','Conclusao'),
          array(InfraDTO::$OPER_MAIOR_IGUAL,InfraDTO::$OPER_MENOR_IGUAL),
          array($dthIni,$dthFim),
          InfraDTO::$OPER_LOGICO_AND,
          'criterioConclusao');

      $objAtividadeDTO->agruparCriterios(array('criterioAbertura','criterioConclusao'),
          InfraDTO::$OPER_LOGICO_OR);

      $objAtividadeDTO->setNumIdAtividade(null, InfraDTO::$OPER_DIFERENTE);
      $objAtividadeDTO->setDblIdProtocolo(null, InfraDTO::$OPER_DIFERENTE);
      $objAtividadeDTO->setNumIdTarefa(null, InfraDTO::$OPER_DIFERENTE);
      $objAtividadeDTO->setNumIdUnidade(null, InfraDTO::$OPER_DIFERENTE);

      //Erro no SQL Server que n�o aceita ordenar pelo campo se utilizando distinct com cast as varchar e alias
      //$objAtividadeDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_DESC);

      $objAtividadeRN 	= new AtividadeRN();
      $arrObjAtividadeDTO = $objAtividadeRN->listarRN0036($objAtividadeDTO);

      InfraArray::ordenarArrInfraDTO($arrObjAtividadeDTO, 'IdProtocolo', InfraArray::$TIPO_ORDENACAO_DESC);

      $numRegistros 			=	count($arrObjAtividadeDTO);
      $numRegistrosPagina = 10;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){

        if ($numPaginaAtual ==  ($numPaginas-1)){
          $numRegistrosAtual = $numRegistros;
        }else{
          $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
        }


        $strMsg = 'Indexa��o Parcial - indexando processos ['.$numRegistrosAtual.' de '.$numRegistros.']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);


        $arrObjAtividadeDTOPagina = array_slice($arrObjAtividadeDTO, ($numPaginaAtual*$numRegistrosPagina), $numRegistrosPagina);

        $objIndexacaoDTO->setArrIdProtocolos(InfraArray::converterArrInfraDTO($arrObjAtividadeDTOPagina,'IdProtocolo'));
        $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_METADADOS_E_CONTEUDO);

        $objIndexacaoRN->indexarProtocolo($objIndexacaoDTO);
      }

      $strMsg = 'Indexa��o Parcial - '.$numRegistros.' processos indexados em '.InfraData::formatarTimestamp(InfraUtil::verificarTempoProcessamento($numSeg));

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      unset($arrObjAtividadeDTO);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      SessaoInfra::setObjInfraSessao(SessaoSEI::getInstance());
      BancoInfra::setObjInfraIBanco(BancoSEI::getInstance());

      $objInfraAuditoriaDTO = new InfraAuditoriaDTO();
      $objInfraAuditoriaDTO->retStrRequisicao();
      $objInfraAuditoriaDTO->retStrRecurso();
      $objInfraAuditoriaDTO->setStrRecurso(array('procedimento_excluir','documento_excluir'),InfraDTO::$OPER_IN);

      $objInfraAuditoriaDTO->adicionarCriterio(array('Acesso','Acesso'),
          array(InfraDTO::$OPER_MAIOR_IGUAL,InfraDTO::$OPER_MENOR_IGUAL),
          array($dthIni,$dthFim),
          InfraDTO::$OPER_LOGICO_AND);

      $objInfraAuditoriaRN = new InfraAuditoriaRN();
      $arrObjInfraAuditoriaDTO = $objInfraAuditoriaRN->listar($objInfraAuditoriaDTO);

      $numRegistros 			=	count($arrObjInfraAuditoriaDTO);
      $numRegistrosPagina = 10;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      $strMsg = 'Indexa��o Parcial - removendo indexa��o de protocolos exclu�dos...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('RemocaoParcial', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      $this->logar($strMsg);

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){

        if ($numPaginaAtual ==  ($numPaginas-1)){
          $numRegistrosAtual = $numRegistros;
        }else{
          $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
        }

        $strMsg = 'Indexa��o Parcial - removendo indexa��o ['.$numRegistrosAtual.' de '.$numRegistros.']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjInfraAuditoriaDTOPagina = array_slice($arrObjInfraAuditoriaDTO, ($numPaginaAtual*$numRegistrosPagina), $numRegistrosPagina);

        $strPesquisa = '';
        foreach($arrObjInfraAuditoriaDTOPagina as $objInfraAuditoriaDTO){
          $strRequisicao = $objInfraAuditoriaDTO->getStrRequisicao();

          if ($objInfraAuditoriaDTO->getStrRecurso()=='procedimento_excluir'){
            $strChave = '[id_procedimento] => ';
            $strPrefixo = 'P';
          }else{
            $strChave = '[id_documento] => ';
            $strPrefixo = 'D';
          }

          $posIni = strpos($strRequisicao,$strChave);
          if ($posIni !== 0) {
            $posFim = strpos($strRequisicao, "\n", $posIni);
            if ($posFim !== 0) {
              $posIni += strlen($strChave);
              $dblIdProtocoloExcluido = substr($strRequisicao, $posIni, $posFim - $posIni);

              if ($strPesquisa!=''){
                $strPesquisa .= '%20OR%20';
              }

              $strPesquisa .= 'id:'.$strPrefixo.$dblIdProtocoloExcluido . '*';
            }
          }
        }

        if ($strPesquisa!='') {

          $urlBusca = ConfiguracaoSEI::getInstance()->getValor('Solr', 'Servidor').'/'.ConfiguracaoSEI::getInstance()->getValor('Solr', 'CoreProtocolos').'/select?q=(' . $strPesquisa . ')&fl=id&rows=1000';

          $resultados = file_get_contents($urlBusca);

          if ($resultados != '') {

            $xml = simplexml_load_string($resultados);
            $arrRet = $xml->xpath('/response/result/@numFound');

            $itens = array_shift($arrRet);

            if ($itens > 0) {

              $arrRegistros = $xml->xpath('/response/result/doc');

              foreach ($arrRegistros as $registro) {
                $objInfraFeedDTO = new InfraFeedDTO();
                $objInfraFeedDTO->setStrUrl(InfraSolrUtil::obterTag($registro, 'id', 'str'));
                $objInfraFeedDTO->setStrMimeType('text/plain');
                $objInfraFeedDTO->setArrMetaTags(null);
                $objInfraFeedDTO->setBinConteudo(null);
                FeedSEIProtocolos::getInstance()->removerFeed($objInfraFeedDTO);
              }

              FeedSEIProtocolos::getInstance()->indexarFeeds();
            }
          }
        }
      }

      $strMsg = 'Indexa��o Parcial - '.$numRegistros.' protocolos removidos da indexa��o em '.InfraData::formatarTimestamp(InfraUtil::verificarTempoProcessamento($numSeg));

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      $objVeiculoPublicacaoDTO = new VeiculoPublicacaoDTO();
      $objVeiculoPublicacaoDTO->retNumIdVeiculoPublicacao();
      $objVeiculoPublicacaoDTO->adicionarCriterio(array('StaTipo','SinExibirPesquisaInterna'),
          array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
          array(VeiculoPublicacaoRN::$TV_INTERNO,'S'),
          InfraDTO::$OPER_LOGICO_OR);

      $objVeiculoPublicacaoRN = new VeiculoPublicacaoRN();
      $arrObjVeiculoPublicacaoDTO = $objVeiculoPublicacaoRN->listar($objVeiculoPublicacaoDTO);

      if (count($arrObjVeiculoPublicacaoDTO)) {

        $objPublicacaoDTO = new PublicacaoDTO();
        $objPublicacaoDTO->retNumIdPublicacao();
        $objPublicacaoDTO->retStrStaEstado();
        $objPublicacaoDTO->setNumIdVeiculoPublicacao(InfraArray::converterArrInfraDTO($arrObjVeiculoPublicacaoDTO, 'IdVeiculoPublicacao'), InfraDTO::$OPER_IN);
        $objPublicacaoDTO->adicionarCriterio(array('Publicacao','Publicacao'),
                                             array(InfraDTO::$OPER_MAIOR_IGUAL,InfraDTO::$OPER_MENOR_IGUAL),
                                             array(substr($dthIni,0,10),substr($dthFim,0,10)),
                                             InfraDTO::$OPER_LOGICO_AND);
        $objPublicacaoDTO->setOrdDtaPublicacao(InfraDTO::$TIPO_ORDENACAO_DESC);

        $objPublicacaoRN = new PublicacaoRN();
        $arrObjPublicacaoDTOTodas = $objPublicacaoRN->listarRN1045($objPublicacaoDTO);

        $arrObjPublicacaoDTO = array();
        foreach ($arrObjPublicacaoDTOTodas as $objPublicacaoDTO) {
          if ($objPublicacaoDTO->getStrStaEstado() == PublicacaoRN::$TE_PUBLICADO) {
            $arrObjPublicacaoDTO[] = $objPublicacaoDTO;
          }
        }
        $numRegistros = count($arrObjPublicacaoDTO);
        $numRegistrosPagina = 50;
        $numPaginas = ceil($numRegistros / $numRegistrosPagina);


        $strMsg = 'Indexa��o Parcial - indexando publica��es SEI...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb = InfraBarraProgresso2::newInstance('PublicacaoParcial', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
          $prb->setStrRotulo($strMsg);
          $prb->setNumMin(0);
          $prb->setNumMax($numPaginas);
        }

        $objIndexacaoDTO = new IndexacaoDTO();

        for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

          if ($numPaginaAtual == ($numPaginas - 1)) {
            $numRegistrosAtual = $numRegistros;
          } else {
            $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
          }

          $strMsg = 'Indexa��o Parcial - indexando publica��es SEI ['.$numRegistrosAtual.' de '.$numRegistros.']...';

          if (!InfraUtil::isBolLinhaDeComando()) {
            $prb->setStrRotulo($strMsg);
            $prb->moverProximo();
          }

          $this->logar($strMsg);

          $arrObjPublicacaoDTOPagina = array_slice($arrObjPublicacaoDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);
          $objPublicacaoDTO = new PublicacaoDTO();
          $objPublicacaoDTO->retTodos(true);
          $objPublicacaoDTO->setNumIdPublicacao(InfraArray::converterArrInfraDTO($arrObjPublicacaoDTOPagina, 'IdPublicacao'), InfraDTO::$OPER_IN);
          $objIndexacaoDTO->setArrObjPublicacaoDTO($objPublicacaoRN->listarRN1045($objPublicacaoDTO));
          $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PUBLICACAO);

          $objIndexacaoRN->indexarPublicacao($objIndexacaoDTO);
        }

        $numSegSei = InfraUtil::verificarTempoProcessamento($numSeg);

        $strMsg = 'Indexa��o de Publica��es - ' . $numRegistros . ' publica��es SEI indexadas em ' . InfraData::formatarTimestamp($numSegSei);

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
        }

        $this->logar($strMsg);
      }


      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o parcial.',$e);
    }
  }

  protected function gerarIndexacaoProcessoConectado(IndexacaoDTO $parObjIndexacaoDTO){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoProcesso', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
      }

      if (InfraString::isBolVazia($parObjIndexacaoDTO->getStrProtocoloFormatadoPesquisa())){
        $objInfraException->lancarValidacao('Nenhum processo informado.');
      }

      $arrProtocoloFormatado = explode(',',$parObjIndexacaoDTO->getStrProtocoloFormatadoPesquisa());
      $numProtocolos = count($arrProtocoloFormatado);
      for($i=0;$i<$numProtocolos;$i++){
        $arrProtocoloFormatado[$i] = InfraUtil::retirarFormatacao(trim($arrProtocoloFormatado[$i]),false);
      }

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->retDblIdProtocolo();
      $objProtocoloDTO->retStrProtocoloFormatado();
      $objProtocoloDTO->setStrProtocoloFormatadoPesquisa($arrProtocoloFormatado, InfraDTO::$OPER_IN);
      $objProtocoloDTO->setStrStaNivelAcessoGlobal(ProtocoloRN::$NA_SIGILOSO,InfraDTO::$OPER_DIFERENTE);
      $objProtocoloDTO->setStrStaProtocolo(ProtocoloRN::$TP_PROCEDIMENTO);
      $objProtocoloDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_DESC);

      $objProtocoloRN = new ProtocoloRN();
      $arrObjProtocoloDTOProcessos = $objProtocoloRN->listarRN0668($objProtocoloDTO);

      if (count($arrObjProtocoloDTOProcessos)==0){
        $objInfraException->lancarValidacao('Nenhum processo n�o encontrado.');
      }

      $numProcessos = count($arrObjProtocoloDTOProcessos);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numProcessos);
      }

      $numSeg = InfraUtil::verificarTempoProcessamento();

      for($j=0;$j<$numProcessos;$j++){

        $dblIdProcedimento = $arrObjProtocoloDTOProcessos[$j]->getDblIdProtocolo();
        $strProtocoloFormatado = $arrObjProtocoloDTOProcessos[$j]->getStrProtocoloFormatado();

        $strMsg = 'Indexando Processo '.$strProtocoloFormatado.' ['.($j+1).' de '.$numProcessos.']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
        $objRelProtocoloProtocoloDTO->retDblIdProtocolo1();
        $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);
        $objRelProtocoloProtocoloDTO->setDblIdProtocolo2($dblIdProcedimento);

        $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
        $objRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->consultarRN0841($objRelProtocoloProtocoloDTO);

        if ($objRelProtocoloProtocoloDTO != null) {
          $dblIdProcessoPai = $objRelProtocoloProtocoloDTO->getDblIdProtocolo1();
        } else {
          $dblIdProcessoPai = $dblIdProcedimento;
        }

        $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
        $objRelProtocoloProtocoloDTO->retDblIdProtocolo2();
        $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_PROCEDIMENTO_ANEXADO);
        $objRelProtocoloProtocoloDTO->setDblIdProtocolo1($dblIdProcessoPai);

        $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
        $arrIdProtocolos = InfraArray::converterArrInfraDTO($objRelProtocoloProtocoloRN->listarRN0187($objRelProtocoloProtocoloDTO), 'IdProtocolo2');
        $arrIdProtocolos[] = $dblIdProcessoPai;

        $objDocumentoDTO = new DocumentoDTO();
        $objDocumentoDTO->retDblIdDocumento();
        $objDocumentoDTO->setDblIdProcedimento($arrIdProtocolos, InfraDTO::$OPER_IN);

        $objDocumentoRN = new DocumentoRN();
        $arrIdProtocolos = array_merge($arrIdProtocolos, InfraArray::converterArrInfraDTO($objDocumentoRN->listarRN0008($objDocumentoDTO), 'IdDocumento'));

        $objProtocoloDTO = new ProtocoloDTO();
        $objProtocoloDTO->retDblIdProtocolo();
        $objProtocoloDTO->retStrProtocoloFormatado();
        $objProtocoloDTO->retStrProtocoloFormatadoProcedimentoDocumento();
        $objProtocoloDTO->retDblIdProcedimentoDocumento();
        $objProtocoloDTO->retStrStaProtocolo();
        $objProtocoloDTO->setDblIdProtocolo($arrIdProtocolos, InfraDTO::$OPER_IN);
        $objProtocoloDTO->setOrdDblIdProcedimentoDocumento(InfraDTO::$TIPO_ORDENACAO_ASC);
        $objProtocoloDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_ASC);

        $arrObjProtocoloDTO = $objProtocoloRN->listarRN0668($objProtocoloDTO);

        $objIndexacaoRN = new IndexacaoRN();
        $objIndexacaoDTO = new IndexacaoDTO();

        $numRegistros = count($arrObjProtocoloDTO);

        for ($i = 0; $i < $numRegistros; $i++) {

          $objProtocoloDTO = $arrObjProtocoloDTO[$i];

          $strMsg = 'Indexa��o Processo '.$strProtocoloFormatado.' - ';

          if ($objProtocoloDTO->getStrStaProtocolo() == ProtocoloRN::$TP_PROCEDIMENTO) {
            $strMsg .= $objProtocoloDTO->getStrProtocoloFormatado();
          } else {

            if ($objProtocoloDTO->getDblIdProcedimentoDocumento() == $dblIdProcedimento) {
              $strMsg .= $objProtocoloDTO->getStrProtocoloFormatado();
            } else {
              $strMsg .= $objProtocoloDTO->getStrProtocoloFormatadoProcedimentoDocumento().' '.$objProtocoloDTO->getStrProtocoloFormatado();
            }
          }

          $objIndexacaoDTO->setArrIdProtocolos(array($objProtocoloDTO->getDblIdProtocolo()));
          $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PROTOCOLO_METADADOS_E_CONTEUDO);
          $objIndexacaoRN->indexarProtocolo($objIndexacaoDTO);
        }
      }

      $numSegProcessos = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o Processos - '.$numProcessos.' indexados em '.InfraData::formatarTimestamp($numSegProcessos);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de processo.',$e);
    }
  }

  protected function gerarIndexacaoPublicacaoConectado(){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      $strMsg = 'Indexa��o de Publica��es - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoPublicacaoSei', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objUnidadePublicacaoDTO = new UnidadePublicacaoDTO();
      $objUnidadePublicacaoDTO->retNumIdUnidadePublicacao();
      $objUnidadePublicacaoRN = new UnidadePublicacaoRN();
      $objUnidadePublicacaoRN->excluir($objUnidadePublicacaoRN->listar($objUnidadePublicacaoDTO));

      $objSeriePublicacaoDTO = new SeriePublicacaoDTO();
      $objSeriePublicacaoDTO->retNumIdSeriePublicacao();
      $objSeriePublicacaoRN = new SeriePublicacaoRN();
      $objSeriePublicacaoRN->excluir($objSeriePublicacaoRN->listar($objSeriePublicacaoDTO));

      $objVeiculoPublicacaoDTO = new VeiculoPublicacaoDTO();
      $objVeiculoPublicacaoDTO->retNumIdVeiculoPublicacao();
      $objVeiculoPublicacaoDTO->adicionarCriterio(array('StaTipo','SinExibirPesquisaInterna'),
          array(InfraDTO::$OPER_IGUAL,InfraDTO::$OPER_IGUAL),
          array(VeiculoPublicacaoRN::$TV_INTERNO,'S'),
          InfraDTO::$OPER_LOGICO_OR);

      $objVeiculoPublicacaoRN = new VeiculoPublicacaoRN();
      $arrObjVeiculoPublicacaoDTO = $objVeiculoPublicacaoRN->listar($objVeiculoPublicacaoDTO);

      if (count($arrObjVeiculoPublicacaoDTO)==0){
        $objInfraException = new InfraException();
        $objInfraException->lancarValidacao('Nenhum ve�culo de publica��o configurado para indexa��o.');
      }

      $objPublicacaoDTO = new PublicacaoDTO();
      $objPublicacaoDTO->retNumIdPublicacao();
      $objPublicacaoDTO->retStrStaEstado();
      $objPublicacaoDTO->setNumIdVeiculoPublicacao(InfraArray::converterArrInfraDTO($arrObjVeiculoPublicacaoDTO,'IdVeiculoPublicacao'), InfraDTO::$OPER_IN);
      $objPublicacaoDTO->setOrdDtaPublicacao(InfraDTO::$TIPO_ORDENACAO_DESC);

      $objPublicacaoRN = new PublicacaoRN();
      $arrObjPublicacaoDTOTodas = $objPublicacaoRN->listarRN1045($objPublicacaoDTO);

      $arrObjPublicacaoDTO = array();
      foreach($arrObjPublicacaoDTOTodas as $objPublicacaoDTO){
        if ($objPublicacaoDTO->getStrStaEstado()==PublicacaoRN::$TE_PUBLICADO){
          $arrObjPublicacaoDTO[] = $objPublicacaoDTO;
        }
      }
      $numRegistros 			=	count($arrObjPublicacaoDTO);
      $numRegistrosPagina = 50;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      $objIndexacaoRN = new IndexacaoRN();
      $objIndexacaoDTO = new IndexacaoDTO();

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){

        if ($numPaginaAtual ==  ($numPaginas-1)){
          $numRegistrosAtual = $numRegistros;
        }else{
          $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
        }

        $strMsg = 'Indexa��o de Publica��es - SEI ['. $numRegistrosAtual.' de '.$numRegistros.']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjPublicacaoDTOPagina = array_slice($arrObjPublicacaoDTO, ($numPaginaAtual*$numRegistrosPagina), $numRegistrosPagina);
        $objPublicacaoDTO = new PublicacaoDTO();
        $objPublicacaoDTO->retTodos(true);
        $objPublicacaoDTO->setNumIdPublicacao(InfraArray::converterArrInfraDTO($arrObjPublicacaoDTOPagina,'IdPublicacao'),InfraDTO::$OPER_IN);
        $objIndexacaoDTO->setArrObjPublicacaoDTO($objPublicacaoRN->listarRN1045($objPublicacaoDTO));
        $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PUBLICACAO);

        $objIndexacaoRN->indexarPublicacao($objIndexacaoDTO);
      }

      $numSegSei = InfraUtil::verificarTempoProcessamento($numSeg);
      $numSeg = InfraUtil::verificarTempoProcessamento();

      $strMsg = 'Indexa��o de Publica��es - '.$numRegistros.' publica��es SEI indexadas em '.InfraData::formatarTimestamp($numSegSei);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $objPublicacaoLegadoRN = new PublicacaoLegadoRN();
      $objPublicacaoLegadoDTO = new PublicacaoLegadoDTO();
      $objPublicacaoLegadoDTO->retNumIdPublicacaoLegado();
      $objPublicacaoLegadoDTO->setNumIdVeiculoPublicacao(InfraArray::converterArrInfraDTO($arrObjVeiculoPublicacaoDTO,'IdVeiculoPublicacao'), InfraDTO::$OPER_IN);
      $objPublicacaoLegadoDTO->setOrdDtaPublicacao(InfraDTO::$TIPO_ORDENACAO_DESC);

      $arrObjPublicacaoLegadoDTO = $objPublicacaoLegadoRN->listar($objPublicacaoLegadoDTO);

      if (count($arrObjPublicacaoLegadoDTO)){
        $numRegistros 			=	count($arrObjPublicacaoLegadoDTO);
        $numRegistrosPagina = 50;
        $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

        $objIndexacaoRN = new IndexacaoRN();
        $objIndexacaoDTO = new IndexacaoDTO();

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb = InfraBarraProgresso2::newInstance('IndexacaoPublicacaoLegado', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
          $prb->setNumMin(0);
          $prb->setNumMax($numPaginas);
        }

        for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){
          if ($numPaginaAtual ==  ($numPaginas-1)){
            $numRegistrosAtual = $numRegistros;
          }else{
            $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
          }

          $strMsg = 'Indexa��o de Publica��es - legado ['.$numRegistrosAtual.' de '.$numRegistros.']...';

          if (!InfraUtil::isBolLinhaDeComando()) {
            $prb->setStrRotulo($strMsg);
            $prb->moverProximo();
          }

          $this->logar($strMsg);

          $arrObjPublicacaoLegadoDTOPagina = array_slice($arrObjPublicacaoLegadoDTO, ($numPaginaAtual*$numRegistrosPagina), $numRegistrosPagina);

          $objPublicacaoLegadoDTO = new PublicacaoLegadoDTO();
          $objPublicacaoLegadoDTO->retTodos(true);
          $objPublicacaoLegadoDTO->setNumIdPublicacaoLegado(InfraArray::converterArrInfraDTO($arrObjPublicacaoLegadoDTOPagina,'IdPublicacaoLegado'),InfraDTO::$OPER_IN);
          $arrObjPublicacaoLegadoDTO_Temp = $objPublicacaoLegadoRN->listar($objPublicacaoLegadoDTO);

          $arrObjPublicacaoDTO_Indexar = array();
          foreach($arrObjPublicacaoLegadoDTO_Temp as $objPublicacaoLegadoDTO){
            $objPublicacaoDTO = new PublicacaoDTO();

            $objPublicacaoDTO->setNumIdPublicacao(null);
            $objPublicacaoDTO->setNumIdPublicacaoLegado($objPublicacaoLegadoDTO->getNumIdPublicacaoLegado());
            $objPublicacaoDTO->setDblIdDocumento($objPublicacaoLegadoDTO->getStrIdDocumento());
            $objPublicacaoDTO->setDblIdProtocoloAgrupadorProtocolo($objPublicacaoLegadoDTO->getNumIdPublicacaoLegadoAgrupador());
            $objPublicacaoDTO->setNumIdOrgaoUnidadeResponsavelDocumento($objPublicacaoLegadoDTO->getNumIdOrgaoUnidade());
            $objPublicacaoDTO->setNumIdUnidadeResponsavelDocumento($objPublicacaoLegadoDTO->getNumIdUnidade());
            $objPublicacaoDTO->setNumIdSerieDocumento($objPublicacaoLegadoDTO->getNumIdSerie());
            $objPublicacaoDTO->setStrNumeroDocumento($objPublicacaoLegadoDTO->getStrNumero());
            $objPublicacaoDTO->setStrProtocoloFormatadoPesquisaProtocolo(InfraUtil::retirarFormatacao($objPublicacaoLegadoDTO->getStrProtocoloFormatado(),false));
            $objPublicacaoDTO->setStrProtocoloFormatadoProtocolo($objPublicacaoLegadoDTO->getStrProtocoloFormatado());
            $objPublicacaoDTO->setDtaGeracaoProtocolo($objPublicacaoLegadoDTO->getDtaGeracao());
            $objPublicacaoDTO->setDtaPublicacao($objPublicacaoLegadoDTO->getDtaPublicacao());
            $objPublicacaoDTO->setNumNumero(null);
            $objPublicacaoDTO->setNumIdVeiculoPublicacao($objPublicacaoLegadoDTO->getNumIdVeiculoPublicacao());
            $objPublicacaoDTO->setStrResumo($objPublicacaoLegadoDTO->getStrResumo());
            $objPublicacaoDTO->setNumIdVeiculoIO($objPublicacaoLegadoDTO->getNumIdVeiculoIO());
            $objPublicacaoDTO->setDtaPublicacaoIO($objPublicacaoLegadoDTO->getDtaPublicacaoIO());
            $objPublicacaoDTO->setNumIdSecaoIO($objPublicacaoLegadoDTO->getNumIdSecaoIO());
            $objPublicacaoDTO->setStrPaginaIO($objPublicacaoLegadoDTO->getStrPaginaIO());
            $objPublicacaoDTO->setStrConteudoDocumento($objPublicacaoLegadoDTO->getStrConteudoDocumento());
            $objPublicacaoDTO->setDblIdProcedimentoDocumento(null);
            $objPublicacaoDTO->setStrProtocoloProcedimentoFormatado(null);

            $arrObjPublicacaoDTO_Indexar[] = $objPublicacaoDTO;
          }
          $objIndexacaoDTO->setArrObjPublicacaoDTO($arrObjPublicacaoDTO_Indexar);
          $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PUBLICACAO);

          $objIndexacaoRN->indexarPublicacao($objIndexacaoDTO);

        }

        $numSegLegado = InfraUtil::verificarTempoProcessamento($numSeg);

        $strMsg = 'Indexa��o de Publica��es - '.$numRegistros.' publica��es legadas indexadas em '.InfraData::formatarTimestamp($numSegLegado);

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
        }

        $this->logar($strMsg);
      }

      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro indexando publica��es.',$e);
    }
  }

  protected function gerarIndexacaoBasesConhecimentoConectado(){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      $strMsg = 'Indexa��o de Bases de Conhecimento - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoBasesConhecimento', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objBaseConhecimentoRN 	= new BaseConhecimentoRN();

      $objBaseConhecimentoDTO = new BaseConhecimentoDTO();
      $objBaseConhecimentoDTO->retNumIdBaseConhecimento();
      $objBaseConhecimentoDTO->setStrStaEstado(BaseConhecimentoRN::$TE_LIBERADO);
      $objBaseConhecimentoDTO->setOrdNumIdBaseConhecimento(InfraDTO::$TIPO_ORDENACAO_DESC);

      $arrObjBaseConhecimentoDTO =	$objBaseConhecimentoRN->listar($objBaseConhecimentoDTO);

      $numRegistros 			=	count($arrObjBaseConhecimentoDTO);
      $numRegistrosPagina = 10;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      $objIndexacaoRN = new IndexacaoRN();
      $objIndexacaoDTO = new IndexacaoDTO();

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){

        if ($numPaginaAtual ==  ($numPaginas-1)){
          $numRegistrosAtual = $numRegistros;
        }else{
          $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
        }

        $strMsg = 'Indexa��o de Bases de Conhecimento - ['.$numRegistrosAtual.' de '.$numRegistros.']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);


        $offset = ($numPaginaAtual*$numRegistrosPagina);

        if (($offset + $numRegistrosPagina) > $numRegistros) {
          $length = $numRegistros - $offset;
        }else{
          $length = $numRegistrosPagina;
        }

        $objIndexacaoDTO->setArrObjBaseConhecimentoDTO(array_slice($arrObjBaseConhecimentoDTO, $offset, $length));
        $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_BASE_CONHECIMENTO_LIBERAR);
        $objIndexacaoRN->indexarBaseConhecimento($objIndexacaoDTO);
      }

      $numSegBasesConhecimento = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o de Bases de Conhecimento - '.$numRegistros.' registros indexados em '.InfraData::formatarTimestamp($numSegBasesConhecimento);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de bases de conhecimento.',$e);
    }
  }

  protected function gerarIndexacaoControleInternoConectado(){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      $strMsg = 'Indexa��o Controle Interno - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('IndexacaoControleInterno', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objAcessoDTO = new AcessoDTO();
      $objAcessoDTO->setDistinct(true);
      $objAcessoDTO->retDblIdProtocolo();
      $objAcessoDTO->setStrStaTipo(AcessoRN::$TA_CONTROLE_INTERNO);

      $objAcessoRN = new AcessoRN();
      $arrIdProtocolos = InfraArray::converterArrInfraDTO($objAcessoRN->listar($objAcessoDTO),'IdProtocolo');

      sort($arrIdProtocolos);

      $objIndexacaoRN = new IndexacaoRN();
      $objIndexacaoDTO = new IndexacaoDTO();

      $numRegistros 			=	count($arrIdProtocolos);
      $numRegistrosPagina = 50;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o Controle Interno [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $objIndexacaoDTO->setArrIdProtocolos(array_slice($arrIdProtocolos, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina));
        $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PROCESSO_COM_DOCUMENTOS_ACESSO);
        $objIndexacaoRN->indexarProtocolo($objIndexacaoDTO);
      }

      $numSegProtocolos = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o Controle Interno - '.$numRegistros.' processos indexados em '.InfraData::formatarTimestamp($numSegProtocolos);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(2);

      $objInfraException->lancarValidacao('Opera��o Finalizada.');

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de criterios de controle internos.',$e);
    }
  }

  protected function gerarIndexacaoInternaConectado(IndexacaoDTO $objIndexacaoDTO){
    try{

      $objInfraException = new InfraException();

      LimiteSEI::getInstance()->configurarNivel3();

      $numSeg = InfraUtil::verificarTempoProcessamento();

      if (!$objIndexacaoDTO->isSetStrSinScript()){
        $objIndexacaoDTO->setStrSinScript('N');
      }

      if ($objIndexacaoDTO->getStrSinOrgaos()=='S') {
        $this->gerarIndexacaoOrgaos();
      }

      if ($objIndexacaoDTO->getStrSinUnidades()=='S') {
        $this->gerarIndexacaoUnidades();
      }

      if ($objIndexacaoDTO->getStrSinUsuarios()=='S') {
        $this->gerarIndexacaoUsuarios();
      }

      if ($objIndexacaoDTO->getStrSinContatos()=='S') {
        $this->gerarIndexacaoContatos();
      }

      if ($objIndexacaoDTO->getStrSinAssuntos()=='S') {
        $this->gerarIndexacaoAssuntos();
      }

      if ($objIndexacaoDTO->getStrSinAcompanhamentos()=='S') {
        $this->gerarIndexacaoAcompanhamentos();
      }

      if ($objIndexacaoDTO->getStrSinBlocos()=='S') {
        $this->gerarIndexacaoBlocos();
      }

      if ($objIndexacaoDTO->getStrSinGruposEmail()=='S') {
        $this->gerarIndexacaoGruposEmail();
      }

      if ($objIndexacaoDTO->getStrSinObservacoes()=='S') {
        $this->gerarIndexacaoObservacoesProtocolos();
      }

      if ($objIndexacaoDTO->getStrSinFavoritos()=='S') {
        $this->gerarIndexacaoFavoritos();
      }


      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o Interna - finalizada em '.InfraData::formatarTimestamp($numSeg);

      $this->logar($strMsg);

      if ($objIndexacaoDTO->getStrSinScript()=='N') {
        $objInfraException->lancarValidacao('Opera��o Finalizada em '.InfraData::formatarTimestamp($numSeg).'.');
      }

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o interna.',$e);
    }
  }

  private function gerarIndexacaoOrgaos(){
    try{

      $strEntidade = 'Interna - �rg�os';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Orgaos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objOrgaoDTO = new OrgaoDTO();
      $objOrgaoDTO->setBolExclusaoLogica(false);
      $objOrgaoDTO->retNumIdOrgao();

      $objOrgaoRN = new OrgaoRN();
      $arrObjOrgaoDTO = $objOrgaoRN->listarRN1353($objOrgaoDTO);

      $numRegistros	=	count($arrObjOrgaoDTO);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numRegistros);
      }

      $numRegistrosAtual = 0;

      foreach($arrObjOrgaoDTO as $objOrgaoDTO){

        $strMsg = 'Indexa��o '.$strEntidade.' [' . ++$numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $objOrgaoRN->montarIndexacao($objOrgaoDTO);

        usleep(10000);
      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoUnidades(){
    try{

      $strEntidade = 'Interna - Unidades';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Unidades', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->setBolExclusaoLogica(false);
      $objUnidadeDTO->retNumIdUnidade();

      $objUnidadeRN = new UnidadeRN();
      $arrObjUnidadeDTO = $objUnidadeRN->listarRN0127($objUnidadeDTO);

      $numRegistros 			=	count($arrObjUnidadeDTO);
      $numRegistrosPagina = 100;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjUnidadeDTOPagina = array_slice($arrObjUnidadeDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objUnidadeDTO = new UnidadeDTO();
        $objUnidadeDTO->setNumIdUnidade(InfraArray::converterArrInfraDTO($arrObjUnidadeDTOPagina,'IdUnidade'));
        $objUnidadeRN->montarIndexacao($objUnidadeDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoUsuarios(){
    try{

      $strEntidade = 'Interna - Usu�rios';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Usuarios', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objUsuarioDTO = new UsuarioDTO();
      $objUsuarioDTO->setBolExclusaoLogica(false);
      $objUsuarioDTO->retNumIdUsuario();

      $objUsuarioRN = new UsuarioRN();
      $arrObjUsuarioDTO = $objUsuarioRN->listarRN0490($objUsuarioDTO);

      $numRegistros 			=	count($arrObjUsuarioDTO);
      $numRegistrosPagina = 1000;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjUsuarioDTOPagina = array_slice($arrObjUsuarioDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objUsuarioDTO = new UsuarioDTO();
        $objUsuarioDTO->setNumIdUsuario(InfraArray::converterArrInfraDTO($arrObjUsuarioDTOPagina,'IdUsuario'));
        $objUsuarioRN->montarIndexacao($objUsuarioDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoContatos(){
    try{

      $strEntidade = 'Interna - Contatos';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Contatos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objContatoDTO = new ContatoDTO();
      $objContatoDTO->setBolExclusaoLogica(false);
      $objContatoDTO->retNumIdContato();

      $objContatoRN = new ContatoRN();
      $arrObjContatoDTO = $objContatoRN->listarRN0325($objContatoDTO);

      $numRegistros 			=	count($arrObjContatoDTO);
      $numRegistrosPagina = 1000;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjContatoDTOPagina = array_slice($arrObjContatoDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objContatoDTO = new ContatoDTO();
        $objContatoDTO->setNumIdContato(InfraArray::converterArrInfraDTO($arrObjContatoDTOPagina,'IdContato'));
        $objContatoRN->montarIndexacao($objContatoDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoAssuntos(){
    try{

      $strEntidade = 'Interna - Assuntos';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Assuntos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objAssuntoDTO = new AssuntoDTO();
      $objAssuntoDTO->setBolExclusaoLogica(false);
      $objAssuntoDTO->retNumIdAssunto();

      $objAssuntoRN = new AssuntoRN();
      $arrObjAssuntoDTO = $objAssuntoRN->listarRN0247($objAssuntoDTO);

      $numRegistros 			=	count($arrObjAssuntoDTO);
      $numRegistrosPagina = 500;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjAssuntoDTOPagina = array_slice($arrObjAssuntoDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objAssuntoDTO = new AssuntoDTO();
        $objAssuntoDTO->setNumIdAssunto(InfraArray::converterArrInfraDTO($arrObjAssuntoDTOPagina,'IdAssunto'));
        $objAssuntoRN->montarIndexacao($objAssuntoDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoAcompanhamentos(){
    try{

      $strEntidade = 'Interna - Acompanhamentos Especiais';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Acompanhamentos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objAcompanhamentoDTO = new AcompanhamentoDTO();
      $objAcompanhamentoDTO->retNumIdAcompanhamento();

      $objAcompanhamentoRN = new AcompanhamentoRN();
      $arrObjAcompanhamentoDTO = $objAcompanhamentoRN->listar($objAcompanhamentoDTO);

      $numRegistros 			=	count($arrObjAcompanhamentoDTO);
      $numRegistrosPagina = 1000;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjAcompanhamentoDTOPagina = array_slice($arrObjAcompanhamentoDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objAcompanhamentoDTO = new AcompanhamentoDTO();
        $objAcompanhamentoDTO->setNumIdAcompanhamento(InfraArray::converterArrInfraDTO($arrObjAcompanhamentoDTOPagina,'IdAcompanhamento'));
        $objAcompanhamentoRN->montarIndexacao($objAcompanhamentoDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoBlocos(){
    try{

      $strEntidade = 'Interna - Blocos';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Blocos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retNumIdBloco();

      $objBlocoRN = new BlocoRN();
      $arrObjBlocoDTO = $objBlocoRN->listarRN1277($objBlocoDTO);

      $numRegistros 			=	count($arrObjBlocoDTO);
      $numRegistrosPagina = 250;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      $objRelBlocoProtocoloRN = new RelBlocoProtocoloRN();
      $objRelBlocoProtocoloBD = new RelBlocoProtocoloBD($this->getObjInfraIBanco());

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjBlocoDTOPagina = array_slice($arrObjBlocoDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objBlocoDTO = new BlocoDTO();
        $objBlocoDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTOPagina,'IdBloco'));
        $objBlocoRN->montarIndexacao($objBlocoDTO);

        $arrNumIdBloco = InfraArray::converterArrInfraDTO($arrObjBlocoDTOPagina,'IdBloco');

        $dto = new RelBlocoProtocoloDTO();
        $dto->setBolExclusaoLogica(false);
        $dto->retDblIdProtocolo();
        $dto->retNumIdBloco();
        $dto->retStrAnotacao();
        $dto->retStrProtocoloFormatadoProtocolo();
        $dto->retStrProtocoloProcedimentoFormatado();
        $dto->setNumIdBloco($arrNumIdBloco, InfraDTO::$OPER_IN);

        BancoSEI::getInstance()->abrirTransacao();

        $arrObjRelBlocoProtocoloDTO = $objRelBlocoProtocoloRN->listarRN1291($dto);

        foreach ($arrObjRelBlocoProtocoloDTO as $objRelBlocoProtocoloDTO){
          $objRelBlocoProtocoloRN->montarIdxRelBlocoProtocolo($objRelBlocoProtocoloDTO);
          $objRelBlocoProtocoloBD->alterar($objRelBlocoProtocoloDTO);
        }

        unset($arrObjRelBlocoProtocoloDTO);

        BancoSEI::getInstance()->confirmarTransacao();
      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' blocos indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoGruposEmail(){
    try{

      $strEntidade = 'Interna - Grupos de E-mail';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('GruposEmail', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objEmailGrupoEmailDTO = new EmailGrupoEmailDTO();
      $objEmailGrupoEmailDTO->retNumIdEmailGrupoEmail();

      $objEmailGrupoEmailRN = new EmailGrupoEmailRN();
      $arrObjEmailGrupoEmailDTO = $objEmailGrupoEmailRN->listar($objEmailGrupoEmailDTO);

      $numRegistros 			=	count($arrObjEmailGrupoEmailDTO);
      $numRegistrosPagina = 500;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjEmailGrupoEmailDTOPagina = array_slice($arrObjEmailGrupoEmailDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objEmailGrupoEmailDTO = new EmailGrupoEmailDTO();
        $objEmailGrupoEmailDTO->setNumIdEmailGrupoEmail(InfraArray::converterArrInfraDTO($arrObjEmailGrupoEmailDTOPagina,'IdEmailGrupoEmail'));
        $objEmailGrupoEmailRN->montarIndexacao($objEmailGrupoEmailDTO);
      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoObservacoesProtocolos(){
    try{

      $strEntidade = 'Interna - Observa��es em Protocolos';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('ObservacoesProtocolos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $rs = InfraArray::simplificarArr(BancoSEI::getInstance()->consultarSql('select id_observacao from observacao'),'id_observacao');

      $numRegistros 			=	count($rs);
      $numRegistrosPagina = 1000;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      $objObservacaoRN = new ObservacaoRN();

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrRsPagina = array_slice($rs, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objObservacaoDTO = new ObservacaoDTO();
        $objObservacaoDTO->setNumIdObservacao($arrRsPagina);
        $objObservacaoRN->montarIndexacao($objObservacaoDTO);
      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function gerarIndexacaoFavoritos(){
    try{

      $strEntidade = 'Interna - Favoritos';

      $strMsg = 'Indexa��o '.$strEntidade.' - iniciando...';

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb = InfraBarraProgresso2::newInstance('Favoritos', array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7'));
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      $numSeg = InfraUtil::verificarTempoProcessamento();

      $objProtocoloModeloDTO = new ProtocoloModeloDTO();
      $objProtocoloModeloDTO->retDblIdProtocoloModelo();

      $objProtocoloModeloRN = new ProtocoloModeloRN();
      $arrObjProtocoloModeloDTO = $objProtocoloModeloRN->listar($objProtocoloModeloDTO);

      $numRegistros 			=	count($arrObjProtocoloModeloDTO);
      $numRegistrosPagina = 1000;
      $numPaginas 				= ceil($numRegistros/$numRegistrosPagina);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setNumMin(0);
        $prb->setNumMax($numPaginas);
      }

      for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++) {

        if ($numPaginaAtual == ($numPaginas - 1)) {
          $numRegistrosAtual = $numRegistros;
        } else {
          $numRegistrosAtual = ($numPaginaAtual + 1) * $numRegistrosPagina;
        }

        $strMsg = 'Indexa��o '.$strEntidade.' [' . $numRegistrosAtual . ' de ' . $numRegistros . ']...';

        if (!InfraUtil::isBolLinhaDeComando()) {
          $prb->setStrRotulo($strMsg);
          $prb->moverProximo();
        }

        $this->logar($strMsg);

        $arrObjProtocoloModeloDTOPagina = array_slice($arrObjProtocoloModeloDTO, ($numPaginaAtual * $numRegistrosPagina), $numRegistrosPagina);

        $objProtocoloModeloDTO = new ProtocoloModeloDTO();
        $objProtocoloModeloDTO->setDblIdProtocoloModelo(InfraArray::converterArrInfraDTO($arrObjProtocoloModeloDTOPagina,'IdProtocoloModelo'));
        $objProtocoloModeloRN->montarIndexacao($objProtocoloModeloDTO);

      }

      $numSeg = InfraUtil::verificarTempoProcessamento($numSeg);

      $strMsg = 'Indexa��o '.$strEntidade.' - '.$numRegistros.' indexados em '.InfraData::formatarTimestamp($numSeg);

      if (!InfraUtil::isBolLinhaDeComando()) {
        $prb->setStrRotulo($strMsg);
      }

      $this->logar($strMsg);

      sleep(1);

    }catch(Exception $e){
      throw new InfraException('Erro executando indexa��o de '.$strEntidade.'.',$e);
    }
  }

  private function logar($strTexto){
    InfraDebug::getInstance()->gravar(InfraString::excluirAcentos($strTexto));
    //LogSEI::getInstance()->gravar($strTexto,InfraLog::$INFORMACAO);
  }
}
