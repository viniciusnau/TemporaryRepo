<?
/*
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 30/11/2006 - criado por mga
*
*
*/

try {
    require_once dirname(__FILE__).'/../Sip.php';

    session_start();

    //////////////////////////////////////////////////////////////////////////////
    //InfraDebug::getInstance()->setBolLigado(false);
    //InfraDebug::getInstance()->setBolDebugInfra(true);
    //InfraDebug::getInstance()->limpar();
    //////////////////////////////////////////////////////////////////////////////

    SessaoSip::getInstance(false);

    switch ($_GET['acao']) {
        case 'instrucoes_2fa':
            break;

        default:
            throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
    }

    $objSistemaDTO = LoginINT::obterSistema($_GET['sigla_sistema'], $_GET['sigla_orgao_sistema']);

    if ($objSistemaDTO->getStrLogo() != null) {
        $strLogo = '<div style="position:absolute; top:30px; left:100px;overflow:hidden;margin:auto;width:150px;height:150px;background-image: url(\'data:image/png;base64,'.$objSistemaDTO->getStrLogo(
            ).'\');background-position: center center;background-repeat: no-repeat;border-radius: 8px;"></div>';
    } else {
        $strLogo = '<div style="position:absolute;overflow:hidden;top:30px; left:0px;width:350px;text-align:center;"><h1>'.$objSistemaDTO->getStrSigla().'</h1></div>';;
    }
} catch (Exception $e) {
    PaginaSip::getInstance()->processarExcecao($e);
}

function montarImagemAjuda($strImagem, $strTitle, $strLogo = null, $strExtra = null)
{
    $ret = '';
    $ret .= '<p class="imagem">';
    $ret .= '<div style="position:relative;left:10%;"><img src="ajuda/'.$strImagem.'" title="'.$strTitle.'" />';

    if ($strLogo != null) {
        $ret .= $strLogo;
    }

    if ($strExtra != null) {
        $ret .= $strExtra;
    }

    $ret .= '</div>';
    $ret .= '</p>';
    return $ret;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Pragma" content="no-cache"/>
  <title>SIP - Autentica��o em 2 Fatores</title>
  <style type="text/css">
      <!--
      /*--><![CDATA[/
      ><!--*/

      .titulo1 {
          font-family: Verdana, Arial, Helvetica, Sans;
          font-size: 16px;
          font-weight: bold;
          color: #ffffff;
          background: #336699;
          position: relative;
          padding: 2pt;
          border-width: 0px;
      }

      .titulo2 {
          font-family: Verdana, Arial, Helvetica, Sans;
          font-size: 14px;
          font-weight: bold;
          color: #ffffff;
          background: #16609B;
          position: relative;
          padding: 6pt;
          border-width: 0px;
          border-radius: 4px;
      }

      .texto {
          font-family: Verdana, Arial, Helvetica, Sans;
          font-size: 14px;
          text-align: justify;
          text-indent: .6in;
          color: #000000;
          background: #FFFFFF;
          position: relative;
          padding: 5pt;
          border-width: 0px;
      }

      p.imagem {
          position: relative;
          left: 10%;
      }

      /*]]>*/
      -->
  </style>
</head>
<body>
<br/>

<p style='text-align:center;font-weight:bold;font-size:16pt;'>Autentica��o em 2 Fatores</p>

<blockquote>
  <blockquote>
    <p class="texto">
      A autentica��o em 2 fatores, ou 2FA, fornece seguran�a adicional, pois junta algo que voc� sabe (a sua senha) com
      algo que voc� possui (o seu smartphone). Somente com a combina��o dos dois ser� poss�vel efetuar o login. Ap�s
      validar a senha, ser� preciso informar um c�digo de 6 d�gitos, que ser� gerado pelo aplicativo no smartphone.
    </p>
  </blockquote>
</blockquote>

<blockquote>

  <div class="titulo2">1. Gerando um C�digo para Ativa��o</div>
  <blockquote>

    <p class="texto">
      Na tela de login do sistema, ap�s informar seu usu�rio e senha, clique no link "Autentica��o em dois fatores":
    </p>

      <?= montarImagemAjuda('2fa_login.png', 'Login', $strLogo) ?>

    <p class="texto">
      Clique em Prosseguir na tela de apresenta��o da autentica��o em dois fatores:
    </p>

      <?= montarImagemAjuda('2fa_prosseguir.png', 'Prosseguir', $strLogo) ?>

    <p class="texto">
      A mensagem abaixo ser� exibida e se voc� nunca fez este procedimento apenas ignore-a:
    </p>

      <?= montarImagemAjuda('2fa_remover_conta.png', 'Remover Conta') ?>

  </blockquote>

  <div class="titulo2">2. Instala��o do Aplicativo de Autentica��o</div>
  <blockquote>
    <p class="texto">
      Ser� gerado um c�digo QR como este:
    </p>

      <?= montarImagemAjuda('2fa_geracao.png', 'Gera��o do c�digo QR', $strLogo) ?>

    <p class="texto">
      Para l�-lo, instale em seu smartphone um aplicativo pr�prio para autentica��o em duas etapas, como o Google
      Authenticator, Microsoft Authenticator, FreeOTP, Authy, etc. Os exemplos abaixo usam o Google Authenticator.
      Acesse a Apple Store ou o Google Play para instalar.
    </p>

    <p class="imagem">
      <a target="_blank" href="https://www.apple.com/br/ios/app-store"><img src="ajuda/app_store.png" width="150"
                                                                            title="Apple Store"/></a>
      <a target="_blank" href="https://play.google.com/store/apps?hl=pt_BR"><img src="ajuda/google_play.jpg" width="150"
                                                                                 title="Google Play"/></a>
    </p>

  </blockquote>

  <div class="titulo2">3. Leitura do C�digo</div>
  <blockquote>

    <p class="texto">
      Abra o aplicativo Google Authenticator:
    </p>

    <p class="imagem">
      <img src="ajuda/google_authenticator_icone.png" title="Google Authenticator" width="100"/>
    </p>

    <p class="texto">
      Encontre a op��o para leitura de c�digo. Pode ser necess�rio permitir que o aplicativo tenha acesso a c�mera do
      smartphone:
    </p>

    <p class="imagem">
      <img src="ajuda/google_authenticator1.png" title="Google Authenticator"/>
      &nbsp;
      <img src="ajuda/google_authenticator2.png" title="Google Authenticator"/>
      &nbsp;
      <img src="ajuda/google_authenticator3.png" title="Google Authenticator"/>
    </p>

    <p class="texto">
      Aponte a c�mera para o c�digo QR que est� sendo exibido na tela e adicione a conta no aplicativo.
    </p>
  </blockquote>


  <div class="titulo2">4. Configura��o Manual do C�digo</div>
  <blockquote>

    <p class="texto">
      <b>Execute este passo apenas se voc� n�o consegue ler o c�digo QR.</b> Por exemplo, se estiver acessando esta
      p�gina pelo smartphone ou se a c�mera do seu celular n�o estiver funcionando. No aplicativo localize a op��o
      "Entrada manual" ou "Inserir chave de configura��o":
    </p>

    <p class="imagem">
      <img src="ajuda/google_authenticator1.png" title="Google Authenticator"/>
      &nbsp;
      <img src="ajuda/google_authenticator4.png" title="Google Authenticator"/>
    </p>

    <p class="texto">
      Clique sobre o c�digo alfanum�rico que est� sendo exibido logo abaixo do c�digo QR para copi�-lo. Em seguida,
      cole-o no aplicativo de autentica��o e clique em "Adicionar":
    </p>

      <?= montarImagemAjuda(
          '2fa_copiar_codigo.png',
          'Copiar Chave de Configura��o',
          $strLogo,
          '&nbsp;&nbsp;<img src="ajuda/google_authenticator5.png" title="Google Authenticator" />'
      ) ?>


  </blockquote>

  <div class="titulo2">5. Finaliza��o do Cadastro</div>
  <blockquote>
    <p class="texto">
      Informe um endere�o de e-mail que <b>n�o seja associado com a institui��o</b>. Por exemplo, pode ser do gmail,
      hotmail, yahoo, etc. � imprescind�vel que a senha de acesso ao e-mail seja diferente da senha de acesso ao
      sistema:
    </p>

      <?= montarImagemAjuda('2fa_email.png', 'Informar E-mail', $strLogo) ?>

    <p class="texto">
      Clique em "Enviar" para que um link de ativa��o seja enviado para o endere�o de e-mail fornecido. Somente ap�s
      receber o e-mail e clicar no link � que o mecanismo de autentica��o em 2 fatores estar� ativado.
    </p>
  </blockquote>

  <div class="titulo2">6. Login com a Autentica��o em 2 Fatores</div>
  <blockquote>
    <p class="texto">
      Se a autentica��o em 2 fatores estiver ativada, ent�o, ap�s informar o usu�rio e senha, ser� exibida outra tela
      solicitando o c�digo num�rico. Abra o aplicativo de autentica��o no seu smartphone e veja o c�digo gerado. Informe
      o valor no campo C�digo de Acesso e clique em Validar:
    </p>

      <?= montarImagemAjuda(
          '2fa_validacao.png',
          'Valida��o do C�digo QR',
          $strLogo,
          '<img src="ajuda/google_authenticator.png" title="Google Authenticator" height="300" style="margin-left:50px;"/>'
      ) ?>

    <!--
    <p class="imagem">
      <img src="google_authenticator.png" title="Google Authenticator" height="300" />
    </p>
    -->

    <p class="texto">
      De agora em diante, sempre que fizer login, ser� preciso consultar o seu smartphone, porque o c�digo muda a cada
      30 segundos. O sistema aceitar� qualquer um dos c�digos gerados nos �ltimos 90 segundos por isso � importante que
      o seu smartphone esteja com o hor�rio correto.
    </p>
  </blockquote>

  <div class="titulo2">Liberando Dispositivos</div>
  <blockquote>
    <p class="texto">
      Para dispositivos usados com frequ�ncia, pode ser conveniente liber�-los da valida��o a cada login. Para isso, na
      tela onde � solicitado o c�digo num�rico, marque a op��o "N�o usar 2FA neste dispositivo e navegador". Essa
      sinaliza��o precisar� ser realizada para cada navegador utilizado. O c�digo poder� ser solicitado novamente se for
      feita a limpeza dos cookies do navegador ou se a libera��o perder a validade de acordo com o per�odo estabelecido
      pela institui��o.
    </p>
  </blockquote>

  <div class="titulo2">Cancelando Dispositivos Liberados</div>
  <blockquote>
    <p class="texto">
      Para cancelar as libera��es, em todos os dispositivos, acesse o link "Autentica��o em 2 fatores" dispon�vel na
      tela inicial de login e clique no bot�o "Cancelar Dispositivos Liberados":
    </p>

      <?= montarImagemAjuda('2fa_cancelar_dispositivos.png', 'Cancelamento Dispositivos Liberados', $strLogo) ?>

  </blockquote>

  <div class="titulo2">Desativando a Autentica��o em 2 Fatores</div>
  <blockquote>
    <p class="texto">
      Se n�o conseguir validar o c�digo por algum motivo (perda do aparelho, defeito, roubo, erro no aplicativo, etc.),
      � poss�vel requisitar a desativa��o da autentica��o em 2 fatores na mesma tela onde � solicitado o c�digo
      num�rico, ou ent�o por meio do link "Autentica��o em 2 fatores" dispon�vel na tela inicial de login. Clique no
      bot�o "Desativar 2FA" para que um e-mail com o link de desativa��o seja enviado para o endere�o que foi fornecido
      no momento da leitura do c�digo QR. Somente ap�s receber o e-mail e clicar no link � que o mecanismo de
      autentica��o em 2 fatores ser� desativado.
    </p>
  </blockquote>


  <div class="titulo2">Solu��o de Problemas</div>
  <blockquote>
    <p class="texto">
      Caso esteja recebendo a mensagem "C�digo inv�lido." ou "C�digo n�o reconhecido.", � poss�vel que o hor�rio no seu
      smartphone esteja desatualizado.

      Primeiro verifique se o aparelho est� configurado para obter a hora automaticamente pela rede. Abaixo est�o
      exemplos de como fazer isso em diferentes sistemas.
    </p>
    <p class="imagem">
      <img src="ajuda/2fa_data_1.png" title="Ajuste Data" style="margin-left:50px;border:1px solid #d0d0d0;"/>
      <img src="ajuda/2fa_data_2.png" title="Ajuste Data" style="margin-left:50px;border:1px solid #d0d0d0;"/>
      <img src="ajuda/2fa_data_3.png" title="Ajuste Data" style="margin-left:50px;border:1px solid #d0d0d0;"/>
    </p>

    <p class="texto">
      Ap�s, apenas em dispositivos Android, tamb�m � necess�rio seguir os passos abaixo para sincronizar o hor�rio no
      Google Authenticator:
    </p>
    <p class="imagem">
      <img src="ajuda/2fa_hora_1.png" title="Ajuste Hora" style="margin-left:50px;border:1px solid #d0d0d0;"/>
      <img src="ajuda/2fa_hora_2.png" title="Ajuste Hora" style="margin-left:50px;border:1px solid #d0d0d0;"/>
      <img src="ajuda/2fa_hora_3.png" title="Ajuste Hora" style="margin-left:50px;border:1px solid #d0d0d0;"/>
    </p>

  </blockquote>


</blockquote>
</body>
</html>

