Vagrant.configure(2) do |config|

    config.vm.define "web" do |web|
        # force box_version = "1.0.1" for puppet v3.7.4~
        # resolves puppet 4 --manifestdir vagrant bug on current box version
        web.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
        web.vm.box_version = "1.0.1"

        # alternate ubuntu box and setup our own puppet
        web.vm.network "forwarded_port", guest: 80, host: 8080

        web.vm.synced_folder ".", "/var/www/sociate"

        web.vm.synced_folder './sites/', "/etc/apache2/sites-available/"
        web.vm.synced_folder "./puppet/modules", "/etc/puppet/modules"

        # remove deprecated template directory from puppet.conf
        web.vm.provision "shell", inline: "sed -e '/templatedir/ s/^#*/#/' -i.back /etc/puppet/puppet.conf"

        # fix the stdin is not a tty warning
        web.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

        web.vm.provision "shell", inline: "apt-get update -y"
        web.vm.provision "shell", inline: "apt-get upgrade -y"

        # copy the hiera.yml to the guest machine
        web.vm.provision "shell", inline: "cp /var/www/sociate/puppet/hiera.yaml /etc/puppet/."

        # puppet modules
        web.vm.provision "shell", inline: "{ puppet module list | grep stdlib > /dev/null; } || puppet module install puppetlabs/stdlib"
        web.vm.provision "shell", inline: "{ puppet module list | grep concat > /dev/null; } || puppet module install puppetlabs/concat"
        web.vm.provision "shell", inline: "{ puppet module list | grep git > /dev/null; } || puppet module install puppetlabs/git"
        web.vm.provision "shell", inline: "{ puppet module list | grep apache > /dev/null; } || puppet module install example42/apache"
        web.vm.provision "shell", inline: "{ puppet module list | grep php > /dev/null; } || puppet module install example42/php"
        web.vm.provision "shell", inline: "{ puppet module list | grep mysql > /dev/null; } || puppet module install example42/mysql"
        web.vm.provision "shell", inline: "{ puppet module list | grep mongo > /dev/null; } || puppet module install puppetlabs/mongodb"
        #web.vm.provision "shell", inline: "{ puppet module list | grep newrelic > /dev/null; } || puppet module install mwillbanks/newrelic"

        web.vm.provision "shell", inline: "apt-get -f install -y"

        web.vm.provision "puppet", run: "always", :options => ["--modulepath=/etc/puppet/modules"] do |puppet|
            puppet.manifests_path = "puppet/manifests"
            puppet.manifest_file = "web_manifest.pp"
        end

        web.vm.network "private_network", ip: "192.168.50.200"
    end


=begin
    config.vm.define "db" do |db|
        db.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
        db.vm.box_version = "1.0.1"

        db.vm.synced_folder "./puppet/modules", "/etc/puppet/modules"

        # remove deprecated template directory from puppet.conf
        db.vm.provision "shell", inline: "sed -e '/templatedir/ s/^#*/#/' -i.back /etc/puppet/puppet.conf"

        # fix the stdin is not a tty warning
        db.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

        db.vm.provision "shell", inline: "apt-get update -y"
        db.vm.provision "shell", inline: "apt-get upgrade -y"

        db.vm.synced_folder ".", "/var/www/sociate"
        # copy the hiera.yml to the guest machine
        db.vm.provision "shell", inline: "cp /var/www/sociate/puppet/hiera.yaml /etc/puppet/."

        db.vm.provision "shell", inline: "{ puppet module list | grep stdlib > /dev/null; } || puppet module install puppetlabs/stdlib"
        db.vm.provision "shell", inline: "{ puppet module list | grep concat > /dev/null; } || puppet module install puppetlabs/concat"
        db.vm.provision "shell", inline: "{ puppet module list | grep git > /dev/null; } || puppet module install puppetlabs/git"
        db.vm.provision "shell", inline: "{ puppet module list | grep newrelic > /dev/null; } || puppet module install mwillbanks/newrelic"
        db.vm.provision "shell", inline: "{ puppet module list | grep mongo > /dev/null; } || puppet module install puppetlabs/mongodb"

        db.vm.provision "shell", inline: "apt-get -f install -y"

        db.vm.provision "puppet", run: "always", :options => ["--modulepath=/etc/puppet/modules"] do |puppet|
            puppet.manifests_path = "puppet/manifests"
            puppet.manifest_file = "db_manifest.pp"
        end

        db.vm.network "private_network", ip: "192.168.50.201"
    end
=end

end