# -*- mode: ruby -*-
# vi: set ft=ruby :


$os_packages_update = <<SCRIPT
#!/bin/bash
sudo rm -v /etc/apt/apt.conf.d/70debconf
echo -e "===> Update OS packages "
sudo apt-get update 
sudo apt-get upgrade -y
sudo apt-get install net-tools curl -y
echo -e "===> Disabling IPv6 "
sudo echo "net.ipv6.conf.all.disable_ipv6 = 1\n 
net.ipv6.conf.default.disable_ipv6 = 1\n
net.ipv6.conf.lo.disable_ipv6 = 1\n
net.ipv6.conf.eth0.disable_ipv6 = 1" >> /etc/sysctl.conf
#sudo sysctl -p
SCRIPT

$docker_setup = <<SCRIPT
#!/bin/bash
echo -e "===> Installing Docker dependencies... "
sudo apt-get update
sudo apt-get install apt-transport-https curl gnupg-agent ca-certificates software-properties-common -y

sudo apt-get install ca-certificates curl gnupg lsb-release -y
sudo mkdir -m 0755 -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y

echo -e "===> Docker installed and configured."
sudo adduser vagrant docker
sudo usermod -aG docker vagrant

mkdir -p /home/vagrant/.docker/cli-plugins/
curl -sSL https://github.com/docker/compose/releases/download/v2.16.0/docker-compose-linux-x86_64 -o /home/vagrant/.docker/cli-plugins/docker-compose
chmod +x /home/vagrant/.docker/cli-plugins/docker-compose
chown vagrant:vagrant -R  /home/vagrant/.docker

SCRIPT

$docker_start = <<SCRIPT
#!/bin/bash
echo -e "===> Start Docker standalone ... "
cd /vagrant/apps
#docker network create -d bridge --subnet 192.168.50.0/24 --gateway 192.168.50.1 wantsomenet
docker compose up -d 
#docker compose create db
#docker compose start db
#docker compose create app1
#docker compose start app1
#docker compose create app2
#docker compose start app2
#docker compose create lb
#docker compose start lb
SCRIPT


Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/jammy64"
  config.vm.boot_timeout = 600
  config.vm.provider "virtualbox"
  config.vm.define "docker" do |dd|
    dd.vm.hostname = "docker"
    dd.vm.network "private_network", ip: "192.168.56.10", virtualbox__vboxnet: true, ipv6: false
    #dd.vm.network "forwarded_port", guest: "80", host: "8080"
    dd.vm.provision "shell", :inline => $os_packages_update
    dd.vm.provision "shell", :inline => $docker_setup
    dd.vm.provision 'shell', reboot: true
    dd.vm.provision "shell", :inline => $docker_start
    dd.vm.provider "virtualbox" do |vb|
      #vb.gui = true
      vb.memory = "4096"
      vb.cpus = "2"
      # Intel PRO/1000 MT Desktop (82540EM) - default
      #vb.default_nic_type = "82540EM"
      # Intel PRO/1000 T Server (82543GC)
      #vb.default_nic_type = "82543GC"
      # Intel PRO/1000 MT Server (82545EM)
      #vb.default_nic_type = "82545EM"
      #As it currently stands they are Am79C970A|Am79C973|82540EM|82543GC|82545EM|virtio
      vb.default_nic_type = "Am79C973"
      vb.customize ["modifyvm", :id, "--graphicscontroller", "vmsvga"]
      vb.customize ["modifyvm", :id, "--vram", "32"]
      vb.customize ["modifyvm", :id, "--audio", "none"]
      # enable promiscuous mode on the public network
      #vb.customize ["modifyvm", :id, "--nicpromisc3", "allow-all"]
    end
  end
end
