
CREATE DATABASE IF NOT EXISTS BD_ZEITGEIST;

USE BD_ZEITGEIST;

/*==============================================================*/
/* Table: tb_jornal                                             */
/*==============================================================*/
CREATE TABLE tb_jornal
(
   id_jornal            smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_usuario           tinyint not null,
   id_situacao          tinyint not null,
   num_edicao_jornal    tinyint not null,
   nom_titulo_jornal    varchar(255) not null,
   dta_publicacao_jornal date,
   dta_ultima_atualizacao_jornal date
);

/*==============================================================*/
/* Table: tb_pagina                                             */
/*==============================================================*/
CREATE TABLE tb_pagina
(
   id_pagina            smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_jornal            smallint not null,
   id_template          smallint not null,
   num_pagina           tinyint not null,
   nom_pagina           varchar(50)
);

/*==============================================================*/
/* Table: tb_pagina_dado                                        */
/*==============================================================*/
CREATE TABLE tb_pagina_dado
(
   id_pagina_dado       smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_pagina            smallint not null,
   id_template_dado     smallint not null
);

/*==============================================================*/
/* Table: tb_pagina_imagem                                       */
/*==============================================================*/
CREATE TABLE tb_pagina_imagem
(
   id_pagina_imagem     smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_pagina_dado       smallint not null,
   valor_pagina_imagem  longblob
);

/*==============================================================*/
/* Table: tb_pagina_string                                      */
/*==============================================================*/
CREATE TABLE tb_pagina_string
(
   id_pagina_string     smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_pagina_dado       smallint not null,
   valor_pagina_string  varchar(255)
);

/*==============================================================*/
/* Table: tb_pagina_texto                                       */
/*==============================================================*/
CREATE TABLE tb_pagina_texto
(
   id_pagina_texto     smallint not null PRIMARY KEY,
   id_pagina_dado       smallint not null,
   valor_pagina_texto   text
);

/*==============================================================*/
/* Table: tb_situacao                                           */
/*==============================================================*/
CREATE TABLE tb_situacao
(
   id_situacao          tinyint not null PRIMARY KEY AUTO_INCREMENT,
   desc_situacao        varchar(30) not null
);

/*==============================================================*/
/* Table: tb_template                                           */
/*==============================================================*/
CREATE TABLE tb_template
(
   id_template          smallint not null PRIMARY KEY AUTO_INCREMENT,
   desc_template        varchar(50) not null,
   desc_caminho_template varchar(255)
);

/*==============================================================*/
/* Table: tb_template_dado                                      */
/*==============================================================*/
CREATE TABLE tb_template_dado
(
   id_template_dado     smallint not null PRIMARY KEY AUTO_INCREMENT,
   id_template          smallint not null,
   id_tipo_template_dado tinyint not null,
   chave_template_dado  varchar(50),
   desc_template_dado   varchar(255)
);

/*==============================================================*/
/* Table: tb_usuario                                            */
/*==============================================================*/
CREATE TABLE tb_usuario
(
   id_usuario           tinyint not null PRIMARY KEY AUTO_INCREMENT,
   nom_usuario          varchar(50) not null,
   email_usuario        varchar(50) not null,
   senha_usuario        varchar(255) not null
);

/*==============================================================*/
/* Table: tb_tipo_template_dado                                    */
/*==============================================================*/
CREATE TABLE tb_tipo_template_dado
(
   id_tipo_template_dado tinyint not null PRIMARY KEY AUTO_INCREMENT,
   desc_tipo_template_dado varchar(50) not null
);


ALTER TABLE tb_jornal ADD CONSTRAINT FK_situacao_jornal FOREIGN KEY (id_situacao)
      REFERENCES tb_situacao (id_situacao);

ALTER TABLE tb_jornal ADD CONSTRAINT FK_usuario_jornal FOREIGN KEY (id_usuario)
      REFERENCES tb_usuario (id_usuario);

ALTER TABLE tb_pagina ADD CONSTRAINT FK_paginas_jornal FOREIGN KEY (id_jornal)
      REFERENCES tb_jornal (id_jornal);

ALTER TABLE tb_pagina ADD CONSTRAINT FK_template_pagina FOREIGN KEY (id_template)
      REFERENCES tb_template (id_template);

ALTER TABLE tb_pagina_dado ADD CONSTRAINT FK_pagina_pagina_dado FOREIGN KEY (id_pagina)
      REFERENCES tb_pagina (id_pagina);

ALTER TABLE tb_pagina_dado ADD CONSTRAINT FK_pagina_template FOREIGN KEY (id_template_dado)
      REFERENCES tb_template_dado (id_template_dado);

ALTER TABLE tb_pagina_imagem ADD CONSTRAINT FK_imagem_da_pagina FOREIGN KEY (id_pagina_dado)
      REFERENCES tb_pagina_dado (id_pagina_dado);

ALTER TABLE tb_pagina_string ADD CONSTRAINT FK_string_da_pagina FOREIGN KEY (id_pagina_dado)
      REFERENCES tb_pagina_dado (id_pagina_dado);

ALTER TABLE tb_pagina_texto ADD CONSTRAINT FK_texto_da_pagina FOREIGN KEY (id_pagina_dado)
      REFERENCES tb_pagina_dado (id_pagina_dado);

ALTER TABLE tb_template_dado ADD CONSTRAINT FK_template_template_dado FOREIGN KEY (id_template)
      REFERENCES tb_template (id_template);

ALTER TABLE tb_template_dado ADD CONSTRAINT FK_tipo_template_dado FOREIGN KEY (id_tipo_template_dado)
      REFERENCES tb_tipo_template_dado (id_tipo_template_dado);

