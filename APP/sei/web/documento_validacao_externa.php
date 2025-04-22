<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 23/04/2012 - criado por bcu
 */


try {
  require_once dirname(__FILE__).'/SEI.php';

  session_start();

  SeiINT::definirIdioma("externo",$arrIdiomas,$locale);
  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  if (ConfiguracaoSEI::getInstance()->getValor('PaginaSEI','ValidacaoDocumentos',false,true)!==true){
    die (SeiINT::$MSG_PAGINA_DESABILITADA);
  }

  SessaoSEIExterna::getInstance()->validarLink();

  PaginaSEIExterna::getInstance()->setTipoPagina(PaginaSEIExterna::$TIPO_PAGINA_SEM_MENU);  

  $arrComandos = array();
  
  $objDocumentoDTO = new DocumentoDTO();

  $strLink = '';
  $strResultado = '';
  
  switch($_GET['acao']){

    case 'documento_conferir':

      CaptchaSEI::getInstance()->configurarCaptcha('Valida��o de Documentos');

      $strTitulo = _('Confer�ncia de Autenticidade de Documentos');

      $_POST['txtCodigoVerificador'] = trim($_POST['txtCodigoVerificador']);
      $_POST['txtCrc'] = trim($_POST['txtCrc']);

      if ($_POST['txtCodigoVerificador'] == '' && $_POST['txtCrc'] == ''){        
        $_POST['txtCodigoVerificador'] = $_GET['cv'];
        $_POST['txtCrc'] = $_GET['crc'];
      }      
      $objDocumentoDTO->setStrCodigoVerificador($_POST['txtCodigoVerificador']);
      $objDocumentoDTO->setStrCrcAssinatura($_POST['txtCrc']);
      
      if (isset($_POST['hdnInfraCaptcha']) && $_POST['hdnInfraCaptcha']=='1') {
        try{          
          if (!CaptchaSEI::getInstance()->verificar()){
            PaginaSEIExterna::getInstance()->setStrMensagem(_('C�digo de confirma��o inv�lido.'));
          }else{         

            $objDocumentoRN = new DocumentoRN();
            $objDocumentoDTORet = $objDocumentoRN->obterDocumentoAutenticidade($objDocumentoDTO);

            if ($objDocumentoDTORet != null){

              $objDocumentoRN->bloquearConsultado($objDocumentoDTORet);

              //sinalizador de bloqueio deve entrar no calculo do hash
              $objDocumentoDTORet->setStrSinBloqueado('S');
              $strHashDownload = hash('SHA512',$objDocumentoDTORet->__toString());

              $arrObjAssinaturaDTO = $objDocumentoDTORet->getArrObjAssinaturaDTO();

              $numRegistros = InfraArray::contar($arrObjAssinaturaDTO);

              $strResultado = '';

              if ($numRegistros == 0) {
                $strLink = '<span id="spnResultado">'._('Documento n�o possui assinatura.').'</span>';
              }else{
                $strLink = '';
                $strLink .= '<span id="spnResultado">'._('Clique').' <a href="controlador_externo.php?acao='.$_GET['acao'].'&codigo_verificador='.$_POST['txtCodigoVerificador'].'&codigo_crc='.$_POST['txtCrc'].'&hash_download='.$strHashDownload.'&visualizacao=1&id_orgao_acesso_externo='.$_GET['id_orgao_acesso_externo'].'" target="_blank" class="ancoraPadraoAzul">'._('aqui').'</a> ';

                if ($objDocumentoDTORet->getStrStaProtocoloProtocolo()==ProtocoloRN::$TP_DOCUMENTO_GERADO){
                  $strLink .= _('para visualizar o documento.');
                }else{
                  $strLink .= _('para download do documento.');
                }

                $strLink .= '</span><br /><br />';

                $numAssinaturasDigitais = 0;
                foreach($arrObjAssinaturaDTO as $objAssinaturaDTO) {
                  if ($objAssinaturaDTO->getStrStaDocumentoDocumento() != DocumentoRN::$TD_EDITOR_EDOC && $objAssinaturaDTO->getStrStaFormaAutenticacao() == AssinaturaRN::$TA_CERTIFICADO_DIGITAL) {
                    $numAssinaturasDigitais++;
                  }
                }

                if ($numAssinaturasDigitais && $objDocumentoDTORet->getStrStaProtocoloProtocolo()==ProtocoloRN::$TP_DOCUMENTO_GERADO){
                  $strLink .= '<span id="spnResultado">'._('Para valida��o da assinatura digital fa�a download do conte�do clicando ').' <a href="controlador_externo.php?acao='.$_GET['acao'].'&codigo_verificador='.$_POST['txtCodigoVerificador'].'&codigo_crc='.$_POST['txtCrc'].'&hash_download='.$strHashDownload.'&original=1&id_orgao_acesso_externo='.$_GET['id_orgao_acesso_externo'].'" target="_blank" class="ancoraPadraoAzul">'._('aqui').'</a>.</span>';
                }

                $strResultado .= '<table width="99%" class="infraTable" summary="'._('Tabela de Assinaturas').'.">' . "\n";
                $strResultado .= '<caption class="infraCaption">' . _('Lista de Assinaturas'). ' ('. $numRegistros. ' '.ngettext('registro','registros',$numRegistros) . '):</caption>';
                $strResultado .= '<tr>';
                $strResultado .= '<th class="infraTh" width="">'._('Assinante').'</th>' . "\n";
                $strResultado .= '<th class="infraTh" width="">'._('Cargo/Fun��o').'</th>' . "\n";
                $strResultado .= '<th class="infraTh" width="">'._('Data/Hora').'</th>' . "\n";
                $strResultado .= '<th class="infraTh" width="">'._('Tipo').'</th>' . "\n";

                if ($objDocumentoDTORet->getStrStaDocumento()!=DocumentoRN::$TD_EDITOR_EDOC && $numAssinaturasDigitais) {
                  $strResultado .= '<th class="infraTh" width="10%">PKCS #7</th>' . "\n";
                }

                $strResultado .= '</tr>' . "\n";
                $strCssTr = '';

                $dthFormatBR=new IntlDateFormatter('pt_BR',null,null,null,null,'dd/MM/yyyy HH:mm:ss');

                $tipoHora=($locale=='pt_BR'?IntlDateFormatter::MEDIUM:IntlDateFormatter::LONG);

                $dthFormatIntl = datefmt_create( $locale ,IntlDateFormatter::LONG, $tipoHora, 'America/Sao_Paulo', IntlDateFormatter::GREGORIAN  );

                foreach ($arrObjAssinaturaDTO as $objAssinaturaDTO) {

                  $strCssTr = ($strCssTr == '<tr class="infraTrClara">') ? '<tr class="infraTrEscura">' : '<tr class="infraTrClara">';
                  $strResultado .= $strCssTr;

                  $strResultado .= '<td align="center">' . $objAssinaturaDTO->getStrNome() . '</td>';
                  $strResultado .= '<td align="center">' . $objAssinaturaDTO->getStrTratamento() . '</td>';
                  $strData=$dthFormatIntl->format($dthFormatBR->parse($objAssinaturaDTO->getDthAberturaAtividade()));
                  $strData=preg_replace('/\xe2\x88\x92/','-',$strData);
                  $strResultado .= '<td align="center">' . utf8_decode($strData) . '</td>';
                  $strResultado .= '<td align="center">' . ($objAssinaturaDTO->getStrStaFormaAutenticacao() == AssinaturaRN::$TA_CERTIFICADO_DIGITAL?_('Certificado Digital'):_('Login/Senha')) . '</td>';
                  if ($objDocumentoDTORet->getStrStaDocumento()!=DocumentoRN::$TD_EDITOR_EDOC && $numAssinaturasDigitais) {
                    $strResultado .= '<td align="center">';
                    if ($objAssinaturaDTO->getStrStaFormaAutenticacao() == AssinaturaRN::$TA_CERTIFICADO_DIGITAL) {
                      $strResultado .= '<a href="' . 'controlador_externo.php?acao=' . $_GET['acao'] . '&codigo_verificador=' . $_POST['txtCodigoVerificador'] . '&codigo_crc=' . $_POST['txtCrc'] . '&id_assinatura=' . $objAssinaturaDTO->getNumIdAssinatura() . '&hash_download=' . $strHashDownload . '&id_orgao_acesso_externo=' . $_GET['id_orgao_acesso_externo'] . '" target="_blank"><img src="'.PaginaSEIExterna::getInstance()->getIconeDownload().'" title="'._('Download do arquivo PKCS #7 para valida��o da assinatura digital').'" alt="'._('Download do arquivo PKCS #7 para valida��o da assinatura digital').'" class="infraImg" /></a>&nbsp;';
                    }
                    $strResultado .= '</td>' . "\n";
                  }
                  $strResultado .= '</tr>' . "\n";
                }
                $strResultado .= '</table>';
              }
            }
          }
        }catch(Exception $e){
          PaginaSEIExterna::getInstance()->processarExcecao($e);
        }
      }

      if (isset($_GET['hash_download'])){
        
        $objDocumentoDTODownload = new DocumentoDTO();
        $objDocumentoDTODownload->setStrCodigoVerificador($_GET['codigo_verificador']);
        $objDocumentoDTODownload->setStrCrcAssinatura($_GET['codigo_crc']);
      
        $objDocumentoRN = new DocumentoRN();
        $objDocumentoDTODownload = $objDocumentoRN->obterDocumentoAutenticidade($objDocumentoDTODownload);
      
        if ($objDocumentoDTODownload==null){
          PaginaSEIExterna::getInstance()->setStrMensagem(_('Documento n�o encontrado.'));
        }else{
          if (hash('SHA512',$objDocumentoDTODownload->__toString())!=$_GET['hash_download']){
            PaginaSEIExterna::getInstance()->setStrMensagem(_('Link para download inv�lido.'));
          }else{

            if (isset($_GET['id_assinatura'])){

              $arrObjAssinaturaDTO = $objDocumentoDTODownload->getArrObjAssinaturaDTO();
              foreach($arrObjAssinaturaDTO as $objAssinaturaDTO){
                if ($objAssinaturaDTO->getNumIdAssinatura()==$_GET['id_assinatura']){

                  InfraPagina::montarHeaderDownload($objDocumentoDTODownload->getStrProtocoloDocumentoFormatado().'_'.InfraString::transformarCaixaAlta($objAssinaturaDTO->getStrNome()).'.p7s','attachment');
                  echo base64_decode($objAssinaturaDTO->getStrP7sBase64());
                  die;

                }
              }

              die(_('Assinatura n�o encontrada.'));

            }else{
              if ($objDocumentoDTODownload->getStrStaProtocoloProtocolo()==ProtocoloRN::$TP_DOCUMENTO_GERADO){

                $strNomeDownload = $objDocumentoDTODownload->getStrProtocoloDocumentoFormatado() . '_' . $objDocumentoDTODownload->getStrNomeSerie();
                if (!InfraString::isBolVazia($objDocumentoDTODownload->getStrNumero())) {
                  $strNomeDownload .= '_' . $objDocumentoDTODownload->getStrNumero();
                }

                if (isset($_GET['original'])) {
                  InfraPagina::montarHeaderDownload($strNomeDownload . '.html', 'attachment');
                  die($objDocumentoDTODownload->getStrConteudoAssinatura());
                }else{
                  InfraPagina::montarHeaderDownload($strNomeDownload . '.html', 'inline');
                  die($objDocumentoDTODownload->getStrConteudo());
                }

              }else{
                $objAnexoDTO = new AnexoDTO();
                $objAnexoDTO->retNumIdAnexo();
                $objAnexoDTO->retStrNome();
                $objAnexoDTO->retStrHash();
                $objAnexoDTO->retNumIdAnexo();
                $objAnexoDTO->setDblIdProtocolo($objDocumentoDTODownload->getDblIdDocumento());
                $objAnexoDTO->retDblIdProtocolo();
                $objAnexoDTO->retDthInclusao();

                $objAnexoRN = new AnexoRN();
                $arrObjAnexoDTO = $objAnexoRN->listarRN0218($objAnexoDTO);

                if (count($arrObjAnexoDTO)!=1){
                  PaginaSEIExterna::getInstance()->setStrMensagem(_('Documento n�o possui conte�do.'));
                }else {
                  SeiINT::download($arrObjAnexoDTO[0], null, null, $objDocumentoDTODownload->getStrProtocoloDocumentoFormatado() . '_'.$arrObjAnexoDTO[0]->getStrNome(), 'attachment', $objDocumentoDTODownload->getStrProtocoloDocumentoFormatado(), $objDocumentoDTODownload->getDblIdDocumento(), true);
                  die;
                }
              }
            }            
          }
        }
      }
       
      break;

    default:
      throw new InfraException(sprintf(_("A��o '%s' n�o reconhecida."),$_GET['acao']));
  }

}catch(Exception $e){
  PaginaSEIExterna::getInstance()->processarExcecao($e);
}


$strDivIdioma='<div id="divIdioma">'."\n";
$strLinkConferencia='controlador_externo.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'].'&id_orgao_acesso_externo='.$_GET['id_orgao_acesso_externo'];

foreach ($arrIdiomas as $key=>$value) {
  $strDivIdioma.='<a href="'.$strLinkConferencia.'&lang='.$key.'" title="'.$value[0].'" style="text-decoration:none;padding:1px;'.($locale==$key?'border:1px solid black;font-weight:bold;':'').'">'.$value[1].'</a>&nbsp;'."\n";
}
$strDivIdioma.="</div>\n";

PaginaSEIExterna::getInstance()->montarDocType();
PaginaSEIExterna::getInstance()->abrirHtml();
PaginaSEIExterna::getInstance()->abrirHead();
PaginaSEIExterna::getInstance()->montarMeta();
PaginaSEIExterna::getInstance()->montarTitle(PaginaSEIExterna::getInstance()->getStrNomeSistema().' - '.$strTitulo);
PaginaSEIExterna::getInstance()->montarStyle();
CaptchaSEI::getInstance()->montarStyle();
PaginaSEIExterna::getInstance()->abrirStyle();
?>

#frmDocumentoValidar {max-width: 1200px;}

#divInfraCaptcha {margin:.5em 0;}
#sbmPesquisar {position:absolute;left:0;top:25%;}

#spnResultado {position:relative;font-size:1.4em;padding: 0 1em; border:0px solid #c0c0c0;}
a.ancoraPadraoAzul {padding:0;font-size:1em;}

#divIdioma {float:right; margin-right:5px; margin-top:5px }
#divIdioma img {padding:2px; width:20px; height:14px;}
.idiomaEscolhido { border: 1px solid gray; border-width:1px !important; }

#lblInfraCaptchaAjuda{
  display:none;
}

<?
PaginaSEIExterna::getInstance()->fecharStyle();
PaginaSEIExterna::getInstance()->montarJavaScript();
CaptchaSEI::getInstance()->montarJavascript();
PaginaSEIExterna::getInstance()->abrirJavaScript();
?>

function inicializar(){
  document.getElementById('txtCodigoVerificador').focus();
}

function OnSubmitForm(){ 
 return validarForm();
}

function validarForm() { 
  if (infraTrim(document.getElementById('txtCodigoVerificador').value)=='') {
    alert('<?=_('Informe o C�digo Verificador.');?>');
    document.getElementById('txtCodigoVerificador').focus(); 
    return false; 
   }
  if (infraTrim(document.getElementById('txtCrc').value)=='') {
    alert('<?=_('Informe o C�digo CRC.');?>');
    document.getElementById('txtCrc').focus();
    return false; 
   }

  <? CaptchaSEI::getInstance()->validarOnSubmit('frmDocumentoValidar'); ?>
}

<?
PaginaSEIExterna::getInstance()->fecharJavaScript();
PaginaSEIExterna::getInstance()->fecharHead();
PaginaSEIExterna::getInstance()->abrirBody($strTitulo,'onload="inicializar();"');

echo $strDivIdioma;
?>
<form id="frmDocumentoValidar" method="post" onsubmit="return OnSubmitForm();" action="<?=SessaoSEIExterna::getInstance()->assinarLink('controlador_externo.php?acao='.$_GET['acao'].'&acao_origem='.$_GET['acao'].'&lang='.$locale)?>">
	<?
  PaginaSEIExterna::getInstance()->montarBarraComandosSuperior($arrComandos);
  ?>

  <div id="divCodigoVerificador" class="infraAreaDados d-flex flex-column flex-md-row mb-1">
    <div class="col-12 col-md-2 mx-0 px-0 pt-1">
      <label id="lblCodigoVerificador" for="txtCodigoVerificador" class="infraLabelObrigatorio"><?=_('C�digo Verificador');?>:</label>
    </div>
    <div class="col-12 col-md-9 pl-0 pl-md-1 pt-1 media">
      <input type="text" id="txtCodigoVerificador" name="txtCodigoVerificador" class="infraText w-50 w-md-25" onkeypress="return infraMascaraNumero(this,event,<?=DIGITOS_DOCUMENTO?>,'vV');" maxlength="15" value="<?=PaginaSEIExterna::tratarHTML($objDocumentoDTO->getStrCodigoVerificador())?>" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    </div>
  </div>

  <div id="divCrc" class="infraAreaDados d-flex flex-column flex-md-row mb-1">
    <div class="col-12 col-md-2 mx-0 px-0 pt-1">
      <label id="lblCrc" for="txtCrc" class="infraLabelObrigatorio"><?=_('C�digo CRC');?>:</label>
    </div>
    <div class="col-12 col-md-9 pl-0 pl-md-1 pt-1 media">
      <input type="text" id="txtCrc" name="txtCrc" class="infraText w-50 w-md-25" value="<?=PaginaSEIExterna::tratarHTML($objDocumentoDTO->getStrCrcAssinatura())?>" maxlength="8" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>" />
    </div>
  </div>
  <br>
  <?
  CaptchaSEI::getInstance()->montarHtml(PaginaSEIExterna::getInstance()->getProxTabDados());
  PaginaSEIExterna::getInstance()->abrirAreaDados('5em');
	?>
	<button type="submit" accesskey="P" id="sbmPesquisar" name="sbmPesquisar" value="Pesquisar" class="infraButton" tabindex="<?=PaginaSEIExterna::getInstance()->getProxTabDados()?>"><?=_('Pesquisar');?></button>
  <?
  PaginaSEIExterna::getInstance()->fecharAreaDados();
  echo $strLink;
  if ($numRegistros) {
    PaginaSEIExterna::getInstance()->montarAreaTabela($strResultado, $numRegistros);
  }
	?>
  <br>
  <br>
</form>
<?
PaginaSEIExterna::getInstance()->montarAreaDebug();
PaginaSEIExterna::getInstance()->fecharBody();
PaginaSEIExterna::getInstance()->fecharHtml();
?>