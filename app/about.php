<?php
require_once "_config.php";
require "header.php";
?>
<div class="row">
	<div class="span12">
		<h2>Learn more about the Time Machine</h2>
		<hr>
	<div class="row">	
		<div id="aboutPage" class="span12">
			<p><span style="text-decoration: underline">The Time Machine Historical Simulator</span> is a free online affinity space where learners, ages 7-18 can collaborate to create by a child working solo, by an informal group formed online, or by whole classrooms.</p>
			<p><span style="text-decoration: underline">Students</span> are encouraged to keep their own copies of their writing, research and image collections, to form a personal portfolio.</p>
			<p><span style="text-decoration: underline">Parents and teachers</span> are encouraged to give as specific prompts as they feel are helpful, from open-ended choice to challenges for learners.</p>
			<p><span style="text-decoration: underline">Safety:</span> There is no direct communication between users, each user has her own anonymous screen name, and all material published is curated by an adult guide and Galaxy Learn.</p>
			<p>Skills practiced and mastered in the Time Machine include:</p>
			<ul>
				<li>research and scholarship</li>
				<li>writing and editing</li>
				<li>image search and editing</li>
				<li>storytelling, narrative design</li> 
				<li>art production and design</li>
				<li>guiding peers, leadership, tutoring</li>
				<li>product creation and management</li>
				<li>storyboarding</li>
				<li>multimedia presentations</li>
				<li>game design</li>
			</ul>
		</div>
	</div>
	<div id="contactButton" >
		<p><b>Teachers, schools, other institutional users:</b> Please contact Galaxy Learn for special pricing and custom-configured systems and analytics.</p>
		<a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="btn btn-large btn-primary">Contact Us</a>
	</div>
	<p>Please be sure to review our <a href="tos.php">terms of use</a>.</p>
	</div>
</div>
<?php
require "footer.php";
