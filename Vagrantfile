Vagrant.configure(2) do |config|

    config.vm.box = "ubuntu/trusty64"
    config.vm.synced_folder ".", "/sociate/"

    config.vm.provision "puppet", run: "always" do |puppet|
        puppet.manifests_path = "puppet/manifests"
        puppet.module_path = "puppet/modules"
        puppet.hiera_config_path = "puppet/hiera.yml"
        puppet.working_directory = "/tmp/vagrant-puppet"
        #puppet.options = "--verbose --debug"
    end
end