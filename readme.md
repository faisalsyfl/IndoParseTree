## Description
Indonesian Part of Speech Tagger
This program trains Indonesian model using Hidden Markov Model.
The data used from [link](https://github.com/faisalsyfl/IndoPOSTag/tree/master/datasets/idn-tagged-corpus-master#readmemd-versi-bahasa).

## Datasets
Please see the ```datasets/ ``` for the datasets

## Database
Don't forget upload the database ```db_postag.php`` into your MySQL

## Function

Please see the ```application/model/Tools.php``` for the function.  
The Following function can be used:

``` php
praProcess();
transitionProb();
EmissionProb();
Viterbi();
    
```
## Installation
1. Clone repo using Git
``` shell
# clone repository into your htdocs dir
git clone https://github.com/faisalsyfl/IndoPOSTag.git 
```
2. Open your localhost/apache ex: http://localhost/IndoPOSTag



