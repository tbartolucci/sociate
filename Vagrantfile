Vagrant.configure(2) do |config|

    # force box_version = "1.0.1" for puppet v3.7.4~
    # resolves puppet 4 --manifestdir vagrant bug on current box version
    config.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
    config.vm.box_version = "1.0.1"

    # alternate ubuntu box and setup our own puppet
    config.vm.network "forwarded_port", guest: 80, host: 8080

    config.vm.synced_folder ".", "/var/www/sociate"

    config.vm.synced_folder './sites/', "/etc/apache2/sites-available/"
    config.vm.synced_folder "./puppet/modules", "/etc/puppet/modules"

    # remove deprecated template directory from puppet.conf
    config.vm.provision "shell", inline: "sed -e '/templatedir/ s/^#*/#/' -i.back /etc/puppet/puppet.conf"
    # fix the stdin is not a tty warning
    config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

    config.vm.provision "shell", inline: "apt-get update -y"
    config.vm.provision "shell", inline: "apt-get upgrade -y"

    # copy the hiera.yml to the guest machine
    config.vm.provision "shell", inline: "cp /var/www/sociate/puppet/hiera.yaml /etc/puppet/."

    # puppet modules
    config.vm.provision "shell", inline: "{ puppet module list | grep stdlib > /dev/null; } || puppet module install puppetlabs/stdlib"
    config.vm.provision "shell", inline: "{ puppet module list | grep concat > /dev/null; } || puppet module install puppetlabs/concat"
    config.vm.provision "shell", inline: "{ puppet module list | grep git > /dev/null; } || puppet module install puppetlabs/git"
    config.vm.provision "shell", inline: "{ puppet module list | grep apache > /dev/null; } || puppet module install example42/apache"
    config.vm.provision "shell", inline: "{ puppet module list | grep php > /dev/null; } || puppet module install example42/php"

    #config.vm.provision "shell", inline: "apt-get install php-pear -y"
    #config.vm.provision "shell", inline: "apt-get install php5-dev -y"
    #config.vm.provision "shell", inline: "apt-get install php5-mongo -y"

    config.vm.provision "shell", inline: "apt-get -f install -y"

    config.vm.provision "puppet", run: "always", :options => ["--modulepath=/etc/puppet/modules"] do |puppet|
        puppet.manifests_path = "puppet/manifests"
    end

end