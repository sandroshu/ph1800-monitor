# ph1800-monitor
Hybrid Solar Inverter monitoring script with Zabbix Template. Tested with GreenCell inverter (Must inverters should work too)


## How to

This project was developed to run on a Pine64 board with ARM cpu. Running this on a Raspberry Pi should be no different.
To run this on an x86 system you need to compile aquarat's must_inverter wrapper.
I am using DietPi OS (but Raspbian, Debian, Ubuntu should work too).

 - Get the compiled armhf build and put it in `/mnt/dietpi_userdata/MonoInverter`: https://github.com/aquarat/must_inverter
 - Install `mono-full` and `php-cli` on your OS
 - Connect your PH1800 inverter to your SBC with USB (get a shielded cable if possible, included one can cause problems)
 - Enter the MonoInverter directory and check if the connection works: `mono MonoInverter.exe`
   (you should see a JSON object in return with values. If you see null as values, reset the inverter)
 - Go one level up (/mnt/dietpi_userdata) and clone my repo: https://github.com/sandroshu/ph1800-monitor.git
 - Enter the ph1800-monitor directory and make MonoInverter.sh executable: `chmod +x MonoInverter.sh`
 - Set up a cronjob that runs this command every minute: `flock -n /tmp/monoinverter.poller -c "/mnt/dietpi_userdata/ph1800-monitor/MonoInverter.sh"`
   (Optionally you could create a systemd service that runs the MonoInverter.php script every x seconds, 15+s recommended)

 At this point you have monitoring active and every parameter with its value gets written to /tmp/MonoInverter/* every time the script runs.

 To get Zabbix monitoring working, follow these steps:
 - Install `zabbix-agent` on your OS
 - Configure Zabbix according to your setup (optionally install Zabbix server too if you don't already have one)
 - Copy zabbix_ph1800.conf from my repo to `/etc/zabbix/zabbix_agentd.conf.d/`
 - Make MonoInverter.data.sh executable in cloned dir `chmod +x MonoInverter.data.sh`
 - Restart zabbix-agent
 - Import zabbix_ph1800_template.xml to your Zabbix server as a template
 - Add the template to the Host
 - Check if theres data from the Inverter in Latest data of the host


Information on how to install and Configure Zabbix Server, OS packages and git can be found on a bunch of sites.

I still need more info to document the Inverter parameters better, it's not 100% yet and some are missing from the Zabbix template too.

### Feel free to contribute to the project and add/correct these.

![zabbix demo](https://github.com/sandroshu/ph1800-monitor/blob/main/zabbix.png?raw=true)

