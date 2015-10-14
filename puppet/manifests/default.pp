
class { 'git': }

class { "apache": }

apache::vhost { 'sociate.com':
  ensure            => 'enabled',
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

class { 'php': }