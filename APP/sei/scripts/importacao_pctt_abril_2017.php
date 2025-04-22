<?
	try {

		require_once dirname(__FILE__) . '/../web/SEI.php';

		session_start();

		SessaoSEI::getInstance(false);

		InfraDebug::getInstance()->setBolLigado(false);
		InfraDebug::getInstance()->setBolDebugInfra(false);
		InfraDebug::getInstance()->setBolEcho(true);
		InfraDebug::getInstance()->limpar();

		$data = array();
		$data[] = array('00', 'S', 'ORGANIZA��O E FUNCIONAMENTO', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF), este ser� de guarda permanente.');
		$data[] = array('00.01', 'S', 'ADMINISTRA��O JUDICI�RIA', null, null, null, null);
		$data[] = array('00.01.01', 'S', 'ORGANIZA��O ADMINISTRATIVA', null, null, null, null);
		$data[] = array('00.01.01.01', 'N', 'Moderniza��o Administrativa', '3', '0', 'G', 'Projetos, estudos, qualidade, reengenharia e outros modelos gerenciais. Pode ser classificado pelo assunto pertinente.');
		$data[] = array('00.01.01.03', 'N', 'Estatuto. Regulamentos. Padroniza��o de procedimentos', '3', '0', 'G', null);
		$data[] = array('00.01.01.05', 'N', 'Estrutura organizacional', '3', '0', 'G', 'Inclusive organograma.');
		$data[] = array('00.01.01.07', 'N', 'Amplia��o da Justi�a Federal', '3', '0', 'G', 'Cria��o, implanta��o, especializa��o de varas, turmas, JEF, TRF.');
		$data[] = array('00.01.01.09', 'N', 'Jurisdi��o/delimita��o territorial', '3', '0', 'G', null);
		$data[] = array('00.01.01.11', 'N', 'Delega��es de compet�ncia. Procura��o', '100', '0', 'E', null);
		$data[] = array('00.01.01.12', 'N', 'Indica��o de magistrado � Diretoria do Foro, Presid�ncia dos TRF?s e outros cargos de dire��o', '10', '5', 'G', null);
		$data[] = array('00.01.01.13', 'N', 'Escolha de magistrado para a composi��o dos TRF\'s.', '10', '5', 'G', null);
		$data[] = array('00.01.01.14', 'N', 'Hor�rio de expediente', '2', '0', 'E', null);
		$data[] = array('00.01.01.15', 'N', 'Mapeamento e Modelagem de Processos de Trabalho', '3', '0', 'G', null);
		$data[] = array('00.01.01.16', 'N', 'Atribui��es e compet�ncias das unidades', '3', '0', 'G', null);
		$data[] = array('00.01.01.17', 'N', 'Formaliza��o de acordos (acordos, ajuste, contrato, conv�nio, termo de coopera��o, tratado)', '100', '3', 'G', 'O ato essencial gerado dever� ser encaminhado diretamente ao arquivo, conforme Resolu��o n. 318/2014, artigo 12.');
		$data[] = array('00.02', 'S', 'DESENVOLVIMENTO DE PESQUISA CIENT�FICA', null, null, null, null);
		$data[] = array('00.02.00.01', 'N', 'Pesquisa cient�fica', '100', '0', 'G', null);
		$data[] = array('00.03', 'S', 'GEST�O S�CIO-AMBIENTAL E RESPONSABILIDADE SOCIAL', null, null, null, null);
		$data[] = array('00.03.00.01', 'N', 'Gest�o Ambiental', '3', '0', 'G', null);
		$data[] = array('00.03.00.03', 'N', 'Responsabilidade Social / Voluntariado', '3', '0', 'G', null);
		$data[] = array('00.03.00.05', 'N', 'Programas s�cio-educativos para menores', '3', '0', 'G', null);
		$data[] = array('00.04', 'S', 'PLANEJAMENTO ESTRAT�GICO', null, null, null, null);
		$data[] = array('00.04.00.01', 'N', 'Planejamento estrat�gico', '3', '0', 'G', null);
		$data[] = array('00.05', 'S', 'RELATO DE ATIVIDADES', null, null, null, null);
		$data[] = array('00.05.00.01', 'N', 'Estat�stica para subsidiar a elabora��o de relat�rios de atividades', '2', '0', 'E', 'Dados transferidos para o relat�rio. Pode ser classificado pelo assunto pertinente.');
		$data[] = array('00.05.00.02', 'N', 'Relato de Atividades', '3', '0', 'G', 'Todo e qualquer tipo de Relat�rio (devendo o assunto ficar especificado na descri��o do documento), ');
		$data[] = array('00.06', 'S', 'FISCALIZA��O CONT�BIL, FINANCEIRA, OR�AMENT�RIA, OPERACIONAL E PATRIMONIAL', null, null, null, 'Prazo m�nimo de guarda 10 anos, conforme Art. n� 19, da IN 49/2005-TCU.');
		$data[] = array('00.06.01', 'S', 'AUDITORIA', null, null, null, null);
		$data[] = array('00.06.01.01', 'N', 'Auditoria externa', '3', '0', 'G', null);
		$data[] = array('00.06.01.02', 'N', 'Auditoria  interna', '100', '0', 'G', null);
		$data[] = array('00.06.02', 'S', 'PRESTA��O  DE CONTAS', null, null, null, null);
		$data[] = array('00.06.02.01', 'N', 'Tomada de contas especial', '0', '0', 'E', null);
		$data[] = array('00.06.02.03', 'N', 'Decis�o do TCU sobre as contas', '100', '0', 'G', null);
		$data[] = array('00.06.02.05', 'N', 'Presta��o de Contas Anual', '0', '0', 'E', null);
		$data[] = array('00.07', 'S', 'INFORMA��O PARA SUBSIDIAR A��ES JUDICIAIS', null, null, null, null);
		$data[] = array('00.07.00.01', 'N', 'Informa��o para subsidiar a��es judiciais', '2', '0', 'E', 'Informa��es em a��es contra o �rg�o, documentos para subsidiar a defesa. ');
		$data[] = array('00.07.00.02', 'N', 'Acompanhamento de decis�es judiciais', '3', '0', 'E', null);
		$data[] = array('00.08', 'S', 'REGULAMENTA��O', null, null, null, null);
		$data[] = array('00.08.00.01', 'N', 'Estudos e proposi��es para normas, regulamenta��es, diretrizes ', '3', '0', 'G', 'Caso gere ato normativo,  dever� ser classificado pelo assunto pertinente.');
		$data[] = array('00.09', 'S', 'REGISTRO NOS �RG�OS COMPETENTES', null, null, null, null);
		$data[] = array('00.09.00.01', 'N', 'Registro junto � Receita Federal / Minist�rio da Fazenda', '100', '0', 'E', 'Cadastro Geral de Contribuinte (CGC), Cadastro Nacional da Pessoa Jur�dica (CNPJ). Sujeito � an�lise hist�rica.');
		$data[] = array('00.10', 'S', '�RG�OS COLEGIADOS DE COMPET�NCIA ADMINISTRATIVA, COMIT�S, COMISS�ES E GRUPOS DE TRABALHO', null, null, null, null);
		$data[] = array('00.10.00.01', 'N', 'Funcionamento de colegiados', '3', '0', 'G', null);
		$data[] = array('00.10.00.02', 'N', 'Cria��o de comit�s, comiss�es e grupos de trabalho', '2', '0', 'G', null);
		$data[] = array('00.10.00.03', 'N', 'Indica��o de membros para composi��o', '2', '0', 'G', null);
		$data[] = array('00.10.00.04', 'N', 'Convoca��o para reuni�o', '2', '0', 'E', null);
		$data[] = array('00.10.00.05', 'N', 'Registro de reuni�o', '3', '0', 'G', 'Ata, Mem�ria da Reuni�o.');
		$data[] = array('00.10.02', 'S', 'DISTRIBUI��O DE PROCESSO ADMINISTRATIVO DO COLEGIADO', null, null, null, null);
		$data[] = array('00.10.02.01', 'N', 'Distribui��o de processo administrativo do colegiado', '2', '0', 'E', null);
		$data[] = array('00.10.03', 'S', 'TRAMITA��O, PROCESSAMENTO, BAIXA E ARQUIVAMENTO DE PROCESSO ADMINISTRATIVO DO COLEGIADO', null, null, null, null);
		$data[] = array('00.10.03.01', 'N', 'Provid�ncias/informa��es sobre o andamento de processo do colegiado', '2', '0', 'E', 'Dilig�ncias, antecedentes, inclus�o em pauta.');
		$data[] = array('00.10.03.02', 'N', 'Comunica��o de decis�es, despachos, julgamentos de processo do colegiado', '3', '0', 'E', 'Tanto expedida, quanto recebida.');
		$data[] = array('00.10.03.03', 'N', 'Certid�o de processo do colegiado', '100', '0', 'E', null);
		$data[] = array('00.10.04', 'S', 'JULGAMENTO DE PROCESSO DO COLEGIADO', null, null, null, null);
		$data[] = array('00.10.04.01', 'N', 'Registro de audi�ncia de julgamento de processo do colegiado', '3', '0', 'G', 'Inclusive ata, livro de transcri��o de depoimentos,notas taquigr�ficas, registros em audio, v�deo e meios digitais.');
		$data[] = array('00.11', 'S', 'COMUNICA��O E REPRESENTA��O SOCIAL', null, null, null, null);
		$data[] = array('00.11.01', 'S', 'RELAC�ES COM A IMPRENSA. ENTREVISTAS. NOTICI�RIOS. REPORTAGENS. EDITORIAIS', null, null, null, null);
		$data[] = array('00.11.01.01', 'N', 'Rela��es com a imprensa', '2', '0', 'E', 'Inclusive credenciamento.');
		$data[] = array('00.11.01.02', 'N', 'colet�nea de reportagens sobre o Poder Judici�rio', '3', '0', 'G', 'Clipping.');
		$data[] = array('00.11.01.03', 'N', 'mat�rias sobre a institui��o a serem divulgadas pela imprensa', '2', '0', 'G', 'Release.');
		$data[] = array('00.11.01.04', 'N', 'Produ��o Jornal�stica', '2', '0', 'G', 'Independente de m�dia (Programas veiculados na TV e nas R�dios).');
		$data[] = array('00.11.01.05', 'N', 'Credenciamento de imprensa', '3', '0', 'E', null);
		$data[] = array('00.11.02', 'S', 'RELA��ES P�BLICAS : SOLENIDADES, COMEMORA��ES, HOMENAGENS. ', null, null, null, null);
		$data[] = array('00.11.02.01', 'N', 'Mem�ria da solenidade', '3', '0', 'G', 'Planejamento, programa��o, discursos, palestras e trabalhos apresentados por t�cnicos do �rg�o.');
		$data[] = array('00.11.02.02', 'N', 'Visitas e visitantes oficiais', '2', '0', 'G', null);
		$data[] = array('00.11.02.03', 'N', 'Agradecimentos, congratula��es, felicita��es etc. ', '2', '0', 'E', null);
		$data[] = array('00.11.02.04', 'N', 'Eventos culturais', '2', '5', 'E', 'Pode ser juntado ao dossi�.');
		$data[] = array('00.11.02.05', 'N', 'Campanhas institucionais', '2', '5', 'E', 'Pode ser juntado ao dossi�.');
		$data[] = array('00.11.04', 'S', 'OUVIDORIA', null, null, null, null);
		$data[] = array('00.11.04.01', 'N', 'Ouvidoria externa', '5', '0', 'E', 'Caso gere processo, este ser� classificado pelo assunto.');
		$data[] = array('00.11.04.02', 'N', 'Ouvidoria interna ', '5', '0', 'E', 'Atendimento ao servidor / magistrado. Caso gere processo, este ser� classificado pelo assunto.');
		$data[] = array('00.12', 'S', 'HIGIENE E SEGURAN�A DO TRABALHO', null, null, null, null);
		$data[] = array('00.12.00.01', 'N', 'Higiene e Seguran�a do trabalho', '3', '0', 'G', null);
		$data[] = array('00.12.00.03', 'N', 'Preven��o de acidentes de trabalho - CIPA', '3', '0', 'G', null);
		$data[] = array('00.12.00.05', 'N', 'Ergonomia', '3', '0', 'G', null);
		$data[] = array('00.12.00.07', 'N', 'Combate a inc�ndio', '3', '0', 'G', null);
		$data[] = array('00.12.00.09', 'N', 'Vigil�ncia sanit�ria', '3', '0', 'G', null);
		$data[] = array('00.12.00.11', 'N', 'Inspe��es peri�dicas de sa�de ', '3', '0', 'G', null);
		$data[] = array('00.13', 'S', 'GEST�O DE PROJETOS ', null, null, null, null);
		$data[] = array('00.13.00.01', 'N', 'Portf�lio de Projetos', '3', '0', 'G', null);
		$data[] = array('10', 'S', 'OR�AMENTO E FINAN�AS', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF), este ser� de guarda permanente.');
		$data[] = array('10.01', 'S', 'SIAFI', null, null, null, null);
		$data[] = array('10.01.00.01', 'N', 'SIAFI', '2', '0', 'E', 'Controle  de acesso.');
		$data[] = array('10.02', 'S', 'PROGRAMA��O OR�AMENT�RIA E FINANCEIRA ', null, null, null, null);
		$data[] = array('10.02.00.01', 'N', 'Plano plurianual - PPA', '100', '0', 'G', 'Documenta��o referente � lei, inclusive propostas parciais e defini��o de metas.');
		$data[] = array('10.02.00.02', 'N', 'Lei de diretrizes or�ament�rias - LDO', '5', '0', 'E', 'Documenta��o referente � lei.');
		$data[] = array('10.03', 'S', 'LEI OR�AMENT�RIA ANUAL  - LOA', null, null, null, null);
		$data[] = array('10.03.00.01', 'N', 'Lei Or�ament�ria Anual - LOA', '100', '10', 'G', 'Documenta��o referente � lei, inclusive contigenciamento e descontigenciamento. ');
		$data[] = array('10.03.00.02', 'N', 'Reprograma��o or�ament�ria', '6', '0', 'E', null);
		$data[] = array('10.03.00.03', 'N', 'Altera��es no QDD - Notas de Dota��o', '1', '0', 'E', null);
		$data[] = array('10.03.00.04', 'N', 'Proposta or�ament�ria', '6', '0', 'E', null);
		$data[] = array('10.04', 'S', 'SOLICITA��O DE DOTA��O OR�AMENT�RIA', null, null, null, null);
		$data[] = array('10.04.00.01', 'N', 'Programa��o financeira de custeio e capital', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.02', 'N', 'Programa��o financeira de pessoal', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.03', 'N', 'Cr�dito suplementar, especial ou extraordin�rio.', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.04', 'N', 'Enquadramento da despesa', '100', '10', 'E', null);
		$data[] = array('10.04.00.05', 'N', 'Programa��o financeira de precat�rios', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.06', 'N', 'Programa��o financeira de RPVs', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.07', 'N', 'Programa��o Financeira para Contribui��o Patronal', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.08', 'N', 'Restitui��o de Receitas (arrecadadas por GRU)', '100', '10', 'E', null);
		$data[] = array('10.04.00.09', 'N', 'Programa��o financeira de pessoal (exerc�cios anteriores - DEA)', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.04.00.10', 'N', 'Programa��o Financeira de Senten�as Judiciais', '100', '10', 'E', 'Inclui solicita��o de dota��o or�ament�ria.');
		$data[] = array('10.05', 'S', 'EXECU��O OR�AMENT�RIA E FINANCEIRA', null, null, null, null);
		$data[] = array('10.05.00.01', 'N', 'Transfer�ncia or�ament�ria', '1', '0', 'E', null);
		$data[] = array('10.05.00.02', 'N', 'Transfer�ncia financeira ', '2', '0', 'E', 'Processo de pagamento relativos aos servi�os prestados por aut�nomos ou empresas mediante cess�o de m�o-de-obra ou empreitada, com reten��o de INSS ou declara��o de aut�nomo, dever�o ser preservados por 10 anos.');
		$data[] = array('10.05.00.03', 'N', 'Cronograma de desembolso', '1', '0', 'E', null);
		$data[] = array('10.05.00.04', 'N', 'Rela��o de Ordem Banc�ria', '100', '10', 'E', 'Inclusive Rela��o de Ordem Banc�ria Intra-SIAFI.');
		$data[] = array('10.05.00.05', 'N', 'Declara��o de Imposto de Renda na Fonte - DIRF', '0', '0', 'E', null);
		$data[] = array('10.05.00.06', 'N', 'Guia de Recolhimento do FGTS e Informa��es � Previd�ncia Social - GFIP', '5', '51', 'E', null);
		$data[] = array('10.05.00.07', 'N', 'Suprimento de fundos', '100', '10', 'E', 'Pode ser gerado um processo.');
		$data[] = array('10.05.00.08', 'N', 'Pagamento de tributos/impostos', '100', '10', 'E', null);
		$data[] = array('10.05.00.09', 'N', 'Empenho', '100', '0', 'E', null);
		$data[] = array('10.05.00.10', 'N', 'Conformidade de Gest�o', '100', '10', 'E', null);
		$data[] = array('10.05.00.11', 'N', 'Cr�dito suplementar, especial ou extraordin�rio.', '100', '10', 'E', null);
		$data[] = array('10.05.00.12', 'N', 'Encerramento do Exerc�cio', '100', '10', 'E', null);
		$data[] = array('10.05.00.13', 'N', 'Descentraliza��o Or�ament�ria', '100', '10', 'E', null);
		$data[] = array('10.05.00.14', 'N', 'Contingenciamento', '100', '10', 'E', null);
		$data[] = array('10.05.01', 'S', 'ARRECADA��O', null, null, null, null);
		$data[] = array('10.05.01.01', 'N', 'Valores restitu�dos a Justi�a Federal  ou ao Er�rio     ', '2', '0', 'E', null);
		$data[] = array('10.05.01.02', 'N', 'Guias de Recolhimento', '2', '0', 'E', 'Documento de Arrecada��o de Receitas Federais - DARF e avisos de dep�sito.');
		$data[] = array('10.05.01.03', 'N', 'Dados estat�sticos da arrecada��o', '2', '0', 'E', 'Pode ser eliminado ap�s transferido ao relat�rio anual. ');
		$data[] = array('10.06', 'S', 'CONTROLE OR�AMENT�RIO E FINANCEIRO', null, null, null, null);
		$data[] = array('10.06.00.01', 'N', 'Custos', '2', '0', 'E', null);
		$data[] = array('10.06.00.02', 'N', 'Dados Estat�sticos', '2', '0', 'E', 'Pode ser eliminado ap�s transferido ao relat�rio anual. ');
		$data[] = array('10.06.00.03', 'N', 'Rol de Respons�veis', '100', '10', 'E', null);
		$data[] = array('10.06.01', 'S', 'DEMONSTRATIVO FINANCEIRO', null, null, null, null);
		$data[] = array('10.06.01.01', 'N', 'Balancete Mensal', '100', '10', 'E', 'Or�ament�rio, f�sico-financeiro, patrimonial, compensado.');
		$data[] = array('10.06.01.02', 'N', 'Demonstrativo - Balan�o', '100', '10', 'E', 'Or�ament�rio, f�sico-financeiro, patrimonial, compensado.');
		$data[] = array('20', 'S', 'GEST�O DE PESSOAS', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF), este ser� de guarda permanente.');
		$data[] = array('20.01', 'S', 'QUADROS, TABELAS E POL�TICA DE PESSOAL', null, null, null, null);
		$data[] = array('20.01.01', 'S', 'CARGOS E FUN��ES', null, null, null, null);
		$data[] = array('20.01.01.01', 'N', 'Estudos e previs�o', '2', '0', 'G', 'O projeto ser� classificado na classe 00.');
		$data[] = array('20.01.01.02', 'N', 'Remunera��o', '2', '0', 'E', 'Enquadramento e tabelas.');
		$data[] = array('20.01.01.03', 'N', 'Classifica��o de cargos e fun��es', '100', '0', 'G', 'Uso pelo CJF.');
		$data[] = array('20.01.01.04', 'N', 'Atribui��es de cargos e fun��es', '100', '0', 'G', 'Uso pelo CJF.');
		$data[] = array('20.01.01.05', 'N', 'Cria��o de cargos e fun��es', '5', '0', 'G', null);
		$data[] = array('20.01.01.06', 'N', 'Controle e distribui��o de cargos providos e vagos', '100', '0', 'E', null);
		$data[] = array('20.01.01.07', 'N', 'Controle e distribui��o de fun��es comissionadas providas e vagas', '100', '0', 'E', null);
		$data[] = array('20.01.01.08', 'N', 'Acumula��o de cargos / proventos', '5', '51', 'E', null);
		$data[] = array('20.01.01.09', 'N', 'Transforma��o de cargo', '2', '0', 'G', null);
		$data[] = array('20.01.01.10', 'N', 'Carga hor�ria', '5', '51', 'E', null);
		$data[] = array('20.01.01.11', 'N', 'Transforma��o de fun��o comissionada', '2', '0', 'G', null);
		$data[] = array('20.02', 'S', 'INGRESSO E DESLIGAMENTO', null, null, null, null);
		$data[] = array('20.02.01', 'S', 'CONCURSO P�BLICO PARA A MAGISTRATURA FEDERAL', null, null, null, null);
		$data[] = array('20.02.01.01', 'N', 'Concurso p�blico para a magistratura', '100', '0', 'G', 'Dossi� do concurso.');
		$data[] = array('20.02.01.02', 'N', 'Inscri��o', '100', '0', 'E', 'Dossi�s dos candidatos aprovados ser�o inclu�dos nos assentamentos funcionais.');
		$data[] = array('20.02.01.03', 'N', 'Avalia��o escrita e oral', '100', '0', 'E', 'Prova de Ju�zes aprovados - Guarda Permanente.');
		$data[] = array('20.02.02', 'S', 'INGRESSO NA MAGISTRATURA PELO QUINTO CONSTITUCIONAL', null, null, null, null);
		$data[] = array('20.02.02.01', 'N', 'L�sta tr�plice para o quinto constitucional', '100', '0', 'G', null);
		$data[] = array('20.02.03', 'S', 'CONCURSO P�BLICO PARA O SERVI�O FEDERAL', null, null, null, null);
		$data[] = array('20.02.03.01', 'N', 'Concurso p�blico para servidor', '0', '0', 'G', 'Dossi� do concurso.');
		$data[] = array('20.02.03.02', 'N', 'Questionamentos e solicita��es', '100', '5', 'E', null);
		$data[] = array('20.02.03.03', 'N', 'Convoca��o de candidato aprovado em concurso p�blico', '0', '0', 'E', null);
		$data[] = array('20.02.03.04', 'N', 'Convoca��o de candidatos aprovados em outros concursos p�blicos', '100', '0', 'E', null);
		$data[] = array('20.02.03.05', 'N', 'Candidatos aprovados em concurso p�blico da Justi�a Federal solicitados por outro �rg�o', '100', '2', 'E', null);
		$data[] = array('20.02.03.06', 'N', 'Recursos de candidatos', '100', '5', 'E', null);
		$data[] = array('20.02.04', 'S', 'PROVIMENTO POR NOMEA��O, POSSE E EXERC�CIO', null, null, null, null);
		$data[] = array('20.02.04.01', 'N', 'Nomea��o de magistrados', '5', '51', 'E', null);
		$data[] = array('20.02.04.02', 'N', 'Nomea��o de servidor para cargo em comiss�o', '5', '51', 'E', null);
		$data[] = array('20.02.04.03', 'N', 'Nomea��o de servidor para cargo efetivo', '5', '51', 'E', null);
		$data[] = array('20.02.04.04', 'N', 'Compromisso com as atribui��es do cargo', '0', '0', 'G', 'Termo de posse para atestar compromisso.');
		$data[] = array('20.02.04.05', 'N', 'Efetivo exerc�cio', '2', '0', 'E', null);
		$data[] = array('20.02.04.06', 'N', 'Prazo para posse', '2', '0', 'E', null);
		$data[] = array('20.02.04.07', 'N', 'Exame pr�-admissional', '0', '0', 'G', null);
		$data[] = array('20.02.04.08', 'N', 'Incapacidade para ingressar no servi�o p�blico', '5', '0', 'G', null);
		$data[] = array('20.02.04.09', 'N', 'Candidatos portadores de defici�ncia', '100', '2', 'E', null);
		$data[] = array('20.02.05', 'S', 'OUTRAS FORMAS DE PROVIMENTO', null, null, null, null);
		$data[] = array('20.02.05.01', 'N', 'Promo��o de magistrados por antiguidade', '5', '0', 'G', null);
		$data[] = array('20.02.05.02', 'N', 'Promo��o de magistrados por merecimento', '5', '0', 'G', null);
		$data[] = array('20.02.05.03', 'N', 'Lista tr�plice para promo��o por merecimento', '100', '0', 'G', null);
		$data[] = array('20.02.05.04', 'N', 'Transfer�ncia de magistrados entre �rg�os', '5', '51', 'E', null);
		$data[] = array('20.02.05.05', 'N', 'Permuta de magistrados entre �rg�os', '5', '51', 'E', null);
		$data[] = array('20.02.05.06', 'N', 'Readapta��o de servidor no cargo efetivo', '5', '51', 'E', null);
		$data[] = array('20.02.05.07', 'N', 'Recondu��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.08', 'N', 'Reintegra��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.09', 'N', 'Revers�o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.10', 'N', 'Admiss�o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.11', 'N', 'Aproveitamento de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.12', 'N', 'Contrata��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.05.13', 'N', 'Transfer�ncia de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.06', 'S', 'DADOS E IDENTIFICA��O FUNCIONAIS', null, null, null, null);
		$data[] = array('20.02.06.01', 'N', 'Assentamento Funcional ', '100', '0', 'G', 'De uso restrito da Secretaria de Recursos Humanos.');
		$data[] = array('20.02.06.02', 'N', 'Dependentes', '100', '95', 'E', null);
		$data[] = array('20.02.06.03', 'N', 'Benefici�rio de pens�o', '100', '95', 'E', 'Inclus�o / exclus�o.');
		$data[] = array('20.02.06.04', 'N', 'Recadastramento de inativos e pensionistas', '2', '0', 'E', null);
		$data[] = array('20.02.06.05', 'N', 'Declara��o sobre servidor', '0', '0', 'E', 'Inclusive "nada consta", "hist�rico funcional".');
		$data[] = array('20.02.06.06', 'N', ' Documentos admissionais', '0', '0', 'G', 'Documentos obrigat�rios entregues no momento da posse em cargo ou fun��o. A declara��o de IR e bens ser� juntada no processo de nomea��o e exonera��o/vac�ncia.');
		$data[] = array('20.02.06.07', 'N', 'Comprovante de vota��o', '1', '0', 'E', 'Elei��o');
		$data[] = array('20.02.06.08', 'N', 'Tempo de servi�o', '100', '95', 'E', null);
		$data[] = array('20.02.06.09', 'N', 'Identifica��o funcional ', '5', '10', 'E', 'Carteira, crach�, identifica��o digital.');
		$data[] = array('20.02.06.10', 'N', 'Carteiras e crach�s recolhidos', '100', '0', 'E', 'A carteira ou crach� dever� ser destru�do');
		$data[] = array('20.02.06.11', 'N', 'Tempo de contribui��o', '100', '95', 'E', null);
		$data[] = array('20.02.07', 'S', 'VITALICIAMENTO E PROMO��O ', null, null, null, null);
		$data[] = array('20.02.07.01', 'N', 'Senten�a de ju�zes em per�odo de vitaliciamento', '100', '0', 'E', null);
		$data[] = array('20.02.07.02', 'N', 'Vitaliciamento de juiz federal substituto', '0', '0', 'G', null);
		$data[] = array('20.02.07.03', 'N', 'Desempenho dos servidores', '0', '0', 'G', 'Inclusive avalia��o e gest�o.');
		$data[] = array('20.02.07.04', 'N', 'Est�gio probat�rio', '5', '51', 'E', null);
		$data[] = array('20.02.07.05', 'N', 'Promo��o / Progress�o funcional de servidores', '0', '0', 'G', null);
		$data[] = array('20.02.08', 'S', 'INCENTIVOS FUNCIONAIS', null, null, null, null);
		$data[] = array('20.02.08.01', 'N', 'Premia��es e medalhas', '0', '0', 'G', null);
		$data[] = array('20.02.08.02', 'N', 'Honra ao m�rito, elogios, voto de louvor', '0', '0', 'G', null);
		$data[] = array('20.02.09', 'S', 'DESLIGAMENTO DE MAGISTRADO', null, null, null, null);
		$data[] = array('20.02.09.01', 'N', 'Demiss�o de magistrado', '10', '0', 'G', null);
		$data[] = array('20.02.09.02', 'N', 'Promo��o de magistrado', '10', '0', 'G', null);
		$data[] = array('20.02.09.03', 'N', 'Desligamento por aposentadoria', '10', '0', 'G', null);
		$data[] = array('20.02.09.04', 'N', 'Posse  de magistrado em outro cargo inacumul�vel', '10', '0', 'G', null);
		$data[] = array('20.02.09.05', 'N', 'Falecimento de magistrado', '0', '0', 'G', null);
		$data[] = array('20.02.10', 'S', 'VAC�NCIA DE CARGO P�BLICO', null, null, null, null);
		$data[] = array('20.02.10.01', 'N', 'Exonera��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.10.02', 'N', 'Demiss�o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.10.03', 'N', 'Vac�ncia por promo��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.10.04', 'N', 'Readapta��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.02.10.05', 'N', 'Vac�ncia por aposentadoria', '5', '51', 'E', null);
		$data[] = array('20.02.10.06', 'N', 'Posse de servidor em outro cargo inacumul�vel', '5', '51', 'E', null);
		$data[] = array('20.02.10.07', 'N', 'Falecimento de servidor', '5', '51', 'E', null);
		$data[] = array('20.03', 'S', 'MOVIMENTA��O', null, null, null, null);
		$data[] = array('20.03.01', 'S', 'LOTA��O DE SERVIDOR', null, null, null, null);
		$data[] = array('20.03.01.01', 'N', 'Controle de lota��o de servidores', '100', '0', 'E', 'Pode ser transferido para relat�rios estat�sticos.');
		$data[] = array('20.03.01.02', 'N', 'Lota��o de servidor', '5', '0', 'E', null);
		$data[] = array('20.03.01.03', 'N', 'Exerc�cio provis�rio', '100', '0', 'E', 'Licen�a para acompanhar c�njuge.');
		$data[] = array('20.03.02', 'S', 'MOVIMENTA��O E REMO��O', null, null, null, null);
		$data[] = array('20.03.02.01', 'N', 'Mudan�a de magistrado de turma ou vara', '5', '95', 'E', 'Inclusive Afastamento de magistrado em tr�nsito');
		$data[] = array('20.03.02.02', 'N', 'Remo��o', '5', '51', 'E', 'Inclusive remo��o compuls�ria. O dossi� do concurso de remo��o dever� ter guarda permanente.');
		$data[] = array('20.03.02.03', 'N', 'Redistribui��o de servidor', '5', '51', 'E', null);
		$data[] = array('20.03.02.04', 'N', 'Disponibilidade', '5', '51', 'E', null);
		$data[] = array('20.03.03', 'S', 'REQUISI��O DE PESSOAL. CESS�O', null, null, null, null);
		$data[] = array('20.03.03.01', 'N', 'Requisi��o de servidor', '5', '51', 'E', 'Inclusive solicita��o, prorroga��o.');
		$data[] = array('20.03.03.02', 'N', 'Cess�o de servidor', '5', '51', 'E', 'Inclusive solicita��o, prorroga��o');
		$data[] = array('20.03.04', 'S', 'DESIGNA��O, CONVOCA��O, SUBSTITUI��O E DISPENSA', null, null, null, null);
		$data[] = array('20.03.04.01', 'N', 'Designa��o de magistrados ', '5', '0', 'E', null);
		$data[] = array('20.03.04.02', 'N', 'Substitui��o de magistrados', '5', '0', 'E', null);
		$data[] = array('20.03.04.03', 'N', 'Convoca��o para outros �rg�os', '5', '0', 'E', null);
		$data[] = array('20.03.04.04', 'N', 'Designa��o de servidor para fun��o comissionada', '5', '0', 'E', null);
		$data[] = array('20.03.04.05', 'N', 'Substitui��o de servidor em cargo ou fun��o comissionada', '5', '0', 'E', null);
		$data[] = array('20.03.04.06', 'N', 'Dispensa de servidor da fun��o comissionada', '5', '0', 'E', null);
		$data[] = array('20.04', 'S', 'CAPACITA��O E APERFEI�OAMENTO ', null, null, null, null);
		$data[] = array('20.04.00.01', 'N', 'Comunica��o de participa��o de magistrado em curso / evento', '2', '0', 'E', null);
		$data[] = array('20.04.00.02', 'N', 'Programas de aperfei�oamento ', '2', '0', 'G', 'EMAGIS, LNC, PNA E PNC');
		$data[] = array('20.04.00.03', 'N', 'Trabalho de conclus�o / monografia', '0', '0', 'E', 'Quando solicitado pelo �rg�o.');
		$data[] = array('20.04.00.04', 'N', 'Eventos de capacita��o promovidos pela institui��o', '2', '0', 'G', 'Programa, relat�rio, rela��o de participantes.');
		$data[] = array('20.04.00.05', 'N', 'Participa��o de servidor / magistrado em cursos e eventos de treinamento, aperfei�oamento, etc.', '0', '0', 'E', 'Comprovante de participa��o.');
		$data[] = array('20.04.00.06', 'N', 'Eventos promovidos por outras institui��es', '5', '0', 'E', null);
		$data[] = array('20.05', 'S', 'VENCIMENTOS E REMUNERA��O', null, null, null, null);
		$data[] = array('20.05.00.01', 'N', 'D�bitos pendentes de magistrados e servidores com a Uni�o', '5', '51', 'E', null);
		$data[] = array('20.05.00.02', 'N', 'D�bitos da Uni�o com magistrados e servidores', '5', '51', 'E', null);
		$data[] = array('20.05.00.03', 'N', 'Decis�o judicial sobre sal�rios, vencimentos, proventos e remunera��es', '5', '51', 'E', null);
		$data[] = array('20.05.00.04', 'N', 'Reestrutura��o e altera��es salariais', '5', '0', 'G', null);
		$data[] = array('20.05.00.05', 'N', 'Diferen�as e reposi��es salariais', '5', '95', 'E', 'URV');
		$data[] = array('20.05.00.06', 'N', 'Sal�rio-fam�lia', '5', '51', 'E', 'Para os casos especiais previstos no Regime Jur�dico �nico, o prazo total de guarda para os documentos referentes � concess�o de sal�rio-fam�lia ser� de 100 anos.');
		$data[] = array('20.05.00.07', 'N', 'Teto Remunerat�rio Constitucional', '5', '51', 'E', 'Conf. Art. n� 37, XI, CF/88.');
		$data[] = array('20.05.00.08', 'N', 'Sal�rio de menor aprendiz', '100', '10', 'E', null);
		$data[] = array('20.05.01', 'S', 'DESCONTOS. CONSIGNA��ES', null, null, null, null);
		$data[] = array('20.05.01.01', 'N', 'Consigna��o em folha', '100', '2', 'E', 'Autoriza��o, altera��o, desist�ncia, quita��o, etc.');
		$data[] = array('20.05.01.02', 'N', 'Devolu��o de parcela remunerat�ria', '5', '51', 'E', 'Autoriza��o, altera��o, desist�ncia, quita��o, desconto em folha.');
		$data[] = array('20.05.01.03', 'N', 'Desconto em folha para falta n�o justificada', '5', '95', 'E', null);
		$data[] = array('20.05.02', 'S', 'CONTRIBUI��O SINDICAL DO SERVIDOR', null, null, null, null);
		$data[] = array('20.05.02.01', 'N', 'Contribui��o sindical do servidor', '5', '51', 'E', null);
		$data[] = array('20.05.03', 'S', 'CONTRIBUI��O � ENTIDADE DE CLASSE ', null, null, null, null);
		$data[] = array('20.05.03.01', 'N', 'Contribui��o � Entidade de Classe - magistrado', '5', '51', 'E', null);
		$data[] = array('20.05.04', 'S', 'CONTRIBUI��O PARA A SEGURIDADE SOCIAL', null, null, null, null);
		$data[] = array('20.05.04.01', 'N', 'Contribui��o para seguridade social', '5', '51', 'E', null);
		$data[] = array('20.05.05', 'S', 'IMPOSTO DE RENDA DE PESSOA F�SICA (IRPF)', null, null, null, null);
		$data[] = array('20.05.05.01', 'N', 'Comprovante Anual de Rendimentos para IRPF', '0', '0', 'E', null);
		$data[] = array('20.05.05.02', 'N', 'Declara��o de Ajuste Anual do Imposto de Renda de Pessoa F�sica', '7', '0', 'E', 'Inclusive Declara��o de Bens e Valores.');
		$data[] = array('20.05.06', 'S', 'PENS�O ALIMENT�CIA', null, null, null, null);
		$data[] = array('20.05.06.01', 'N', 'Pens�o aliment�cia', '5', '95', 'E', 'Inclusive decis�o judicial.');
		$data[] = array('20.05.07', 'S', 'ENCARGOS PATRONAIS. RECOLHIMENTOS', null, null, null, null);
		$data[] = array('20.05.07.01', 'N', 'PIS-Programa de Integra��o Social; PASEP-Programa de Forma��o do Patrim�nio do Servidor P�blico ', '5', '51', 'E', null);
		$data[] = array('20.05.07.02', 'N', 'Recolhimento da contribui��o sindical do empregado', '5', '51', 'E', null);
		$data[] = array('20.05.07.03', 'N', 'Contribui��o do empregador para o plano de seguridade social ', '5', '51', 'E', null);
		$data[] = array('20.05.07.04', 'N', 'Recolhimento do Imposto de renda', '5', '51', 'E', null);
		$data[] = array('20.05.07.05', 'N', 'Isen��o do Imposto de renda', '5', '51', 'E', null);
		$data[] = array('20.05.08', 'S', 'RESSARCIMENTOS E REEMBOLSOS', null, null, null, null);
		$data[] = array('20.05.08.01', 'N', 'Ressarcimento a magistrado / servidor', '100', '10', 'E', null);
		$data[] = array('20.05.08.02', 'N', 'Reembolso de despesas', '100', '10', 'E', null);
		$data[] = array('20.05.09', 'S', 'FOLHAS DE PAGAMENTO DE PESSOAL. FICHAS FINANCEIRAS', null, null, null, null);
		$data[] = array('20.05.09.01', 'N', 'Ficha financeira ', '2', '0', 'G', null);
		$data[] = array('20.05.09.02', 'N', 'Folha de pagamento', '5', '95', 'E', null);
		$data[] = array('20.05.09.03', 'N', 'Rubrica', '5', '0', 'G', 'Inclusive cria��o, altera��o, exclus�o. Para uso exclusivo pelo CJF.');
		$data[] = array('20.05.09.04', 'N', 'Rela��o Anual de Informa��es Sociais (RAIS)', '5', '10', 'E', null);
		$data[] = array('20.05.10', 'S', 'VANTAGENS  E INDENIZA��ES', null, null, null, null);
		$data[] = array('20.05.10.01', 'N', 'Indeniza��o por exonera��o de fun��o', '5', '95', 'E', null);
		$data[] = array('20.05.10.02', 'N', 'Indeniza��o de transporte', '5', '95', 'E', 'Uso de carro pr�prio por oficial de justi�a.');
		$data[] = array('20.05.10.03', 'N', 'Ajuda de custo para mudan�a de domic�lio', '100', '10', 'E', null);
		$data[] = array('20.05.10.04', 'N', 'Aux�lio-moradia', '100', '10', 'E', null);
		$data[] = array('20.05.10.05', 'N', 'Di�rias', '100', '10', 'E', null);
		$data[] = array('20.05.10.06', 'N', 'Viagem a servi�o com �nus', '100', '10', 'E', null);
		$data[] = array('20.05.10.07', 'N', 'Viagem a servi�o sem �nus', '5', '0', 'E', null);
		$data[] = array('20.05.10.08', 'N', 'Indeniza��o de f�rias', '5', '95', 'E', null);
		$data[] = array('20.05.11', 'S', 'GRATIFICA��ES E ADICIONAIS', null, null, null, null);
		$data[] = array('20.05.11.01', 'N', 'Gratifica��o por encargo de curso ou concurso', '5', '51', 'E', 'Instrutoria prestada por servidor / magistrado. Pode ser gerado um processo.');
		$data[] = array('20.05.11.02', 'N', 'Vantagens pessoais', '5', '51', 'E', 'VPNI, manuten��o, extin��o.');
		$data[] = array('20.05.11.03', 'N', 'Quintos e d�cimos', '5', '51', 'E', 'Cargos em comiss�o e de fun��o.');
		$data[] = array('20.05.11.04', 'N', 'Gratifica��o natalina (13� sal�rio)', '5', '51', 'E', null);
		$data[] = array('20.05.11.05', 'N', 'Gratifica��es relativas a Planos de Cargos', '5', '51', 'E', 'GEL, GRM, GAE, GAJ. Pode ser gerado um processo.  ');
		$data[] = array('20.05.11.06', 'N', 'Adicional por tempo de servi�o', '5', '51', 'E', 'Anu�nio - quinqu�nio');
		$data[] = array('20.05.11.07', 'N', 'Adicional noturno', '5', '51', 'E', null);
		$data[] = array('20.05.11.08', 'N', 'Adicional de periculosidade', '5', '51', 'E', null);
		$data[] = array('20.05.11.09', 'N', 'Adicional de insalubridade', '5', '51', 'E', null);
		$data[] = array('20.05.11.10', 'N', 'Adicional de atividades penosas', '5', '51', 'E', null);
		$data[] = array('20.05.11.11', 'N', 'Servi�o extraordin�rio', '5', '51', 'E', 'Horas extras de servidor');
		$data[] = array('20.05.11.12', 'N', 'Adicional de f�rias, abono pecuni�rio', '5', '51', 'E', null);
		$data[] = array('20.05.11.13', 'N', 'Adicional de qualifica��o - AQ', '5', '51', 'E', null);
		$data[] = array('20.06', 'S', 'AFASTAMENTOS', null, null, null, null);
		$data[] = array('20.06.00.01', 'N', 'Afastamento para estudo ou miss�o no exterior', '5', '51', 'E', null);
		$data[] = array('20.06.00.02', 'N', 'Afastamento de magistrado para frequ�ncia a cursos ou semin�rios de aperfei�oamento e estudos', '100', '95', 'E', null);
		$data[] = array('20.06.00.03', 'N', 'Afastamento de magistrado para presta��o de servi�os exclusivamente � Justi�a Eleitoral', '100', '95', 'E', null);
		$data[] = array('20.06.00.04', 'N', 'Afastamento de magistrado para presidir associa��o de classe', '100', '95', 'E', null);
		$data[] = array('20.06.00.05', 'N', 'Afastamento de dias trabalhados por magistrado a t�tulo de plant�o', '100', '95', 'E', null);
		$data[] = array('20.06.00.06', 'N', 'Afastamento por motivo de exerc�cio de mandato eletivo', '5', '51', 'E', null);
		$data[] = array('20.06.00.07', 'N', 'Afastamento para presta��o de depoimentos', '5', '51', 'E', null);
		$data[] = array('20.06.00.08', 'N', 'Afastamento para presta��o de assist�ncia como jurado', '5', '51', 'E', null);
		$data[] = array('20.06.00.09', 'N', 'Afastamento para participa��o em programa de P�s-Gradua��o Stricto Sensu no pa�s.', '5', '51', 'E', null);
		$data[] = array('20.06.00.10', 'N', 'Afastamento para servir a outro �rg�o ou entidade', '5', '51', 'E', null);
		$data[] = array('20.06.01', 'S', 'LICEN�AS ESPECIAIS', null, null, null, null);
		$data[] = array('20.06.01.01', 'N', 'Licen�a para trato de interesse particular', '5', '95', 'E', null);
		$data[] = array('20.06.01.02', 'N', 'Licen�a por doen�a em pessoa da fam�lia', '5', '95', 'E', null);
		$data[] = array('20.06.01.03', 'N', 'Licen�a para acompanhar c�njuge', '5', '95', 'E', null);
		$data[] = array('20.06.01.04', 'N', 'Licen�a para curso de forma��o', '5', '95', 'E', null);
		$data[] = array('20.06.01.05', 'N', 'Licen�a para capacita��o', '5', '95', 'E', null);
		$data[] = array('20.06.01.06', 'N', 'Licen�a para atividade pol�tica', '5', '95', 'E', null);
		$data[] = array('20.06.01.07', 'N', 'Licen�a para desempenho de mandato classista', '5', '95', 'E', null);
		$data[] = array('20.06.01.08', 'N', 'Licen�a-pr�mio por assiduidade', '5', '95', 'E', null);
		$data[] = array('20.06.01.09', 'N', 'Licen�a para servi�o militar', '5', '95', 'E', null);
		$data[] = array('20.06.02', 'S', 'CONCESS�O PARA AUSENTAR-SE DO SERVI�O ', null, null, null, null);
		$data[] = array('20.06.02.01', 'N', 'Aus�ncia ao servi�o por motivo de casamento', '5', '51', 'E', null);
		$data[] = array('20.06.02.02', 'N', 'Aus�ncia ao servi�o para doa��o de sangue', '5', '51', 'E', null);
		$data[] = array('20.06.02.03', 'N', 'Aus�ncia ao servi�o por motivo de falecimento de familiares ', '5', '51', 'E', null);
		$data[] = array('20.06.02.04', 'N', 'Hor�rio especial', '5', '51', 'E', null);
		$data[] = array('20.06.02.05', 'N', 'Aus�ncia ao servi�o para alistamento eleitoral', '5', '51', 'E', null);
		$data[] = array('20.07', 'S', 'REGIME DISCIPLINAR', null, null, null, null);
		$data[] = array('20.07.00.01', 'N', 'Investiga��o preliminar', '3', '0', 'G', null);
		$data[] = array('20.07.00.02', 'N', 'Apura��o de responsabilidades', '5', '0', 'G', null);
		$data[] = array('20.07.00.03', 'N', 'Sindic�ncia', '5', '0', 'G', null);
		$data[] = array('20.07.00.04', 'N', 'Justifica��o de conduta', '3', '0', 'G', null);
		$data[] = array('20.07.00.05', 'N', 'A��o disciplinar (PAD)', '5', '0', 'G', null);
		$data[] = array('20.07.00.06', 'N', 'Penas disciplinares', '5', '0', 'G', null);
		$data[] = array('20.07.00.07', 'N', 'Representa��o', '3', '0', 'G', null);
		$data[] = array('20.07.00.08', 'N', 'Den�ncia', '3', '0', 'G', null);
		$data[] = array('20.08', 'S', 'SEGURIDADE SOCIAL', null, null, null, null);
		$data[] = array('20.08.01', 'S', 'AUX�LIOS', null, null, null, null);
		$data[] = array('20.08.01.01', 'N', 'Aux�lio-natalidade', '100', '10', 'E', null);
		$data[] = array('20.08.01.02', 'N', 'Aux�lio-funeral', '100', '10', 'E', null);
		$data[] = array('20.08.01.03', 'N', 'Aux�lio-doen�a', '100', '10', 'E', null);
		$data[] = array('20.08.01.04', 'N', 'Aux�lio-reclus�o', '100', '10', 'E', null);
		$data[] = array('20.08.01.05', 'N', 'Aux�lio-acidente ', '100', '10', 'E', null);
		$data[] = array('20.08.01.06', 'N', 'Aux�lio-sa�de', '100', '10', 'E', null);
		$data[] = array('20.08.01.07', 'N', 'Assist�ncia pr�-escolar', '100', '10', 'E', null);
		$data[] = array('20.08.01.08', 'N', 'Aux�lio transporte', '100', '10', 'E', 'Vale-transporte');
		$data[] = array('20.08.01.09', 'N', 'Aux�lio alimenta��o', '100', '10', 'E', null);
		$data[] = array('20.08.02', 'S', 'LICEN�AS ', null, null, null, null);
		$data[] = array('20.08.02.01', 'N', 'Atestado m�dico ', '0', '0', 'G', null);
		$data[] = array('20.08.02.02', 'N', 'Licen�a por acidente em servi�o', '5', '95', 'E', null);
		$data[] = array('20.08.02.03', 'N', 'Licen�a � adotante', '5', '95', 'E', null);
		$data[] = array('20.08.02.04', 'N', 'Licen�a � gestante', '5', '95', 'E', null);
		$data[] = array('20.08.02.05', 'N', 'Licen�a-paternidade', '5', '95', 'E', null);
		$data[] = array('20.08.02.06', 'N', 'Licen�a para tratamento de sa�de', '5', '95', 'E', 'LTS');
		$data[] = array('20.08.03', 'S', 'APOSENTADORIA', null, null, null, null);
		$data[] = array('20.08.03.01', 'N', 'Aposentadoria por invalidez', '100', '95', 'E', null);
		$data[] = array('20.08.03.02', 'N', 'Aposentadoria compuls�ria', '100', '95', 'E', null);
		$data[] = array('20.08.03.03', 'N', 'Aposentadoria volunt�ria', '100', '95', 'E', null);
		$data[] = array('20.08.03.04', 'N', 'Abono de perman�ncia', '100', '95', 'E', null);
		$data[] = array('20.08.03.06', 'N', 'Revers�o de aposentadoria', '100', '95', 'E', null);
		$data[] = array('20.08.04', 'S', 'PENS�O', null, null, null, null);
		$data[] = array('20.08.04.01', 'N', 'Pens�o estatut�ria (concess�o, revis�o e altera��o)', '5', '95', 'E', 'Concess�o, revis�o, suspens�o.');
		$data[] = array('20.08.05', 'S', 'ASSIST�NCIA � SA�DE', null, null, null, null);
		$data[] = array('20.08.05.01', 'N', 'Assist�ncia � sa�de', '100', '10', 'E', 'M�dicos, dentistas, psic�logos, fonoaudi�logos, fisioterapeutas.');
		$data[] = array('20.08.05.02', 'N', 'Plano de sa�de', '100', '0', 'E', 'Inclus�o / exclus�o');
		$data[] = array('20.08.05.03', 'N', 'Tratamento de sa�de fora do domic�lio', '5', '51', 'E', null);
		$data[] = array('20.08.05.04', 'N', 'Credenciamento de profissionais e de estabelecimentos hospitalares', '100', '0', 'E', 'M�dicos, dentistas, psic�logos, fonoaudi�logos, fisioterapeutas.');
		$data[] = array('20.08.05.05', 'N', 'Prontu�rio m�dico ', '100', '0', 'G', null);
		$data[] = array('20.08.06', 'S', 'SERVI�O SOCIAL', null, null, null, 'Podem ser juntados aos prontu�rios m�dicos.');
		$data[] = array('20.08.06.01', 'N', 'Acompanhamento psicossocial', '5', '0', 'G', null);
		$data[] = array('20.08.06.02', 'N', 'Acompanhamento social', '5', '0', 'G', null);
		$data[] = array('20.08.06.03', 'N', 'Assist�ncia social', '5', '0', 'G', null);
		$data[] = array('20.09', 'S', 'SINDICATOS. ACORDOS. DISS�DIOS. ASSOCIA��ES', null, null, null, null);
		$data[] = array('20.09.00.01', 'N', 'Sindicatos. Acordos. Diss�dios', '5', '0', 'G', null);
		$data[] = array('20.09.00.02', 'N', 'Associa��es', '5', '0', 'G', null);
		$data[] = array('20.09.00.03', 'N', 'Movimentos reivindicat�rios', '5', '0', 'G', 'Greves, paralisa��es.');
		$data[] = array('20.10', 'S', 'FREQU�NCIA E F�RIAS', null, null, null, null);
		$data[] = array('20.10.00.01', 'N', 'Afastamento por motivo de suspens�o de contrato de trabalho (CLT)', '5', '51', 'E', null);
		$data[] = array('20.10.00.02', 'N', 'Convoca��o para o TRE', '5', '51', 'E', 'Presta��o de servi�o eleitoral');
		$data[] = array('20.10.00.03', 'N', 'Compensa��o de dias trabalhados para a justi�a eleitoral', '5', '51', 'E', null);
		$data[] = array('20.10.00.04', 'N', 'Frequ�ncia', '5', '51', 'E', 'Livro de ponto, folha de ponto e boletim de frequ�ncia. Todos os documentos citados devem ser preservados pelo prazo previsto na tabela de 56 anos.');
		$data[] = array('20.10.00.05', 'N', 'Plant�o', '2', '0', 'E', 'Convoca��o, compensa��o, controle.');
		$data[] = array('20.10.00.06', 'N', 'Recesso', '2', '0', 'E', 'Convoca��o, compensa��o, controle.');
		$data[] = array('20.10.00.07', 'N', 'Convoca��o para atuar em Turma Especial', '2', '0', 'E', null);
		$data[] = array('20.10.00.08', 'N', 'Convoca��o para atuar em Regime de Exce��o - Mutir�o', '2', '0', 'E', null);
		$data[] = array('20.10.00.09', 'N', 'F�rias', '7', '0', 'E', 'Escala, marca��o, adiamento, cancelamento.');
		$data[] = array('20.11', 'S', 'EST�GIOS', null, null, null, null);
		$data[] = array('20.11.00.01', 'N', 'Termo de compromisso de est�gio', '100', '3', 'E', null);
		$data[] = array('20.11.00.02', 'N', 'Frequ�ncia de estagi�rios', '5', '0', 'E', null);
		$data[] = array('20.11.00.03', 'N', 'Pagamento da bolsa-est�gio', '100', '10', 'E', null);
		$data[] = array('20.11.00.04', 'N', 'Declara��o de est�gio', '0', '0', 'E', null);
		$data[] = array('20.11.00.05', 'N', 'Sele��o de estagi�rio', '3', '0', 'E', null);
		$data[] = array('20.11.00.06', 'N', 'Contrata��o e acompanhamento de est�gio', '3', '0', 'E', null);
		$data[] = array('30', 'S', 'ADMINISTRA��O DE BENS, MATERIAIS E SERVI�OS    ', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF), este ser� de guarda permanente.');
		$data[] = array('30.01', 'S', 'ACOMPANHAMENTO DE LICITA��ES E CONTRATA��ES', null, null, null, null);
		$data[] = array('30.01.01', 'S', 'ACOMPANHAMENTO DE LICITA��ES', null, null, null, 'O processo deve ser classificado pelo c�digo do assunto de que trata a licita��o / contrata��o. ');
		$data[] = array('30.01.01.01', 'N', 'Coleta de dados e acompanhamento das licita��es', '100', '0', 'E', 'Inclusive an�lise da conformidade jur�dica de atos administrativos.');
		$data[] = array('30.01.01.02', 'N', 'Coleta de pre�os de servi�os / materiais', '100', '0', 'E', null);
		$data[] = array('30.01.01.03', 'N', 'Licita��o', '100', '0', 'E', 'Processo de contrata��o. ');
		$data[] = array('30.01.01.04', 'N', 'Julgamento de proposta ', '100', '0', 'E', null);
		$data[] = array('30.01.01.05', 'N', 'Aviso de julgamento de licita��o, adjudica��o e de homologa��o', '100', '0', 'E', null);
		$data[] = array('30.01.01.06', 'N', 'Recursos da decis�o', '100', '0', 'E', 'Inclusive de licita��o/preg�o.');
		$data[] = array('30.01.01.07', 'N', 'Julgamento dos recursos', '100', '0', 'E', 'Inclusive de licita��o/preg�o.');
		$data[] = array('30.01.01.08', 'N', 'Entrega de edital �s empresas interessadas', '100', '0', 'E', null);
		$data[] = array('30.01.01.09', 'N', 'Pre�os de itens ofertados', '100', '0', 'E', null);
		$data[] = array('30.01.01.10', 'N', 'Esclarecimentos sobre edital', '100', '0', 'E', null);
		$data[] = array('30.01.01.11', 'N', 'Cadastramento de fornecedores', '3', '0', 'E', null);
		$data[] = array('30.01.01.12', 'N', 'Capacidade t�cnica ', '0', '0', 'E', null);
		$data[] = array('30.01.01.13', 'N', 'Informa��o sobre produtos e servi�os', '0', '0', 'E', null);
		$data[] = array('30.01.02', 'S', 'ACOMPANHAMENTO DE CONTRATA��ES', null, null, null, 'O processo deve ser classificado pelo c�digo do assunto de que trata a licita��o / contrata��o.');
		$data[] = array('30.01.02.01', 'N', 'Altera��o / renegocia��o de cl�usulas contratuais', '100', '0', 'E', 'Aditamento / prorroga��o / repactua��o contratual / reajuste de pre�os.');
		$data[] = array('30.01.02.02', 'N', 'Acompanhamento contratual ', '100', '0', 'E', 'Procedimentos diversos pertinentes � execu��o do contrato - assinatura, informa��o, solicita��o, inclusive an�lise de conformidade jur�dica em todas as fases contratuais at� o arquivamento do processo.');
		$data[] = array('30.01.02.03', 'N', 'An�lise e confer�ncia de documento de cobran�a.', '100', '0', 'E', null);
		$data[] = array('30.01.02.04', 'N', 'Planilha de reajuste de pre�o', '100', '0', 'E', null);
		$data[] = array('30.01.02.05', 'N', 'Documentos gerais relativos � cobran�a / planilhas de custo, � regularidade fiscal / previdenci�ria', '100', '0', 'E', 'Folha de pagamento, FGTS, INSS.');
		$data[] = array('30.01.02.06', 'N', 'Avalia��o de servi�os prestados', '5', '0', 'E', null);
		$data[] = array('30.01.02.07', 'N', 'Nota fiscal ', '100', '0', 'E', null);
		$data[] = array('30.01.03', 'S', 'PENALIDADES CONTRATUAIS', null, null, null, null);
		$data[] = array('30.01.03.01', 'N', 'An�lise, comunica��o, solicita��o de aplica��o de san��es', '100', '0', 'E', null);
		$data[] = array('30.01.03.02', 'N', 'Rescis�o Contratual', '100', '0', 'E', null);
		$data[] = array('30.02', 'S', 'OBRAS E SERVI�OS', null, null, null, null);
		$data[] = array('30.02.01', 'S', 'OBRAS', null, null, null, 'Verificar projeto b�sico e/ou executivo. Se n�o enquadrado no inciso I, art. 6� da Lei n� 8.666/93 (obra), classificar no 30.02.02.00 ou 30.02.05.00.');
		$data[] = array('30.02.01.01', 'N', 'Projeto arquitet�nico', '0', '0', 'G', 'O projeto original, o executivo e os complementares devem ser de guarda permanente.');
		$data[] = array('30.02.01.02', 'N', 'Projeto "as built" (conforme constru�do)', '100', '2', 'E', 'O documento original (aprovado) dever� ser de guarda permanente.');
		$data[] = array('30.02.01.08', 'N', 'Execu��o de obras', '100', '10', 'G', null);
		$data[] = array('30.02.01.09', 'N', 'Plano de obras', '100', '10', 'G', null);
		$data[] = array('30.02.01.10', 'N', 'Moderniza��o de instala��es', '100', '10', 'G', null);
		$data[] = array('30.02.02', 'S', 'CONTRATA��O DE SERVI�OS', null, null, null, 'Inclusive servi�os de manuten��o e conserva��o contratados.');
		$data[] = array('30.02.02.01', 'N', 'Contrata��o / pagamento de  servi�os (exceto magistrado e servidor) ', '100', '10', 'E', null);
		$data[] = array('30.02.05', 'S', 'SERVI�OS DE MANUTEN��O E CONSERVA��O EXECUTADOS NO �RG�O', null, null, null, 'Elevador, ar condicionado, subesta��es e gerador, limpeza, vistoria.');
		$data[] = array('30.02.05.06', 'N', 'Manuten��o', '100', '10', 'E', null);
		$data[] = array('30.02.05.07', 'N', 'Conserva��o ', '100', '10', 'E', null);
		$data[] = array('30.02.07', 'S', 'MUDAN�AS', null, null, null, null);
		$data[] = array('30.02.07.01', 'N', 'Para outros im�veis', '100', '10', 'E', null);
		$data[] = array('30.02.07.02', 'N', 'Dentro do mesmo im�vel', '100', '10', 'E', null);
		$data[] = array('30.03', 'S', 'SEGURAN�A', null, null, null, 'Os documentos que n�o envolvem pagamentos ser�o eliminados ap�s 2 anos.');
		$data[] = array('30.03.00.01', 'N', 'Transporte para Magistrados/servidores', '2', '0', 'E', null);
		$data[] = array('30.03.00.02', 'N', 'Contrata��o de servi�os de vigil�ncia', '100', '10', 'E', null);
		$data[] = array('30.03.00.03', 'N', 'Registro de ocorr�ncias  / ronda', '2', '0', 'E', 'Caso ocorra "sinistro", abrir processo de sindic�ncia.');
		$data[] = array('30.03.00.04', 'N', 'Controle de chaves em geral ', '2', '0', 'E', null);
		$data[] = array('30.03.00.05', 'N', 'Porte de arma de fogo', '100', '10', 'E', null);
		$data[] = array('30.03.00.06', 'N', 'Controle de entrada/sa�da de ve�culos de garagem', '2', '0', 'E', null);
		$data[] = array('30.03.00.07', 'N', 'Utiliza��o de vaga na garagem', '2', '0', 'E', null);
		$data[] = array('30.03.00.08', 'N', 'Sinistro', '100', '0', 'G', null);
		$data[] = array('30.03.00.09', 'N', 'Inspe��es peri�dicas de preven��o de inc�ndio', '4', '0', 'E', null);
		$data[] = array('30.03.00.10', 'N', 'Contrata��o de seguros', '100', '10', 'E', null);
		$data[] = array('30.03.01', 'S', 'USO DE DEPEND�NCIAS ', null, null, null, null);
		$data[] = array('30.03.01.01', 'N', 'Entrada/sa�da de pessoas - controle de portaria', '4', '0', 'E', null);
		$data[] = array('30.03.01.02', 'N', 'Entrada fora do hor�rio de expediente', '4', '0', 'E', null);
		$data[] = array('30.03.01.03', 'N', 'Uso das depend�ncias (Controle)', '2', '0', 'E', null);
		$data[] = array('30.03.01.04', 'N', 'Utiliza��o das depend�ncias para outros fins', '4', '0', 'E', null);
		$data[] = array('30.03.01.05', 'N', 'Uso extraordin�rio de depend�ncias (acionamento de sistemas, ar condicionado e outros) ', '2', '0', 'E', null);
		$data[] = array('30.04', 'S', 'ADMINISTRA��O DE BENS M�VEIS ', null, null, null, null);
		$data[] = array('30.04.01', 'S', 'EXTRAVIO. ROUBO. DESAPARECIMENTO DE MATERIAL', null, null, null, null);
		$data[] = array('30.04.01.01', 'N', 'Comunica��o de ocorr�ncia ', '2', '0', 'E', null);
		$data[] = array('30.04.02', 'S', 'TRANSPORTE  E MOVIMENTA��O DE MATERIAL', null, null, null, null);
		$data[] = array('30.04.02.01', 'N', 'Controle de movimenta��o de material', '2', '0', 'E', null);
		$data[] = array('30.04.02.02', 'N', 'Recolhimento de material ao dep�sito', '2', '0', 'E', null);
		$data[] = array('30.04.02.03', 'N', 'Relat�rio de movimenta��o de bens m�veis (RMBM)  ', '100', '10', 'E', null);
		$data[] = array('30.04.03', 'S', 'ADMINISTRA��O E USO DE VE�CULOS', null, null, null, null);
		$data[] = array('30.04.03.01', 'N', 'Controle de combust�vel', '1', '0', 'E', 'Requisi��o, fornecimento.');
		$data[] = array('30.04.03.02', 'N', 'Manuten��o e conserva��o de ve�culos', '100', '10', 'E', null);
		$data[] = array('30.04.03.03', 'N', 'Licenciamentos, acidentes, infra��es, multas e pagamentos', '100', '10', 'E', 'Pode ser gerado um processo. Acidentes envolvendo servidor, classificar como processo de apura��o de responsabilidade, sob o c�digo 20.07.00.02.');
		$data[] = array('30.04.03.04', 'N', 'Controle de uso do ve�culo', '2', '0', 'E', null);
		$data[] = array('30.04.03.05', 'N', 'Licenciamento de Ve�culos', '2', '0', 'E', 'documento IPVA, DPVAT');
		$data[] = array('30.04.03.06', 'N', 'Aquisi��o de ve�culos', '100', '10', 'E', null);
		$data[] = array('30.04.03.07', 'N', 'Plano anual de aquisi��o de ve�culos', '100', '10', 'G', null);
		$data[] = array('30.04.04', 'S', ' MATERIAL PERMANENTE', null, null, null, null);
		$data[] = array('30.04.04.01', 'N', 'Empr�stimo de material permanente  ', '100', '0', 'E', 'N�o se aplica a empr�stimo de acervo bibliogr�fico, que deve ser classificado na 40.01.01.03.');
		$data[] = array('30.04.04.02', 'N', 'Tombamento ', '100', '0', 'E', null);
		$data[] = array('30.04.04.03', 'N', 'Responsabilidade sobre guarda de material permanente', '3', '0', 'E', null);
		$data[] = array('30.04.04.04', 'N', 'Solicita��o de bem por transfer�ncia  ', '3', '0', 'E', null);
		$data[] = array('30.04.04.05', 'N', 'Enquadramento cont�bil', '100', '0', 'E', null);
		$data[] = array('30.04.04.06', 'N', 'Reavalia��o, redu��o a valor recuper�vel, deprecia��o, amortiza��o e exaust�o', '100', '0', 'E', null);
		$data[] = array('30.04.05', 'S', ' AQUISI��O DE MATERIAL PERMANENTE', null, null, null, 'Os documentos referentes � material n�o adquirido dever�o ser eliminados ap�s dois anos no arquivo corrente.');
		$data[] = array('30.04.05.01', 'N', 'Aquisi��o de material permanente por compra / pagamento', '100', '100', 'E', 'Se o bem se deteriorar antes do julgamento das contas, utilizar o prazo Julgamento TCU mais 10 anos.  ');
		$data[] = array('30.04.05.02', 'N', 'Aquisi��o de material permanente  por cess�o', '5', '100', 'E', null);
		$data[] = array('30.04.05.03', 'N', 'Aquisi��o de material permanente  por doa��o ', '5', '100', 'E', null);
		$data[] = array('30.04.05.04', 'N', 'Aquisi��o de material permanente  por permuta ', '5', '100', 'E', null);
		$data[] = array('30.04.05.05', 'N', 'Aquisi��o de material permanente por da��o  ', '5', '100', 'E', null);
		$data[] = array('30.04.06', 'S', 'ALUGUEL. COMODATO. LEASING', null, null, null, null);
		$data[] = array('30.04.06.01', 'N', 'Contrata��o / pagamento de aluguel, comodato, leasing de material permanente', '100', '10', 'E', null);
		$data[] = array('30.04.07', 'S', 'INVENT�RIO DE MATERIAL PERMANENTE', null, null, null, null);
		$data[] = array('30.04.07.01', 'N', 'Invent�rio anual de material permanente', '100', '0', 'G', null);
		$data[] = array('30.04.08', 'S', 'DESFAZIMENTO DE MATERIAL PERMANENTE', null, null, null, null);
		$data[] = array('30.04.08.01', 'N', 'Cess�o de material permanente  ', '5', '0', 'G', null);
		$data[] = array('30.04.08.02', 'N', 'Aliena��o por doa��o de material permanente  ', '5', '0', 'G', null);
		$data[] = array('30.04.08.03', 'N', 'Aliena��o por permuta de material permanente  ', '5', '0', 'G', null);
		$data[] = array('30.04.08.04', 'N', 'Aliena��o de material permanente por da��o em pagamento ', '5', '0', 'G', null);
		$data[] = array('30.04.08.05', 'N', 'Aliena��o por venda de material permanente', '5', '0', 'G', null);
		$data[] = array('30.04.08.06', 'N', 'Inutiliza��o de material permanente', '5', '0', 'G', null);
		$data[] = array('30.04.09', 'S', 'MATERIAL DE CONSUMO ', null, null, null, 'Os documentos referentes � material n�o adquirido dever�o ser eliminados ap�s dois anos no arquivo corrente.');
		$data[] = array('30.04.09.01', 'N', 'Aquisi��o de material de consumo por compra / pagamento', '100', '10', 'E', null);
		$data[] = array('30.04.09.02', 'N', 'Aquisi��o de material de consumo por cess�o  ', '100', '10', 'E', null);
		$data[] = array('30.04.09.03', 'N', 'Aquisi��o de material de consumo por doa��o ', '100', '10', 'E', null);
		$data[] = array('30.04.09.04', 'N', 'Aquisi��o de material de consumo por permuta', '100', '10', 'E', null);
		$data[] = array('30.04.09.05', 'N', 'Aquisi��o de material de consumo por da��o em pagamento ', '100', '10', 'E', null);
		$data[] = array('30.04.09.06', 'N', 'Produ��o interna de material de consumo', '100', '10', 'E', null);
		$data[] = array('30.04.09.07', 'N', 'Requisi��o / entrega de material ', '1', '0', 'E', 'Dados transferidos para a estat�stica.');
		$data[] = array('30.04.09.08', 'N', 'Transfer�ncia de material de consumo  ', '100', '10', 'E', null);
		$data[] = array('30.04.10', 'S', 'INVENT�RIO DE MATERIAL DE CONSUMO', null, null, null, null);
		$data[] = array('30.04.10.01', 'N', 'Controle de estoque e almoxarifado ', '2', '0', 'E', null);
		$data[] = array('30.04.10.02', 'N', 'Invent�rio anual de material de consumo', '100', '10', 'E', null);
		$data[] = array('30.04.11', 'S', 'DESFAZIMENTO DE MATERIAL DE CONSUMO', null, null, null, null);
		$data[] = array('30.04.11.01', 'N', 'Cess�o de material de consumo', '5', '0', 'G', null);
		$data[] = array('30.04.11.02', 'N', 'Aliena��o de material consumo por doa��o', '5', '0', 'G', null);
		$data[] = array('30.04.11.03', 'N', 'Aliena��o de material consumo por permuta', '5', '0', 'G', null);
		$data[] = array('30.04.11.04', 'N', 'Aliena��o de material consumo  por da��o em pagamento ', '5', '0', 'G', null);
		$data[] = array('30.04.11.05', 'N', 'Aliena��o de material consumo por venda', '5', '0', 'G', null);
		$data[] = array('30.04.11.06', 'N', 'Inutiliza��o de material consumo', '5', '0', 'G', null);
		$data[] = array('30.05', 'S', 'BENS IM�VEIS', null, null, null, null);
		$data[] = array('30.05.01', 'S', 'AQUISI��O DE IM�VEIS', null, null, null, 'O processo de aquisi��o de im�veis � feito pela Secretaria de Patrim�nio da Uni�o.');
		$data[] = array('30.05.01.01', 'N', 'Aquisi��o de im�veis por compra', '100', '0', 'G', null);
		$data[] = array('30.05.01.02', 'N', 'Aquisi��o de im�veis por cess�o', '100', '0', 'G', null);
		$data[] = array('30.05.01.03', 'N', 'Aquisi��o de im�veis por doa��o', '100', '0', 'G', null);
		$data[] = array('30.05.01.04', 'N', 'Aquisi��o de im�veis por permuta', '100', '0', 'G', null);
		$data[] = array('30.05.02', 'S', 'ADMINISTRA��O DE IM�VEIS   ', null, null, null, null);
		$data[] = array('30.05.02.01', 'N', 'Aluguel de im�veis', '100', '10', 'E', 'Caso a vig�ncia do contrato de loca��o seja menor que o julgamento do TCU, utilizar o prazo Julgamento TCU mais 10 anos.');
		$data[] = array('30.05.02.02', 'N', 'Aquisi��o, controle e administra��o da ocupa��o de im�veis funcionais', '100', '0', 'G', null);
		$data[] = array('30.05.02.03', 'N', 'Ocupa��o de im�veis funcionais pr�prios da Uni�o, estados e munic�pios ', '100', '0', 'G', null);
		$data[] = array('30.05.03', 'S', 'DESPESAS CONDOMINIAIS', null, null, null, null);
		$data[] = array('30.05.03.01', 'N', 'Contas de �gua e esgoto', '100', '10', 'E', null);
		$data[] = array('30.05.03.02', 'N', 'Contas de g�s', '100', '10', 'E', null);
		$data[] = array('30.05.03.03', 'N', 'Contas de energia el�trica', '100', '10', 'E', null);
		$data[] = array('30.05.03.04', 'N', 'Conta de condom�nio', '100', '10', 'E', null);
		$data[] = array('30.05.04', 'S', 'ALIENA��O DE IM�VEIS', null, null, null, 'Para transa��es que envolvam pagamento de despesas pendentes utilizar prazos dos documentos financeiros (Julgamento TCU mais 10 anos e Guarda Permanente).');
		$data[] = array('30.05.04.01', 'N', 'Aliena��o de im�veis por venda', '100', '0', 'G', null);
		$data[] = array('30.05.04.02', 'N', 'Aliena��o de im�veis por cess�o', '100', '0', 'G', null);
		$data[] = array('30.05.04.03', 'N', 'Aliena��o de im�veis por doa��o', '100', '0', 'G', null);
		$data[] = array('30.05.04.04', 'N', 'Aliena��o de im�veis por permuta', '100', '0', 'G', null);
		$data[] = array('30.05.05', 'S', 'DESAPROPRIA��O. REINTEGRA��O DE POSSE. REIVINDICA��O DE DOM�NIO. TOMBAMENTO ', null, null, null, null);
		$data[] = array('30.05.05.01', 'N', 'Desapropria��o, reintegra��o de posse, reivindica��o de dom�nio e de tombamento de im�veis.', '100', '10', 'G', null);
		$data[] = array('30.05.06', 'S', 'INVENT�RIO DE BENS IM�VEIS', null, null, null, null);
		$data[] = array('30.05.06.01', 'N', 'Invent�rio de bens im�veis', '100', '0', 'G', 'Inclusive im�veis pr�prios');
		$data[] = array('40', 'S', 'GEST�O DA DOCUMENTA��O E INFORMA��O', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF), este ser� de guarda permanente.');
		$data[] = array('40.01', 'S', 'POL�TICAS DE ACERVO', null, null, null, null);
		$data[] = array('40.01.00.01', 'N', 'Pol�tica de Seguran�a da informa��o', '2', '0', 'G', null);
		$data[] = array('40.01.00.02', 'N', 'Controle terminol�gico', '100', '0', 'G', 'Uso pelo CJF');
		$data[] = array('40.01.00.03', 'N', 'Classifica��o da informa��o ', '5', '0', 'G', null);
		$data[] = array('40.01.01', 'S', 'POL�TICA DE ACESSO � INFORMA��O ', null, null, null, 'Dados transferidos para estat�stica e para relat�rios.');
		$data[] = array('40.01.01.01', 'N', 'Pol�tica de acesso aos documentos e informa��es', '5', '0', 'G', null);
		$data[] = array('40.01.01.02', 'N', 'Solicita��o de pesquisas e informa��es', '1', '0', 'E', null);
		$data[] = array('40.01.01.03', 'N', 'Empr�stimo de acervo ', '0', '0', 'E', null);
		$data[] = array('40.01.01.04', 'N', 'Desarquivamento de documentos/processos administrativos', '2', '3', 'E', null);
		$data[] = array('40.01.01.05', 'N', 'Servi�o de informa��o ao cidad�o', '2', '0', 'E', null);
		$data[] = array('40.01.02', 'S', 'CONSERVA��O E RESTAURA��O DO ACERVO', null, null, null, null);
		$data[] = array('40.01.02.01', 'N', 'Conserva��o e restaura��o do acervo', '3', '0', 'G', 'Inclusive relat�rios de condi��es ambientais.');
		$data[] = array('40.02', 'S', 'DOCUMENTA��O BIBLIOGR�FICA', null, null, null, null);
		$data[] = array('40.02.00.01', 'N', 'Sele��o de material bibliogr�fico', '2', '0', 'E', 'Os documentos da aquisi��o ser�o classificados na classe 30.');
		$data[] = array('40.02.01', 'S', 'PROCESSAMENTO T�CNICO', null, null, null, 'Registro, cataloga��o, classifica��o, indexa��o.');
		$data[] = array('40.02.01.01', 'N', 'Ficha de descri��o', '100', '0', 'E', null);
		$data[] = array('40.02.02', 'S', 'BIBLIOTECA VIRTUAL', null, null, null, null);
		$data[] = array('40.02.02.01', 'N', 'Biblioteca virtual', '2', '0', 'G', 'Planejamento, desenvolvimento, gerenciamento, conv�nio.');
		$data[] = array('40.03', 'S', 'SISTEMA DE ARQUIVOS E CONTROLE DE DOCUMENTOS', null, null, null, null);
		$data[] = array('40.03.01', 'S', 'PRODU��O DE DOCUMENTOS : LEVANTAMENTO, DIAGN�STICO E CONTROLE DE FLUXO', null, null, null, null);
		$data[] = array('40.03.01.01', 'N', 'Estudo sobre produ��o de documentos', '5', '5', 'G', null);
		$data[] = array('40.03.02', 'S', 'PROTOCOLO E ARQUIVAMENTO: RECEP��O,  AUTUA��O, TRAMITA��O E EXPEDI��O DE DOCUMENTOS e PROCESSOS ADMINISTRATIVOS', null, null, null, null);
		$data[] = array('40.03.02.01', 'N', 'Tramita��o de documentos e de processos administrativos', '2', '0', 'E', 'A tramita��o pode se dar por meio de of�cios, guias,  livros, etc. O documento encaminhado deve ser classificado pelo assunto espec�fico.');
		$data[] = array('40.03.02.02', 'N', 'Autua��o de  processo administrativo', '3', '0', 'E', 'Livros ou fichas usadas anteriormente a exist�ncia de sistemas informatizados s�o pass�veis de avalia��o hist�rica. ');
		$data[] = array('40.03.03', 'S', 'CLASSIFICA��O E DESTINA��O', null, null, null, null);
		$data[] = array('40.03.03.01', 'N', 'Instrumentos do programa de gest�o documental ', '100', '0', 'G', 'Uso exclusivo do CJF (gest�o das tabelas TUA, TUC, TUMP, PCTT, SIGLAS JUDICI�RIAS).');
		$data[] = array('40.03.04', 'S', 'AN�LISE. AVALIA��O. SELE��O DOCUMENTAL', null, null, null, null);
		$data[] = array('40.03.04.01', 'N', 'Descarte de documentos / processos ', '5', '0', 'G', null);
		$data[] = array('40.03.04.02', 'N', 'Microfilmagem', '5', '0', 'G', 'Projetos e estudos para substitui��o de suporte e preserva��o.');
		$data[] = array('40.03.04.03', 'N', 'Digitaliza��o', '5', '0', 'G', 'Projetos e estudos para substitui��o de suporte e preserva��o.');
		$data[] = array('40.04', 'S', 'MEM�RIA INSTITUCIONAL', null, null, null, null);
		$data[] = array('40.04.00.01', 'N', 'Pe�as museol�gicas', '0', '0', 'E', null);
		$data[] = array('40.04.00.02', 'N', 'Registro audiovisual etc.', '2', '0', 'G', null);
		$data[] = array('40.04.00.03', 'N', 'Hist�ria oral', '100', '0', 'G', null);
		$data[] = array('40.04.00.04', 'N', 'Registros de mem�ria institucional  ', '2', '0', 'G', null);
		$data[] = array('40.05', 'S', 'JURISPRUD�NCIA', null, null, null, null);
		$data[] = array('40.05.01', 'S', 'AC�RD�OS. AN�LISE. DESCRI��O. INDEXA��O. PESQUISA', null, null, null, 'A sele��o de ac�rd�os para publica��o ser� classificada no c�digo 90.07.00.01.');
		$data[] = array('40.05.01.01', 'N', 'An�lise e Indexa��o de jurisprud�ncia ', '100', '0', 'E', null);
		$data[] = array('40.05.01.04', 'N', 'Pesquisa de jurisprud�ncia', '1', '0', 'E', 'Dados transferidos para a estat�stica.');
		$data[] = array('40.05.02', 'S', 'S�MULA. ENUNCIADO ', null, null, null, null);
		$data[] = array('40.05.02.01', 'N', 'S�mula. Enunciado ', '2', '0', 'G', null);
		$data[] = array('40.05.03', 'S', 'REPOSIT�RIO OFICIAL', null, null, null, null);
		$data[] = array('40.05.03.01', 'N', 'Remessa de publica��es aos reposit�rios oficiais', '1', '0', 'E', null);
		$data[] = array('40.05.03.02', 'N', 'Reposit�rio oficial', '2', '0', 'E', null);
		$data[] = array('40.06', 'S', 'EDITORA��O E PUBLICA��O', null, null, null, null);
		$data[] = array('40.06.01', 'S', 'PUBLICA��ES OFICIAIS', null, null, null, null);
		$data[] = array('40.06.01.01', 'N', 'Publica��es em ve�culos externos ', '1', '0', 'E', 'As publica��es externas ao �rg�o poder�o integrar o acervo bibliogr�fico.');
		$data[] = array('40.06.01.02', 'N', 'Material para publica��o', '100', '0', 'E', null);
		$data[] = array('40.06.01.03', 'N', 'Publica��es do �rg�o', '0', '0', 'G', 'As publica��es do �rg�o, revistas, boletins, informativos, relat�rios, discursos, etc., poder�o integrar o acervo bibliogr�fico. ');
		$data[] = array('40.06.02', 'S', 'PROJETO   EDITORIAL', null, null, null, null);
		$data[] = array('40.06.02.01', 'N', 'Projeto Editorial ', '2', '0', 'G', null);
		$data[] = array('40.06.02.03', 'N', 'Pauta', '2', '0', 'E', null);
		$data[] = array('40.06.02.04', 'N', 'Autoriza��o do autor', '0', '0', 'G', null);
		$data[] = array('40.06.02.05', 'N', 'Artigo original do autor', '2', '50', 'E', 'Lei n� 9.610, de 19/02/98.');
		$data[] = array('40.06.02.06', 'N', 'ISBN / ISSN', '5', '0', 'G', null);
		$data[] = array('40.06.03', 'S', 'SERVI�OS GR�FICOS E REPROGR�FICOS', null, null, null, null);
		$data[] = array('40.06.03.01', 'N', 'Servi�os gr�ficos, diagrama��o, impress�o, encaderna��o', '2', '2', 'E', null);
		$data[] = array('40.06.03.02', 'N', 'Controle de servi�os reprogr�ficos', '2', '0', 'E', 'Pode gerar processo.');
		$data[] = array('40.06.03.03', 'N', 'Requisi��o de c�pia reprogr�fica', '2', '0', 'E', null);
		$data[] = array('40.06.03.04', 'N', 'Projetos de programa��o de identidade visual - logotipos, s�mbolos, �cones, personagens, etc. ', '2', '0', 'G', 'Cria��o, aprova��o, revis�o. Inclusive em meio eletr�nico ');
		$data[] = array('40.06.04', 'S', 'DISTRIBUI��O. PROMO��O. DIVULGA��O', null, null, null, null);
		$data[] = array('40.06.04.01', 'N', 'Material de distribui��o, promo��o e divulga��o - folhetos, cartazes, folders, etc. ', '0', '0', 'G', 'Divulgar eventos, cursos, etc. Inclusive em meio eletr�nico. Um exemplar deve ser juntado ao dossi� do evento/curso.');
		$data[] = array('40.06.05', 'S', 'ADMINISTRA��O DE PORTAIS', null, null, null, null);
		$data[] = array('40.06.05.01', 'N', 'Desenvolvimento de p�gina eletr�nica', '5', '5', 'G', null);
		$data[] = array('40.06.05.02', 'N', 'Manuten��o evolutiva, corretiva, adaptativa', '5', '5', 'G', null);
		$data[] = array('40.06.05.03', 'N', 'Mem�ria dos layouts e funcionalidades', '5', '5', 'G', null);
		$data[] = array('40.07', 'S', 'TECNOLOGIA DA INFORMA��O', null, null, null, null);
		$data[] = array('40.07.01', 'S', 'DESENVOLVIMENTO DE SISTEMA', null, null, null, null);
		$data[] = array('40.07.01.01', 'N', 'Implanta��o de sistemas', '5', '0', 'G', null);
		$data[] = array('40.07.01.02', 'N', 'Desenvolvimento de sistemas', '5', '0', 'G', null);
		$data[] = array('40.07.01.03', 'N', 'Manuten��o evolutiva/corretiva/adaptativa ', '5', '0', 'G', 'Inclusive para customiza��o de sistemas.');
		$data[] = array('40.07.01.04', 'N', 'Mem�ria dos leiautes e funcionalidades dos diversos sistemas informatizados', '2', '0', 'G', 'Inclusive p�ginas de internet e intranet.');
		$data[] = array('40.07.01.05', 'N', 'Metodologia de desenvolvimento de sistemas', '5', '0', 'G', null);
		$data[] = array('40.07.01.06', 'N', 'Documentos do sistema', '5', '0', 'G', 'Diagrama de fluxo de dados/ Modelo de entidade / relacionamento/ Dicion�rio de dados.');
		$data[] = array('40.07.01.07', 'N', 'Manuais de uso', '2', '0', 'G', 'Os manuais dos sistemas criados pela institui��o. ');
		$data[] = array('40.07.01.08', 'N', 'An�lises para utiliza��o de softwares', '5', '0', 'E', 'Documentos relativos � aquisi��o de software dever�o ser classificados no c�digo 30.04.09.01.');
		$data[] = array('40.07.02', 'S', 'ADMINISTRA��O DE REDE', null, null, null, null);
		$data[] = array('40.07.02.01', 'N', 'Administra��o de rede', '2', '0', 'E', null);
		$data[] = array('40.07.02.02', 'N', 'C�pia de seguran�a di�ria', '100', '0', 'E', null);
		$data[] = array('40.07.02.03', 'N', 'C�pia de seguran�a semanal', '100', '0', 'E', null);
		$data[] = array('40.07.02.04', 'N', 'C�pia de seguran�a mensal', '1', '0', 'E', null);
		$data[] = array('40.07.03', 'S', 'SUPORTE T�CNICO ', null, null, null, null);
		$data[] = array('40.07.03.01', 'N', 'Atendimento e suporte ao usu�rio', '2', '0', 'E', 'Dados transferidos para a estat�stica.');
		$data[] = array('40.07.03.03', 'N', 'Equipamentos de inform�tica', '2', '0', 'E', 'Inclusive instala��o, manuten��o, conserva��o.');
		$data[] = array('40.07.04', 'S', 'TECNOLOGIA', null, null, null, null);
		$data[] = array('40.07.04.01', 'N', 'Infraestrutura de Inform�tica', '2', '0', 'E', null);
		$data[] = array('40.07.04.02', 'N', 'Itens de Configura��o', '5', '0', 'E', null);
		$data[] = array('40.07.05', 'S', 'CERTIFICA��O DIGITAL', null, null, null, null);
		$data[] = array('40.07.05.01', 'N', 'Credenciamento de Autoridade Certificadora (AC)', '2', '0', 'G', null);
		$data[] = array('40.07.05.02', 'N', 'Credenciamento de Autoridade de Registro (AR)', '2', '0', 'G', null);
		$data[] = array('40.07.05.03', 'N', 'Credenciamento de Posto Provis�rio', '2', '0', 'G', null);
		$data[] = array('40.07.05.04', 'N', 'Credenciamento de Instala��o T�cnica', '2', '0', 'G', null);
		$data[] = array('40.07.05.05', 'N', 'Cadastramento de Certificado Digital', '3', '0', 'E', 'Procedimentos para cadastramento de usu�rios junto � AC-JUS.');
		$data[] = array('40.07.06', 'S', 'SEGURAN�A DA INFORMA��O', null, null, null, null);
		$data[] = array('40.07.06.01', 'N', 'Resposta a incidentes', '2', '0', 'G', null);
		$data[] = array('40.07.06.02', 'N', 'Auditoria de TI', '2', '0', 'G', null);
		$data[] = array('40.07.06.03', 'N', 'Acesso aos sistemas e uso de recursos de TI', '5', '0', 'E', 'Solicita��o.');
		$data[] = array('40.07.06.04', 'N', 'An�lise de risco', '2', '0', 'G', null);
		$data[] = array('40.08', 'S', 'SERVI�OS DE TRANSMISS�O DE DADOS, VOZ E IMAGEM', null, null, null, null);
		$data[] = array('40.08.00.01', 'N', 'Servi�o de transmiss�o de dados, voz e imagem', '100', '10', 'E', null);
		$data[] = array('40.08.00.04', 'N', 'Servi�o de radiofrequ�ncia', '5', '0', 'G', null);
		$data[] = array('50', 'S', 'VAGO', null, null, null, null);
		$data[] = array('60', 'S', 'VAGO', null, null, null, null);
		$data[] = array('70', 'S', 'VAGO', null, null, null, null);
		$data[] = array('80', 'S', 'VAGO', null, null, null, null);
		$data[] = array('90', 'S', 'ATIVIDADES FORENSES', null, null, null, 'Caso gere ato (art. 12, � 2�, "a", "b" e "c", Res. 318/2014, CJF),  este ser� de guarda permanente.');
		$data[] = array('90.00.00.01', 'N', 'Advogados', '100', '0', 'E', 'A��es envolvendo cadastramento, altera��o, suspens�o, impedimento');
		$data[] = array('90.00.00.02', 'N', 'Ades�o a servi�os processuais', '3', '0', 'E', 'Inclusive advogados.');
		$data[] = array('90.00.00.03', 'N', 'Procuradores da Uni�o e Aut�rquico', '2', '0', 'E', 'Credenciamento');
		$data[] = array('90.00.00.04', 'N', 'Cadastramento de jurado, perito, tradutor, int�rprete, advogado volunt�rio e defensor dativo', '2', '0', 'E', null);
		$data[] = array('90.00.00.05', 'N', 'Honor�rios de perito, tradutor, int�rprete, advogado volunt�rio e defensor dativo ', '100', '10', 'E', null);
		$data[] = array('90.01', 'S', 'PROTOCOLO JUDICI�RIO', null, null, null, null);
		$data[] = array('90.01.00.01', 'N', 'Peti��es protocoladas e outros documentos judiciais', '3', '0', 'E', 'Registro, pr�-cadastramento, cadastramento');
		$data[] = array('90.01.01', 'S', 'REGISTRO E AUTUA��O DE PROCESSOS', null, null, null, null);
		$data[] = array('90.01.01.01', 'N', 'Registro de processos judiciais - tombo', '5', '0', 'G', null);
		$data[] = array('90.01.02', 'S', 'DISTRIBUI��O PROCESSUAL', null, null, null, null);
		$data[] = array('90.01.02.01', 'N', 'Distribui��o de processos', '2', '0', 'E', 'Inclusive preven��o, suspei��o, impedimento');
		$data[] = array('90.01.02.02', 'N', 'Escala de distribui��o', '2', '0', 'E', null);
		$data[] = array('90.01.02.03', 'N', 'An�lise de pedidos de certid�o (rela��o de prov�veis)', '5', '0', 'E', null);
		$data[] = array('90.02', 'S', 'TRAMITA��O, PROCESSAMENTO, BAIXA E ARQUIVAMENTO', null, null, null, null);
		$data[] = array('90.02.00.01', 'N', 'Provid�ncias / informa��es sobre o andamento processual', '2', '0', 'E', 'Dilig�ncias, antecedentes, devolu��o de cartas e processos, inclus�o em pauta, perito, c�lculo judicial. ');
		$data[] = array('90.02.00.02', 'N', 'Cargas de processos judiciais', '100', '0', 'E', 'Livro ou rela��o "on-line" de carga para advogado, perito, MPU, etc.');
		$data[] = array('90.02.00.03', 'N', 'Entrega definitiva de autos', '3', '0', 'G', 'Este c�digo refere-se � entrega para as partes. Classificar sob o c�digo 40.03.04.01 a entrega de autos findos.');
		$data[] = array('90.02.00.04', 'N', 'Remessa Externa (entre os distintos �rg�os)', '2', '0', 'E', 'Inclusive baixa por declina��o de compet�ncia.');
		$data[] = array('90.02.00.05', 'N', 'Remessa Interna (entre setores do mesmo �rg�o)', '2', '0', 'E', 'Inclusive guia de remessa ao arquivo. � desnecess�ria a impress�o, basta o registro eletr�nico.');
		$data[] = array('90.02.00.06', 'N', 'Comunica��o de decis�es, despachos, julgamentos, etc.', '3', '0', 'E', 'Tanto expedida, quanto recebida.');
		$data[] = array('90.02.00.07', 'N', 'Registro de Guia de Recolhimento (Criminal)', '5', '10', 'E', null);
		$data[] = array('90.02.00.08', 'N', 'Registro de Livramento Condicional', '5', '10', 'E', null);
		$data[] = array('90.02.00.09', 'N', 'Rol dos Culpados', '100', '0', 'G', 'Registro no CJF, no Rol Nacional de Culpados. Livro ou rela��o "on-line".');
		$data[] = array('90.02.00.10', 'N', 'Fian�a', '5', '10', 'E', 'Inclusive termo, of�cio.');
		$data[] = array('90.02.00.11', 'N', 'Termo de suspens�o de processo ', '100', '0', 'E', null);
		$data[] = array('90.02.00.12', 'N', 'Bens Apreendidos', '5', '0', 'G', 'Termo de apreens�o, termo de doa��o ');
		$data[] = array('90.02.00.13', 'N', 'Cumprimento de Dilig�ncias', '100', '0', 'E', 'Inclusive controle de entrega de mandados aos Oficiais de Justi�a.');
		$data[] = array('90.02.00.14', 'N', 'Editais', '2', '0', 'E', null);
		$data[] = array('90.02.00.15', 'N', 'Cartas - De Ordem, Precat�ria, Rogat�ria', '2', '0', 'E', null);
		$data[] = array('90.02.00.16', 'N', 'Mandados', '2', '0', 'E', null);
		$data[] = array('90.02.00.17', 'N', 'Certid�es', '0', '0', 'E', 'Certid�o narrat�ria ou objeto e p�, negativa, CDA etc.');
		$data[] = array('90.02.00.18', 'N', 'Peti��es', '100', '0', 'E', 'Peti��o de cunho eminentemente processual.');
		$data[] = array('90.02.00.19', 'N', 'Peti��es n�o pass�veis de juntada aos autos', '3', '0', 'E', null);
		$data[] = array('90.02.00.20', 'N', 'Alvar�s', '3', '5', 'E', null);
    $data[] = array('90.02.00.21', 'N', 'Compromisso de Liberdade Provis�ria sem fian�a', '3', '5', 'E', 'Registro, termo.');
		$data[] = array('90.02.01', 'S', 'JULGAMENTO', null, null, null, null);
		$data[] = array('90.02.01.01', 'N', 'Carta de Senten�a', '2', '0', 'E', null);
		$data[] = array('90.02.01.02', 'N', 'Livro de Senten�a - termo', '100', '0', 'G', null);
		$data[] = array('90.02.01.03', 'N', 'Ata de julgamento', '1', '0', 'G', 'Utilizadas para restaura��o de autos.');
		$data[] = array('90.02.01.04', 'N', 'Pauta de julgamento', '3', '0', 'E', null);
		$data[] = array('90.02.01.05', 'N', 'Memorial', '100', '0', 'E', null);
		$data[] = array('90.02.01.06', 'N', 'Livro de audi�ncia', '100', '0', 'G', null);
		$data[] = array('90.02.01.07', 'N', 'Registro de audi�ncia / sess�o de julgamento', '3', '0', 'G', 'Inclusive ata livro de transcri��o de depoimentos, notas taquigr�ficas, registros em audio, v�deo e meios digitais.');
    $data[] = array('90.02.01.08', 'N', 'Suspens�o Condicional do Processo', '100', '10', 'E', 'Registro, termo.');
		$data[] = array('90.03', 'S', 'EXECU��O', null, null, null, null);
		$data[] = array('90.03.00.01', 'N', 'Penhora', '100', '0', 'E', null);
		$data[] = array('90.03.00.02', 'N', 'Arremata��o e Adjudica��o', '100', '0', 'E', 'Autos, carta.');
		$data[] = array('90.03.00.03', 'N', 'Registro de Suspens�o Condicional de Execu��o da pena', '5', '10', 'E', null);
		$data[] = array('90.03.00.04', 'N', 'Comparecimento dos condenados com benef�cio de sursis e declara��o de presta��o laborativa', '2', '5', 'E', null);
		$data[] = array('90.03.00.05', 'N', 'Controle de pena alternativa', '100', '0', 'E', null);
		$data[] = array('90.03.00.06', 'N', 'Controle de r�u preso ', '100', '0', 'E', null);
		$data[] = array('90.03.00.07', 'N', 'Laudo de Avalia��o', '3', '0', 'E', null);
		$data[] = array('90.03.01', 'S', 'PRECAT�RIO', null, null, null, null);
		$data[] = array('90.03.01.01', 'N', 'Precat�rio ou Requisi��o de Pequeno Valor (RPV)', '100', '10', 'E', null);
		$data[] = array('90.03.01.02', 'N', 'Controle de precat�rio', '3', '0', 'E', 'Inclusive erros, duplicidade, cancelamento.');
		$data[] = array('90.03.02', 'S', 'C�LCULOS JUDICIAIS', null, null, null, null);
		$data[] = array('90.03.02.01', 'N', 'C�lculo judicial', '100', '0', 'E', null);
		$data[] = array('90.03.02.02', 'N', 'Laudo judicial', '100', '0', 'E', null);
		$data[] = array('90.03.02.03', 'N', 'Manual', '3', '0', 'G', 'Uso pelo CJF.');
		$data[] = array('90.04', 'S', 'DEP�SITO JUDICIAL', null, null, null, null);
		$data[] = array('90.04.00.01', 'N', 'Dep�sito Judicial', '5', '0', 'G', 'Termo de recebimento, tombamento e remessa de bens apreendidos, bens acautelados.');
		$data[] = array('90.04.00.02', 'N', 'Fiel deposit�rio', '100', '5', 'E', 'Termo de compromisso.');
		$data[] = array('90.05', 'S', 'CORREGEDORIA', null, null, null, null);
		$data[] = array('90.05.00.02', 'N', 'Consultas, orienta��es, provid�ncias e registro de reclama��es', '5', '0', 'E', 'Pode ser gerado processo.');
		$data[] = array('90.05.00.03', 'N', 'Representa��o por excesso de prazo', '3', '0', 'G', null);
		$data[] = array('90.05.00.04', 'N', 'Avoca��o', '3', '0', 'G', null);
		$data[] = array('90.05.00.06', 'N', 'Intima��o pela Corregedoria', '3', '0', 'E', null);
		$data[] = array('90.05.00.07', 'N', 'Procedimento de Controle Administrativo', '3', '0', 'G', null);
		$data[] = array('90.05.00.08', 'N', 'Pedido de Provid�ncia', '5', '0', 'G', null);
		$data[] = array('90.05.00.09', 'N', 'Reclama��o Disciplinar', '5', '0', 'G', null);
		$data[] = array('90.05.00.10', 'N', 'Recurso de Decis�o do Corregedor', '5', '0', 'G', null);
		$data[] = array('90.05.00.11', 'N', 'Recurso Disciplinar de Magistrado', '5', '0', 'G', null);
		$data[] = array('90.05.00.12', 'N', 'Revis�o Disciplinar', '3', '0', 'G', null);
		$data[] = array('90.05.01', 'S', 'INSPE��O', null, null, null, null);
		$data[] = array('90.05.01.01', 'N', 'Inspe��o geral ordin�ria', '3', '0', 'G', null);
		$data[] = array('90.05.01.02', 'N', 'Inspe��o geral extraordin�ria', '3', '0', 'G', null);
		$data[] = array('90.05.01.03', 'N', 'Inspe��o de avalia��o', '3', '0', 'G', null);
		$data[] = array('90.05.02', 'S', 'CORREI��O', null, null, null, null);
		$data[] = array('90.05.02.01', 'N', 'Correi��o geral ordin�ria', '3', '0', 'G', null);
		$data[] = array('90.05.02.02', 'N', 'Correi��o geral extraordin�ria', '3', '0', 'G', null);
		$data[] = array('90.05.02.03', 'N', 'Correi��o de avalia��o', '3', '0', 'G', null);
		$data[] = array('90.05.02.04', 'N', 'Correi��o parcial', '3', '0', 'G', null);
		$data[] = array('90.05.03', 'S', 'IMPEDIMENTO E SUSPEI��O', null, null, null, 'Art. 134 a 138, CPC e Resolu��o n� 82, CNJ, 09 junho de 2009.');
		$data[] = array('90.05.03.01', 'N', 'Impedimento / suspei��o', '3', '0', 'G', 'Art. 134 a 138, CPC.');
		$data[] = array('90.06', 'S', 'ESTAT�STICA JUDICI�RIA', null, null, null, null);
		$data[] = array('90.06.00.01', 'N', 'Estat�stica da produ��o judici�ria', '3', '0', 'E', 'Inclusive a produtividade de magistrados (Podem ser transferidos para relat�rios anuais). ');
		$data[] = array('90.07', 'S', 'ADMINISTRA��O DE GABINETES', null, null, null, null);
		$data[] = array('90.07.00.01', 'N', 'Sele��o de ac�rd�os para publica��o na Revista', '1', '0', 'E', null);
		$data[] = array('90.07.00.02', 'N', 'Senten�a', '100', '0', 'G', 'Em suporte papel ou digital cfe. Art. 12, Res. 318/2014, CJF.');
		$data[] = array('90.07.00.03', 'N', 'Inteiro teor do ac�rd�o', '100', '0', 'G', 'Relat�rio, voto, ementa e ac�rd�o. Em suporte papel ou digital cfe. Art. 12, Res. 318/2014, CJF.');
		$data[] = array('90.07.00.04', 'N', 'Decis�es interlocut�rias proferidas', '100', '0', 'E', null);
		$data[] = array('90.07.00.05', 'N', 'Decis�es terminativas proferidas', '100', '0', 'G', 'Em suporte papel ou digital cfe. Art. 12, Res. 318/2014, CJF.');
		$data[] = array('90.07.00.06', 'N', 'Decis�es recursais monocr�ticas', '100', '0', 'G', 'Em suporte papel ou digital cfe. Art. 12, Res. 318/2014, CJF.');
		$data[] = array('90.08', 'S', 'PRAZOS PROCESSUAIS', null, null, null, null);
		$data[] = array('90.08.00.01', 'N', 'Prazos forenses', '3', '0', 'E', null);
		$data[] = array('90.08.01', 'S', 'ANO JUDICI�RIO', null, null, null, null);
		$data[] = array('90.08.01.01', 'N', 'Recesso forense', '3', '0', 'E', null);
		$data[] = array('90.08.01.02', 'N', 'F�rias forenses', '3', '0', 'E', null);
		$data[] = array('90.08.01.03', 'N', 'Plant�o ', '3', '0', 'E', null);


    BancoSEI::getInstance()->abrirConexao();
    BancoSEI::getInstance()->abrirTransacao();

    $objTabelaAssuntoRN = new TabelaAssuntosRN();

		$objTabelaAssuntoDTO = new TabelaAssuntosDTO();
		$objTabelaAssuntoDTO->setStrNome('PCTT Abril/2017');
		$objTabelaAssuntoDTO->setNumIdTabelaAssuntos(null);
		$objTabelaAssuntoDTO->setStrDescricao('Plano de Classifica��o e Tabela de Temporalidade dos Documentos administrativos da Justi�a Federal (vers�o abril/2017)');
		$objTabelaAssuntoDTO->setStrSinAtual('N');
		$objTabelaAssuntoDTO = $objTabelaAssuntoRN->cadastrar($objTabelaAssuntoDTO);
//
    $objAssuntoRN = new AssuntoRN();

    $objAssuntoDTO = new AssuntoDTO();
    $objAssuntoDTO->setNumIdTabelaAssuntos($objTabelaAssuntoDTO->getNumIdTabelaAssuntos());
//		$objAssuntoDTO->setNumIdTabelaAssuntos(5);
		$objAssuntoDTO->setNumIdAssunto(null);
		$objAssuntoDTO->setStrSinAtivo('S');

    InfraDebug::getInstance()->gravar('ASSUNTOS:');

		foreach ($data as $arr) {

			InfraDebug::getInstance()->gravar(InfraString::excluirAcentos($arr[0].' - '.$arr[2]));

			$objAssuntoDTO->setStrCodigoEstruturado($arr[0]);
			$objAssuntoDTO->setStrSinEstrutural($arr[1]);
			$objAssuntoDTO->setStrDescricao($arr[2]);
			$objAssuntoDTO->setNumPrazoCorrente($arr[3]);
			$objAssuntoDTO->setNumPrazoIntermediario($arr[4]);
			$objAssuntoDTO->setStrStaDestinacao($arr[5]);
			$objAssuntoDTO->setStrObservacao($arr[6]);
			$objAssuntoRN->cadastrarRN0259($objAssuntoDTO);
		}

		$arrMapeamentos = explode("\n",'00.01.01.01;00.01.01.01
00.01.01.02;90.05.00.02
00.01.02;00.01.01.03
00.01.03;00.01.01.03
00.01.04.01;00.01.01.07
00.01.04.02;00.01.01.07
00.01.04.03;90.05.00.06
00.01.04.04;20.03.01.01
00.01.04.05;00.01.01.07
00.01.04.06;00.01.01.07
00.01.04.07;00.01.01.07
00.01.04.08;00.01.01.09
00.01.04.09;00.01.01.05
00.01.04.10;20.03.01.01
00.01.04.11;00.01.01.03
00.01.05;00.01.01.01
00.01.06;00.01.01.03
00.01.07;00.01.01.16
00.01.08.01;00.03.00.01
00.01.08.02;00.03.00.01
00.01.09.01;00.01.01.01
00.01.10.01;20.08.06.03
00.01.10.02;20.08.06.03
00.01.10.03;20.08.06.03
00.01.11.01;30.01.02.06
00.01.11.02;30.03.00.10
00.01.11.03;00.03.00.03
00.01.11.04;00.03.00.03
00.01.11.05;00.03.00.03
00.01.12.01;00.04.00.01
00.02.01;00.04.00.01
00.02.02;00.04.00.01
00.02.03;00.01.01.03
00.03.01;00.05.00.01
00.03.02;00.05.00.02
00.03.03;00.05.00.02
00.03.04;00.01.01.03
00.04.01.01;30.03.00.10
00.04.01.02;00.01.01.17
00.04.01.03;30.01.02.02
00.04.01.04;00.01.01.17
00.04.01.05;00.01.01.17
00.04.01.06;00.01.01.17
00.04.01.07;00.01.01.17
00.04.01.08;00.01.01.17
00.04.01.09;00.01.01.17
00.04.01.10;00.01.01.17
00.04.01.11;00.06.02.05
00.04.01.12;00.01.01.17
00.04.01.13;00.01.01.17
00.04.02.01;00.01.01.17
00.04.02.02;30.01.02.03
00.04.02.03;30.01.02.04
00.04.02.04;30.01.02.05
00.04.02.05;30.01.02.06
00.04.02.06;20.05.01.01
00.04.03.01;30.01.03.01
00.04.03.02;30.01.03.02
00.04.04;00.01.01.03
00.04.05;30.01.02.01
00.04.06;30.01.02.01
00.05.01.01;00.06.01.02
00.05.01.02;00.06.01.02
00.05.02.01;00.06.02.01
00.05.02.02;00.06.01.02
00.05.02.03;00.06.01.02
00.05.02.04;00.06.01.02
00.05.02.05;00.06.02.03
00.05.02.06;00.01.01.03
00.05.03.01;00.06.01.02
00.05.04.01;10.06.01.01
00.05.04.02;10.06.01.02
00.05.05.01;00.01.01.03
00.05.05.02;00.06.01.02
00.05.05.03;00.06.01.02
00.05.06;00.01.01.03
00.06.01;00.01.01.03
00.06.02;00.07.00.01
00.99;00.01.01.05
00.99.04;00.01.01.05
00.99.20;00.01.01.05
00.99.32;00.01.01.05
00.99.40;00.01.01.05
00.99.80;00.01.01.05
01.01.01;00.08.00.01
01.01.01.01;00.01.01.03
01.01.02;00.08.00.01
01.01.03.01;00.09.00.01
01.01.04.01;00.01.01.03
01.01.04.02;00.01.01.03
01.01.04.03;00.01.01.05
01.01.04.04;00.01.01.03
01.01.04.05;00.01.01.03
01.01.04.06;00.01.01.03
01.01.04.07;00.01.01.05
01.02.01;00.10.00.05
01.02.02;00.10.00.05
01.02.03.01;40.03.02.01
01.02.03.02;40.03.02.01
01.02.03.03;00.10.04.01
01.02.03.04;00.10.00.05
01.02.03.05;00.10.00.05
01.02.03.06;00.01.01.03
01.02.04;00.10.00.02
01.02.04.01;00.01.01.03
01.02.05;00.10.00.02
01.03.01.01;20.02.06.05
01.03.02.01;00.11.01.01
01.03.03;00.11.01.05
01.03.04.01;00.11.01.02
01.03.04.02;00.11.01.03
01.03.05;00.01.01.03
01.04.01.01;00.11.02.01
01.04.01.02;00.11.02.01
01.04.01.03;00.11.02.01
01.04.01.04;00.11.02.01
01.04.01.05;00.11.02.01
01.04.01.06;00.11.02.03
01.04.01.08;00.11.02.01
01.04.01.09;00.11.02.01
01.04.01.10;00.11.02.01
01.04.02.01;00.11.02.01
01.04.02.02;00.11.02.01
01.04.03.01;00.11.02.03
01.04.04.01;00.11.04.01
01.04.04.02;00.11.04.02
01.04.05;00.01.01.03
01.05.01.01;00.11.02.04
01.05.01.02;00.11.02.05
01.05.01.03;00.11.02.04
01.05.02.01;40.03.02.01
01.05.03;00.01.01.03
02.01.01.04;20.07.00.02
02.01.02.01;20.02.06.09
02.01.02.02;20.02.06.09
02.01.02.03;20.02.06.09
02.01.02.04;20.02.06.09
02.01.02.05;20.02.06.09
02.01.03.01;20.05.09.04
02.01.04.01;00.11.04.01
02.01.04.02;20.09.00.01
02.01.04.03;20.09.00.01
02.01.05.01;20.09.00.01
02.01.05.02;20.09.00.02
02.01.06.01;20.09.00.03
02.01.07;90.05.00.02
02.01.08;00.01.01.03
02.02.01.01;20.02.08.02
02.02.01.02;20.02.08.02
02.02.02.01;20.02.08.01
02.02.02.02;20.04.00.04
02.02.02.03;00.11.02.01
02.02.02.04;00.11.02.01
02.02.02.05;00.11.02.01
02.02.02.06;00.11.02.01
02.02.02.07;00.11.02.01
02.02.02.08;00.11.02.01
02.02.02.09;20.02.08.01
02.03.01;00.07.00.01
02.04.01.01;20.04.00.04
02.04.02;20.02.06.01
02.04.03;20.05.09.02
02.04.04;20.02.06.01
02.04.05;20.02.06.02
02.04.06;20.02.06.02
02.04.07;20.02.06.05
02.04.08;20.02.06.07
02.05.01.01;20.02.06.01
02.05.01.02;20.02.06.01
02.05.02.01;20.02.03.01
02.05.02.02;20.02.03.01
02.05.02.03;20.02.03.01
02.05.02.04;20.02.01.01
02.05.02.05;20.02.04.07
02.05.02.06;20.02.03.03
02.05.02.07;20.02.03.01
02.05.02.08;20.02.01.02
02.05.02.09;20.02.03.05
02.05.02.10;20.02.03.05
02.05.02.11;20.02.03.05
02.05.02.12;20.02.03.01
02.05.02.13;20.02.03.01
02.05.02.14;20.02.03.01
02.05.02.15;20.02.03.01
02.05.02.16;20.02.03.01
02.05.02.17;20.02.03.01
02.05.02.18;20.02.01.03
02.05.02.19;20.02.03.06
02.05.02.20;20.02.04.06
02.05.02.21;20.02.03.01
02.05.02.22;20.02.04.09
02.05.02.23;20.02.03.01
02.05.02.24;20.02.03.01
02.05.02.25;20.02.04.05
02.05.03.01;20.02.07.03
02.05.03.02;20.02.07.03
02.05.03.03;20.02.07.04
02.05.04.01;20.11.00.06
02.05.04.02;00.08.00.01
02.05.04.03;20.11.00.06
02.05.04.04;20.11.00.06
02.05.04.05;20.11.00.06
02.05.04.06;20.11.00.03
02.05.04.07;20.11.00.04
02.05.04.08;20.11.00.06
02.05.04.09;00.01.01.17
02.05.04.10;20.11.00.06
02.05.04.11;30.03.00.10
02.05.04.12;20.11.00.06
02.05.04.13;20.11.00.06
02.05.04.14;20.11.00.06
02.05.04.15;20.11.00.06
02.05.05.01;20.02.03.04
02.05.05.02;20.02.03.05
02.05.05.03;20.02.03.05
02.05.05.04;20.02.03.01
02.05.05.05;20.02.04.08
02.05.05.06;20.02.03.01
02.05.05.07;20.11.00.06
02.05.05.08;20.02.04.03
02.05.05.09;20.02.04.06
02.05.05.10;20.02.04.06
02.05.05.11;20.01.01.07
02.05.06.01;20.08.06.01
02.05.06.02;20.08.06.02
02.05.06.03;20.08.06.02
02.06.01.01;20.04.00.04
02.06.01.02;20.04.00.02
02.06.01.03;20.04.00.05
02.06.01.04;20.04.00.04
02.06.01.05;20.04.00.04
02.06.01.06;20.04.00.05
02.06.01.07;20.04.00.04
02.06.01.08;20.04.00.04
02.06.02.01;20.04.00.04
02.06.02.02;30.02.02.01
02.06.02.03;20.04.00.05
02.06.02.04;20.04.00.05
02.06.02.05;20.04.00.04
02.06.02.06;30.02.02.01
02.06.02.07;20.04.00.05
02.06.02.08;20.04.00.03
02.06.03.01;20.04.00.04
02.06.03.02;20.04.00.04
02.06.04.01;20.04.00.06
02.06.05.03;20.08.06.03
02.07.01.01;20.01.01.03
02.07.02.01;20.01.01.03
02.07.02.02;20.01.01.06
02.07.02.03;20.01.01.05
02.07.02.04;20.01.01.07
02.07.02.05;20.01.01.04
02.07.02.06;20.01.01.08
02.07.02.07;20.01.01.09
02.07.02.08;20.01.01.10
02.07.02.09;20.01.01.11
02.07.03.01;00.08.00.01
02.07.03.02;20.05.00.04
02.07.04.01;20.01.01.01
02.07.04.02;20.02.05.10
02.07.04.03;20.03.02.02
02.07.05.01;20.02.04.02
02.07.05.02;20.02.04.03
02.07.05.03;20.02.04.03
02.07.05.04;20.02.04.03
02.07.05.05;20.02.05.06
02.07.05.06;20.02.04.04
02.07.05.07;20.02.04.05
02.07.05.08;20.01.01.06
02.07.05.09;20.02.05.11
02.07.05.10;20.02.05.12
02.07.05.11;20.02.05.07
02.07.05.12;20.02.05.08
02.07.05.13;20.08.03.06
02.07.05.14;20.02.04.03
02.07.05.15;20.02.05.10
02.07.06.01;20.02.10.01
02.07.06.02;20.03.04.06
02.07.06.03;20.03.04.06
02.07.06.04;20.02.10.05
02.07.06.05;20.02.10.02
02.07.06.06;20.02.10.01
02.07.06.07;20.02.10.01
02.07.07.01;20.03.01.01
02.07.07.02;00.10.00.03
02.07.07.03;00.10.00.03
02.07.07.04;20.03.01.02
02.07.07.05;20.03.01.01
02.07.07.06;20.03.02.02
02.07.07.07;20.02.05.13
02.07.07.08;20.03.02.02
02.07.08.01;20.03.04.04
02.07.08.02;20.03.04.05
02.07.08.03;20.03.04.04
02.07.08.04;20.03.02.04
02.07.08.05;20.03.02.04
02.07.08.06;20.03.02.03
02.07.08.07;20.03.04.05
02.07.09.01;20.03.03.01
02.07.09.02;20.03.03.01
02.07.09.03;20.03.03.02
02.07.09.04;20.03.03.01
02.07.09.05;20.03.03.02
02.07.10.01;20.02.07.05
02.08.01.01;20.05.09.01
02.08.01.04;20.05.10.02
02.08.01.05;20.05.11.05
02.08.01.06;20.05.10.01
02.08.01.07;20.05.00.05
02.08.01.08;20.05.11.05
02.08.01.09;20.05.11.05
02.08.01.10;20.05.09.03
02.08.02;20.05.09.02
02.08.03;20.05.09.02
02.08.04;20.05.09.02
02.08.05;20.05.09.02
02.08.06.01;20.05.00.01
02.08.06.02;20.05.00.01
02.08.06.03;20.05.00.02
02.08.07.01;20.01.01.02
02.08.07.02;20.05.00.03
02.08.07.03;20.05.00.07
02.08.07.04;20.05.00.08
02.08.07.05;20.05.00.08
02.08.07.06;00.06.02.03
02.08.07.07;20.05.11.02
02.08.08.01;20.05.00.05
02.08.09.01;20.05.00.06
02.08.09.02;20.05.00.06
02.08.10.01;20.05.11.03
02.08.10.02;20.05.11.03
02.08.10.03;20.05.11.02
02.08.11.01;20.05.11.04
02.08.12;00.01.01.03
02.09.01.01;20.05.11.06
02.09.02.01;20.05.11.07
02.09.02.02;20.05.11.07
02.09.03.01;20.05.11.08
02.09.03.02;20.05.11.08
02.09.04.01;20.05.11.09
02.09.04.02;20.05.11.09
02.09.05;20.05.11.10
02.09.06.01;20.05.11.11
02.09.06.02;20.05.11.11
02.09.07.01;20.05.11.12
02.09.08;00.01.01.03
02.09.09.01;20.05.11.13
02.10.01.01;20.05.01.01
02.10.01.02;20.05.01.01
02.10.01.03;20.05.09.02
02.10.01.04;20.05.09.02
02.10.02.01;20.05.02.01
02.10.03.01;20.05.04.01
02.10.04.01;20.05.05.02
02.10.04.02;20.05.05.02
02.10.04.03;20.05.07.05
02.10.05.01;20.05.06.01
02.10.05.02;20.05.06.01
02.10.06;00.01.01.03
02.11.01.01;20.05.07.03
02.11.02.01;20.05.07.01
02.11.03.01;10.05.00.06
02.11.04.01;20.05.02.01
02.11.05.01;20.05.04.01
02.11.06.01;20.08.01.01
02.11.07.01;20.05.07.04
02.11.07.02;20.05.07.05
02.11.08;00.01.01.03
02.12.01;20.10.00.09
02.12.02;20.10.00.09
02.12.03;20.10.00.09
02.12.04;00.01.01.03
02.13.01.01;20.06.01.01
02.13.01.02;20.06.01.08
02.13.01.03;20.06.01.01
02.13.01.04;20.06.01.06
02.13.01.05;20.06.01.07
02.13.01.06;20.06.01.08
02.13.01.07;20.06.01.09
02.13.01.08;20.06.01.01
02.13.01.09;20.06.01.03
02.13.01.10;20.06.01.04
02.13.01.11;20.06.01.05
02.13.01.12;20.03.01.03
02.13.02.01;20.08.02.01
02.13.02.02;20.08.02.01
02.13.02.03;20.10.00.04
02.13.02.04;00.12.00.03
02.13.02.05;20.08.02.06
02.13.02.06;20.08.02.06
02.13.02.07;20.08.02.01
02.13.02.08;20.08.02.06
02.13.02.09;20.08.02.02
02.13.02.10;20.08.02.03
02.13.02.11;20.06.01.02
02.13.02.12;20.08.02.04
02.13.02.13;20.08.02.05
02.13.03.01;20.06.00.06
02.13.03.02;20.06.00.01
02.13.03.03;20.06.00.08
02.13.03.04;20.06.00.06
02.13.03.05;20.06.00.07
02.13.03.06;20.10.00.01
02.13.04;00.01.01.03
02.14.01.01;20.05.08.01
02.14.01.02;20.05.08.02
02.14.01.03;20.05.08.02
02.14.01.04;20.05.08.01
02.14.02.01;20.05.10.03
02.14.02.02;20.05.10.03
02.14.03;20.05.08.02
02.14.04;20.05.08.02
02.14.05;00.01.01.03
02.15.01;20.10.00.02
02.15.02;20.06.01.01
02.15.03;20.06.02.01
02.15.04;20.06.02.04
02.15.05;20.06.02.04
02.15.06;00.01.01.03
02.15.07;20.06.02.04
02.15.08;20.06.02.01
02.15.09;20.06.02.05
02.15.10;20.06.02.02
02.15.11;20.06.02.03
02.15.12;20.10.00.03
02.15.13;20.06.00.08
02.16.01.01;20.08.01.07
02.16.01.02;20.08.01.07
02.16.01.03;20.08.01.08
02.16.01.04;20.08.01.08
02.16.01.05;20.08.01.08
02.16.01.06;20.08.01.07
02.16.01.07;20.08.01.09
02.16.01.08;20.08.01.08
02.16.01.09;20.08.01.08
02.16.01.10;20.08.01.08
02.16.01.11;20.05.10.04
02.16.02.01;20.08.01.02
02.16.02.02;20.08.01.01
02.16.02.03;20.08.01.02
02.16.02.04;20.08.01.05
02.16.02.05;20.08.01.03
02.16.02.06;20.08.01.04
02.16.02.07;20.08.01.06
02.16.03;00.01.01.03
02.17.01.01;20.07.00.02
02.17.01.02;20.07.00.05
02.17.01.03;20.07.00.03
02.17.01.04;20.07.00.02
02.17.02.01;20.07.00.02
02.17.02.02;20.07.00.03
02.17.03.01;20.07.00.06
02.17.04;00.01.01.03
02.18;30.03.00.10
02.18.01;00.01.01.03
02.19.01;20.02.04.08
02.19.01.01;20.08.02.01
02.19.02;20.02.09.03
02.19.03;20.02.09.03
02.19.04;20.02.09.03
02.19.05.02;20.02.06.08
02.19.05.03;20.02.06.08
02.19.06.01;20.08.04.01
02.19.06.02;20.08.04.01
02.19.06.03;20.08.04.01
02.19.06.04;20.08.04.01
02.19.07;00.01.01.03
02.19.08;20.02.06.04
02.20;20.05.00.01
02.20.01;00.01.01.03
02.21;20.08.05.01
02.21.01;20.08.05.01
02.21.02.01;20.05.08.02
02.21.02.02;20.05.08.02
02.21.03;20.02.06.09
02.21.04;20.08.05.04
02.21.05;30.01.02.07
02.21.06;20.08.05.05
02.21.07;20.08.05.01
02.21.08;00.12.00.11
02.21.09;20.08.05.01
02.21.10;20.08.05.04
02.21.11;20.08.05.04
02.21.12;20.08.05.01
02.21.13;20.08.05.01
02.21.14;20.08.05.05
02.21.15;20.08.05.03
02.21.16;20.08.05.04
02.21.17;20.08.05.05
02.21.18;20.02.06.09
02.21.19;00.01.01.03
02.21.20;20.08.05.01
02.22.01;30.05.02.02
02.22.02;30.05.02.03
02.22.03;00.01.01.03
02.23;30.03.00.01
02.23.01;30.03.00.01
02.24.01;00.12.00.03
02.24.02;30.05.02.02
02.24.03.01;00.12.00.11
02.24.04;20.02.06.01
02.24.05;00.01.01.03
02.24.06;20.08.05.01
02.24.07;00.12.00.05
02.25.01.01;20.10.00.04
02.25.01.02;20.10.00.05
02.25.01.03;20.10.00.04
02.25.02;00.01.01.03
02.26.01.01;20.05.10.06
02.26.01.02;20.10.00.04
02.26.01.03;20.05.10.05
02.26.01.04;20.05.10.06
02.26.01.05;20.05.10.06
02.26.02.01;20.05.10.06
02.26.02.02;20.05.10.06
02.26.02.03;20.05.10.06
02.26.02.04;20.05.10.03
02.26.02.05;20.05.10.03
02.26.03;20.05.10.07
02.27;20.05.11.02
03.01.01;30.01.01.01
03.01.02;30.02.02.01
03.01.03.01;30.01.01.11
03.01.03.02;30.01.01.03
03.01.03.03;30.01.01.12
03.01.03.04;30.01.01.11
03.02.01;30.01.01.13
03.02.02;30.01.01.03
03.03.01;40.06.03.02
03.03.02;40.06.03.02
03.03.03;40.06.03.03
03.04.01.01;30.02.02.01
03.04.01.02;30.01.01.02
03.04.01.03;30.01.01.03
03.04.01.04;30.01.01.04
03.04.01.05;30.01.01.04
03.04.01.06;30.01.01.05
03.04.01.07;30.01.01.06
03.04.01.08;30.01.01.07
03.04.01.09;30.01.01.13
03.04.01.10;30.01.01.08
03.04.01.11;30.01.01.10
03.04.01.12;30.01.01.03
03.04.01.13;30.01.01.09
03.04.01.14;30.01.01.10
03.04.01.15;30.01.03.01
03.04.01.16;30.01.02.07
03.04.01.17;30.01.01.03
03.04.01.18;30.01.01.03
03.04.01.19;30.01.01.03
03.04.01.20;30.01.01.03
03.04.01.21;30.01.01.03
03.04.01.22;30.01.01.03
03.04.01.23;30.01.01.03
03.04.01.24;30.01.01.03
03.05.01.01;30.04.05.01
03.05.02.01;30.04.05.03
03.05.02.02;30.04.05.02
03.05.02.03;30.04.05.04
03.05.03.01;30.04.06.01
03.05.04.01;30.04.04.03
03.06.01.01;30.04.09.01
03.06.02.01;30.04.09.02
03.06.03.01;30.02.02.01
03.06.03.02;30.02.02.01
03.06.03.03;30.01.02.02
03.07.01.01;30.04.09.07
03.07.01.02;30.04.09.07
03.07.01.03;30.04.04.03
03.07.01.04;30.01.01.03
03.07.01.05;30.01.01.03
03.07.01.06;30.04.10.01
03.07.01.07;30.02.02.01
03.07.01.08;30.02.02.01
03.07.02.01;30.04.10.01
03.07.02.02;30.04.10.01
03.07.02.04;30.04.10.01
03.07.03.01;30.04.01.01
03.07.03.02;20.07.00.02
03.07.04.01;30.02.02.01
03.07.04.02;30.02.02.01
03.07.04.03;30.03.00.01
03.07.04.04;30.02.02.01
03.07.05.01;30.04.02.01
03.07.06.01;30.04.02.02
03.08.01;30.04.02.02
03.08.02.01;30.04.08.02
03.08.02.02;30.04.08.05
03.08.02.03;30.04.08.02
03.08.02.04;30.04.02.02
03.09.01.01;30.02.02.01
03.09.01.02;30.02.05.07
03.09.02;30.02.05.07
03.10.01.01;30.04.07.01
03.10.01.02;30.04.07.01
03.10.01.03;30.04.07.01
03.10.01.04;30.04.07.01
03.10.01.05;30.04.07.01
03.10.02.01;30.04.07.01
03.10.02.02;30.04.02.03
03.10.03.01;30.04.10.01
03.10.04.01;30.05.06.01
04.01.01.01;30.05.03.01
04.01.01.02;30.05.03.02
04.01.02.01;30.05.03.02
04.01.03.01;30.05.03.03
04.01.04.01;30.05.03.04
04.02.01;30.05.01.01
04.02.01.01;30.05.01.01
04.02.02;30.05.01.02
04.02.02.01;30.05.01.02
04.02.03;30.05.01.03
04.02.03.01;30.02.07.01
04.02.04;30.05.01.04
04.02.04.01;30.05.01.04
04.02.05;30.05.02.01
04.02.05.01;30.05.02.01
04.03.01.01;30.05.04.01
04.03.02;30.05.04.02
04.03.02.01;30.05.04.02
04.03.03.01;30.05.04.03
04.03.04.01;30.05.04.04
04.04.01;30.05.05.01
04.05.01;30.02.01.01
04.05.01.01;30.02.01.01
04.05.01.02;30.02.01.01
04.05.01.03;30.02.01.08
04.05.01.04;30.02.01.08
04.05.01.05;30.02.01.08
04.05.02;30.02.01.09
04.05.02.01;30.02.01.08
04.05.03;30.02.01.08
04.05.03.01;30.02.01.08
04.05.04;30.02.01.08
04.05.05;30.02.01.08
04.05.06;30.02.01.08
04.05.07;30.02.01.08
04.05.08;30.02.01.08
04.06.01;30.02.05.06
04.06.01.01;30.02.05.06
04.06.02;30.02.05.06
04.06.02.01;30.02.05.06
04.06.03;30.02.05.06
04.06.03.01;30.02.05.06
04.06.04;30.02.05.06
04.06.04.01;30.02.05.06
04.06.05;30.02.05.06
04.06.05.01;30.02.05.06
04.07.01.01;30.04.03.05
04.07.02.01;30.04.03.01
04.07.02.02;30.04.03.02
04.07.02.03;30.04.03.02
04.07.03.01;30.04.03.02
04.07.03.02;30.04.03.04
04.07.04.01;30.04.03.04
04.07.04.02;30.04.03.04
04.07.04.03;30.03.00.06
04.07.05.01;30.03.00.06
04.07.05.02;30.03.00.07
04.08.01.01;30.03.00.03
04.08.01.02;30.03.00.04
04.08.01.03;30.03.00.05
04.08.01.04;30.03.00.05
04.08.02.01;30.03.00.02
04.08.03.01;30.03.00.10
04.08.03.02;30.03.00.10
04.08.04.01;20.04.00.05
04.08.05.01;30.03.00.08
04.08.06.01;30.03.01.01
04.08.06.02;30.03.01.02
04.09.01;30.02.02.01
04.09.02;30.02.05.06
04.09.03.01;30.03.01.04
04.10.01.01;30.03.01.04
04.10.01.02;30.03.01.05
04.10.01.03;30.03.01.04
05.01.01;10.01.00.01
05.01.02;10.01.00.01
05.01.03;10.01.00.01
05.02.01.01;10.02.00.01
05.02.01.02;10.02.00.01
05.02.01.03;10.02.00.01
05.02.01.04;10.02.00.01
05.02.02.01;10.05.00.14
05.02.02.02;10.03.00.01
05.02.03.01;10.03.00.04
05.02.03.02;10.03.00.03
05.02.03.03;10.03.00.04
05.02.03.04;10.03.00.04
05.02.03.05;10.03.00.04
05.02.03.06;10.03.00.03
05.02.03.07;10.04.00.03
05.02.04.01;10.05.00.09
05.02.04.02;10.05.00.09
05.02.04.03;10.05.00.09
05.02.05.01;10.05.00.01
05.02.05.02;10.05.00.13
05.02.06.01;10.03.00.04
05.02.06.02;10.05.00.09
05.02.06.03;10.05.00.03
05.02.06.04;10.05.00.03
05.02.06.05;10.05.00.01
05.02.06.06;10.04.00.02
05.02.06.07;10.04.00.02
05.02.06.08;10.06.01.01
05.02.06.09;10.04.00.02
05.02.06.10;10.04.00.02
05.02.06.11;10.05.00.03
05.02.07.01;10.02.00.02
05.03.01.01;10.04.00.04
05.03.01.02;30.01.02.05
05.03.01.03;10.06.01.02
05.03.01.04.01;10.06.01.02
05.03.01.05.01;10.05.00.03
05.03.01.06;10.04.00.01
05.03.01.07;10.04.00.02
05.03.01.08;10.05.00.03
05.03.02.01;10.05.00.03
05.03.02.02;10.05.00.13
05.03.03.01;10.05.00.03
05.03.03.02;10.05.00.03
05.03.03.03;10.05.00.04
05.03.03.04;10.05.00.04
05.03.03.05;10.05.00.10
05.03.04;10.05.01.02
05.03.04.01;10.05.01.02
05.03.04.02;10.05.01.02
05.03.04.03;10.05.01.02
05.03.04.04;10.05.00.05
05.03.04.05;10.05.01.02
05.03.04.06;10.05.00.08
05.03.05.01;10.05.01.01
05.03.05.02;10.05.01.03
05.03.06.01;10.05.00.07
05.03.06.02;10.05.00.07
05.03.06.03;10.05.00.07
05.03.06.04;10.05.00.07
05.03.06.05;10.05.00.07
05.04.01.01;10.05.00.02
05.04.02.01;10.05.00.04
05.04.02.02;10.05.00.04
05.04.03;10.05.00.04
05.05.01.01;10.06.00.01
05.05.02.01;10.06.00.01
05.05.02.02;10.06.00.02
05.06;10.06.00.02
05.06.01;10.06.00.02
05.07;10.06.00.03
05.07.01;10.06.00.03
06.01.01;40.01.01.01
06.01.02;40.07.01.07
06.01.03;40.01.00.02
06.01.04.01;40.07.05.04
06.01.04.02;40.07.05.04
06.01.05.01;40.01.01.03
06.01.05.02;40.01.01.03
06.01.05.03;40.01.01.03
06.01.05.04;40.01.01.04
06.01.05.05;40.06.03.03
06.01.05.06;40.01.01.02
06.01.05.07;40.01.02.01
06.01.05.08;40.01.01.03
06.01.05.09;40.07.03.01
06.01.05.10;40.01.01.01
06.01.05.11;40.07.03.01
06.01.06.01;40.01.02.01
06.01.06.02;40.01.02.01
06.01.06.03;40.06.03.01
06.02.01;40.05.01.04
06.02.02.01;40.02.00.01
06.02.02.03;40.02.00.01
06.02.03.01;40.02.00.01
06.02.04.01;30.04.04.03
06.02.05.01;40.01.02.01
06.02.05.02;40.01.02.01
06.02.06.01;40.01.01.02
06.02.06.02;40.01.02.01
06.02.06.03;40.01.02.01
06.02.07;40.01.02.01
06.02.08.01;00.01.01.17
06.03.01.01;00.01.01.17
06.03.02.01;40.03.02.02
06.03.02.02;40.03.02.01
06.03.02.03;40.03.02.01
06.03.02.05;40.01.01.01
06.03.02.06;40.01.01.01
06.03.02.07;40.01.01.01
06.03.02.08;40.01.01.01
06.04.01.01;40.01.00.03
06.04.01.02;40.01.01.01
06.04.02.01;40.03.03.01
06.04.03.01;40.03.04.01
06.04.03.02;40.03.04.01
06.04.05;40.01.01.01
06.04.06.01;40.03.04.02
06.04.06.02;40.03.04.02
06.04.06.03;40.03.04.03
06.04.07.01;40.03.04.03
06.04.07.02;40.03.04.03
06.07.01;40.04.00.01
06.07.02;40.01.01.02
06.07.03;40.04.00.04
06.07.04;40.04.00.04
06.07.05;40.04.00.04
06.07.06;40.04.00.04
06.07.07;40.04.00.04
06.07.08;40.04.00.04
06.07.09;40.04.00.04
06.07.10;40.04.00.04
06.07.11;40.04.00.04
06.07.12;40.04.00.04
06.07.13;40.04.00.04
06.07.14;40.04.00.04
06.07.15;40.04.00.04
06.07.16;40.04.00.04
06.07.17;40.04.00.04
06.07.18;40.04.00.04
06.07.19;40.04.00.04
06.07.20;40.04.00.04
06.07.21;40.07.01.08
06.07.22;40.04.00.04
06.07.23;40.04.00.04
06.07.24;40.04.00.04
06.07.25;40.04.00.04
06.07.26;40.04.00.04
06.07.27;40.04.00.04
06.07.28;40.04.00.03
06.07.29;40.04.00.04
06.07.30;40.04.00.04
06.08.01.01;40.05.01.01
06.08.01.02;40.05.01.01
06.08.01.03;40.05.01.01
06.08.02.01;40.05.01.01
06.08.02.02;40.05.01.01
06.08.02.03;40.05.01.01
06.08.03.01;40.05.01.04
06.08.04.01;40.05.02.01
06.08.04.02;40.05.02.01
06.08.04.03;40.05.02.01
06.08.04.04;40.05.01.01
06.08.04.05;40.05.02.01
06.08.04.06;40.05.02.01
06.08.04.07;40.05.01.01
06.08.05.01;40.05.03.01
06.08.05.02;40.05.03.02
06.08.05.03;40.05.03.02
06.09.01.01;90.02.00.14
06.09.01.02;40.06.01.01
06.09.01.03;40.06.01.02
06.09.01.04;40.06.01.01
06.09.02.01;40.06.01.03
06.09.02.02;40.06.01.03
06.09.03.01;40.06.02.01
06.09.03.02;40.06.02.03
06.09.03.03;40.06.02.04
06.09.03.04;40.06.02.04
06.09.03.05;40.06.02.05
06.09.03.06;40.06.02.06
06.09.04.01;40.06.02.01
06.09.04.02;40.06.02.01
06.09.05.01;40.06.04.01
06.09.05.02;40.06.04.01
06.10.00;40.07.04.01
06.10.01.01;40.07.01.02
06.10.01.02;40.07.04.01
06.10.01.03;40.07.01.01
06.10.01.04;40.07.01.02
06.10.01.05;40.06.05.02
06.10.01.06;40.07.01.03
06.10.01.07;40.07.06.03
06.10.01.08;40.07.01.03
06.10.01.09;40.07.01.03
06.10.02.01;40.07.04.01
06.10.02.02;40.07.04.01
06.10.02.03;40.07.04.01
06.10.02.04;40.07.04.01
06.10.02.05;40.07.06.03
06.10.02.06;40.07.01.07
06.10.02.07;40.07.01.07
06.10.02.08;40.07.01.07
06.10.02.09;40.07.01.08
06.10.03.01;40.07.04.01
06.10.03.02;40.07.04.01
06.10.03.03;40.07.04.01
06.10.03.04;40.07.04.01
06.10.04.01;40.07.03.01
06.10.04.02;40.07.03.03
06.10.04.03;40.07.04.01
06.10.04.04;40.07.03.01
06.10.04.05;40.07.03.01
06.10.04.06;40.07.03.01
06.11.01;40.01.01.02
06.11.02;40.07.04.01
06.11.03;40.07.04.01
06.11.04;40.07.04.01
07.01.01.01;90.02.00.04
07.01.01.02;90.02.00.04
07.01.01.03;90.02.00.04
07.01.01.04;90.02.00.04
07.01.02.01;90.02.00.04
07.01.03.01;90.02.00.04
07.01.03.02;90.02.00.04
07.01.04.01;90.02.00.04
07.02.01;40.08.00.04
07.03.01;40.08.00.01
07.04.01.01;40.08.00.01
07.04.01.02;40.08.00.01
07.04.02.01;40.08.00.01
07.04.02.02;40.08.00.01
07.04.02.03;40.08.00.01
07.04.03.01;40.08.00.01
07.04.03.02;40.08.00.01
07.04.03.03;40.08.00.01
07.05.01;40.08.00.01
08.01.01.01;20.01.01.06
08.01.02.01;00.01.01.03
08.01.03.01;20.02.06.01
08.01.03.02;20.02.06.05
08.01.03.03;20.04.00.01
08.01.03.04;20.02.06.02
08.01.03.05;20.04.00.05
08.01.04.01;20.02.06.09
08.01.04.02;20.02.06.09
08.02.01.01;20.02.01.01
08.02.01.02;20.02.03.05
08.02.01.03;20.02.01.02
08.02.01.04;20.02.01.02
08.02.01.05;20.02.01.03
08.02.01.06;20.02.01.03
08.02.01.07;20.02.01.01
08.02.01.08;20.02.01.01
08.02.01.09;20.02.01.01
08.03.01.01;20.04.00.05
08.03.01.02;20.04.00.01
08.03.01.03;20.04.00.05
08.03.01.04;20.04.00.04
08.03.01.05;20.04.00.02
08.03.01.06;20.04.00.03
08.03.02.01;00.01.01.12
08.04.01.01;20.02.04.01
08.04.01.02;20.03.02.01
08.04.02.01;20.10.00.08
08.04.02.02;20.10.00.08
08.04.02.03;20.02.04.01
08.04.02.04;20.03.04.01
08.04.03.01;20.03.04.01
08.04.03.02;20.03.04.02
08.04.03.03;20.03.02.02
08.04.03.04;00.01.01.12
08.04.04.01;00.01.01.12
08.04.04.02;00.01.01.13
08.04.04.03;00.01.01.13
08.04.06.01;20.02.09.03
08.04.07.01;20.03.02.02
08.04.07.02;20.02.05.04
08.04.07.03;20.03.02.02
08.04.07.04;20.03.02.02
08.04.07.05;20.02.05.05
08.04.07.06;20.02.05.05
08.04.08.01;90.06.00.01
08.04.08.02;20.02.07.01
08.04.08.03;20.02.07.02
08.04.08.04;20.02.05.02
08.04.08.05;20.02.05.01
08.05.01.01;20.01.01.02
08.05.01.02;20.05.00.06
08.05.01.03;20.05.00.06
08.05.01.04;20.05.11.04
08.05.01.05;20.01.01.02
08.05.02.01;20.05.11.06
08.05.02.02;20.05.11.12
08.05.03.01;20.05.11.12
08.05.04.01;20.05.04.01
08.05.04.02;10.05.00.05
08.05.04.03;20.05.05.02
08.05.04.04;20.05.00.03
08.05.04.05;20.05.06.01
08.05.04.06;20.05.03.01
08.05.04.07;10.05.00.05
08.05.05.01;10.04.00.07
08.05.05.02;20.05.07.01
08.05.05.03;30.01.02.05
08.05.05.04;20.08.01.01
08.05.05.05;10.05.00.05
08.05.06.01;20.10.00.09
08.05.06.02;20.10.00.09
08.05.06.03;20.10.00.09
08.05.06.04;20.05.11.12
08.05.06.04.01;20.10.00.09
08.05.07.01;20.06.01.08
08.05.07.02;20.08.02.06
08.05.07.03;20.06.01.08
08.05.07.04;20.08.02.06
08.05.07.05;20.08.02.06
08.05.07.06;20.06.01.02
08.05.07.07;20.08.02.04
08.05.07.08;20.08.02.05
08.05.07.09;20.08.02.03
08.05.07.10;20.08.02.02
08.05.07.11;20.06.01.01
08.05.08.01;30.03.00.01
08.05.08.02;20.05.10.06
08.05.08.03;20.05.10.05
08.05.08.04;20.05.10.06
08.05.08.05;20.05.10.06
08.05.08.06;20.06.02.01
08.05.08.07;20.06.02.03
08.05.08.08;20.06.02.01
08.05.08.09;20.06.02.03
08.05.08.10;20.06.00.02
08.05.08.11;20.06.00.03
08.05.08.12;20.06.00.04
08.05.08.13;20.06.00.05
08.05.08.14;20.06.02.02
08.05.09.01;20.05.08.01
08.05.09.02;20.05.08.02
08.05.09.03;20.05.08.02
08.05.09.04;20.05.08.01
08.05.09.05;20.05.08.02
08.05.10.01;20.05.10.03
08.05.10.02;20.05.10.03
08.05.10.03;20.05.10.03
08.05.11;20.05.00.03
08.06.01.01;20.05.08.02
08.06.01.02;20.08.01.02
08.06.01.03;20.08.01.05
08.06.01.04;20.08.01.03
08.06.01.05;20.08.01.01
08.06.01.06;20.08.01.04
08.06.01.07;20.08.01.07
08.06.02.01;20.02.09.03
08.06.02.02;20.02.09.03
08.06.02.03;20.02.06.08
08.06.02.04;20.02.06.08
08.06.02.05;20.08.03.04
08.06.03.01;20.08.04.01
08.06.03.02;20.08.04.01
08.06.03.03;20.08.04.01
08.06.03.04;20.08.04.01
08.07.01;20.08.05.01
08.07.02;20.08.05.01
08.07.03;20.08.05.01
08.07.04;20.08.05.05
08.07.05;20.08.05.05
08.07.06;00.12.00.11
08.07.07;20.08.05.01
08.07.08;20.08.05.01
08.07.09;20.08.05.05
08.07.10;20.08.05.01
09.00.00.00;90.00.00.02
09.00.00.04;90.00.00.04
09.00.00.05;90.00.00.04
09.00.00.06;90.00.00.04
09.00.00.07;90.00.00.01
09.00.00.08;90.00.00.04
09.00.00.09;90.00.00.04
09.00.00.10;90.00.00.04
09.00.00.11;90.00.00.04
09.00.00.12;90.00.00.04
09.00.00.13;90.02.01.07
09.00.00.14;90.00.00.04
09.00.02;90.00.00.02
09.01.02;90.00.00.03
09.01.03;90.00.00.01
09.01.04;20.06.00.06
09.01.05;90.02.00.01
09.02.01;90.01.00.01
09.02.02.01;90.02.00.18
09.02.02.03;90.01.00.01
09.02.03.01;90.01.00.01
09.02.04.01;90.01.00.01
09.02.04.02;90.01.01.01
09.02.04.03;90.01.01.01
09.02.04.04;90.01.01.01
09.02.04.05;90.01.01.01
09.02.04.08;90.01.00.01
09.02.04.09;90.02.00.18
09.02.04.10;90.02.00.18
09.02.04.11;90.02.00.18
09.02.05.01;90.01.02.01
09.02.05.02;90.01.02.01
09.02.05.03;90.01.02.01
09.02.05.04;90.00.00.01
09.02.05.05;90.01.02.01
09.02.05.06;90.02.01.07
09.03.01.01;90.02.00.06
09.03.01.02;00.10.03.02
09.03.01.03;00.10.03.02
09.03.01.04;90.02.00.01
09.03.01.05;90.02.00.02
09.03.01.06;90.01.00.01
09.03.01.07;90.02.00.04
09.03.01.08;90.02.00.04
09.03.01.09;90.02.00.05
09.03.01.10;90.02.00.04
09.03.02.01;90.02.00.14
09.03.02.02;90.02.00.15
09.03.02.03;90.02.00.15
09.03.02.04;90.02.00.15
09.03.02.05;90.02.00.16
09.03.02.06;90.02.00.17
09.03.02.07;90.02.00.18
09.03.02.08;90.02.00.19
09.03.02.09;90.02.00.20
09.03.02.10;90.02.00.16
09.03.02.11;90.00.00.05
09.03.02.12;90.04.00.01
09.03.02.13;90.02.00.12
09.03.03.01;90.02.01.01
09.03.03.02;90.02.01.02
09.03.03.03;90.02.01.03
09.03.03.04;90.02.01.04
09.03.03.05;00.01.01.05
09.03.03.06;90.02.01.07
09.03.03.07;90.02.01.05
09.03.04.01;90.02.01.06
09.03.05.01;90.02.01.07
09.03.05.02;00.01.01.05
09.03.05.03;90.02.01.07
09.03.05.04;00.10.04.01
09.03.05.05;90.02.01.07
09.03.06.01;00.10.04.01
09.03.06.02;90.07.00.01
09.03.07.01;90.03.00.01
09.03.08.01;90.03.01.02
09.03.08.02;90.03.01.02
09.03.08.03;10.04.00.05
09.03.08.04;00.01.01.05
09.03.08.05;00.01.01.05
09.03.08.06;90.03.01.01
09.03.08.07;10.04.00.05
09.03.08.08;10.04.00.05
09.03.09.01;00.01.01.05
09.03.09.02;90.03.02.01
09.03.09.03;90.03.02.02
09.03.10.01;90.02.00.06
09.03.11;40.01.02.01
09.04.01;40.01.01.04
09.04.02;40.01.01.04
09.05.01.01;00.01.01.05
09.05.01.02;90.05.01.01
09.05.01.03;00.01.01.05
09.05.01.04;90.05.01.01
09.05.01.05;90.05.01.02
09.05.01.06;90.05.01.03
09.05.02.01;90.05.02.01
09.05.02.02;90.05.02.02
09.05.02.03;90.05.02.04
09.05.02.04;90.05.02.03
09.05.03.01;20.07.00.04
09.05.03.02;20.07.00.05
09.05.03.03;90.05.00.03
09.05.03.04;20.07.00.03
09.05.03.05;20.07.00.01
09.05.03.06;00.01.01.05
09.05.04;90.02.00.01
09.05.04.01;00.01.01.05
09.05.04.02;00.01.01.05
09.05.04.03;00.01.01.05
09.05.04.04;90.02.00.01
09.06.01;00.01.01.05
09.06.02;00.01.01.05
09.06.03;00.01.01.05
09.06.04;90.06.00.01
09.06.05;90.06.00.01
09.06.06;90.06.00.01
09.07.01;90.07.00.01
09.07.02;90.07.00.02
09.07.03;90.07.00.03
09.07.04;90.07.00.04
09.07.05;90.07.00.05
09.07.06;90.07.00.05
09.07.07;90.07.00.05
09.07.08;00.01.01.05
09.08.01;90.08.00.01
09.08.02.01;90.08.01.01
09.08.02.02;90.08.01.02
09.08.02.03;90.08.01.03
09.08.02.04;90.08.01.01
09.08.02.05;20.10.00.06
09.08.02.06;90.08.01.01
09.09;20.10.00.08
11;00.10.00.02
90.95;00.01.01.05
90.96;00.01.01.05
90.97;00.01.01.05
90.98;00.01.01.05
90.99;00.01.01.05
90.99.01;00.01.01.05
');

   $objMapeamentoAssuntoRN = new MapeamentoAssuntoRN();

   InfraDebug::getInstance()->setBolDebugInfra(true);

   InfraDebug::getInstance()->gravar('MAPEAMENTOS:');

   foreach($arrMapeamentos as $strMapeamento){
     $arr = explode(';',$strMapeamento);

     $objAssuntoDTO = new AssuntoDTO();
     $objAssuntoDTO->setBolExclusaoLogica(false);
     $objAssuntoDTO->retNumIdAssunto();
     $objAssuntoDTO->setStrCodigoEstruturado($arr[0]);
     $objAssuntoDTO->setStrSinAtualTabelaAssuntos('S');
     $objAssuntoDTO->setNumIdTabelaAssuntos($objTabelaAssuntoDTO->getNumIdTabelaAssuntos(), InfraDTO::$OPER_DIFERENTE);

     $objAssuntoDTOOrigem = $objAssuntoRN->consultarRN0256($objAssuntoDTO);

     if ($objAssuntoDTOOrigem==null) {
       InfraDebug::getInstance()->gravar($arr[0].': NAO ENCONTRADO');
     }

     if ($objAssuntoDTOOrigem!=null) {

       $objAssuntoDTO = new AssuntoDTO();
       $objAssuntoDTO->setBolExclusaoLogica(false);
       $objAssuntoDTO->retNumIdAssunto();
       $objAssuntoDTO->setStrCodigoEstruturado($arr[1]);
       $objAssuntoDTO->setNumIdTabelaAssuntos($objTabelaAssuntoDTO->getNumIdTabelaAssuntos(), InfraDTO::$OPER_IGUAL);

       $objAssuntoDTODestino = $objAssuntoRN->consultarRN0256($objAssuntoDTO);

       if ($objAssuntoDTODestino==null) {
         InfraDebug::getInstance()->gravar($arr[1].': NAO ENCONTRADO');
       }

       if ($objAssuntoDTODestino!=null) {

         $objMapeamentoAssuntoDTO = new MapeamentoAssuntoDTO();
         $objMapeamentoAssuntoDTO->setNumIdAssuntoOrigem($objAssuntoDTOOrigem->getNumIdAssunto());
         $objMapeamentoAssuntoDTO->setNumIdAssuntoDestino($objAssuntoDTODestino->getNumIdAssunto());

         InfraDebug::getInstance()->gravar($arr[0] . ' --> ' . $arr[1]);


         $objMapeamentoAssuntoRN->cadastrar($objMapeamentoAssuntoDTO);
       }
     }
   }

   $objAssuntoDTO = new AssuntoDTO();
   $objAssuntoDTO->setStrSinEstrutural('N');
   $objAssuntoDTO->setStrCodigoEstruturado('00.07');
   $objAssuntoDTO->setNumIdAssunto(1595);
   $objAssuntoDTO->setStrSinAtualTabelaAssuntos('S');
   $objAssuntoDTO->setNumIdTabelaAssuntos($objTabelaAssuntoDTO->getNumIdTabelaAssuntos(), InfraDTO::$OPER_DIFERENTE);

   if ($objAssuntoRN->contarRN0249($objAssuntoDTO)==1){
     $objAssuntoDTO->setStrSinEstrutural('S');
     $objAssuntoBD = new AssuntoBD(BancoSEI::getInstance());
     $objAssuntoBD->alterar($objAssuntoDTO);
   }

    BancoSEI::getInstance()->confirmarTransacao();
    BancoSEI::getInstance()->fecharConexao();

		InfraDebug::getInstance()->gravar('FIM');

	}catch(Exception $e){

	  try {
      BancoSEI::getInstance()->cancelarTransacao();
    }catch(Exception $e){}

    try {
      BancoSEI::getInstance()->fecharConexao();
    }catch(Exception $e){}

    echo(InfraException::inspecionar($e));
		try{LogSEI::getInstance()->gravar(InfraException::inspecionar($e));	}catch (Exception $e){}
	}
?>