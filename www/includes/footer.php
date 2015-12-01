<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;

?>

    <div id="footer">
      <?php /*echo date("F j, Y, g:i a"); ?> | &copy; <?php echo date("Y"); echo SITE_NAME;*/ ?>
    </div>
  </body>
</html>

<?php

// Close database connection
$dbh = null;
