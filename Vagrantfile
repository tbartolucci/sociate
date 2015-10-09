Vagrant.configure(2) do |config|

    # force box_version = "1.0.1" for puppet v3.7.4~
    # resolves puppet 4 --manifestdir vagrant bug on current box version
    config.vm.box = "puppetlabs/ubuntu-14.04-64-puppet"
    config.vm.box_version = "1.0.1"
    config.vm.synced_folder ".", "/home/vagrant/sociate/"

    config.vm.provision "shell", inline: "gem install r10k -y"
    config.vm.provision "shell", inline: "r10k puppetfile install"

    config.vm.provision "puppet", run: "always", :options => ["--debug --trace --verbose"] do |puppet|
        puppet.manifests_path = "puppet/manifests"
        puppet.module_path = "puppet/modules"
    end

end