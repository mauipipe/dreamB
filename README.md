# Installation Instruction

 //Create the project folder: 
 mkdir <path>/dreamBeach
 
 //Clone the repository
 git clone <repository-name> dreamBeach
 
 //go to the project
 cd dreamBeach
 
 //Start the VM (default path mapping is /srv/apps/ /srv/apps/dreamBeach/ to customize it change it inside VagrantFile)
 vagrant up
 
 //Run composer (this command could be run inside the VM too but the memory_limit should be increased) 
 php composer.phar install
 
 //Run bower (if not present install Bower)
 bower install  
   
# Post Installation instruction
 - After the project is installed add:
     192.168.33.10 dream-beach.local
   in the file /etc/hosts in your local machine
   
# PhpMyAdmin
  PhpMyAdmin can be found at the address /192.168.33.10/phpMyAdmin

# Import the DB  
  A full dump to visualize a working project can be found in data/dump/dreambeach.sql on the project root
  Import it using the preferred method (phpMyAdmin,console)
  
# Run Test 
  To run test with Behat from the project root:
  php bin/behat API
  To run test with phpspec from the project root:
  php bin/phpspec run