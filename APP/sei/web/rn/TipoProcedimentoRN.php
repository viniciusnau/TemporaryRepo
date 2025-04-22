<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 03/12/2007 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.9.2
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class TipoProcedimentoRN extends InfraRN {

  public static $TS_EXCLUSIVO_OUVIDORIA = 1;
  public static $TS_PROCESSO_UNICO = 2;
  public static $TS_INTERNO_SISTEMA = 3;

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
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_EXCLUSIVO_OUVIDORIA);
      $objSinalizacaoDTO->setStrDescricao('Exclusivo da ouvidoria');
      $arrObjSinalizacaoDTO[] = $objSinalizacaoDTO;

      $objSinalizacaoDTO = new SinalizacaoDTO();
      $objSinalizacaoDTO->setStrStaSinalizacao(self::$TS_PROCESSO_UNICO);
      $objSinalizacaoDTO->setStrDescricao('Processo �nico no �rg�o por usu�rio interessado');
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

  protected function cadastrarRN0265Controlado(TipoProcedimentoDTO $objTipoProcedimentoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_cadastrar',__METHOD__,$objTipoProcedimentoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNomeRN0272($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrDescricaoRN0274($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrStaNivelAcessoSugestao($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrStaGrauSigiloSugestao($objTipoProcedimentoDTO, $objInfraException);
      $this->validarNumIdHipoteseLegalSugestao($objTipoProcedimentoDTO, $objInfraException);
      $this->validarNumIdPlanoTrabalho($objTipoProcedimentoDTO, $objInfraException);
      $this->validarArrObjRelTipoProcedimentoAssuntoDTO($objTipoProcedimentoDTO, $objInfraException);
      $this->validarArrObjTipoProcedRestricaoDTO($objTipoProcedimentoDTO, $objInfraException);
      $this->validarArrObjNivelAcessoPermitidoDTO($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrSinAtivoRN0277($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrSinInterno($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrSinOuvidoria($objTipoProcedimentoDTO, $objInfraException);
      $this->validarStrSinIndividual($objTipoProcedimentoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedimentoBD->cadastrar($objTipoProcedimentoDTO);
      
     	$arrObjRelTipoProcedimentoAssuntoDTO = $objTipoProcedimentoDTO->getArrObjRelTipoProcedimentoAssuntoDTO();
      	
     	$objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
      foreach($arrObjRelTipoProcedimentoAssuntoDTO as $objRelTipoProcedimentoAssuntoDTO){
	      $objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($ret->getNumIdTipoProcedimento());
        $objRelTipoProcedimentoAssuntoRN->cadastrarRN0285($objRelTipoProcedimentoAssuntoDTO);
	    }

      $arrObjTipoProcedRestricaoDTO = $objTipoProcedimentoDTO->getArrObjTipoProcedRestricaoDTO();

      $objTipoProcedRestricaoRN = new TipoProcedRestricaoRN();
      foreach($arrObjTipoProcedRestricaoDTO as $objTipoProcedRestricaoDTO){
        $objTipoProcedRestricaoDTO->setNumIdTipoProcedRestricao(null);
        $objTipoProcedRestricaoDTO->setNumIdTipoProcedimento($ret->getNumIdTipoProcedimento());
        $objTipoProcedRestricaoRN->cadastrar($objTipoProcedRestricaoDTO);
      }

      if (InfraArray::contar($arrObjTipoProcedRestricaoDTO)){
        CacheSEI::getInstance()->setAtributoVersao('SEI_TPNL');
      }

     	$arrObjNivelAcessoPermitidoDTO = $objTipoProcedimentoDTO->getArrObjNivelAcessoPermitidoDTO();
      	
     	$objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
      foreach($arrObjNivelAcessoPermitidoDTO as $objNivelAcessoPermitidoDTO){
	      $objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($ret->getNumIdTipoProcedimento());
        $objNivelAcessoPermitidoRN->cadastrar($objNivelAcessoPermitidoDTO);
	    }
	    
	    
      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Tipo de Processo.',$e);
    }
  }

  protected function alterarRN0266Controlado(TipoProcedimentoDTO $objTipoProcedimentoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_alterar',__METHOD__,$objTipoProcedimentoDTO);

  	  /*
      $objTipoProcedimentoDTOBanco = new TipoProcedimentoDTO();
      $objTipoProcedimentoDTOBanco->retTodos();    
      $objTipoProcedimentoDTOBanco->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
      
      $objTipoProcedimentoDTOBanco = $this->consultarRN0267($objTipoProcedimentoDTOBanco);
  	  */
        	   
      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objTipoProcedimentoDTO->isSetStrNome()){
        $this->validarStrNomeRN0272($objTipoProcedimentoDTO, $objInfraException);
      }
      
      if ($objTipoProcedimentoDTO->isSetStrDescricao()){
        $this->validarStrDescricaoRN0274($objTipoProcedimentoDTO, $objInfraException);
      }
      
      if ($objTipoProcedimentoDTO->isSetStrStaNivelAcessoSugestao()){
        $this->validarStrStaNivelAcessoSugestao($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetStrStaGrauSigiloSugestao()){
        $this->validarStrStaGrauSigiloSugestao($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetNumIdHipoteseLegalSugestao()){
        $this->validarNumIdHipoteseLegalSugestao($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetNumIdPlanoTrabalho()){
        $this->validarNumIdPlanoTrabalho($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetArrObjRelTipoProcedimentoAssuntoDTO()){
      	$this->validarArrObjRelTipoProcedimentoAssuntoDTO($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetArrObjTipoProcedRestricaoDTO()) {
        $this->validarArrObjTipoProcedRestricaoDTO($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetArrObjNivelAcessoPermitidoDTO()){
      	$this->validarArrObjNivelAcessoPermitidoDTO($objTipoProcedimentoDTO, $objInfraException);
      }
      
      if ($objTipoProcedimentoDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivoRN0277($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetStrSinInterno()){
        $this->validarStrSinInterno($objTipoProcedimentoDTO, $objInfraException);
      }

      if ($objTipoProcedimentoDTO->isSetStrSinOuvidoria()){
        $this->validarStrSinOuvidoria($objTipoProcedimentoDTO, $objInfraException);
      }
      
      if ($objTipoProcedimentoDTO->isSetStrSinIndividual()){
        
        $this->validarStrSinIndividual($objTipoProcedimentoDTO, $objInfraException);
        
        /*
        if ($objTipoProcedimentoDTOBanco->getStrSinIndividual() != $objTipoProcedimentoDTO->getStrSinIndividual() && $objTipoProcedimentoDTO->getStrSinIndividual()=='S'){
          
     	    $objProtocoloDTO = new ProtocoloDTO();
     	    $objProtocoloDTO->retDblIdProtocolo();
     	    $objProtocoloDTO->retStrSiglaOrgaoUnidadeGeradora();
     	    $objProtocoloDTO->retStrProtocoloFormatado();
     	    $objProtocoloDTO->retNumIdContatoParticipante();
     	    $objProtocoloDTO->setNumTipoFkProcedimento(InfraDTO::$TIPO_FK_OBRIGATORIA);
     	    $objProtocoloDTO->setNumTipoFkParticipante(InfraDTO::$TIPO_FK_OPCIONAL);
     	    $objProtocoloDTO->setNumIdTipoProcedimentoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
     	    $objProtocoloDTO->setStrStaParticipacaoParticipante(ParticipanteRN::$TP_INTERESSADO);
     	    
     	    $objProtocoloDTO->setOrdStrSiglaOrgaoUnidadeGeradora(InfraDTO::$TIPO_ORDENACAO_ASC);
     	    
     	    $objProtocoloRN = new ProtocoloRN();
       	  $objUsuarioRN = new UsuarioRN();
     	    $arrMsg = array();
     	    
     	    $arrObjProtocoloDTOPorOrgao = InfraArray::indexarArrInfraDTO($objProtocoloRN->listarRN0668($objProtocoloDTO),'SiglaOrgaoUnidadeGeradora',true);
     	    
     	    foreach($arrObjProtocoloDTOPorOrgao as $strSiglaOrgao => $arrObjProtocoloDTODoOrgao){
     	    
       	    $arrObjProtocoloDTO = InfraArray::indexarArrInfraDTO($arrObjProtocoloDTODoOrgao,'IdProtocolo',true);

       	    $arrDuplicados = array();
       	    $arrProtocolos = array_keys($arrObjProtocoloDTO);
       	    foreach($arrObjProtocoloDTO as $dblIdProtocolo => $arrObjProtocoloDTOParticipante){
  
       	      if (InfraArray::contar($arrObjProtocoloDTOParticipante)>1){
       	        $arrMsg[] = 'Processo '.$arrObjProtocoloDTOParticipante[0]->getStrProtocoloFormatado().' possui '.InfraArray::contar($arrObjProtocoloDTOParticipante).' interessados.';
       	      }else{
       	        
       	        if (InfraArray::contar($arrObjProtocoloDTOParticipante)==1 && $arrObjProtocoloDTOParticipante[0]->getNumIdContatoParticipante()==null){
       	           $arrMsg[] = 'Processo '.$arrObjProtocoloDTOParticipante[0]->getStrProtocoloFormatado().' n�o possui interessado.';
       	        }else{
       	        
         	        foreach($arrObjProtocoloDTOParticipante as $objProtocoloDTOParticipante){
           	        $objUsuarioDTO = new UsuarioDTO();
               	    $objUsuarioDTO->setBolExclusaoLogica(false);
               	    $objUsuarioDTO->retStrSigla();
               	    $objUsuarioDTO->retStrNome();
               	    $objUsuarioDTO->setNumIdContato($objProtocoloDTOParticipante->getNumIdContatoParticipante());
               	    
               	    $objUsuarioDTO = $objUsuarioRN->consultarRN0489($objUsuarioDTO);
               	    
               	    if ($objUsuarioDTO==null){
             	         $arrMsg[] = 'Processo '.$objProtocoloDTOParticipante->getStrProtocoloFormatado().' possui um interessado que n�o � usu�rio.';
               	    }else{
               	    
               	      $numIdParticipante = $objProtocoloDTOParticipante->getNumIdContatoParticipante();
               	      
               	      if (!isset($arrDuplicados[$numIdParticipante])){
                 	   
               	        $arrDuplicados[$numIdParticipante] = null;
               	        
                   	    foreach($arrProtocolos as $dblIdProtocoloTemp){
                   	      if ($dblIdProtocolo != $dblIdProtocoloTemp){
                   	        $arrObjProtocoloDTOTemp = $arrObjProtocoloDTO[$dblIdProtocoloTemp];
                   	        
                   	        foreach($arrObjProtocoloDTOTemp as $objProtocoloDTOTemp){
                   	          if ($objProtocoloDTOTemp->getNumIdContatoParticipante()==$numIdParticipante){
                   	            
                   	            if ($arrDuplicados[$numIdParticipante]==null){
                   	              $arrDuplicados[$numIdParticipante] = array();
                   	            }
                   	            
                   	            $arrDuplicados[$numIdParticipante][] = $objProtocoloDTOTemp->getStrProtocoloFormatado();
                   	          }
                   	        }
                   	      }
                   	    }
                   	    
               	        if (is_array($arrDuplicados[$numIdParticipante])){
               	           $arrMsg[] = 'Usu�rio "'.$objUsuarioDTO->getStrSigla().' / '.$objUsuarioDTO->getStrNome().'" consta como interessado em mais de um processo deste tipo no �rg�o '.$strSiglaOrgao.' ('.implode(',',$arrDuplicados[$numIdParticipante]).' e '.$objProtocoloDTOParticipante->getStrProtocoloFormatado().').';
               	        }
               	      }
               	    }
         	        }
       	        }
       	      }
       	    }
          }     	    
     	    $numValidacoes = InfraArray::contar($arrMsg);
     	    if ($numValidacoes){
   	        $objInfraException->adicionarValidacao('Foram encontrados '.$numValidacoes.' erros:\n'.implode('\n',$arrMsg));
     	    }
        }
        */
      }

      $objInfraException->lancarValidacoes();

      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $objTipoProcedimentoBD->alterar($objTipoProcedimentoDTO);
      
      if ($objTipoProcedimentoDTO->isSetArrObjRelTipoProcedimentoAssuntoDTO()) {
        
      	$objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
      	$objRelTipoProcedimentoAssuntoDTO = new RelTipoProcedimentoAssuntoDTO();
      	$objRelTipoProcedimentoAssuntoDTO->retTodos();
      	$objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
      	$objRelTipoProcedimentoAssuntoRN->excluirRN0286($objRelTipoProcedimentoAssuntoRN->listarRN0192($objRelTipoProcedimentoAssuntoDTO));
      	
      	$arrObjRelTipoProcedimentoAssuntoDTO = $objTipoProcedimentoDTO->getArrObjRelTipoProcedimentoAssuntoDTO();
      	
	      foreach($arrObjRelTipoProcedimentoAssuntoDTO as $objRelTipoProcedimentoAssuntoDTO){
	      	$objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
	      	$objRelTipoProcedimentoAssuntoRN->cadastrarRN0285($objRelTipoProcedimentoAssuntoDTO);
	      }
      }

      if ($objTipoProcedimentoDTO->isSetArrObjTipoProcedRestricaoDTO()) {

        $objTipoProcedRestricaoDTO = new TipoProcedRestricaoDTO();
        $objTipoProcedRestricaoDTO->retTodos();
        $objTipoProcedRestricaoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());

        $objTipoProcedRestricaoRN = new TipoProcedRestricaoRN();
        $arrObjTipoProcedRestricaoDTOAntigos = $objTipoProcedRestricaoRN->listar($objTipoProcedRestricaoDTO);

        $arrObjTipoProcedRestricaoDTONovos = $objTipoProcedimentoDTO->getArrObjTipoProcedRestricaoDTO();

        $arrObjTipoProcedRestricaoDTOExclusao = array();
        foreach($arrObjTipoProcedRestricaoDTOAntigos as $objTipoProcedRestricaoDTOAntigo){
          $bolAchouRestricao = false;
          foreach($arrObjTipoProcedRestricaoDTONovos as $objTipoProcedRestricaoDTONovo){
            if ($objTipoProcedRestricaoDTOAntigo->getNumIdOrgao()==$objTipoProcedRestricaoDTONovo->getNumIdOrgao() && $objTipoProcedRestricaoDTOAntigo->getNumIdUnidade()==$objTipoProcedRestricaoDTONovo->getNumIdUnidade()){
              $bolAchouRestricao = true;
              break;
            }
          }

          if (!$bolAchouRestricao){
            $arrObjTipoProcedRestricaoDTOExclusao[] = $objTipoProcedRestricaoDTOAntigo;
          }
        }

        $objTipoProcedRestricaoRN->excluir($arrObjTipoProcedRestricaoDTOExclusao);

        foreach($arrObjTipoProcedRestricaoDTONovos as $objTipoProcedRestricaoDTONovo){
          $bolAchouRestricao = false;
          foreach($arrObjTipoProcedRestricaoDTOAntigos as $objTipoProcedRestricaoDTOAntigo){
            if ($objTipoProcedRestricaoDTOAntigo->getNumIdOrgao()==$objTipoProcedRestricaoDTONovo->getNumIdOrgao() && $objTipoProcedRestricaoDTOAntigo->getNumIdUnidade()==$objTipoProcedRestricaoDTONovo->getNumIdUnidade()){
              $bolAchouRestricao = true;
              break;
            }
          }

          if (!$bolAchouRestricao){
            $objTipoProcedRestricaoDTONovo->setNumIdTipoProcedRestricao(null);
            $objTipoProcedRestricaoDTONovo->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
            $objTipoProcedRestricaoRN->cadastrar($objTipoProcedRestricaoDTONovo);
          }
        }

        CacheSEI::getInstance()->removerAtributo('SEI_TPR_'.$objTipoProcedimentoDTO->getNumIdTipoProcedimento());

        CacheSEI::getInstance()->setAtributoVersao('SEI_TPNL');
      }

      if ($objTipoProcedimentoDTO->isSetArrObjNivelAcessoPermitidoDTO()) {
        
      	$objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
      	$objNivelAcessoPermitidoDTO = new NivelAcessoPermitidoDTO();
      	$objNivelAcessoPermitidoDTO->retNumIdNivelAcessoPermitido();
      	$objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
      	$objNivelAcessoPermitidoRN->excluir($objNivelAcessoPermitidoRN->listar($objNivelAcessoPermitidoDTO));
      	
      	$arrObjNivelAcessoPermitidoDTO = $objTipoProcedimentoDTO->getArrObjNivelAcessoPermitidoDTO();
      	
	      foreach($arrObjNivelAcessoPermitidoDTO as $objNivelAcessoPermitidoDTO){
	      	$objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
	      	$objNivelAcessoPermitidoRN->cadastrar($objNivelAcessoPermitidoDTO);
	      }
      }
      
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Tipo de Processo.',$e);
    }
  }

  protected function excluirRN0268Controlado($arrObjTipoProcedimentoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_excluir',__METHOD__,$arrObjTipoProcedimentoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();


      $arrIdTipoProcedimento = InfraArray::converterArrInfraDTO($arrObjTipoProcedimentoDTO, 'IdTipoProcedimento');

      if (InfraArray::contar($arrIdTipoProcedimento)) {

        $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
        $objTipoProcedimentoDTO->setBolExclusaoLogica(false);
        $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
        $objTipoProcedimentoDTO->retStrNome();
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcedimento, InfraDTO::$OPER_IN);

        $arrObjTipoProcedimentoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0244($objTipoProcedimentoDTO), 'IdTipoProcedimento');

        $objProcedimentoRN = new ProcedimentoRN();
        $objRelBaseConhecTipoProcedRN = new RelBaseConhecTipoProcedRN();
        $objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
        $objTipoProcedRestricaoRN = new TipoProcedRestricaoRN();
        $objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
        $objTipoProcedimentoEscolhaRN = new TipoProcedimentoEscolhaRN();
        $objOperacaoServicoRN = new OperacaoServicoRN();
        $objRelControleInternoTipoProcRN = new RelControleInternoTipoProcRN();
        $objRelUsuarioTipoProcedRN = new RelUsuarioTipoProcedRN();

        foreach($arrIdTipoProcedimento as $numIdTipoProcedimento){

          $strNome = $arrObjTipoProcedimentoDTOConsulta[$numIdTipoProcedimento]->getStrNome();

          $objProcedimentoDTO = new ProcedimentoDTO();
          $objProcedimentoDTO->setNumMaxRegistrosRetorno(1);
          $objProcedimentoDTO->retDblIdProcedimento();
          $objProcedimentoDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          if ($objProcedimentoRN->consultarRN0201($objProcedimentoDTO) != null) {
            $objInfraException->adicionarValidacao('Existem processos utilizando o tipo de processo "'.$strNome.'".');
          }

          $objRelBaseConhecTipoProcedDTO = new RelBaseConhecTipoProcedDTO();
          $objRelBaseConhecTipoProcedDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          if ($objRelBaseConhecTipoProcedRN->contar($objRelBaseConhecTipoProcedDTO) > 0) {
            $objInfraException->adicionarValidacao('Existem bases de conhecimento associadas ao tipo de processo "'.$strNome.'".');
          }

          $objRelControleInternoTipoProcDTO = new RelControleInternoTipoProcDTO();
          $objRelControleInternoTipoProcDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          if ($objRelControleInternoTipoProcRN->contar($objRelControleInternoTipoProcDTO)) {
            $objInfraException->lancarValidacao('Tipo de processo faz parte de um Crit�rio de Controle Interno.');
          }

          $objRelTipoProcedimentoAssuntoDTO = new RelTipoProcedimentoAssuntoDTO();
          $objRelTipoProcedimentoAssuntoDTO->retNumIdTipoProcedimento();
          $objRelTipoProcedimentoAssuntoDTO->retNumIdAssuntoProxy();
          $objRelTipoProcedimentoAssuntoDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objRelTipoProcedimentoAssuntoRN->excluirRN0286($objRelTipoProcedimentoAssuntoRN->listarRN0192($objRelTipoProcedimentoAssuntoDTO));

          $objTipoProcedRestricaoDTO = new TipoProcedRestricaoDTO();
          $objTipoProcedRestricaoDTO->retNumIdTipoProcedRestricao();
          $objTipoProcedRestricaoDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objTipoProcedRestricaoRN->excluir($objTipoProcedRestricaoRN->listar($objTipoProcedRestricaoDTO));

          $objNivelAcessoPermitidoDTO = new NivelAcessoPermitidoDTO();
          $objNivelAcessoPermitidoDTO->retNumIdNivelAcessoPermitido();
          $objNivelAcessoPermitidoDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objNivelAcessoPermitidoRN->excluir($objNivelAcessoPermitidoRN->listar($objNivelAcessoPermitidoDTO));

          $objTipoProcedimentoEscolhaDTO = new TipoProcedimentoEscolhaDTO();
          $objTipoProcedimentoEscolhaDTO->retNumIdTipoProcedimento();
          $objTipoProcedimentoEscolhaDTO->retNumIdUnidade();
          $objTipoProcedimentoEscolhaDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objTipoProcedimentoEscolhaRN->excluir($objTipoProcedimentoEscolhaRN->listar($objTipoProcedimentoEscolhaDTO));

          $objOperacaoServicoDTO = new OperacaoServicoDTO();
          $objOperacaoServicoDTO->retNumIdOperacaoServico();
          $objOperacaoServicoDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objOperacaoServicoRN->excluir($objOperacaoServicoRN->listar($objOperacaoServicoDTO));

          $objRelUsuarioTipoProcedDTO = new RelUsuarioTipoProcedDTO();
          $objRelUsuarioTipoProcedDTO->retNumIdTipoProcedimento();
          $objRelUsuarioTipoProcedDTO->retNumIdUsuario();
          $objRelUsuarioTipoProcedDTO->retNumIdUnidade();
          $objRelUsuarioTipoProcedDTO->setNumIdTipoProcedimento($numIdTipoProcedimento);
          $objRelUsuarioTipoProcedRN->excluir($objRelUsuarioTipoProcedRN->listar($objRelUsuarioTipoProcedDTO));
        }

        $objInfraException->lancarValidacoes();

        $arrObjTipoProcedimentoAPI = array();
        foreach ($arrObjTipoProcedimentoDTOConsulta as $objTipoProcedimentoDTO) {
          $objTipoProcedimentoAPI = new TipoProcedimentoAPI();
          $objTipoProcedimentoAPI->setIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
          $objTipoProcedimentoAPI->setNome($objTipoProcedimentoDTO->getStrNome());
          $arrObjTipoProcedimentoAPI[] = $objTipoProcedimentoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('excluirTipoProcesso', $arrObjTipoProcedimentoAPI);
        }

        $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
        for ($i = 0; $i < count($arrObjTipoProcedimentoDTO); $i++) {
          $objTipoProcedimentoBD->excluir($arrObjTipoProcedimentoDTO[$i]);
        }
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Tipo de Processo.',$e);
    }
  }

  protected function desativarRN0269Controlado($arrObjTipoProcedimentoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_desativar',__METHOD__,$arrObjTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();
      
      //$objInfraException->lancarValidacoes();

      $arrIdTipoProcedimento = InfraArray::converterArrInfraDTO($arrObjTipoProcedimentoDTO, 'IdTipoProcedimento');

      if (InfraArray::contar($arrIdTipoProcedimento)) {

        $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
        for ($i = 0; $i < InfraArray::contar($arrObjTipoProcedimentoDTO); $i++) {
          $objTipoProcedimentoBD->desativar($arrObjTipoProcedimentoDTO[$i]);
        }

        $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
        $objTipoProcedimentoDTO->setBolExclusaoLogica(false);
        $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
        $objTipoProcedimentoDTO->retStrNome();
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcedimento, InfraDTO::$OPER_IN);

        $arrObjTipoProcedimentoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0244($objTipoProcedimentoDTO), 'IdTipoProcedimento');

        $arrObjTipoProcedimentoAPI = array();
        foreach ($arrObjTipoProcedimentoDTOConsulta as $objTipoProcedimentoDTO) {
          $objTipoProcedimentoAPI = new TipoProcedimentoAPI();
          $objTipoProcedimentoAPI->setIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
          $objTipoProcedimentoAPI->setNome($objTipoProcedimentoDTO->getStrNome());
          $arrObjTipoProcedimentoAPI[] = $objTipoProcedimentoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('desativarTipoProcesso', $arrObjTipoProcedimentoAPI);
        }
      }
        //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Tipo de Processo.',$e);
    }
  }

  protected function reativarRN0352Controlado($arrObjTipoProcedimentoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_reativar',__METHOD__,$arrObjTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $arrIdTipoProcedimento = InfraArray::converterArrInfraDTO($arrObjTipoProcedimentoDTO, 'IdTipoProcedimento');

      if (InfraArray::contar($arrIdTipoProcedimento)) {

        $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
        for($i=0;$i<InfraArray::contar($arrObjTipoProcedimentoDTO);$i++){
          $objTipoProcedimentoBD->reativar($arrObjTipoProcedimentoDTO[$i]);
        }

        $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
        $objTipoProcedimentoDTO->setBolExclusaoLogica(false);
        $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
        $objTipoProcedimentoDTO->retStrNome();
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcedimento, InfraDTO::$OPER_IN);

        $arrObjTipoProcedimentoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarRN0244($objTipoProcedimentoDTO), 'IdTipoProcedimento');

        $arrObjTipoProcedimentoAPI = array();
        foreach ($arrObjTipoProcedimentoDTOConsulta as $objTipoProcedimentoDTO) {
          $objTipoProcedimentoAPI = new TipoProcedimentoAPI();
          $objTipoProcedimentoAPI->setIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento());
          $objTipoProcedimentoAPI->setNome($objTipoProcedimentoDTO->getStrNome());
          $arrObjTipoProcedimentoAPI[] = $objTipoProcedimentoAPI;
        }

        foreach ($SEI_MODULOS as $seiModulo) {
          $seiModulo->executar('reativarTipoProcesso', $arrObjTipoProcedimentoAPI);
        }
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Tipos de Processo.',$e);
    }
  }

  protected function consultarRN0267Conectado(TipoProcedimentoDTO $objTipoProcedimentoDTO){
    try {

    	
      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_consultar',__METHOD__,$objTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedimentoBD->consultar($objTipoProcedimentoDTO);

      //Auditoria
      
      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Tipo de Processo.',$e);
    }
  }

  protected function listarRN0244Conectado(TipoProcedimentoDTO $objTipoProcedimentoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_listar',__METHOD__,$objTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();
      
      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedimentoBD->listar($objTipoProcedimentoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Processo.',$e);
    }
  }

  protected function pesquisarConectado(TipoProcedimentoDTO $objTipoProcedimentoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_listar',__METHOD__,$objTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedimentoDTO = InfraString::tratarPalavrasPesquisaDTO($objTipoProcedimentoDTO,"Nome");

      if ($objTipoProcedimentoDTO->isSetNumIdAssunto()){
        $objRelTipoProcedimentoAssuntoRN = new RelTipoProcedimentoAssuntoRN();
        $objRelTipoProcedimentoAssuntoDTO = new RelTipoProcedimentoAssuntoDTO();
        $objRelTipoProcedimentoAssuntoDTO->retNumIdTipoProcedimento();
        $objRelTipoProcedimentoAssuntoDTO->setNumIdAssunto($objTipoProcedimentoDTO->getNumIdAssunto());
        $arrObjRelTipoProcedimentoAssuntoDTO = $objRelTipoProcedimentoAssuntoRN->listarRN0192($objRelTipoProcedimentoAssuntoDTO);
        if(InfraArray::contar($arrObjRelTipoProcedimentoAssuntoDTO)) {
          $arrIdTipoProcessimento = InfraArray::converterArrInfraDTO($arrObjRelTipoProcedimentoAssuntoDTO,"IdTipoProcedimento");
          $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcessimento, InfraDTO::$OPER_IN);
        }else{
          $objTipoProcedimentoDTO->setNumIdTipoProcedimento(null);
        }
      }

      if ($objTipoProcedimentoDTO->isSetArrObjNivelAcessoPermitidoDTO()){
        $objNivelAcessoPermitidoRN = new NivelAcessoPermitidoRN();
        $objNivelAcessoPermitidoDTO = new NivelAcessoPermitidoDTO();
        $objNivelAcessoPermitidoDTO->retNumIdTipoProcedimento();
        $objNivelAcessoPermitidoDTO->setStrStaNivelAcesso(InfraArray::converterArrInfraDTO($objTipoProcedimentoDTO->getArrObjNivelAcessoPermitidoDTO(),'StaNivelAcesso'), InfraDTO::$OPER_IN);
        $arrObjNivelAcessoPermitidoDTO = $objNivelAcessoPermitidoRN->listar($objNivelAcessoPermitidoDTO);
        if(InfraArray::contar($arrObjNivelAcessoPermitidoDTO)) {
          $arrIdTipoProcessimento = InfraArray::converterArrInfraDTO($arrObjNivelAcessoPermitidoDTO,"IdTipoProcedimento");
          $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcessimento, InfraDTO::$OPER_IN);
        }else{
          $objTipoProcedimentoDTO->setNumIdTipoProcedimento(null);
        }
      }

      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedimentoBD->listar($objTipoProcedimentoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Tipos de Processo.',$e);
    }
  }

  protected function contarRN0270Conectado(TipoProcedimentoDTO $objTipoProcedimentoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('tipo_procedimento_listar',__METHOD__,$objTipoProcedimentoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objTipoProcedimentoBD = new TipoProcedimentoBD($this->getObjInfraIBanco());
      $ret = $objTipoProcedimentoBD->contar($objTipoProcedimentoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Tipos de Processo.',$e);
    }
  }

  private function validarStrNomeRN0272(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objTipoProcedimentoDTO->setStrNome(trim($objTipoProcedimentoDTO->getStrNome()));
      
	    if (strlen($objTipoProcedimentoDTO->getStrNome())>100){
	      $objInfraException->adicionarValidacao('Nome possui tamanho superior a 100 caracteres.');
	    }
	    
      $dto = new TipoProcedimentoDTO();
      $dto->retStrSinAtivo();
      $dto->setNumIdTipoProcedimento($objTipoProcedimentoDTO->getNumIdTipoProcedimento(),InfraDTO::$OPER_DIFERENTE);
      $dto->setStrNome($objTipoProcedimentoDTO->getStrNome(),InfraDTO::$OPER_IGUAL);
      $dto->setStrSinOuvidoria($objTipoProcedimentoDTO->getStrSinOuvidoria(),InfraDTO::$OPER_IGUAL);
      $dto->setBolExclusaoLogica(false);
          
      $dto = $this->consultarRN0267($dto);
      if ($dto != NULL){
        if ($dto->getStrSinAtivo() == 'S')
          $objInfraException->adicionarValidacao('Existe outra ocorr�ncia de Tipo de Processo que utiliza o mesmo Nome.');
        else
          $objInfraException->adicionarValidacao('Existe ocorr�ncia inativa de Tipo de Processo que utiliza o mesmo Nome.');    	
      }
	    
    }
  }

  private function validarStrDescricaoRN0274(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrDescricao())){
      //$objInfraException->adicionarValidacao('Descri��o n�o informada.');
      $objTipoProcedimentoDTO->setStrDescricao(null);
    }else{
      $objTipoProcedimentoDTO->setStrDescricao(trim($objTipoProcedimentoDTO->getStrDescricao()));      
      
	    if (strlen($objTipoProcedimentoDTO->getStrDescricao())>250){
	      $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 250 caracteres.');
	    }
    }
  }

  private function validarStrSinAtivoRN0277(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTipoProcedimentoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }
  
  private function validarStrSinInterno(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrSinInterno())){
      $objInfraException->adicionarValidacao('Sinalizador de Interno do Sistema n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTipoProcedimentoDTO->getStrSinInterno())){
        $objInfraException->adicionarValidacao('Sinalizador de Interno do Sistema inv�lido.');
      }
    }
  }
  
  private function validarStrSinOuvidoria(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrSinOuvidoria())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclusivo da Ouvidoria n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTipoProcedimentoDTO->getStrSinOuvidoria())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclusivo da Ouvidoria inv�lido.');
      }
    }
  }

  private function validarStrSinIndividual(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrSinIndividual())){
      $objInfraException->adicionarValidacao('Sinalizador de Tipo de Processo Individual n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objTipoProcedimentoDTO->getStrSinIndividual())){
        $objInfraException->adicionarValidacao('Sinalizador de Tipo de Processo Individual inv�lido.');
      }
    }
  }

  private function validarStrStaNivelAcessoSugestao(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrStaNivelAcessoSugestao())){
      $objInfraException->adicionarValidacao('Sugest�o para o n�vel de acesso n�o informada.');
    }else{
      
      $objProtocoloRN = new ProtocoloRN();
      $arr = $objProtocoloRN->listarNiveisAcessoRN0878();
      
      foreach($arr as $dto) {
        if ($dto->getStrStaNivel() == $objTipoProcedimentoDTO->getStrStaNivelAcessoSugestao())
          return;
      }
      $objInfraException->adicionarValidacao('Sugest�o para o n�vel de acesso inv�lida.');
    }
  }

  private function validarStrStaGrauSigiloSugestao(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if ($objTipoProcedimentoDTO->getStrStaNivelAcessoSugestao()==ProtocoloRN::$NA_SIGILOSO){
      if (InfraString::isBolVazia($objTipoProcedimentoDTO->getStrStaGrauSigiloSugestao())){
        $objTipoProcedimentoDTO->setStrStaGrauSigiloSugestao(null);
      }else{
        if (!in_array($objTipoProcedimentoDTO->getStrStaGrauSigiloSugestao(),InfraArray::converterArrInfraDTO(ProtocoloRN::listarGrausSigiloso(),'StaGrau'))){
          $objInfraException->adicionarValidacao('Grau do sigilo inv�lido.');
        }
      }
    }else{
      $objTipoProcedimentoDTO->setStrStaGrauSigiloSugestao(null);
    }
  }

  private function validarNumIdHipoteseLegalSugestao(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getNumIdHipoteseLegalSugestao())){
      $objTipoProcedimentoDTO->setNumIdHipoteseLegalSugestao(null);
    }
  }

  private function validarNumIdPlanoTrabalho(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objTipoProcedimentoDTO->getNumIdPlanoTrabalho())){
      $objTipoProcedimentoDTO->setNumIdPlanoTrabalho(null);
    }
  }

  private function validarArrObjRelTipoProcedimentoAssuntoDTO(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
  	//
  }

  private function validarArrObjTipoProcedRestricaoDTO(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
    $arrObjTipoProcedRestricaoDTO = $objTipoProcedimentoDTO->getArrObjTipoProcedRestricaoDTO();

    $objUnidadeRN = new UnidadeRN();

    $numRestricoes = InfraArray::contar($arrObjTipoProcedRestricaoDTO);

    for($i=0; $i<$numRestricoes; $i++){

      $objTipoProcedRestricaoDTO = $arrObjTipoProcedRestricaoDTO[$i];

      if (InfraString::isBolVazia($objTipoProcedRestricaoDTO->getNumIdOrgao())){
        $objInfraException->lancarValidacao('�rg�o da restri��o n�o informado.');
      }

      if (InfraString::isBolVazia($objTipoProcedRestricaoDTO->getNumIdUnidade())){

        $objTipoProcedRestricaoDTO->setNumIdUnidade(null);

        //se a unidade � nula s� pode haver um registro para o orgao nas restricoes
        for($j=0;$j<$numRestricoes;$j++){
          if ($j!=$i && $arrObjTipoProcedRestricaoDTO[$j]->getNumIdOrgao()==$objTipoProcedRestricaoDTO->getNumIdOrgao()){
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
        $objUnidadeDTO->setNumIdUnidade($objTipoProcedRestricaoDTO->getNumIdUnidade());

        $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

        if ($objUnidadeDTO==null){
          throw new InfraException('Unidade da restri��o ['.$objTipoProcedRestricaoDTO->getNumIdUnidade().'] n�o encontrada.');
        }

        if ($objUnidadeDTO->getNumIdOrgao()!=$objTipoProcedRestricaoDTO->getNumIdOrgao()){
          throw new InfraException('�rg�o da unidade '.$objUnidadeDTO->getStrSigla().'/'.$objUnidadeDTO->getStrSiglaOrgao().' n�o � igual ao �rg�o da restri��o.');
        }
      }
    }
  }

  private function validarArrObjNivelAcessoPermitidoDTO(TipoProcedimentoDTO $objTipoProcedimentoDTO, InfraException $objInfraException){
  	$arr = InfraArray::indexarArrInfraDTO($objTipoProcedimentoDTO->getArrObjNivelAcessoPermitidoDTO(),'StaNivelAcesso',true);
  	
  	if (InfraArray::contar($arr)==0){
  		$objInfraException->adicionarValidacao('N�veis de acesso permitidos n�o informados.');
  	}
  	
  	foreach(array_keys($arr) as $staNivelAcesso){
  		if (InfraArray::contar($arr[$staNivelAcesso])>1){
  			$objInfraException->adicionarValidacao('N�vel de acesso permitido duplicado.');
  		}
  	}
  }

  protected function listarNaoLiberadosNaUnidadeConectado(){

    try{

      $strCache = 'SEI_TPNL_'.CacheSEI::getInstance()->getAtributoVersao('SEI_TPNL').'_'.SessaoSEI::getInstance()->getNumIdUnidadeAtual();

      $arrCache = CacheSEI::getInstance()->getAtributo($strCache);

      if ($arrCache == null) {

        $objTipoProcedRestricaoDTO = new TipoProcedRestricaoDTO();
        $objTipoProcedRestricaoDTO->retNumIdTipoProcedimento();
        $objTipoProcedRestricaoDTO->retNumIdOrgao();
        $objTipoProcedRestricaoDTO->retNumIdUnidade();

        $objTipoProcedRestricaoRN = new TipoProcedRestricaoRN();
        $arrObjTipoProcedRestricaoDTO = InfraArray::indexarArrInfraDTO($objTipoProcedRestricaoRN->listar($objTipoProcedRestricaoDTO), 'IdTipoProcedimento', true);

        $numIdOrgao = SessaoSEI::getInstance()->getNumIdOrgaoUnidadeAtual();
        $numIdUnidade = SessaoSEI::getInstance()->getNumIdUnidadeAtual();

        $arrCache = array();
        foreach ($arrObjTipoProcedRestricaoDTO as $numIdTipoProcedimento => $arrRestricoesTipo) {
          $bolPermitido = false;
          foreach ($arrRestricoesTipo as $objRestricao) {
            if ($objRestricao->getNumIdOrgao() == $numIdOrgao && ($objRestricao->getNumIdUnidade() == null || $objRestricao->getNumIdUnidade() == $numIdUnidade)) {
              $bolPermitido = true;
            }
          }
          if (!$bolPermitido) {
            $arrCache[] = $numIdTipoProcedimento;
          }
        }

        CacheSEI::getInstance()->setAtributo($strCache, $arrCache, CacheSEI::getInstance()->getNumTempo());
      }

      return InfraArray::gerarArrInfraDTO('TipoProcedimentoDTO','IdTipoProcedimento',$arrCache);

    }catch(Exception $e){
      throw new InfraException('Erro verificando tipos de processos n�o liberados para a unidade.', $e);
    }
  }

  protected function listarTiposUnidadeConectado(TipoProcedimentoDTO $parObjTipoProcedimentoDTO){
    try{

      $arrIdTipoProcedimentoNaoLiberados = InfraArray::converterArrInfraDTO($this->listarNaoLiberadosNaUnidade(),'IdTipoProcedimento');
      $arrIdTipoProcedimentoUnidade = array();

      if ($parObjTipoProcedimentoDTO->getStrSinSomenteUtilizados()=='S'){

        $objTipoProcedimentoEscolhaDTO = new TipoProcedimentoEscolhaDTO();
        $objTipoProcedimentoEscolhaDTO->retNumIdTipoProcedimento();
        $objTipoProcedimentoEscolhaDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

        if (InfraArray::contar($arrIdTipoProcedimentoNaoLiberados)){
          $objTipoProcedimentoEscolhaDTO->setNumIdTipoProcedimento($arrIdTipoProcedimentoNaoLiberados, InfraDTO::$OPER_NOT_IN);
        }

        $objTipoProcedimentoEscolhaRN = new TipoProcedimentoEscolhaRN();
        $arrIdTipoProcedimentoUnidade = InfraArray::converterArrInfraDTO($objTipoProcedimentoEscolhaRN->listar($objTipoProcedimentoEscolhaDTO), 'IdTipoProcedimento');

        if (count($arrIdTipoProcedimentoUnidade)==0){
          return array();
        }
      }

      $objUnidadeDTO = new UnidadeDTO();
      $objUnidadeDTO->setBolExclusaoLogica(false);
      $objUnidadeDTO->retStrSinOuvidoria();
      $objUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

      $objUnidadeRN = new UnidadeRN();
      $objUnidadeDTO = $objUnidadeRN->consultarRN0125($objUnidadeDTO);

      if ($objUnidadeDTO==null){
        throw new InfraException('Unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'/'.SessaoSEI::getInstance()->getStrSiglaOrgaoUnidadeAtual().' n�o encontrada no SEI.');
      }

      $objTipoProcedimentoDTO = new TipoProcedimentoDTO();
      $objTipoProcedimentoDTO->retNumIdTipoProcedimento();
      $objTipoProcedimentoDTO->retStrNome();
      $objTipoProcedimentoDTO->retStrSinOuvidoria();

      if ($objUnidadeDTO->getStrSinOuvidoria()=='N'){
        $objTipoProcedimentoDTO->setStrSinOuvidoria('N');
      }

      $objTipoProcedimentoDTO->setStrSinInterno('N');

      if (InfraArray::contar($arrIdTipoProcedimentoUnidade)){
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcedimentoUnidade, InfraDTO::$OPER_IN);
      }else if (InfraArray::contar($arrIdTipoProcedimentoNaoLiberados)){
        $objTipoProcedimentoDTO->setNumIdTipoProcedimento($arrIdTipoProcedimentoNaoLiberados, InfraDTO::$OPER_NOT_IN);
      }

      $objTipoProcedimentoDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

      $ret = $this->listarRN0244($objTipoProcedimentoDTO);

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando tipos de processo da unidade.', $e);
    }
  }
}
?>