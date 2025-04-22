<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 29/03/2010 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.29.1
 *
 * Vers�o no CVS: $Id$
 */

try {
  require_once dirname(__FILE__).'/../SEI.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoPublicacoes::getInstance()->validarLink();

  SessaoPublicacoes::getInstance()->validarPermissao($_GET['acao']);

  PaginaPublicacoes::getInstance()->setTipoPagina(PaginaPublicacoes::$TIPO_PAGINA_SIMPLES);

  switch($_GET['acao']){

    case 'publicacao_ajuda':
      $strTitulo = '';
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $arrComandos = array();

}catch(Exception $e){
  PaginaPublicacoes::getInstance()->processarExcecao($e);
}

PaginaPublicacoes::getInstance()->montarDocType();
PaginaPublicacoes::getInstance()->abrirHtml();
PaginaPublicacoes::getInstance()->abrirHead();
PaginaPublicacoes::getInstance()->montarMeta();
PaginaPublicacoes::getInstance()->montarTitle(PaginaPublicacoes::getInstance()->getStrNomeSistema().' - Ajuda Pesquisa');
PaginaPublicacoes::getInstance()->montarStyle();
PaginaPublicacoes::getInstance()->montarJavaScript();
PaginaPublicacoes::getInstance()->fecharHead();
?>
<body id="bodyAjuda">
<div>
<blockquote>

  <br />

  <p style='text-align:center;font-weight:bold;font-size:16pt;'>Pesquisa de Publica��es</p>

  <div class="ajudaTexto">
    A pesquisa pode ser realizada por:
  </div>

  <div class="ajudaTitulo">1. Palavras, Siglas, Express�es ou N�meros</div>
  <blockquote>
    <div class="ajudaTexto">Busca ocorr�ncias de uma determinada palavra, sigla, express�o (deve ser informada entre aspas duplas) ou n�mero:</div>
    <div class="ajudaExemplo">prescri��o</div>
    <br>
    <div class="ajudaExemplo">certid�o INSS</div>
    <br>
    <div class="ajudaExemplo">declara��o "imposto de renda"</div>
    <br>
    <div class="ajudaExemplo">portaria 744</div>
    <br>
    <br>
  </blockquote>

  <div class="ajudaTitulo">2. Busca por parte de Palavras ou N�meros (*)</div>
  <blockquote>
    <div class="ajudaTexto">Procura registros que contenham parte da palavra ou n�mero:</div>
    <div class="ajudaExemplo">embarg* (retornar� registros com <strong>embarg</strong>o, <strong>embarg</strong>ou,<strong>embarg</strong>ante,...)</div>
    <br>
    <div class="ajudaExemplo">201.7* (retornar� registros contendo <strong>201.7</strong>98.988-00, <strong>201.7</strong>19,43, <strong>201.7</strong>1, ...)</div>
    <br>
  </blockquote>

  <div class="ajudaTitulo">3. Conector (E)</div>
  <blockquote>
    <div class="ajudaTexto">Pesquisa por registros que contenham todas as palavras e express�es:</div>
    <div class="ajudaExemplo">m�vel e licita��o</div>
    <br>
    <div class="ajudaExemplo">nomea��o e "cargo efetivo"</div>
    <br>

    <div class="ajudaTexto">Este conector ser� utilizado automaticamente caso nenhum outro seja informado.</div>
  </blockquote>

  <div class="ajudaTitulo">4. Conector (OU)</div>
  <blockquote>
    <div class="ajudaTexto">Pesquisa por registros que contenham pelo menos uma das palavras ou express�es:</div>
    <div class="ajudaExemplo">funcion�rio ou servidor</div>
    <br>
  </blockquote>

  <div class="ajudaTitulo">5. Conector (N�O)</div>
  <blockquote>
    <div class="ajudaTexto">Recupera registros que contenham a primeira, mas n�o a segunda palavra ou express�o, isto �, exclui os registros que contenham a palavra ou express�o seguinte ao conector (N�O):</div>
    <div class="ajudaExemplo">certid�o n�o INSS</div>
    <br>
  </blockquote>

</blockquote>
</div>
</body>
<?
PaginaPublicacoes::getInstance()->fecharHtml();
?>