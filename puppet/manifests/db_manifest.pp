
class {'::mongodb::server':
  port    => 27018,
  verbose => true,
  auth => true,
}

#class { 'newrelic::server::linux':
#  newrelic_license_key    => '89f9ef330f9fd5a2e0ed42169efbe8b02a82f2de',
#  newrelic_package_ensure => 'latest',
#  newrelic_service_ensure => 'running',
#}