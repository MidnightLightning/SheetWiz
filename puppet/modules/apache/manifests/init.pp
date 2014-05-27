# == Class: apache
#
# Installs packages for Apache and sets config files.
#
class apache {
  package { ['apache2', 'apache2-mpm-prefork']:
    ensure => present;
  }

  service { 'apache2':
    ensure  => running,
    require => Package['apache2'];
  }
  
  define apache::module() {
    file { "/etc/apache2/mods-enabled/${name}":
      ensure  => link,
      target  => "/etc/apache2/mods-available/${name}",
      require => Package['apache2'],
      notify  => Service['apache2'];
    }
  }
  apache::module { ['rewrite.load']: } # Extend this array with any additional Apache modules needed
  
  file {
    "/etc/apache2/sites-available/static-site":
      before => File ['/etc/apache2/sites-enabled/000-default'],
      source => "puppet:///modules/apache/static-site", # Copy vhost file
      require => Package['apache2'],
      notify => Service['apache2'];
    "/etc/apache2/sites-enabled/000-default": # Ensure our vhost is the default one, to prevent root level being exposed
      ensure => link,
      target => "../sites-available/static-site",
      notify => Service['apache2'];
  }
}
