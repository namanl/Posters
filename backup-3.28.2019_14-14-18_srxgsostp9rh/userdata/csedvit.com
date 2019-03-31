--- 
customlog: 
  - 
    format: combined
    target: /etc/apache2/logs/domlogs/csedvit.com
  - 
    format: "\"%{%s}t %I .\\n%{%s}t %O .\""
    target: /etc/apache2/logs/domlogs/csedvit.com-bytes_log
documentroot: /home/srxgsostp9rh/public_html
group: srxgsostp9rh
hascgi: 1
homedir: /home/srxgsostp9rh
ip: 43.255.154.29
owner: gdresell
phpopenbasedirprotect: 1
port: 80
scriptalias: 
  - 
    path: /home/srxgsostp9rh/public_html/cgi-bin
    url: /cgi-bin/
serveradmin: webmaster@csedvit.com
serveralias: mail.csedvit.com www.csedvit.com
servername: csedvit.com
usecanonicalname: 'Off'
user: srxgsostp9rh
