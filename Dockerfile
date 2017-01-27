FROM centos:7

# Add mysql user and group first to make sure their IDs get assigned consistently,
# regardless of whatever dependencies get added.
RUN groupadd -r mysql && useradd -r -g mysql mysql

RUN rpm --import https://dl.fedoraproject.org/pub/epel/RPM-GPG-KEY-EPEL-7 && \
    rpm --import https://mirror.webtatic.com/yum/RPM-GPG-KEY-webtatic-el7 && \
    rpm --rebuilddb && \
    yum -y install centos-release-scl centos-release-scl-rh epel-release deltarpm && \
    rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

RUN yum -y update && yum clean all && \
    yum -y install zsh wget supervisor psmisc

SHELL ["/bin/zsh", "-lc"] 

RUN yum -y install httpd24 \
        php71w-fpm php71w-mysqlnd php71w-cli php71w-devel php71w-mbstring \
        php71w-xml php71w-intl php71w-process \
        less vim git && \
    yum -y groupinstall 'Development Tools'

# Compile and install XDebug extension for php
RUN mkdir -p /root/soft && cd /root/soft && \
    wget https://xdebug.org/files/xdebug-2.5.0.tgz && \
    tar xf xdebug-2.5.0.tgz && \
    cd xdebug-2.5.0 && phpize && \
    ./configure --enable-xdebug && make install && \
    cd .. && rm -rf xdebug-2.5.0*

# Setup php to use XDebug
RUN echo -e "\
zend_extension=/usr/lib64/php/modules/xdebug.so\n\
xdebug.remote_enable=1\n\
xdebug.remote_connect_back=1" > /etc/php.d/xdebug.ini

# Install php composer 
RUN wget -q https://getcomposer.org/download/1.3.0/composer.phar -O /usr/local/bin/composer.phar && \
    chmod a+x /usr/local/bin/composer.phar 

RUN yum -y install \
        http://www.percona.com/downloads/percona-release/redhat/0.1-4/percona-release-0.1-4.noarch.rpm && \
    yum -y install Percona-Server-{server,client}-57 && \
    chown mysql:mysql /var/log/mysqld.log

# oh-my-zsh
RUN git clone git://github.com/robbyrussell/oh-my-zsh.git ~/.oh-my-zsh && \
    cp ~/.oh-my-zsh/templates/zshrc.zsh-template ~/.zshrc && \
    sed -ie 's/^# DISABLE_AUTO_UPDATE=/DISABLE_AUTO_UPDATE=/' ~/.zshrc && \
    sed -ie 's/^plugins=(git)/plugins=(git wd)/' ~/.zshrc


RUN mkdir -p /kyberia/data

COPY docker/run_percona.sh /usr/local/bin/run_percona.sh
COPY docker/composer_init.sh /usr/local/bin/composer_init.sh
COPY data/kyberia-db.sql /kyberia/data/kyberia-db.sql

USER mysql
RUN (run_percona.sh &) && \
    while [[ ! -S /var/lib/mysql/mysql.sock ]] { sleep 1 } && \
    killall mysqld && while [[ -S /var/lib/mysql/mysql.sock ]] { sleep 1 }

# mysql 5.7 sets a random default root password. Disable it.
RUN while { read i } \
        { [[ $i =~ 'temporary password is generated.*localhost: (.*)' ]] && mpasswd=$match[1] && break } \
        < /var/log/mysqld.log && \
    (run_percona.sh &) && \
    while [[ ! -S /var/lib/mysql/mysql.sock ]] { sleep 1 } && \
    mysql -u root "-p$mpasswd" --connect-expired-password -e " \
        ALTER USER 'root'@'localhost' IDENTIFIED BY '' ; FLUSH PRIVILEGES;" && \
    killall mysqld && while [[ -S /var/lib/mysql/mysql.sock ]] { sleep 1 }
        
RUN (run_percona.sh &) && \
    while [[ ! -S /var/lib/mysql/mysql.sock ]] { sleep 1 } && \
    mysql -u root mysql -e ' \
        create user kyberia@localhost identified by "blah"; \
        create database kyberia2; \
        grant all on kyberia2.* to kyberia@localhost;' && \
    mysql -u kyberia -pblah kyberia2 -e 'source /kyberia/data/kyberia-db.sql'
USER root

COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/httpd24_kyberia.conf /opt/rh/httpd24/root/etc/httpd/conf.d/kyberia.conf
COPY docker/symfony_htaccess /opt/rh/httpd24/root/etc/httpd/kyberia_htaccess.conf
COPY docker/warprc /root/.warprc

EXPOSE 80
    
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
