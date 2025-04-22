<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 28/12/2017 - criado por MGA
 *
 * @package infra_php
 */

class InfraTOTP
{

    /**
     * Gera o c�digo QRCode para autentica��o em 2 fatores
     * @param string $strDirTemp Diret�rio tempor�rio para gera��o do arquivo PNG do QRCode
     * @param string $strEmissor Institui��o e/ou sistema
     * @param string $strIdentificacao sigla e/ou nome de usu�rio
     * @param string $strSegredo chave secreta codificada em Base32 (RFC3548)
     * @param int $numDigitos n�mero de d�gitos (6 ou 8)
     * @param int $numIntervalo tamanho da janela de tempo (ignorado pelo Google Authenticator que usa o valor 30)
     * @return imagem do QRCode codificada em Base64
     */
    public static function gerar(
        $strDirTemp,
        $strEmissor,
        $strIdentificacao,
        $strSegredo,
        $numDigitos = 6,
        $numIntervalo = 30
    ) {
        try {
            if ($numDigitos != 6 && $numDigitos != 8) {
                throw new InfraException('N�mero de d�gitos inv�lido para autentica��o de 2 fatores.');
            }

            $base32 = new Tuupola\Base32();

            //public static function create(?string $secret = null, int $period = 30, string $digest = 'sha1', int $digits = 6, int $epoch = 0)
            $objTotp = OTPHP\TOTP::create(
                str_replace('=', '', $base32->encode($strSegredo)),
                $numIntervalo,
                'sha1',
                $numDigitos
            );

            $objTotp->setIssuer($strEmissor);
            $objTotp->setLabel($strIdentificacao);
            $objTotp->setIssuerIncludedAsParameter(true);

            if (InfraDebug::isBolProcessar()) {
                InfraDebug::getInstance()->gravarInfra('[InfraTOPT->gerar] ' . $objTotp->getProvisioningUri());
            }

            $strArquivo = $strDirTemp . '/' . md5(
                    time() . $strEmissor . mt_rand() . $strIdentificacao . mt_rand() . uniqid(mt_rand(), true)
                );

            InfraQRCode::gerar($objTotp->getProvisioningUri(), $strArquivo, 'L');

            if (($binQrCode = file_get_contents($strArquivo)) === false) {
                throw new InfraException('Erro lendo arquivo QRCode para autentica��o de 2 fatores.');
            }

            unlink($strArquivo);

            return base64_encode($binQrCode);
        } catch (Exception $e) {
            throw new InfraException('Erro gerando c�digo para autentica��o de 2 fatores.', $e);
        }
    }

    /**
     * Valida chave de 2 fatores
     * @param string $strSegredo chave secreta utilizada na gera��o do QRCode codificada em Base32 (RFC3548)
     * @param string $strChave valor informado pelo App
     * @param int $numJanelas n�mero de janelas v�lidas (0..n)
     * @param int $numDigitos n�mero de d�gitos (6 ou 8)
     * @param int $numIntervalo tamanho da janela de tempo (ignorado pelo Google Authenticator que usa o valor 30)
     * @param long $numTimestamp tempo de refer�ncia para valida��o (tempo atual se n�o informado)
     * @return true/false
     */
    public static function verificar(
        $strSegredo,
        $strChave,
        $numJanelas = 3,
        $numDigitos = 6,
        $numIntervalo = 30,
        $numTimestamp = null
    ) {
        try {
            if ($numDigitos != 6 && $numDigitos != 8) {
                throw new InfraException('N�mero de d�gitos inv�lido para autentica��o de 2 fatores.');
            }

            $base32 = new Tuupola\Base32();

            ////public static function create(?string $secret = null, int $period = 30, string $digest = 'sha1', int $digits = 6, int $epoch = 0)
            $objTotp = OTPHP\TOTP::create(
                str_replace('=', '', $base32->encode($strSegredo)),
                $numIntervalo,
                'sha1',
                $numDigitos
            );

            //public function verify(string $otp, ?int $timestamp = null, ?int $window = null)
            if ($objTotp->verify($strChave, $numTimestamp, $numJanelas)) {
                return true;
            }
        } catch (Exception $e) {
            throw new InfraException('Erro verificando chave na autentica��o de 2 fatores.', $e);
        }
        return false;
    }
}

