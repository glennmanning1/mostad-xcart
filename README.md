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

* Start the Box: `vagrant up`
* Stop the box: `vagrant stop`
* Pause the box: `vagrant suspend`
* Call provisioning script: `vagrant provision`

## Questions?
Please contact Drew <drew.brown@novahorizons.io>