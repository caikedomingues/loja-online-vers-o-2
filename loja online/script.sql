

create database loja;

use loja;

create table pessoas(

nome text not  null,

cpf varchar(11) not null,

senha text,

email text not null,

criado_em timestamp default current_timestamp,/*ira guardar a data e a hora da criação
da conta*/

atualizado_em timestamp default current_timestamp on update current_timestamp,/*Ira guardar a data e a hora que os registros foram atualizados*/

foto text,

saldo_compra float not null,


primary key(cpf)

)default charset = utf8;


create table administradores(
	cpf_adm varchar(11) not null,
    
    email_adm text not null,
    
    senha_adm text not null,
    
    primary key(cpf_adm)

)default charset = utf8;

create table produtos(

codigo_produto varchar(4) not null,

quantidade_produto int not null,

nome_produto text not null,

preco_produto float not null,

descricao_produto text not null,

prazo_entrega text not null,

imagem_produto text not null,

primary key(codigo_produto)

)default charset = utf8;

create table carrinho(

id int auto_increment not null,

codigo_produto_adquirido varchar(4) not null, 

nome_produto_adquirido text not null,

preco_produto_adquirido float not null,

prazo_entrega_produto_adquirido text,

dono_carrinho varchar(11),

primary key(id)/*chave primária*/

)default charset = utf8;

/*Vamos atualizar a tabela do carrinho adicionando a coluna total de compras*/
alter table carrinho add column total_compra int;

/*Como eu tive que ajustar o metodo de inserção de clientes para possibilitar que um
carrinho seja criado para cada cliente, vamos apagar manualmente os dados da tabela 
 pessoas para inserir novamente os dados.*/
 
 /*desabilitando o modo seguro sql*/
 
 SET SQL_SAFE_UPDATES = 0;
 
 delete from carrinho;
 delete from pessoas;
/*inserção do primeiro usuário administrador*/
insert into administradores(cpf_adm, email_adm, senha_adm) values('23345', 'caike.dom@gmail.com', '12345');

/*Vamos alterar a tabela de carrinho para adicionar a imagem do produto escolhido
pelo usuário*/
alter table carrinho add column imagem_produto_adquirido text;

/*Alterando a tabela de produtos para adicionar uma coluna que será a quantidade de vendas daquele
produto.*/
alter table produtos add column quant_vendas int;

# atualizando a tabela de quantidade de vendas para iniciar
# a contagem no 0

update produtos set quant_vendas = 0;

/*Seleções dos dados*/
select * from pessoas;
select * from carrinho;
select * from administradores;
select * from produtos;





