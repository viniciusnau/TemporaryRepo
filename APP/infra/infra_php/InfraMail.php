<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 * 17/08/2007 - CRIADO POR cle@trf4.gov.br
 * @package infra_php
 */

require_once dirname(__FILE__) . '/mail/PHPMailer.php';
require_once dirname(__FILE__) . '/mail/SMTP.php';
require_once dirname(__FILE__) . '/mail/Exception.php';

class InfraMail
{
    /**
     * Constante usada para avaliar a configura��o do tipo de email
     * @access private
     * @name $TM_SEND_MAIL
     */
    public static $TM_SEND_MAIL = '1';

    /**
     * Constante usada para avaliar a configura��o do tipo de email
     * @access private
     * @name $TM_SMTP
     */
    public static $TM_SMTP = '2';

    private function __construct()
    {
    }

    /**
     * Envia email com endere�o do destinat�rio obtido por consulta na tabela infra_parametro.
     *
     * @param Obj $objInfraIBanco - Inst�ncia de alguma classe de BD espec�fico (ex. BancoCSRHSQLServer::getInstance()).
     * @param string $strNomeInfraParametro - Nome padronizado para busca na tabela infra_parametro (ex. 'mail_concurso_remocao')
     * @param string $strDe
     * @param string $strPara
     * @param string $strAssunto
     * @param string $varAnexo
     * @param string $strConteudo
     * @param string $strCopiaOculta
     * @return void
     */
    public static function enviarProtegido(
        $objInfraIBanco,
        $strNomeInfraParametro,
        $strDe,
        $strPara,
        $strAssunto,
        $strCorpo,
        $varAnexo = null,
        $strConteudo = "text/plain",
        $strCopiaOculta = null
    ) {
        $objInfraParametro = new InfraParametro($objInfraIBanco);
        $strEmailProtecao = $objInfraParametro->getValor($strNomeInfraParametro, false);
        if ($strEmailProtecao != '') {
            $strPara = $strEmailProtecao;
        }
        return self::enviar($strDe, $strPara, $strAssunto, $strCorpo, $varAnexo, $strConteudo, $strCopiaOculta);
    }

    /**
     * Envia email.
     *
     * @param string $strDe
     * @param string $strPara
     * @param string $strAssunto
     * @param string $strCorpo
     * @param string $varAnexo
     * @param string $strConteudo
     * @param string $strCopiaOculta
     * @return void
     */
    public static function enviar(
        $strDe,
        $strPara,
        $strAssunto,
        $strCorpo,
        $varAnexo = null,
        $strConteudo = "text/plain",
        $strCopiaOculta = null,
        $strReplyTo = null
    ) {
        $strCabecalho = '';
        $strCabecalho .= "From: " . $strDe . "\r\n";
        $strCabecalho .= "Reply-To: " . ($strReplyTo == null ? $strDe : $strReplyTo) . "\r\n";

        if (!InfraString::isBolVazia($strCopiaOculta)) {
            $strCabecalho .= 'Bcc: ' . $strCopiaOculta . "\r\n";
        }

        $strCabecalho .= "MIME-Version: 1.0\r\n";

        if ($varAnexo == null) {
            $strCabecalho .= "Content-type: " . $strConteudo . "; charset=iso-8859-1\r\n";
        } else {
            //CABE�ALHO DA MENSAGEM COM ANEXO
            $strRand = md5(time());
            $strMimeBoundary = "==Multipart_Boundary_x{$strRand}x";
            $strCabecalho .= "Content-Type: multipart/mixed;\n boundary=\"{$strMimeBoundary}\"\r\n";
            $strCabecalho .= "\r\nThis is a multi-part message in MIME format.\r\n";

            $strTemp = '';
            $strTemp .= "--{$strMimeBoundary}\r\n";
            $strTemp .= "Content-type: " . $strConteudo . "; charset=iso-8859-1\n";
            $strTemp .= "Content-Transfer-Encoding: base64\r\n";
            $strTemp .= chunk_split(base64_encode($strCorpo)) . "\r\n";

            //COMPATIBILIDADE COM C�DIGOS LEGADOS: LISTA DE ARQUIVOS (MESMO SE � S� UM) EM ARRAY
            if (!is_array($varAnexo)) {
                $strArquivo = $varAnexo;
                $varAnexo = array($strArquivo => $strArquivo);
            }

            if (count($varAnexo) > 0) {
                if (isset($varAnexo['tmp_name'])) {
                    //SE � UM CAMPO FILES[''], GUARDA AS INFORMA��ES NO ARRAY
                    $arrNomeAnexo[0] = $varAnexo['name'];
                    $arrCaminhoArquivo[0] = $varAnexo['tmp_name'];
                    $arrTipoArquivo[0] = $varAnexo['type'];
                } else {
                    //SE � UM ARRAY DE CAMINHOS, GUARDA AS INFORMA��ES DE CADA UM NO ARRAY (A CHAVE DO ARRAY TEM O NOME REAL)
                    foreach ($varAnexo as $strNome => $strCaminho) {
                        $arrNomeAnexo[] = $strNome;
                        $arrCaminhoArquivo[] = $strCaminho;
                        $arrTipoArquivo[] = InfraUtil::getStrMimeType($strCaminho);
                    }
                }

                //ANEXOS
                for ($i = 0; $i < InfraArray::contar($arrNomeAnexo); $i++) {
                    $strArquivo = fopen($arrCaminhoArquivo[$i], 'rb');
                    $strDados = fread($strArquivo, filesize($arrCaminhoArquivo[$i]));
                    fclose($strArquivo);
                    $strDados = chunk_split(base64_encode($strDados));
                    $strTemp .= "--{$strMimeBoundary}\r\n";
                    $strTemp .= "Content-Type: {$arrTipoArquivo[$i]}; name=\"{$arrNomeAnexo[$i]}\"\n";
                    $strTemp .= "Content-Transfer-Encoding: base64\n";
                    $strTemp .= "Content-Disposition: attachment;\n filename=\"{$arrNomeAnexo[$i]}\"\r\n";
                    $strTemp .= $strDados . "\r\n";
                }
            }

            $strCorpo = $strTemp;
        }

        //verifica se esta no formato "Nome <e-mail>"
        $posMenor = strpos($strDe, '<');
        $posMaior = strpos($strDe, '>');

        if ($posMenor !== false && $posMaior !== false && $posMenor < $posMaior) {
            $strReturnPath = substr($strDe, ($posMenor + 1), $posMaior - $posMenor - 1);
        } else {
            $strReturnPath = $strDe;
        }

        //die($strCabecalho.'#'.$strCorpo);

        return mail($strPara, $strAssunto, $strCorpo, $strCabecalho, '-r "' . $strReturnPath . '"');
    }

    /**
     * Envia email buscando informa��es na classe de configura��o de cada sistema (ex. ConfiguracaoCSRH.php)
     *
     * @param Var $varConfiguracao - Inst�ncia da classe de configura��o ou um array com a configura��o
     * @param string $strDe
     * @param string $strPara
     * @param string $strCC
     * @param string $strCCO
     * @param string $strAssunto
     * @param string $strCorpo
     * @param string $strTipoCorpo
     * @param string $strAnexos
     * @param InfraLog $objInfraLog
     * @param null|string $strReplyTo Se n�o definido, ao inv�s de usar o replyTo como 'De', usa o valor parametrizado.
     * @return void
     */
    public static function enviarConfigurado(
        InfraConfiguracao $objInfraConfiguracao,
        $strDe,
        $strPara,
        $strCC,
        $strCCO,
        $strAssunto,
        $strCorpo,
        $strTipoCorpo = "text/plain",
        $arrAnexos = null,
        $objInfraLog = null,
        $strReplyTo = null
    ) {
        try {
            self::validarEmail(
                $objInfraConfiguracao,
                $strDe,
                $strPara,
                $strCC,
                $strCCO,
                $strAssunto,
                $strCorpo,
                $strTipoCorpo,
                $arrAnexos,
                $strReplyTo
            );

            $arrConfig = self::obterConfiguracao($objInfraConfiguracao, $strDe);

            $numTipoMail = $arrConfig['Tipo'];
            $strCodificacao = $arrConfig['Codificacao'];
            $strServidor = $arrConfig['Servidor'];
            $numPorta = $arrConfig['Porta'];
            $bolAutenticar = $arrConfig['Autenticar'];
            $strUsuario = $arrConfig['Usuario'];
            $strSenha = $arrConfig['Senha'];
            $strEmailProtegido = $arrConfig['Protegido'];

            $objPhpMailer = new PHPMailer\PHPMailer\PHPMailer(true);

            if (isset($arrConfig['Seguranca'])) {
                if (strtolower($arrConfig['Seguranca']) == 'ssl') {
                    $objPhpMailer->SMTPSecure = 'ssl';
                } elseif (strtolower($arrConfig['Seguranca']) == 'tls') {
                    $objPhpMailer->SMTPSecure = 'tls';
                } elseif ($arrConfig['Seguranca'] == '') {
                    $objPhpMailer->SMTPAutoTLS = false;
                } else {
                    throw new InfraException(
                        'Tipo de seguran�a para o envio de e-mail inv�lida [' . $arrConfig['Seguranca'] . '].'
                    );
                }
            } else {
                $objPhpMailer->SMTPSecure = 'tls';
            }

            if ($numTipoMail != InfraMail::$TM_SEND_MAIL && $numTipoMail != InfraMail::$TM_SMTP) {
                if (!isset($arrConfig['Tipo'])) {
                    throw new InfraException('N�o foi poss�vel localizar as configura��es de envio.');
                } else {
                    throw new InfraException('Tipo de envio do e-mail inv�lido [' . $numTipoMail . '].');
                }
            }

            $objPhpMailer->Encoding = $strCodificacao;

            if ($numTipoMail == InfraMail::$TM_SEND_MAIL) {
                $objPhpMailer->isSendMail();
            } else {
                $objPhpMailer->IsSMTP(); // telling the class to use SMTP
                $objPhpMailer->Host = $strServidor;
                $objPhpMailer->Port = $numPorta;

                if ($bolAutenticar) {
                    $objPhpMailer->SMTPAuth = true;
                    $objPhpMailer->Username = $strUsuario;
                    $objPhpMailer->Password = $strSenha;
                }
            }

            $arr = InfraMail::decomporEmail($strDe);
            $objPhpMailer->SetFrom($arr[0], $arr[1]);

            if (InfraString::isBolVazia($strReplyTo)) {
                $objPhpMailer->addReplyTo($arr[0], $arr[1]);
            } else {
                $arrReplyTo = InfraMail::decomporEmail($strReplyTo);
                $objPhpMailer->addReplyTo($arrReplyTo[0], $arrReplyTo[1]);
            }

            if ($strEmailProtegido != '') {
                $strPara = $strEmailProtegido;
            }

            if (!InfraString::isBolVazia($strPara)) {
                $arrPara = explode(';', $strPara);
                foreach ($arrPara as $strItemPara) {
                    if ($strItemPara != '') {
                        $arr = InfraMail::decomporEmail($strItemPara);
                        $objPhpMailer->AddAddress($arr[0], $arr[1]);
                    }
                }
            }

            if (!InfraString::isBolVazia($strCC) && $strEmailProtegido == '') {
                $arrCC = explode(';', $strCC);
                foreach ($arrCC as $strItemCC) {
                    if ($strItemCC != '') {
                        $arr = InfraMail::decomporEmail($strItemCC);
                        $objPhpMailer->AddCC($arr[0], $arr[1]);
                    }
                }
            }

            if (!InfraString::isBolVazia($strCCO) && $strEmailProtegido == '') {
                $arrCCO = explode(';', $strCCO);
                foreach ($arrCCO as $strItemCCO) {
                    if ($strItemCCO != '') {
                        $arr = InfraMail::decomporEmail($strItemCCO);
                        $objPhpMailer->AddBCC($arr[0], $arr[1]);
                    }
                }
            }

            $objPhpMailer->ContentType = $strTipoCorpo;
            $objPhpMailer->Subject = $strAssunto;
            $objPhpMailer->Body = $strCorpo;

            if ($arrAnexos != null) {
                foreach ($arrAnexos as $strNomeAnexo => $strCaminhoAnexo) {
                    $type = PHPMailer\PHPMailer\PHPMailer::filenameToType($strNomeAnexo);

                    if ($type == 'text/html') {
                        $type .= '; charset=' . $objPhpMailer::CHARSET_ISO88591;
                    }

                    $objPhpMailer->AddAttachment(
                        $strCaminhoAnexo,
                        (is_numeric($strNomeAnexo) ? '' : $strNomeAnexo),
                        $objPhpMailer::ENCODING_BASE64,
                        $type
                    );
                }
            }

            $objPhpMailer->Send();
        } catch (Exception $e) {
            $objInfraException = new InfraException();

            $strExcUpper = strtoupper($e->__toString());

            if (strpos($strExcUpper, 'COULD NOT CONNECT TO SMTP HOST') !== false ||
                strpos($strExcUpper, 'CONNECTION TIMED OUT') !== false ||
                strpos($strExcUpper, 'UNABLE TO CONNECT') !== false ||
                strpos($strExcUpper, 'NO ROUTE TO HOST') !== false ||
                strpos($strExcUpper, 'NAME OR SERVICE NOT KNOWN') !== false) {
                $objInfraException->lancarValidacao('Falha na conex�o com o servidor de e-mails.', null, $e);
            }

            if (strpos($strExcUpper, 'CONNECTION REFUSED') !== false) {
                $objInfraException->lancarValidacao('O servidor de e-mails recusou a conex�o.', null, $e);
            }

            if (strpos($strExcUpper, 'COULD NOT AUTHENTICATE') !== false) {
                $objInfraException->lancarValidacao('Falha na autentica��o com o servidor de e-mails.', null, $e);
            }

            if (strpos($strExcUpper, 'DATA NOT ACCEPTED') !== false) {
                $objInfraException->lancarValidacao('O servidor de e-mails n�o aceitou os dados enviados.', null, $e);
            }

            if (strpos($strExcUpper, 'INVALID ADDRESS') !== false) {
                $objInfraException->lancarValidacao('Endere�o eletr�nico inv�lido.');
            }

            if (strpos($strExcUpper, 'THE FOLLOWING RECIPIENTS FAILED') !== false) {
                $strMsg = 'N�o foi poss�vel enviar para o(s) destinat�rio(s): ' . "\n";

                foreach ($objPhpMailer->getArrBadReceipt() as $item) {
                    $strErroBadReceiptUpper = strtoupper($item['error']);

                    $strMsg .= $item['to'] . ' - ';

                    if (strpos($strErroBadReceiptUpper, 'QUOTA EXCEEDED') !== false) {
                        $strMsg .= 'Conta de email cheia';
                    } elseif (strpos($strErroBadReceiptUpper, 'DOMAIN NOT FOUND') !== false) {
                        $strMsg .= 'Dom�nio do email n�o encontrado';
                    } elseif (strpos($strErroBadReceiptUpper, 'USER UNKNOWN') !== false) {
                        $strMsg .= 'Conta n�o encontrada';
                    } else {
                        $strMsg .= $item['error'];
                    }
                    $strMsg .= "\n";
                }

                $objInfraException->lancarValidacao($strMsg, null, $e);
            }

            if (strpos($strExcUpper, 'QUOTA EXCEEDED') !== false) {
                $objInfraException->lancarValidacao('Conta de email cheia.');
            }

            throw new InfraException('Erro enviando correspond�ncia eletr�nica.', $e);
        }
    }

    /**
     * Se o endere�o de email est� no formato "Nome <e-mail>", divide a string e retorna um array com dois os valores,
     * Se n�o, passa apenas o endere�o na posi��o 0, e '' na posi�ao 1 do array retornado
     *
     * @param string $strEmail
     * @return array
     */
    private static function decomporEmail($strEmail)
    {
        $posMenor = strpos($strEmail, '<');
        $posMaior = strpos($strEmail, '>');

        if ($posMenor !== false && $posMaior !== false && $posMenor < $posMaior) {
            $strDescricao = substr($strEmail, 0, $posMenor);
            $strEndereco = substr($strEmail, ($posMenor + 1), $posMaior - $posMenor - 1);
        } else {
            $strDescricao = '';
            $strEndereco = $strEmail;
        }

        return array($strEndereco, $strDescricao);
    }

    /**
     * @param InfraConfiguracao $objInfraConfiguracao
     * @param $strDe
     * @param $strPara
     * @param $strCC
     * @param $strCCO
     * @param $strAssunto
     * @param $strCorpo
     * @param string $strTipoCorpo
     * @param null $arrAnexos
     * @param null|string $strReplyTo Se n�o definido, ao inv�s de usar o replyTo como 'De', usa o valor parametrizado.
     */
    public static function validarEmail(
        InfraConfiguracao $objInfraConfiguracao,
        $strDe,
        $strPara,
        $strCC,
        $strCCO,
        $strAssunto,
        $strCorpo,
        $strTipoCorpo = "text/plain",
        $arrAnexos = null,
        $strReplyTo = null
    ) {
        $objInfraException = new InfraException();

        if (InfraString::isBolVazia($strDe)) {
            $objInfraException->lancarValidacao('Remetente do e-mail n�o informado.');
        }

        if (!InfraUtil::validarEmail($strDe)) {
            $objInfraException->lancarValidacao('E-mail do remetente "' . $strDe . '" inv�lido.');
        }

        $arrConfig = self::obterConfiguracao($objInfraConfiguracao, $strDe);

        //postconf | grep smtpd_recipient_limit
        $numMaxDestinatarios = (isset($arrConfig['MaxDestinatarios']) ? $arrConfig['MaxDestinatarios'] : null);

        //zmprov getAllConfig | grep MessageSize
        $numMaxTamMbAnexos = (isset($arrConfig['MaxTamAnexosMb']) ? $arrConfig['MaxTamAnexosMb'] : null);
        if (!InfraString::isBolVazia($strReplyTo)) {
            if (!InfraUtil::validarEmail($strReplyTo)) {
                $objInfraException->lancarValidacao('E-mail do Reply To "' . $strReplyTo . '" inv�lido.');
            }
        }
        if (InfraString::isBolVazia($strPara) && InfraString::isBolVazia($strCC) && InfraString::isBolVazia($strCCO)) {
            $objInfraException->lancarValidacao('Nenhum destinat�rio de e-mail informado.');
            return;
        }

        $arr = array();

        if (!InfraString::isBolVazia($strPara)) {
            $arr = array_merge($arr, explode(';', $strPara));
        }

        if (!InfraString::isBolVazia($strCC)) {
            $arr = array_merge($arr, explode(';', $strCC));
        }

        if (!InfraString::isBolVazia($strCCO)) {
            $arr = array_merge($arr, explode(';', $strCCO));
        }

        $numDestinatarios = count($arr);

        $numDestinatariosValidos = 0;

        for ($i = 0; $i < $numDestinatarios; $i++) {
            if ($arr[$i] != '') {
                if (!InfraUtil::validarEmail($arr[$i])) {
                    $objInfraException->lancarValidacao('E-mail do destinat�rio "' . $arr[$i] . '" inv�lido.');
                }
                $numDestinatariosValidos++;
            }
        }

        if ($numDestinatariosValidos == 0) {
            $objInfraException->lancarValidacao('Nenhum e-mail de destinat�rio informado.');
        }

        if ($numMaxDestinatarios != null && $numDestinatariosValidos > $numMaxDestinatarios) {
            $objInfraException->lancarValidacao(
                'N�mero de destinat�rios (' . $numDestinatariosValidos . ') excede o limite permitido (' . $numMaxDestinatarios . ').'
            );
            return;
        }

        if (InfraString::isBolVazia($strAssunto)) {
            $objInfraException->lancarValidacao('Assunto n�o informado.');
        }

        /*
        if (InfraString::isBolVazia($strCorpo)){
          $objInfraException->lancarValidacao('Mensagem n�o informada.');
        }
        */

        if ($arrAnexos != null) {
            foreach ($arrAnexos as $strNome => $strAnexo) {
                if (!file_exists($strAnexo)) {
                    $objInfraException->lancarValidacao(
                        'Anexo ' . $strNome . ' [' . $strAnexo . '] n�o encontrado para envio.'
                    );
                }
            }

            if ($numMaxTamMbAnexos != null) {
                $numTamanho = 0;

                foreach ($arrAnexos as $strAnexo) {
                    $numTamanho += filesize($strAnexo);
                }

                if ($numTamanho > ($numMaxTamMbAnexos * 1024 * 1024)) {
                    $objInfraException->lancarValidacao(
                        'O tamanho dos anexos � ' . round(
                            $numTamanho / (1024 * 1024),
                            1
                        ) . 'Mb (m�ximo permitido ' . $numMaxTamMbAnexos . 'Mb).'
                    );
                }
            }
        }
    }

    private static function obterConfiguracao(InfraConfiguracao $objInfraConfiguracao, $strDe)
    {
        $arrConfig = $objInfraConfiguracao->getValor('InfraMail');

        $strDominio = trim(str_replace('>', '', substr($strDe, strrpos($strDe, '@') + 1)));
        if ($objInfraConfiguracao->isSetValor('InfraMail', 'Dominios')) {
            $arrDominios = $objInfraConfiguracao->getValor('InfraMail', 'Dominios');
            if (isset($arrDominios[$strDominio])) {
                $arrConfig = $arrDominios[$strDominio];
            }
        }

        //die('<pre>'.$strDominio.'<br />'.print_r($arrConfig,true).'</pre>');

        return $arrConfig;
    }
}

