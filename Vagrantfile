# -*- mode: ruby -*-
# vi: set ft=ruby :


$os_packages_update = <<SCRIPT
#!/bin/bash
sudo rm -v /etc/apt/apt.conf.d/70debconf
echo -e "===> Update OS packages "
sudo apt-get update 
sudo apt-get upgrade -y
sudo apt-get install net-tools -y
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

$githubaction_setup = <<SCRIPT
#!/bin/bash
echo -e "===> Installing GiHub self-hosted runner... "
if [[ ! -d /vagrant/actions-runner ]]; then
  echo -e "===> Creating /vagrant/actions-runner folder"
  mkdir /vagrant/actions-runner
fi
cd /vagrant/actions-runner
VER="2.303.0"
if [[ ! -f actions-runner-linux-x64-$VER.tar.gz ]]; then
  echo -e "===> Download actions-runner-linux-x64-$VER.tar.gz"
  curl -o actions-runner-linux-x64-$VER.tar.gz -sL https://github.com/actions/runner/releases/download/v$VER/actions-runner-linux-x64-$VER.tar.gz
  tar xzf ./actions-runner-linux-x64-$VER.tar.gz
  # start github action runner
  ./svc.sh start
fi

SCRIPT

$githubrunner_script = <<SCRIPT
#!/bin/bash
cd /vagrant/apps
echo -e "===> run docker compose... "
docker compose up

SCRIPT

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/jammy64"
  #config.vm.box = "ubuntu/focal64"
  #config.vm.box = "ubuntu/bionic64"
  #config.vm.box = "generic/ubuntu2204"

  config.vm.boot_timeout = 600
  config.vm.provider "virtualbox"
  config.vm.define "docker" do |dd|
    dd.vm.hostname = "docker"
    dd.vm.network "private_network", ip: "192.168.56.10", virtualbox__vboxnet: true
    dd.vm.network "forwarded_port", guest: "8080", host: "8888"
    dd.vm.provision "shell", :inline => $os_packages_update
    dd.vm.provision "shell", :inline => $docker_setup
    #dd.vm.provision "shell", :inline => $githubaction_setup
    #dd.vm.provision "shell", :inline => $githubrunner_script, privileged: false

    dd.vm.provision 'shell', reboot: true
    dd.vm.provider "virtualbox" do |vb|
      vb.gui = true
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
    end
  end
end
