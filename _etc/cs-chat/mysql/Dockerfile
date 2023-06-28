FROM mysql

# -----------------------------------------------------------------------------
### SERVER COMMON Configuration
# -----------------------------------------------------------------------------
RUN ln -sf /usr/share/zoneinfo/Asia/Seoul /etc/localtime
# -----------------------------------------------------------------------------

COPY my.cnf     /etc/mysql/my.cnf
COPY dumps      /var/mysql/dumps
COPY dumps_to_first_build.sh /var/mysql/

RUN mkdir -p /docker-volumes/log
RUN chmod 755 /docker-volumes/log

RUN mkdir -p /docker-volumes
RUN chown mysql:mysql /docker-volumes
CMD ["mysqld"]
