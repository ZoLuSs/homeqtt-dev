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
# Config
npm install --omit=dev --silent
echo ""

echo -e "\e[1;34mConfig: \e[0m"
echo ""
if ${SUDO} useradd homeqtt -r; then
    echo -e "Create user homeqtt: \e[32mOK\e[0m"
else
    echo -e "Create user homeqtt: \e[31mError\e[0m"
fi
echo ""

phpV=$(phpquery -V | head -n 1)
read -n1 -p "Create php$phpV config ?
If you select no, you need to create your own php-fpm pool config for homeqtt (y/n): " create_php_config 
echo ""
if [ "$create_php_config" == "y" ];
then
    ${SUDO} cat << EOF > /etc/php/$phpV/fpm/pool.d/homeqtt.conf
; Start a new pool named 'www'.
; the variable \$pool can be used in any directive and will be replaced by the
; pool name ('www' here)
[homeqtt]

; Per pool prefix
; It only applies on the following directives:
; - 'access.log'
; - 'slowlog'
; - 'listen' (unixsocket)
; - 'chroot'
; - 'chdir'
; - 'php_values'
; - 'php_admin_values'
; When not set, the global prefix (or /usr) applies instead.
; Note: This directive can also be relative to the global prefix.
; Default Value: none
;prefix = /path/to/pools/\$pool

; Unix user/group of processes
; Note: The user is mandatory. If the group is not set, the default user's group
;       will be used.
user = homeqtt
group = homeqtt

; The address on which to accept FastCGI requests.
; Valid syntaxes are:
;   'ip.add.re.ss:port'    - to listen on a TCP socket to a specific IPv4 address on
;                            a specific port;
;   '[ip:6:addr:ess]:port' - to listen on a TCP socket to a specific IPv6 address on
;                            a specific port;
;   'port'                 - to listen on a TCP socket to all addresses
;                            (IPv6 and IPv4-mapped) on a specific port;
;   '/path/to/unix/socket' - to listen on a unix socket.
; Note: This value is mandatory.
listen = /run/php/php$phpV-fpm-homeqtt.sock

; Set permissions for unix socket, if one is used. In Linux, read/write
; permissions must be set in order to allow connections from a web server. Many
; BSD-derived systems allow connections regardless of permissions. The owner
; and group can be specified either by name or by their numeric IDs.
; Default Values: user and group are set as the running user
;                 mode is set to 0660
listen.owner = www-data
listen.group = www-data
;listen.mode = 0660
; When POSIX Access Control Lists are supported you can set them using
; these options, value is a comma separated list of user/group names.
; When set, listen.owner and listen.group are ignored
;listen.acl_users =
;listen.acl_groups =


; Choose how the process manager will control the number of child processes.
; Possible Values:
;   static  - a fixed number (pm.max_children) of child processes;
;   dynamic - the number of child processes are set dynamically based on the
;             following directives. With this process management, there will be
;             always at least 1 children.
;             pm.max_children      - the maximum number of children that can
;                                    be alive at the same time.
;             pm.start_servers     - the number of children created on startup.
;             pm.min_spare_servers - the minimum number of children in 'idle'
;                                    state (waiting to process). If the number
;                                    of 'idle' processes is less than this
;                                    number then some children will be created.
;             pm.max_spare_servers - the maximum number of children in 'idle'
;                                    state (waiting to process). If the number
;                                    of 'idle' processes is greater than this
;                                    number then some children will be killed.
;             pm.max_spawn_rate    - the maximum number of rate to spawn child
;                                    processes at once.
;  ondemand - no children are created at startup. Children will be forked when
;             new requests will connect. The following parameter are used:
;             pm.max_children           - the maximum number of children that
;                                         can be alive at the same time.
;             pm.process_idle_timeout   - The number of seconds after which
;                                         an idle process will be killed.
; Note: This value is mandatory.
pm = dynamic

; The number of child processes to be created when pm is set to 'static' and the
; maximum number of child processes when pm is set to 'dynamic' or 'ondemand'.
; This value sets the limit on the number of simultaneous requests that will be
; served. Equivalent to the ApacheMaxClients directive with mpm_prefork.
; Equivalent to the PHP_FCGI_CHILDREN environment variable in the original PHP
; CGI. The below defaults are based on a server without much resources. Don't
; forget to tweak pm.* to fit your needs.
; Note: Used when pm is set to 'static', 'dynamic' or 'ondemand'
; Note: This value is mandatory.
pm.max_children = 5

; The number of child processes created on startup.
; Note: Used only when pm is set to 'dynamic'
; Default Value: (min_spare_servers + max_spare_servers) / 2
pm.start_servers = 2

; The desired minimum number of idle server processes.
; Note: Used only when pm is set to 'dynamic'
; Note: Mandatory when pm is set to 'dynamic'
pm.min_spare_servers = 1

; The desired maximum number of idle server processes.
; Note: Used only when pm is set to 'dynamic'
; Note: Mandatory when pm is set to 'dynamic'
pm.max_spare_servers = 3

; The number of rate to spawn child processes at once.
; Note: Used only when pm is set to 'dynamic'
; Note: Mandatory when pm is set to 'dynamic'
; Default Value: 32
;pm.max_spawn_rate = 32

; The number of seconds after which an idle process will be killed.
; Note: Used only when pm is set to 'ondemand'
; Default Value: 10s
;pm.process_idle_timeout = 10s;

; The access log file
; Default: not set
access.log = /var/log/\$pool.access.log
EOF
    if ${SUDO} systemctl restart php$phpV-fpm; then
        echo -e "Restart php$phpV-fpm: \e[32mOK\e[0m"
    else
        echo -e "Restart php$phpV-fpm: \e[31mError\e[0m"
    fi
fi

read -n1 -p "Create nginx config (this will delete all the config file) ?
If you select no, you need to create your own nginx config (y/n): " create_nginx_config 
echo ""
if [ "$create_nginx_config" == "y" ];
then
    echo -e "\e[1;34mBegin configuration: \e[0m"
    read -p "Web port (default: 80): " webport
    if [ "$webport" == "" ];then webport="80"; fi
    read -p "Websocket port (default: 81): " socketport
    if [ "$socketport" == "" ];then socketport="81"; fi
    read -p "Web hostname (default: localhost): " hostname
    if [ "$socketport" == "" ];then hostname="localhost"; fi
    ${SUDO} systemctl stop nginx
    ${SUDO} rm -rf /etc/nginx/site-available
    ${SUDO} rm -rf /etc/nginx/site-enabled
    ${SUDO} rm -r /etc/nginx/conf.d/*
    ${SUDO} cat << EOF > /etc/nginx/conf.d/homeqtt.conf
server {
    listen $webport;
    listen [::]:$webport;

    server_name  $hostname;
    index  index.php;
    root /opt/homeqtt/web;
    autoindex off;

    location / {
        try_files \$uri \$uri/ \$uri.php;
        index index.php;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php$phpV-fpm-homeqtt.sock;
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
    echo -e "\e[1;34mRestart nginx...\e[0m"
        if ${SUDO} systemctl restart nginx; then
        echo -e "Restart nginx: \e[32mOK\e[0m"
    else
        echo -e "Restart nginx: \e[31mError\e[0m"
    fi
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
echo ""
echo -e "\e[1;34mCreating systemd service\e[0m"
echo -e "\e[31mDo not launch homeqtt via systemd !\e[0m"

${SUDO} cat << EOF > /lib/systemd/system/homeqtt.service
[Unit]
Description=HomeQTT - Control your home with MQTT protocol
Documentation=https://github.com/ZoLuSs/homeqtt/docs
After=network.targer

[Service]
Type=simple
User=homeqtt
ExecStart=/usr/bin/node /opt/homeqtt/app.js
Restart=on-failure

[Install]
WantedBy=multi-user.targer
EOF

${SUDO} systemctl daemon-reload


echo ""
homeqttSudoers="homeqtt ALL=NOPASSWD: /bin/systemctl"
if ! grep -q "$homeqttSudoers" "/etc/sudoers"; then
echo $homeqttSudoers >> "/etc/sudoers"
echo -e "\e[1;34mAllow homeqtt to manage systemctl\e[0m"
else
echo -e "\e[1;34mhomeqtt already allowed to manage systemctl\e[0m"
fi