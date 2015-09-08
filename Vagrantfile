# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "dubbs/centos-6.6"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024"
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Define a Vagrant Push strategy for pushing to Atlas. Other push strategies
  # such as FTP and Heroku are also available. See the documentation at
  # https://docs.vagrantup.com/v2/push/atlas.html for more information.
  # config.push.define "atlas" do |push|
  #   push.app = "YOUR_ATLAS_USERNAME/YOUR_APPLICATION_NAME"
  # end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL

    # SYSTEM
    #mv /etc/localtime /etc/localtime.bak
    #ln -s /usr/share/zoneinfo/America/Regina /etc/localtime
    #sed -i 's%New_York%Regina%' /etc/sysconfig/clock
    # put selinux into permissive mode
    #setenforce 0

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
