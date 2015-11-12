
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

class { 'php':
  service             => 'apache',
  service_autorestart => true,
  module_prefix       => '',
}

#php::pecl::module { 'mongodb': }

class { 'mysql':
  disable => true,
  disableboot => true,
  absent => true,
}

# make sure the directory is available for the mongod filesystem
file { [ "/data/", "/data/db/"]:
  ensure => "directory",
}

# elevate the admin user of the puppet process to stop errors
file { 'mongorc.js':
  path          => '/etc/.mongorc.js',
  ensure        => file,
  require       => Mongodb_user['tom'],
  content       => "var prev_db = db;
db = db.getSiblingDB('admin');
db.auth('siteUserAdmin','admin');
db = db.getSiblingDB(prev_db);",
}

class {'::mongodb::globals':
  manage_package_repo => true,
}->
class {'::mongodb::server':
  ensure => true,
  port    => 27018,
  verbose => true,
  auth => true,
}->
class {'::mongodb::client':}->
mongodb_database { evolvd:
  ensure   => present,
  tries    => 10,
  require  => Class['mongodb::server'],
}

mongodb_user { tom:
  username      => 'tom',
  ensure        => present,
  password_hash => mongodb_password('tom', 'dev'),
  database      => evolvd,
  roles         => ['root', 'siteUserAdmin', 'adminAnyDatabase', 'readWrite', 'dbAdmin'],
  tries         => 10,
  require       => Class['mongodb::server'],
}

exec { "write_mongo":
  command => 'echo extension=/usr/lib/php5/20121212/mongodb.so >> /etc/php5/apache2/php.ini',
  path => '/bin/',
}

#php -c "/etc/php5/apache2/php.ini" composer.phar install


#cd /etc/php5/cli
#mv php.ini php.ini.bak
#mv conf.d conf.d.bak
#ln -s /etc/php5/apache2/php.ini
#ln -s /etc/php5/apache2/conf.d

exec { "link_php_cli":
  command => 'mv php.ini php.ini.bak && mv conf.d conf.d.bak && && ln -s /etc/php5/apache2/php.ini && ln -s /etc/php5/apache2/conf.d',
  path => "/etc/php5/cli",
}
