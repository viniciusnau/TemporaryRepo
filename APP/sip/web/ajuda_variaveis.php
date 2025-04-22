<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 05/07/2018 - criado por mga
 *
 */

try {
  require_once dirname(__FILE__) . '/Sip.php';

  session_start();

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSip::getInstance()->validarLink();

  PaginaSip::getInstance()->setTipoPagina(InfraPagina::$TIPO_PAGINA_SIMPLES);

  SessaoSip::getInstance()->validarPermissao($_GET['acao']);

  $arrVariaveis = array();

  switch ($_GET['acao']) {
    case 'ajuda_variaveis_email_sistema':

      $strTitulo = 'Vari�veis Dispon�veis';

      switch ($_GET['campo']) {
        case 'R':
          $strTitulo .= ' para Remetente';
          break;

        case 'D':
          $strTitulo .= ' para Destinat�rio';
          break;

        case 'A':
          $strTitulo .= ' para Assunto';
          break;

        case 'C':
          $strTitulo .= ' para Conte�do';
          break;
      }

      switch ($_GET['tipo']) {
        case EmailSistemaRN::$ES_ATIVACAO_2_FATORES:
        case EmailSistemaRN::$ES_DESATIVACAO_2_FATORES:
        case EmailSistemaRN::$ES_ALERTA_SEGURANCA:
        case EmailSistemaRN::$ES_AVISO_BLOQUEIO:

          switch ($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@', 'Sigla do sistema');
              $arrVariaveis[] = array('@sigla_orgao_sistema@', 'Sigla do �rg�o do sistema');
              $arrVariaveis[] = array(
                '@email_sistema@', 'Endere�o eletr�nico do sistema configurado no par�metro SIP_EMAIL_SISTEMA da tabela de par�metros'
              );
              break;

            case 'D':
              $arrVariaveis[] = array('@email_usuario@', 'Endere�o eletr�nico do usu�rio');
              if ($_GET['tipo'] == EmailSistemaRN::$ES_ATIVACAO_2_FATORES || $_GET['tipo'] == EmailSistemaRN::$ES_DESATIVACAO_2_FATORES) {
                $arrVariaveis[] = array('@nome_usuario@', 'Nome do usu�rio');
              }
              break;

            case 'A':
              $arrVariaveis[] = array('@sigla_sistema@', 'Sigla do sistema');
              $arrVariaveis[] = array('@sigla_orgao_sistema@', 'Sigla do �rg�o do sistema');
              $arrVariaveis[] = array('@sigla_usuario@', 'Sigla do usu�rio');
              $arrVariaveis[] = array('@nome_usuario@', 'Nome do usu�rio');
              break;

            case 'C':
              $arrVariaveis[] = array('@sigla_sistema@', 'Sigla do sistema');
              $arrVariaveis[] = array('@sigla_orgao_sistema@', 'Sigla do �rg�o do sistema');
              $arrVariaveis[] = array('@sigla_usuario@', 'Sigla do usu�rio');
              $arrVariaveis[] = array('@nome_usuario@', 'Nome do usu�rio');
              $arrVariaveis[] = array('@data@', 'Data do acesso no formato dd/mm/aaaa');
              $arrVariaveis[] = array('@hora@', 'Hora do acesso no formato hh:mm');

              if ($_GET['tipo'] == EmailSistemaRN::$ES_ATIVACAO_2_FATORES) {
                $arrVariaveis[] = array('@endereco_ativacao@', 'Endere�o para ativa��o do mecanismo');
              } else {
                if ($_GET['tipo'] == EmailSistemaRN::$ES_DESATIVACAO_2_FATORES) {
                  $arrVariaveis[] = array(
                    '@endereco_desativacao@', 'Endere�o para desativa��o do mecanismo'
                  );
                } else {
                  if ($_GET['tipo'] == EmailSistemaRN::$ES_ALERTA_SEGURANCA) {
                    $arrVariaveis[] = array(
                      '@endereco_bloqueio@', 'Endere�o para bloqueio do usu�rio'
                    );
                  }
                }
              }
              break;
          }
          break;
      }
      break;

    default:
      throw new InfraException("A��o '" . $_GET['acao'] . "' n�o reconhecida.");
  }

  $numRegistros = count($arrVariaveis);

  $strResultado = '';
  $strResultado .= '<table width="99%" class="infraTable" summary="Tabela de Vari�veis Dispon�veis">' . "\n"; //80
  $strResultado .= '<caption class="infraCaption">' . PaginaSip::getInstance()->gerarCaptionTabela('Vari�veis Dispon�veis', $numRegistros) . '</caption>';
  $strResultado .= '<tr>';
  $strResultado .= '<th class="infraTh" width="30%">Vari�vel</th>' . "\n";
  $strResultado .= '<th class="infraTh">Descri��o</th>' . "\n";
  $strResultado .= '</tr>' . "\n";
  $strCssTr = '';
  for ($i = 0; $i < $numRegistros; $i++) {
    $strCssTr = ($strCssTr == '<tr class="infraTrClara">') ? '<tr class="infraTrEscura">' : '<tr class="infraTrClara">';
    $strResultado .= $strCssTr;

    $strResultado .= '<td><span style="font-family: Courier New">' . PaginaSip::tratarHTML($arrVariaveis[$i][0]) . '</span></td>';
    $strResultado .= '<td>' . PaginaSip::tratarHTML($arrVariaveis[$i][1]) . '</td>';

    $strResultado .= '</tr>' . "\n";
  }
  $strResultado .= '</table>';
} catch (Exception $e) {
  PaginaSip::getInstance()->processarExcecao($e);
}

PaginaSip::getInstance()->montarDocType();
PaginaSip::getInstance()->abrirHtml();
PaginaSip::getInstance()->abrirHead();
PaginaSip::getInstance()->montarMeta();
PaginaSip::getInstance()->montarTitle(PaginaSip::getInstance()->getStrNomeSistema() . ' - ' . $strTitulo);
PaginaSip::getInstance()->montarStyle();
PaginaSip::getInstance()->montarJavaScript();
PaginaSip::getInstance()->fecharHead();
PaginaSip::getInstance()->abrirBody($strTitulo);
PaginaSip::getInstance()->montarAreaTabela($strResultado, $numRegistros, true);
PaginaSip::getInstance()->fecharBody();
PaginaSip::getInstance()->fecharHtml();
?>