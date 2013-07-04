how to use 
V 0.1

See example.php for more examples

----------------------------
Classes, types and functions
----------------------------
View
	This object is used for showing results in a single array  
ViewObject
	Representation of a DataObject in the View
ViewFormat
	Stores information about the way the index and values should be shown

DataObject
	This object is used to store information in
DataCalculationObject
	A child object of the DataObject for storing calculations, contains DataCalculationValueObjects
DataCalculationValueObject
	Representation of a DataObject (or dataCalculationObject) in a DataCaclulationObject


DataSource
	Not implemented yet, Child object of DataObject for storing data sources
SourceFile
	Not implemented yet, stores the source information and data from a file
SourceWeb
	Not implemented yet, stores the source information and data from the web

---------------------
Creating a basic View 
---------------------

-----
input
-----
Array:
[	day1 => [t => 45, v => 1], 
	day2 => [t => 34, v => 2],
	day3 => [t => 25, v => 3]] 
	
with:
ViewFormat("fn1", "", "t")
ViewFormat("fn2", "", "v")

------
output
------
Array:
[	0 => ["t as value" => [day1 => 45, day2 => 34, day3 => 25]]
	1 => ["v as value" => [day1 => 1 , day2 => 2 , day3 => 3]]] 
	
-------------------------
Creating a View with mask
-------------------------

-----
input
-----
Array:
[	day1 => [t => 45, v => 1], 
	day2 => [t => 34, v => 2],
	day3 => [t => 25, v => 3]] 

Mask for fn2
Array:
[	day1 => "1 okt", 
	day2 => "2 okt",
	day3 => "3 okt"]
	
	
with:
ViewFormat("fn1", "", "t")
ViewFormat("fn2", "", "v")

------
output
------

Array: 
[	0 => ["t as value" => [day1    => 45, day2 	  => 34, day3 	 => 25]]
	1 => ["v as value" => ["1 okt" => 1 , "2 okt" => 2 , "3 okt" => 3]]] 


------------------
Using calculations
------------------
Matching indexed will be sought in order to do calculation on arrays, 
a mask could be added to a DataObject to make the indexes match.
Existing DataCalculationObject can be used in new calculations, and will be treated just like an ordinary DataObject

myArray1:
[	day1 => 1 
	day2 => 2  
	day3 => 3] 
	
myArray2:
[	day1 => 5 
	day2 => 1  
	day3 => 3] 

-------	
--SUM--	

---------
example 1: add 2 arrays
---------
	add myArray1 and myArray2 to a calculationObject
	call sum()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	------
	output
	------
	Array [6,3,6]
	
---------
example 2: add 2 arrays, then add a value
---------

	add myArray1 and myArray2 to a calculationObject
	set value ( value is 3 in this example)
	call sum()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	value	  3	
	------
	output
	------
	Array [9,6,9]
		
--END SUM--	
-----------

------------
--SUBTRACT--	

---------
example 1: subtract 2 arrays
---------
	add myArray1 and myArray2 to a calculationObject
	call subtract()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	------
	output
	------
	Array [-4,1,0]
	
---------
example 2: subtract 2 arrays, then subtract a value
---------

	add myArray1 and myArray2 to a calculationObject
	set value ( value is 3 in this example)
	call subtract()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	value	  3	
	------
	output
	------
	Array [-7,-2,-3]
		
--END SUBTRACT--	
----------------

------------
--MULTIPLY--	

---------
example 1: multiply 2 arrays
---------
	add myArray1 and myArray2 to a calculationObject
	call multiply()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	------
	output
	------
	Array [5,2,9]
	
---------
example 2: multiply 2 arrays, then multiply with value
---------

	add myArray1 and myArray2 to a calculationObject
	set value ( value is 3 in this example)
	call multiply()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	value	  3	
	------
	output
	------
	Array [15,6,27]
		
--END MULTIPLY--	
----------------

----------
--divide--	

---------
example 1: divide 2 arrays
---------
	add myArray1 and myArray2 to a calculationObject
	call divide()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	------
	output
	------
	Array [0.2, 2, 1]
	
---------
example 2: divide 2 arrays, then divide with value
---------

	add myArray1 and myArray2 to a calculationObject
	set value ( value is 2 in this example)
	call divide()

	-----
	input
	-----
	myArray1 [1, 2, 3]
	myArray2 [5, 1, 3]
	value	  2	
	------
	output
	------
	Array [0.1, 1, 0.5]
		
--END DIVIDE--	
--------------





