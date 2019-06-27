# ClassScheduling

## Problem

This piece of code was written to provide a solution for the following problem:

> For the rising Junior, the school has opened up 11 AP courses, which would be divided to be held in 4 different periods. Since each individual is only able to take one course at a time (unless you have Hermione's magic watch), some courses are to be in conflict with other ones. Then it is your job to find a way to divide up the 11 courses up so that most people would be able to satisfy their own needs. Suppose we have the data for all students' course, how shall you give a good way to divide them up?

## Why we can enumerate?

First let's analyze the problem. Perhaps we could put all 11 courses into one period, but intuition tells that it is better to cut it evenly. We should probably use a 2-3-3-3 combination. Thus how many ways can them be divided up? Use a little bit of math, we can find out that there are 92400 ways. (And further, if the order of the three "3"s doesn't matter, the number shall be divided by 6.)

92400 is big, but for computers, it's just a little one. Then it is clear: we can simply enumerate all possible strategies, and then figure out which one is better.

## How can you compare two strategies?

Let's simplify this problem a bit: say one is happier if he has more courses, no matter how many he chose at first. This shall not interfere with the nature of the question too much, but can result in less coding work.

First, no single strategy can satisfy everyone. One strategy can simultaneous make 10 people get all classes they want while making another 10 only able to choose one course. Therefore, it is difficult to tell one best answer from all strategies.

But sometimes we truly can tell one is better than another: if we consider the following:

| # of People able to have N courses | 1 | 2 | 3 | 4 |
| ------ | ------ | ------ |------ |------ |
| Strategy 1 | 0 | 5 | 10 | 3 |
| Strategy 2 | 1 | 4 | 12 | 1 |

Then I dare to say 1 is better than 2.

Still Not clear? Then...

| # of People **at least** able to have N courses | 1 | 2 | 3 | 4 |
| ------ | ------ | ------ |------ |------ |
| Strategy 1 | 18 | 18 | 13 | 3 |
| Strategy 2 | 18 | 17 | 13 | 1 |

The above should be self-explanatory. Each figure from 1 is higher than 2. Enough to make a difference.

Then we could use an array to store all acquired strategies, and if there is a new strategy, try to compare it with all array members. Quit the enumeration if there is one acquired strategy strictly better than our current strategy, then eliminate all that is definitely worse than it, and finally insert itself into the array.

## Finally, check out the answers!

We've got 11 answers, and their result distributions are:

| # of People | 1 | 2 | 3 | 4 |
| ------ | ------ | ------ |------ |------ |
|Strategy 1|0|17|15|11|
|Strategy 2|1|5|32|5|
|Strategy 3|0|10|25|8|
|Strategy 4|1|7|26|9|
|Strategy 5|1|6|30|6|
|Strategy 6|0|9|27|7|
|Strategy 7|1|9|23|10|
|Strategy 8|1|12|19|11|
|Strategy 9|0|11|22|10|
|Strategy 10|2|5|29|7|
|Strategy 11|0|8|29|6|

Strategies 2,4,5,7,8,10 are sad strategies, because in those cases 1 or 2 of them would only take one course for a whole year, ~~then wasting their time during their free periods playing basketball and break a leg~~

| # of People | 1 | 2 | 3 | 4 |
| ------ | ------ | ------ |------ |------ |
|Strategy 1|0|17|15|11|
|Strategy 3|0|10|25|8|
|Strategy 6|0|9|27|7|
|Strategy 9|0|11|22|10|
|Strategy 11|0|8|29|6|

Thus we've got our winners! Final step, check with teachers, and be sure they are happy. In all strategies above there may still be drawbacks, but somebody's sacrifice is not avoidable. Rather, teachers could favor one strategy over another. Some teachers might want to have class in the same period so that in other ones they can have a intimate chat ^_^
