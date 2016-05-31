EJECUTAR ESTO EN EL SERVER
Habilitar Regla para conexiones entrantes al node server

sudo iptables -I INPUT -p tcp --dport 5140 -j ACCEPT

Configurar Mysql para que haga binary log en la base.

[mysqld]
# Must be unique integer from 1-2^32
server-id        = 1
# Row format required for ZongJi
binlog_format    = row
# Directory must exist. This path works for Linux. Other OS may require
#   different path.
log_bin          = /var/log/mysql/mysql-bin.log

binlog_do_db     = live_data   # Optional, limit which databases to log
expire_logs_days = 10          # Optional, purge old logs
max_binlog_size  = 100M        # Optional, limit log size
