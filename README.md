# A No-Code-Low-Code solution for the misfits, the dropouts, the freaks

For the past 23 years people have asked why I code in PHP. I'll admit, back in 2000 I really wanted to code in Java, so I did. I wrote a lot of Java, PERL, Javascript, Flex, whatever was 'hot' at the time. But, time after time I kept building project in PHP. First PHP3, then PHP4, 5, 6 (just kidding), 7 and now PHP8. 

Time after time at tech conference, online, some asshole manager I was criticised for using PHP. At this point in my career I'm done with the programming language religious wars. 

So you don't think a No-Code-Low-Code system should be written in PHP?? Fine, [Piss off and Go Away](https://www.urbandictionary.com/define.php?term=Elitest).

NoLoCo is a No-Code-Low-Code framework written in PHP. This project is the free and open core which contains the basic tools for NoLoCo.

# NoLoCo

As you already know, NoLoCo stands for No/Low-Code and yes, it's written in PHP.  The point of NoLoCo is to make an easy to use, easy to modify No/Low-Code solution that is accessible to anybody.

## NoLoCo-Core

This project is the core code used for the processes. It contains the basics needed for the engine, the validation, and a basic set of NodeCode and CatalogNodes.

The code can be run inline with other code by executing a proceess and getting the results of the process.

## NoLoCo - Bundle

If you want to use NoLoCo inside of your Symfony project, then include the NoLoCo bundle in your Symfony project. From there you can call the process engine directly.

## NoLoCo - Runtime Plane

If you want a robust runtime plane with one to many nodes processing requests via the HTTP, then get the Docker NoLoCo Runtime Plane Image. 

## NoLoCo - Queue Processor

If you want to process a queue with NoLoCo, use the Docker image for the NoLoCo queue processor that will dequeue messages and process them using a NoLoCo process.

## Our model : Free-Promium

We want to give back to the community and industry that has supported us all these years. As such our goal is to offer valuable code for free. 

There is a need to have some income to pay some bills and as such, we will offer some pro-plugins at low yearly cost along with professional services for businesses that need some help use the platform. 

## Unit Tests

We use PHPUnit for our unit tests. The test cases can be found in the tests folder.

## Code Quality Tools

We use Code_Sniffer for our quality standards. We include PSR1, PSR2, and PSR12.
