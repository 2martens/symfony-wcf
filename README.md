README
======

What are the WCF extensions?
----------------------------

The WCF extensions extend (who would have guessed that?) the Symfony2 framework
with WCF features. This features include a running ACP (Administrator Control Panel),
users and user groups, package management and many more. These extensions allow the creation
of redistributable applications that can be installed into existing Symfony-WCF installations.

In addition all administrative tasks necessary to operate the system can be done from the ACP.

Requirements
------------

The WCF extensions have the same requirements as the Symfony2 framework.
They only work with PHP 5.3.3 and upwards.

Be warned that PHP versions before 5.3.8 are known to be buggy and might not
work for you:

 * before PHP 5.3.4, if you get "Notice: Trying to get property of
   non-object", you've hit a known PHP bug (see
   https://bugs.php.net/bug.php?id=52083 and
   https://bugs.php.net/bug.php?id=50027);

 * before PHP 5.3.8, if you get an error involving annotations, you've hit a
   known PHP bug (see https://bugs.php.net/bug.php?id=55156).

 * PHP 5.3.16 has a major bug in the Reflection subsystem and is not suitable to
   run Symfony2 (https://bugs.php.net/bug.php?id=62715)

Installation
------------

The best way to install the WCF extensions is to download the Symfony WCF Edition
available at [https://github.com/frmwrk123/symfony-wcf-edition][1].

Documentation
-------------

The "[Quick Tour][2]" tutorial gives you a first feeling of the framework. If,
like us, you think that Symfony2 can help speed up your development and take
the quality of your work to the next level, read the official
[Symfony2 documentation][3].

Contributing
------------

The WCF extensions are free software (as in free speech). If you'd like to contribute,
please read the [Contributing Code][4] part of the documentation. If you're submitting
a pull request, please follow the guidelines in the [Submitting a Patch][5] section
and use [Pull Request Template][6]. These links are for Symfony itself but many things
are valid for the WCF extensions as well. Of course you will find other branches for
the WCF extensions. For more detailed information on how to contribute specifically
to the WCF extensions, refer to CONTRIBUTING.md in this directory.

Running Symfony2 Tests
----------------------

Information on how to run the Symfony2 test suite can be found in the
[Running Symfony2 Tests][7] section. Testing the WCF extensions is not much different.
Actually the only difference is, that under the src/ directory you will find other files
then shown in an example on that site.

[1]: https://github.com/frmwrk123/symfony-wcf-edition
[2]: http://symfony.com/get_started
[3]: http://symfony.com/doc/current/
[4]: http://symfony.com/doc/current/contributing/code/index.html
[5]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[6]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[7]: http://symfony.com/doc/master/contributing/code/tests.html
