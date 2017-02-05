# Oasis, self-contained

## Intro

- built with PHP
- uses Silex micro-framework
- modified from the original to use static content (vs using db)
- everything that's needed is packaged inside this repo (no need to run any composer builds)
- runs under http://uzbekistan.org/newsite

## For designers

You can try pulling the static site from http://uzbekistan.org/newsite (save the site on your computer), and take it from there. Or you can setup a working site based on *Installation* steps below.

I assume you are somewhat familiar with templating languages. Silex uses Twig, which was inspired by Django. You are free to create your own template though.

## Installation
I suggest using [vagrant](https://www.vagrantup.com/). That will make preparing an environment very easy. So please go ahead and install (I tested it in Mac, on Windows it may differ a bit)

1. [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](https://www.vagrantup.com/downloads.html)
* [git](https://github.com/git-for-windows/git/releases/download/v2.11.1.windows.1/Git-2.11.1-64-bit.exe)

Open a command line shell and ensure that you can run the `vagrant` command, as well as `git` command. Just open a shell (terminal on mac, cmd shell on windows) and type those two commans, and ensure you get a valid output (i.e. no errors)

While we have an open shell, lets create a folder and download a vagrant box (VM) into it.

```bash
mkdir oasis
cd oasis
git clone https://github.com/phantomphp/oasis-self-contained.git
vagrant init inviqa/centos-6-stack-php55
```

That creates Vagrantfile. Open it, and uncomment line (should be line 25) that will map the port 80 on the VM to 8080 on localhost.

Now run `vagrant up` command. This will download ~900MB VM image. Keep the shell open. Once that's complete, we will login into that VM and run PHP 5.5 webserver that will run our site.

Let's SSH into our VM (see https://stackoverflow.com/questions/9885108/ssh-to-vagrant-box-in-windows for Windows), and verify that we can see the oasis-self-contained directory that we just cloned from github (and run bunch of other commands to get it working)

```
vagrant ssh
sudo su
service iptables stop
chkconfig iptables off
sed -i 's/;date.timezone =/date.timezone = America\/New_York/' /etc/php.ini
php -S 0.0.0.0:80 -t /vagrant/oasis-self-contained/web
```

`/vagrat` is mounted to the directory where we cloned the repo, thus `oasis-self-contained` is visible inside the VM under `/vagrant/oasis-self-contained`

Last command will serve the site on port 80 in the VM. Now open a browser and navigate to 'http://localhost:8080'. Given your setup is proper, you will see a working site, similar to what's under http://uzbekistan.org/newsite.

Not everything works in the site. Only following links work

- [Main page, http://localhost:8080](http://localhost:8080)
- [Press of Uzbekistan, http://localhost:8080/press-uzbekistan](http://localhost:8080/press-uzbekistan)
- [Consular section > Visa Information, http://localhost:8080/consular/visa/index](http://localhost:8080/consular/visa/index)

These links demo most of the site's functionality.

The view templates are located in oasis-self-contained/views. You can edit those files either outside the VM, or inside it. I'd choose the former.

If you stumble upon issues, please open an issue in github.


