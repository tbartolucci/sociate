
class { 'git': }

class { "apache": }

apache::vhost { 'sociate.com':
  enable            => true,
  port              => '80',
  docroot           => '/var/www/sociate/public',
  directory         => '/var/www/sociate/public',
  directory_allow_override   => 'All',
  directory_require => 'all granted',
  directory_options => 'Indexes FollowSymLinks',
}

apache::module { 'rewrite':
  ensure => 'present',
}

#exec { 'disable default vhost':
#  command => 'sudo a2dissite 000-default',
#  path => '/usr/bin/',
#}

class { 'php': }
php::mod { "mongo": }
#php::pecl::module { "mongo": }

class { 'mysql':
  disable => true,
  disableboot => true,
  absent => true,
}

#class { 'newrelic':
# license_key => '89f9ef330f9fd5a2e0ed42169efbe8b02a82f2de',
# use_latest  => true
#}

class { 'newrelic::server::linux':
  newrelic_license_key    => '89f9ef330f9fd5a2e0ed42169efbe8b02a82f2de',
  newrelic_package_ensure => 'latest',
  newrelic_service_ensure => 'running',
}