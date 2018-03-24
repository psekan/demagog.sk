# demagog.sk
## Project description
Command line application for processing politicians' assertions from public website http://www.demagog.sk/.

## How to install

For installation you just need `git` and `php 5.6/7.x`.  
```bash
# Clone source code to a directory
git clone https://github.com/psekan/demagog.sk.git
# Initialize database
cd demagog.sk
php demagog update
```

## Available commands
```
help         Displays help for a command
list         Lists commands
parties      Print political parties
politicians  Print politicians
update       Update database with actual data from website
```

### Command `parties`

Print list of all political parties.
```
Usage:
  parties [options]

Options:
  -r, --relevant                         Show only relevant parties.
  -m, --median                           Show median of each party.
  -t, --relevant-limit[=RELEVANT-LIMIT]  Limit for relevant parties. [default: 50]
  -c, --sort-correct                     Sort parties by correct answers.
  -l, --sort-lie                         Sort parties by lies answers.
```

### Command `politicians`

Print list of politicians.
```
Usage:
  politicians [options] [--] [<name>]

Arguments:
  name                                   Show only politicians with a name.

Options:
  -r, --relevant                         Show only relevant politicians.
  -t, --relevant-limit[=RELEVANT-LIMIT]  Limit for relevant parties. [default: 10]
  -p, --party=PARTY                      Show politician only from a party.
  -c, --sort-correct                     Sort politicians by correct answers.
  -l, --sort-lie                         Sort politicians by lies answers.
```

## Example
Show relevant political parties sorted by correct assertions.
```
>php demagog parties -r -c
Party name [assertions]: correct / lies / juggle / non-verifiable
#01 SaS          [ 742]:  75.88% /   7.55% /   5.12% /  11.46%
#02 MOST-HÍD     [1080]:  70.65% /  10.09% /   7.59% /  11.67%
#03 Nová väčšina [ 322]:  69.88% /   9.94% /   9.01% /  11.18%
#04 OĽaNO        [ 413]:  68.28% /  10.65% /   7.51% /  13.56%
#05 Nestraníci   [1342]:  67.06% /  12.22% /   5.51% /  15.20%
#06 KDH          [1218]:  65.44% /  11.74% /   8.37% /  14.45%
#07 SDKÚ-DS      [1123]:  64.47% /  12.56% /   8.19% /  14.78%
#08 SKOK!        [  67]:  64.18% /  14.93% /   7.46% /  13.43%
#09 SMK          [  86]:  63.95% /  18.60% /   5.81% /  11.63%
#10 SME RODINA   [ 151]:  62.25% /  20.53% /   8.61% /   8.61%
#11 SMER-SD      [5212]:  60.73% /  14.43% /  10.78% /  14.06%
#12 SNS          [ 495]:  50.10% /  21.01% /  14.14% /  14.75%
#13 ĽSNS         [  92]:  36.96% /  29.35% /  19.57% /  14.13%
```
