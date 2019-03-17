# Migrating from CVS to Git

## Overview

### Introduction

This repository was originally tracked / versioned using [CVS](https://en.wikipedia.org/wiki/Concurrent_Versions_System), running under Windows.

The sections below detail how I went about migrating the repository to [Git](https://git-scm.com/) and pushing it to [GitHub](https://github.com/).

The migration was performed within a [Ubuntu](https://www.ubuntu.com/) bash shell, running under [Windows Subsystem for Linux](https://docs.microsoft.com/en-us/windows/wsl/about).

The main tools used were [cvs-fast-export](http://www.catb.org/~esr/cvs-fast-export/) and Git itself, referencing the [howto](http://www.catb.org/~esr/reposurgeon/dvcs-migration-guide.html) guide from [reposurgeon](http://www.catb.org/~esr/reposurgeon/).



### Approach

The approach was to export the original repository directly from CVSROOT and import it into Git.

The cvs-fast-export tool did a great job, exporting the legacy CVS repository as a Git fast-import file.

The process was largely automatic and mapping the committers / authors was the only minor complication.

The .git directory was then copied into the original project directory and local changes / additions reviewed.

Finally and once I was happy with everything the Git repository was pushed to GitHub.



## Pre-Requisites

### Installing cvs-fast-export

Install GCC:

```sh
mike@MIKE-ENVY:~$ sudo apt install gcc
```

Install make:

```sh
mike@MIKE-ENVY:~$ sudo apt install make
```

Install CVS:

```sh
mike@MIKE-ENVY:~$ sudo apt install cvs
```

Install asciidoc:

```sh
mike@MIKE-ENVY:~$ sudo apt-get update
mike@MIKE-ENVY:~$ sudo apt install asciidoc
```

Install cvs-fast-export:

```bash
mike@MIKE-ENVY:~/cvs-fast-export-1.45$ make
...
mike@MIKE-ENVY:~/cvs-fast-export-1.45$ make check
...
mike@MIKE-ENVY:~/cvs-fast-export-1.45$ sudo make install
[sudo] password for mike:
install -d "/usr/local/bin"
install cvs-fast-export cvssync cvsconvert "/usr/local/bin"
install -d "/usr/local/share/man/man1"
install -m 644 cvs-fast-export.1 "/usr/local/share/man/man1"
install -m 644 cvssync.1 "/usr/local/share/man/man1"
install -m 644 cvsconvert.1 "/usr/local/share/man/man1"
```



### Installing Dos2Unix

This tool is needed for conversion of CR/LF to LF:

```bash
mike@MIKE-ENVY:~$ sudo apt install dos2unix
```



## Migration

### Exporting from CVSROOT

Export the existing repository / module from CVSROOT using cvs-fast-export:

```sh
mike@MIKE-ENVY:/mnt/c/CAESAR/CVSROOT$ find CAESAR | cvs-fast-export -p >../CAESAR.fi
2019-03-16T19:25:02Z: Reading file list...done, 118273.393KB in 1956 files (0.312sec)
2019-03-16T19:25:03Z: Analyzing masters with 8 threads...done, 4736 revisions (14.572sec)
2019-03-16T19:25:17Z: Make DAG branch heads...1956 of 1956(100%)    (0.003sec)
2019-03-16T19:25:17Z: Sorting...done  (0.000sec)
2019-03-16T19:25:17Z: Compute branch parent relationships...2 of 2(100%)    (0.000sec)
2019-03-16T19:25:17Z: Collate common branches...1 of 2(50%)
cvs-fast-export: warning - branch point import-1.1.1 -> master later than branch
cvs-fast-export:        trunk(311):  2006-10-15T08:55:44Z  bin/load_tables.sh 1.1
cvs-fast-export:        branch(311): 2006-10-15T08:57:18Z  bin/load_tables.sh 1.1.1.1
2019-03-16T19:25:17Z: Collate common branches...2 of 2(100%)    (0.056sec)
2019-03-16T19:25:17Z: Find tag locations...3 of 3(100%)    (0.003sec)
2019-03-16T19:25:17Z: Compute tail values...done  (0.000sec)
2019-03-16T19:25:17Z: Generating snapshots...done (2.086sec)0%)
2019-03-16T19:25:19Z: Saving in fast order: done (0.054sec))
cvs-fast-export: no commitids before 2010-10-31T16:25:50Z.
       after parsing:   15.028  7116KB
after branch collation: 15.098  11540KB
               total:   17.243  59392KB
306 commits/239.418M text, 4310 atoms at 17 commits/sec.
```

Note: Warning about branch point



### Mapping Committers / Authors

"Mike" was mapped to "Logiqx" using the following hack:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ strings CAESAR.fi | grep 'committer' | awk '{print $1, $2, $3}' | sort -u
committer Mike <Mike>
mike@MIKE-ENVY:/mnt/c/CAESAR$ sed 's/committer .* <.*>/committer Logiqx <software@mikeg.me.uk>/' CAESAR.fi >CAESAR.tmp.fi
mike@MIKE-ENVY:/mnt/c/CAESAR$ strings CAESAR.tmp.fi | grep 'committer' | awk '{print $1, $2, $3}' | sort -u
committer Logiqx <software@mikeg.me.uk>
```

Note: I'm not 100% happy about hacking the fast import file but it seemed to work ok!



### Importing to Git

The "fast import" was performed using the standard Git client:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR.tmp$ git init
Initialized empty Git repository in /mnt/c/CAESAR.tmp/.git/
mike@MIKE-ENVY:/mnt/c/CAESAR.tmp$ git fast-import <../CAESAR/CAESAR.tmp.fi
git-fast-import statistics:
---------------------------------------------------------------------
Alloc'd objects:       5000
Total objects:         4745 (      1699 duplicates                  )
      blobs  :         2927 (      1696 duplicates       1898 deltas of       2693 attempts)
      trees  :         1512 (         3 duplicates       1270 deltas of       1409 attempts)
      commits:          306 (         0 duplicates          0 deltas of          0 attempts)
      tags   :            0 (         0 duplicates          0 deltas of          0 attempts)
Total branches:           5 (         2 loads     )
      marks:        1048576 (      4928 unique    )
      atoms:           1988
Memory total:          2532 KiB
       pools:          2298 KiB
     objects:           234 KiB
---------------------------------------------------------------------
pack_report: getpagesize()            =       4096
pack_report: core.packedGitWindowSize = 1073741824
pack_report: core.packedGitLimit      = 8589934592
pack_report: pack_used_ctr            =        118
pack_report: pack_mmap_calls          =          6
pack_report: pack_open_windows        =          1 /          1
pack_report: pack_mapped              =   30548131 /   30548131
---------------------------------------------------------------------
```



### Checking Out from Git

Checkout all of the files and check the author(s):

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR.tmp$ git checkout
Checking out files: 100% (1843/1843), done.
mike@MIKE-ENVY:/mnt/c/CAESAR.tmp$ git status
On branch master
nothing to commit, working directory clean
mike@MIKE-ENVY:/mnt/c/CAESAR.tmp$ git log | grep Author | sort -u
Author: Logiqx <software@mikeg.me.uk>
```



### Switching from CVS to Git

Remove the CVS directories and copy the Git repository into the project directory.

```bash
mike@MIKE-ENVY:/mnt/c$ find CAESAR -type d -name CVS -exec rm -fr {} \;
...
mike@MIKE-ENVY:/mnt/c$ rm -fr CAESAR/CVSROOT
mike@MIKE-ENVY:/mnt/c$ mv CAESAR.tmp/.gitignore CAESAR/
mike@MIKE-ENVY:/mnt/c$ mv CAESAR.tmp/.git CAESAR/
```



## Comparing Project Directories

A simple directory comparison was used to compare the CVS and Git project directories:

```bash
mike@MIKE-ENVY:/mnt/c$ diff -rq CAESAR CAESAR.tmp | grep "Only in" | grep "CAESAR.tmp:"
mike@MIKE-ENVY:/mnt/c$ diff -rq CAESAR CAESAR.tmp | grep "Only in" | grep -v "CAESAR.tmp:"
...

mike@MIKE-ENVY:/mnt/c$ mike@MIKE-ENVY:/mnt/c$ diff -rwq CAESAR CAESAR.tmp | grep "Files"
Files CAESAR/bin/notin.exe and CAESAR.tmp/bin/notin.exe differ
Files CAESAR/data/emus/multi/mame.xml and CAESAR.tmp/data/emus/multi/mame.xml differ
Files CAESAR/dtd/xhtml1-strict.dtd and CAESAR.tmp/dtd/xhtml1-strict.dtd differ
Files CAESAR/www/_filelist_inspiron.txt and CAESAR.tmp/www/_filelist_inspiron.txt differ
```



### Converting CR/LF to LF

Ensure that all text files in the project directory are converted from CR/LF to LF:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git status | grep modified: | sed 's/.*modified:   //' | xargs dos2unix
```

Note: Binary files are automatically skipped by the dos2unix command.

Check for local changes which should now be consistent with the directory comparison:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git status
On branch master
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

        modified:   bin/notin.exe
        modified:   data/emus/multi/mame.xml
        modified:   dtd/xhtml1-strict.dtd
        modified:   www/_filelist_inspiron.txt

Untracked files:
  (use "git add <file>..." to include in what will be committed)

        CAESAR.fi
        CAESAR.tmp.fi
        Migration.md
        data/games/_mame_map_test.out
        data/games/d128.bat
        data/games/logs.dat/
        data/games/logs.map/
        data/games/multi/MAME_v0.140.dat
        data/games/nonmame.txt
        dev/crashtest/crashtest.dat
        dev/crashtest/crashtest.log
        dev/crashtest/imgchk.log
        dev/fba/fba.dat
        dev/images/images.dat
        dev/images/images.log
        dev/images/imgchk.log
        www/cache/
        www/images/
        www/snaps/
        www/txt/
        www/zips/
```



## Tidy Up

### Configuring the Git User

Prior to committing any changes to Git the user name and e-mail need to be specified:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git config --global user.name "Logiqx"
mike@MIKE-ENVY:/mnt/c/CAESAR$ git config --global user.email "software@mikeg.me.uk"
```



### Reviewing Local Changes

Use the GIt "status" and "diff" commands to identify local changes:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git status
On branch master
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

        modified:   data/emus/multi/mame.xml
        modified:   dtd/xhtml1-strict.dtd
        modified:   www/_filelist_inspiron.txt

Untracked files:
  (use "git add <file>..." to include in what will be committed)

        CAESAR.fi
        CAESAR.tmp.fi
        Migration.md
        data/games/_mame_map_test.out
        data/games/d128.bat
        data/games/logs.dat/
        data/games/logs.map/
        data/games/multi/MAME_v0.140.dat
        data/games/nonmame.txt
        dev/crashtest/crashtest.dat
        dev/crashtest/crashtest.log
        dev/crashtest/imgchk.log
        dev/fba/fba.dat
        dev/images/images.dat
        dev/images/images.log
        dev/images/imgchk.log
        www/cache/
        www/images/
        www/snaps/
        www/txt/
        www/zips/

no changes added to commit (use "git add" and/or "git commit -a")

mike@MIKE-ENVY:/mnt/c/CAESAR$ ... one-off commits, ignores, etc ...
```



### Removing Empty Folders

Empty data folders were removed as follows:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR/data$ find . -type d -exec du -sb {} \; | grep 4096
4096    ./games/digita
4096    ./games/digita2
4096    ./games/fake
4096    ./games/linux2
4096    ./games/ps2
4096    ./games/psion
4096    ./games/qnx
4096    ./games/single2
4096    ./games/sound2
mike@MIKE-ENVY:/mnt/c/CAESAR/data$ rmdir ./games/digita ./games/digita2 ./games/fake ./games/linux2 ./games/ps2 ./games/psion ./games/qnx ./games/single2 ./games/sound2
```



### Final Check 

Check that the repository is clean:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git status
On branch master
Untracked files:
  (use "git add <file>..." to include in what will be committed)

        CAESAR.fi
        CAESAR.tmp.fi
        Migration.md

nothing added to commit but untracked files present (use "git add" to track)
```



## Publication

### Pushing the Repo to GitHub

Push the local repository to GitHub:

```bash
mike@MIKE-ENVY:/mnt/c/CAESAR$ git remote add origin https://github.com/Logiqx/caesar.git
mike@MIKE-ENVY:/mnt/c/CAESAR$ git push -u origin --all
Username for 'https://github.com': Logiqx
Password for 'https://Logiqx@github.com':
Counting objects: 6667, done.
Delta compression using up to 4 threads.
Compressing objects: 100% (3204/3204), done.
Writing objects: 100% (6667/6667), 52.89 MiB | 337.00 KiB/s, done.
Total 6667 (delta 3343), reused 4679 (delta 3168)
remote: Resolving deltas: 100% (3343/3343), done.
To https://github.com/Logiqx/caesar.git
 * [new branch]      import-1.1.1 -> import-1.1.1
 * [new branch]      master -> master
Branch import-1.1.1 set up to track remote branch import-1.1.1 from origin.
Branch master set up to track remote branch master from origin.
mike@MIKE-ENVY:/mnt/c/CAESAR$ git status
On branch master
Your branch is up-to-date with 'origin/master'.
Untracked files:
  (use "git add <file>..." to include in what will be committed)

        Migration.md

nothing added to commit but untracked files present (use "git add" to track)
```



### Final Check

Pull the repository from GitHub and compare with the working directory:

```bash
mike@MIKE-ENVY:/mnt/c$ git init CAESAR.github
Initialized empty Git repository in /mnt/c/CAESAR.github/.git/
mike@MIKE-ENVY:/mnt/c$ cd CAESAR.github
mike@MIKE-ENVY:/mnt/c/CAESAR.github$ git remote add origin https://github.com/Logiqx/caesar.git
mike@MIKE-ENVY:/mnt/c/CAESAR.github$ git pull origin master
remote: Enumerating objects: 6614, done.
remote: Counting objects: 100% (6614/6614), done.
remote: Compressing objects: 100% (3027/3027), done.
remote: Total 6614 (delta 3303), reused 6614 (delta 3303), pack-reused 0
Receiving objects: 100% (6614/6614), 52.89 MiB | 2.29 MiB/s, done.
Resolving deltas: 100% (3303/3303), done.
From https://github.com/Logiqx/caesar
 * branch            master     -> FETCH_HEAD
 * [new branch]      master     -> origin/master
Checking out files: 100% (3661/3661), done.
mike@MIKE-ENVY:/mnt/c/CAESAR.github$ rm -fr .git
mike@MIKE-ENVY:/mnt/c/CAESAR.github$ cd ..
mike@MIKE-ENVY:/mnt/c/Logiqx$ diff -r CAESAR.github/ CAESAR
Only in CAESAR/dev/cat2txt: cat2txt.exe
Only in CAESAR/dev/cat2txt: obj
Only in CAESAR/dev/crashtest: crashtest.exe
Only in CAESAR/dev/crashtest: obj
Only in CAESAR/dev/fba: fba.exe
Only in CAESAR/dev/fba: obj
Only in CAESAR/dev/images: images.exe
Only in CAESAR/dev/images: obj
Only in CAESAR/dev/info2txt: info2txt.exe
Only in CAESAR/dev/info2txt: obj
Only in CAESAR/dev/manu: manu.exe
Only in CAESAR/dev/manu: obj
Only in CAESAR/dev/map2txt: map2txt.exe
Only in CAESAR/dev/map2txt: obj
Only in CAESAR/dev/mapfix: mapfix.exe
Only in CAESAR/dev/mapfix: obj
Only in CAESAR/dev/notin: notin.exe
Only in CAESAR/dev/notin: obj
Only in CAESAR/dev/xml2txt: obj
Only in CAESAR/dev/xml2txt: xml2txt.exe
Only in CAESAR: .git
Only in CAESAR: Migration.md
Only in CAESAR: tmp
Only in CAESAR/www: backup
Only in CAESAR/www: images
Only in CAESAR/www: snaps
Only in CAESAR/www: zips
```

Note:  The "Only in CAESAR" items are all fine.
