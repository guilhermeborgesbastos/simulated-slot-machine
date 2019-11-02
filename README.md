# Simulated Slot Machine using Lumen

In this repository, it was developed part of a **Simulated Slot Machine** using Lumen (https://lumen.laravel.com/docs/5.5).

To make it as simple as possible it was create a console command inside the project created using Lumen.

___

## Requirements

1. Assume that every bet as the value of 1 Euro.
2. Generate a random board with 5 columns and 3 rows using 10 different symbols:
```9, 10, J, Q, K, A, cat, dog, monkey and bird```

3. Use the following logic for numbering each symbol on the board:

| **0** | **3** | **6** | **9** | **12** |
|:-:|:-:|:-:|:-:|:-:|
| **1** | **4** | **7** | **10** | **13** |
| **2** | **5** | **8** | **11** | **14** |


### Example
Suppose the board generated was the following
```J, J, J, Q, K, cat, J, Q, monkey, bird, bird, bird, J, Q, A```

These 15 random symbols generated the table:

| **J** | **J** | **J** | **Q** | **K** |
|:-:|:-:|:-:|:-:|:-:|
| **Cat** | **J** | **Q** | **Monkey** | **Bird** |
| **Bird** | **Bird** | **J** | **Q** | **A** |

4. A pay out happens when 3 or more consecutive symbols of the same kind are present in a
payline, always starting from the first column (0,1,2). For the test consider the following
paylines:

| Payline Sequences |
|:-:|
| 0 3 6 9 12 | 
| 1 4 7 10 13 | 
| 2 5 8 11 14 | 
| 0 4 8 10 12 | 
| 2 4 6 10 14 |
	 
From the example above 2 paylines are matched <span style="color:red">**J J J**</span> from [ <span style="color:red">**0 3 6**</span> 9 12 ] and [ <span style="color:red">**0 4 8**</span> 10 12 ].

5. Pay out return to the players in the following amounts:

| Match | Pay out percentage |
|:-:|:-:|
| 3 symbols | 20% of the bet |
| 4 symbols | 200% of the bet |
| 5 symbols | 1000% of the bet |

6.) Print in the console command the following:

* **board:** [0,....,14]
* **paylines:** Array with matched payline and number of matched symbol.
* **bet_amount:** monetary numbers in cents 1€ = 100cents.
* **total_win:** amount won.

#### Console Output

Considering the above example the result will be:
```xml
{
    board: [J, J, J, Q, K, cat, J, Q, monkey, bird, bird, bird, J, Q, A],
    paylines: [{"0 3 6 9 12": 3}, {"0 4 8 10 12":3}],
    bet_amount: 100,
    total_win: 40
}
```