<?php
global $hesk_settings, $hesklang;
/**
 * @var string $trackingId
 * @var string $email
 * @var boolean $rememberEmail
 * @var boolean $displayForgotTrackingIdForm
 * @var boolean $submittedForgotTrackingIdForm
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');

require_once HESK_PATH . 'inc/common.inc.php';

if (is_file(HESK_PATH . 'inc/customer_ticket_common.inc.php')) {
    require_once HESK_PATH . 'inc/customer_ticket_common.inc.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <?= ltrim(str_replace(constant('HESK_BASE_PATH'), '', __FILE__), '/\\') ?> -->
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
    <!-- form.php -->
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/ie9.css" />
    <![endif]-->
    <?php hesk_require('head.php', true); ?>
    <?php require_once TEMPLATE_PATH . 'customer/inc/customer-login-check.inc.php' ?>
    <style>
        #forgot-tid-submit {
            width: 200px;
        }
    </style>
    <link rel="stylesheet" href="<?= hesk_template_url('customer/css/jquery.modal.css') ?>" />
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
                    <div class="last"><?php echo $hesklang['view_ticket']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div style="margin-bottom: 20px;">
                    <?php
                    if (!$submittedForgotTrackingIdForm) {
                        hesk3_show_messages($messages);
                    }
                    ?>
                </div>
                <h3 class="article__heading article__heading--form">
                    <div class="icon-in-circle">
                        <svg class="icon icon-document">
                            <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-document"></use>
                        </svg>
                    </div>
                    <span class="ml-1"><?php echo $hesklang['view_existing']; ?></span>
                </h3>
                <form action="ticket.php" method="get" name="form2" id="formNeedValidation" class="form form-submit-ticket ticket-create" novalidate>
                    <section class="form-groups centered">
                        <div class="form-group required">
                            <label class="label"><?php echo $hesklang['ticket_trackID']; ?></label>
                            <input type="text" name="track" maxlength="20" class="form-control" value="<?php echo $trackingId; ?>" required>
                            <div class="form-control__error"><?php echo $hesklang['this_field_is_required']; ?></div>
                        </div>
                        <?php
                        $tmp = '';
                        if ($hesk_settings['email_view_ticket'])
                        {
                            $tmp = 'document.form1.email.value=document.form2.e.value;';
                            ?>
                            <div class="form-group required display-none">
                                <label class="label"><?php echo $hesklang['email']; ?></label>
                                <input type="email" class="form-control" name="e" size="35" value="<?php echo $email; ?>" required>
                                <div class="form-control__error"><?php echo $hesklang['this_field_is_required']; ?></div>
                            </div>
                            <div class="form-group display-none">
                                <div class="checkbox-custom">
                                    <input type="hidden" name="f" value="1">
                                    <input type="checkbox" name="r" value="Y" id="inputRememberMyEmail" <?php if ($rememberEmail) { ?>checked<?php } ?>>
                                    <label for="inputRememberMyEmail"><?php echo $hesklang['rem_email']; ?></label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </section>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-full" ripple="ripple"><?php echo $hesklang['view_ticket']; ?></button>
                        <a href="ticket.php?forgot=1#modal-contents" data-modal="#forgot-modal" class="link"><?php echo $hesklang['forgot_tid']; ?></a>
                    </div>
                </form>

                <!-- BEGIN Lista de chamados -->
                <style>
                    [data-id="extra-content"] {width: 100% !important;}
                    .main__content.tools > section,
                    .main__content.tools > div
                    {
                        width: 100% !important;
                        /* border: 1px black solid; */
                    }
                    [data-template-id] { /* display: none !important; */ }
                </style>
                <div x-data="ticket_list_table">
                    <div class="main__content tools">
                        <section class="tools__between-head">
                            <a
                                href="index.php?a=add"
                                class="btn btn--blue-border"
                                ripple="ripple"
                                data-action="create-custom-status"
                            >Novo chamado</a>
                            <div
                                x-data="{
                                    open: false,
                                }"
                                x-on:click.outside.stop="open = false"
                            >
                                <button
                                    type="button"
                                    x-on:click="open = !open"
                                    x-text="CUSTOMER_DATA?.name"
                                ></button>
                                <div
                                    class="customer-info"
                                    x-bind:class="{
                                        show: open,
                                    }"
                                >
                                    <ul>
                                        <li x-text="CUSTOMER_DATA?.name"></li>
                                            <?= blade_view('modules.modal', [
                                                'body' => blade_view('login.update-password-form', []),
                                                'uid' => 'update-password-form',
                                                'title' => 'Alterar senha',
                                                'wraperTag' => 'li',
                                                'triggerLabel' => 'Alterar senha',
                                                'triggerTag' => 'div',
                                                'triggerClass' => 'update-password-form',
                                            ]) ?>
                                        <li x-on:click="logout">Sair</li>
                                    </ul>
                                </div>
                        </section>

                        <div class="table-wrapper status">
                            <div class="table">
                                <table id="default-table" class="table sindu-table">
                                    <thead>
                                        <tr>
                                        <th>id</th>
                                        <th>trackid</th>
                                        <th>subject</th>
                                        <th>dt</th>
                                        <th>lastchange</th>
                                        <th>status</th>
                                        <th>-</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <template
                                            x-if="showThis(tickets)"
                                            aaax-if="(tickets && tickets?.length)"
                                        >
                                            <template x-for="ticket in tickets">
                                                <tr>
                                                    <td x-text="ticket.id"></td>
                                                    <td x-text="ticket.trackid"></td>
                                                    <td x-text="ticket.subject"></td>
                                                    <td x-text="ticket.dt"></td>
                                                    <td x-text="ticket.lastchange"></td>
                                                    <td>
                                                        <div
                                                            style="display: flex;gap: 0.5rem;justify-content: center;align-content: center;"
                                                        >
                                                            <h1 x-text="ticket.status"></h1>
                                                            <div class="tooltype right out-close">
                                                                <svg class="icon icon-info">
                                                                    <use xlink:href="../img/sprite.svg#icon-info"></use>
                                                                </svg>
                                                                <div class="tooltype__content">
                                                                    <div class="tooltype__wrapper">Status</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nowrap buttons">
                                                        <button
                                                            type="button"
                                                            class="cursor-pointer"
                                                            x-on:click="showTicketDetail(ticket)"
                                                        >Ver ticket</button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                        <template x-else>
                                            <tr class="title text-center">
                                                <td colspan="5">Sem registros</td>
                                            </tr>
                                        </template>

                                        <template
                                            x-if="showThis(links)"
                                            aaax-if="(links && links?.length)"
                                        >
                                            <tr>
                                                <td colspan="100%">
                                                    <div
                                                        class="nav pagination-container"
                                                        x-html="paginationContent"
                                                    ></div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('ticket_list_table', () => ({
                            responseData: {},
                            async init() {
                                await this.fetchTickets();

                                if (globalThis?.Customer_API) {
                                    await globalThis?.Customer_API.validateToken();
                                }
                            },
                            showThis(value, type = 'object') {
                                if (!type || typeof value !== type) {
                                    return false;
                                }

                                return true;
                            },
                            setResponseData(responseData) {
                                try {
                                    if (!responseData) {
                                        return;
                                    }

                                    if (typeof responseData !== 'object') {
                                        return;
                                    }

                                    if (Array.isArray(responseData)) {
                                        return;
                                    }

                                    this.responseData = JSON.parse(JSON.stringify(responseData || {}));
                                } catch (error) {
                                    console.error('setResponseData error:', error, responseData);
                                }
                            },
                            get response() {
                                return this.responseData || {};
                            },
                            get tickets() {
                                let data = this.response?.data || [];
                                return data && Array.isArray(data) ? data : [];
                            },
                            get links() {
                                let links = this.response?.links || [];
                                return links && Array.isArray(links) ? links : [];
                            },
                            get paginationContent() {
                                let links = this.links || [];
                                links = links && Array.isArray(links) ? links : [];
                                let buttons = [];

                                for (let link of links) {
                                    let button = document.createElement('button');
                                    button.setAttribute('type', 'button');
                                    button.disabled = !link?.url ? true : false;
                                    button.innerHTML = link?.label || '';
                                    button.setAttribute('x-on:click.prevent', `fetchFromLink('${link?.url}')`);

                                    button.classList.add(
                                        ...([
                                            'pagination-item',
                                            link?.active ? 'active' : null,
                                            !link?.url ? 'disabled inactive' : null,
                                        ].join(' ').split(' ').filter(item => item)),
                                    );

                                    buttons.push(button.outerHTML);
                                }

                                return buttons.join('');
                            },
                            validString(value, defaultValue = null) {
                                value = value && typeof value === 'string' && value.trim() ? value.trim() : null;

                                return value ?? (typeof defaultValue === 'string' || defaultValue === null)
                                    ? defaultValue : null;
                            },
                            get BASE_API() {
                                return globalThis.CUSTOMER_API_BASE_URL || "<?= hesk_settings_get('customer_api_base_url') ?>";
                            },
                            get API_TOKEN() {
                                return globalThis.Customer_API.API_TOKEN || {};
                            },
                            get CUSTOMER_DATA() {
                                return globalThis.Customer_API.CUSTOMER_DATA || {};
                            },
                            getCustomer(key, defaultValue) {
                                let customer_data = this.CUSTOMER_DATA || {};

                                key = this.validString(key);

                                if (!key) {
                                    return defaultValue;
                                }

                                if (key in customer_data) {
                                    return customer_data[key];
                                }

                                return defaultValue;
                            },
                            getHeskURL(uri) {
                                let str_trim_slashes = globalThis?.Helpers?.str_trim_slashes || ((string) => string.trim().replaceAll(/^\/|\/$/ig, ''));
                                let url = new URL(globalThis.HESK_BASE_URL || location.origin);
                                uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';

                                return [
                                    url.href,
                                    (uri ? `${uri}` : ''),
                                ]
                                .map(item => str_trim_slashes(item))
                                .filter(item => item)
                                .join('/');
                            },
                            invalidateToken(message = null) {
                                return globalThis.Customer_API.invalidateToken();
                            },
                            async logout() {
                                return await globalThis.Customer_API.logout();
                            },
                            getUrl(uri = '') {
                                let str_trim_slashes = globalThis?.Helpers?.str_trim_slashes || ((string) => string.trim().replaceAll(/^\/|\/$/ig, ''));
                                let url = new URL(this.BASE_API);
                                uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';

                                return [
                                    url.href,
                                    (uri ? `${uri}` : ''),
                                ]
                                .map(item => str_trim_slashes(item))
                                .filter(item => item)
                                .join('/');
                            },
                            showTicketDetail(ticket) {
                                if (!ticket || typeof ticket !== 'object' || Array.isArray(ticket)) {
                                    return;
                                }

                                let ticketIdInput = document.querySelector('form input[name="track"]');
                                let ticketEmailInput = document.querySelector('form input[type="email"][name="e"]');

                                if (!ticketIdInput || !ticketEmailInput) {
                                    return;
                                }

                                let ticketId = ticket?.trackid || null;
                                let ticketEmail = ticket?.email || null;

                                if (!ticketId || !ticketEmail) {
                                    return;
                                }

                                ticketIdInput.value = ticketId || '';
                                ticketEmailInput.value = ticketEmail || '';

                                document.querySelector('form[action="ticket.php"]')?.submit();
                            },
                            async fetchFromLink(link) {
                                link = link ? globalThis.Helpers['generateUrl'](link) : null;

                                if (!link || typeof link !== 'object' || Array.isArray(link)) {
                                    return;
                                }

                                let {href} = (link || {});

                                if (!href) {
                                    return;
                                }

                                await this.fetchTickets(href);
                            },
                            async fetchTickets(url = null) {
                                url = url || this.getUrl('/tickets');
                                console.log('fetchTickets URL:', url);
                                console.log('fetchTickets this.BASE_API:', this.BASE_API);

                                let headers = {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${this.API_TOKEN}`,
                                };

                                let options = {
                                    method: 'POST',
                                    headers,
                                }

                                try {
                                    let response = await fetch(url, options);

                                    if (!response.ok) {
                                        this.setResponseData({});
                                        return;
                                    }

                                    if (!response?.ok && response?.status === 401) {
                                        this.invalidateToken('Não autenticado');
                                        this.setResponseData({});
                                        return;
                                    }

                                    let data = await response.json();

                                    this.setResponseData(data);
                                    return data;
                                } catch(error) {
                                    console.error('fetchTickets', error);
                                    this.setResponseData({});
                                }
                            },
                        }))
                    })
                </script>

                <div>
                    <?php
                    // view_render('modules.modal', [
                    //     'title' => 'Login',
                    //     'body' => blade_view('login.form', []),
                    // ]);
                    ?>
                </div>

                <div data-id="extra-content"></div>
                <!-- END Lista de chamados -->

                <!-- Start ticket reminder form -->
                <div id="forgot-modal" class="<?php echo !$displayForgotTrackingIdForm ? 'modal' : ''; ?>">
                    <div id="modal-contents" class="<?php echo !$displayForgotTrackingIdForm ? '' : 'notification orange'; ?>" style="padding-bottom:15px">
                        <?php
                        if ($submittedForgotTrackingIdForm) {
                            hesk3_show_messages($messages);
                        }
                        ?>
                        <b><?php echo $hesklang['forgot_tid']; ?></b><br><br>
                        <?php echo $hesklang['tid_mail']; ?>
                        <form action="index.php" method="post" name="form1" id="form1" class="form">
                            <div class="form-group">
                                <label class="label" style="display: none"><?php echo $hesklang['email']; ?></label>
                                <input id="forgot-email" type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <div class="radio-custom">
                                    <input type="radio" name="open_only" id="open_only1" value="1" <?php echo $hesk_settings['open_only'] ? 'checked' : ''; ?>>
                                    <label for="open_only1">
                                        <?php echo $hesklang['oon1']; ?>
                                    </label>
                                </div>
                                <div class="radio-custom">
                                    <input type="radio" name="open_only" id="open_only0" value="0" <?php echo !$hesk_settings['open_only'] ? 'checked' : ''; ?>>
                                    <label for="open_only0">
                                        <?php echo $hesklang['oon2']; ?>
                                    </label>
                                </div>
                            </div>

                            <?php
                            // Use Invisible reCAPTCHA?
                            if ($hesk_settings['secimg_use'] && $hesk_settings['recaptcha_use'] == 1) {
                                define('RECAPTCHA',1);
                                ?>
                                <div class="g-recaptcha" data-sitekey="<?php echo $hesk_settings['recaptcha_public_key']; ?>" data-bind="forgot-tid-submit" data-callback="recaptcha_submitForm"></div>
                            <?php
                            } elseif ($hesk_settings['secimg_use']) {
                            ?>
                            <div class="captcha-remind">
                                <div class="form-group">
                                    <?php
                                    // Use reCAPTCHA V2?
                                    if ($hesk_settings['recaptcha_use'] == 2) {
                                        define('RECAPTCHA',1);
                                        ?>
                                        <div class="g-recaptcha" data-sitekey="<?php echo $hesk_settings['recaptcha_public_key']; ?>"></div>
                                    <?php } else { ?>
                                        <img name="secimg" src="print_sec_img.php?<?php echo rand(10000,99999); ?>" width="150" height="40" alt="<?php echo $hesklang['sec_img']; ?>" title="<?php echo $hesklang['sec_img']; ?>" style="vertical-align:text-bottom">
                                        <a class="btn btn-refresh" href="javascript:void(0)" onclick="javascript:document.form1.secimg.src='print_sec_img.php?'+ ( Math.floor((90000)*Math.random()) + 10000);">
                                            <svg class="icon icon-refresh">
                                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-refresh"></use>
                                            </svg>
                                        </a>
                                        <label class="required"><?php echo $hesklang['sec_enter']; ?></label>
                                        <input type="text" name="mysecnum" size="20" maxlength="5" autocomplete="off" class="form-control">
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <input type="hidden" name="a" value="forgot_tid">
                            <input type="hidden" id="js" name="forgot" value="<?php echo (hesk_GET('forgot') ? '1' : '0'); ?>">
                            <button id="forgot-tid-submit" type="submit" class="btn btn-full"><?php echo $hesklang['tid_send']; ?></button>
                        </form>
                    </div>
                </div>
                <!-- End ticket reminder form -->
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
<script src="<?= hesk_template_url() ?>/customer/js/jquery.modal.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select_category').selectize();
        $('a[data-modal]').on('click', function() {
            $($(this).data('modal')).modal();
            return false;
        });
        <?php if ($submittedForgotTrackingIdForm) { ?>
            $('#forgot-modal').modal();
            $('#forgot-email').select();
        <?php } ?>
    });
</script>
<script src="<?= hesk_template_url() ?>/customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<?php if (defined('RECAPTCHA')) : ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $hesklang['RECAPTCHA']; ?>" async defer></script>
<script>
    function recaptcha_submitForm() {
        document.getElementById("form1").submit();
    }
</script>
<?php endif; ?>
</body>
</html>
