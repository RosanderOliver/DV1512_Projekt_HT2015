<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

?>
      </div>
    <footer class="navbar navbar-fixed-bottom footer">
      <div class="container">
        <p class="text-muted"><?php echo date("F j, Y, g:i a"); ?> | &copy; <?php echo date("Y "); echo SITE_NAME; ?></p>
      </div>
    </footer>
  </body>
</html>

<?php

// Close database connection
$dbh = null;
