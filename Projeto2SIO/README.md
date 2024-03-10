
	Dando uma pequena introdução base de como proceder com a instalação primeiro é importante mencionar a necessidade do uso do:

		- PHP 8.2.12
		- Apache 2.4.58
		- MariaDB 15.1

	Os arquivos de configuração estão presentes na pasta configs/ onde na mesma tem:

		- admin_accounts.txt -> Onde tem os utilizadores da base de dados e do website + como criar o utilizador app_sec_mysql_user_n_1
		- mariadb.cnf -> Arquivo com a configuração do MariaDB
		- keygenerator.sh -> Script em bash para criar as chaves necessarias para criptografar a base de dados
		- apache2.conf -> Arquivo com a configuração do Apache2

	Os arquivos de configuração devem ir para estas pastas:

		- mariadb.conf -> /etc/mysql/
		- apache2.conf -> /etc/apache2/


