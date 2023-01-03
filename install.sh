#!/bin/bash
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
    sudo apt install nginx -y
    echo $(nginx -v) TESTER
    fi
else
    echo -e "nginx     \e[32mOK\e[0m"
fi

if ! which php > /dev/null 2>&1; then
    read -n1 -p "php is not present, do you want to install php(y/n): " install_php 
    if [ "$install_php" == "y" ];
    then
    sudo apt install dirmngr ca-certificates software-properties-common gnupg gnupg2 apt-transport-https curl -y
        if [ "$distro" == "Debian" ];
        then
        curl -sSL https://packages.sury.org/php/README.txt | sudo bash -x
        echo "Add repo to apt"
        fi
        if [ "$distro" == "Ubuntu" ];
        then
        sudo add-apt-repository ppa:ondrej/php
        fi
    sudo apt update
    sudo apt list --upgradable
    sudo apt upgrade -y
    sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-sqlite3 -y
    echo $(php -v)
    fi
else
    echo -e "php       \e[32mOK\e[0m"
fi

if ! which mosquitto > /dev/null 2>&1; then
    read -n1 -p "mosquitto is not present, do you want to install mosquitto(y/n): " install_mqtt 
    case $install_mqtt in  
    y|Y) sudo apt install mosquitto ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "mosquitto \e[32mOK\e[0m"
fi

if ! which node > /dev/null 2>&1; then
    read -n1 -p "node.js is not present, do you want to install node.js(y/n): " install_nodejs 
    case $install_nodejs in  
    y|Y) sudo apt install nodejs ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "node.js   \e[32mOK\e[0m"
fi

if ! which pm2 > /dev/null 2>&1; then
    read -n1 -p "node.js is not present, do you want to install node.js(y/n): " install_pm2 
    case $install_pm2 in  
    y|Y) npm install pm2 -g ;; 
    *) echo dont know ;; 
    esac
else
    echo -e "pm2       \e[32mOK\e[0m"
fi

npm install --omit=dev
echo ""
echo -e "\e[1;34mBegin configuration: \e[0m"

read -p "Web port (80 recommanded): " webport
read -p "hostname (Ex: localhost): " hostname


#read -p "Do you want to create mosquitto user (y/n):" create_mqtt_user
#if [ "$create_mqtt_user" == "y" ];
#then
#pass_output=$(tr -cd '[:alnum:]' < /dev/urandom | fold -w12 | head -n 1)
#echo -e "\e[1;31mSAVE THIS DATA FOR LATER: \e[0m"
#echo "MQTT username: homeqtt"
#echo "MQTT password: $pass_output"
#mosquitto_passwd -b /etc/mosquitto/passwd homeqtt 
#fi