<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 25/09/2009 - criado por fbv@trf4.gov.br
*
* Vers�o do Gerador de C�digo: 1.29.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class BlocoRN extends InfraRN {

  public static $TB_ASSINATURA = 'A';
  public static $TB_REUNIAO = 'R';
  public static $TB_INTERNO = 'I';
  
  public static $TE_ABERTO = 'A';
  public static $TE_DISPONIBILIZADO = 'D';
  public static $TE_RETORNADO = 'R';
  public static $TE_CONCLUIDO = 'C';
  public static $TE_RECEBIDO = 'B';

  public static $TA_TODAS = 'T';
  public static $TA_MINHAS = 'M';

  
  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  public function listarValoresEstadoRN1265(){
    try {

      $objArrEstadoBlocoDTO = array();

      $objEstadoBlocoDTO = new EstadoBlocoDTO();
      $objEstadoBlocoDTO->setStrStaEstado(self::$TE_ABERTO);
      $objEstadoBlocoDTO->setStrDescricao('Gerado');
      $objArrEstadoBlocoDTO[] = $objEstadoBlocoDTO;

      $objEstadoBlocoDTO = new EstadoBlocoDTO();
      $objEstadoBlocoDTO->setStrStaEstado(self::$TE_DISPONIBILIZADO);
      $objEstadoBlocoDTO->setStrDescricao('Disponibilizado');
      $objArrEstadoBlocoDTO[] = $objEstadoBlocoDTO;

      $objEstadoBlocoDTO = new EstadoBlocoDTO();
      $objEstadoBlocoDTO->setStrStaEstado(self::$TE_RECEBIDO);
      $objEstadoBlocoDTO->setStrDescricao('Recebido');
      $objArrEstadoBlocoDTO[] = $objEstadoBlocoDTO;

      $objEstadoBlocoDTO = new EstadoBlocoDTO();
      $objEstadoBlocoDTO->setStrStaEstado(self::$TE_RETORNADO);
      $objEstadoBlocoDTO->setStrDescricao('Retornado');
      $objArrEstadoBlocoDTO[] = $objEstadoBlocoDTO;
      
      $objEstadoBlocoDTO = new EstadoBlocoDTO();
      $objEstadoBlocoDTO->setStrStaEstado(self::$TE_CONCLUIDO);
      $objEstadoBlocoDTO->setStrDescricao('Conclu�do');
      $objArrEstadoBlocoDTO[] = $objEstadoBlocoDTO;

      return $objArrEstadoBlocoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Estado.',$e);
    }
  }
  
  public function listarValoresTipo(){
    try {

      $arrObjTipoDTO = array();

      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TB_ASSINATURA);
      $objTipoDTO->setStrDescricao('Assinatura');
      $arrObjTipoDTO[] = $objTipoDTO;

      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TB_REUNIAO);
      $objTipoDTO->setStrDescricao('Reuni�o');
      $arrObjTipoDTO[] = $objTipoDTO;
      
      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TB_INTERNO);
      $objTipoDTO->setStrDescricao('Interno');
      $arrObjTipoDTO[] = $objTipoDTO;

      
      return $arrObjTipoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Tipo.',$e);
    }
  }  

  private function validarStrStaTipoRN1266(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getStrStaTipo())){
      $objInfraException->adicionarValidacao('Tipo n�o informado.');
    }else{
      if (!in_array($objBlocoDTO->getStrStaTipo(),InfraArray::converterArrInfraDTO($this->listarValoresTipo(),'StaTipo'))){
        $objInfraException->adicionarValidacao('Tipo inv�lido.');
      }
    }
  }

  private function validarNumIdUnidadeRN1267(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getNumIdUnidade())){
      $objInfraException->adicionarValidacao('Unidade n�o informada.');
    }
  }

  private function validarNumIdUsuarioRN1268(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getNumIdUsuario())){
      $objInfraException->adicionarValidacao('Usu�rio n�o informado.');
    }
  }

  private function validarStrDescricaoRN1269(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getStrDescricao())){
      $objBlocoDTO->setStrDescricao(null);
    }else{
      $objBlocoDTO->setStrDescricao(trim($objBlocoDTO->getStrDescricao()));
      $objBlocoDTO->setStrDescricao(InfraUtil::filtrarISO88591($objBlocoDTO->getStrDescricao()));
      if (strlen($objBlocoDTO->getStrDescricao())>$this->getNumMaxTamanhoDescricao()){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a '.$this->getNumMaxTamanhoDescricao().' caracteres.');
      }
    }
  }

  public function getNumMaxTamanhoDescricao(){
    return 250;
  }

  private function validarStrAnotacaoRN1270(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getStrAnotacao())){
      $objBlocoDTO->setStrAnotacao(null);
    }else{
      $objBlocoDTO->setStrAnotacao(trim($objBlocoDTO->getStrAnotacao()));
    }
  }

  private function validarStrIdxBlocoRN1271(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getStrIdxBloco())){
      $objBlocoDTO->setStrIdxBloco(null);
    }else{
      $objBlocoDTO->setStrIdxBloco(trim($objBlocoDTO->getStrIdxBloco()));
      if (strlen($objBlocoDTO->getStrIdxBloco()) > 500){
        $objInfraException->adicionarValidacao('Indexa��o possui tamanho superior a 500 caracteres.');
      }
    }
  }

  private function validarStrStaEstadoRN1272(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getStrStaEstado())){
      $objInfraException->adicionarValidacao('Estado n�o informado.');
    }else{
      if (!in_array($objBlocoDTO->getStrStaEstado(),InfraArray::converterArrInfraDTO($this->listarValoresEstadoRN1265(),'StaEstado'))){
        $objInfraException->adicionarValidacao('Estado inv�lido.');
      }
    }
  }

  private function validarArrObjRelBlocoUnidadeDTO(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (!is_array($objBlocoDTO->getArrObjRelBlocoUnidadeDTO())){
      $objInfraException->adicionarValidacao('Conjunto de unidades para disponibiliza��o inv�lido.');
    }
    
    if (InfraArray::contar($objBlocoDTO->getArrObjRelBlocoUnidadeDTO())>0 && $objBlocoDTO->getStrStaTipo()==self::$TB_INTERNO){
      $objInfraException->adicionarValidacao('Bloco interno n�o pode ser disponibilizado para outras unidades.');
    }
  }

  private function validarNumDiasSemMovimentacao(BlocoDTO $objBlocoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objBlocoDTO->getNumDiasSemMovimentacao())){
      $objInfraException->adicionarValidacao('N�mero de dias sem movimenta��o n�o informado.');
    }else{

      $objBlocoDTO->setNumDiasSemMovimentacao(trim($objBlocoDTO->getNumDiasSemMovimentacao()));

      if (!is_numeric($objBlocoDTO->getNumDiasSemMovimentacao()) || $objBlocoDTO->getNumDiasSemMovimentacao() <= 0){
        $objInfraException->adicionarValidacao('N�mero de dias sem movimenta��o inv�lido.');
      }
    }
  }

  
  protected function cadastrarRN1273Controlado(BlocoDTO $objBlocoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_cadastrar',__METHOD__,$objBlocoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();
      
      
      $this->validarStrStaTipoRN1266($objBlocoDTO, $objInfraException);
      $this->validarNumIdUnidadeRN1267($objBlocoDTO, $objInfraException);
      $this->validarNumIdUsuarioRN1268($objBlocoDTO, $objInfraException);
      $this->validarStrDescricaoRN1269($objBlocoDTO, $objInfraException);
      //$this->validarStrAnotacaoRN1270($objBlocoDTO, $objInfraException);
      $this->validarStrIdxBlocoRN1271($objBlocoDTO, $objInfraException);
      $this->validarStrStaEstadoRN1272($objBlocoDTO, $objInfraException);
      $this->validarArrObjRelBlocoUnidadeDTO($objBlocoDTO, $objInfraException);
      
      
      $objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $ret = $objBlocoBD->cadastrar($objBlocoDTO);

      $this->montarIndexacao($ret);

      $arrObjRelBlocoUnidadeDTO = array();

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $arrObjRelBlocoUnidadeDTO[] = $objRelBlocoUnidadeDTO;

      if ($objBlocoDTO->isSetArrObjRelBlocoUnidadeDTO()) {
        $arrObjRelBlocoUnidadeDTO = array_merge($arrObjRelBlocoUnidadeDTO,$objBlocoDTO->getArrObjRelBlocoUnidadeDTO());
      }

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      foreach ($arrObjRelBlocoUnidadeDTO as $objRelBlocoUnidadeDTO) {
        $objRelBlocoUnidadeDTO->setNumIdBloco($ret->getNumIdBloco());
        $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
        $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
        $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
        $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
        $objRelBlocoUnidadeDTO->setDthRevisao(null);
        $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
        $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
        $objRelBlocoUnidadeDTO->setDthPrioridade(null);
        $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
        $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
        $objRelBlocoUnidadeDTO->setDthComentario(null);
        $objRelBlocoUnidadeDTO->setStrSinComentario('N');
        $objRelBlocoUnidadeDTO->setStrSinRetornado('N');
        $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);
      }

      if ($objBlocoDTO->isSetNumIdGrupoBlocoRelBlocoUnidade()){
        $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
        $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
        $objRelBlocoUnidadeDTO->setNumIdGrupoBloco($objBlocoDTO->getNumIdGrupoBlocoRelBlocoUnidade());
        $this->alterarGrupo($objRelBlocoUnidadeDTO);
      }

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Bloco.',$e);
    }
  }

  protected function alterarRN1274Controlado(BlocoDTO $objBlocoDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('bloco_alterar',__METHOD__,$objBlocoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $dto = new BlocoDTO();
      $dto->retStrStaTipo();
      $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());
      
      $dto = $this->consultarRN1276($dto);
      
      if ($objBlocoDTO->isSetStrStaTipo() && $objBlocoDTO->getStrStaTipo()!=$dto->getStrStaTipo()){
        $objInfraException->lancarValidacao('N�o � poss�vel alterar o tipo do bloco.');
      }
      
      $objBlocoDTO->setStrStaTipo($dto->getStrStaTipo());
      
      if ($objBlocoDTO->isSetStrStaTipo()){
        $this->validarStrStaTipoRN1266($objBlocoDTO, $objInfraException);
      }
      if ($objBlocoDTO->isSetNumIdUnidade()){
        $this->validarNumIdUnidadeRN1267($objBlocoDTO, $objInfraException);
      }
      if ($objBlocoDTO->isSetNumIdUsuario()){
        $this->validarNumIdUsuarioRN1268($objBlocoDTO, $objInfraException);
      }
      if ($objBlocoDTO->isSetStrDescricao()){
        $this->validarStrDescricaoRN1269($objBlocoDTO, $objInfraException);
      }
      /*if ($objBlocoDTO->isSetStrAnotacao()){
        $this->validarStrAnotacaoRN1270($objBlocoDTO, $objInfraException);
      }*/
      if ($objBlocoDTO->isSetStrIdxBloco()){
        $this->validarStrIdxBlocoRN1271($objBlocoDTO, $objInfraException);
      }
      if ($objBlocoDTO->isSetStrStaEstado()){
        $this->validarStrStaEstadoRN1272($objBlocoDTO, $objInfraException);
      }
      if ($objBlocoDTO->isSetArrObjRelBlocoUnidadeDTO()){
        $this->validarArrObjRelBlocoUnidadeDTO($objBlocoDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $objBlocoBD->alterar($objBlocoDTO);
      
      $this->montarIndexacao($objBlocoDTO);

      if ($objBlocoDTO->isSetArrObjRelBlocoUnidadeDTO()){
        
        $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
        $objRelBlocoUnidadeDTO->retNumIdBloco();
        $objRelBlocoUnidadeDTO->retNumIdUnidade();
        $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
        $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual(),InfraDTO::$OPER_DIFERENTE);
        
        $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
        $arrObjRelBlocoUnidadeDTOAntigos = $objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO);
        $arrObjRelBlocoUnidadeDTONovos = $objBlocoDTO->getArrObjRelBlocoUnidadeDTO();

        $arrRemocao = array();
        foreach($arrObjRelBlocoUnidadeDTOAntigos as $objRelBlocoUnidadeDTOAntigo){
          $flagRemover = true;
          foreach($arrObjRelBlocoUnidadeDTONovos as $objRelBlocoUnidadeDTONovo){
            if ($objRelBlocoUnidadeDTOAntigo->getNumIdUnidade()==$objRelBlocoUnidadeDTONovo->getNumIdUnidade()){
              $flagRemover = false;
              break;
            }
          }
          if ($flagRemover){
            $arrRemocao[] = $objRelBlocoUnidadeDTOAntigo;
          }
        }

        if (InfraArray::contar($arrRemocao)){
          $objRelBlocoUnidadeRN->excluirRN1302($arrRemocao);
        }

        foreach($arrObjRelBlocoUnidadeDTONovos as $objRelBlocoUnidadeDTONovo){
          $flagCadastrar = true;
          foreach($arrObjRelBlocoUnidadeDTOAntigos as $objRelBlocoUnidadeDTOAntigo){
            if ($objRelBlocoUnidadeDTOAntigo->getNumIdUnidade()==$objRelBlocoUnidadeDTONovo->getNumIdUnidade()){
              $flagCadastrar = false;
              break;
            }
          }
          if ($flagCadastrar){
            $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
            $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
            $objRelBlocoUnidadeDTO->setNumIdUnidade($objRelBlocoUnidadeDTONovo->getNumIdUnidade());
            $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
            $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
            $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
            $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
            $objRelBlocoUnidadeDTO->setDthRevisao(null);
            $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
            $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
            $objRelBlocoUnidadeDTO->setDthPrioridade(null);
            $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
            $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
            $objRelBlocoUnidadeDTO->setDthComentario(null);
            $objRelBlocoUnidadeDTO->setStrSinComentario('N');
            $objRelBlocoUnidadeDTO->setStrSinRetornado('N');
            $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);
          }
        }
      }

      if ($objBlocoDTO->isSetNumIdGrupoBlocoRelBlocoUnidade()){
        $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
        $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
        $objRelBlocoUnidadeDTO->setNumIdGrupoBloco($objBlocoDTO->getNumIdGrupoBlocoRelBlocoUnidade());
        $this->alterarGrupo($objRelBlocoUnidadeDTO);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Bloco.',$e);
    }
  }

  protected function excluirRN1275Controlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_excluir',__METHOD__,$arrObjBlocoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      
      for($i=0;$i<count($arrObjBlocoDTO);$i++){
        
      	$objBlocoDTO = new BlocoDTO();
      	$objBlocoDTO->retNumIdBloco();
      	$objBlocoDTO->retNumIdUnidade();
      	$objBlocoDTO->retStrStaEstado();
      	$objBlocoDTO->retStrStaTipo();
      	$objBlocoDTO->setNumIdBloco($arrObjBlocoDTO[$i]->getNumIdBloco());
      	$objBlocoDTO = $this->consultarRN1276($objBlocoDTO);
      	
      	if ($objBlocoDTO==null){
      		$objInfraException->lancarValidacao('Bloco '.$arrObjBlocoDTO[$i]->getNumIdBloco().' n�o encontrado.');
      	}
      	
      	if($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
      		$objInfraException->lancarValidacao('Bloco '.$arrObjBlocoDTO[$i]->getNumIdBloco().' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
      	}else{
      		/* verifica se h� processos/documentos associados */
      		$objRelBlocoProtocoloDTO = new RelBlocoProtocoloDTO();
          $objRelBlocoProtocoloDTO->retDblIdProtocolo();
      		$objRelBlocoProtocoloDTO->setNumIdBloco($arrObjBlocoDTO[$i]->getNumIdBloco());
          $objRelBlocoProtocoloDTO->setNumMaxRegistrosRetorno(1);
      		
      		$objRelBlocoProtocoloRN = new RelBlocoProtocoloRN();
      		if ($objRelBlocoProtocoloRN->consultarRN1290($objRelBlocoProtocoloDTO) != null){
      		  if ($objBlocoDTO->getStrStaTipo()==BlocoRN::$TB_ASSINATURA){
      		    $objInfraException->lancarValidacao('Bloco '.$arrObjBlocoDTO[$i]->getNumIdBloco().' possui documentos.');
      		  }else{
      		    $objInfraException->lancarValidacao('Bloco '.$arrObjBlocoDTO[$i]->getNumIdBloco().' possui processos.');
      		  }
      		}

      		if ($objBlocoDTO->getStrStaEstado()==self::$TE_DISPONIBILIZADO){
      		  $objInfraException->lancarValidacao('Bloco '.$arrObjBlocoDTO[$i]->getNumIdBloco().' n�o pode estar disponibilizado.');
      		}
      		
      		/* verifica se h� disponibiliza��es para outras unidades */
      		$objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      		$objRelBlocoUnidadeDTO->retNumIdUnidade();
      		$objRelBlocoUnidadeDTO->retNumIdBloco();
      		$objRelBlocoUnidadeDTO->setNumIdBloco($arrObjBlocoDTO[$i]->getNumIdBloco());
      		
      		$objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      		$objRelBlocoUnidadeRN->excluirRN1302($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO));
      		
      		/* excluir o bloco propriamente dito */
        	$objBlocoBD->excluir($arrObjBlocoDTO[$i]);
      	}
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Bloco.',$e);
    }
  }

  protected function consultarRN1276Conectado(BlocoDTO $objBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_consultar',__METHOD__,$objBlocoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      if ($objBlocoDTO->isRetStrTipoDescricao()) {
        $objBlocoDTO->retStrStaTipo();
      }

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $ret = $objBlocoBD->consultar($objBlocoDTO);

      if ($ret != null){
        if ($objBlocoDTO->isRetStrTipoDescricao()) {
        	$arrObjTipoDTO = $this->listarValoresTipo();
      		foreach ($arrObjTipoDTO as $objTipoDTO) {
      			if ($ret->getStrStaTipo() == $objTipoDTO->getStrStaTipo()){
      				$ret->setStrTipoDescricao($objTipoDTO->getStrDescricao());
      				break;
      			}
      		}
        }
      }
      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Bloco.',$e);
    }
  }

  protected function listarRN1277Conectado(BlocoDTO $objBlocoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_listar',__METHOD__,$objBlocoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();
      
      //$objInfraException->lancarValidacoes();

      if ($objBlocoDTO->isRetStrTipoDescricao()) {
        $objBlocoDTO->retStrStaTipo();
      }
      
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $ret = $objBlocoBD->listar($objBlocoDTO);

      if ($objBlocoDTO->isRetStrTipoDescricao()) {
      	$arrObjTipoDTO = $this->listarValoresTipo();
      	foreach ($ret as $dto) {
      		foreach ($arrObjTipoDTO as $objTipoDTO) {
      			if ($dto->getStrStaTipo() == $objTipoDTO->getStrStaTipo()){
      				$dto->setStrTipoDescricao($objTipoDTO->getStrDescricao());
      				break;
      			}
      		}
      	}
      }

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Blocos.',$e);
    }
  }

  protected function contarRN1278Conectado(BlocoDTO $objBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_listar',__METHOD__,$objBlocoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $ret = $objBlocoBD->contar($objBlocoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Blocos.',$e);
    }
  }

  protected function reabrirControlado(BlocoDTO $objBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_reabrir',__METHOD__,$objBlocoDTO);
			
      //Regras de Negocio
      $objInfraException = new InfraException();

      $dto = new BlocoDTO();
      $dto->retNumIdBloco();
      $dto->retNumIdUnidade();
      $dto->retStrStaEstado();
      $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());
      
      $dto = $this->consultarRN1276($dto);

      if($dto->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
      	$objInfraException->lancarValidacao('Bloco '.$dto->getNumIdBloco().' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
      }
      
      if($dto->getStrStaEstado()!=BlocoRN::$TE_CONCLUIDO){
      	$objInfraException->lancarValidacao('Bloco '.$dto->getNumIdBloco().' n�o est� conclu�do.');
      } 
      
      $objInfraException->lancarValidacoes();

      $this->lancarAndamentoBloco($objBlocoDTO->getNumIdBloco(),TarefaRN::$TI_BLOCO_REABERTURA);
      
      $dto = new BlocoDTO();
     	$dto->setStrStaEstado(BlocoRN::$TE_ABERTO);
      $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());
     	
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $objBlocoBD->alterar($dto);      

      //Auditoria

      return $dto;
      
    }catch(Exception $e){
      throw new InfraException('Erro reabrindo Bloco.',$e);
    }
  }

  protected function pesquisarConectado(BlocoDTO $parObjBlocoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_listar',__METHOD__,$parObjBlocoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();
      
      //$objInfraException->lancarValidacoes();

      $objBlocoDTO = clone($parObjBlocoDTO);

      $objBlocoDTO = InfraString::prepararPesquisaDTO($objBlocoDTO,"PalavrasPesquisa", "IdxBloco");

			if ($objBlocoDTO->isRetNumDocumentos() || $objBlocoDTO->isRetNumAssinados() || $objBlocoDTO->isRetArrObjRelBlocoUnidadeDTO() || $objBlocoDTO->isRetObjRelBlocoUnidadeDTO() || $objBlocoDTO->isRetStrStaEstado()){
			  $objBlocoDTO->retNumIdBloco();
			  $objBlocoDTO->retNumIdUnidade();
			  $objBlocoDTO->retArrObjRelBlocoUnidadeDTO();
			}

      if (!$objBlocoDTO->isSetNumIdBloco()) {
        $this->configurarFiltroBlocosUnidade($objBlocoDTO);
      }

      if ($objBlocoDTO->isSetStrStaTipoAtribuicao() && $objBlocoDTO->getStrStaTipoAtribuicao() == self::$TA_MINHAS) {
        $objBlocoDTO->setNumIdUsuarioAtribuicaoRelBlocoUnidade(SessaoSEI::getInstance()->getNumIdUsuario());
        $objBlocoDTO->setNumIdUnidadeRelBlocoUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      }

      if ($objBlocoDTO->isSetStrSinPrioridadeRelBlocoUnidade() || $objBlocoDTO->isSetStrSinRevisaoRelBlocoUnidade() || $objBlocoDTO->isSetStrSinComentarioRelBlocoUnidade()){
        $objBlocoDTO->setNumIdUnidadeRelBlocoUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      }

      if ($objBlocoDTO->isSetNumIdGrupoBlocoRelBlocoUnidade()){
        $objBlocoDTO->setNumIdUnidadeRelBlocoUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      }

      if ($objBlocoDTO->isSetStrStaEstado() && $objBlocoDTO->getStrStaEstado()!=null){

        $arrEstados = $objBlocoDTO->getStrStaEstado();

        if (!is_array($arrEstados)){
          $arrEstados = array($arrEstados);
        }

        $arrEstados = array_flip($arrEstados);

        if (isset($arrEstados[self::$TE_DISPONIBILIZADO]) xor isset($arrEstados[self::$TE_RECEBIDO])) {

          $arrCriterios = array();

          if (isset($arrEstados[self::$TE_DISPONIBILIZADO])) {
            $objBlocoDTO->adicionarCriterio(array('StaEstado', 'IdUnidade'),
                array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
                array(self::$TE_DISPONIBILIZADO, SessaoSEI::getInstance()->getNumIdUnidadeAtual()),
                InfraDTO::$OPER_LOGICO_AND,
                'cDisponibilizado');

            $arrCriterios[] = 'cDisponibilizado';
            unset($arrEstados[self::$TE_DISPONIBILIZADO]);
          }

          if (isset($arrEstados[self::$TE_RECEBIDO])){
            $objBlocoDTO->adicionarCriterio(array('StaEstado', 'IdUnidade'),
                array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_DIFERENTE),
                array(self::$TE_DISPONIBILIZADO, SessaoSEI::getInstance()->getNumIdUnidadeAtual()),
                InfraDTO::$OPER_LOGICO_AND,
                'cRecebido');

            $arrCriterios[] = 'cRecebido';
            unset($arrEstados[self::$TE_RECEBIDO]);
          }

          if (count($arrEstados)) {
            $objBlocoDTO->adicionarCriterio(array('StaEstado'),
                array(InfraDTO::$OPER_IN),
                array(array_keys($arrEstados)),
                null,
                'cOutros');
            $arrCriterios[] = 'cOutros';
          }

          if (count($arrCriterios) > 1){
            $objBlocoDTO->agruparCriterios($arrCriterios, array_fill(0, count($arrCriterios) - 1, InfraDTO::$OPER_LOGICO_OR));
          }

          $objBlocoDTO->unSetStrStaEstado();
        }
      }

      //ordenacao
      if ($parObjBlocoDTO->isOrdNumIdBloco()){
        $objBlocoDTO->setOrdNumIdBloco($parObjBlocoDTO->getOrdNumIdBloco());
      }

      if ($parObjBlocoDTO->isOrdStrDescricao()){
        $objBlocoDTO->setOrdStrDescricao($parObjBlocoDTO->getOrdStrDescricao());
      }

      $ret = $this->listarRN1277($objBlocoDTO);

      //pagina��o
      $parObjBlocoDTO->setNumTotalRegistros($objBlocoDTO->getNumTotalRegistros());
      $parObjBlocoDTO->setNumRegistrosPaginaAtual($objBlocoDTO->getNumRegistrosPaginaAtual());

			if (count($ret)) {

			  $arrIdBlocos = InfraArray::converterArrInfraDTO($ret,'IdBloco');

        if ($objBlocoDTO->isRetNumDocumentos() || $objBlocoDTO->isRetNumAssinados()) {
          $objRelBlocoProtocoloDTO = new RelBlocoProtocoloDTO();
          $objRelBlocoProtocoloDTO->retNumIdBloco();
          $objRelBlocoProtocoloDTO->retDblIdProtocolo();

          if ($objBlocoDTO->isRetNumAssinados()){
            $objRelBlocoProtocoloDTO->retArrObjAssinaturaDTO();
          }

          $objRelBlocoProtocoloDTO->setNumIdBloco($arrIdBlocos,InfraDTO::$OPER_IN);

          $objRelBlocoProtocoloRN = new RelBlocoProtocoloRN();
          $arrObjRelBlocoProtocoloDTO = $objRelBlocoProtocoloRN->listarProtocolosBloco($objRelBlocoProtocoloDTO);

          $arrObjRelBlocoProtocoloDTO = InfraArray::indexarArrInfraDTO($arrObjRelBlocoProtocoloDTO,'IdBloco',true);
        }

        if ($objBlocoDTO->isRetNumDocumentos()) {
          foreach ($ret as $dto) {
            if (!isset($arrObjRelBlocoProtocoloDTO[$dto->getNumIdBloco()])){
              $dto->setNumDocumentos(0);
            }else{
              $dto->setNumDocumentos(InfraArray::contar($arrObjRelBlocoProtocoloDTO[$dto->getNumIdBloco()]));
            }
          }
        }

        if ($objBlocoDTO->isRetNumAssinados()) {
          foreach ($ret as $dto) {
            $numAssinados = 0;
            if (isset($arrObjRelBlocoProtocoloDTO[$dto->getNumIdBloco()])){
              foreach($arrObjRelBlocoProtocoloDTO[$dto->getNumIdBloco()] as $objRelBlocoProtocoloDTO) {
                if (InfraArray::contar($objRelBlocoProtocoloDTO->getArrObjAssinaturaDTO())) {
                  $numAssinados++;
                }
              }
            }
            $dto->setNumAssinados($numAssinados);
          }
        }


        if ($objBlocoDTO->isRetArrObjRelBlocoUnidadeDTO()) {

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->retNumIdBloco();
          $objRelBlocoUnidadeDTO->retNumIdUnidade();
          $objRelBlocoUnidadeDTO->retStrSiglaUnidade();
          $objRelBlocoUnidadeDTO->retStrDescricaoUnidade();
          $objRelBlocoUnidadeDTO->retStrSinRetornado();
          $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBlocos,InfraDTO::$OPER_IN);
          $objRelBlocoUnidadeDTO->setOrdStrSiglaUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);

          $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
          $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO), 'IdBloco', true);

          foreach($ret as $dto){
            if (isset($arrObjRelBlocoUnidadeDTO[$dto->getNumIdBloco()])){

              $arr = array();
              foreach($arrObjRelBlocoUnidadeDTO[$dto->getNumIdBloco()] as $objRelBlocoUnidadeDTO){
                if ($objRelBlocoUnidadeDTO->getNumIdUnidade()!=$dto->getNumIdUnidade()){
                  $arr[] = $objRelBlocoUnidadeDTO;
                }
              }
              $dto->setArrObjRelBlocoUnidadeDTO($arr);

            }else{
              $dto->setArrObjRelBlocoUnidadeDTO(array());
            }
          }
        }

        if ($objBlocoDTO->isRetObjRelBlocoUnidadeDTO()) {

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->retNumIdBloco();
          $objRelBlocoUnidadeDTO->retStrSinPrioridade();
          $objRelBlocoUnidadeDTO->retNumIdUsuarioAtribuicao();
          $objRelBlocoUnidadeDTO->retStrSiglaUsuarioAtribuicao();
          $objRelBlocoUnidadeDTO->retStrNomeUsuarioAtribuicao();
          $objRelBlocoUnidadeDTO->retNumIdUsuarioPrioridade();
          $objRelBlocoUnidadeDTO->retStrSiglaUsuarioPrioridade();
          $objRelBlocoUnidadeDTO->retDthPrioridade();
          $objRelBlocoUnidadeDTO->retStrSinRevisao();
          $objRelBlocoUnidadeDTO->retNumIdUsuarioRevisao();
          $objRelBlocoUnidadeDTO->retStrSiglaUsuarioRevisao();
          $objRelBlocoUnidadeDTO->retDthRevisao();
          $objRelBlocoUnidadeDTO->retNumIdUsuarioComentario();
          $objRelBlocoUnidadeDTO->retStrSiglaUsuarioComentario();
          $objRelBlocoUnidadeDTO->retStrNomeUsuarioComentario();
          $objRelBlocoUnidadeDTO->retStrTextoComentario();
          $objRelBlocoUnidadeDTO->retStrSinComentario();
          $objRelBlocoUnidadeDTO->retDthComentario();
          $objRelBlocoUnidadeDTO->retNumIdGrupoBloco();
          $objRelBlocoUnidadeDTO->retStrNomeGrupoBloco();
          $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBlocos, InfraDTO::$OPER_IN);
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());

          $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
          $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

          foreach($ret as $dto){
            if (isset($arrObjRelBlocoUnidadeDTO[$dto->getNumIdBloco()])){
              $dto->setObjRelBlocoUnidadeDTO($arrObjRelBlocoUnidadeDTO[$dto->getNumIdBloco()]);
            }else{
              $dto->setObjRelBlocoUnidadeDTO(null);
            }
          }
        }

        if ($objBlocoDTO->isRetStrStaEstado()) {

          $arrObjEstadoBlocoDTO = InfraArray::indexarArrInfraDTO($this->listarValoresEstadoRN1265(),'StaEstado');

          foreach ($ret as $dto) {
            if ($dto->getStrStaEstado() == self::$TE_DISPONIBILIZADO && $dto->getNumIdUnidade() != SessaoSEI::getInstance()->getNumIdUnidadeAtual() && in_array(SessaoSEI::getInstance()->getNumIdUnidadeAtual(),InfraArray::converterArrInfraDTO($dto->getArrObjRelBlocoUnidadeDTO(),'IdUnidade'))) {
              $dto->setStrStaEstado(self::$TE_RECEBIDO);
            }
            $dto->setStrStaEstadoDescricao($arrObjEstadoBlocoDTO[$dto->getStrStaEstado()]->getStrDescricao());
          }
        }
      }

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro pesquisando Blocos.',$e);
    }
  }
  
  protected function montarIndexacaoControlado(BlocoDTO $objBlocoDTO){
  	try{

	  	$dto = new BlocoDTO();
	  	$dto->retNumIdBloco();
	  	$dto->retStrDescricao();

	  	if (is_array($objBlocoDTO->getNumIdBloco())){
        $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco(),InfraDTO::$OPER_IN);
      }else{
        $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());
      }

      $objBlocoDTOIdx = new BlocoDTO();
      $objInfraException = new InfraException();
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());

      $arrObjBlocoDTO = $this->listarRN1277($dto);

	  	foreach($arrObjBlocoDTO as $dto) {

        $objBlocoDTOIdx->setNumIdBloco($dto->getNumIdBloco());
        $objBlocoDTOIdx->setStrIdxBloco(InfraString::prepararIndexacao($dto->getNumIdBloco().' '.$dto->getStrDescricao()));

        $this->validarStrIdxBlocoRN1271($objBlocoDTOIdx, $objInfraException);
        $objInfraException->lancarValidacoes();

        $objBlocoBD->alterar($objBlocoDTOIdx);
      }

    }catch(Exception $e){
      throw new InfraException('Erro montando indexa��o de bloco.',$e);
    }
  }
  
/* 
  protected function desativarRN1279Controlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjBlocoDTO);$i++){
        $objBlocoBD->desativar($arrObjBlocoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Bloco.',$e);
    }
  }

  protected function reativarRN1280Controlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjBlocoDTO);$i++){
        $objBlocoBD->reativar($arrObjBlocoDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Bloco.',$e);
    }
  }
  */

  protected function bloquearRN1281Controlado(BlocoDTO $objBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      $ret = $objBlocoBD->bloquear($objBlocoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Bloco.',$e);
    }
  }

  protected function disponibilizarControlado($arrObjBlocoDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_disponibilizar',__METHOD__,$arrObjBlocoDTO);

      
      //Regras de Negocio
      
      $objInfraException = new InfraException();
      
      if (count($arrObjBlocoDTO)==0){
      	$objInfraException->lancarValidacao('Nenhum bloco informado para disponibiliza��o.');
      }

      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrStaEstado();
      $objBlocoDTO->retNumDocumentos();
      $objBlocoDTO->retArrObjRelBlocoUnidadeDTO();
      $objBlocoDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTO,'IdBloco'),InfraDTO::$OPER_IN);
      
      $arr = $this->pesquisar($objBlocoDTO);
      
      foreach($arr as $objBlocoDTO){
        
        if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }
        
        if ($objBlocoDTO->getStrStaEstado()==BlocoRN::$TE_DISPONIBILIZADO){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' j� foi disponibilizado.');
        }

        if ($objBlocoDTO->getStrStaEstado()==BlocoRN::$TE_CONCLUIDO){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' est� conclu�do.');
        }
        
        if ($objBlocoDTO->getStrStaTipo()==self::$TB_INTERNO){
          $objInfraException->adicionarValidacao('Bloco interno '.$objBlocoDTO->getNumIdBloco().' n�o pode ser disponibilizado.');
        }

        if ($objBlocoDTO->getNumDocumentos()==0){
          if ($objBlocoDTO->getStrStaTipo()==BlocoRN::$TB_ASSINATURA){
            $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o possui documentos.');  
          }else{
            $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o possui processos.');
          }
        }
                
        if (InfraArray::contar($objBlocoDTO->getArrObjRelBlocoUnidadeDTO())==0){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o possui unidades configuradas para disponibiliza��o.');
        }
      }
      
      $objInfraException->lancarValidacoes();
      
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      
      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      
      foreach($arr as $objBlocoDTO){

	      foreach($objBlocoDTO->getArrObjRelBlocoUnidadeDTO() as $objRelBlocoUnidadeDTO){

          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
          $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
          $objRelBlocoUnidadeDTO->setDthRevisao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
          $objRelBlocoUnidadeDTO->setDthPrioridade(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
          $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
          $objRelBlocoUnidadeDTO->setDthComentario(null);
          $objRelBlocoUnidadeDTO->setStrSinComentario('N');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');

	      	$objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);
	      }

        $dto = new BlocoDTO();
        $dto->setStrStaEstado(self::$TE_DISPONIBILIZADO);
        $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());

        $objBlocoBD->alterar($dto);
        
        if (InfraArray::contar($objBlocoDTO->getArrObjRelBlocoUnidadeDTO())){
          $this->lancarAndamentoBloco($objBlocoDTO->getNumIdBloco(),TarefaRN::$TI_BLOCO_DISPONIBILIZACAO);
        }
      }
      
      //Auditoria

      return true;

    }catch(Exception $e){
      throw new InfraException('Erro disponibilizando bloco.',$e);
    }
  }
  
  protected function cancelarDisponibilizacaoControlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_cancelar_disponibilizacao',__METHOD__,$arrObjBlocoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();
      
      if (count($arrObjBlocoDTO)==0){
      	$objInfraException->lancarValidacao('Nenhum bloco informado para cancelamento de disponibiliza��o.');
      }
      
      
      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrStaEstado();
      $objBlocoDTO->retArrObjRelBlocoUnidadeDTO();
      $objBlocoDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTO,'IdBloco'),InfraDTO::$OPER_IN);
      
      $arr = $this->pesquisar($objBlocoDTO);
      
      foreach($arr as $objBlocoDTO){
        if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }
        
        if ($objBlocoDTO->getStrStaEstado()!=BlocoRN::$TE_DISPONIBILIZADO){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o est� disponibilizado.');
        }
      }
      
      $objInfraException->lancarValidacoes();
      
      
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      
      foreach($arr as $objBlocoDTO){
        
        $dto = new BlocoDTO();
        $dto->setStrStaEstado(self::$TE_ABERTO);
        $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());

        $objBlocoBD->alterar($dto);
        
        if (InfraArray::contar($objBlocoDTO->getArrObjRelBlocoUnidadeDTO())){
          $this->lancarAndamentoBloco($objBlocoDTO->getNumIdBloco(),TarefaRN::$TI_BLOCO_CANCELAMENTO_DISPONIBILIZACAO);
        }
      }
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro cancelando disponibiliza��o.',$e);
    }
  }

  protected function retornarControlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_retornar',__METHOD__,$arrObjBlocoDTO);
			
      //Regras de Negocio
      $objInfraException = new InfraException();

      if (count($arrObjBlocoDTO)==0){
        $objInfraException->lancarValidacao('Nenhum bloco informado.');
      }
      
      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrStaEstado();
      $objBlocoDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTO,'IdBloco'),InfraDTO::$OPER_IN);
      
      $arr = $this->pesquisar($objBlocoDTO);
      
      foreach($arr as $objBlocoDTO){
        if ($objBlocoDTO->getNumIdUnidade()==SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
          $objInfraException->lancarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }

        if ($objBlocoDTO->getStrStaEstado()!=BlocoRN::$TE_RECEBIDO){
          $objInfraException->lancarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o consta como recebido.');
        }
      }
      
      $objInfraException->lancarValidacoes();
            
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());
      
      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      foreach($arr as $objBlocoDTO){
        
      	$objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      	$objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
      	$objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      	$objRelBlocoUnidadeDTO->setStrSinRetornado('S');
      	
      	$objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        $this->lancarAndamentoBloco($objBlocoDTO->getNumIdBloco(),TarefaRN::$TI_BLOCO_RETORNO);
      	
      	$objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
        $objRelBlocoUnidadeDTO->setNumMaxRegistrosRetorno(1);
        $objRelBlocoUnidadeDTO->retNumIdBloco();
      	$objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
        $objRelBlocoUnidadeDTO->setNumIdUnidade($objBlocoDTO->getNumIdUnidade(),InfraDTO::$OPER_DIFERENTE);
      	$objRelBlocoUnidadeDTO->setStrSinRetornado('N');

      	if ($objRelBlocoUnidadeRN->consultarRN1303($objRelBlocoUnidadeDTO)==null){
	        $dto = new BlocoDTO();
	        $dto->setStrStaEstado(self::$TE_RETORNADO);
	        $dto->setNumIdBloco($objBlocoDTO->getNumIdBloco());
	        $objBlocoBD->alterar($dto);
        }
      }
            
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro retornando bloco.',$e);
    }
  }

  protected function concluirControlado($arrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_concluir',__METHOD__,$arrObjBlocoDTO);
			
      $objInfraException = new InfraException();
      
      if (count($arrObjBlocoDTO)==0){
      	$objInfraException->lancarValidacao('Nenhum bloco informado para conclus�o.');
      }
      
      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrStaEstado();
      $objBlocoDTO->retArrObjRelBlocoUnidadeDTO();
      $objBlocoDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTO,'IdBloco'),InfraDTO::$OPER_IN);
      
      $arr = $this->pesquisar($objBlocoDTO);
      
      foreach($arr as $objBlocoDTO){
        if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }
        
        if ($objBlocoDTO->getStrStaEstado()==BlocoRN::$TE_DISPONIBILIZADO){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' n�o pode estar disponibilizado para outras unidades.');
        }
        
        if ($objBlocoDTO->getStrStaEstado()==BlocoRN::$TE_CONCLUIDO){
          $objInfraException->adicionarValidacao('Bloco '.$objBlocoDTO->getNumIdBloco().' j� foi conclu�do.');
        }
      }
      
      $objInfraException->lancarValidacoes();
            
      $objBlocoBD = new BlocoBD($this->getObjInfraIBanco());

      for($i=0;$i<count($arrObjBlocoDTO);$i++){

        $this->lancarAndamentoBloco($arrObjBlocoDTO[$i]->getNumIdBloco(),TarefaRN::$TI_BLOCO_CONCLUSAO);
        
        $dto = new BlocoDTO();
        $dto->setStrStaEstado(self::$TE_CONCLUIDO);
        $dto->setNumIdBloco($arrObjBlocoDTO[$i]->getNumIdBloco());

        $objBlocoBD->alterar($dto);
      }
            
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro concluindo bloco.',$e);
    }
  }
  
  private function lancarAndamentoBloco($numIdBloco,  $numIdTarefa){
    try{

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
    
      //obtem protocolos do bloco
      $objRelBlocoProtocoloDTO = new RelBlocoProtocoloDTO();
      $objRelBlocoProtocoloDTO->retDblIdProtocolo();
      $objRelBlocoProtocoloDTO->retStrStaProtocoloProtocolo();
      $objRelBlocoProtocoloDTO->setNumIdBloco($numIdBloco);
      
      $objRelBlocoProtocoloRN = new RelBlocoProtocoloRN();
      $arrObjRelBlocoProtocoloDTO = $objRelBlocoProtocoloRN->listarRN1291($objRelBlocoProtocoloDTO);  
      
      $arrIdProcessos = array();
      $arrIdDocumentos = array();
      foreach($arrObjRelBlocoProtocoloDTO as $objRelBlocoProtocoloDTO){
        if ($objRelBlocoProtocoloDTO->getStrStaProtocoloProtocolo()==ProtocoloRN::$TP_PROCEDIMENTO){
          $arrIdProcessos[] = $objRelBlocoProtocoloDTO->getDblIdProtocolo();
        }else{
          $arrIdDocumentos[] = $objRelBlocoProtocoloDTO->getDblIdProtocolo();
        }
      }
      
      //obtem processos dos documentos do bloco
      if (count($arrIdDocumentos)>0){
        $objRelProtocoloProtocoloDTO = new RelProtocoloProtocoloDTO();
        $objRelProtocoloProtocoloDTO->setDistinct(true);
        $objRelProtocoloProtocoloDTO->retDblIdProtocolo1();
        $objRelProtocoloProtocoloDTO->setDblIdProtocolo2($arrIdDocumentos,InfraDTO::$OPER_IN);
        $objRelProtocoloProtocoloDTO->setStrStaAssociacao(RelProtocoloProtocoloRN::$TA_DOCUMENTO_ASSOCIADO);
        
        $objRelProtocoloProtocoloRN = new RelProtocoloProtocoloRN();
        $arrObjRelProtocoloProtocoloDTO = $objRelProtocoloProtocoloRN->listarRN0187($objRelProtocoloProtocoloDTO);          
        
        $arrIdProcessos = array_unique(array_merge($arrIdProcessos, InfraArray::converterArrInfraDTO($arrObjRelProtocoloProtocoloDTO,'IdProtocolo1')));
      }    

      $objAtividadeRN = new AtividadeRN();

      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrSiglaUnidade();
      $objBlocoDTO->retStrDescricaoUnidade();
      $objBlocoDTO->setNumIdBloco($numIdBloco);

      $objBlocoDTO = $this->consultarRN1276($objBlocoDTO);

      //lan�ar andamento somente para a unidade atual
      if ($numIdTarefa == TarefaRN::$TI_BLOCO_RETORNO || $numIdTarefa == TarefaRN::$TI_BLOCO_CONCLUSAO || $numIdTarefa == TarefaRN::$TI_BLOCO_REABERTURA){

        foreach($arrIdProcessos as $dblIdProcesso){

          $arrObjAtributoAndamentoDTO = array();
          $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
          $objAtributoAndamentoDTO->setStrNome('BLOCO');
          $objAtributoAndamentoDTO->setStrValor($numIdBloco);
          $objAtributoAndamentoDTO->setStrIdOrigem($numIdBloco);
          $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;
  
          $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
          $objAtributoAndamentoDTO->setStrNome('UNIDADE');
          $objAtributoAndamentoDTO->setStrValor($objBlocoDTO->getStrSiglaUnidade().'�'.$objBlocoDTO->getStrDescricaoUnidade());
          $objAtributoAndamentoDTO->setStrIdOrigem($objBlocoDTO->getNumIdUnidade());
          $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;
          
          $objAtividadeDTO = new AtividadeDTO();
          $objAtividadeDTO->setDblIdProtocolo($dblIdProcesso);
          $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objAtividadeDTO->setNumIdTarefa($numIdTarefa);
          $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);
          
          $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);
        }
                 
      }else{

        //obtem unidades de disponibilizacao do bloco
        $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
        $objRelBlocoUnidadeDTO->retNumIdUnidade();
        $objRelBlocoUnidadeDTO->retStrSiglaUnidade();
        $objRelBlocoUnidadeDTO->retStrDescricaoUnidade();
        $objRelBlocoUnidadeDTO->retNumIdBloco();
        $objRelBlocoUnidadeDTO->setNumIdBloco($numIdBloco);
        $objRelBlocoUnidadeDTO->setNumIdUnidade($objBlocoDTO->getNumIdUnidade(), InfraDTO::$OPER_DIFERENTE);
        
        if ($numIdTarefa == TarefaRN::$TI_BLOCO_CANCELAMENTO_DISPONIBILIZACAO){
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');
        }
        
        $arrObjRelBlocoUnidadeDTO = $objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO);

        if (count($arrObjRelBlocoUnidadeDTO)) {

          $arrObjAtributoAndamentoDTO = array();

          $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
          $objAtributoAndamentoDTO->setStrNome('BLOCO');
          $objAtributoAndamentoDTO->setStrValor($numIdBloco);
          $objAtributoAndamentoDTO->setStrIdOrigem($numIdBloco);
          $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;

          foreach ($arrObjRelBlocoUnidadeDTO as $objRelBlocoUnidadeDTO) {
            $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
            $objAtributoAndamentoDTO->setStrNome('UNIDADE');
            $objAtributoAndamentoDTO->setStrValor($objRelBlocoUnidadeDTO->getStrSiglaUnidade().'�'.$objRelBlocoUnidadeDTO->getStrDescricaoUnidade());
            $objAtributoAndamentoDTO->setStrIdOrigem($objRelBlocoUnidadeDTO->getNumIdUnidade());
            $arrObjAtributoAndamentoDTO[] = $objAtributoAndamentoDTO;
          }

          //lan�a um andamento em cada processo
          foreach ($arrIdProcessos as $dblIdProcesso) {

            $objAtividadeDTO = new AtividadeDTO();
            $objAtividadeDTO->setDblIdProtocolo($dblIdProcesso);
            $objAtividadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
            $objAtividadeDTO->setNumIdTarefa($numIdTarefa);
            $objAtividadeDTO->setArrObjAtributoAndamentoDTO($arrObjAtributoAndamentoDTO);

            $objAtividadeRN->gerarInternaRN0727($objAtividadeDTO);
          }
        }
     }
            
    }catch(Exception $e){
      throw new InfraException('Erro lan�ando andamento para processos do bloco.',$e);
    }
  }

  protected function priorizarControlado($parArrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_priorizar',__METHOD__,$parArrObjBlocoDTO);

      $arrIdBloco = InfraArray::converterArrInfraDTO($parArrObjBlocoDTO, 'IdBloco');

      $arrObjBlocoDTO = $this->validarSinalizacaoBlocos($arrIdBloco);

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retStrSinPrioridade();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

      $strDataHora = InfraData::getStrDataHoraAtual();

      foreach($arrIdBloco as $numIdBloco){

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        /*
        if (!isset($arrObjRelBlocoUnidadeDTO[$numIdBloco])){

          if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            throw new InfraException('Bloco '.$numIdBloco.' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
          }

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
          $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
          $objRelBlocoUnidadeDTO->setDthRevisao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('S');
          $objRelBlocoUnidadeDTO->setDthPrioridade($strDataHora);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
          $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
          $objRelBlocoUnidadeDTO->setDthComentario(null);
          $objRelBlocoUnidadeDTO->setStrSinComentario('N');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');
          $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);

        }else{
        */

          $objRelBlocoUnidadeDTO = $arrObjRelBlocoUnidadeDTO[$numIdBloco];
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrSinPrioridade($objRelBlocoUnidadeDTO->getStrSinPrioridade()=='N'?'S':'N');
          $objRelBlocoUnidadeDTO->setDthPrioridade($strDataHora);
          $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        //}
      }

    }catch(Exception $e){
      throw new InfraException('Erro priorizando bloco.',$e);
    }
  }

  protected function revisarControlado($parArrObjBlocoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_revisar',__METHOD__,$parArrObjBlocoDTO);

      $arrIdBloco = InfraArray::converterArrInfraDTO($parArrObjBlocoDTO, 'IdBloco');

      $arrObjBlocoDTO = $this->validarSinalizacaoBlocos($arrIdBloco);

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retStrSinRevisao();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

      $strDataHora = InfraData::getStrDataHoraAtual();

      foreach($arrIdBloco as $numIdBloco){

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        /*
        if (!isset($arrObjRelBlocoUnidadeDTO[$numIdBloco])){

          if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            throw new InfraException('Bloco '.$numIdBloco.' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
          }

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrSinRevisao('S');
          $objRelBlocoUnidadeDTO->setDthRevisao($strDataHora);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
          $objRelBlocoUnidadeDTO->setDthPrioridade(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
          $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
          $objRelBlocoUnidadeDTO->setDthComentario(null);
          $objRelBlocoUnidadeDTO->setStrSinComentario('N');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');

          $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);

        }else{
        */

          $objRelBlocoUnidadeDTO = $arrObjRelBlocoUnidadeDTO[$numIdBloco];
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrSinRevisao($objRelBlocoUnidadeDTO->getStrSinRevisao()=='N'?'S':'N');
          $objRelBlocoUnidadeDTO->setDthRevisao($strDataHora);
          $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        //}
      }

    }catch(Exception $e){
      throw new InfraException('Erro revisando bloco.',$e);
    }
  }

  protected function atribuirControlado(BlocoAtribuirDTO $objBlocoAtribuirDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_atribuir',__METHOD__,$objBlocoAtribuirDTO);

      $arrIdBloco = InfraArray::converterArrInfraDTO($objBlocoAtribuirDTO->getArrObjBlocoDTO(), 'IdBloco');

      $arrObjBlocoDTO = $this->validarSinalizacaoBlocos($arrIdBloco);

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retNumIdUsuarioAtribuicao();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

      foreach($arrIdBloco as $numIdBloco){

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        /*
        if (!isset($arrObjRelBlocoUnidadeDTO[$numIdBloco])){

          if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            throw new InfraException('Bloco '.$numIdBloco.' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
          }

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao($objBlocoAtribuirDTO->getNumIdUsuarioAtribuicao());
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
          $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
          $objRelBlocoUnidadeDTO->setDthRevisao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
          $objRelBlocoUnidadeDTO->setDthPrioridade(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
          $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
          $objRelBlocoUnidadeDTO->setDthComentario(null);
          $objRelBlocoUnidadeDTO->setStrSinComentario('N');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');
          $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);

        }else{
        */

          $objRelBlocoUnidadeDTO = $arrObjRelBlocoUnidadeDTO[$numIdBloco];
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao($objBlocoAtribuirDTO->getNumIdUsuarioAtribuicao());
          $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        //}
      }

    }catch(Exception $e){
      throw new InfraException('Erro atribuindo bloco.',$e);
    }
  }

  protected function removerRevisaoControlado($arrObjBlocoDTO){
    try {

      if (count($arrObjBlocoDTO)==0){
        throw new InfraException('Nenhum bloco informado.');
      }

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->setNumIdBloco(InfraArray::converterArrInfraDTO($arrObjBlocoDTO,'IdBloco'), InfraDTO::$OPER_IN);
      $objRelBlocoUnidadeDTO->setStrSinRevisao('S');

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = $objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO);

      foreach($arrObjRelBlocoUnidadeDTO as $objRelBlocoUnidadeDTO){
        $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
        $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
        $objRelBlocoUnidadeDTO->setDthRevisao(null);
        $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);
      }

    }catch(Exception $e){
      throw new InfraException('Erro removendo sinaliza��o de revis�o do bloco.',$e);
    }
  }

  protected function comentarControlado(BlocoComentarDTO $objBlocoComentarDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_comentar',__METHOD__, $objBlocoComentarDTO);

      $arrIdBloco = InfraArray::converterArrInfraDTO($objBlocoComentarDTO->getArrObjBlocoDTO(), 'IdBloco');

      $arrObjBlocoDTO = $this->validarSinalizacaoBlocos($arrIdBloco);

      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retNumIdUsuarioAtribuicao();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

      $strDataHora = InfraData::getStrDataHoraAtual();

      foreach($arrIdBloco as $numIdBloco){

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        /*
        if (!isset($arrObjRelBlocoUnidadeDTO[$numIdBloco])){

          if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            throw new InfraException('Bloco '.$numIdBloco.' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
          }

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
          $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
          $objRelBlocoUnidadeDTO->setDthRevisao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
          $objRelBlocoUnidadeDTO->setDthPrioridade(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrTextoComentario($objBlocoComentarDTO->getStrTextoComentario());
          $objRelBlocoUnidadeDTO->setDthComentario($strDataHora);
          $objRelBlocoUnidadeDTO->setStrSinComentario('S');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');

          $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);

        }else{
        */

          $objRelBlocoUnidadeDTO = $arrObjRelBlocoUnidadeDTO[$numIdBloco];
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(SessaoSEI::getInstance()->getNumIdUsuario());
          $objRelBlocoUnidadeDTO->setStrTextoComentario($objBlocoComentarDTO->getStrTextoComentario());
          $objRelBlocoUnidadeDTO->setDthComentario($strDataHora);
          $objRelBlocoUnidadeDTO->setStrSinComentario('S');
          $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        //}
      }

    }catch(Exception $e){
      throw new InfraException('Erro comentando bloco.',$e);
    }
  }

  private function validarSinalizacaoBlocos($arrIdBloco){
    try{

      $objInfraException = new InfraException();

      if (count($arrIdBloco)==0){
        $objInfraException->lancarValidacao('Nenhum bloco informado.');
      }

      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retNumIdUnidade();
      $objBlocoDTO->retStrStaEstado();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $arrObjBlocoDTO = InfraArray::indexarArrInfraDTO($this->pesquisar($objBlocoDTO),'IdBloco');

      foreach($arrIdBloco as $numIdBloco){

        if (!isset($arrObjBlocoDTO[$numIdBloco])){
          $objInfraException->lancarValidacao('Bloco '.$numIdBloco.' n�o encontrado.');
        }

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual() && $objBlocoDTO->getStrStaEstado()!=BlocoRN::$TE_RECEBIDO){
          $objInfraException->lancarValidacao('Bloco '.$numIdBloco.' n�o est� disponibilizado para a unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }

        //if ($objBlocoDTO->getStrStaTipo()!=BlocoRN::$TB_ASSINATURA){
        //  $objInfraException->lancarValidacao('Bloco '.$numIdBloco.' n�o � de assinatura.');
        //}
      }

      return $arrObjBlocoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro validando sinaliza��o em blocos.',$e);
    }
  }

  protected function alterarGrupoControlado(RelBlocoUnidadeDTO $parObjRelBlocoUnidadeDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('bloco_alterar_grupo',__METHOD__, $parObjRelBlocoUnidadeDTO);

      $objInfraException = new InfraException();

      $arrIdBloco = $parObjRelBlocoUnidadeDTO->getNumIdBloco();

      if (!is_array($arrIdBloco)){
        $arrIdBloco = array($arrIdBloco);
      }

      $arrObjBlocoDTO = $this->validarSinalizacaoBlocos($arrIdBloco);

      if ($parObjRelBlocoUnidadeDTO->getNumIdGrupoBloco()!=null) {
        $objGrupoBlocoDTO = new GrupoBlocoDTO();
        $objGrupoBlocoDTO->setBolExclusaoLogica(false);
        $objGrupoBlocoDTO->retStrNome();
        $objGrupoBlocoDTO->retNumIdUnidade();
        $objGrupoBlocoDTO->setNumIdGrupoBloco($parObjRelBlocoUnidadeDTO->getNumIdGrupoBloco());

        $objGrupoBlocoRN = new GrupoBlocoRN();
        $objGrupoBlocoDTO = $objGrupoBlocoRN->consultar($objGrupoBlocoDTO);

        if ($objGrupoBlocoDTO == null) {
          throw new InfraException('Grupo de Blocos n�o encontrado.');
        }

        if ($objGrupoBlocoDTO->getNumIdUnidade() != SessaoSEI::getInstance()->getNumIdUnidadeAtual()) {
          $objInfraException->lancarValidacao('Grupo de Blocos "'.$objGrupoBlocoDTO->getStrNome().'" n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
        }
      }


      $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
      $objRelBlocoUnidadeDTO->retNumIdBloco();
      $objRelBlocoUnidadeDTO->retNumIdUnidade();
      $objRelBlocoUnidadeDTO->retNumIdGrupoBloco();
      $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
      $objRelBlocoUnidadeDTO->setNumIdBloco($arrIdBloco, InfraDTO::$OPER_IN);

      $objRelBlocoUnidadeRN = new RelBlocoUnidadeRN();
      $arrObjRelBlocoUnidadeDTO = InfraArray::indexarArrInfraDTO($objRelBlocoUnidadeRN->listarRN1304($objRelBlocoUnidadeDTO),'IdBloco');

      foreach($arrIdBloco as $numIdBloco){

        $objBlocoDTO = $arrObjBlocoDTO[$numIdBloco];

        /*
        if (!isset($arrObjRelBlocoUnidadeDTO[$numIdBloco])){

          if ($objBlocoDTO->getNumIdUnidade()!=SessaoSEI::getInstance()->getNumIdUnidadeAtual()){
            throw new InfraException('Bloco '.$numIdBloco.' n�o pertence � unidade '.SessaoSEI::getInstance()->getStrSiglaUnidadeAtual().'.');
          }

          $objRelBlocoUnidadeDTO = new RelBlocoUnidadeDTO();
          $objRelBlocoUnidadeDTO->setNumIdBloco($objBlocoDTO->getNumIdBloco());
          $objRelBlocoUnidadeDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual());
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco($parObjRelBlocoUnidadeDTO->getNumIdGrupoBloco());
          $objRelBlocoUnidadeDTO->setNumIdUsuarioAtribuicao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioRevisao(null);
          $objRelBlocoUnidadeDTO->setStrSinRevisao('N');
          $objRelBlocoUnidadeDTO->setDthRevisao(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioPrioridade(null);
          $objRelBlocoUnidadeDTO->setStrSinPrioridade('N');
          $objRelBlocoUnidadeDTO->setDthPrioridade(null);
          $objRelBlocoUnidadeDTO->setNumIdUsuarioComentario(null);
          $objRelBlocoUnidadeDTO->setStrTextoComentario(null);
          $objRelBlocoUnidadeDTO->setDthComentario(null);
          $objRelBlocoUnidadeDTO->setStrSinComentario('N');
          $objRelBlocoUnidadeDTO->setStrSinRetornado('N');

          $objRelBlocoUnidadeRN->cadastrarRN1300($objRelBlocoUnidadeDTO);

        }else{
        */

          $objRelBlocoUnidadeDTO = $arrObjRelBlocoUnidadeDTO[$numIdBloco];
          $objRelBlocoUnidadeDTO->setNumIdGrupoBloco($parObjRelBlocoUnidadeDTO->getNumIdGrupoBloco());
          $objRelBlocoUnidadeRN->alterarRN1301($objRelBlocoUnidadeDTO);

        //}
      }

    }catch(Exception $e){
      throw new InfraException('Erro sinalizando grupo em blocos.',$e);
    }
  }

  public function configurarFiltroBlocosUnidade(BlocoDTO $objBlocoDTO){
    try{

      $objBlocoDTO->adicionarCriterio(array('IdUnidade', 'IdUnidadeRelBlocoUnidade'),
        array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
        array(SessaoSEI::getInstance()->getNumIdUnidadeAtual(), SessaoSEI::getInstance()->getNumIdUnidadeAtual()),
        InfraDTO::$OPER_LOGICO_AND,
        'cUnidade');

      $objBlocoDTO->adicionarCriterio(array('StaEstado', 'IdUnidade', 'IdUnidadeRelBlocoUnidade', 'SinRetornadoRelBlocoUnidade'),
        array(InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_DIFERENTE, InfraDTO::$OPER_IGUAL, InfraDTO::$OPER_IGUAL),
        array(BlocoRN::$TE_DISPONIBILIZADO, SessaoSEI::getInstance()->getNumIdUnidadeAtual(), SessaoSEI::getInstance()->getNumIdUnidadeAtual(), 'N'),
        array(InfraDTO::$OPER_LOGICO_AND, InfraDTO::$OPER_LOGICO_AND, InfraDTO::$OPER_LOGICO_AND),
        'cRecebidos');

      $objBlocoDTO->agruparCriterios(array('cUnidade', 'cRecebidos'), InfraDTO::$OPER_LOGICO_OR);

    }catch(Exception $e){
      throw new InfraException('Erro configurando filtro de blocos da unidade.',$e);
    }
  }

  protected function concluirBlocosDisponibilizadosConectado(BlocoDTO $parObjBlocoDTO){
    try{

      $arrObjBlocoDTOConclusao = array();

      $objInfraException = new InfraException();

      $this->validarNumDiasSemMovimentacao($parObjBlocoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objBlocoDTO = new BlocoDTO();
      $objBlocoDTO->retNumIdBloco();
      $objBlocoDTO->retStrStaTipo();
      $objBlocoDTO->setNumIdUnidade($parObjBlocoDTO->getNumIdUnidade());
      $objBlocoDTO->setStrStaTipo(BlocoRN::$TB_INTERNO, InfraDTO::$OPER_DIFERENTE);
      $objBlocoDTO->setStrStaEstado(BlocoRN::$TE_DISPONIBILIZADO);
      $arrObjBlocoDTODisponibilizados = $this->listarRN1277($objBlocoDTO);

      $objAtributoAndamentoRN = new AtributoAndamentoRN();
      $objRelBlocoProtocoloRN = new RelBlocoProtocoloRN();
      $objAssinaturaRN = new AssinaturaRN();

      if (count($arrObjBlocoDTODisponibilizados)) {

        $dthLimite = InfraData::calcularData($parObjBlocoDTO->getNumDiasSemMovimentacao(), InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS).' 00:00:00';

        foreach($arrObjBlocoDTODisponibilizados as $objBlocoDTODisponibilizado) {

          $objAtributoAndamentoDTO = new AtributoAndamentoDTO();
          $objAtributoAndamentoDTO->setNumMaxRegistrosRetorno(1);
          $objAtributoAndamentoDTO->retStrIdOrigem();
          $objAtributoAndamentoDTO->setNumIdTarefaAtividade(array(
                  TarefaRN::$TI_BLOCO_DISPONIBILIZACAO,
                  TarefaRN::$TI_BLOCO_RETORNO,
                  TarefaRN::$TI_DOCUMENTO_INCLUIDO_EM_BLOCO,
                  TarefaRN::$TI_DOCUMENTO_RETIRADO_DO_BLOCO,
                  TarefaRN::$TI_PROCESSO_INCLUIDO_EM_BLOCO,
                  TarefaRN::$TI_PROCESSO_RETIRADO_DO_BLOCO), InfraDTO::$OPER_IN);
          $objAtributoAndamentoDTO->setDthAberturaAtividade($dthLimite, InfraDTO::$OPER_MAIOR);
          $objAtributoAndamentoDTO->setStrNome('BLOCO');
          $objAtributoAndamentoDTO->setStrIdOrigem($objBlocoDTODisponibilizado->getNumIdBloco());
          $objAtributoAndamentoDTO->setOrdStrIdOrigem(InfraDTO::$TIPO_ORDENACAO_ASC);

          if ($objAtributoAndamentoRN->consultarRN1366($objAtributoAndamentoDTO)==null){

            $bolConcluir = true;

            if ($objBlocoDTODisponibilizado->getStrStaTipo() == BlocoRN::$TB_ASSINATURA) {

              $objRelBlocoProtocoloDTO = new RelBlocoProtocoloDTO();
              $objRelBlocoProtocoloDTO->retDblIdProtocolo();
              $objRelBlocoProtocoloDTO->setNumIdBloco($objBlocoDTODisponibilizado->getNumIdBloco());
              $objRelBlocoProtocoloDTO->setOrdDblIdProtocolo(InfraDTO::$TIPO_ORDENACAO_ASC);

              $arrIdProtocolosBlocoPartes = array_chunk(InfraArray::converterArrInfraDTO($objRelBlocoProtocoloRN->listarRN1291($objRelBlocoProtocoloDTO), 'IdProtocolo'), 100);

              foreach ($arrIdProtocolosBlocoPartes as $arrIdProtocolosBloco) {

                $objAssinaturaDTO = new AssinaturaDTO();
                $objAssinaturaDTO->retDblIdDocumento();
                $objAssinaturaDTO->retDthAberturaAtividade();
                $objAssinaturaDTO->setDblIdDocumento($arrIdProtocolosBloco, InfraDTO::$OPER_IN);

                $arrObjAssinaturaDTO = $objAssinaturaRN->listarRN1323($objAssinaturaDTO);

                $arrIdAssinados = array();

                foreach($arrObjAssinaturaDTO as $objAssinaturaDTO){

                  $numTempoAssinatura = InfraData::compararDataHora($dthLimite, $objAssinaturaDTO->getDthAberturaAtividade());

                  if ($numTempoAssinatura > 0){
                    $bolConcluir = false;
                    break;
                  }

                  $arrIdAssinados[$objAssinaturaDTO->getDblIdDocumento()] = true;
                }

                if (count($arrIdProtocolosBloco)!=count($arrIdAssinados)){
                  $bolConcluir = false;
                  break;
                }
              }
            }

            if ($bolConcluir) {
              $objBlocoDTO = new BlocoDTO();
              $objBlocoDTO->setNumIdBloco($objBlocoDTODisponibilizado->getNumIdBloco());
              $arrObjBlocoDTOConclusao[] = $objBlocoDTO;
            }
          }
        }

        $numBlocos = count($arrObjBlocoDTOConclusao);

        if ($numBlocos) {

          SessaoSEI::getInstance()->simularLogin(SessaoSEI::$USUARIO_SEI, null, null, $parObjBlocoDTO->getNumIdUnidade());

          $arrObjBlocoDTOPaginas = array_chunk($arrObjBlocoDTOConclusao, 50);

          foreach ($arrObjBlocoDTOPaginas as $arrObjBlocoDTOPagina) {
            $this->concluirBlocosDisponibilizadosInterno($arrObjBlocoDTOPagina);
          }
        }
      }

      return $arrObjBlocoDTOConclusao;

      }catch(Exception $e){
      throw new InfraException('Erro concluindo blocos disponibilizados sem movimenta��o.',$e);
    }
  }

  protected function concluirBlocosDisponibilizadosInternoControlado($arrObjBlocoDTO){
    try{

      $this->cancelarDisponibilizacao($arrObjBlocoDTO);
      $this->concluir($arrObjBlocoDTO);

    }catch(Exception $e){
      throw new InfraException('Erro concluindo blocos disponibilizados.', $e);
    }
  }
}
?>