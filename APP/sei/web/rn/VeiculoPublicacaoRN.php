<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 24/07/2013 - criado por mkr@trf4.jus.br
*
* Vers�o do Gerador de C�digo: 1.33.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class VeiculoPublicacaoRN extends InfraRN {

  public static $TV_INTERNO = 'I';
  public static $TV_EXTERNO = 'E';  
  public static $TV_MODULO = 'M';

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }
         
  public function listarValoresTipo(){
    try {

      $arrObjTipoDTO = array();

      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TV_INTERNO);
      $objTipoDTO->setStrDescricao('Interno');
      $arrObjTipoDTO[] = $objTipoDTO;

      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TV_EXTERNO);
      $objTipoDTO->setStrDescricao('Externo');
      $arrObjTipoDTO[] = $objTipoDTO;

      $objTipoDTO = new TipoDTO();
      $objTipoDTO->setStrStaTipo(self::$TV_MODULO);
      $objTipoDTO->setStrDescricao('M�dulo');
      $arrObjTipoDTO[] = $objTipoDTO;

      return $arrObjTipoDTO;

    }catch(Exception $e){
      throw new InfraException('Erro listando valores de Tipo.',$e);
    }
  }
  
  private function validarStrNome(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Nome n�o informado.');
    }else{
      $objVeiculoPublicacaoDTO->setStrNome(trim($objVeiculoPublicacaoDTO->getStrNome()));
      if (strlen($objVeiculoPublicacaoDTO->getStrNome())>100){
        $objInfraException->adicionarValidacao('Nome possui tamanho superior a 100 caracteres.');
      }
      
      $objVeiculoPublicacaoDTO_JaExiste = new VeiculoPublicacaoDTO();
      $objVeiculoPublicacaoDTO_JaExiste->retStrSinAtivo();
      $objVeiculoPublicacaoDTO_JaExiste->setBolExclusaoLogica(false);
      $objVeiculoPublicacaoDTO_JaExiste->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao(),InfraDTO::$OPER_DIFERENTE);
      $objVeiculoPublicacaoDTO_JaExiste->setStrNome($objVeiculoPublicacaoDTO->getStrNome());
      $objVeiculoPublicacaoDTO_JaExiste = $this->consultar($objVeiculoPublicacaoDTO_JaExiste);
      if ($objVeiculoPublicacaoDTO_JaExiste != NULL){
        if ($objVeiculoPublicacaoDTO_JaExiste->getStrSinAtivo() == 'N')
          $objInfraException->adicionarValidacao('Existe outro Ve�culo de Publica��o inativo com o mesmo nome.');
        else
          $objInfraException->adicionarValidacao('Existe outro Ve�culo de Publica��o com o mesmo nome.');
      }
      
    }
  }

  private function validarStrDescricao(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrDescricao())){
      $objVeiculoPublicacaoDTO->setStrDescricao(null);
    }else{
      $objVeiculoPublicacaoDTO->setStrDescricao(trim($objVeiculoPublicacaoDTO->getStrDescricao()));

      if (strlen($objVeiculoPublicacaoDTO->getStrDescricao())>500){
        $objInfraException->adicionarValidacao('Descri��o possui tamanho superior a 500 caracteres.');
      }
    }
  }
  
  private function validarStrStaTipo(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrStaTipo())){
      $objInfraException->adicionarValidacao('Tipo de Ve�culo n�o informado.');
    }else{
      if (!in_array($objVeiculoPublicacaoDTO->getStrStaTipo(),InfraArray::converterArrInfraDTO($this->listarValoresTipo(),'StaTipo'))){
        $objInfraException->adicionarValidacao('Tipo de Ve�culo inv�lido.');
      }
      
      if ($objVeiculoPublicacaoDTO->getStrStaTipo() == self::$TV_INTERNO){
        
        $objVeiculoPublicacaoDTO_JaExiste = new VeiculoPublicacaoDTO();
        $objVeiculoPublicacaoDTO_JaExiste->retStrSinAtivo();
        $objVeiculoPublicacaoDTO_JaExiste->setStrStaTipo(self::$TV_INTERNO);
        $objVeiculoPublicacaoDTO_JaExiste->setBolExclusaoLogica(false);
        $objVeiculoPublicacaoDTO_JaExiste->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao(),InfraDTO::$OPER_DIFERENTE);
        $objVeiculoPublicacaoDTO_JaExiste = $this->consultar($objVeiculoPublicacaoDTO_JaExiste);
        if ($objVeiculoPublicacaoDTO_JaExiste != NULL){
          if ($objVeiculoPublicacaoDTO_JaExiste->getStrSinAtivo() == 'N')
            $objInfraException->adicionarValidacao('J� existe um Ve�culo de Publica��o inativo do tipo "Interno" cadastrado.');
          else
            $objInfraException->adicionarValidacao('J� existe um Ve�culo de Publica��o do tipo "Interno" cadastrado.');
        }
        
        $objVeiculoPublicacaoDTO->setStrSinExibirPesquisaInterna('S');
        
      }
    }
  }
  
  private function validarStrSinFonteFeriados(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrSinFonteFeriados())){
      $objInfraException->adicionarValidacao('Sinalizador de Fonte de Feriados n�o informado.');
    }else{
      
      if (!InfraUtil::isBolSinalizadorValido($objVeiculoPublicacaoDTO->getStrSinFonteFeriados())){
        $objInfraException->adicionarValidacao('Sinalizador de Fonte de Feriados inv�lido.');
      }
      
      if ($objVeiculoPublicacaoDTO->getStrSinFonteFeriados() == 'S'){
        $objVeiculoPublicacaoDTO_JaExiste = new VeiculoPublicacaoDTO();
        $objVeiculoPublicacaoDTO_JaExiste->retStrSinAtivo();
        $objVeiculoPublicacaoDTO_JaExiste->setStrSinFonteFeriados('S');
        $objVeiculoPublicacaoDTO_JaExiste->setBolExclusaoLogica(false);      
        $objVeiculoPublicacaoDTO_JaExiste->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao(),InfraDTO::$OPER_DIFERENTE);      
        $objVeiculoPublicacaoDTO_JaExiste = $this->consultar($objVeiculoPublicacaoDTO_JaExiste);
        if ($objVeiculoPublicacaoDTO_JaExiste != NULL){
          if ($objVeiculoPublicacaoDTO_JaExiste->getStrSinAtivo() == 'N')
            $objInfraException->adicionarValidacao('J� existe um ve�culo de publica��o inativo cadastrado como fonte de feriados.');
          else
            $objInfraException->adicionarValidacao('J� existe um ve�culo de publica��o cadastrado como fonte de feriados.');
        }else{
          if ($objVeiculoPublicacaoDTO->getStrStaTipo() != self::$TV_EXTERNO){
            $objInfraException->adicionarValidacao('Somente ve�culos de publica��o externos podem ser fonte de feriados.');
          }
        }
      }
    }
  }

  private function validarStrSinExibirPesquisaInterna(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna())){
      $objInfraException->adicionarValidacao('Sinalizador de exibi��o na pesquisa interna de publica��es n�o informado.');
    }else{
  
      if (!InfraUtil::isBolSinalizadorValido($objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna())){
        $objInfraException->adicionarValidacao('Sinalizador de exibi��o na pesquisa interna de publica��es inv�lido.');
      }
    }
  }
  
  private function validarStrSinPermiteExtraordinaria(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrSinPermiteExtraordinaria())){
      $objInfraException->adicionarValidacao('Sinalizador de Permite Edi��o Extraordin�ria n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objVeiculoPublicacaoDTO->getStrSinPermiteExtraordinaria())){
        $objInfraException->adicionarValidacao('Sinalizador de Permite Edi��o Extraordin�ria inv�lido.');
      }
    }
  }
 
  private function validarStrWebService(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if ($objVeiculoPublicacaoDTO->isSetStrStaTipo() && $objVeiculoPublicacaoDTO->getStrStaTipo() == VeiculoPublicacaoRN::$TV_EXTERNO && InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrWebService())){
      $objInfraException->adicionarValidacao('Web Service n�o informado.');
    }else if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrWebService())){              
      $objVeiculoPublicacaoDTO->setStrWebService(null);
    }else{
      $objVeiculoPublicacaoDTO->setStrWebService(trim($objVeiculoPublicacaoDTO->getStrWebService()));

      if (strlen($objVeiculoPublicacaoDTO->getStrWebService())>250){
        $objInfraException->adicionarValidacao('Web Service possui tamanho superior a 250 caracteres.');
      }
      
    }
  }

  private function validarStrSinAtivo(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrSinAtivo())){
      $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica n�o informado.');
    }else{
      if (!InfraUtil::isBolSinalizadorValido($objVeiculoPublicacaoDTO->getStrSinAtivo())){
        $objInfraException->adicionarValidacao('Sinalizador de Exclus�o L�gica inv�lido.');
      }
    }
  }

  protected function cadastrarControlado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO) {
    try{

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_cadastrar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNome($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrDescricao($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrStaTipo($objVeiculoPublicacaoDTO, $objInfraException);      
      $this->validarStrSinFonteFeriados($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrSinExibirPesquisaInterna($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrSinPermiteExtraordinaria($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrWebService($objVeiculoPublicacaoDTO, $objInfraException);
      $this->validarStrSinAtivo($objVeiculoPublicacaoDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objVeiculoPublicacaoBD->cadastrar($objVeiculoPublicacaoDTO);

      $objVeiculoPublicacaoAPI = VeiculoPublicacaoAPI::criar($objVeiculoPublicacaoDTO);
      foreach ($SEI_MODULOS as $seiModulo) {
        $seiModulo->executar('cadastrarVeiculoPublicacao', $objVeiculoPublicacaoAPI);
      }

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Ve�culo de Publica��o.',$e);
    }
  }

  public function indexar(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO){

    LimiteSEI::getInstance()->configurarNivel2();

    $arrCorBarraProgresso=array('cor_fundo'=>'#5c9ccc','cor_borda'=>'#4297d7');
    $prb = InfraBarraProgresso2::newInstance('indexacao',$arrCorBarraProgresso);

    $objPublicacaoDTO = new PublicacaoDTO();
    $objPublicacaoDTO->retNumIdPublicacao();
    $objPublicacaoDTO->retStrStaEstado();
    $objPublicacaoDTO->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao());

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

    $objIndexacaoRN = new IndexacaoRN();
    $objIndexacaoDTO = new IndexacaoDTO();


    $prb->setNumMin(0);
    $prb->setNumMax($numPaginas);

    for ($numPaginaAtual = 0; $numPaginaAtual < $numPaginas; $numPaginaAtual++){

      if ($numPaginaAtual ==  ($numPaginas-1)){
        $numRegistrosAtual = $numRegistros;
      }else{
        $numRegistrosAtual = ($numPaginaAtual+1)*$numRegistrosPagina;
      }

      if ($objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna()=='S'){
        $prb->setStrRotulo('Indexando '.$numRegistrosAtual.' de '.$numRegistros.'...');
      }else{
        $prb->setStrRotulo('Desindexando '.$numRegistrosAtual.' de '.$numRegistros.'...');
      }
      $prb->moverProximo();

      $arrObjPublicacaoDTOPagina = array_slice($arrObjPublicacaoDTO, ($numPaginaAtual*$numRegistrosPagina), $numRegistrosPagina);
      $objPublicacaoDTO = new PublicacaoDTO();
      $objPublicacaoDTO->retTodos(true);
      $objPublicacaoDTO->setNumIdPublicacao(InfraArray::converterArrInfraDTO($arrObjPublicacaoDTOPagina,'IdPublicacao'),InfraDTO::$OPER_IN);
      $objIndexacaoDTO->setArrObjPublicacaoDTO($objPublicacaoRN->listarRN1045($objPublicacaoDTO));
      $objIndexacaoDTO->setStrStaOperacao(IndexacaoRN::$TO_PUBLICACAO);

      if ($objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna()=='S'){
        $objIndexacaoRN->indexarPublicacao($objIndexacaoDTO);
      }else{
        $objIndexacaoRN->prepararRemocaoPublicacao($objIndexacaoDTO);
        FeedSEIPublicacoes::getInstance()->indexarFeeds();
      }
    }

    if ($objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna()=='S'){
      $prb->setStrRotulo('Finalizado: indexadas '.$numRegistros.' publica��es.');
    }else{
      $prb->setStrRotulo('Finalizado: desindexadas '.$numRegistros.' publica��es.');
    }
    sleep(2);

  }
  
  protected function alterarControlado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_alterar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $objVeiculoPublicacaoDTOBanco = new VeiculoPublicacaoDTO();
      $objVeiculoPublicacaoDTOBanco->retStrNome();
      $objVeiculoPublicacaoDTOBanco->retStrDescricao();
      $objVeiculoPublicacaoDTOBanco->retStrStaTipo();
      $objVeiculoPublicacaoDTOBanco->retStrSinFonteFeriados();
      $objVeiculoPublicacaoDTOBanco->retStrSinExibirPesquisaInterna();
      $objVeiculoPublicacaoDTOBanco->retStrSinPermiteExtraordinaria();
      $objVeiculoPublicacaoDTOBanco->retStrWebService();
      $objVeiculoPublicacaoDTOBanco->retStrSinAtivo();
      $objVeiculoPublicacaoDTOBanco->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao());
      $objVeiculoPublicacaoDTOBanco = $this->consultar($objVeiculoPublicacaoDTOBanco);

      if ($objVeiculoPublicacaoDTO->isSetStrNome()){
        $this->validarStrNome($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrNome($objVeiculoPublicacaoDTOBanco->getStrNome());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrDescricao()){
        $this->validarStrDescricao($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrDescricao($objVeiculoPublicacaoDTOBanco->getStrDescricao());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrStaTipo()){
        $this->validarStrStaTipo($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrStaTipo($objVeiculoPublicacaoDTOBanco->getStrStaTipo());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrSinFonteFeriados()){
        $this->validarStrSinFonteFeriados($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrSinFonteFeriados($objVeiculoPublicacaoDTOBanco->getStrSinFonteFeriados());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrSinExibirPesquisaInterna()){
        $this->validarStrSinExibirPesquisaInterna($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrSinExibirPesquisaInterna($objVeiculoPublicacaoDTOBanco->getStrSinExibirPesquisaInterna());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrSinPermiteExtraordinaria()){
        $this->validarStrSinPermiteExtraordinaria($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrSinPermiteExtraordinaria($objVeiculoPublicacaoDTOBanco->getStrSinPermiteExtraordinaria());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrWebService()){
        $this->validarStrWebService($objVeiculoPublicacaoDTO, $objInfraException);
      }else {
        $objVeiculoPublicacaoDTO->setStrWebService($objVeiculoPublicacaoDTOBanco->getStrWebService());
      }

      if ($objVeiculoPublicacaoDTO->isSetStrSinAtivo()){
        $this->validarStrSinAtivo($objVeiculoPublicacaoDTO, $objInfraException);
      }else{
        $objVeiculoPublicacaoDTO->setStrSinAtivo($objVeiculoPublicacaoDTOBanco->getStrSinAtivo());
      }

      $objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $objVeiculoPublicacaoBD->alterar($objVeiculoPublicacaoDTO);

      $objVeiculoPublicacaoAPI = VeiculoPublicacaoAPI::criar($objVeiculoPublicacaoDTO);
      foreach ($SEI_MODULOS as $seiModulo) {
        $seiModulo->executar('alterarVeiculoPublicacao', $objVeiculoPublicacaoAPI);
      }

      if ($objVeiculoPublicacaoDTOBanco->getStrSinExibirPesquisaInterna()!=$objVeiculoPublicacaoDTO->getStrSinExibirPesquisaInterna()){
        return true;
      }

      return false;
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Ve�culo de Publica��o.',$e);
    }
  }

  private function validarSePodeExcluir(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO, InfraException $objInfraException){
    $objPublicacaoRN = new PublicacaoRN();
    $objPublicacaoDTO = new PublicacaoDTO();       
    $objPublicacaoDTO->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao());
    if ($objPublicacaoRN->contarRN1046($objPublicacaoDTO) > 0){    
      $objInfraException->lancarValidacao('Existem publica��es utilizando este ve�culo.');
    }

    $objPublicacaoLegadoRN = new PublicacaoLegadoRN();
    $objPublicacaoLegadoDTO = new PublicacaoLegadoDTO();       
    $objPublicacaoLegadoDTO->setNumIdVeiculoPublicacao($objVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao());
    if ($objPublicacaoLegadoRN->contar($objPublicacaoLegadoDTO) > 0){
      $objInfraException->lancarValidacao('Existem publica��es legadas associadas.');
    }
  }
  
  protected function excluirControlado($arrObjVeiculoPublicacaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_excluir',__METHOD__,$arrObjVeiculoPublicacaoDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();
      
      $objRelSerieVeiculoPublicacaoDTO = new RelSerieVeiculoPublicacaoDTO();
      $objRelSerieVeiculoPublicacaoDTO->retTodos();
      $objRelSerieVeiculoPublicacaoRN = new RelSerieVeiculoPublicacaoRN();
      
      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVeiculoPublicacaoDTO);$i++){
              
        $this->validarSePodeExcluir($arrObjVeiculoPublicacaoDTO[$i], $objInfraException);
        
        $objRelSerieVeiculoPublicacaoDTO->setNumIdVeiculoPublicacao($arrObjVeiculoPublicacaoDTO[$i]->getNumIdVeiculoPublicacao());
        $objRelSerieVeiculoPublicacaoRN->excluir($objRelSerieVeiculoPublicacaoRN->listar($objRelSerieVeiculoPublicacaoDTO));
      
        $objVeiculoPublicacaoBD->excluir($arrObjVeiculoPublicacaoDTO[$i]);
      }
         
      $arrObjVeiculoPublicacaoAPI = array_map(function($obj){ return VeiculoPublicacaoAPI::criar($obj); }, $arrObjVeiculoPublicacaoDTO);
      foreach ($SEI_MODULOS as $seiModulo) {
        $seiModulo->executar('excluirVeiculoPublicacao', $arrObjVeiculoPublicacaoAPI);
      }

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Ve�culo de Publica��o.',$e);
    }
  }

  protected function consultarConectado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_consultar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objVeiculoPublicacaoBD->consultar($objVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Ve�culo de Publica��o.',$e);
    }
  }

  protected function listarConectado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_listar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objVeiculoPublicacaoBD->listar($objVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Ve�culos de Publica��o.',$e);
    }
  }

  protected function contarConectado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_listar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objVeiculoPublicacaoBD->contar($objVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Ve�culos de Publica��o.',$e);
    }
  }

  protected function desativarControlado($arrObjVeiculoPublicacaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_desativar',__METHOD__,$arrObjVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVeiculoPublicacaoDTO);$i++){
        $objVeiculoPublicacaoBD->desativar($arrObjVeiculoPublicacaoDTO[$i]);
      }

      $arrObjVeiculoPublicacaoAPI = array_map(function($obj){ return VeiculoPublicacaoAPI::criar($obj); }, $arrObjVeiculoPublicacaoDTO);
      foreach ($SEI_MODULOS as $seiModulo) {
        $seiModulo->executar('desativarVeiculoPublicacao', $arrObjVeiculoPublicacaoAPI);
      }

    }catch(Exception $e){
      throw new InfraException('Erro desativando Ve�culo de Publica��o.',$e);
    }
  }

  protected function reativarControlado($arrObjVeiculoPublicacaoDTO){
    try {

      global $SEI_MODULOS;

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_reativar',__METHOD__,$arrObjVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjVeiculoPublicacaoDTO);$i++){
        $objVeiculoPublicacaoBD->reativar($arrObjVeiculoPublicacaoDTO[$i]);
      }

      $arrObjVeiculoPublicacaoAPI = array_map(function($obj){ return VeiculoPublicacaoAPI::criar($obj); }, $arrObjVeiculoPublicacaoDTO);
      foreach ($SEI_MODULOS as $seiModulo) {
        $seiModulo->executar('reativarVeiculoPublicacao', $arrObjVeiculoPublicacaoAPI);
      }

    }catch(Exception $e){
      throw new InfraException('Erro reativando Ve�culo de Publica��o.',$e);
    }
  }

  protected function bloquearControlado(VeiculoPublicacaoDTO $objVeiculoPublicacaoDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('veiculo_publicacao_consultar',__METHOD__,$objVeiculoPublicacaoDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objVeiculoPublicacaoBD = new VeiculoPublicacaoBD($this->getObjInfraIBanco());
      $ret = $objVeiculoPublicacaoBD->bloquear($objVeiculoPublicacaoDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Ve�culo de Publica��o.',$e);
    }
  }

  public function getWebService(VeiculoPublicacaoDTO $parObjVeiculoPublicacaoDTO){

    $objVeiculoPublicacaoDTO = new VeiculoPublicacaoDTO();
    $objVeiculoPublicacaoDTO->setBolExclusaoLogica(false);
    $objVeiculoPublicacaoDTO->retStrWebService();
    $objVeiculoPublicacaoDTO->retStrNome();
    $objVeiculoPublicacaoDTO->setNumIdVeiculoPublicacao($parObjVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao());
    $objVeiculoPublicacaoDTO = $this->consultar($objVeiculoPublicacaoDTO);

    $objWS = null;

    try {

      if ($objVeiculoPublicacaoDTO==null){
        throw new InfraException('Ve�culo de Publica��o ['.$parObjVeiculoPublicacaoDTO->getNumIdVeiculoPublicacao().'] n�o encontrado.');
      }

      if (InfraString::isBolVazia($objVeiculoPublicacaoDTO->getStrWebService())){
        throw new InfraException('Ve�culo de Publica��o "'.$objVeiculoPublicacaoDTO->getStrNome().'" n�o possui Web Service configurado.');
      }

      if(!@file_get_contents($objVeiculoPublicacaoDTO->getStrWebService())){
        throw new InfraException('Falha na leitura do arquivo WSDL ('.$objVeiculoPublicacaoDTO->getStrWebService().')');
      }
      $objWS = new SoapClient($objVeiculoPublicacaoDTO->getStrWebService(), array('encoding'=>'ISO-8859-1'));

    } catch(Exception $e){
      throw new InfraException('Falha na conex�o com o Web Service do Ve�culo de Publica��o.',$e);
    }

    return $objWS;
  }

}
?>