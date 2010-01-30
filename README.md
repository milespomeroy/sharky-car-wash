# Sparky Car Wash

Sparky squirrel manages a car detailing service in downtown Durham. Sparky has 2 lanes into which customers can pull up and pay for one of three different levels of service they would like: Silver, Gold or Platinum, which take 5 minutes, 10 minutes and 15 minutes of hands-on work from the employees each respectively. While an employee is working on one vehicle, they cannot work on another. Also, only one employee works on a car at a time. Meaning that to be 100% efficient and service all vehicles currently in all 2 lanes (if it were a busy day), Sparky needs 2 employees to be at work. This is rarely the case as most employees prefer to hang out at the Valley Springs park disc golf course in Durham to being at work.

There is a problem that Sparky needs to solve here. He needs to be able to tell a customer what the expected wait time is before an employee will start working on their car. He also needs to be able to tell them how long it'll be until their car will be ready for them to be picked up. But that one is easy: waiting time + service time.

That's where you come in. Being a fresh California transplant, you realize that you don't really connect with the Durhamites how you thought you would. Disc golf bores you. The mini-brewery around every corner doesn't interest you. And you definitely are not interested in Southern comfort food. What you are, however, interested in, is solving problems for people using the power of computers! 

Your mission, should you choose to accept it, is to stand at the door of the Sparky Car Detailing shop and answer customers when they ask you how long they have until their car will be ready. You should be able to answer this even if they are currently waiting for a free lane and an employee has not started working on their car yet.

You've been given a Unix box with shell access. You discover that the box does not have MySQL installed, and has no internet access for you to install any packages other than what already exists on the machine. Apache and PHP 5.3, however, are installed and functioning.

I want you to tackle this problem using OO PHP. You will not need a user interface. If you need to store anything, you can accomplish it with flat files.

## Assume:

- that there is no lag time between different cars being serviced.
- that at the end of each day, Sparky's employees will have finished working on all cars in all lanes and you always start with an empty shop each morning.
- the day starts at 7am (if you need it).
- the day ends at 6pm (if you need it).

## MY IMPLEMENTATION

Commandline PHP script. It will create a file, thecars.inc, that will store the car objects between runs of the program. This file can be deleted each day.