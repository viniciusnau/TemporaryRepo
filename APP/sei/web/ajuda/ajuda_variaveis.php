<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 01/06/2018 - cjy - adicao de variaveis observacao_documento e observacao_processo
 *
 */

try {
  require_once dirname(__FILE__).'/../SEI.php';

  session_start();

  global $SEI_MODULOS;

  //////////////////////////////////////////////////////////////////////////////
  //InfraDebug::getInstance()->setBolLigado(false);
  //InfraDebug::getInstance()->setBolDebugInfra(true);
  //InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  SessaoSEI::getInstance()->validarLink();

  PaginaSEI::getInstance()->setTipoPagina(InfraPagina::$TIPO_PAGINA_SIMPLES);

  SessaoSEI::getInstance()->validarPermissao($_GET['acao']);

  $arrVariaveis = array();

  switch($_GET['acao']){

    case 'ajuda_variaveis_secao_modelo':

      $strTitulo = 'Vari�veis Dispon�veis na Se��o';

      $arrVariaveis[] = array('@timbre_orgao@','Timbre do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@sigla_orgao_origem@','Sigla do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@descricao_orgao_origem@','Descri��o do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@descricao_orgao_maiusculas@','Descri��o em letras mai�sculas do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@artigo_orgao_minuscula@','Artigo em letra min�scula associado com o �rg�o da unidade atual');
      $arrVariaveis[] = array('@artigo_orgao_maiuscula@','Artigo em letra mai�scula associado com o �rg�o da unidade atual');
      $arrVariaveis[] = array('@cnpj_orgao@','CNPJ do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@endereco_orgao@','Endere�o do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@complemento_endereco_orgao@','Complemento do endere�o do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@hifen_bairro_orgao@','Caractere h�fen seguido do bairro do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@cidade_orgao@','Cidade do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@sigla_uf_orgao@','Sigla da unidade federativa associada com o �rg�o da unidade atual');
      $arrVariaveis[] = array('@cep_orgao@','CEP do �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@hifen_sitio_internet_orgao@','Caractere h�fen seguido do s�tio da internet cadastrado para o �rg�o associado com a unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade@','Hierarquia da unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade_invertida@','Hierarquia invertida da unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade_descricao_quebra_linha@','Descri��o das unidades da hierarquia separadas por quebra de linha');
      $arrVariaveis[] = array('@hierarquia_unidade_invertida_descricao_quebra_linha@','Descri��o das unidades da hierarquia invertida separadas por quebra de linha');
      $arrVariaveis[] = array('@hierarquia_unidade_raiz_sigla@','Sigla da unidade raiz na hierarquia da unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade_raiz_descricao@','Descri��o da unidade raiz na hierarquia da unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade_superior_sigla@','Sigla da unidade imediatamente superior na hierarquia da unidade atual');
      $arrVariaveis[] = array('@hierarquia_unidade_superior_descricao@','Descri��o da unidade imediatamente superior na hierarquia da unidade atual');
      $arrVariaveis[] = array('@sigla_unidade@','Sigla da unidade atual');
      $arrVariaveis[] = array('@descricao_unidade@','Descri��o da unidade atual');
      $arrVariaveis[] = array('@descricao_unidade_maiusculas@','Descri��o em letras mai�sculas da unidade atual');
      $arrVariaveis[] = array('@email_unidade[_2,_3]@','1�, 2� ou 3� endere�o eletr�nico da unidade atual');
      $arrVariaveis[] = array('@endereco_unidade@','Endere�o da unidade atual');
      $arrVariaveis[] = array('@complemento_endereco_unidade@','Complemento do endere�o da unidade atual');
      $arrVariaveis[] = array('@hifen_bairro_unidade@','Caractere h�fen seguido do bairro da unidade atual');
      $arrVariaveis[] = array('@telefone_comercial_unidade@','Telefone comercial da unidade atual');
      $arrVariaveis[] = array('@telefone_residencial_unidade@','Telefone residencial da unidade atual');
      $arrVariaveis[] = array('@telefone_celular_unidade@','Telefone celular da unidade atual');
      $arrVariaveis[] = array('@cidade_unidade@','Cidade da unidade atual');
      $arrVariaveis[] = array('@sigla_uf_unidade@','Sigla da unidade federativa associada com a unidade atual');
      $arrVariaveis[] = array('@cep_unidade@','CEP da unidade atual');
      $arrVariaveis[] = array('@observacao_unidade@','Observa��o associada com a unidade atual');
      $arrVariaveis[] = array('@dia@','Dia atual (01..31)');
      $arrVariaveis[] = array('@mes@','M�s atual (01..12)');
      $arrVariaveis[] = array('@ano@','Ano atual');
      $arrVariaveis[] = array('@mes_extenso@','Nome do m�s atual');
      $arrVariaveis[] = array('@processo@','N�mero do processo');
      $arrVariaveis[] = array('@tipo_processo@','Tipo do processo');
      $arrVariaveis[] = array('@especificacao_processo@','Especifica��o do processo');
      $arrVariaveis[] = array('@observacao_processo@','Observa��o da unidade no processo');
      $arrVariaveis[] = array('@codigo_barras_processo@','C�digo de barras do n�mero do processo (formato 3 de 9)');
      $arrVariaveis[] = array('@link_acesso_externo_processo@','N�mero do processo contendo um link para um acesso externo gerado automaticamente');
      $arrVariaveis[] = array('@documento@','N�mero do documento');
      $arrVariaveis[] = array('@serie@','Tipo do documento');
      $arrVariaveis[] = array('@numeracao_serie@','Numera��o associada com o tipo de documento');
      $arrVariaveis[] = array('@descricao_documento@','Descri��o do documento');
      $arrVariaveis[] = array('@observacao_documento@','Observa��o da unidade no documento');
      $arrVariaveis[] = array('@codigo_barras_documento@','C�digo de barras do n�mero do documento (formato 3 de 9)');

      $arrVariaveis[] = array('@destinatarios_virgula_espaco@','Nomes dos destinat�rios separados por v�rgula e espa�o');
      $arrVariaveis[] = array('@destinatarios_virgula_espaco_maiusculas@','Nomes em letras mai�sculas dos destinat�rios separados por v�rgula e espa�o');
      $arrVariaveis[] = array('@destinatarios_quebra_linha@','Nomes dos destinat�rios separados por quebra de linha');
      $arrVariaveis[] = array('@destinatarios_quebra_linha_maiusculas@','Nomes em letras mai�sculas dos destinat�rios separados por quebra de linha');

      $arrVariaveis[] = array('@nome_destinatario[_2,_3]@','Nome do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@nome_destinatario_maiusculas[_2,_3]@','Nome em letras mai�sculas do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@tratamento_destinatario[_2,_3]@','Tratamento associado com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@categoria_destinatario[_2,_3]@','Categoria associada com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cargo_destinatario[_2,_3]@','Cargo associado com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@titulo_destinatario[_2,_3]@','T�tulo associado com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@titulo_abreviatura_destinatario[_2,_3]@','Abreviatura do T�tulo associada com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@funcao_destinatario[_2,_3]@','Fun��o associada com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@vocativo_destinatario[_2,_3]@','Vocativo associado com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@artigo_destinatario_minuscula[_2,_3]@','Artigo em letra min�scula associado com o sexo do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@artigo_destinatario_maiuscula[_2,_3]@','Artigo em letra mai�scula associado com o sexo do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cpf_destinatario[_2,_3]@','N�mero do CPF do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@numero_passaporte_destinatario[_2,_3]@','N�mero do passaporte associado com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@pais_passaporte_destinatario[_2,_3]@','Pa�s de emiss�o do passaporte do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@rg_destinatario[_2,_3]@','N�mero do RG do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@orgao_expedidor_rg_destinatario[_2,_3]@','�rg�o Expedidor associado com o RG do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@matricula_destinatario[_2,_3]@','N�mero de matr�cula do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@matricula_oab_destinatario[_2,_3]@','N�mero de matr�cula da OAB do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cnpj_destinatario[_2,_3]@','N�mero do CNPJ do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@endereco_destinatario[_2,_3]@','Endere�o do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@complemento_endereco_destinatario[_2,_3]@','Complemento do endere�o do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@bairro_destinatario[_2,_3]@','Bairro do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cep_destinatario[_2,_3]@','CEP do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cidade_destinatario[_2,_3]@','Cidade do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@sigla_uf_destinatario[_2,_3]@','Sigla da unidade federativa do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@hifen_uf_destinatario[_2,_3]@','Caractere h�fen seguido da sigla da unidade federativa do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@pais_destinatario[_2,_3]@','Pa�s do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@email_destinatario[_2,_3]@','Endere�o eletr�nico do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@sitio_internet_destinatario[_2,_3]@','S�tio na internet do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@telefone_comercial_destinatario[_2,_3]@','Telefone comercial do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@telefone_residencial_destinatario[_2,_3]@','Telefone residencial do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@telefone_celular_destinatario[_2,_3]@','Telefone celular do 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@nome_pessoa_juridica_associada_destinatario[_2,_3]@','Nome da pessoa jur�dica associada com o 1�, 2� ou 3� destinat�rio');
      $arrVariaveis[] = array('@cnpj_pessoa_juridica_associada_destinatario[_2,_3]@','CNPJ da pessoa jur�dica associada com o 1�, 2� ou 3� destinat�rio');

      $arrVariaveis[] = array('@interessados_virgula_espaco@','Nomes dos interessados separados por v�rgula e espa�o');
      $arrVariaveis[] = array('@interessados_virgula_espaco_maiusculas@','Nomes em letras mai�sculas dos interessados separados por v�rgula e espa�o');
      $arrVariaveis[] = array('@interessados_quebra_linha@','Nomes dos interessados separados por quebra de linha');
      $arrVariaveis[] = array('@interessados_quebra_linha_maiusculas@','Nomes em letras mai�sculas dos interessados separados por quebra de linha');

      $arrVariaveis[] = array('@nome_interessado[_2,_3]@','Nome do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@nome_interessado_maiusculas[_2,_3]@','Nome em letras mai�sculas do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@tratamento_interessado[_2,_3]@','Tratamento associado com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@categoria_interessado[_2,_3]@','Categoria associada com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cargo_interessado[_2,_3]@','Cargo associado com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@titulo_interessado[_2,_3]@','T�tulo associado com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@titulo_abreviatura_interessado[_2,_3]@','Abreviatura do T�tulo associada com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@funcao_interessado[_2,_3]@','Fun��o associada com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@vocativo_interessado[_2,_3]@','Vocativo associado com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@artigo_interessado_minuscula[_2,_3]@','Artigo em letra min�scula associado com o sexo do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@artigo_interessado_maiuscula[_2,_3]@','Artigo em letra mai�scula associado com o sexo do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cpf_interessado[_2,_3]@','N�mero do CPF do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@numero_passaporte_interessado[_2,_3]@','N�mero do passaporte associado com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@pais_passaporte_interessado[_2,_3]@','Pa�s de emiss�o do passaporte do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@rg_interessado[_2,_3]@','N�mero do RG do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@orgao_expedidor_rg_interessado[_2,_3]@','�rg�o Expedidor associado com o RG do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@matricula_interessado[_2,_3]@','N�mero de matr�cula do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@matricula_oab_interessado[_2,_3]@','N�mero de matr�cula da OAB do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cnpj_interessado[_2,_3]@','N�mero do CNPJ do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@endereco_interessado[_2,_3]@','Endere�o do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@complemento_endereco_interessado[_2,_3]@','Complemento do endere�o do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@bairro_interessado[_2,_3]@','Bairro do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cep_interessado[_2,_3]@','CEP do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cidade_interessado[_2,_3]@','Cidade do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@sigla_uf_interessado[_2,_3]@','Sigla da unidade federativa do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@hifen_uf_interessado[_2,_3]@','Caractere h�fen seguido da sigla da unidade federativa do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@pais_interessado[_2,_3]@','Pa�s do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@email_interessado[_2,_3]@','Endere�o eletr�nico do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@sitio_internet_interessado[_2,_3]@','S�tio na internet do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@telefone_comercial_interessado[_2,_3]@','Telefone comercial do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@telefone_residencial_interessado[_2,_3]@','Telefone residencial do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@telefone_celular_interessado[_2,_3]@','Telefone celular do 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@nome_pessoa_juridica_associada_interessado[_2,_3]@','Nome da pessoa jur�dica associada com o 1�, 2� ou 3� interessado');
      $arrVariaveis[] = array('@cnpj_pessoa_juridica_associada_interessado[_2,_3]@','CNPJ da pessoa jur�dica associada com o 1�, 2� ou 3� interessado');

      $arrVariaveis[] = array('@sigla_usuario@','Sigla do usu�rio logado');
      $arrVariaveis[] = array('@nome_usuario@','Nome do usu�rio logado');
      $arrVariaveis[] = array('@cargo_usuario@','Cargo do usu�rio logado');
      $arrVariaveis[] = array('@email_usuario@','Endere�o Eletr�nico do usu�rio logado');

      foreach($SEI_MODULOS as $seiModulo){
        if (($arr = $seiModulo->executar('obterRelacaoVariaveisEditor'))!=null){
          foreach ($arr as $variavel=>$descricao) {
            if(preg_match(EditorRN::$REGEXP_VARIAVEL_EDITOR,$variavel)!==1){
              throw new InfraException('Vari�vel de editor inv�lida ['.$variavel.'] criada no m�dulo '.$seiModulo->getNome());
            }
            $arrVariaveis[]=array('@'.$variavel.'@',$descricao);
          }
        }
      }

      break;

    case 'ajuda_variaveis_tarjas':

      $strTitulo = 'Vari�veis Dispon�veis na Tarja';

      switch($_GET['tipo']) {
        case 'A':
          $arrVariaveis[] = array('@logo_assinatura@', 'Logotipo associado com a tarja');
          $arrVariaveis[] = array('@nome_assinante@', 'Nome do assinante');
          $arrVariaveis[] = array('@tratamento_assinante@', 'Cargo/Fun��o utilizado pelo assinante');
          $arrVariaveis[] = array('@data_assinatura@', 'Data da assinatura no formato dd/mm/aaaa');
          $arrVariaveis[] = array('@hora_assinatura@', 'Hora da assinatura no formato hh:mm');
          $arrVariaveis[] = array('@codigo_verificador@', 'C�digo verificador necess�rio para valida��o da assinatura');
          $arrVariaveis[] = array('@crc_assinatura@', 'C�digo CRC necess�rio para valida��o da assinatura');
          $arrVariaveis[] = array('@numero_serie_certificado_digital@', 'N�mero de s�rie do certificado digital utilizado na assinatura');
          $arrVariaveis[] = array('@tipo_conferencia@', 'Tipo de confer�ncia realizada no documento externo');
          break;

        case 'V':
          $arrVariaveis[] = array('@qr_code@','QR Code com um link para a p�gina de valida��o de assinatura');
          $arrVariaveis[] = array('@codigo_verificador@','C�digo verificador necess�rio para valida��o da assinatura');
          $arrVariaveis[] = array('@crc_assinatura@','C�digo CRC necess�rio para valida��o da assinatura');
          $arrVariaveis[] = array('@link_acesso_externo_processo@','N�mero do processo contendo um link para um acesso externo gerado automaticamente');
          break;
      }
      break;

    case 'ajuda_variaveis_email_sistema':

      $strTitulo = 'Vari�veis Dispon�veis';

      switch($_GET['campo']){
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

      switch($_GET['tipo']){

        case EmailSistemaRN::$ES_ENVIO_PROCESSO_PARA_UNIDADE:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@emails_unidade@','Lista de endere�os eletr�nicos da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@tipo_processo@','Tipo do processo');
              $arrVariaveis[] = array('@sigla_unidade_remetente@','Sigla da unidade remetente');
              $arrVariaveis[] = array('@descricao_unidade_remetente@','Descri��o da unidade remetente');
              $arrVariaveis[] = array('@sigla_orgao_unidade_remetente@','Sigla do �rg�o da unidade remetente');
              $arrVariaveis[] = array('@descricao_orgao_unidade_remetente@','Descri��o do �rg�o da unidade remetente');
              $arrVariaveis[] = array('@sigla_unidade_destinataria@','Sigla da unidade destinat�ria');
              $arrVariaveis[] = array('@descricao_unidade_destinataria@','Descri��o da unidade destinat�ria');
              $arrVariaveis[] = array('@sigla_orgao_unidade_destinataria@','Sigla do �rg�o da unidade destinat�ria');
              $arrVariaveis[] = array('@descricao_orgao_unidade_destinataria@','Descri��o do �rg�o da unidade destinat�ria');
              break;
          }
          break;

        case EmailSistemaRN::$ES_CONCESSAO_CREDENCIAL:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@emails_unidade@','Lista de endere�os eletr�nicos da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@sigla_usuario_credencial@','Sigla do usu�rio que recebeu credencial');
              $arrVariaveis[] = array('@nome_usuario_credencial@','Nome do usu�rio que recebeu credencial');
              $arrVariaveis[] = array('@sigla_unidade_credencial@','Sigla da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@descricao_unidade_credencial@','Descri��o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@sigla_orgao_unidade_credencial@','Sigla do �rg�o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@descricao_orgao_unidade_credencial@','Descri��o do �rg�o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              break;
          }
          break;

        case EmailSistemaRN::$ES_CONCESSAO_CREDENCIAL_ASSINATURA:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@emails_unidade@','Lista de endere�os eletr�nicos da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@sigla_usuario_credencial@','Sigla do usu�rio que recebeu credencial');
              $arrVariaveis[] = array('@nome_usuario_credencial@','Nome do usu�rio que recebeu credencial');
              $arrVariaveis[] = array('@sigla_unidade_credencial@','Sigla da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@descricao_unidade_credencial@','Descri��o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@sigla_orgao_unidade_credencial@','Sigla do �rg�o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@descricao_orgao_unidade_credencial@','Descri��o do �rg�o da unidade onde o usu�rio recebeu credencial');
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@documento@','N�mero do documento');
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              break;
          }
          break;

        case EmailSistemaRN::$ES_DISPONIBILIZACAO_ACESSO_EXTERNO:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@email_unidade@','Endere�o eletr�nico da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'D':
              $arrVariaveis[] = array('@email_destinatario@','Endere�o eletr�nico do destinat�rio');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@nome_destinatario@','Nome do destinat�rio');
              $arrVariaveis[] = array('@data_validade@','Data de validade do acesso externo');
              $arrVariaveis[] = array('@link_acesso_externo@','Link para acesso externo');
              $arrVariaveis[] = array('@sigla_unidade@','Sigla da unidade');
              $arrVariaveis[] = array('@descricao_unidade@','Descri��o da unidade');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_DISPONIBILIZACAO_ACESSO_EXTERNO_USUARIO_EXTERNO:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@email_unidade@','Endere�o eletr�nico da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'D':
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@nome_usuario_externo@','Nome do usu�rio externo');
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              $arrVariaveis[] = array('@link_login_usuario_externo@','Endere�o da p�gina de login de usu�rios externos');
              $arrVariaveis[] = array('@sigla_unidade@','Sigla da unidade');
              $arrVariaveis[] = array('@descricao_unidade@','Descri��o da unidade');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_DISPONIBILIZACAO_ASSINATURA_EXTERNA_USUARIO_EXTERNO:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@email_unidade@','Endere�o eletr�nico da unidade no formato "Descri��o do E-mail <E-mail>"');
              break;

            case 'D':
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              break;

            case 'A':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@documento@','N�mero do documento');
              $arrVariaveis[] = array('@tipo_documento@','Tipo do documento');
              $arrVariaveis[] = array('@nome_usuario_externo@','Nome do usu�rio externo');
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              $arrVariaveis[] = array('@link_login_usuario_externo@','Endere�o da p�gina de login de usu�rios externos');
              $arrVariaveis[] = array('@sigla_unidade@','Sigla da unidade');
              $arrVariaveis[] = array('@descricao_unidade@','Descri��o da unidade');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_CADASTRO_USUARIO_EXTERNO:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              break;

            case 'A':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              break;

            case 'C':
              $arrVariaveis[] = array('@nome_usuario_externo@','Nome do usu�rio externo');
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              $arrVariaveis[] = array('@link_login_usuario_externo@','Endere�o da p�gina de login de usu�rios externos');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_GERACAO_SENHA_USUARIO_EXTERNO:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              break;

            case 'A':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              break;

            case 'C':
              $arrVariaveis[] = array('@nova_senha_usuario_externo@','Nova senha gerada para o usu�rio externo');
              $arrVariaveis[] = array('@nome_usuario_externo@','Nome do usu�rio externo');
              $arrVariaveis[] = array('@email_usuario_externo@','Endere�o eletr�nico do usu�rio externo');
              $arrVariaveis[] = array('@link_login_usuario_externo@','Endere�o da p�gina de login de usu�rios externos');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_CONTATO_OUVIDORIA:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@sigla_orgao_minusculas@','Sigla do �rg�o em letras min�sculas');
              $arrVariaveis[] = array('@sufixo_email@','Sufixo do endere�o eletr�nico configurado no par�metro SEI_SUFIXO_EMAIL da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@nome_contato@','Nome do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@email_contato@','Endere�o eletr�nico do usu�rio que realizou contato com a ouvidoria');
              break;

            case 'A':
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo@','N�mero do processo');
              $arrVariaveis[] = array('@tipo_processo@','Tipo do processo');
              $arrVariaveis[] = array('@nome_contato@','Nome do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@email_contato@','Endere�o eletr�nico do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@sigla_orgao@','Sigla do �rg�o');
              $arrVariaveis[] = array('@descricao_orgao@','Descri��o do �rg�o');
              $arrVariaveis[] = array('@sitio_internet_orgao@','S�tio do �rg�o na internet');
              break;
          }
          break;

        case EmailSistemaRN::$ES_CORRECAO_ENCAMINHAMENTO_OUVIDORIA:

          switch($_GET['campo']) {
            case 'R':
              $arrVariaveis[] = array('@sigla_sistema@','Sigla do sistema');
              $arrVariaveis[] = array('@email_sistema@','Endere�o eletr�nico do sistema configurado no par�metro SEI_EMAIL_SISTEMA da tabela de par�metros');
              $arrVariaveis[] = array('@sigla_orgao_origem@','Sigla do �rg�o origem');
              $arrVariaveis[] = array('@sigla_orgao_destino@','Sigla do �rg�o destino');
              $arrVariaveis[] = array('@sigla_orgao_origem_minusculas@','Sigla do �rg�o origem em letras min�sculas');
              $arrVariaveis[] = array('@sigla_orgao_destino_minusculas@','Sigla do �rg�o destino em letras min�sculas');
              $arrVariaveis[] = array('@sufixo_email@','Sufixo do endere�o eletr�nico configurado no par�metro SEI_SUFIXO_EMAIL da tabela de par�metros');
              break;

            case 'D':
              $arrVariaveis[] = array('@nome_contato@','Nome do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@email_contato@','Endere�o eletr�nico do usu�rio que realizou contato com a ouvidoria');
              break;

            case 'A':
              $arrVariaveis[] = array('@sigla_orgao_origem@','Sigla do �rg�o origem');
              $arrVariaveis[] = array('@sigla_orgao_destino@','Sigla do �rg�o destino');
              break;

            case 'C':
              $arrVariaveis[] = array('@processo_origem@','N�mero do processo origem');
              $arrVariaveis[] = array('@processo_destino@','N�mero do processo destino');
              $arrVariaveis[] = array('@tipo_processo@','Tipo do processo');
              $arrVariaveis[] = array('@nome_contato@','Nome do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@email_contato@','Endere�o eletr�nico do usu�rio que realizou contato com a ouvidoria');
              $arrVariaveis[] = array('@sigla_orgao_origem@','Sigla do �rg�o origem');
              $arrVariaveis[] = array('@sigla_orgao_destino@','Sigla do �rg�o destino');
              $arrVariaveis[] = array('@descricao_orgao_origem@','Descri��o do �rg�o origem');
              $arrVariaveis[] = array('@descricao_orgao_destino@','Descri��o do �rg�o destino');
              $arrVariaveis[] = array('@sitio_internet_orgao_origem@','S�tio do �rg�o origem na internet');
              $arrVariaveis[] = array('@sitio_internet_orgao_destino@','S�tio do �rg�o destino na internet');
              break;
          }
          break;
      }
      break;

    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }

  $numRegistros = count($arrVariaveis);

  $strResultado = '';
  $strResultado .= '<table width="99%" class="infraTable" summary="Tabela de Vari�veis Dispon�veis">'."\n"; //80
  $strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela('Vari�veis Dispon�veis',$numRegistros).'</caption>';
  $strResultado .= '<tr>';
  $strResultado .= '<th class="infraTh" width="30%">Vari�vel</th>'."\n";
  $strResultado .= '<th class="infraTh">Descri��o</th>'."\n";
  $strResultado .= '</tr>'."\n";
  $strCssTr='';
  for($i = 0;$i < $numRegistros; $i++){

    $strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
    $strResultado .= $strCssTr;

    $strResultado .= '<td><span style="font-family: Courier New">'.PaginaSEI::tratarHTML($arrVariaveis[$i][0]).'</span></td>';
    $strResultado .= '<td>'.PaginaSEI::tratarHTML($arrVariaveis[$i][1]).'</td>';

    $strResultado .= '</tr>'."\n";
  }
  $strResultado .= '</table>';

}catch(Exception $e){
  PaginaSEI::getInstance()->processarExcecao($e);
}

PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
PaginaSEI::getInstance()->montarTitle(PaginaSEI::getInstance()->getStrNomeSistema().' - '.$strTitulo);
PaginaSEI::getInstance()->montarStyle();
PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->fecharHead();
PaginaSEI::getInstance()->abrirBody($strTitulo);
PaginaSEI::getInstance()->montarAreaTabela($strResultado,$numRegistros,true);
PaginaSEI::getInstance()->fecharBody();
PaginaSEI::getInstance()->fecharHtml();
?>