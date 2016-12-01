## Setup Instructions

1. Download and install VirtualBox and it's Extension Pack <https://www.virtualbox.org/wiki/Downloads>
1. Download and install Vagrant <https://www.vagrantup.com/downloads.html>
1. Install Vagrant Host Manager Plugin
    * `vagrant plugin install vagrant-hostmanager`
1. Clone the Repo
1. Clone the Next-SDK repo at the same level as this repo in a folder named next-sdk <https://github.com/xcart/next-sdk>
1. Copy Vagrantfile.dist to Vagrantfile and update sync folders if necessary
    * If using a mac/linux uncomment lines 24,25 and comment out 26,27
    * If using Windows and would like to try SMB Sharing, uncomment 24,25 and commen tout 26,27 and change instances of nfs to smb.  Note there are mixed reviews on performance of smb sharing
1. Start the virtual box
    * `vagrant up`
    * If the prompt asks for a username or password, it is your system username or password.
1. Verify site is working by visiting <http://mostad-xcart.dev/>

## Usernames and logins

* Mysql
    * username: root
    * password: 123
* Vagrant
    * username: vagrant
    * password: vagrant
* X-Cart
    * username: xcart@novahorizons.io
    * password: P4ssw0rd

## Helpful Vagrant information
Note: these commands will only work from the Windows Command Line, which should be run as and administrator.

* Start the Box: `vagrant up`
    * If the box has been hatled you will need to provision the box for the site to work appropriately this can be done while upping using `vagrant up --provision`
* Stop the box: `vagrant halt`
* Pause the box: `vagrant suspend`
* Call provisioning script: `vagrant provision`
* SSH into the vagrant box: `vagrant ssh`

## Questions?
Please contact The Nova Horizons team <xcart+mostad@novahorizons.io>

## Some Common Tasks
### Getting code to staging or production
1. In git, create a new branch to do the work in, based off develop.
1. Do the necessary work.
1. Commit the necessary work.
1. Push your new branch to the remote repository.
1. Log into [Nova Horizons' Git Lab](https://git.novahorizons.io/users/sign_in) and submit a merge request, making sure to set the source branch to your new branch, and the target branch to develop.
1. At this time the changes will be reviewed and merged, or sent back for revision.

### Updating the local development environment database
1. Log into the Plesk Control Panel
1. Navigate to the mostad.com webspace.
1. Navigate to the Databases tab.
1. Under the xcart section, click `Export Dump`
    1. Create in the default root location.
1. Download the dump utilizing the link in the lower right hand corner of the screen.
1. Move the file into the project `<project_dir>/sys/files`
1. SSH into the vagrant box
1. Execute the following command, replacing FILENAME with the appropriate filename from the download.  `zcat /var/www/sys/files/FILENAME.sql.gz | mysql -u root -p"123" xc5`
1. Execute the following command, ```mysql --execute 'UPDATE `xc_config` SET `value`=0 WHERE `name`="admin_security" OR `name`="customer_security";' -u root -p"123" xc5```
1. Then rebuild the x-cart cache.

### Rebuilding X-Cart cache from the command line.
This can be sometimes faster than rebuilding it form the admin.  This can also be helpful when just having updated the Database, or when the site appears to be unreachable.

**IMPORTANT**: If you run the command and the output says anything about Step X of Y you must run the command for each remaining step.
1. SSH into the vagrant box
1. Change to the project directory
1. Execute the following command ```php ../next-sdk/devkit/macros/rebuild-classes.php```


## Good Resources
As well as the below links, there are a number of great communities out there with Forums, and IRC chats that will gladly provide assistance with issues.
* [Vagrant](https://www.vagrantup.com/docs/)
* [VirtualBox](https://www.virtualbox.org/wiki/End-user_documentation)
* [Git](https://git-scm.com/doc)
* [Stack Overflow](http://stackoverflow.com/)
    * [X-Cart Questions](http://stackoverflow.com/questions/tagged/x-cart)
    * [Vagrant Questions](http://stackoverflow.com/questions/tagged/vagrant)
* [X-Cart](https://devs.x-cart.com/)
* [X-Cart Help Desk](https://secure.x-cart.com/)
* [Google](https://google.com)

