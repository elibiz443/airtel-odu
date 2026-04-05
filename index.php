<?php
  declare(strict_types=1);

  require_once __DIR__ . '/connector.php';
  require_once __DIR__ . '/admin/controllers/home/index.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Airtel ODU Shop • SmartConnect 5G & FTTx</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="min-h-screen bg-gradient-to-b from-[#FFF5F7] via-white to-white text-slate-800 antialiased max-w-full overflow-x-hidden">
  <?php include './includes/header.php'; ?>

  <main class="min-h-screen">
    <?php include './includes/hero.php'; ?>
    <?php include './includes/packages.php'; ?>
    <?php include './includes/steps.php'; ?>
    <?php include './includes/support.php'; ?>
  </main>

  <?php include './includes/footer.php'; ?>

  <script>
    const subareasData = <?php echo json_encode($subareas, JSON_UNESCAPED_UNICODE); ?>;
  </script>

  <script src="<?php echo ROOT_URL; ?>/assets/js/header.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/modal.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/area.js"></script>
</body>
</html>
