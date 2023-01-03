#!/bin/bash
if [ "$(whoami)" != "root" ]; then
    SUDO=sudo
fi

echo -e "\e[1;34mCheck what OS you are running...\e[0m"
distro=$(lsb_release -i -s)
version=$(lsb_release -r -s)
echo -e "Distribution: \e[32m$distro\e[0m"
echo -e "Version: \e[32m$version\e[0m"

echo -e "\e[1;34mRequired packages\e[0m"

if ! which nginx > /dev/null 2>&1; then
    read -n1 -p "nginx is not present, do you want to install nginx(y/n): " install_nginx 
    if [ "$install_nginx" == "y" ];
    then
    ${SUDO} wget -qO- https://nginx.org/keys/nginx_signing.key | sudo apt-key add -
    ${SUDO} sh -c 'echo "deb https://nginx.org/packages/mainline/$distro/ $(lsb_release -sc) nginx
deb-src https://nginx.org/packages/mainline/$distro $(lsb_release -sc) nginx" > /etc/apt/sources.list.d/nginx.list' 
    ${SUDO} apt install nginx -y
    echo $(nginx -v) TESTER
    fi
else
    echo -e "nginx     \e[32mOK\e[0m"
fi

if ! which php > /dev/null 2>&1; then
    read -n1 -p "php is not present, do you want to install php(y/n): " install_php 
    if [ "$install_php" == "y" ];
    then
    ${SUDO} apt install dirmngr ca-certificates software-properties-common gnupg gnupg2 apt-transport-https curl -y
        if [ "$distro" == "Debian" ];
        then
        curl -sSL https://packages.sury.org/php/README.txt | ${SUDO} bash -x
        echo "Add repo to apt"
        fi
        if [ "$distro" == "Ubuntu" ];
        then
        ${SUDO} add-apt-repository ppa:ondrej/php
        fi
    ${SUDO} apt update
    ${SUDO} apt list --upgradable
    ${SUDO} apt upgrade -y
    ${SUDO} apt install php8.2 php8.2-cli php8.2-fpm php8.2-sqlite3 -y
    echo $(php -v)
    fi
else
    echo -e "php       \e[32mOK\e[0m"
fi

if ! which mosquitto > /dev/null 2>&1; then
    read -n1 -p "mosquitto is not present, do you want to install mosquitto(y/n): " install_mqtt 
    case $install_mqtt in  
    y|Y) ${SUDO} apt install mosquitto -y ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "mosquitto \e[32mOK\e[0m"
fi

if ! which node > /dev/null 2>&1; then
    read -n1 -p "node.js is not present, do you want to install node.js(y/n): " install_nodejs 
    case $install_nodejs in  
    y|Y) ${SUDO} apt install nodejs npm -y ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "node.js   \e[32mOK\e[0m"
fi

if ! which npm > /dev/null 2>&1; then
    read -n1 -p "npm is not present, do you want to install npm(y/n): " install_npm 
    case $install_npm in  
    y|Y) ${SUDO} apt install npm -y ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "npm       \e[32mOK\e[0m"
fi

if ! which pm2 > /dev/null 2>&1; then
    read -n1 -p "pm2 is not present, do you want to install pm2(y/n): " install_pm2 
    case $install_pm2 in  
    y|Y) npm install pm2 -g ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "pm2       \e[32mOK\e[0m"
fi

npm install --omit=dev
echo ""
read -n1 -p "Create nginx config (this will delete the default file) ?
If you select no, you need to create your own nginx config (y/n): " create_nginx_config 
    if [ "$create_nginx_config" == "y" ];
    then
        echo -e "\e[1;34mBegin configuration: \e[0m"
        webport="80"
        socketport="81"
        hostname="localhost"
        read -p "Web port (default: 80): " webport
        read -p "Websocket port (default: 81): " socketport
        read -p "Web hostname (default: localhost): " hostname
        cat << EOF >> /etc/nginx/conf.d/homeqtt.conf
        server {
            listen $webport;
            listen [::]:$webport;

            server_name  $localhost;
            index  index.php;

            autoindex off;

            location / {
                root /opt/homeqtt/web;
                try_files \$uri \$uri/ \$uri.php;
                index index.php;
            }

            location ~ \.php$ {
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass unix:/run/php/php8.2-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
                include fastcgi_params;
            }

            location /socket.io/ {
                proxy_pass http://localhost:$socketport;
                proxy_http_version 1.1;
                proxy_set_header Upgrade \$http_upgrade;
                proxy_set_header Connection "Upgrade";
                proxy_set_header Host \$host;
            }
        }
EOF
    fi

#read -p "Do you want to create mosquitto user (y/n):" create_mqtt_user
#if [ "$create_mqtt_user" == "y" ];
#then
#pass_output=$(tr -cd '[:alnum:]' < /dev/urandom | fold -w12 | head -n 1)
#echo -e "\e[1;31mSAVE THIS DATA FOR LATER: \e[0m"
#echo "MQTT username: homeqtt"
#echo "MQTT password: $pass_output"
#mosquitto_passwd -b /etc/mosquitto/passwd homeqtt 
#fi