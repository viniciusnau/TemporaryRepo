<?
/*
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 12/11/2007 - criado por MGA
 *
 */

require_once dirname(__FILE__).'/SEI.php';


class PaginaSEI extends InfraPaginaEsquema3
{
  private static $instance = null;
  private $bolArvore = false;
  private $bolD3 =   false;
  private $bolAcoesSistema = true;
  private static $strMenu = null;

  public function getArquivoCssEsquemaLocal(){
    if ($this->getStrEsquemaCores() == self::$ESQUEMA_PRETO){
      return 'infra-esquema-3.css';
    }
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new PaginaSEI();
    }
    return self::$instance;
  }

  public function __construct()
  {
    SeiINT::validarHttps();
    parent::__construct();
  }

  public function getStrNomeSistema()
  {
    return ConfiguracaoSEI::getInstance()->getValor('PaginaSEI', 'NomeSistema');
  }

  public function isBolProducao()
  {
    return ConfiguracaoSEI::getInstance()->getValor('SEI', 'Producao');
  }

  public function validarHashTabelas(){
    return true;
  }

  public function getStrLogoSistema(){
    $strRet = '<img src="svg/sei_barra.svg?'.$this->getNumVersao().'" title="Sistema Eletr�nico de Informa��es - Vers�o ' . SEI_VERSAO . '"/>';
    if (($strComplemento = ConfiguracaoSEI::getInstance()->getValor('PaginaSEI', 'NomeSistemaComplemento',false))!=null){
      $strRet .= '<span class="infraTituloLogoSistema">'.$strComplemento.'</span>';
    }
    return $strRet;
  }

  public function getDiretoriosIconesMenu()
  {
    global $SEI_MODULOS;
    $arr = array('menu');
    foreach($SEI_MODULOS as $objModulo){
      if (($strDir = $objModulo->executar('obterDiretorioIconesMenu'))!=null){
        $arr[] = $strDir;
      }
    }
    return $arr;
  }

  public function getStrMenuSistema()
  {
    global $SEI_MODULOS;

    if (self::$strMenu === null) {

      $strMenu = parent::montarMenuSessao('Principal');

      if (($strLogo = ConfiguracaoSEI::getInstance()->getValor('PaginaSEI', 'LogoMenu', false)) != null) {
        $strMenu = str_replace("<!--LOGO-->" ,$strLogo,$strMenu);
      }

      $strModulos = "";
      foreach($SEI_MODULOS as $objModulo){
        if (($strMenuModulo = $objModulo->executar('adicionarElementoMenu', $_GET['acao']))!=null){
          $strModulos .= $strMenuModulo;
        }
      }
      if($strModulos != ""){
        $strMenu = str_replace("<!--MODULOS-->" ,$strModulos,$strMenu);
      }

      self::$strMenu = $strMenu;
    }

    return self::$strMenu;
  }

  public function getArrStrAcoesSistema()
  {
    global $SEI_MODULOS;

    $arrStrAcoes = array();

    $arrStrAcoes[] = $this->montarLinkMenuTexto();

    if ($this->bolAcoesSistema) {
      $strAcoesIcones = '';

      if (SessaoSEI::getInstance()->verificarPermissao('protocolo_pesquisa_rapida')) {

        $arrStrAcoes[] =' <div class="nav-item px-1 media d-flex py-md-0 ">
                 <form class="form-inline align-self-center w-100" id="frmProtocoloPesquisaRapida" method="post" action="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=protocolo_pesquisa_rapida').'">
                  <div class="input-group">
                    <input type="text" id="txtPesquisaRapida" name="txtPesquisaRapida" class="form-control" placeholder="Pesquisar..." style="font-size:.8rem;height:24px;width:190px;border:0;" tabindex="' . $this->getProxTabBarraSistema() . '" />
                    <span class="input-group-btn">
                      <span id="spnInfraUnidade" class="btn infraAcaoBarraConjugada">
                      <img src="svg/pesquisa_rapida.svg?'.$this->getNumVersao().'" width="20" height="20" onclick="document.getElementById(\'frmProtocoloPesquisaRapida\').submit();" title="Pesquisa R�pida" alt="Pesquisa R�pida" tabindex="' . $this->getProxTabBarraSistema() . '" class="infraImg" />
                      </span>
                    </span>
                  </div>
                 </form>
             </div >           
          ';
      }

      $strAcoesIcones .= ''.$this->montarSelectUnidades().'';

      foreach($SEI_MODULOS as $objModulo){
        if (($arrAcoesModulo = $objModulo->executar('montarIconeSistema'))!=null){
          foreach ($arrAcoesModulo as $strAcaoModulo){
            $strAcoesIcones .= '<div class="nav-item d-flex infraAcaoBarraSistema">'.$strAcaoModulo.'</div >';
          }
        }
      }

      if (SessaoSEI::getInstance()->verificarPermissao('procedimento_controlar')) {
        $strAncora = '';
        if (isset($_GET['acao_origem']) && $_GET['acao_origem'] == 'procedimento_controlar' && isset($_GET['id_procedimento'])) {
          $strAncora = self::montarAncora($_GET['id_procedimento']);
        }
        $strAcoesIcones .= '
          <div class="nav-item d-flex infraAcaoBarraSistema">
            <a class="align-self-center  d-none d-md-block" id="lnkControleProcessos" href="#" onclick="window.location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=procedimento_controlar&reset=1'.$strAncora).'\'" title="Controle de Processos" tabindex="'.$this->getProxTabBarraSistema().'">
              <img src="svg/controle_processos_barra.svg?'.$this->getNumVersao().'" class="infraImg" title="Controle de Processos" />
            </a>
            
            <span title="Controle de Processos"  class=" nav-link d-flex d-md-none" >
               <img src="svg/controle_processos_barra.svg?'.$this->getNumVersao().'" class="infraImg" title="Controle de Processos" />
               <a class="align-self-center text-white pl-1"  href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=procedimento_controlar&reset=1'.$strAncora).'" title="Controle de Processos" tabindex="' . $this->getProxTabBarraSistema() . '" >
                Controle de Processos
               </a>
            </span>
          </div >';
      }

      if (SessaoSEI::getInstance()->verificarPermissao('painel_controle_visualizar')) {
        $strAcoesIcones .= '
          <div class="nav-item d-flex infraAcaoBarraSistema">
            <a class="align-self-center  d-none d-md-block" id="lnkPainelControle" href="#" onclick="window.location.href=\''.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=painel_controle_visualizar').'\'" title="Painel de Controle" tabindex="'.$this->getProxTabBarraSistema().'">
              <img src="svg/painel_controle_barra.svg?'.$this->getNumVersao().'" class="infraImg" title="Painel de Controle" />
            </a>
            
            <span title="Painel de Controle"  class=" nav-link d-flex d-md-none" >
               <img src="svg/painel_controle_barra.svg?'.$this->getNumVersao().'" class="infraImg" title="Painel de Controle" />
               <a class="align-self-center text-white pl-1"  href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=painel_controle_visualizar').'" title="Painel de Controle" tabindex="' . $this->getProxTabBarraSistema() . '" >Painel de Controle</a>
            </span>
          </div >';
      }

      if (SessaoSEI::getInstance()->verificarPermissao('novidade_mostrar')) {
        $strAcoesIcones .= '
          <div class="nav-item d-flex infraAcaoBarraSistema">
            
            <a class="align-self-center  d-none d-md-block"  target="_blank" href="'.SessaoSEI::getInstance()->assinarLink('controlador.php?acao=novidade_mostrar&mostrar_todas=1').'" title="Novidades" tabindex="' . $this->getProxTabBarraSistema() . '">
              <img src="svg/novidades.svg?'.$this->getNumVersao().'" class="infraImg" title="Novidades" />
            </a>
            
            <span title="Novidades"  class=" nav-link   d-flex d-md-none" >
               <img src="svg/novidades.svg?'.$this->getNumVersao().'" class="infraImg" title="Novidades" />
               <a class="align-self-center text-white pl-1"  target="_blank" href="'.SessaoSEI::getInstance()->assinarLink("controlador.php?acao=novidade_mostrar&mostrar_todas=1").'" title="Novidades" tabindex="' . $this->getProxTabBarraSistema() . '">
                Novidades
               </a>
            </span>
         </div >';
      }

      $strAcoesIcones .= $this->montarLinkAcessibilidade();
      $strAcoesIcones .= $this->montarLinkConfiguracao();
      $strAcoesIcones .= $this->montarLinkUsuario();
      $strAcoesIcones .= parent::montarLinkSair(SessaoSEI::getInstance()->assinarLink('controlador.php?acao=sair'));
      $arrStrAcoes[] = $strAcoesIcones;
    }

    return $arrStrAcoes;
  }


  public function getObjInfraSessao()
  {
    return SessaoSEI::getInstance();
  }

  public function getObjInfraLog()
  {
    return LogSEI::getInstance();
    //return null;
  }

  public function setBolArvore($bolArvore)
  {
    $this->bolArvore = $bolArvore;
    if ($this->bolArvore) {
      $this->setTipoPagina(InfraPagina::$TIPO_PAGINA_SIMPLES);
    }
  }

  public function isBolArvore()
  {
    return $this->bolArvore;
  }

  public function abrirHead($strAtributos = '')
  {
    parent::abrirHead($strAtributos);
    SeiINT::montarHeaderFavicon('favicon');
  }
  public function abrirStyle($strAtributos = '') {
    parent::abrirStyle($strAtributos);
  }

  public function montarLinkMenu()
  {
    return '';
  }

  public function getBolMontarIconeMenu(){
    return false;
  }

  public function montarBotaoVoltarExcecao()
  {
    if ($this->isBolArvore()) {
      return '';
    } else {
      return parent::montarBotaoVoltarExcecao();
    }
  }

  public function montarBotaoFecharExcecao()
  {
    if ($this->isBolArvore()) {
      return '';
    } else {
      return parent::montarBotaoFecharExcecao();
    }
  }

  public function montarBarraComandosSuperior($arrComandos) {
    array_unshift($arrComandos, '<a id="ancVoltarArvoreSuperior" href="javascript:seiVoltarArvoreProcesso()" class="btn" style="display:none;" title="Voltar para a �rvore do Processo" tabindex="'.InfraPagina::$TAB_INI_BARRA_COMANDOS_SUPERIOR.'">
          <img src="'.$this->getDiretorioSvgGlobal() .'/voltar.svg?'.$this->getNumVersao().'">
        </a>');

    parent::montarBarraComandosSuperior($arrComandos);
  }

  public function montarBarraComandosInferior($arrComandos, $bolForcarMontagem = false) {
    array_unshift($arrComandos, '<a id="ancVoltarArvoreInferior" href="javascript:seiVoltarArvoreProcesso()" class="btn" style="display:none;" title="Voltar para a �rvore do Processo" tabindex="'.InfraPagina::$TAB_INI_BARRA_COMANDOS_SUPERIOR.'">
          <img src="'.$this->getDiretorioSvgGlobal() .'/voltar.svg?'.$this->getNumVersao().'">
        </a>');

    parent::montarBarraComandosInferior($arrComandos, $bolForcarMontagem);
  }

  public function getArrStrAcoesSistemaMovel(){
    $arrStrAcoes = array();
    $arrStrAcoes[] = $this->montarLinkMenuTexto(true);
    $arrStrAcoes[] = $this->montarSelectUnidades(true);
    return $arrStrAcoes;
  }

  public function montarJavaScript(){
    parent::montarJavaScript();
    echo '<script type="text/javascript" charset="iso-8859-1" src="js/sei.js?' . $this->getNumVersao() . '"></script>'."\n";
  }

  public function obterTiposMensagemExibicao()
  {
    return self::$TIPO_MSG_AVISO | self::$TIPO_MSG_ERRO;
  }

   public function getNumVersao(){
     return str_replace(' ','-',SEI_VERSAO . '-'.parent::getNumVersao());
   }

   public function getNumVersaoCache(){
     return CACHE_VERSAO;
   }

  public function adicionarJQuery(){
    return true;
  }

  public function setBolD3($bolD3){
    $this->bolD3 = $bolD3;
  }

  public function adicionarD3(){
    return $this->bolD3;
  }

  public function setBolAcoesSistema($bolAcoesSistema){
    $this->bolAcoesSistema = $bolAcoesSistema;
  }

  public function getStrSiglaOrgao(){
    return  $this->getObjInfraSessao()->getStrSiglaOrgaoUnidadeAtual() ;
  }

  public function getStrTextoBarraSuperior(){
    $strOrgaoTopo = ConfiguracaoSEI::getInstance()->getValor('PaginaSEI','OrgaoTopoJanela',false,'S');
    if ($strOrgaoTopo=='S') {
      return $this->getObjInfraSessao()->getStrDescricaoOrgaoSistema();
    }else if ($strOrgaoTopo=='U') {
      return $this->getObjInfraSessao()->getStrDescricaoOrgaoUsuario();
    }
    return null;
  }

  public function permitirXHTML(){
    return false;
  }

  public static function montarTitleTooltip($strTexto, $strTitulo = '', $strRotuloAria = '', $bolInverterTituloAria = false, $bolSobrescreverAria = false){

    $ret = '';

    if ($bolSobrescreverAria && $strRotuloAria!=''){

      $ret = 'aria-label="'.self::tratarHTML($strRotuloAria).'"';

    }else {

      if ($strRotuloAria != '') {
        $strRotuloAria = self::tratarHTML($strRotuloAria).' / ';
      }

      if ($strTitulo != '' && $strTexto != '') {
        if ($bolInverterTituloAria) {
          $ret = 'aria-label="'.$strRotuloAria.str_replace("\n", '&#13;', self::tratarHTML($strTexto)).' / '.self::tratarHTML($strTitulo).'" ';
        } else {
          $ret = 'aria-label="'.$strRotuloAria.self::tratarHTML($strTitulo).' / '.str_replace("\n", '&#13;', self::tratarHTML($strTexto)).'" ';
        }

      } else if ($strTitulo != '') {
        $ret = 'aria-label="'.$strRotuloAria.self::tratarHTML($strTitulo).'" ';
      } else if ($strTexto != '') {
        $ret = 'aria-label="'.$strRotuloAria.str_replace("\n", '&#13;', self::tratarHTML($strTexto)).'" ';
      }
    }

    if ($strTitulo != '') {
      $ret .= 'onmouseover="return infraTooltipMostrar(\''.self::tratarHTML(self::formatarParametrosJavaScript($strTexto)).'\',\''.self::tratarHTML(self::formatarParametrosJavaScript($strTitulo)).'\');"';
    } else {
      $ret .= 'onmouseover="return infraTooltipMostrar(\''.self::tratarHTML(self::formatarParametrosJavaScript($strTexto)).'\');"';
    }

    $ret .= ' onmouseout="return infraTooltipOcultar();"';

    $ret = str_replace('&amp;lt;hr&amp;gt;','<hr>', $ret);

    return $ret;
  }

  public static function getParametroRandom(){
    return 'seiRandom='.uniqid();
  }

  public function obterTipoJanelaLupas(){
    return self::$INFRA_JANELA_MODAL;
  }

  public function obterTipoJanelaBarraProgresso(){
    return self::$INFRA_JANELA_MODAL;
  }

  public function getArrStrAcessibilidade(){
    $arr = array();

    $arr['Acesso R�pido'] = array(
      'ALT + F2' => 'Controle de Processos',
      'ALT + F3' => 'Painel de Controle',
      'ALT + F10' => 'Pesquisa R�pida'
    );

    $arr['Controle de Processos'] = array(
      'ALT + R' => 'posiciona na tabela de processos recebidos',
      'ALT + G' => 'posiciona na tabela de processos gerados'
    );

    $arr['�rvore de Processo'] = array(
      'CTRL + ALT + R' => 'posiciona no item raiz da �rvore que representa o n�mero do processo',
      'CTRL + ALT + S' => 'posiciona no item de protocolo selecionado atualmente na �rvore',
      'CTRL + ALT + F' => 'posiciona na barra de funcionalidades associadas com o protocolo selecionado (usar TAB para navegar entre as funcionalidades dispon�veis)',
      'CTRL + ALT + V' => 'posiciona na �rea de visualiza��o de conte�do associada com protocolo selecionado ou funcionalidade escolhida',
      'CTRL + ALT + U' => 'posiciona no �ltimo item de protocolo da �rvore',
      'ALT + Seta acima' => 'seleciona o item anterior (pasta ou protocolo)',
      'ALT + Seta abaixo' => 'seleciona o pr�ximo item (pasta ou protocolo)',
      'TAB' => 'navega entre todos os itens da �rvore (pastas, protocolos e sinaliza��es)'
    );

    $arr['Editor'] = array(
      'CTRL + ALT + S' => 'Salvar',
      'CTRL + SHIFT + A' => 'Assinar',
      'CTRL + SHIFT + L' => 'Inserir um link para processo ou documento do SEI',
      'CTRL + SHIFT + X' => 'Inserir o conte�do de um texto padr�o (AutoTexto)',
      'CTRL + B' => 'Negrito',
      'CTRL + I' => 'It�lico',
      'CTRL + U' => 'Sublinhado',
      'CTRL + X' => 'Recortar',
      'CTRL + C' => 'Copiar',
      'CTRL + V' => 'Colar',
      'CTRL + SHIFT + V' => 'Colar como texto sem formata��o',
      'CTRL + Z' => 'Desfazer',
      'CTRL + Y' => 'Refazer',
      'ALT + 0' => 'Exibe instru��es de acessibilidade do editor'
    );

    return $arr;
  }
}
?>