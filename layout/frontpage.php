<?php

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-pre-only';
    }else{
        $bodyclasses[] = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $bodyclasses[] = 'side-post-only';
    }else{
        $bodyclasses[] = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

$hasfootnote = (!empty($PAGE->theme->settings->footnote));

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
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
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

    <div id="menubar">
    	<div id="menushell">
    	<div id="logo"></div>
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

<!-- START OF HEADER -->
   
    <div id="page-header" class="clearfix">
		<div id="page-header-wrapper">
        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
        <div class="headermenu"><?php
            echo $OUTPUT->lang_menu();
            echo $PAGE->headingmenu;
        ?></div>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
         <?php } ?>
		</div>
    </div>
    
    
  	  
<!-- END OF HEADER -->

<!-- START OF CONTENT -->

<div id="page-content-wrapper">
    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                            <?php echo $OUTPUT->main_content() ?>
                        </div>
                    </div>
                </div>

                <?php if ($hassidepre OR (right_to_left() AND $hassidepost)) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                            <?php
                        if (!right_to_left()) {
                            echo $OUTPUT->blocks_for_region('side-pre');
                        } elseif ($hassidepost) {
                            echo $OUTPUT->blocks_for_region('side-post');
                    } ?>

                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                           <?php
                       if (!right_to_left()) {
                           echo $OUTPUT->blocks_for_region('side-post');
                       } elseif ($hassidepre) {
                           echo $OUTPUT->blocks_for_region('side-pre');
                    } ?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<!-- END OF CONTENT -->

<!-- START OF FOOTER -->

    <div id="page-footer">
		<?php if ($hasfootnote) { ?>
			<div id="footnote"><?php echo $PAGE->theme->settings->footnote;?></div>
        <?php } ?>
        <p class="helplink">
        <?php echo page_doc_link(get_string('moodledocslink')) ?>
        </p>

        <?php
        echo $OUTPUT->home_link();
        echo $OUTPUT->standard_footer_html();
        ?>
    </div>

<!-- END OF FOOTER -->
    <div class="clearfix"></div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>