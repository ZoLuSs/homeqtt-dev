# In Dev
This project is under development and not finished.
You can try the dev version but at your own risk !

# Installation
>This instruction is based on root user

>The information is for installation on clean Debian or Ubuntu with no software installed.
    
>If you try to install on already use system, please refer to **Install homeqtt with other program**

To become temporarly root use ``sudo -s`` or use sudo before any command

## Download all the file: 
```bash
git clone git@github.com:ZoLuSs/homeqtt-dev /opt/homeqtt
```
## Install dependency
Go to the folder ``cd /opt/homeqtt``
```bash
.\install.sh
```
This will start the install process.

It will first check if all the needed software are installed.

You will be asked if you wan't to install every software needed.
You should answer **y** to all question.

### Configure nginx

The installer are asking you if you want to create nginx config.

You should answer **y**
After that you will be prompt for the web port, websocket port and hostname of your homeqtt system.
- Web port is by default 80, you can set anything you want
- **Websocket port should not be the same as the web port**
- Hostname is the url you gonna use to access homeqtt. If you want to access it from other device, set this to the IP of the system.

> If you have error at this step, refer to **Troubleshoot the install process**

# First launch

Everything is installed and you are now able to access to homeqtt with the url provide at the end of the installation. ``http://hostname:webport``

## Web config
### Create database or restore backup
Select create to continue the configuration process or upload your homeqtt.db file for restore a previous installation of homeqtt.
### Create user / password
> This is needed to access and protect your homeqtt installation
- Password should be strong

### Configure MQTT
> Important step, read carefully
>> All the step are going to overwrite your MQTT broker configuration

>> If you don't want to set 

You are now going to set the MQTT broker.
It's recommanded to use SSL communication with MQTT
