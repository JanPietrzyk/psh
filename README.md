PSH - PHP shell helper
====================

A Tool to execute *.sh scripts through php, including a templating language and environment settings.

# Set up

Check out the repository and create a phar file using box.phar

```
php box.phar build
cd build/
chmod +x psh.phar
```

# Usage

## Configuration

Create a config file named `.psh.yaml` in your base directory an example file could look like this:

```
header: |
  SHOPWARE PHP-SH

paths:
  - scripts/specific
  - scripts/common
  - dev-ops/scripts/docker

const:
  env: prod
  host: http://www.selfish.de

dynamic:
  id: id
  lsahl: ll
```
  
This will:

* Output `Shopware PHP-SH` as the header of each command
* load *.sh and *.psh files from scripts/specific, scripts/common, dev-ops/scripts/docker
* Replace __ENV__ and __HOST__ in these files with the constant values
* Execute `id` and `ll` and replace __ID__ and __LSAHL__ with the output

## Writing SH-Scripts

Of course you can just reuse your existing sh scripts and they should work just fine. If not, please open an issue in the issue tracker. 

Keep in mind: **Commands will be validated for successful execution -> All failures will fail the script!**

#### Specials

There are some *special syntax* changes here:

* Prefixing a line with `I: ` will trigger it to ignore the errors.
* Prefixing a line with `INCLUDE: ` will treat the rest of the line as a path assignment to another script to be included here.
* Prefixing a line with three spaces will append the line to the previous statement allowing for easy multi line statements.

#### Variables

All Variables must start with `__`, end with `__` and contain upper case letters and `_` only. Even if configured as lower case they will be converted to upper case before the replacement takes place.
 
 
#### Example Script

```
#!/usr/bin/env bash

ls -al
I: chmod +x /dir
INCLUDE: simple.sh

bin/phpunit
    --debug
    --verbose
```
 
 


