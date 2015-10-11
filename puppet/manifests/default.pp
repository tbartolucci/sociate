#exec { '/usr/bin/apt-get install php-pear -y': }
#exec { '/usr/bin/apt-get install php5-dev -y': }
#exec { '/usr/bin/apt-get install php5-mongo -y': }
#exec { '/usr/bin/apt-get update -y': }
#exec { '/usr/bin/apt-get upgrade -y': }

class { 'git': }

class { 'apache':
  default_mods => false,
  mpm_module => 'prefork',
}

class { 'apache::mod::php': }
class { 'apache::mod::rewrite': }

apache::vhost { 'sociate.com':
  port      => '80',
  docroot   => '/var/www/sociate/public',
  directories => [
    {
      path    => '/var/www/sociate/public',
      override => 'All',
    },
  ],
}