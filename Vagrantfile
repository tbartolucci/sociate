Vagrant.configure(2) do |config|

    # force box_version = "1.0.1" for puppet v3.7.4~
    # resolves puppet 4 --manifestdir vagrant bug on current box version
    config.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
    config.vm.box_version = "1.0.1"

    # alternate ubuntu box and setup our own puppet

    config.vm.synced_folder ".", "/var/www/sociate"

    config.vm.provision "shell", inline: "apt-get update"
    config.vm.provision "shell", inline: "apt-get install git -y"
    config.vm.provision "shell", inline: "apt-get install puppet -y"

    config.vm.provision "shell", inline: "{ puppet module list | grep stdlib > /dev/null; } || puppet module install puppetlabs/stdlib"
    config.vm.provision "shell", inline: "{ puppet module list | grep concat > /dev/null; } || puppet module install puppetlabs/concat"
    config.vm.provision "shell", inline: "{ puppet module list | grep apache > /dev/null; } || puppet module install puppetlabs/apache"
    config.vm.provision "shell", inline: "{ puppet module list | grep php > /dev/null; } || puppet module install mayflower/php"

    config.vm.provision "puppet", run: "always", :options => ["--debug --trace --verbose --modulepath=/etc/puppet/modules"] do |puppet|
        puppet.manifests_path = "puppet/manifests"
    end

end