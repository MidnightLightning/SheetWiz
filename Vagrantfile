Vagrant.configure("2") do |config|
  config.vm.box = 'ubuntu-precise12042-x64-vbox43'
  config.vm.box_url = 'http://box.puphpet.com/ubuntu-precise12042-x64-vbox43.box'
  config.vm.host_name = 'phpdev.dev'
  config.vm.network :private_network, ip: '192.168.0.42'
  
  config.vm.provider :virtualbox do |vb|
    vb.customize [
      'modifyvm', :id,
      '--name', 'sheetwiz.dev',
      '--memory', '256'
    ]
  end
  
  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = 'puppet/manifests'
    puppet.manifest_file = 'site.pp'
    puppet.module_path = 'puppet/modules'
  end
  
end
