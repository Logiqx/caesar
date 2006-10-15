<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php
			// Standard PHP includes (database connection and constants)

			include ('../resources/include.php');

			// Display the page title

			echo '<title>CAESAR - Interview with Logiqx</title>' . LF . LF;

			// Include standard <head> metadata

			include('../resources/head.php');
		?>
	</head>
	<body>
		<?php
			// The main page content is a 3 column table (left column is the menu, right one is the news)

			echo '<!-- CAESAR pages are basically a table with one row and three columns -->' . LF . LF;

			include('../resources/top.php');
		?>

		<h2>Logiqx Interview</h2>

		<p>Logiqx is the creator of CAESAR and active member in the
		arcade emulation community with cute utilites for ROM collectors.
		I'm quite sad that no one thought about interviewing him, so I
		made my own move and asked him for this. Being a friend of him
		and former member of the CAESAR team helps me to find the right
		questions, so I hope this interview will be interesting for you
		too.<br/>
		<br/>
		The interview was conducted by Pi by email on 01/21/2001.<br/>
		<br/>
		-----------------<br/>
		Q: Hello Logiqx, can you give us a bit of background about you?
		Age, location, job, those things.<br/>
		<br/>
		A: I'm 28 years old and work for a large IT company, developing
		corporate IT systems such as data warehouses and the like. I've
		lived in the UK all my life and currently live near to
		London.<br/>
		<br/>
		Q: Any hobbies besides emulation? What do you do when not into
		emulation?<br/>
		<br/>
		A: Until this summer I was a keen 400 metre hurdler (took me
		around 54 seconds to get around). However, I'm not going to be
		competing this year as I want time to do some of the other things
		I enjoy like Windsurfing. I also started doing Salsa about a year
		ago and still doing it!<br/>
		<br/>
		Q: Again, why Logiqx? Tell us what's behind the nickname.<br/>
		<br/>
		A: I used Logix as a coding name back in the ST days. When I
		joined the emulation scene I found Logix had already gone on the
		free mail services so I added a silent Q.<br/>
		<br/>
		Q: When it was the first contact with arcade machines? Which were
		your favorite games in that time?<br/>
		<br/>
		A: Hmmm, must have been when I was taken to restaurants as a kid.
		I remember having seen Space Invaders in 1980/1981 but the first
		game I actually played was Galaxian. I also enjoyed Konami's
		Track and Field as Daley Thompson's Decathlon was a big favorite
		of mine on the Sinclair Spectrum. My real favorites were from my
		time at sixth form college though (aged 17 to 18) where we had
		loads of free time (err, I mean study time) to kill and arcade
		games filled it up for me. My favorites were Guerrilla War,
		Operation Wolf, Out Run, Gauntlet, Golden Axe, Cabal (rubbish
		graphics but good fun), 1942 and probably almost every other game
		that was at the College!<br/>
		<br/>
		Q: When and how did you make the first contact with emulation?
		Why are you focused in arcade emulation?<br/>
		<br/>
		A: My first contact with emulation was the Spectrum emulators
		that appeared on the Amiga and PC in the early 1990s. My
		obsession with arcade emulation comes from the fact that having
		arcade perfect versions at home was what we dreamt of whilst at
		college. Okay, 10 years have gone by but it is still cool to have
		them running on a home PC!<br/>
		<br/>
		Q: Then you started to make neat utilities for dat files and
		other works in rom management. Also a sample fix for MAME source
		which got its way into MAME already. What made you to get
		involved actively in emulation and why in these areas
		specially?<br/>
		<br/>
		A: Each tool had it's own reason for creation. Some of the
		original arcade dats contained mistakes so I started fixing those
		whilst I was trying out the emulators (DatUtil was created to
		help me with this task). MAMEDiff was born after trying to use
		DatUtil to compare different versions of MAME (this showed
		something a bit more clever was required). Other tools were
		created as and when I had a need for them. :)<br/>
		<br/>
		Q: In the 2000 we have seen the birth of CAESAR, how long it took
		since you had the first idea of the project? Which were the first
		steps of CAESAR?<br/>
		<br/>
		A: The idea of CAESAR was born in May 2000 when I decided I could
		use the arcade dats to create a web site listing the games
		supported by each emulator. That would have taken just a few days
		to do but then I decided to include every arcade emulator I could
		find (thinking there were no more than 50, not hundreds as I was
		to find out!). Creating the dats for all of those was quite a
		task but whilst creating them I also created ROMBuild. CAESAR
		just grew and grew as I added information about all the emus,
		authors, development tools, commercial/non-PC emus, snapshots
		etc. What I first envisaged would be a 5 day quick hack ended up
		as a six month development!<br/>
		<br/>
		Q: I know this is explained in CAESAR, but in your own words,
		tell us about the future of CAESAR. Maybe you want to ask for
		more volunteers to help...<br/>
		<br/>
		A: The most important thing is to keep it up to date and I also
		want to get the snapshots completed. Keeping CAESAR up to date is
		quite easy for me but I don't really have time to snapshot all
		the games (and do new snapshots for MAME especially). If any
		dedicated individuals would like to help out in that respect then
		they should contact me. In terms of extending CAESAR there are
		tons of possibilities from marques/cabinet packs to game
		histories etc. but I need to relax for a little while!<br/>
		<br/>
		Q: After CAESAR, a little bird told me you got into the RAINE
		team. A little bird also told me that the RAINE project is
		suffering quite a big revolution, can you explain us briefly
		what's going on? What can we expect?<br/>
		<br/>
		A: RAINE is now an open source project hosted at SourceForge
		(http://www.sourceforge.net) so I have made a few contributions
		like fixing ROM sets and some other tidying up. The most active
		developer nowadays is Emmanuel (who does the Linux version) but
		there are quite a few people like myself who make their own
		little contributions.<br/>
		<br/>
		Q: RAINE is a pretty big project, and CAESAR is also very big to
		maintain, besides your web site. So do you have other projects
		for the future or will we see a relaxed Logiqx this year?<br/>
		<br/>
		A: Almost certainly, I have many things I want to do but whether
		I'll get time is another matter!<br/>
		<br/>
		Q: Will we ever see your own emulator, besides the RAINE project?
		:)<br/>
		<br/>
		A: Who knows, it depends on whether there's one I want to write!
		I think it is more likely that I'd add drivers to RAINE or MAME
		tough, rather than write a completely new emulator. Again, it
		comes down to limited spare time.<br/>
		<br/>
		Q: Now we will talk a bit of the emulation scene. You're indeed a
		big expert since you made CAESAR! Which are the names who impress
		you in the emulation scene, past and present? Logiqx is not a
		valid answer!<br/>
		<br/>
		A: Unfortunately I didn't witness the early years of arcade
		emulation but all the past contributors deserve a huge amount of
		recognition for the groundwork they did. Of those still remaining
		I would pick out Nicola Salmoria (for creating MAME in the first
		place), Richard Bush (for creating RAINE almost on his own), Dave
		(for figuring out Afterburner and his rapid development speed)
		plus the other people who take emulation further like Phil
		Stroffolino, Ernesto Corvi, Aaron Giles etc. Hmmm, there are so
		many others I have respect for that it seems unfair to list just
		a few!<br/>
		<br/>
		Q: Making all those things with the emulators and games for
		CAESAR must have given you a wider point of view. Which are your
		favorite emulators and games currently?<br/>
		<br/>
		A: On a decent PC then MAME normally has the most accurate
		emulation but on a lower spec machine Callus, System 16, NeoRAGEx
		etc are better for playing games. I also like emulators that play
		games not yet in MAME (like Final Burn) and there are also a few
		little known emulators I really like such as Final Pengo by
		Sergio Mu&ntilde;oz.<br/>
		<br/>
		Q: Recently CPS-2 has been emulated, even when not decrypted yet.
		Nintendo VS went into MAME already. But there are so many things
		to do yet, which are the games/systems you want to see emulated
		now?<br/>
		<br/>
		A: The System 32 and Sega Model 1/2 emulators are of great
		interest to me as I remember being totally awestruck by Virtua
		Fighter when it was released. I hope that Modeller/Virtua will
		eventually run these games properly.<br/>
		<br/>
		Q: In the last months, with the emulation of newer games, we've
		started to see a split between classic gamers and modern gamers,
		which is your opinion about all this? Pacman or Mortal Kombat 3?
		Maybe both?<br/>
		<br/>
		A: I like emulators because I can replay the games that I enjoyed
		playing in the past. Ideally all games should be emulated
		eventually but I think it is best if there is a lag of a few
		years before games are emulated. Sometimes this is enforced
		through technical difficulties and sometimes through policies of
		emulator authors. Here's a thought - if your favorite arcade game
		was emulated the same week it appeared in the arcade and you only
		played it at home on your PC, would you have missed out? Would
		you have felt the excitement of the arcade atmosphere?<br/>
		<br/>
		Q: After these years with all the sues and threats from Sega and
		Nintendo, and the apparent stop of fights and flames between some
		members of the community, 2001 seems to be a calm year. Which is
		your opinion about this year for the emulation scene?<br/>
		<br/>
		A: Lets hope that progress continues to be made with the
		emulation of old games, both in emulating more of them and
		improving the current emulation. Maybe we'll see Capcom endorse
		emulation of their old CPS-2 games like they did for CPS-1?<br/>
		<br/>
		Q: Well, the interview is almost done, will you ever post your
		own interview in CAESAR? :)<br/>
		<br/>
		A: I'll add it to the 'about' page.<br/>
		<br/>
		Q: Thank you very much for your time, we hope that this new
		millenium is great for Logiqx inside and outside emulation.<br/>
		<br/>
		A: Cheers. I hope you all have a good one too.<br/>
		<br/>
		<br/></p>

		<?php
			// Standard page footer (counter)

			include('../resources/bottom.php');
		?>
	</body>
</html>

