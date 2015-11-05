
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

class { 'php': }
php::mod { "mongo": }

class { 'composer': }

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

