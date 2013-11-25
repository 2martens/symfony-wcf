CONTRIBUTING
============

Thank you for your interest in contributing to the WCF extensions. However you have to meet some requirements
to get your changes accepted.

All console examples assume that you are in the directory of this file. To show the syntax of issues the following
minimalistic grammar is used:

Optional elements are enclosed in braces {} and alternatives are enclosed in parantheses and divided by a pipe
(alt1|alt2). Optional alternatives are enclosed in braces and parantheses {(alt3|alt4)}. A placeholder is enclosed by
`<` and `>`.

Download
--------

Fork this project and clone your fork locally. After that happened, download the composer.phar. To do this, type the
following into the console (make sure you are in the root directory of your cloned fork):

```
$ curl -s http://getcomposer.org/installer | php
```

If you don't have curl, download the installer manually and call it with PHP to download composer.phar.

Next you have to install the dependencies (this may take some time):

```
$ php composer.phar --dev install
```

Coding Standard
---------------
The [Symfony coding standard][1] is used. To check your code against the standard, you should use CodeSniffer.

By installing the dependencies of the WCF extensions with Composer, you have already installed CodeSniffer. To execute
the test, type the following into the console:

```
$ vendor/bin/phpcs -p --extensions=php --standard="CodeSniff/WCF" src/
```

If you use an IDE, it is mostly possible to include CodeSniffer to the IDE, so that you can execute the test
from within the IDE. As that differs from IDE to IDE, you won't get help for that here. Refer to the documentation
of your IDE, to find out how to include third party PHP tools.

Tests
-----

The WCF extensions aim to have a code coverage of over 90%. To test the code PHPUnit is used. By installing the
dependencies of the WCF extensions with Composer, you have already installed PHPUnit. To execute all tests of the WCF
extensions, type the following into the console:

```
$ vendor/bin/phpunit
```

If you implement a new feature, you should test for the code coverage. For this run:

```
$ vendor/bin/phpunit --coverage-html=cov/
```

You should have in all areas a coverage over 90%. If not, then investigate why. It does only make sense to test
classes with actual code. So interfaces are not tested. If in a directory are only two files (an interface and a class
implementing this interface) the coverage concerning the files and classes may be 50%. Simply make sure that every
class is tested. Depending on the IDE you can show the coverage while editing the files. That way you can see
what parts of the code are already covered, and what parts are not.

Minimum requirement for tests are black box tests. That means you test the public interface (all public methods of a class).
Black box tests assume nothing over the actual code, they just test the expected output. On top of that you can do
white box tests, that know what code stands within the tested methods. White box tests test the possible control flow
inside the method. There may be parts of the method that are only used, if a certain kind of input is given that does
not fit the expected input.

Please do not test with wrong input (input that is not valid as defined in the public interface) unless the method
has code to deal with it. The main goal of the tests is to test that the method does what it is supposed to do,
if correct input is given. If no external input is sent to a method (from the user or third party libraries), a method
must not test for invalid input as it is in the responsibility of the developer to ensure that he calls the method
only with valid input.

Github Issues
-------------

Feature requests, todo requests and bug reports all use the Github issues. To separate them labels and naming conventions
are used. To prevent push misuse, you need to fork the project and submit pull requests to collaborate. Because you
are not a Github collaborator, you can't get issues assigned via the technical way. To show that you work on an issue,
post a comment to the issue stating that fact. If you cannot continue to work on the issue, you still should make your
current work public so that others can continue to work where you have left.

Feature request
---------------
*This section will change after the first stable version is released.*

A feature request requests a feature that is so far not implemented or part of the planned features. During initial
development feature requests have the intention to add features to the features available on release of the first
stable version. Feature requests after the first stable version can be implemented in any subsequent feature or major
release.

Before submitting a feature request, check if such a request already exists or the feature is already a planned feature.
If no such request exists and the feature is not part of the already planned features, create a feature request.

To do so navigate to the [Github project][2], log in (if you are not logged in already), navigate to issues and click
on "New Issue". The title should follow this pattern:

```
{[WIP]} Feature <shortCallSignForFeature>
```

The call sign for the feature should make it easy to understand what the feature is about. A feature can be anything
from a new cache source up to a new bundle. Of course the higher in the feature hierarchy you go, the more unlikely
it becomes that the feature will be realized.

In the main part you should write the rationale for this feature. Bad: "It is cool." Good: "By adding Memcache as
cache source, the loading times can be reduced significantly."

If you make a statement that includes measurable facts (loading times, etc.), you should add supporting facts for your
statement. Such supporting facts are links to serious websites that deal with the question at hand.

The rationale has to make clear what the added bonus for the WCF extensions is. There are tons of features that many
people want, but the majority of them won't fit into the scope and goal of the WCF extensions.

Even more important than the rationale is the specification. You must explain what is part of the feature, what the
desired functionality is and how it can be tested.

Best is if you can provide a proof of concept (e.g. by link to a website that has the feature).

With all these required detailed information it is intended that you think twice what scope your feature really has.
Try to split one feature (like a new bundle for the extreme) in as many small features as possible. That way it is possible
to reject one feature and accept another. As soon as any part of a feature is rejected, the whole feature gets rejected.
That's why you should create one feature request for every small part of your big feature. One request means one feature
and one pull request to implement it. The bigger the feature, the more changes must be made by a pull request, which
makes a quick realization very unlikely.

This is, because a pull request is provided by one person. If a single person has to implement one big feature, it is
likely that nobody will pick it. But if you split the feature into many small features many more people can work on
the one big feature at the same time.

Todo requests
-------------

*This section will be removed after the first stable version is released.*

These requests will be created once by the project initiator to create an amount of inital features that
will definitely be included in the first stable release. They contain a specification what is part of the feature
and where one can find information on how it should be implemented.

Bug report
----------

*This section will change after the first stable version is released.*

During the initial development of the WCF extensions it is the standard case that things don't work. In this phase
the only relevant thing is that the unit tests that test classes in isolation run through without problems. Functional
tests will come after all elements that work together for a certain feature have been implemented.

Therefore we have different requirements for a bug report. Every bug report must include either the output of a PHPUnit
run (if tests fail) that shows clearly what is the failure/error or the output of a CodeSniffer run that shows
what parts of the Coding Standard are violated. For each bug report concentrate on one aspect. That means if a PHPUnit
run over all tests, indicate that the tests of two different classes fail, create a bug report for each of this classes.

That allows solving the problems individually and closing bug reports as soon as possible when the solution of the one class
is trivial while the solution for the other class requires a lot of work.

During the initial development (and before the ACP extension can be used to test the code with your own browser),
it is strongly advised to add a pull request that fixes the bug report you just have added.

Before we come to the pull requests, we clear how you can add a bug report. To add a bug report go to the [Github
project][2] of the WCF extensions, log in if you haven't done that already, go to the issues and search first if your
report already exists. If not, click on "New Issue" and give it a meaningful title. The title should follow the following
pattern.

```
{[WIP]} ([Tests]|[Coding Standard]) <FQCN>
```

With this information it is cleary what the problem is (a test fails or coding standard is not followed completely),
in which class the problem is (FQCN - Fully Qualified Classname) and if you still work on this bug report (WIP - Work in Progress).

The main text field of the bug report should have this format:
```
(<phpunitOutput>|<phpCodeSnifferOutput>)
```

Please do not include your ideas what the problem might be. If you know what it is, solve it with a pull request.
Otherwise don't mind any further. If you want to report that a class has no test, then make sure in advance that this
class is already in the dev branch on the remote repository ([Github project][2]). If not, then it is not the time
to report it. Everything that you don't find on the remote repository in the dev branch is still being worked on.

But if you actually find such a class, mark it as a Coding Standard bug report and instead of the CodeSniffer output,
write simply "missing test class". Usually this shouldn't happen in the first place, as everything in the dev branch
should be considered working (isolated during PHPUnit test).

Pull requests
-------------
*This section will change after the release of the first stable version.*

If you want to add a new feature or fix an issue, use a pull request for that. Before you start to code, create a title
branch for your particular work.

Pull requests always have dev as the base. If you want to fix a bug report, name the branch fix/<issueNr>. If you want
to implement a feature request/todo request, name the branch feature/<issueNr>.

Once you are done with your work, submit it as a pull request (possible via Github GUI from your fork). As the base branch
you must select the dev branch of the [original project][2]. The title of the pull requests should be named after your
branch. This simplifies searching for existing pull requests that intend to resolve a certain issue.

If you fixed an issue described by a bug report, write into the pull request message ``"Fixed #<issueNr>."``. That way
Github will close the related issue automatically once the pull request is merged into dev. If you have implemented
a new feature of a feature request, replace the Fixed with Resolved and describe shortly what you have done.

Commit rules
------------

For the commit rules, refer to the Symfony documentation section [Work on your patch][3].

[1]: http://symfony.com/doc/current/contributing/code/standards.html
[2]: https://github.com/frmwrk123/symfony-wcf
[3]: http://symfony.com/doc/current/contributing/code/patches.html#work-on-your-patch
