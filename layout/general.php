<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$hasfootnote = (!empty($PAGE->theme->settings->footnote));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    } else {
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    } else {
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
<script type="text/javascript">
	YUI().use('node', function(Y) {
		window.thisisy = Y;
	Y.one(window).on('scroll', function(e) {
		var node = Y.one('#back-to-top');

		if (Y.one('window').get('docScrollY') > Y.one('#page-content-wrapper').getY()) {
			node.setStyle('display', 'block');
		} else {
			node.setStyle('display', 'none');
		}

		});
	});
</script>
</head>

<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

    <div id="menubar">
    	<div id="menushell">
    	<a href="<?php echo $CFG->wwwroot; ?>"><div id="logo"></div></a>
    	<?php
    	if($this->page->pagelayout != 'maintenance') {
    	$topsettings = $this->page->get_renderer('theme_moodlebook','topsettings');
    	echo $topsettings->navigation_tree($this->page->navigation);
    	?>
    	<div id="menucenter">
        <?php
            echo $topsettings->settings_tree($this->page->settingsnav);
        ?>
    	</div>
    	<?php } ?>
		
		<div id="profiletop">
			<?php

			if (!isloggedin() or isguestuser()) {
				} else {
					echo '<a href="'.$CFG->wwwroot.'/user/view.php?id='.$USER->id.'&amp;course='.$COURSE->id.'"><img src="'.$CFG->wwwroot.'/user/pix.php?file=/'.$USER->id.'/f1.jpg" id="profilepic" title="'.$USER->firstname.' '.$USER->lastname.'" alt="'.$USER->firstname.' '.$USER->lastname.'" /></a>';
			} 
			echo $OUTPUT->login_info();
		?>
		</div>
    	</div>
		
    </div>

<div id="page">

<?php if ($hasheading || $hasnavbar) { ?>

    <div id="page-header" class="clearfix">
		<div id="page-header-wrapper">
		
 	
	        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
    	    <div class="headermenu">
        		<?php
    	        	echo $OUTPUT->lang_menu();
	        	    echo $PAGE->headingmenu;
		        ?>	    
	    	</div>
	    	<?php if ($hascustommenu) { ?>
      <div id="custommenu"><?php echo $custommenu; ?></div>
 	<?php } ?>
	    </div>
    </div>
    
    <?php if ($hasnavbar) { ?>
	    <div class="navbar clearfix">
    	    <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
            <div class="navbutton"> <?php echo $PAGE->button; ?></div>
        </div>
    <?php } ?>

<?php } ?>
<!-- END OF HEADER -->
<div id="page-content-wrapper">
    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">
            
                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                       		<?php echo $coursecontentheader; ?>
                       		<?php echo $OUTPUT->main_content() ?>
                       		<?php echo $coursecontentfooter; ?>
                   		</div>
                    </div>
                </div>
                
                <?php if ($hassidepre) { ?>
                <div id="region-pre">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>
                
                <?php if ($hassidepost) { ?>
                <div id="region-post">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </div>
</div>

<!-- START OF FOOTER -->
    <?php if ($hasfooter) { ?>
    <div id="page-footer" class="clearfix">
		<?php if ($hasfootnote) { ?>
			<div id="footnote"><?php echo $PAGE->theme->settings->footnote;?></div>
        <?php } ?>
        <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
        <?php
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>
    <?php } ?>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<div id="back-to-top">
	<a class="arrow" href="#">▲</a>
	<a class="text" href="#">Back to Top</a>
</div>
</body>
</html>