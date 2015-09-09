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
    #sed -i 's%SELINUX=enforcing%SELINUX=permissive%' /etc/selinux/config

    rpm -qa|grep nginx > /dev/null
    if [ $? -ne 0 ];then
      yum -y install nginx
      chkconfig --levels 345 nginx on
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
      yum -y install php56w php56w-mysql php56w-fpm
      # fix security risk
      sed -i 's%^;cgi.fix_pathinfo=1%cgi.fix_pathinfo=0%' /etc/php.ini
      # update timezone
      sed -i 's%^;date.timezone =%date.timezone = "America/Regina"%' /etc/php.ini
      chkconfig --levels 345 php-fpm on
      service php-fpm start
    fi

    # WEB

  SHELL
end
