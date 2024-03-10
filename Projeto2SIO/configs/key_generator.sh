

#!/bin/bash

echo "Digite quantas chaves pretende gerar:"
read userInput

if [[ $userInput =~ ^[1-9][0-9]*$ ]]; then
	intValue=$((userInput))
	mkdir -p /etc/mysql/rest
	# Este for gera as chaves que queremos e armazena no arquivo /etc/mysql/rest/keyfile
	for i in $(seq 1 $intValue); do
		echo -n "$i;" ; openssl rand -hex 32
	done | sudo tee -a /etc/mysql/rest/keyfile
	# Gera uma password de 128 caracteres que é armazenado /etc/mysql/rest/keyfile.key
	sudo openssl rand -hex 128 | sudo tee -a /etc/mysql/rest/keyfile.key
	# Gera um arquivo criptografado em /etc/mysql/rest/keyfile.enc com as chaves
	# guardadas em /etc/mysql/rest/keyfile
	# através da password armazenada em file:/etc/mysql/rest/keyfile.key
	openssl enc -aes-256-cbc -md sha1 -pass file:/etc/mysql/rest/keyfile.key -in /etc/mysql/rest/keyfile -out /etc/mysql/rest/keyfile.enc
	# Apaga o arquivo não criptografado com as chaves
	rm /etc/mysql/rest/keyfile
	chown mysql:mysql -R /etc/mysql/rest
	chmod 600 /etc/mysql/rest/*
	echo "Exit..."
else
    echo "Por favor, insira um número inteiro positivo!\nExit..."
fi


