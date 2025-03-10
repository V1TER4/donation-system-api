# Donation System API

## Passo 1: Clonar o repositório
Faça o clone do repositório do projeto:
```sh
git clone https://github.com/V1TER4/donation-system-api.git
cd donation-system-api
```

## Passo 2: Instalar dependências
Instale as dependências necessárias para o PHP 8.2:
```sh
sudo apt update && sudo apt install -y php8.2-fpm php8.2-mysql php8.2-zip php8.2-xml unzip
```

## Passo 3: Instalar o Composer e dependências do projeto
Se o Composer ainda não estiver instalado, instale-o:
```sh
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
Agora, instale as dependências do projeto:
```sh
composer install
```

## Passo 4: Configurar o arquivo `.env`
Copie o arquivo de exemplo e edite conforme necessário:
```sh
cp .env.example .env
```
Atualize as configurações do banco de dados:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

## Passo 5: Executar migrações e seeders
Após configurar o `.env`, execute os seguintes comandos:
```sh
php artisan migrate --seed
```

## Opções para executar o projeto

### Usando Nginx
1. Crie o arquivo de configuração do Nginx:
   ```sh
   sudo nano /etc/nginx/sites-available/donation-system-api
   ```
   Adicione o seguinte conteúdo:
   ```nginx
   server {
       listen 80;
       server_name exemplo.com;
       root /var/www/html/public;
       index index.php index.html index.htm;
   
       access_log /var/log/nginx/donation-system-api-access.log;
       error_log /var/log/nginx/donation-system-api-error.log;
   
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
   
       location ~ \.php$ {
           include fastcgi_params;
           fastcgi_pass unix:/run/php/php8.2-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       }
   
       location ~ /\.ht {
           deny all;
       }
   }
   ```
2. Crie um link simbólico para ativar a configuração:
   ```sh
   sudo ln -s /etc/nginx/sites-available/donation-system-api /etc/nginx/sites-enabled/
   ```
3. Teste a configuração do Nginx:
   ```sh
   sudo nginx -t
   ```
4. Reinicie o Nginx para aplicar as mudanças:
   ```sh
   sudo systemctl restart nginx
   ```
5. Configure o arquivo `/etc/hosts` (se necessário):
   ```sh
   sudo nano /etc/hosts
   ```
   Adicione a linha:
   ```
   127.0.0.1 exemplo.com
   ```

### Usando o servidor embutido do Laravel
Se preferir rodar o projeto sem configurar o Nginx, utilize:
```sh
php artisan serve
```
