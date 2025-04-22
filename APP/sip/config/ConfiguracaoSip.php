<?

class ConfiguracaoSip extends InfraConfiguracao  {

 	private static $instance = null;

 	public static function getInstance(){
 	  if (ConfiguracaoSip::$instance == null) {
 	    ConfiguracaoSip::$instance = new ConfiguracaoSip();
 	  }
 	  return ConfiguracaoSip::$instance;
 	}

 	public function getArrConfiguracoes(){
 	  return array(
 	      'Sip' => array(
 	          'URL' => 'http://172.17.0.2/sip',
 	          'Producao' => false),
 	       
 	      'PaginaSip' => array('NomeSistema' => 'SIP'),

 	      'SessaoSip' => array(
 	          'SiglaOrgaoSistema' => 'DPESC',
 	          'SiglaSistema' => 'SIP',
 	          'PaginaLogin' => 'http://172.17.0.2/sip/login.php',
 	          'SipWsdl' => 'http://172.17.0.2/sip/controlador_ws.php?servico=sip',
 	          'ChaveAcesso' => 'd27791b894028d9e7fa34887ad6f0c9a2c559cccda5f64f4e108e3573d5db862b66fb933', //ATEN��O: gerar uma nova chave para o SIP ap�s a instala��o (ver documento de instala��o)
 	          'https' => false),
 	       
 	      'BancoSip'  => array(
 	          'Servidor' => '172.22.0.1',
 	          'Porta' => '5433',
 	          'Banco' => 'sip',
 	          'Usuario' => 'postgres',
 	          'Senha' => 'DPE@01491!qwerty',
 	          'Tipo' => 'PostgreSql'), //MySql, SqlServer, Oracle ou PostgreSql

        /*
 	      'BancoAuditoriaSip'  => array(
 	          'Servidor' => '[Servidor BD]',
 	          'Porta' => '',
 	          'Banco' => '',
 	          'Usuario' => '',
 	          'Senha' => '',
 	          'Tipo' => ''), //MySql, SqlServer, Oracle ou PostgreSql
        */

				'CacheSip' => array('Servidor' => '[ocultado]',
						                'Porta' => '11211'),

				'InfraMail' => array(
                    'Tipo' => '2', //1 = sendmail (neste caso não é necessário configurar os atributos abaixo), 2 = SMTP
                    'Servidor' => '[ocultado]',
                    'Porta' => '587',
                    'Codificacao' => '8bit', //8bit, 7bit, binary, base64, quoted-printable
                    'MaxDestinatarios' => 31, //numero maximo de destinatarios por mensagem
                    'MaxTamAnexosMb' => 100, //tamanho maximo dos anexos em Mb por mensagem
                    'Seguranca' => '', //TLS, SSL ou vazio
                    'Autenticar' => false, //se true então informar Usuario e Senha
                    'Usuario' => '[ocultado]',
                    'Senha' => '[ocultado]',
                    'Protegido' => '' //campo usado em desenvolvimento, se tiver um email preenchido entao todos os emails enviados terao o destinatario ignorado e substituído por este valor evitando envio incorreto de email
				)
 	  );
 	}
}
?>