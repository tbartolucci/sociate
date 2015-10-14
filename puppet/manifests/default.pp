
class { 'git': }

class { "apache":

}

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

exec { 'disable default vhost':
  command => 'sudo a2dissite 000-default',
  path => '/usr/bin/',
}


class { 'php': }