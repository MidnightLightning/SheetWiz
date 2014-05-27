File {
  owner => 'root',
  group => 'root',
  mode  => '0644',
}

stage { 'pre':
  before => Stage['main']
}

# add the baseconfig module to the new 'pre' run stage
class { 'baseconfig':
  stage => 'pre'
}

include baseconfig, apache, mysql, php
