# Short URL

This application is similar to bit.ly where any user can submit a url, and it will give them back a shortened url that  automatically redirects, to the original url. 

This version was written in PHP using CodeIgniter v3.1.4, and uses Javascript/jQuery on the front-end. The design comes from a free bootstrap theme, called '[cyborg](https://bootswatch.com/cyborg/)', to give it a standard look-and-feel. Each url first passes through a [phishtank](https://www.phishtank.com/) blacklist, to prevent known malicious urls from getting into the system. 

## System Requirements
 * [Vagrant](https://www.vagrantup.com/)
 * [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

## Setup
```
git clone git@github.com:mathew-fleisch/Short-URL.git
cd ./Link-Shrinker
vagrant up
```
[http://localhost:8088](http://localhost:8088)



## API

``` 
/api/url
	POST - original_url => short_url
	GET  - alias        => original_url
```



