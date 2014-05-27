# == Class: mysql
#
# Installs MySQL server, sets config file, and loads database for dynamic site.
#
class mysql {
  package { ['mysql-server']:
    ensure => present;
  }

  service { 'mysql':
    ensure  => running,
    require => Package['mysql-server'];
  }

  exec { 'set-mysql-password':
    unless  => 'mysqladmin -uroot -proot status', # If we can already log in as root:root, ignore
    command => "mysqladmin -uroot password root", # Otherwise, set the root user's password to "root"
    path    => ['/bin', '/usr/bin'],
    require => Service['mysql'];
  }

  #exec { 'load-dynamic-sql': # Run arbitrary SQL after server created
  #  command => 'mysql -u root -proot < /vagrant/sites/dynamic.sql',
  #  path    => ['/bin', '/usr/bin'],
  #  require => Exec['set-mysql-password'];
  #}
}
