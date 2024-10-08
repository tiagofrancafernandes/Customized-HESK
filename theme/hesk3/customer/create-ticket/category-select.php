<?php
global $hesk_settings, $hesklang;

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['hesk_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= hesk_url() . '/'; ?>img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= hesk_url() . '/'; ?>img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= hesk_url() . '/'; ?>img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?= hesk_url() . '/'; ?>img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?= hesk_url() . '/'; ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?= hesk_url('img/favicon/favicon.ico'); ?>" />
    <meta name="msapplication-TileColor" content="#2d89ef" />
    <meta name="msapplication-config" content="<?= hesk_url() . '/'; ?>img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/ie9.css" />
    <![endif]-->
    <?php require_once TEMPLATE_PATH . '../../inc/custom_header.inc.php'; ?>
</head>

<body class="cust-help">
<?php hesk_require('header.php'); ?>
<div class="wrapper">
    <main class="main">
        <header class="header">
            <div class="contr">
                <div class="header__inner">
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>" class="header__logo">
                        <?php echo $hesk_settings['hesk_title']; ?>
                        <img src="<?php echo $hesk_settings['hesk_url']; ?>/img/favicon/simbolo.svg" alt="logo_iperf" width="25px" height="25px" style="vertical-align: -3px;">
                    </a>
                    <?php if ($hesk_settings['can_sel_lang']): ?>
                        <div class="header__lang">
                            <form method="get" action="" style="margin:0;padding:0;border:0;white-space:nowrap;">
                                <div class="dropdown-select center out-close">
                                    <select name="language" onchange="this.form.submit()">
                                        <?php hesk_listLanguages(); ?>
                                    </select>
                                </div>
                                <?php foreach (hesk_getCurrentGetParameters() as $key => $value): ?>
                                    <input type="hidden" name="<?php echo hesk_htmlentities($key); ?>"
                                           value="<?php echo hesk_htmlentities($value); ?>">
                                <?php endforeach; ?>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div class="breadcrumbs">
            <div class="contr">
                <div class="breadcrumbs__inner">
                    <a href="<?php echo $hesk_settings['site_url']; ?>">
                        <span><?php echo $hesk_settings['site_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <div class="last"><?php echo $hesklang['submit_ticket']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div style="margin-bottom: 20px;">
                    <?php
                    hesk3_show_messages($messages);
                    ?>
                </div>
                <h2 class="select__title"><?php echo $hesklang['select_category_text']; ?></h2>
                <?php
                // Show dropdown or list, depending on number of categories
                if (($category_count = count($hesk_settings['categories'])) > $hesk_settings['cat_show_select']):
                ?>
                    <form action="index.php" method="get">
                        <div style="display: table; margin: 40px auto;">
                            <select class="form-control cat-select" name="category" id="select_category">
                                <?php
                                if ($hesk_settings['select_cat'])
                                {
                                    echo '<option value="">'.$hesklang['select'].'</option>';
                                }
                                foreach ($hesk_settings['categories'] as $k=>$v)
                                {
                                    echo '<option value="'.$k.'">'.$v.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-footer">
                            <button class="btn btn-full" type="submit"><?php echo $hesklang['c2c']; ?></button>
                            <input type="hidden" name="a" value="add">
                        </div>
                    </form>
                <?php else: ?>
                    <div class="nav">
                        <?php foreach ($hesk_settings['categories'] as $k => $v): ?>
                        <a href="index.php?a=add&amp;category=<?php echo $k; ?>" class="navlink <?php if ($category_count > 8) echo "navlink-condensed"; ?>">
                            <div class="icon-in-circle">
                                <svg class="icon icon-chevron-right">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                                </svg>
                            </div>
                            <div>
                                <h5 class="navlink__title"><!--[if IE]> &raquo; <![endif]--><?php echo $v; ?></h5>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php
require HESK_BASE_PATH . '/hidden-footer.php';
?>
    </main>
</div>
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
<script src="<?= hesk_template_url() ?>/customer/js/jquery-3.5.1.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<script src="<?= hesk_template_url() ?>/customer/js/svg4everybody.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select_category').selectize();
    });
</script>
<script src="<?= hesk_template_url() ?>/customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
</body>
</html>
