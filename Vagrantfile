Vagrant.configure(2) do |config|
  config.vm.box = "dubbs/centos-6.6"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.provision "shell", inline: <<-SHELL

    # SYSTEM
    #mv /etc/localtime /etc/localtime.bak
    #ln -s /usr/share/zoneinfo/America/Regina /etc/localtime
    #sed -i 's%New_York%Regina%' /etc/sysconfig/clock
    # put selinux into permissive mode
    # setenforce 0
    #sed -i 's%SELINUX=enforcing%SELINUX=permissive%' /etc/selinux/config

    rpm -qa|grep nginx > /dev/null
    if [ $? -ne 0 ];then
      yum -y install nginx
      chkconfig --levels 2345 nginx on
      # remove default servers
      CONFD=/etc/nginx/conf.d
      mv $CONFD/default.conf $CONFD/default.conf.bak
      mv $CONFD/ssl.conf $CONFD/ssl.conf.bak
      mv $CONFD/virtual.conf $CONFD/virtual.conf.bak
      # change default nginx user/group
      sed -i 's%nginx;%vagrant vagrant;%' /etc/nginx/nginx.conf
      # set conf file
      ln -sf /vagrant/nginx.conf /etc/nginx/conf.d/nginx.conf
      # init
      service nginx start
    fi

    #iptables -I INPUT -j ACCEPT
    #iptables-save | sudo tee /etc/sysconfig/iptables

    # DB
    rpm -qa|grep MariaDB > /dev/null
    if [ $? -ne 0 ];then
      ln -s /vagrant/MariaDB.repo /etc/yum.repos.d/MariaDB.repo
      yum -y install MariaDB-server MariaDB-client
      chkconfig --levels 345 mysql on
      service mysql start
    fi

    # DB USERS
    if [ ! -d /var/lib/mysql/example_com ];then
      mysql -uroot -e "CREATE DATABASE example_com;"
      mysql -uroot -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password';"
      mysql -uroot -e "GRANT ALL PRIVILEGES ON example_com.* TO admin@'%' IDENTIFIED BY 'password';"
      mysql -uroot -e "GRANT ALL PRIVILEGES ON example_com.* TO admin@localhost IDENTIFIED BY 'password';"
      mysql -uroot -e "FLUSH PRIVILEGES;"
    fi

    # PHP
    rpm -qa|grep php > /dev/null
    if [ $? -ne 0 ];then
      yum -y install php56w php56w-mysql
      # fix security risk
      sed -i 's%^;cgi.fix_pathinfo=1%cgi.fix_pathinfo=0%' /etc/php.ini
      # update timezone
      sed -i 's%^;date.timezone =%date.timezone = "America/Regina"%' /etc/php.ini
    fi

    # PHP-FPM
    rpm -qa|grep fpm > /dev/null
    if [ $? -ne 0 ];then
      yum -y install php56w-fpm
      chkconfig --levels 345 php-fpm on
      sed -i 's%listen = 127.0.0.1:9000%listen = /var/run/php5-fpm.sock%' /etc/php-fpm.d/www.conf
      sed -i 's%user = apache%user = vagrant%' /etc/php-fpm.d/www.conf
      sed -i 's%group = apache%group = vagrant%' /etc/php-fpm.d/www.conf
      sed -i 's%;listen.owner = nobody%listen.owner = vagrant%' /etc/php-fpm.d/www.conf
      sed -i 's%;listen.group = nobody%listen.group = vagrant%' /etc/php-fpm.d/www.conf
      sed -i 's%;listen.mode%listen.mode%' /etc/php-fpm.d/www.conf
      service php-fpm restart
      service nginx restart
    fi

    # https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-12-04
    # http://www.rackspace.com/knowledge_center/article/installing-nginx-and-php-fpm-setup-for-nginx
    # https://danielmiessler.com/blog/ultimate-speed-wordpress-nginx/
    # http://192.168.33.10/wp-admin/

  SHELL
end
