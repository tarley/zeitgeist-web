-- ------------------------------------------------------------------------------
-- Insert tb_tipo_template_dado (Três tipos identificados: string, texto, imagem)
-- ------------------------------------------------------------------------------

INSERT INTO tb_tipo_template_dado (id_tipo_template_dado, desc_tipo_template_dado) 
VALUES (1, "string");

INSERT INTO tb_tipo_template_dado (id_tipo_template_dado, desc_tipo_template_dado) 
VALUES (2, "texto");

INSERT INTO tb_tipo_template_dado (id_tipo_template_dado, desc_tipo_template_dado) 
VALUES (3, "imagem");

-- ----------------------------------------------------------------
-- Insert do primeiro template – 1 metadado (imagem) - Padrão Capa
-- ----------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (1, "Somente imagem");

-- Metadado imagem
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Somente imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"imagem",
    	"Inserir Imagem",
    	1);

-- -------------------------------------------------------------------------------------------------------------------
-- Insert do segundo template – 5 metadados (imagem, nome_pagina, titulo_texto, texto, autor_texto) - Padrão Editorial
-- -------------------------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (2, "Texto simples com imagem");

-- Metadado imagem
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"imagem",
    	"Inserir Imagem",
    	1);
        
-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
    	2);

-- Metadado titulo_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_texto",
    	"Título do texto",
	   3);

-- Metadado texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto",
    	"Texto",
	   4);

-- Metadado autor_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"autor_texto",
    	"Autor",
	   5);

-- -------------------------------------------------------------------------------------------------------------------------------
-- Insert do terceiro template – 5 metadados (titulo, nome_jornal, desc_produtores, contato, logo_instituicao) - Padrão expediente
-- -------------------------------------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (3, "Expediente");

-- Metadado titulo
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Expediente"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo",
    	"Título",
	   1);

-- Metadado nome_jornal
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Expediente"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_jornal",
    	"Nome do jornal",
	   2);

-- Metadado desc_produtores
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Expediente"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"desc_produtores",
    	"Descrição dos produtores",
	   3);

-- Metadado contato
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Expediente"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"contato",
    	"Contato",
	   4);

-- Metadado logo_instituição
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Expediente"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"logo_instituicao",
    	"Logo da Instituição",
	   5);

-- ----------------------------------------------------------------------------------------------------------------------------------
-- Insert do quarto template – 6 metadados (imagem, nome_pagina, autor_texto, desc_autor, titulo_texto, texto) - Padrão Com a Palavra
-- ----------------------------------------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (4, "Texto simples com imagem e detalhamento de autor");

-- Metadado imagem
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"imagem",
    	"Inserir imagem",
	   1);

-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
	   2);

-- Metadado autor_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"autor_texto",
    	"Autor",
	   3);

-- Metadado desc_autor
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"desc_autor",
    	"Descrição do autor",
	   4);

-- Metadado titulo_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_texto",
    	"Título do texto",
	   5);

-- Metadado texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples com imagem e detalhamento de autor"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto",
    	"Texto",
	   6);

-- --------------------------------------------------------------------------------------------------------------
-- Insert do quinto template – 4 metadados (nome_pagina, titulo_texto, texto, autor_texto) - Padrão comportamento
-- --------------------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (5, "Texto simples sem imagem");

-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
	   1);

-- Metadado titulo_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_texto",
    	"Título do texto",
	   2);

-- Metadado texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto",
    	"Texto",
	   3);

-- Metadado autor_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto simples sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"autor_texto",
    	"Autor",
	   4);

-- ------------------------------------------------------------------------------------------------------------------------
-- Insert do sexto template – 5 metadados (nome_pagina, titulo_texto, texto1, texto2, autor_texto) - Padrão comportamento 2
-- ------------------------------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (6, "Texto duplo sem imagem");

-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto duplo sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
	   1);

-- Metadado titulo_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto duplo sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_texto",
    	"Título do texto",
	   2);

-- Metadado texto1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto duplo sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto1",
    	"Primeiro Texto",
	   3);

-- Metadado texto2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto duplo sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto2",
    	"Segundo texto",
	   4);

-- Metadado autor_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto duplo sem imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"autor_texto",
    	"Autor",
	   5);

-- -----------------------------------------------------------------------------------------------------
-- Insert do sétimo template – 4 metadados (nome_pagina, imagem, titulo_texto, texto) - Padrão Fale mais
-- -----------------------------------------------------------------------------------------------------

INSERT INTO tb_template (id_template, desc_template) VALUES (7, "Texto livre com imagem");

-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto livre com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
	   1);

-- Metadado imagem
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto livre com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"imagem",
    	"Inserir imagem",
	   2);

-- Metadado titulo_texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto livre com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_texto",
    	"Título do texto",
	   3);

-- Metadado texto
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Texto livre com imagem"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto",
    	"Texto",
	   4);

-- -----------------------------------------------------------
-- Insert do oitavo template – 25 metadados - Padrão indicador
-- -----------------------------------------------------------
/*
nome_pagina
autor
grupo1
	grupo1_titulo1
		grupo1_titulo1_texto1
		grupo1_titulo1_imagem1
	grupo1_titulo2
		grupo1_titulo2_texto2
		grupo1_titulo2_imagem2
grupo2
	grupo2_titulo1
		grupo2_titulo1_texto1
		grupo2_titulo1_imagem1
	grupo2_titulo2
		grupo2_titulo2_texto2
		grupo2_titulo2_imagem2
grupo3
	grupo3_titulo1
		grupo3_titulo1_texto1
		grupo3_titulo1_imagem1
	grupo3_titulo2
		grupo3_titulo2_texto2
		grupo3_titulo2_imagem2
titulo_rodape
	texto_rodape
*/

INSERT INTO tb_template (id_template, desc_template) VALUES (8, "Grupos de texto e fotos");

-- Metadado nome_pagina
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"nome_pagina",
    	"Nome da página",
	   1);

-- Metadado autor
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"autor",
    	"Autor",
	   2);

-- -----------------------------------------------------------
-- Insert Grupo 1
-- -----------------------------------------------------------

-- Metadado grupo1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo1",
    	"Nome do primeiro grupo",
	   3);

-- Metadado grupo1 - título1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo1_titulo1",
    	"Título",
	   4);

-- Metadado grupo1 - título1 - texto1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo1_titulo1_texto1",
    	"Texto",
	   5);

-- Metadado grupo1 - título1 - imagem1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo1_titulo1_imagem1",
    	"Inserir imagem",
	   6);

-- Metadado grupo1 - título2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo1_titulo2",
    	"Título",
	   7);

-- Metadado grupo1 - título2 - texto2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo1_titulo2_texto2",
    	"Texto",
	   8);

-- Metadado grupo1 - título2 - imagem2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo1_titulo2_imagem2",
    	"Inserir imagem",
	   9);

-- -----------------------------------------------------------
-- Insert Grupo 2
-- -----------------------------------------------------------

-- Metadado grupo2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo2",
    	"Nome do segundo grupo",
	   10);

-- Metadado grupo2 - título1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo2_titulo1",
    	"Título",
	   11);

-- Metadado grupo2 - título1 - texto1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo2_titulo1_texto1",
    	"Texto",
	   12);

-- Metadado grupo2 - título1 - imagem1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo2_titulo1_imagem1",
    	"Inserir imagem",
	   13);

-- Metadado grupo2 - título2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo2_titulo2",
    	"Título",
	   14);

-- Metadado grupo2 - título2 - texto2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo2_titulo2_texto2",
    	"Texto",
	   15);

-- Metadado grupo2 - título2 - imagem2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo2_titulo2_imagem2",
    	"Inserir imagem",
	   16);

-- -----------------------------------------------------------
-- Insert Grupo 3
-- -----------------------------------------------------------

-- Metadado grupo3
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo3",
    	"Nome do terceiro grupo",
	   17);

-- Metadado grupo3 - título1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo3_titulo1",
    	"Título",
	   18);

-- Metadado grupo3 - título1 - texto1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo3_titulo1_texto1",
    	"Texto",
	   19);

-- Metadado grupo3 - título1 - imagem1
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo3_titulo1_imagem1",
    	"Inserir imagem",
	   20);

-- Metadado grupo3 - título2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"grupo3_titulo2",
    	"Título",
	   21);

-- Metadado grupo3 - título2 - texto2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"grupo3_titulo2_texto2",
    	"Texto",
	   22);

-- Metadado grupo3 - título2 - imagem2
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "imagem"),
    	"grupo3_titulo2_imagem2",
    	"Inserir imagem",
	   23);

-- -----------------------------------------------------------
-- Insert Rodapé
-- -----------------------------------------------------------

-- Metadado titulo_rodape
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "string"),
    	"titulo_rodape",
    	"Título",
	   24);

-- Metadado texto_rodape
INSERT INTO tb_template_dado (
    id_template, 
    id_tipo_template_dado, 
    chave_template_dado, 
    desc_template_dado, 
    ordem_dados) 
VALUES (
	 (SELECT id_template FROM tb_template WHERE desc_template = "Grupos de texto e fotos"), 
   	 (SELECT id_tipo_template_dado FROM tb_tipo_template_dado WHERE desc_tipo_template_dado = "texto"),
    	"texto_rodape",
    	"Texto",
	   25);
-- -------------------------------------------------------------------------------------------------------------------
-- Fim do script
-- -------------------------------------------------------------------------------------------------------------------