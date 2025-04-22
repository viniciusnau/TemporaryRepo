<?

class ConfiguracaoSEI extends InfraConfiguracao  {

 	private static $instance = null;

 	public static function getInstance(){
 	  if (ConfiguracaoSEI::$instance == null) {
 	    ConfiguracaoSEI::$instance = new ConfiguracaoSEI();
 	  }
 	  return ConfiguracaoSEI::$instance;
 	}

 	public function getArrConfiguracoes(){
 	  return array(

 	      'SEI' => array(
 	          'URL' => 'http://172.17.0.2/sei',
 	          'Producao' => false,
 	          'RepositorioArquivos' => '/opt/sei/dados'
		),
 	      'PaginaSEI' => array(
 	          'NomeSistema' => 'SEI',
 	          'NomeSistemaComplemento' => '',
 	          'LogoMenu' => ''),
 	       
 	      'SessaoSEI' => array(
 	          'SiglaOrgaoSistema' => 'DPESC',
 	          'SiglaSistema' => 'SEI',
 	          'PaginaLogin' => 'http://172.17.0.2/sip/login.php',
 	          'SipWsdl' => 'http://172.17.0.2/sip/controlador_ws.php?servico=sip',
 	          'ChaveAcesso' => '7babf862e12bd48f3101075c399040303d94a493c7ce9306470f719bb453e0428c6135dc', //ATEN��O: gerar uma nova chave para o SEI ap�s a instala��o (ver documento de instala��o)
 	          'https' => false),
 	       
 	      'BancoSEI'  => array(
 	          'Servidor' => '172.22.0.1',
 	          'Porta' => '5432',
 	          'Banco' => 'sei',
 	          'Usuario' => 'postgres',
 	          'Senha' => 'DPE@01491!qwerty',
 	          'Tipo' => 'PostgreSql'), //MySql, SqlServer, Oracle ou PostgreSql

 	      /*
        'BancoAuditoriaSEI'  => array(
 	          'Servidor' => '[servidor BD]',
 	          'Porta' => '',
 	          'Banco' => '',
 	          'Usuario' => '',S
 	          'Senha' => '',
 	          'Tipo' => ''), //MySql, SqlServer, Oracle ou PostgreSql
        */

  			'CacheSEI' => array('Servidor' => '[ocultado]',
					                	'Porta' => '11211'),

        'Federacao' => array(
          'Habilitado' => false
         ),

 	      'JODConverter' => array('Servidor' => 'http://[Servidor JODConverter]:8080/converter/service'),

		   'Pesquisa' => array('Banco' => true,
		   'Solr' => false,
		   'SqlServerFullTextSearch' => false),
		   
 	    //   'Solr' => array(
 	    //       'Servidor' =>  'http://10.37.1.176:8983/solr',
 	    //       'CoreProtocolos' => 'sei-protocolos',
		// 	  'TempoCommitProtocolos' => 300,
 	    //       'CoreBasesConhecimento' => 'sei-bases-conhecimento',
		// 	  'TempoCommitBasesConhecimento' => 60,
 	    //       'CorePublicacoes' => 'sei-publicacoes',
		// 	  'TempoCommitPublicacoes' => 60,
		// 	  'SolrUsername' => '[ocultado]',
		// 	  'SolrPassword' => '[ocultado]'),

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