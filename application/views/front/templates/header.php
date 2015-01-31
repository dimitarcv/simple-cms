<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php echo html_escape($page_title); ?> - Custom CMS</title>
  <meta name="description" content="<?php echo html_escape($page_description); ?>">
  <meta name="keywords" content="<?php echo html_escape($page_keywords) ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/styles.css">
</head>
<body>

<div id="page-content">
  <header id="header">
    <nav>
      <ul class="clearfix">
        <?php foreach ($pages as $index => $page) { ?>
          <li>
            <?php if($index === 0) { ?>
              <a href="<?php echo base_url(); ?>">
            <?php } else { ?>
              <a href="<?php echo base_url().$page['page_name']; ?>">
            <?php } ?>
              <?php echo html_escape($page['page_title']); ?>
            </a>
          </li>
        <?php } ?>
        <li><a href="<?php echo base_url(); ?>admin">Admin panel</a></li>
      </ul>
    </nav>
  </header><!--#header-->