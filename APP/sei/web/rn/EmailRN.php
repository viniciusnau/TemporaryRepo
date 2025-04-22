<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
*/

require_once dirname(__FILE__).'/../SEI.php';

class EmailRN extends InfraRN {
  
  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  protected function enviarCircularConectado(EmailDTO $parObjEmailDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('email_enviar_circular',__METHOD__,$parObjEmailDTO);

      //Regras de Neg�cio
      $objInfraException = new InfraException();

      $arrIdDocumentosCirculares = $parObjEmailDTO->getArrIdDocumentosCirculares();

      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->retDblIdDocumento();
      $objDocumentoDTO->retStrProtocoloDocumentoFormatado();
      $objDocumentoDTO->setDblIdDocumento($arrIdDocumentosCirculares, InfraDTO::$OPER_IN);

      $objDocumentoRN = new DocumentoRN();
      $arrObjDocumentoDTO = InfraArray::indexarArrInfraDTO($objDocumentoRN->listarRN0008($objDocumentoDTO),'IdDocumento');

      $n = InfraArray::contar($arrIdDocumentosCirculares) - InfraArray::contar($arrObjDocumentoDTO);

      if ($n){
        if ($n == 1 ){
          throw new InfraException('Documento n�o encontrado.');
        }else{
          throw new InfraException($n.' documentos n�o encontrados.');
        }
      }

      $objAssinaturaDTO = new AssinaturaDTO();
      $objAssinaturaDTO->retDblIdDocumento();
      $objAssinaturaDTO->setDblIdDocumento($arrIdDocumentosCirculares, InfraDTO::$OPER_IN);

      $objAssinaturaRN = new AssinaturaRN();
      $arrObjAssinaturaDTO = InfraArray::indexarArrInfraDTO($objAssinaturaRN->listarRN1323($objAssinaturaDTO),'IdDocumento',true);


      $objParticipanteDTO = new ParticipanteDTO();
      $objParticipanteDTO->retDblIdProtocolo();
      $objParticipanteDTO->retStrProtocoloFormatadoProtocolo();
      $objParticipanteDTO->retStrNomeContato();
      $objParticipanteDTO->retStrEmailContato();
      $objParticipanteDTO->setStrStaParticipacao(ParticipanteRN::$TP_DESTINATARIO);
      $objParticipanteDTO->setDblIdProtocolo($arrIdDocumentosCirculares, InfraDTO::$OPER_IN);
      $objParticipanteDTO->setOrdStrNomeContato(InfraDTO::$TIPO_ORDENACAO_ASC);

      $objParticipanteRN = new ParticipanteRN();
      $arrObjParticipanteDTO = InfraArray::indexarArrInfraDTO($objParticipanteRN->listarRN0189($objParticipanteDTO),'IdProtocolo',true);

      foreach($arrObjParticipanteDTO as $arr){
        foreach($arr as $objParticipanteDTODocumento){
          if (InfraString::isBolVazia($objParticipanteDTODocumento->getStrEmailContato())) {
            $objInfraException->adicionarValidacao('Destinat�rio "' . $objParticipanteDTODocumento->getStrNomeContato() . '" do documento ' . $objParticipanteDTODocumento->getStrProtocoloFormatadoProtocolo() . ' n�o possui e-mail cadastrado.');
          }
        }
      }

      foreach($arrIdDocumentosCirculares as $dblIdDocumento){
        if (!isset($arrObjParticipanteDTO[$dblIdDocumento])){
          $objInfraException->adicionarValidacao('Documento ' . $arrObjDocumentoDTO[$dblIdDocumento]->getStrProtocoloDocumentoFormatado() . ' n�o possui destinat�rios.');
        }

        if (!isset($arrObjAssinaturaDTO[$dblIdDocumento])){
          $objInfraException->adicionarValidacao('Documento ' . $arrObjDocumentoDTO[$dblIdDocumento]->getStrProtocoloDocumentoFormatado() . ' n�o possui assinatura.');
        }
      }

      $objInfraException->lancarValidacoes();


      $ret = array();
      foreach($arrIdDocumentosCirculares as $dblIdDocumento) {
        $objEmailDTO = new EmailDTO();
        $objEmailDTO->setDblIdProtocolo($parObjEmailDTO->getDblIdProtocolo());
        $objEmailDTO->setStrDe($parObjEmailDTO->getStrDe());
        $objEmailDTO->setStrPara(implode(';', InfraArray::converterArrInfraDTO($arrObjParticipanteDTO[$dblIdDocumento], 'EmailContato')));
        $objEmailDTO->setStrCCO('');
        $objEmailDTO->setStrAssunto($parObjEmailDTO->getStrAssunto());
        $objEmailDTO->setStrMensagem($parObjEmailDTO->getStrMensagem());
        $objEmailDTO->setArrArquivosUpload(array());
        $objEmailDTO->setArrIdDocumentosProcesso(array($dblIdDocumento));
        $objEmailDTO->setDblIdDocumentoBaseCircular($dblIdDocumento);
        $ret[] = $this->enviar($objEmailDTO);
      }

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro no envio de correspond�ncia eletr�nica circular.',$e);
    }
  }

  public function enviar(EmailDTO $objEmailDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('email_enviar',__METHOD__,$objEmailDTO);

      LimiteSEI::getInstance()->configurarNivel2();

      $this->prepararAnexos($objEmailDTO);

      InfraMail::validarEmail(ConfiguracaoSEI::getInstance(), $objEmailDTO->getStrDe(), $objEmailDTO->getStrPara(), null, $objEmailDTO->getStrCCO(), $objEmailDTO->getStrAssunto(), $objEmailDTO->getStrMensagem(), "text/plain", $objEmailDTO->getArrAnexos());

      $objDocumentoDTO = $this->gerarDocumento($objEmailDTO);

      try {
        self::processar(array($objEmailDTO));
      }catch(InfraException $e){
        if (strpos(strtoupper($e->__toString()), strtoupper('N�o foi poss�vel enviar para o(s) destinat�rio(s):'))!==false) {
          $objDocumentoDTO->setObjInfraException($e);
        }else {
          throw $e;
        }
      }

      try {
        foreach ($objEmailDTO->getArrAnexos() as $strAnexo) {
          unlink($strAnexo);
        }
      }catch(Exception $excAnexos){}

      return $objDocumentoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro no envio de correspond�ncia eletr�nica.',$e);
    }
  }

  protected function gerarDocumentoControlado(EmailDTO $objEmailDTO) {
    try{

      //Regras de Neg�cio
      $strDe = $objEmailDTO->getStrDe();
      $strPara = $objEmailDTO->getStrPara();
      $strCCO = $objEmailDTO->getStrCCO();
      $strAssunto = $objEmailDTO->getStrAssunto();
      $strMensagem = $objEmailDTO->getStrMensagem();

      if (!InfraString::isBolVazia($strPara)){
        $arrPara = explode(';',$strPara);
      }else{
        $arrPara = array();
      }

      if (!InfraString::isBolVazia($strCCO)){
        $arrCCO = explode(';',$strCCO);
      }else{
        $arrCCO = array();
      }

      $objAtividadeRN = new AtividadeRN();
      $objInfraParametro = new InfraParametro($this->getObjInfraIBanco());

      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->setDblIdDocumento(null);
      $objDocumentoDTO->setDblIdProcedimento($objEmailDTO->getDblIdProtocolo());
   	  $objDocumentoDTO->setNumIdSerie($objInfraParametro->getValor('ID_SERIE_EMAIL'));
   	  
   	  $strXML = '';
   	  $strXML .= '<?xml version="1.0" encoding="iso-8859-1"?>'."\n";
   	  $strXML .= '<documento>'."\n";
   	  $strXML .= '<atributo nome="Data" titulo="Data de Envio">'.InfraData::getStrDataHoraAtual().'</atributo>'."\n";
    	$strXML .= '<atributo nome="De" titulo="De">'.InfraString::formatarXML($strDe).'</atributo>'."\n";

      if (InfraArray::contar($arrPara)){
        $strXML .= '<atributo nome="Para" titulo="Para">'."\n";
        $strXML .= '<valores>'."\n";
        foreach($arrPara as $strEmail){
          $strXML .= '<valor id="">'.InfraString::formatarXML($strEmail).'</valor>'."\n";
        }
        $strXML .= '</valores>'."\n";
        $strXML .= '</atributo>'."\n";
      }

      if (InfraArray::contar($arrCCO)){
        $strXML .= '<atributo nome="Cco" titulo="Para (com c�pia oculta)">'."\n";
        $strXML .= '<valores>'."\n";
        foreach($arrCCO as $strEmail){
          $strXML .= '<valor id="">'.InfraString::formatarXML($strEmail).'</valor>'."\n";
        }
        $strXML .= '</valores>'."\n";
        $strXML .= '</atributo>'."\n";
      }

    	$strXML .= '<atributo nome="Assunto" titulo="Assunto">'.InfraString::formatarXML($strAssunto).'</atributo>'."\n";
    	$strXML .= '<atributo nome="Mensagem" titulo="Mensagem">'.InfraString::formatarXML($strMensagem).'</atributo>'."\n";

    	$objDocumentoDTO->setStrConteudo(null);
    	$objDocumentoDTO->setDblIdDocumentoEdoc(null);
    	$objDocumentoDTO->setDblIdDocumentoEdocBase(null);

      if ($objEmailDTO->isSetNumIdTextoPadraoInterno()) {
        $objDocumentoDTO->setNumIdTextoPadraoInterno($objEmailDTO->getNumIdTextoPadraoInterno());
      }

   	  $objDocumentoDTO->setNumIdUnidadeResponsavel(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
    	$objDocumentoDTO->setStrNumero(null);
    	$objDocumentoDTO->setStrNomeArvore(null);
    	$objDocumentoDTO->setStrStaDocumento(DocumentoRN::$TD_FORMULARIO_AUTOMATICO);

      $objProtocoloDTO = new ProtocoloDTO();
      $objProtocoloDTO->setDblIdProtocolo(null);
      $objProtocoloDTO->setStrStaNivelAcessoLocal(ProtocoloRN::$NA_PUBLICO);
      $objProtocoloDTO->setStrDescricao(null);
  	  $objProtocoloDTO->setDtaGeracao(InfraData::getStrDataAtual());
			$objProtocoloDTO->setArrObjRelProtocoloAssuntoDTO(array());							

      $objProtocoloDTO->setArrObjParticipanteDTO(array());						
			$objProtocoloDTO->setArrObjObservacaoDTO(array());
	 		$objProtocoloDTO->setArrObjAnexoDTO($objEmailDTO->getArrObjAnexoDTO());
	 		$objDocumentoDTO->setObjProtocoloDTO($objProtocoloDTO);

      $objDocumentoRN = new DocumentoRN();
	 		$objDocumentoDTO = $objDocumentoRN->cadastrarRN0003($objDocumentoDTO);

	 		//busca os anexos para gravar com o id possibilitando link na consulta
	 		$objAnexoDTO = new AnexoDTO();
	 		$objAnexoDTO->retNumIdAnexo();
	 		$objAnexoDTO->retStrNome();
	 		$objAnexoDTO->retNumTamanho();
	 		$objAnexoDTO->setDblIdProtocolo($objDocumentoDTO->getDblIdDocumento());
	 		
	 		$objAnexoRN = new AnexoRN();
	 		$arrObjAnexoDTOBanco = $objAnexoRN->listarRN0218($objAnexoDTO);
	 		
    	$strXML .= '<atributo nome="Anexos" titulo="Anexos">'."\n";
      foreach($arrObjAnexoDTOBanco as $objAnexoDTO){
        $strXML .= '<valores>'."\n";
        $strXML .= '<valor id="'.$objAnexoDTO->getNumIdAnexo().'" tipo="ANEXO">';
        $strXML .= InfraString::formatarXML($objAnexoDTO->getStrNome());
        $strXML .= '</valor>'."\n";
        $strXML .= '</valores>'."\n";
      }
      $strXML .= '</atributo>'."\n";        
      
    	$strXML .= '</documento>';

    	$dto = new DocumentoDTO();
    	$dto->setDblIdDocumento($objDocumentoDTO->getDblIdDocumento());
    	$dto->setStrConteudo(InfraUtil::filtrarISO88591($strXML));
    	$objDocumentoRN->atualizarConteudoRN1205($dto);
      
      $arrObjAtributoAndamentoDTO = array();
      $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
      $objAtributoAndamentoDTO->setStrNome('DOCUMENTO');
      $objAtributoAndamentoDTO->setStrValor($objDocumentoDTO->getStrProtocoloDocumentoFormatado());
      $objAtributoAndamentoDTO->setStrIdOrigem($objDocumentoDTO->getDblIdDocumento());
      $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

      if ($objEmailDTO->isSetDblIdDocumentoBaseCircular()){
        $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
        $objAtributoAndamentoDTO->setStrNome('DOCUMENTO_CIRCULAR');
        $objAtributoAndamentoDTO->setStrValor($objDocumentoDTO->getDblIdDocumento());
        $objAtributoAndamentoDTO->setStrIdOrigem($objEmailDTO->getDblIdDocumentoBaseCircular());
        $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;
      }

      $objAtividadeDTO = new AtividadeDTO();  
      $objAtividadeDTO->setDblIdProtocolo($objEmailDTO->getDblIdProtocolo());
      $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
	    $objAtividadeDTO->setNumIdTarefa(TarefaRN::$TI_ENVIO_EMAIL);
      $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);
    
      $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);

      $objEmailUtilizadoRN = new EmailUtilizadoRN();
      $arrDestinatarios = array_merge($arrPara, $arrCCO);
      foreach($arrDestinatarios as $strEmail){

        $objEmailUtilizadoDTO = new EmailUtilizadoDTO();
        $objEmailUtilizadoDTO->retNumIdEmailUtilizado();
        $objEmailUtilizadoDTO->setStrEmail($strEmail);
        $objEmailUtilizadoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
        $objEmailUtilizadoDTO->setNumMaxRegistrosRetorno(1);

        if ($objEmailUtilizadoRN->consultar($objEmailUtilizadoDTO) == null){
          $objEmailUtilizadoRN->cadastrar($objEmailUtilizadoDTO);
        }
      }

      return $objDocumentoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro na gera��o de correspond�ncia eletr�nica.',$e);
    }
  }

  private function prepararAnexos(EmailDTO $objEmailDTO)
  {

    $objInfraException = new InfraException();

    $arrAnexos = $objEmailDTO->getArrArquivosUpload();

    $arrStrIds = $objEmailDTO->getArrIdDocumentosProcesso();

    $objDocumentoRN = new DocumentoRN();
    $objAnexoRN = new AnexoRN();

    if (InfraArray::contar($arrStrIds)) {

      $objDocumentoDTO = new DocumentoDTO();
      $objDocumentoDTO->setDblIdProcedimento($objEmailDTO->getDblIdProtocolo());
      $objDocumentoDTO->setDblIdDocumento($arrStrIds, InfraDTO::$OPER_IN);
      $objDocumentoDTO->setStrSinEmail('S');

      $arrObjDocumentoDTO = InfraArray::indexarArrInfraDTO($objDocumentoRN->listarSelecao($objDocumentoDTO),'IdDocumento');

      foreach ($arrStrIds as $strIdDocumento) {

        if (!isset($arrObjDocumentoDTO[$strIdDocumento])) {

          $objDocumentoDTO2 = new DocumentoDTO();
          $objDocumentoDTO2->retStrProtocoloDocumentoFormatado();
          $objDocumentoDTO2->retDblIdProcedimento();
          $objDocumentoDTO2->setDblIdDocumento($strIdDocumento);

          $objDocumentoDTO2 = $objDocumentoRN->consultarRN0005($objDocumentoDTO2);

          if ($objDocumentoDTO2 == null) {
            throw new InfraException('Documento n�o encontrado.');
          }

          if ($objDocumentoDTO2->getDblIdProcedimento() != $objEmailDTO->getDblIdProtocolo()) {
            throw new InfraException('Documento '.$objDocumentoDTO2->getStrProtocoloDocumentoFormatado().' n�o pertence ao processo.');
          }

          $objInfraException->adicionarValidacao('Documento '.$objDocumentoDTO2->getStrProtocoloDocumentoFormatado().' n�o pode ser enviado por e-mail.');
        }
      }

      $objInfraException->lancarValidacoes();

      //criar arquivos tempor�rios para os documentos selecionados
      foreach ($arrStrIds as $strIdDocumento) {

        $objDocumentoDTO = $arrObjDocumentoDTO[$strIdDocumento];

        $objDocumentoRN->bloquearProcessado($objDocumentoDTO);

        if ($objDocumentoDTO->getStrStaProtocoloProtocolo() == ProtocoloRN::$TP_DOCUMENTO_RECEBIDO) {

          $objAnexoDTO = new AnexoDTO();
          $objAnexoDTO->retStrNome();
          $objAnexoDTO->retNumIdAnexo();
          $objAnexoDTO->retStrProtocoloFormatadoProtocolo();
          $objAnexoDTO->setDblIdProtocolo($strIdDocumento);
          $objAnexoDTO->retDthInclusao();

          $arrObjAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);

          foreach ($arrObjAnexoDTO as $objAnexoDTO) {

            if ($objAnexoDTO == null) {
              throw new InfraException('Anexo n�o encontrado.');
            }

            $strNomeArquivo = InfraUtil::formatarNomeArquivo($objDocumentoDTO->getStrNomeSerie().'_'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'_'.$objAnexoDTO->getStrNome());

            $strNomeUpload = $objAnexoRN->gerarNomeArquivoTemporario();

            copy($objAnexoRN->obterLocalizacao($objAnexoDTO), DIR_SEI_TEMP.'/'.$strNomeUpload);

            $numTamanhoAnexo = filesize(DIR_SEI_TEMP.'/'.$strNomeUpload);

            $arrAnexos[] = array($strNomeUpload, $strNomeArquivo, InfraData::getStrDataHoraAtual(), $numTamanhoAnexo, InfraUtil::formatarTamanhoBytes($numTamanhoAnexo));
          }

        } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_EDITOR_EDOC && $objDocumentoDTO->getDblIdDocumentoEdoc() != null) {

          $objEDocRN = new EDocRN();
          $strHtml = $objEDocRN->consultarHTMLDocumentoRN1204($objDocumentoDTO);

          $strNomeArquivoHtml = InfraUtil::formatarNomeArquivo($objDocumentoDTO->getStrNomeSerie().'_'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'.html');
          $strNomeArquivoUploadHtml = $objAnexoRN->gerarNomeArquivoTemporario();

          if (file_put_contents(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml, $strHtml) === false) {
            throw new InfraException('Erro criando arquivo html tempor�rio para envio do e-mail.');
          }

          $numTamanhoHtml = filesize(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml);

          $arrAnexos[] = array($strNomeArquivoUploadHtml, $strNomeArquivoHtml, InfraData::getStrDataHoraAtual(), $numTamanhoHtml, InfraUtil::formatarTamanhoBytes($numTamanhoHtml));

        } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_EDITOR_INTERNO) {

          $objEditorDTO = new EditorDTO();
          $objEditorDTO->setDblIdDocumento($objDocumentoDTO->getDblIdDocumento());
          $objEditorDTO->setNumIdBaseConhecimento(null);
          $objEditorDTO->setStrSinCabecalho('S');
          $objEditorDTO->setStrSinRodape('S');
          $objEditorDTO->setStrSinCarimboPublicacao('S');
          $objEditorDTO->setStrSinIdentificacaoVersao('N');

          $objEditorRN = new EditorRN();
          $strHtml = $objEditorRN->consultarHtmlVersao($objEditorDTO);

          $strNomeArquivoHtml = InfraUtil::formatarNomeArquivo($objDocumentoDTO->getStrNomeSerie().'_'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'.html');
          $strNomeArquivoUploadHtml = $objAnexoRN->gerarNomeArquivoTemporario();

          if (file_put_contents(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml, $strHtml) === false) {
            throw new InfraException('Erro criando arquivo html tempor�rio para envio do e-mail.');
          }

          $numTamanhoHtml = filesize(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml);

          $arrAnexos[] = array($strNomeArquivoUploadHtml, $strNomeArquivoHtml, InfraData::getStrDataHoraAtual(), $numTamanhoHtml, InfraUtil::formatarTamanhoBytes($numTamanhoHtml));

        } else if ($objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_FORMULARIO_AUTOMATICO || $objDocumentoDTO->getStrStaDocumento() == DocumentoRN::$TD_FORMULARIO_GERADO) {

          $strHtml = $objDocumentoRN->consultarHtmlFormulario($objDocumentoDTO);

          $strNomeArquivoHtml = InfraUtil::formatarNomeArquivo($objDocumentoDTO->getStrNomeSerie().'_'.$objDocumentoDTO->getStrProtocoloDocumentoFormatado().'.html');
          $strNomeArquivoUploadHtml = $objAnexoRN->gerarNomeArquivoTemporario();

          if (file_put_contents(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml, $strHtml) === false) {
            throw new InfraException('Erro criando arquivo html tempor�rio para envio do e-mail.');
          }

          $numTamanhoHtml = filesize(DIR_SEI_TEMP.'/'.$strNomeArquivoUploadHtml);

          $arrAnexos[] = array($strNomeArquivoUploadHtml, $strNomeArquivoHtml, InfraData::getStrDataHoraAtual(), $numTamanhoHtml, InfraUtil::formatarTamanhoBytes($numTamanhoHtml));
        }
      }
    }

    $objInfraParametro = new InfraParametro(BancoSEI::getInstance());
    $numConversaoAnexoHtmlParaPdf = $objInfraParametro->getValor('SEI_EMAIL_CONVERTER_ANEXO_HTML_PARA_PDF', false);

		if ($numConversaoAnexoHtmlParaPdf === '1'){

		  $numAnexos = InfraArray::contar($arrAnexos);
		  for($i=0; $i<$numAnexos; $i++){

        if (substr($arrAnexos[$i][1],-4) == '.htm' || substr($arrAnexos[$i][1],-5) == '.html'){

          $strArquivoHtml = $arrAnexos[$i][0].'.html';

          rename(DIR_SEI_TEMP.'/'.$arrAnexos[$i][0], DIR_SEI_TEMP.'/'.$strArquivoHtml);

          $strArquivoPdf = $objAnexoRN->gerarNomeArquivoTemporario('.pdf');

          $strComandoPdf = DocumentoRN::montarComandoGeracaoPdf(DIR_SEI_TEMP.'/'.$strArquivoHtml, DIR_SEI_TEMP.'/'.$strArquivoPdf);

          $ret = shell_exec($strComandoPdf);
          if ($ret != ''){
            throw new InfraException('Erro gerando PDF.', null, "Comando - ".$strComandoPdf."\n\nRetorno - ".$ret);
          }

          unlink(DIR_SEI_TEMP.'/'.$strArquivoHtml);

          $strNomePdf = substr($arrAnexos[$i][1], 0, strlen($arrAnexos[$i][1])-(substr($arrAnexos[$i][1],-4)=='.htm'?4:5)).'.pdf';
          $numTamanhoPdf = filesize(DIR_SEI_TEMP.'/'.$strArquivoPdf);

          $arrAnexos[$i] = array($strArquivoPdf, $strNomePdf, InfraData::getStrDataHoraAtual(), $numTamanhoPdf, InfraUtil::formatarTamanhoBytes($numTamanhoPdf));
        }
      }
    }

		$arrObjAnexoDTO = array();
    $arrAnexosTemp = array();
		foreach($arrAnexos as $anexo){
			$objAnexoDTO = new AnexoDTO();
      $objAnexoDTO->setStrSinExclusaoAutomatica('N');
      $objAnexoDTO->setNumIdAnexo($anexo[0]);
      $objAnexoDTO->setStrNome($anexo[1]);
      $objAnexoDTO->setDthInclusao($anexo[2]);
      $objAnexoDTO->setNumTamanho($anexo[3]);
      $objAnexoDTO->setNumIdUsuario(SessaoSEI::getInstance()->getNumIdUsuario());
			$arrObjAnexoDTO[] = $objAnexoDTO;

      $arrAnexosTemp[$objAnexoDTO->getStrNome()] = DIR_SEI_TEMP.'/'.$objAnexoDTO->getNumIdAnexo();
    }

    $objEmailDTO->setArrObjAnexoDTO($arrObjAnexoDTO);
    $objEmailDTO->setArrAnexos($arrAnexosTemp);
  }

  public static function processar($arrObjEmailDTO){

    foreach ($arrObjEmailDTO as $objEmailDTO) {

      if ($objEmailDTO->isSetStrCC()){
        $strCC = $objEmailDTO->getStrCC();
      }else{
        $strCC = '';
      }

      if ($objEmailDTO->isSetStrCCO()){
        $strCCO = $objEmailDTO->getStrCCO();
      }else{
        $strCCO = '';
      }

      if ($objEmailDTO->isSetArrAnexos()){
        $arrAnexos = $objEmailDTO->getArrAnexos();
      }else{
        $arrAnexos = array();
      }

      InfraMail::enviarConfigurado(ConfiguracaoSEI::getInstance(), $objEmailDTO->getStrDe(), $objEmailDTO->getStrPara(), $strCC, $strCCO, $objEmailDTO->getStrAssunto(), $objEmailDTO->getStrMensagem(), "text/plain", $arrAnexos);
    }
  }
}
?>