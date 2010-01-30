#!/usr/bin/php
<?php
   //			Call from commandline 			   \\
  //					     					    \\
 // 	Created by Miles Pomeroy 2010-01-26			 \\
//	thecars.inc can be deleted at the end of each day \\


////////// Functions ////////

// Change to human time from timestamp
date_default_timezone_set('America/Los_Angeles'); 
function htime($ts)
{
	return date("g:i a", $ts);
}


//////// Classes ////////

class Car
{
	public $service_time = 0;
	public $service_type = NULL;
	public $starttime = 0;
	public $endtime = 0;
 	public $inst_time = 0;	

	function __construct($service) 
	{
		$this->service_type = $service;
		$this->set_service_time($service);
		
		// set instantiation time
		$this->inst_time = time();
	}
	
	function set_service_time($type)
	{
		// set time
		switch ($type):
			case 'silver':
				$this->service_time = 5;
				break;
			case 'gold':
				$this->service_time = 10;
				break;
			case 'platinum':
				$this->service_time = 15;
				break;
		endswitch;
	}
	
	function start_service($time)
	{
		$this->starttime = $time;
		$this->endtime = $this->starttime + ($this->service_time * 60);
	}
}

class Cars
{
	public $cars = array();
	
	function __construct()
	{
		if (file_exists('thecars.inc'))
		{
			// get cars from file
			$c = file_get_contents('thecars.inc');
			$this->cars = unserialize($c);
		}
	}
	
	function add_car($car_inst)
	{
		$this->cars[] = $car_inst;
	}
	
	function get_starttime($emp_num)
	{
		$now = time();
		
		// waittimes for each lane
		$waittime = array();
		foreach ($this->cars as $car)
		{
			// car(s) currently being serviced
			if ($car->endtime > $now)
			{
				if ($car->starttime < $now)
				{
					$waittime[] = $car->endtime;
				}
			}
		}
		// lane one
		if (isset($waittime[0]))
		{
			$lane_one = $waittime[0];
		}
		else
		{
			$lane_one = $now;
		}
		// lane two
		if (isset($waittime[1]))
		{
			$lane_two = $waittime[1];
		}
		else
		{
			$lane_two = $now;
		}
		
		// recalc times: needed due to employee number flakiness
		foreach ($this->cars as $car)
		{
			if ($car->starttime > $now) // only for waitlist cars
			{
				if ($emp_num == 1)
				{
					$lane = 'lane_one';
				}
				else
				{
					// choose lane with shortest wait
					if ($lane_one > $lane_two)
					{
						$lane = 'lane_two';
					}
					else
					{
						$lane = 'lane_one'; // default
					}
				}
		
				// change times in instance
				$car->start_service($$lane);
				// change lane time wait
				$$lane = $car->endtime;
			}
		}
		
		if ($emp_num == 1)
		{
			$starttime = $lane_one;
		}
		else 
		{
			if ($lane_one > $lane_two)
			{
				$starttime = $lane_two;
			}
			else 
			{
				$starttime = $lane_one;
			}
		}
		
		return $starttime;
	}
	
	function __destruct()
	{
		// store cars in file
		$s = serialize($this->cars);
		file_put_contents('thecars.inc', $s);
	}
}


//////// Main Code ////////
print "*** First some questions ***\n";
print "Which level would you like? (silver/gold/platinum): ";
$service = trim(fgets(STDIN));

// new car
$newcar = new Car($service);

print "Number of employees working?  ";
fscanf(STDIN, "%d\n", $emp_num);

if (!$emp_num)
{
	print "\n*** Can't do nuttn' ***\n";
	exit;
}

// load waiting cars
$waitingcars = new Cars();

// get start time based on waiting cars
$starttime = $waitingcars->get_starttime($emp_num);

// set start time and endtime of instance
$newcar->start_service($starttime);

print "\n*** Times ***";
print "\nStart time: ";
print htime($newcar->starttime);

print "\nPick up: ";
print htime($newcar->endtime);
print "\n";

// add new car
$waitingcars->add_car($newcar);