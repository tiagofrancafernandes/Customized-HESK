<?php
global $hesk_settings, $hesklang;

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

/**
 * @var array $top_articles
 * @var array $latest_articles
 * @var array $service_messages
 */

$service_message_type_to_class = array(
    '0' => 'none',
    '1' => 'success',
    '2' => '', // Info has no CSS class
    '3' => 'warning',
    '4' => 'danger'
);

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
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
    <?php require_once HESK_PATH . 'inc/custom_header.inc.php'; ?>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <!-- index.php -->
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/ie9.css" />
    <![endif]-->
    <style>
        <?php outputSearchStyling(); ?>
    </style>
    <?php require_once HESK_PATH . 'inc/custom_header.inc.php'; ?>
    <?= customer_login_check() ?>
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
                    <div class="last"><?php echo $hesk_settings['hesk_title']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div class="help-search">
                    <h2 class="search__title"><?php echo $hesklang['how_can_we_help']; ?></h2>
                    <?php displayKbSearch(); ?>
                </div>
                <?php hesk3_show_messages($service_messages); ?>
                <div class="nav">
                    <a href="index.php?a=add" class="navlink">
                        <div class="icon-in-circle">
                            <svg class="icon icon-submit-ticket">
                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-submit-ticket"></use>
                            </svg>
                        </div>
                        <div>
                            <h5 class="navlink__title"><?php echo $hesklang['submit_ticket']; ?></h5>
                            <div class="navlink__descr"><?php echo $hesklang['open_ticket']; ?></div>
                        </div>
                    </a>
                    <a href="ticket.php" class="navlink">
                        <div class="icon-in-circle">
                            <svg class="icon icon-document">
                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-document"></use>
                            </svg>
                        </div>
                        <div>
                            <h5 class="navlink__title"><?php echo $hesklang['view_existing_tickets']; ?></h5>
                            <div class="navlink__descr"><?php echo $hesklang['vet']; ?></div>
                        </div>
                    </a>
                </div>
                <?php if ($hesk_settings['kb_enable']): ?>
                <article class="article">
                    <h3 class="article__heading">
                        <a href="knowledgebase.php">
                            <div class="icon-in-circle">
                                <svg class="icon icon-knowledge">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                </svg>
                            </div>
                            <span><?php echo $hesklang['kb_text']; ?></span>
                        </a>
                    </h3>
                    <div class="tabbed__head">
                        <ul class="tabbed__head_tabs">
                            <?php
                            if (count($top_articles) > 0):
                            ?>
                            <li class="current" data-link="tab1">
                                <span><?php echo $hesklang['popart']; ?></span>
                            </li>
                            <?php
                            endif;
                            if (count($latest_articles) > 0):
                            ?>
                            <li data-link="tab2">
                                <span><?php echo $hesklang['latart']; ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="tabbed__tabs">
                        <?php if (count($top_articles) > 0): ?>
                        <div class="tabbed__tabs_tab is-visible" data-tab="tab1">
                            <?php foreach ($top_articles as $article): ?>
                            <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                <div class="icon-in-circle">
                                    <svg class="icon icon-knowledge">
                                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                    </svg>
                                </div>
                                <div class="preview__text">
                                    <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                    <p>
                                        <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                        <span class="ml-1"><?php echo $article['category']; ?></span>
                                    </p>
                                    <p class="navlink__descr">
                                        <?php echo $article['content_preview']; ?>
                                    </p>
                                </div>
                                <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                    <div class="rate">
                                        <?php if ($hesk_settings['kb_views']): ?>
                                            <div style="margin-right: 10px; display: -ms-flexbox; display: flex;">
                                                <svg class="icon icon-eye-close">
                                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-eye-close"></use>
                                                </svg>
                                                <span class="lightgrey"><?php echo $article['views_formatted']; ?></span>
                                            </div>
                                        <?php
                                        endif;
                                        if ($hesk_settings['kb_rating']): ?>
                                            <?php echo hesk3_get_customer_rating($article['rating']); ?>
                                            <?php if ($hesk_settings['kb_views']) echo '<span class="lightgrey">('.$article['votes_formatted'].')</span>'; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <!--[if IE]>
                                <p>&nbsp;</p>
                            <![endif]-->
                            <?php endforeach; ?>
                        </div>
                        <?php
                        endif;
                        if (count($latest_articles) > 0):
                        ?>
                        <div class="tabbed__tabs_tab <?php echo count($top_articles) === 0 ? 'is-visible' : ''; ?>" data-tab="tab2">
                            <?php foreach ($latest_articles as $article): ?>
                                <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                    <div class="icon-in-circle">
                                        <svg class="icon icon-knowledge">
                                            <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                        </svg>
                                    </div>
                                    <div class="preview__text">
                                        <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                        <p>
                                            <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                            <span class="ml-1"><?php echo $article['category']; ?></span>
                                        </p>
                                        <p class="navlink__descr">
                                            <?php echo $article['content_preview']; ?>
                                        </p>
                                    </div>
                                    <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                        <div class="rate">
                                            <?php if ($hesk_settings['kb_views']): ?>
                                                <div style="margin-right: 10px; display: -ms-flexbox; display: flex;">
                                                    <svg class="icon icon-eye-close">
                                                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-eye-close"></use>
                                                    </svg>
                                                    <span class="lightgrey"><?php echo $article['views_formatted']; ?></span>
                                                </div>
                                            <?php
                                            endif;
                                            if ($hesk_settings['kb_rating']): ?>
                                                <?php echo hesk3_get_customer_rating($article['rating']); ?>
                                                <?php if ($hesk_settings['kb_views']) echo '<span class="lightgrey">('.$article['votes_formatted'].')</span>'; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <!--[if IE]>
                                    <p>&nbsp;</p>
                                <![endif]-->
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="article__footer">
                        <a href="knowledgebase.php" class="btn btn--blue-border" ripple="ripple"><?php echo $hesklang['viewkb']; ?></a>
                    </div>
                </article>
                <?php
                endif;
                if ($hesk_settings['alink']):
                ?>
                <div class="article__footer">
                    <a href="<?php echo $hesk_settings['admin_dir']; ?>/" class="link"><?php echo $hesklang['ap']; ?></a>
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
<?php outputSearchJavascript(); ?>
<script src="<?= hesk_template_url() ?>/customer/js/svg4everybody.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/selectize.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
</body>

</html>
