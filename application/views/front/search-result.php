<article>
  <?php foreach($search_results as $result) { ?>
    <div class="content-area">
      <h1><?php echo html_escape($result['page_title']); ?></h1>
      <div><?php echo word_limiter(strip_tags($result['contents']), 20); ?></div>
      <a href="<?php echo base_url().$result['page_name']; ?>">View page</a>
    </div>
  <?php } ?>
</article>